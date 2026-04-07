<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\PersonsModel;
use App\Models\LevelsModel;

class Admin extends BaseController
{

    public function index()
    {
        $levelsModel = new LevelsModel();
        $levels      = $levelsModel->findAll();
        $users       = $this->getUsersList();
        return view('admin/dashboard', $this->withAdminNotifications([
            'users'  => $users,
            'levels' => $levels,
        ]));
    }

    public function docente()
    {
        return view('docente/dashboard', [
            'teacherStudents' => $this->getTeacherStudents((int) session('user_id')),
            'teacherSummary'  => $this->getTeacherSummary((int) session('user_id')),
        ]);
    }

    public function alumno()
    {
        return view('alumno/dashboard');
    }

    public function dashboardForm()
    {
        session()->set('role', 'admin');
        echo "DashboardAdmin";
    }

    public function usersIndex()
    {
        $levelsModel = new LevelsModel();
        $levels      = $levelsModel->findAll();

        $users = $this->getUsersList();

        return view('admin/users_index', $this->withAdminNotifications([
            'users'  => $users,
            'levels' => $levels,
        ]));
    }

    public function usersCreate()
    {
        $rules = $this->getUserValidationRules(true);
        $messages = $this->getUserValidationMessages(true);

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $personsModel = new PersonsModel();
        $usersModel   = new UsersModel();
        $db           = \Config\Database::connect();

        $tbl_persons =
        [
            'pk_phone'   => $this->request->getPost('phone'),
            'person'     => strtoupper($this->request->getPost('name')),
            'first_name' => strtoupper($this->request->getPost('firstName')),
            'last_name'  => strtoupper($this->request->getPost('lastName')),
        ];

        $tbl_users =
        [
            'fk_phone' => $this->request->getPost('phone'),
            'fk_level' => (int) $this->request->getPost('level'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'locked'   => 0,
        ];

        $db->transBegin();

        if ($personsModel->insert($tbl_persons) === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', $personsModel->errors());
        }

        if ($usersModel->insert($tbl_users) === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', $usersModel->errors());
        }

        $db->transCommit();

        return redirect()->route('adminUsers')->with('success', 'Usuario creado');
    }

    public function usersRead()
    {
        return $this->response->setJSON($this->getUsersList());
    }

    public function apiUsersCreate()
    {
        $rules = $this->getUserValidationRules(true);
        $messages = $this->getUserValidationMessages(true);

        if (! $this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => implode(' ', $this->validator->getErrors()),
                'icon'    => 'error',
            ]);
        }

        $personsModel = new PersonsModel();
        $usersModel   = new UsersModel();
        $db           = \Config\Database::connect();

        $tbl_persons =
        [
            'pk_phone'   => $this->request->getPost('phone'),
            'person'     => strtoupper($this->request->getPost('name')),
            'first_name' => strtoupper($this->request->getPost('firstName')),
            'last_name'  => strtoupper($this->request->getPost('lastName')),
        ];

        $tbl_users =
        [
            'fk_phone' => $this->request->getPost('phone'),
            'fk_level' => (int) $this->request->getPost('level'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'locked'   => 0,
        ];

        $db->transBegin();

        if ($personsModel->insert($tbl_persons) === false) {
            $db->transRollback();
            return $this->response->setJSON([
                'status'  => 400,
                'message' => implode(' ', $personsModel->errors()),
                'icon'    => 'error',
            ]);
        }

        if ($usersModel->insert($tbl_users) === false) {
            $db->transRollback();
            return $this->response->setJSON([
                'status'  => 400,
                'message' => implode(' ', $usersModel->errors()),
                'icon'    => 'error',
            ]);
        }

        $db->transCommit();

        return $this->response->setJSON([
            'status'  => 200,
            'message' => 'Usuario creado correctamente',
            'icon'    => 'success',
        ]);
    }

    public function usersEdit($pk_user = null)
    {
        if ($pk_user === null) {
            return redirect()->route('adminUsers');
        }

        $levelsModel = new LevelsModel();
        $levels      = $levelsModel->findAll();

        $db = \Config\Database::connect();
        $user = $db->table('tbl_users u')
            ->select('u.pk_user, u.fk_phone, u.fk_level, u.locked, p.person, p.first_name, p.last_name, l.level')
            ->join('tbl_persons p', 'p.pk_phone = u.fk_phone', 'left')
            ->join('cat_levels l', 'l.pk_level = u.fk_level', 'left')
            ->where('u.pk_user', $pk_user)
            ->get()
            ->getRowArray();

        if (! $user) {
            return redirect()->route('adminUsers');
        }

        return view('admin/users_edit', [
            'user'   => $user,
            'levels' => $levels,
        ] + $this->getAdminNotificationData());
    }

