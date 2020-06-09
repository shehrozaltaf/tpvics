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
                            <h3 class="box-title">Data Collection Progress</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-blue">
                                            <?php $target_clusters = 0;
                                            if (isset($clusters_by_district) && $clusters_by_district != '') {
                                                foreach ($clusters_by_district as $row) {
                                                    $target_clusters += $row['clusters_by_district'];
                                                }
                                            } ?>
                                            <h2><?php echo $target_clusters; ?></h2>
                                            <h4>Target Clusters</h4>
                                        </div>
                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <?php if (isset($clusters_by_district) && $clusters_by_district != '') {
                                                        foreach ($clusters_by_district as $row) { ?>
                                                            <li>
                                                                <a href="#"><strong><?php echo $row['district']; ?></strong><span
                                                                            class="pull-right badge bg-blue"><?php echo $row['clusters_by_district']; ?></span></a>
                                                            </li>
                                                        <?php }
                                                    } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <!-- /.widget-user -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-orange">
                                            <?php $randomized_c = 0;
                                            foreach ($randomized_clusters->result() as $row3) {
                                                $randomized_c = $randomized_c + $row3->randomized_c;
                                            } ?>
                                            <h2><?php echo $randomized_c; ?></h2>
                                            <h4>Randomized Clusters</h4>
                                        </div>
                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <?php foreach ($randomized_clusters->result() as $row4) {
                                                        if ($row4->dist_id == 1) {
                                                            $district2 = 'KHYBER PAKHTUNKHWA';
                                                        } elseif ($row4->dist_id == 2) {
                                                            $district2 = 'Punjab';
                                                        } else if ($row4->dist_id == 3) {
                                                            $district2 = 'Sindh';
                                                        } else if ($row4->dist_id == 4) {
                                                            $district2 = 'BALOCHISTAN';
                                                        } else if ($row4->dist_id == 7) {
                                                            $district2 = 'GILGIT BALTISTAN';
                                                        } else if ($row4->dist_id == 9) {
                                                            $district2 = 'ADJACENT AREAS-FR';
                                                        }
                                                        ?>
                                                        <li>
                                                            <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/rc_d' . $row4->dist_id; ?>"><strong><?php echo $district2; ?></strong><span
                                                                        class="pull-right badge bg-orange"><?php echo $row4->randomized_c; ?></span></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <!-- /.widget-user -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-3">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-green">
                                            <h2><?php echo $cc_total; ?></h2>
                                            <h4>Completed Clusters</h4>
                                        </div>
                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/cc_d1'; ?>"><strong>KHYBER
                                                                PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $cc_d1; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/cc_d2'; ?>"><strong>Punjab</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $cc_d2; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/cc_d3'; ?>"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $cc_d3; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/cc_d4'; ?>"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $cc_d4; ?></span></a>
                                                    </li>
                                                    <!-- <li>
                                                        <a href="<?php /*echo base_url() . 'index.php/tpvics/dashboard/cc_d7'; */ ?>"><strong>GILGIT
                                                                BALTISTAN</strong><span
                                                                    class="pull-right badge bg-green"><?php /*echo $cc_d7; */ ?></span></a>
                                                    </li>-->
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/cc_d9'; ?>"><strong>ADJACENT
                                                                AREAS-FR</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $cc_d9; ?></span></a>
                                                    </li>
                                                    <!--
                                                    <li>
                                                        <a href="<?php /*echo base_url() . 'index.php/tpvics/dashboard/cc_d2'; */ ?>"><strong>Punjab</strong><span
                                                                    class="pull-right badge bg-green"><?php /*echo $cc_d2; */ ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php /*echo base_url() . 'index.php/tpvics/dashboard/cc_d3'; */ ?>"><strong>Sindh</strong><span
                                                                    class="pull-right badge bg-green"><?php /*echo $cc_d3; */ ?></span></a>
                                                    </li>-->
                                                </ul>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <!-- /.widget-user -->
                                </div>
                                <!-- /.col -->


                                <div class="col-md-3">
                                    <!-- Widget: user widget style 1 -->
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-red">
                                            <h2><?php echo $rc_total; ?></h2>
                                            <h4>Remaining Clusters</h4>
                                        </div>

                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/rc_d1'; ?>"><strong>KHYBER
                                                                PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $rc_d1; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/rc_d2'; ?>"><strong>Punjab</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $rc_d2; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/rc_d3'; ?>"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $rc_d3; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/rc_d4'; ?>"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $rc_d4; ?></span></a>
                                                    </li>
                                                    <!-- <li>
                                                        <a href="<?php /*echo base_url() . 'index.php/tpvics/dashboard/rc_d7'; */ ?>"><strong>GILGIT
                                                                BALTISTAN</strong><span
                                                                    class="pull-right badge bg-red"><?php /*echo $rc_d7; */ ?></span></a>
                                                    </li>-->
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/dashboard/rc_d9'; ?>"><strong>ADJACENT
                                                                AREAS-FR</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $rc_d9; ?></span></a>
                                                    </li>
                                                    <!--<li>
                                                        <a href="<?php /*echo base_url() . 'index.php/tpvics/dashboard/rc_d2'; */ ?>"><strong>Punjab</strong><span
                                                                    class="pull-right badge bg-red"><?php /*echo $rc_d2; */ ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php /*echo base_url() . 'index.php/tpvics/dashboard/rc_d3'; */ ?>"><strong>Sindh</strong><span
                                                                    class="pull-right badge bg-red"><?php /*echo $rc_d3; */ ?></span></a>
                                                    </li>-->
                                                </ul>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <!-- /.widget-user -->
                                </div>
                                <!-- /.col -->


                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">List of Clusters</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table id="get_list" class="table table-bordered table-responsive" width="100%">

                                <thead>
                                <tr>
                                    <th>Province</th>
                                    <th>District</th>
                                    <th>Cluster Number</th>
                                    <th>Randomized Forms</th>
                                    <th>Collected Forms</th>
                                    <th>Completed</th>
                                    <th>Refused</th>
                                    <th>Other</th>
                                    <th>Status</th>
                                </tr>
                                </thead>

                                <tbody>

                                <?php

                                foreach ($get_list->result() as $row5) {

                                    $get_geoarea = $this->tpvics->query("select geoarea from clusters where cluster_no = '$row5->hh02'")->row()->geoarea;
                                    $explode = explode("|", $get_geoarea);
                                    $division = ltrim(rtrim($explode[1]));
                                    if ($row5->enumcode == 1) {
                                        $province = 'Khyber Paktunkhwa';
                                    } elseif ($row5->enumcode == 2) {
                                        $province = 'Punjab';
                                    } elseif ($row5->enumcode == 3) {
                                        $province = 'Sindh';
                                    } elseif ($row5->enumcode == 4) {
                                        $province = 'Balochistan';
                                    } elseif ($row5->enumcode == 7) {
                                        $province = 'Gilgit Baltistan';
                                    } elseif ($row5->enumcode == 9) {
                                        $province = 'Adjacent Areas-FR';
                                    } else {
                                        $province = ltrim(rtrim($explode[0]));
                                    }

                                    if (($row5->eligible_households > 25 and $row5->randomized_households < 25 and $row5->randomized_households != 0) || $row5->randomized_households > 25) {
                                        $bgcolor = '#E74C3C';
                                    } else {
                                        $bgcolor = '';
                                    }

                                    if ($row5->randomized_households > 0) {
                                        if ($row5->collected_forms == 0) {
                                            $status = '<span class="label label-info">Pending</span>';
                                        } else if ($row5->collected_forms > 0 and $row5->collected_forms < 30) {
                                            $status = '<span class="label label-danger">In Progress</span>';
                                        } else {
                                            $status = '<span class="label label-success">Completed</span>';
                                        }
                                    } else {
                                        $status = '<span class="label label-warning">Not Randomized</span>';
                                    }

                                    ?>

                                    <tr>
                                        <td><?php echo $province; ?></td>
                                        <td><?php echo $division; ?></td>
                                        <td><?php echo $row5->hh02; ?></td>
                                        <td>
                                            <strong><a href="<?php echo base_url() . 'index.php/Tpvics/randomized_households/' . $row5->hh02; ?>"
                                                       class="name"
                                                       target="_blank"><?php echo $row5->randomized_households; ?></a></strong>
                                        </td>
                                        <td>
                                            <strong><a href="<?php echo base_url() . 'index.php/Tpvics/randomized_households/' . $row5->hh02; ?>"
                                                       class="name"
                                                       target="_blank"><?php echo $row5->collected_forms; ?></a></strong>
                                        </td>
                                        <td><?php echo $row5->completed_forms; ?></td>
                                        <td><?php echo $row5->refused_forms; ?></td>
                                        <td><?php echo $row5->remaining_forms; ?></td>
                                        <!-- <td>
                                            <strong><a href="<?php /*echo base_url() . 'index.php/tpvics/cluster_progress/' . $row5->hh02; */ ?>"
                                                       class="name"
                                                       target="_blank"><?php /*echo $row5->collected_households; */ ?></a></strong>
                                        </td>
                                        <td><?php /*echo $row5->completed_tabs; */ ?></td>-->
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
        });

    });
</script>