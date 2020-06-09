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
    <?php echo $this->load->view('includes/sidebar'); ?>
    <div class="content-wrapper">
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
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Collected Households</h3>
                        </div>
                        <div class="box-body">
                            <table id="get_list" class="table table-bordered table-responsive" width="100%">
                                <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Hosuehold No</th>
                                    <th>Forms</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                foreach ($get_list->result() as $row) {
                                    $get_status = $row->hh21;
                                    if ($get_status == 0) {
                                        $status = '<span class="label label-danger">Not Collected Yet</span>';
                                    } else if ($get_status == 1) {
                                        $status = '<span class="label label-success">Completed</span>';
                                    } else if ($get_status == 2) {
                                        $status = '<span class="label label-danger">Partially Complete</span>';
                                    } else if ($get_status == 3) {
                                        $status = '<span class="label label-danger">No HH member at home or no competent respondent at home at time of visit  </span>';
                                    } else if ($get_status == 4) {
                                        $status = '<span class="label label-danger">Entire household absent for extended period of time</span>';
                                    } else if ($get_status == 5) {
                                        $status = '<span class="label label-primary">Refused</span>';
                                    } else if ($get_status == 6) {
                                        $status = '<span class="label label-danger">Dwelling vacant or address not a dwelling </span>';
                                    } else if ($get_status == 7) {
                                        $status = '<span class="label label-danger">Dwelling not found</span>';
                                    } else if ($get_status == 96) {
                                        $status = '<span class="label label-danger">Other</span>';
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row->hhno; ?></td>
                                        <td>
                                            <strong><a href="<?php echo base_url() . 'index.php/tpvics/members/' . $row->cluster_code . '/' . $row->hhno . '/1'; ?>"
                                                       class="name"
                                                       target="_blank"><?php echo $status; ?></a></strong>
                                        </td>
                                    </tr>
                                    <?php $i = $i + 1;
                                } ?>
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
            buttons: ['excel', 'csv'],
            "pageLength": 50,
            "scrollX": true,
            "ordering": true,
        });

    });
</script>