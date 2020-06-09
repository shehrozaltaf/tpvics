<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
  <?php echo $this->load->view('includes/header');?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php echo $this->load->view('includes/sidebar');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $heading;?>
        <small></small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <!--<div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>-->
            <!-- /.box-header -->
            <div class="box-body">
            	<div class="col-sm-3"></div>
                <div class="col-md-6">
                <?= validation_errors("<p style='color:red;'>", "</p>") ?>
                <?php if(validation_errors()){ ?><hr style="border: none; height: 5px;color: #333;background-color:red;"><?php } ?>
                  <!-- general form elements -->
                    <!--<div class="box-header with-border"><h3 class="box-title">Quick Example</h3></div>-->
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open_multipart("index.php/users/register");?>
                      <div class="box-body">
                        
                        <div class="form-group">
                          <label class="control-label">Full Name</label>
                          <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name" value="<?php echo set_value('full_name', $this->session->userdata('full_name')); ?>">
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label">Email</label>
                          <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo set_value('email', $this->session->userdata('email')); ?>">
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label">Designation</label>
                          <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation" value="<?php echo set_value('designation', $this->session->userdata('designation')); ?>">
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label">Contact</label>
                          <input type="text" name="contact" id="contact" class="form-control" placeholder="Contact" value="<?php echo set_value('contact', $this->session->userdata('contact')); ?>">
                        </div>
                        
                        
                        <div class="form-group">
                        <label>Province:</label>
                          <select class="form-control select2" name="district" id="district" style="width: 100%;">
                            <option value="">Select Province</option>
                            <option value="0" 	<?php echo set_select('district', 0, false);?>>Karachi (Core Team)</option>
                              <option value="1" <?php echo set_select('district', 1, false); ?>>KHYBER PAKHTUNKHWA
                              </option>
                              <option value="2" <?php echo set_select('district', 2, false); ?>>PUNJAB</option>
                              <option value="3" <?php echo set_select('district', 3, false); ?>>SINDH</option>
                              <option value="4" <?php echo set_select('district', 4, false); ?>>BALOCHISTAN</option>
                              <option value="7" <?php echo set_select('district', 7, false); ?>>GILGIT BALTISTAN
                              </option>
                              <option value="9" <?php echo set_select('district', 9, false); ?>>ADJACENT AREAS-FR
                              </option>
                          </select>
                        </div>
                        
                        <div class="form-group">
                          <label>User Type:</label>
                          <select class="form-control select2" name="type" id="type" style="width: 100%;">
                            <option value="">Select User Type</option>
                            <option value="1" <?php echo set_select('type', 1, false);?>>Dashboard only</option>
                            <option value="2" <?php echo set_select('type', 2, false);?>>App only</option>
                            <option value="3" <?php echo set_select('type', 3, false);?>>Dashboard & App</option>
                          </select>
                        </div>
                        
                        
                        <div class="form-group" style="display:none" id="app_div">
                          <label>App:</label>
                          <select class="form-control select2" name="app[]" multiple id="user_app" style="width:100%;">
                              <option value="1">Lisitng</option>
                              <option value="2">Survey App</option>
                          </select>
                        </div>
                        
                        
                        <div class="form-group">
                          <label class="control-label">Username</label>
                          <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo set_value('username', $this->session->userdata('username')); ?>">
                        </div>
                        
                        
                        
                        
                        <div class="input-group">
                          <label class="control-label">Password</label>
                          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                          <span class="input-group-btn">
                            <button class="btn btn-default reveal" type="button" style="margin-top:25px;"><i class="glyphicon glyphicon-eye-open"></i></button>
                          </span>          
                        </div>
                        <br>
                        
                        <!--<div class="form-group">
                          <label class="control-label">Confirm Password</label>
                          <input type="password" name="passwordagain" id="passwordagain" class="form-control" placeholder="Re-Password">
                        </div>-->
                        
                        <div class="input-group">
                          <label class="control-label">Confirm Password</label>
                          <input type="password" name="passwordagain" id="passwordagain" class="form-control" placeholder="Password Again">
                          <span class="input-group-btn">
                            <button class="btn btn-default reveal2" type="button" style="margin-top:25px;"><i class="glyphicon glyphicon-eye-open"></i></button>
                          </span>          
                        </div>
                        
                        <!--<div class="form-group">
                              <label>Profile Picture:</label>
                              <input name="profile_image" type="file"/>
                        </div>-->                                                                                                                                                
                        
                        
                      </div>
                      <!-- /.box-body -->
        
                      <div class="box-footer">
                        <?php echo form_submit('submit', "Register User", 'class="btn btn-primary"');?>
                      </div>
                    <?php echo form_close();?>
                  <!-- /.box -->
                </div>
                <!-- /.col-6 -->
                <div class="col-sm-3"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php echo $this->load->view('includes/footer');?>
  
</div>
<!-- ./wrapper -->

<?php echo $this->load->view('includes/scripts');?>
<!-- page script -->
<script>
  $(function () {
	$(".reveal").on('click',function() {
		var $pwd = $("#password");
		if ($pwd.attr('type') === 'password') {
			$pwd.attr('type', 'text');
		} else {
			$pwd.attr('type', 'password');
		}
	});
	$(".reveal2").on('click',function() {
		var $pwd2 = $("#passwordagain");
		if ($pwd2.attr('type') === 'password') {
			$pwd2.attr('type', 'text');
		} else {
			$pwd2.attr('type', 'password');
		}
	});
	$('#example1').DataTable();
	$('.select2').select2();
	$("#type").change(function () {
		var type = $("#type").val();
		if(type == 2 || type == 3){
			$('#app_div').css('display', 'block');
		} else {
			$('#app_div').css('display', 'none');
			//$('#user_app').find('option:eq(0)').prop('selected', true);
			$('#user_app').select2().select2('val','0');
		}
	});
  });
  
  /*function callme(){
  	
	var user_type = $('#type').val();
	
	if(user_type == 2 || user_type == 3){
		$('#app_div').css('display', 'block');
	} else {
		$('#app_div').css('display', 'none');
		//$('#app').prop('selectedIndex',0);
		
		$("#user_app")[0].selectedIndex = 0;
	}
  }*/
</script>