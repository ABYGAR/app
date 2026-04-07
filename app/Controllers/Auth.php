<?php

namespace App\Controllers;

use App\Models\PersonsModel;
use App\Models\LevelsModel;
use App\Models\UsersModel;

class Auth extends BaseController
{
    public function loginForm()
    {
        /*$service = new UserService();
        $users   = $service->getUsers();

        return $this->response->setJSON
        ([
            'status' => true,
            'users'  => $users,
            'group'  => 'ISC-802',
        ]);*/
        
        return view('accounts/login');
    }

    private function renderLoginSuccessRedirect(string $targetRoute)
    {
        return view('accounts/login_success_redirect', [
            'redirectUrl' => base_url(route_to($targetRoute)),
        ]);
    }
    
    public function registerForm()
    {
        return view('accounts/register');
    }
    
    public function forget()
    {
        echo "Forget";
        //return view('prueba');
    }

    public function profile()
    {
        return $this->redirectToProfileTarget();
    }

    public function settings()
    {
        return $this->redirectToProfileTarget();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->route('loginForm')->with('success', 'Sesion cerrada correctamente.');
    }

    public function loginProcess()
    {
        $rules = 
        [
            'phone'    => 'required|min_length[10]|numeric',
            'password' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules))
        {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Inicio de sesion fallido. Revisa los datos e intenta de nuevo.');
        }
        else
        {
            $usersModel   = new UsersModel();

            $phone    = $this->request->getPost('phone');
            $password = $this->request->getPost('password');

            $db = \Config\Database::connect();
            $user = $db->table('tbl_users u')
                ->select('u.pk_user, u.fk_phone, u.fk_level, u.password, u.locked, p.person, p.first_name, p.last_name, l.level')
                ->join('tbl_persons p', 'p.pk_phone = u.fk_phone', 'left')
                ->join('cat_levels l', 'l.pk_level = u.fk_level', 'left')
                ->where('u.fk_phone', $phone)
                ->get()
                ->getRowArray();

            if($user)
            {                
                if(password_verify($password, $user['password']))
                {
                    if (($user['approval_status'] ?? 'approved') !== 'approved' || (int) $user['locked'] === 1) {
                        $this->validator->setError('phone', 'Usuario bloqueado o pendiente de aprobacion');

                        return redirect()->back()
                            ->withInput()
                            ->with('errors', $this->validator->getErrors())
                            ->with('error', 'Inicio de sesion fallido. Tu usuario esta bloqueado o pendiente de aprobacion.');
                    }

                    $fullName = trim(($user['person'] ?? '') . ' ' . ($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
                    session()->set('user_name', $fullName !== '' ? $fullName : $user['fk_phone']);
                    session()->set('user_id', (int) $user['pk_user']);
                    session()->set('user_phone', $user['fk_phone']);
                    session()->set('user_level', (int) $user['fk_level']);
                    $this->sendTelegramLoginNotification($user['fk_phone']);

                    // Resolvemos el rol usando el nombre del nivel.
                    // Asi evitamos depender de IDs fijos que pueden cambiar en la base.
                    $role = $this->resolveRoleFromLevel($user['level'] ?? null);
                    session()->set('role', $role);

                    if ($role === 'docente') {
                        return $this->renderLoginSuccessRedirect('docenteDashboard');
                    }

                    if ($role === 'alumno') {
                        return $this->renderLoginSuccessRedirect('alumnoDashboard');
                    }

                    return $this->renderLoginSuccessRedirect('adminDashboard');
                }
                else
                {
                    $this->validator->setError('phone','Usuario y/o password incorrectos');

                    return redirect()->back()
                    ->withInput()
                    ->with('errors',$this->validator->getErrors())
                    ->with('error', 'Inicio de sesion fallido. Usuario y/o password incorrectos.');
                }   
            }
            else
            {
                $this->validator->setError('phone','Usuario y/o password incorrectos');

                return redirect()->back()
                ->withInput()
                ->with('errors',$this->validator->getErrors())
                ->with('error', 'Inicio de sesion fallido. Usuario y/o password incorrectos.');
            }
        }
    }

    public function registerProcess()
    {
        $rules = 
        [
            'phone'     => 'required|min_length[10]|numeric|matches[cphone]|is_unique[tbl_persons.pk_phone]',
            'cphone'    => 'required|min_length[10]|numeric|matches[phone]',
            'name'      => 'required|alpha',
            'firstName' => 'required|alpha',
            'lastName'  => 'required|alpha',
            'password'  => 'required',
        ]; 
        
        if (!$this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        else
        {
            if($this->request->is('post'))
            {
                $personsModel = new PersonsModel();
                $usersModel   = new UsersModel();
                $db           = \Config\Database::connect();

                $tbl_persons = 
                [
                    'pk_phone'   => $this->request->getPost('phone'),
                    'person'     => strtoupper($this->request->getPost('name')),
                    'first_name' => strtoupper($this->request->getPost('firstName')),
                    'last_name'  => strtoupper($this->request->getPost('lastName'))
                ]; 

                $tbl_users = 
                [
                    'fk_phone'   => $this->request->getPost('phone'),
                    'fk_level'   => $this->getGuestLevelId(),
                    'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'locked'     => 1,
                    'approval_status' => 'pending',
                ]; 

                $db->transBegin();

                $insertPersons = $personsModel->insert($tbl_persons);
                if ($insertPersons === false) {
                    $db->transRollback();
                    return redirect()->back()->withInput()->with('errors', ['phone' => 'No se pudo registrar la solicitud']);
                }

                $insertUsers = $usersModel->insert($tbl_users);
                if ($insertUsers === false) {
                    $db->transRollback();
                    return redirect()->back()->withInput()->with('errors', ['phone' => 'No se pudo registrar la solicitud']);
                }

                $db->transCommit();

                return redirect()->route('loginForm')->with('success', 'Registro enviado. Espera aprobacion del administrador.');
            }           
        }
    }

    private function redirectToProfileTarget()
    {
        if (! session('user_id')) {
            return redirect()->route('loginForm');
        }

        if (session('role') === 'admin') {
            return redirect()->route('adminUsersEdit', [session('user_id')]);
        }

        if (session('role') === 'docente') {
            return redirect()->route('docenteDashboard')->with('info', 'Tu perfil se mostrara aqui.');
        }

        if (session('role') === 'alumno') {
            return redirect()->route('alumnoDashboard')->with('info', 'Tu perfil se mostrara aqui.');
        }

        return redirect()->route('loginForm');
    }

    private function getGuestLevelId(): int
    {
        $levelsModel = new LevelsModel();
        $guest = $levelsModel->whereIn('level', ['Cliente', 'Guest', 'Invitado'])->first();

        if ($guest) {
            return (int) $guest['pk_level'];
        }

        $fallback = $levelsModel->orderBy('pk_level', 'asc')->first();

        return (int) ($fallback['pk_level'] ?? 1);
    }

    private function resolveRoleFromLevel(?string $levelName): string
    {
        $level = strtolower(trim((string) $levelName));

        // Aceptamos varias etiquetas para que el sistema sea flexible
        // aunque los niveles se nombren distinto en la BD.
        if (in_array($level, ['teacher', 'docente', 'profesor'], true)) {
            return 'docente';
        }

        if (in_array($level, ['student', 'alumno', 'cliente', 'guess', 'guest', 'invitado'], true)) {
            return 'alumno';
        }

        return 'admin';
    }

    private function sendTelegramLoginNotification(string $phone): void
    {
        // Auth.php ya no guarda credenciales ni hace la llamada directa.
        // Todo el envio real se centraliza en Api.php para no duplicar logica.
        $mensaje = "numero {$phone} a entrado con exito";

        $resultado = Api::sendTelegramMessage($mensaje);

        if ($resultado['success'] !== true) {
            log_message('error', 'No se pudo enviar mensaje a Telegram: {message}', ['message' => $resultado['message']]);
        }
    }
}