    public function usersUpdate($pk_user = null)
    {
        if ($pk_user === null) {
            return redirect()->route('adminUsers');
        }

        $rules = $this->getUserValidationRules(false);
        $messages = $this->getUserValidationMessages(false);

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usersModel   = new UsersModel();
        $personsModel = new PersonsModel();
        $db           = \Config\Database::connect();

        $user = $usersModel->find($pk_user);
        if (! $user) {
            return redirect()->route('adminUsers');
        }

        $tbl_persons =
        [
            'person'     => strtoupper($this->request->getPost('name')),
            'first_name' => strtoupper($this->request->getPost('firstName')),
            'last_name'  => strtoupper($this->request->getPost('lastName')),
        ];

        $tbl_users =
        [
            'fk_level' => (int) $this->request->getPost('level'),
            'locked'   => (int) ($this->request->getPost('locked') ?? 0),
        ];

        $newPassword = $this->request->getPost('password');
        if ($newPassword !== null && $newPassword !== '') {
            $tbl_users['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $db->transBegin();

        if ($personsModel->update($user['fk_phone'], $tbl_persons) === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', $personsModel->errors());
        }

        if ($usersModel->update($pk_user, $tbl_users) === false) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('errors', $usersModel->errors());
        }

        $db->transCommit();

        return redirect()->route('adminUsers')->with('success', 'Usuario actualizado');
    }

    public function usersDelete($pk_user = null)
    {
        if ($pk_user === null) {
            return redirect()->route('adminUsers');
        }

        $usersModel = new UsersModel();
        $usersModel->delete($pk_user);

        // Reacomodamos los IDs reales despues de eliminar.
        // De esta forma, si se borra un usuario intermedio,
        // los siguientes bajan su pk_user para mantenerse consecutivos.
        $this->resequenceUsersTable();

        return redirect()->route('adminUsers')->with('success', 'Usuario eliminado');
    }

    public function approvePendingUser($pkUser = null)
    {
        if ($pkUser === null) {
            return redirect()->route('adminDashboard');
        }

        $level = (int) $this->request->getPost('level');
        $allowedLevels = array_column($this->getAssignableLevels(), 'pk_level');

        if (! in_array($level, $allowedLevels, true)) {
            return redirect()->back()->with('error', 'Selecciona un rol valido');
        }

        $usersModel = new UsersModel();
        $user = $usersModel->find($pkUser);

        if (! $user) {
            return redirect()->back()->with('error', 'Solicitud no encontrada');
        }

        $usersModel->update($pkUser, [
            'fk_level'         => $level,
            'locked'           => 0,
            'approval_status'  => 'approved',
        ]);

        return redirect()->back()->with('success', 'Usuario aprobado correctamente');
    }

    public function apiUsersDelete()
    {
        $pkUser = $this->request->getPost('user');
        $pkUser = is_array($pkUser) ? ($pkUser[0] ?? null) : $pkUser;

        if ($pkUser === null || $pkUser === '') {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Usuario no recibido',
                'icon'    => 'error',
            ]);
        }

        $usersModel = new UsersModel();
        $user       = $usersModel->find($pkUser);

