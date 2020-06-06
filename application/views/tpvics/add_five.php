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
                            <h3 class="box-title">Add More Cases</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table id="get_list" class="table table-bordered table-striped table-responsive"
                                   width="100%">

                                <thead>
                                <tr>
                                    <th>District</th>
                                    <th>Cluster Number</th>

                                    <?php if ((!empty($this->uri->segment(3)) and substr($this->uri->segment(3), 3, 1) == 'c') || $this->users->get_user()->district != 0) { ?>
                                        <th width="10%">Randomize</th>
                                    <?php } ?>

                                </tr>
                                </thead>

                                <tbody>

                                <?php

                                foreach ($get_list->result() as $row2) {

                                    if ($this->users->in_group('admin') || $this->users->in_group('management')) {
                                        $anchor = anchor("tpvics/systematic_randomizer2/" . $row2->cluster_no . "/" . $this->uri->segment(3), '<i class="fa fa-edit"></i> Randomize', 'class="btn-sm btn-primary"');
                                    } else {
                                        $anchor = anchor("tpvics/systematic_randomizer2/" . $row2->cluster_no, '<i class="fa fa-edit"></i> Randomize', 'class="btn-sm btn-primary"');
                                    }

                                    if ($row2->dist_id == 2) {
                                        $province = 'Punjab';
                                    } else if ($row2->dist_id == 3) {
                                        $province = 'Sindh';
                                    } else {
                                        $province = 'Test';
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $province; ?></td>
                                        <td><?php echo $row2->cluster_no; ?></td>
                                        <td><?php echo $anchor; ?></td>
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
        });

    });
</script>