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
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form Skip Questions</h3>
                        </div>
                        <div class="box-body">
                            <table id="get_list" class="table table-bordered table-responsive" width="100%">
                                <thead>
                                <tr>
                                    <?php foreach ($get_list[0] as $k => $r) { ?>
                                        <th><?php if ($k == 'SkipPecentage') {
                                                echo 'Skip Pecentage';
                                            } else {
                                                echo strtoupper($k);
                                            } ?>
                                        </th>

                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($get_list as $key => $rows) { ?>
                                    <tr>
                                        <?php foreach ($rows as $k => $r) { ?>
                                            <td> <?php if ($k == 'username' || $k == 'total') {
                                                    echo $r;
                                                } else {
                                                    echo $r . '%';
                                                } ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Child Skip Questions</h3>
                        </div>
                        <div class="box-body">
                            <table id="get_list_child" class="table table-bordered table-responsive" width="100%">
                                <thead>
                                <tr>
                                    <?php foreach ($get_list_childs[0] as $k => $r) { ?>
                                        <th><?php if ($k == 'SkipPecentage') {
                                                echo 'Skip Pecentage';
                                            } else {
                                                echo strtoupper($k);
                                            } ?></th>

                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($get_list_childs as $key => $rows) { ?>
                                    <tr>
                                        <?php foreach ($rows as $k => $r) { ?>
                                            <td><?php if ($k == 'username' || $k == 'total') {
                                                    echo $r;
                                                } else {
                                                    echo $r . '%';
                                                } ?></td>

                                        <?php } ?>
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
            "ordering": true,
        });
        $('#get_list_child').DataTable({
            responsive: true,
            dom: '<"top"Bfrt<"clear">>rt<"bottom"ilp>',
            buttons: ['excel', 'csv'],
            "scrollX": true,
            "ordering": true,
        });

    });
</script>