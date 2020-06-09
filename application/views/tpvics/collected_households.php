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
                        <div class="box-body">
                            <table id="get_list" class="table table-bordered table-responsive" width="100%">
                                <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Hosuehold No</th>
                                    <th>Members</th>
                                    <th>MWRAs</th>
                                    <th>Under 5 Children</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $this->load->model('master_model');
                                $i = 1;
                                foreach ($get_list->result() as $row) {
                                    $get_members = $this->master_model->get_members($row->cluster_code, $row->hhno);
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row->hhno; ?></td>
                                        <td>
                                            <strong><a href="<?php echo base_url() . 'spc/members/' . $row->cluster_code . '/' . $row->hhno . '/1'; ?>"
                                                       class="name"
                                                       target="_blank"><?php echo $get_members[0]['members']; ?></a></strong>
                                        </td>
                                        <td>
                                            <strong><a href="<?php echo base_url() . 'spc/members/' . $row->cluster_code . '/' . $row->hhno . '/2'; ?>"
                                                       class="name"
                                                       target="_blank"><?php echo $get_members[0]['mwra']; ?></a></strong>
                                        </td>
                                        <td>
                                            <strong><a href="<?php echo base_url() . 'spc/members/' . $row->cluster_code . '/' . $row->hhno . '/3'; ?>"
                                                       class="name"
                                                       target="_blank"><?php echo $get_members[0]['under5_children']; ?></a></strong>
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