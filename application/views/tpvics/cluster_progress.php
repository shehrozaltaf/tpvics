<style>
    .not-active {
        pointer-events: none;
        cursor: default;
        text-decoration: none;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

    <?php echo $this->load->view('includes/header'); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php echo $this->load->view('includes/sidebar'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $heading; ?>
                <small>
                    <?php if (!empty($message)) { ?>
                        <div id="message">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>
                </small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Collected Households</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table id="get_list" class="table table-bordered table-responsive" width="100%">

                                <thead>

                                <tr>
                                    <th>Household No</th>
                                    <th>Table forms Records</th>
                                    <th>Table hb Records</th>
                                    <th>Table vision Records</th>
                                    <th>Table anthro Records</th>
                                    <th>Status</th>
                                </tr>

                                </thead>

                                <tbody>
                                <?php $this->load->model('master_model');
                                foreach ($get_list->result() as $row) {

                                    if ($row->forms > 0 and $row->hb > 0 and $row->vision > 0 and $row->anthro > 0) {
                                        $status = '<span class="label label-success">All is well</span>';
                                    } else {
                                        $status = '<span class="label label-danger">Something went wrong</span>';
                                    }
                                    ?>

                                    <tr>
                                        <td><?php echo $row->hhno; ?></td>
                                        <td><?php echo $row->forms; ?></td>
                                        <td><?php echo $row->hb; ?></td>
                                        <td><?php echo $row->vision; ?></td>
                                        <td><?php echo $row->anthro; ?></td>
                                        <td><?php echo $status; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                                <!--<tfoot>
                                  <tr>
                                    <th>District</th>
                                    <th>Cluster Number</th>
                                    <th>Total Structures</th>
                                    <th>Residential Structures</th>
                                  </tr>
                                </tfoot>-->

                            </table>

                        </div>
                        <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


        </section>


    </div>
    <!-- /.content-wrapper -->
    <?php echo $this->load->view('includes/footer'); ?>

</div>
<!-- ./wrapper -->

<?php echo $this->load->view('includes/scripts'); ?>

<!-- page script -->
<script>
    $(document).ready(function () {

        $('#get_list').DataTable({
            responsive: true,
            dom: '<"top"Bfrt<"clear">>rt<"bottom"ilp>',
            buttons: ['excel', 'csv'],
            "scrollX": true,
            "ordering": false,
            pageLength: 30,
        });

    });
</script>