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
                    <?php echo form_open(current_url());?>
                      <div class="box-body">
                        
                        <div class="form-group">
                          <label class="control-label">Full Name</label>
                          <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name" value="<?php echo $user->full_name;?>">
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label">Email</label>
                          <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo $user->email;?>">
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label">Designation</label>
                          <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation" value="<?php echo $user->designation;?>">
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label">Contact</label>
                          <input type="text" name="contact" id="contact" class="form-control" placeholder="Contact" value="<?php echo $user->contact;?>">
                        </div>
                        
                        
                        <div class="form-group">
                        <label>Provice:</label>
                          <select class="form-control select2" name="district" id="district" style="width: 100%;">
                            <option value="">Select Province</option>
                              <option value="0" <?php if ($user->district == 0){ ?>selected<?php } ?>>Karachi (Core
                                  Team)
                              </option>
                              <option value="1" <?php if ($user->district == 1){ ?>selected<?php } ?>>KHYBER
                                  PAKHTUNKHWA
                              </option>
                              <option value="2" <?php if ($user->district == 2){ ?>selected<?php } ?>>PUNJAB</option>
                              <option value="3" <?php if ($user->district == 3){ ?>selected<?php } ?>>SINDH</option>
                              <option value="4" <?php if ($user->district == 4){ ?>selected<?php } ?>>BALOCHISTAN
                              </option>
                              <option value="7" <?php if ($user->district == 5){ ?>selected<?php } ?>>GILGIT BALTISTAN
                              </option>
                              <option value="9" <?php if ($user->district == 0){ ?>selected<?php } ?>>ADJACENT
                                  AREAS-FR
                              </option>
                          </select>
                        </div>
                        
                        <div class="form-group">
                          <label>User Type:</label>
                          <select class="form-control select2" name="type" id="type" style="width: 100%;">
                            <option value="">Select User Type</option>
                            <option value="1" <?php if($user->type == 1){ ?>selected<?php } ?>>Dashboard only</option>
                            <option value="2" <?php if($user->type == 2){ ?>selected<?php } ?>>App only</option>
                            <option value="3" <?php if($user->type == 3){ ?>selected<?php } ?>>Dashboard & App</option>
                          </select>
                        </div>
                        
                        
                        <div class="form-group" <?php if($user->type == 1){?>style="display:none"<?php } else {?>style="display:block"<?php }?> id="app_div">
                          <label>App:</label>
                          <select class="form-control select2" name="app[]" multiple id="user_app" style="width:100%;">
                            <?php $apps = explode(",",$user->app);?>
                            <option value="1" <?php if(in_array(1, $apps)){ ?>selected<?php }?>>RSD QOC DHMPT</option>
                            <option value="2" <?php if(in_array(2, $apps)){ ?>selected<?php }?>>Academic Detailing</option>
                            <option value="3" <?php if(in_array(3, $apps)){ ?>selected<?php }?>>LHW Monitoring</option>
                            <option value="4" <?php if(in_array(4, $apps)){ ?>selected<?php }?>>CMW Monitoring</option>
                            <option value="5" <?php if(in_array(5, $apps)){ ?>selected<?php }?>>Emergency Care</option>
                          </select>
                        </div>
                        
                        
                        <div class="form-group">
                          <label class="control-label">Username</label>
                          <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo $user->username;?>">
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label">Password</label>
                          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        
                        <div class="form-group">
                          <label class="control-label">Confirm Password</label>
                          <input type="password" name="passwordagain" id="passwordagain" class="form-control" placeholder="Re-Password">
                        </div>
                        
                        
                        
                        
                       
                        <div class="form-group">
                          
                          <?php 
								foreach ($groups->result() as $group){ 
						  
						  		$group_id = $group->id;
							    $checked  = null;
							    $item     = null;
								
								foreach($current_groups->result() as $current_group) {
									if ($group_id == $current_group->group_id) {
										$checked = ' checked="checked"';
										break;
									}
								}	
						  ?>
                          
                          <input type="checkbox" class="minimal" name="groups[]" value="<?php echo $group->id;?>"<?php echo $checked;?>>
                          <?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?><br>
                          <?php } ?>
                        </div>
                        
                        
                        <!--<div class="form-group">
                              <label>Profile Picture:</label>
                              <input name="profile_image" type="file"/>
                        </div>-->                                                                                                                                                
                        
                        
                      </div>
                      <!-- /.box-body -->
        
                      <div class="box-footer">
                        <?php echo form_submit('submit', "Save User", 'class="btn btn-primary"');?>
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
	
	
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
	
  });
  
  /*function callme(){
  	
	var type = $("#type").val();
	if(type == 2 || type == 3){
		$('#app_div').css('display', 'block');
	} else {
		$('#app_div').css('display', 'none');
		//$('#user_app').find('option:eq(0)').prop('selected', true);
		$('#user_app').select2().select2('val','0');
	}
	
  }*/
</script>