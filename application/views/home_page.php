<h2>Welcome to MAGAZINES</h2>

<div class="row">
    <div class="col-md-5">
        <h3 class="text-primary">Register now</h3>
        <?php 
        if($this->input->post('form_type') && $this->input->post('form_type') == 'register'){
            echo validation_errors();
        }  
        ?>
        <?php if (isset($register_data) && $register_data['success']){ ?>
        <div class="alert alert-success">Registered successfully!, you can login now</div>
        <?php } ?>
        <?php echo form_open() ?>
        <?php echo form_hidden('form_type', 'register'); ?>
        <div class="form-group">
            <?php echo form_label('First Name', 'first_name', array('class' => 'control-label')); ?>
            <?php echo form_input('first_name', set_value('first_name'), 'class="form-control" placeholder="First Name"'); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Last Name', 'last_name', array('class' => 'control-label')); ?>
            <?php echo form_input('last_name', set_value('last_name'), 'class="form-control" placeholder="Last Name"'); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Username', 'username', array('class' => 'control-label')); ?>
            <?php echo form_input('username', set_value('username'), 'class="form-control" placeholder="Username"'); ?>
            <p class="help-block">Use only alphabets and numeric characters</p>
        </div>
        <div class="form-group">
            <?php echo form_label('Password', 'password', array('class' => 'control-label')); ?>
            <?php echo form_password('password', '', 'class="form-control" placeholder="Password"'); ?>
            <p class="help-block">Use only alphabets and numeric characters</p>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        <?php echo form_close() ?>
    </div>
    
    <div class="col-md-5">
        <h3 class="text-primary">or Login</h3>
        <?php 
        if($this->input->post('form_type') && $this->input->post('form_type') == 'login'){
            echo form_error('username');
            echo form_error('password');
            if (isset($login_data) && $login_data['error_login']){
        ?>
        <div class="alert alert-danger">Wrong username/password combination!</div>
        <?php } } ?>
        <?php echo form_open() ?>
        <?php echo form_hidden('form_type', 'login'); ?>
        <div class="form-group">
            <?php echo form_label('Username', 'username', array('class' => 'control-label')); ?>
            <?php echo form_input('username', set_value('username'), 'class="form-control" placeholder="Username"'); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Password', 'password', array('class' => 'control-label')); ?>
            <?php echo form_password('password', '', 'class="form-control" placeholder="Password"'); ?>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        <?php echo form_close() ?>
    </div>

    <div class="col-md-2">
        <h4 class="text-primary">Admin Area</h4>
        <?php 
        if($this->input->post('form_type') && $this->input->post('form_type') == 'admin_login'){
            echo form_error('username');
            echo form_error('password');
            echo form_error('login_validation');
            if (isset($login_data) && $login_data['error_login']){
        ?>
        <div class="alert alert-danger">Wrong username/password combination!</div>
        <?php } } ?>
        <?php echo form_open() ?>
        <?php echo form_hidden('form_type', 'admin_login'); ?>
        <div class="form-group">
            <?php echo form_label('Username', 'username', array('class' => 'control-label')); ?>
            <?php echo form_input('username', set_value('username'), 'class="form-control" placeholder="Username"'); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Password', 'password', array('class' => 'control-label')); ?>
            <?php echo form_password('password', '', 'class="form-control" placeholder="Password"'); ?>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        <?php echo form_close() ?>
    </div>
</div>
