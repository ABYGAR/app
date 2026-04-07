<?= $this->extend('layouts/main_layout'); ?>

<?= $this->section('content') ?>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <?= $this->include('layouts/logo_layout') ?>
      </div>
      <div class="login-box" >
      <?= form_open(base_url(route_to('registerProcess')), ['class'=>'login-form']); ?>

        <h3 class="login-head"><i class="bi bi-plus me-2"></i>NEW ACCOUNT</h3>
        
        <div class="row">
          <div class="col-md-6 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'phone', 'id'=>'phone', 'value'=>old('phone'), 'placeholder'=>'Number phone', 'class' => 'form-control']); ?>
            <small id="phoneHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('phone') ?></p></small> 										
          </div>
          <div class="col-md-6 mb-2">
            <?= form_input(['type' => 'password', 'name' => 'cphone', 'id'=>'cphone', 'value'=>old('cphone'), 'placeholder'=>'Confirm phone', 'class' => 'form-control']); ?>
            <small id="cphoneHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('cphone') ?></p></small> 										
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'name', 'id'=>'name', 'value'=>old('name'), 'placeholder'=>'Name', 'class' => 'form-control']); ?>
            <small id="nameHelpe" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('name') ?></p></small> 										
          </div>
          <div class="col-md-4 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'firstName', 'id'=>'firstName', 'value'=>old('firstName'), 'placeholder'=>'First Name', 'class' => 'form-control']); ?>
            <small id="firstNameHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('firstName') ?></p></small> 										         
          </div>
          <div class="col-md-4 mb-2">
            <?= form_input(['type' => 'text', 'name' => 'lastName', 'id'=>'lastName', 'value'=>old('lastName'), 'placeholder'=>'Last Name', 'class' => 'form-control']); ?>
            <small id="lastNameHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('lastName') ?></p></small> 										         
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-2">
            <?= form_input(['type' => 'password', 'name' => 'password','id'=>'password', 'placeholder'=>'Insert your password', 'class' => 'form-control']); ?>
            <small id="passwordHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('password') ?></p></small> 										         
          </div>
        </div>

        <div class="mb-3">
          <div class="utility">
          <div class="form-check">
            <label class="form-check-label">
                <a href="<?= base_url(route_to('loginForm')); ?>">Login ?</a>
                <a href="<?= base_url(route_to('forgetForm')); ?>">Forgot Password ?</a>
            </label>
          </div>
        </div>

        <div class="mb-3 btn-container d-grid">
          <?php 
            $data = 
            [
                'name'    => 'btnLogin',
                'id'      => 'btnLogin',
                'type'    => 'submit',
                'class'   => 'btn btn-primary btn-block',
                'content' => '<i class="bi bi-plus me-2 fs-5"></i> CREATE'
            ];
            echo form_button($data);
          ?>
        </div>
      <?= form_close(); ?> 
      </div>
    </section>
<?= $this->endSection() ?>