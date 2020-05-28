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
        <small>
			<?php if (! empty($message)) { ?>
                <div id="message">
                <?php echo $message; ?>
                </div>
            <?php } ?>  
        </small>
        <a href="<?php echo base_url();?>index.php/users/register" class="btn btn-primary pull-right">Add User</a>
      </h1>
    </section>
    
    <!--<hr style="border-color:#3C8DBC; width:98%; border-width:2px;">-->

     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box box-primary">
            <!--<div class="box-header">
            <h3>SECTION 2: BACKGROUND</h3>
              <h3 class="box-title">2.4 BACKGROUND and GENERAL SIGNS AND SYMPTOMS </h3>
            </div>-->
            <!-- /.box-header -->
            <div class="box-body">
              
              <table id="example1" class="table table-bordered table-striped" width="100%">
                
                <thead>
                    <tr>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Designation</th>
                      <th>Type</th>
                      <th>App</th>
                      <th>Enable</th>
                      <th>Actions</th>
                    </tr>
                </thead>
                
                
                <tbody>
                
                	<?php foreach($users->result() as $row){ 
						  
						  if($row->enable == 0){
						  	$ed = '<span class="label label-danger">No</span>';
						  } else {
						  	$ed = '<span class="label label-success">Yes</span>';
						  }
						  
						  if($row->type == 1){
						  	$type = '<span class="label label-primary">Dashboard</span>';
						  } else if($row->type == 2){
						  	$type = '<span class="label label-primary">App</span>';
						  } else if($row->type == 3){
						  	$type = '<span class="label label-primary">App & Dashboard</span>';
						  }
					?>
                	<tr>
                      <td><?php echo $row->full_name;?></td>
                      <td><?php echo $row->username;?></td>
                      <td><?php echo $row->designation;?></td>
                      <td><?php echo $type;?></td>
                      <td><?php echo $row->app;?></td>
                      <td><?php echo $ed;?></td>
                      <td><?php echo anchor("index.php/users/edit_user/".$row->id, 'Edit', 'class="btn-xs btn-primary"');?></td>
                  </tr>
                  <?php } ?>
                    
                </tbody>
                
              </table>
              
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

<script src="<?php echo base_url();?>assets/charts/highcharts.js"></script>
<script src="<?php echo base_url();?>assets/charts/highcharts-3d.js"></script>

<!-- page script -->
<script>
$(function () {
    $("#example1").DataTable({
	  dom: '<"top"Bfrt<"clear">>rt<"bottom"ilp>',
	  buttons: ['excel', 'csv'],
	  "scrollX": true,
	  "ordering": false,
	  //responsive: true,
	});
	
	/*$( "#btn-danger" ).click(function() {
		$.confirm({
			title: 'Confirm!',
			content: 'Simple confirm!',
			buttons: {
				confirm: function () {
					$.alert('Confirmed!');
				},
				cancel: function () {
					$.alert('Canceled!');
				}
			}
		});
	});*/
});
</script>

<script>
/*function ConfirmDelete(){
	
	$.confirm({
		title: 'Confirm!',
		content: 'Simple confirm!',
		buttons: {
			confirm: function () {
				$.alert('Confirmed!');
			},
			cancel: function () {
				$.alert('Canceled!');
			}
		}
	});
}*/
</script>