        if (! $user) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Usuario no encontrado',
                'icon'    => 'error',
            ]);
        }

        if ($usersModel->delete($pkUser)) {
            // En eliminaciones por AJAX tambien reordenamos los IDs reales
            // para que la tabla y la base queden consecutivas.
            $this->resequenceUsersTable();

            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Usuario eliminado correctamente',
                'icon'    => 'success',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'No se pudo eliminar el usuario',
            'icon'    => 'error',
        ]);
    }

    public function levelsIndex()
    {
        $levelsModel = new LevelsModel();
        $levels      = $levelsModel->findAll();

        return view('admin/levels_index', $this->withAdminNotifications([
            'levels' => $levels,
        ]));
    }

    public function levelsCreate()
    {
        $rules =
        [
            'level' => 'required|alpha_space',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $levelsModel = new LevelsModel();
        $levelsModel->insert([
            'level' => $this->request->getPost('level'),
        ]);

        return redirect()->route('adminLevels')->with('success', 'Nivel creado');
    }

    public function levelsEdit($pk_level = null)
    {
        if ($pk_level === null) {
            return redirect()->route('adminLevels');
        }

        $levelsModel = new LevelsModel();
        $level = $levelsModel->find($pk_level);
        if (! $level) {
            return redirect()->route('adminLevels');
        }

        return view('admin/levels_edit', $this->withAdminNotifications([
            'level' => $level,
        ]));
    }

    public function levelsUpdate($pk_level = null)
    {
        if ($pk_level === null) {
            return redirect()->route('adminLevels');
        }

        $rules =
        [
            'level' => 'required|alpha_space',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $levelsModel = new LevelsModel();
        $levelsModel->update($pk_level, [
            'level' => $this->request->getPost('level'),
        ]);

        return redirect()->route('adminLevels')->with('success', 'Nivel actualizado');
    }

    public function levelsDelete($pk_level = null)
    {
        if ($pk_level === null) {
            return redirect()->route('adminLevels');
        }

        $levelsModel = new LevelsModel();
        $levelsModel->delete($pk_level);

        return redirect()->route('adminLevels')->with('success', 'Nivel eliminado');
    }

    private function getUsersList()
    {
        $db = \Config\Database::connect();
        return $db->table('tbl_users u')
            ->select('u.pk_user, u.fk_phone, u.fk_level, u.locked, u.approval_status, p.person, p.first_name, p.last_name, l.level')
            ->join('tbl_persons p', 'p.pk_phone = u.fk_phone', 'left')
            ->join('cat_levels l', 'l.pk_level = u.fk_level', 'left')
            ->orderBy('u.pk_user', 'desc')
            ->get()
            ->getResultArray();
    }

    // Reutilizamos las mismas reglas para el formulario normal y el API
    // para que ambos muestren mensajes consistentes en espanol.
    private function getUserValidationRules(bool $includePhone = true): array
    {
        $rules = [
            'name'      => 'required|alpha',
            'firstName' => 'required|alpha',
            'lastName'  => 'required|alpha',
            'level'     => 'required|is_natural_no_zero',
            'locked'    => 'permit_empty|in_list[0,1]',
            'password'  => $includePhone ? 'required|min_length[3]' : 'permit_empty|min_length[3]',
        ];

        if ($includePhone) {
            $rules['phone'] = 'required|min_length[10]|numeric|is_unique[tbl_persons.pk_phone]';
        }

        return $rules;
    }

    // Estos mensajes reemplazan los textos por defecto en ingles.
    // Asi el usuario ve alertas claras como "Falta el telefono".
    private function getUserValidationMessages(bool $includePhone = true): array
    {
        $messages = [
            'name' => [
                'required' => 'Falta el nombre.',
                'alpha'    => 'El nombre solo debe contener letras.',
            ],
            'firstName' => [
                'required' => 'Falta el apellido paterno.',
                'alpha'    => 'El apellido paterno solo debe contener letras.',
            ],
            'lastName' => [
                'required' => 'Falta el apellido materno.',
                'alpha'    => 'El apellido materno solo debe contener letras.',
            ],
            'level' => [
                'required'           => 'Falta seleccionar el nivel.',
                'is_natural_no_zero' => 'Debes seleccionar un nivel valido.',
            ],
            'password' => [
                'required'   => 'Falta la contrasena.',
                'min_length' => 'La contrasena debe tener al menos 3 caracteres.',
            ],
            'locked' => [
                'in_list' => 'El estado bloqueado no es valido.',
            ],
        ];

        if ($includePhone) {
            $messages['phone'] = [
                'required'  => 'Falta el telefono.',
                'min_length'=> 'El telefono debe tener al menos 10 digitos.',
                'numeric'   => 'El telefono solo debe contener numeros.',
                'is_unique' => 'Ese telefono ya esta registrado.',
            ];
        }

        return $messages;
    }

    private function resequenceUsersTable(): void
    {
        $db = \Config\Database::connect();
        $users = $db->table('tbl_users')
            ->select('pk_user')
            ->orderBy('pk_user', 'asc')
            ->get()
            ->getResultArray();

        if (empty($users)) {
            $db->query('ALTER TABLE `tbl_users` AUTO_INCREMENT = 1');
            return;
        }

        // Reordenamos en dos fases para evitar colisiones entre claves primarias:
        // primero mandamos los IDs a una zona temporal alta y luego asignamos 1, 2, 3...
        $temporaryId = 1000;

        foreach ($users as $user) {
            $db->table('tbl_users')
                ->where('pk_user', (int) $user['pk_user'])
                ->update(['pk_user' => $temporaryId]);

            $temporaryId++;
        }

        $newId = 1;

        foreach ($users as $index => $user) {
            $db->table('tbl_users')
                ->where('pk_user', 1000 + $index)
                ->update(['pk_user' => $newId]);

            $newId++;
        }

        // Dejamos listo el siguiente valor autoincremental para que continúe
        // justo despues del ultimo ID reasignado.
        $db->query('ALTER TABLE `tbl_users` AUTO_INCREMENT = ' . $newId);
    }

    private function withAdminNotifications(array $data): array
    {
        return $data + $this->getAdminNotificationData();
    }

    private function getTeacherStudents(int $teacherId): array
    {
        if ($teacherId <= 0) {
            return [];
        }

        $db = \Config\Database::connect();

        return $db->table('tbl_teacher_students ts')
            ->select("
                ts.pk_assignment,
                ts.student_code,
                ts.school_group,
                ts.subject_name,
                ts.notes,
                u.pk_user AS student_user_id,
                p.person,
                p.first_name,
                p.last_name
            ")
            ->join('tbl_users u', 'u.pk_user = ts.fk_student_user', 'inner')
            ->join('tbl_persons p', 'p.pk_phone = u.fk_phone', 'left')
            ->where('ts.fk_teacher_user', $teacherId)
            ->where('ts.status', 1)
            ->orderBy('ts.school_group', 'asc')
            ->orderBy('ts.subject_name', 'asc')
            ->orderBy('p.first_name', 'asc')
            ->get()
            ->getResultArray();
    }

    private function getTeacherSummary(int $teacherId): array
    {
        $students = $this->getTeacherStudents($teacherId);

        $groups = [];
        $subjects = [];
        $studentIds = [];

        foreach ($students as $student) {
            $group = trim((string) ($student['school_group'] ?? ''));
            $subject = trim((string) ($student['subject_name'] ?? ''));
            $studentId = (int) ($student['student_user_id'] ?? 0);

            if ($group !== '') {
                $groups[$group] = true;
            }

            if ($subject !== '') {
                $subjects[$subject] = true;
            }

            if ($studentId > 0) {
                $studentIds[$studentId] = true;
            }
        }

        return [
            'assignments' => count($students),
            'students'    => count($studentIds),
            'groups'      => count($groups),
            'subjects'    => count($subjects),
        ];
    }

    private function getAdminNotificationData(): array
    {
        return [
            'pendingRegistrations' => $this->getPendingRegistrations(),
            'assignableLevels'     => $this->getAssignableLevels(),
        ];
    }

    private function getPendingRegistrations(): array
    {
        $db = \Config\Database::connect();

        return $db->table('tbl_users u')
            ->select('u.pk_user, u.fk_phone, p.person, p.first_name, p.last_name')
            ->join('tbl_persons p', 'p.pk_phone = u.fk_phone', 'left')
            ->where('u.approval_status', 'pending')
            ->orderBy('u.pk_user', 'desc')
            ->get()
            ->getResultArray();
    }

    private function getAssignableLevels(): array
    {
        $levelsModel = new LevelsModel();
        $levels = $levelsModel->findAll();
        $allowed = ['administrador', 'teacher', 'student', 'docente', 'alumno'];
        $mapped = [];

        foreach ($levels as $level) {
            $name = strtolower((string) ($level['level'] ?? ''));
            if (! in_array($name, $allowed, true)) {
                continue;
            }

            $label = $level['level'];
            if ($name === 'teacher') {
                $label = 'Docente';
            } elseif ($name === 'student') {
                $label = 'Alumno';
            } elseif ($name === 'administrador') {
                $label = 'Admin';
            }

            $mapped[] = [
                'pk_level' => (int) $level['pk_level'],
                'label'    => $label,
            ];
        }

        return $mapped;
    }
}
