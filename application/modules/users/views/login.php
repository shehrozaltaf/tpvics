<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>TPVICS</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session <?php if(isset($message)){echo "<font color=red>".$message."</font>";}?></p>
     <?php $attributes = array('name' => 'login', 'id' => 'login'); ?>
	 <?php echo form_open('index.php/users/login', $attributes);?>
      <?= validation_errors("<p style='color:red;'>", "</p>") ?>
      <?php if(validation_errors()){ ?><hr style="border: none; height: 5px;color: #333;background-color:red;"><?php } ?>
      <div class="form-group has-feedback">
        <input type="text" name="username" id="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <?php //echo form_checkbox('remember', '1', FALSE, 'id="remember"');?> <!--Remember Me-->
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button class="btn btn-primary btn-block btn-flat" type="submit" name="submit">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close();?>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php echo $this->load->view('includes/scripts');?>