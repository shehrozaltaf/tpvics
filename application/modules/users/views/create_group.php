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
                    <?php echo form_open_multipart("index.php/users/create_group");?>
                      <div class="box-body">
                        
                        <div class="form-group">
                          <label class="control-label">Group Name:</label>
                          <input type="text" name="name" id="name" class="form-control" placeholder="Group Name" value="<?php echo set_value('name', $this->session->userdata('name')); ?>">
                        </div>
                        
                        <div class="form-group">
                          <label>Group Description:</label>
                          <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description"><?php echo set_value('description', $this->session->userdata('description')); ?></textarea>
                        </div>
                        
                        
                        
                      </div>
                      <!-- /.box-body -->
        
                      <div class="box-footer">
                        <?php echo form_submit('submit', "Create Group", 'class="btn btn-primary"');?>
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