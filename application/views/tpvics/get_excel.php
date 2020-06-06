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
                            <h3 class="box-title">Randomized Cases</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <h6>Project: TPVICS</h6>
                                <h6>Cluster No: <?php echo $cluster; ?></h6>
                                <h6>Randomization Date: <?php echo $randomization_date; ?></h6>
                                <h6>Division: <?php echo $division; ?></h6>
                            </div>
                            <table id="get_list" class="table table-bordered table-striped table-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Tablet No</th>
                                    <th>Household No</th>
                                    <th>Head of the Household</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($cluster_data->result() as $row) { ?>
                                    <tr>
                                        <td><?php echo $row->sno; ?></td>
                                        <td><?php echo $row->tabNo; ?></td>
                                        <td><?php echo $row->household; ?></td>
                                        <td><?php echo $row->hh08; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
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
            buttons: [
                {extend: 'excelHtml5', footer: true},
                {extend: 'csvHtml5', footer: true}
            ],
            "pageLength": 50,
            "scrollX": true,
            "ordering": true,
        });
        $('#get_list tfoot').each(function () {
            $(this).insertAfter($(this).siblings('tbody'));
        });
    });
</script>