<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
  <?php echo $this->load->view('includes/header');?>
  <?php echo $this->load->view('includes/sidebar');?>
  <div class="content-wrapper">
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
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" width="100%">
                <thead>
                    <tr>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Designation</th>
                      <th>Enable</th>
                      <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users->result() as $row) {
						  if($row->enable == 0){
						  	$ed = '<span class="label label-danger">No</span>';
						  } else {
						  	$ed = '<span class="label label-success">Yes</span>';
						  }
					?>
                	<tr>
                      <td><?php echo $row->full_name;?></td>
                      <td><?php echo $row->username;?></td>
                      <td><?php echo $row->designation;?></td>
                      <td><?php echo $ed;?></td>
                      <td><?php echo anchor("index.php/users/edit_user/".$row->id, 'Edit', 'class="btn-xs btn-primary"');?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php echo $this->load->view('includes/footer');?>
</div>
<?php echo $this->load->view('includes/scripts');?>
<script src="<?php echo base_url();?>assets/charts/highcharts.js"></script>
<script src="<?php echo base_url();?>assets/charts/highcharts-3d.js"></script>

<script>
$(function () {
    $("#example1").DataTable({
	  dom: '<"top"Bfrt<"clear">>rt<"bottom"ilp>',
	  buttons: ['excel', 'csv'],
	  "scrollX": true,
        "ordering": true,
	});
});
</script>