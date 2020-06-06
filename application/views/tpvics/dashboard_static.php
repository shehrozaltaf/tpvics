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
                                            <?php $total_clusters = 0;
                                            if (isset($clusters_by_district) && $clusters_by_district != '') {
                                                foreach ($clusters_by_district as $row) {
                                                    $total_clusters = $total_clusters + $row['clusters_by_district'];
                                                }
                                            }
                                            $total_clusters = 8786;
                                            ?>
                                            <h2><?php echo $total_clusters; ?></h2>
                                            <h4>Target Clusters</h4>
                                        </div>

                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>AZAD
                                                                JAMMU & KASHMIR</strong><span
                                                                    class="pull-right badge bg-blue">580</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-blue">2112</span></a>
                                                    </li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>GILGIT-BALTISTAN</strong><span
                                                                    class="pull-right badge bg-blue">433</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>KHYBER
                                                                PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-blue">1853</span></a>
                                                    </li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>PUNJAB</strong><span
                                                                    class="pull-right badge bg-blue">1839</span></a>
                                                    </li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>ISLAMABAD</strong><span
                                                                    class="pull-right badge bg-blue">113</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-blue">1856</span></a>
                                                    </li>

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
                                            <?php $randomized_c = 0; ?>
                                            <h2><?php echo $randomized_c; ?></h2>
                                            <h4>Randomized Clusters</h4>
                                        </div>

                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>AZAD
                                                                JAMMU & KASHMIR</strong><span
                                                                    class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>GILGIT-BALTISTAN</strong><span
                                                                    class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>KHYBER
                                                                PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>PUNJAB</strong><span
                                                                    class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>ISLAMABAD</strong><span
                                                                    class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-orange">0</span></a></li>
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
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>AZAD
                                                                JAMMU & KASHMIR</strong><span
                                                                    class="pull-right badge bg-green">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-green">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>GILGIT-BALTISTAN</strong><span
                                                                    class="pull-right badge bg-green">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>KHYBER
                                                                PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-green">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>PUNJAB</strong><span
                                                                    class="pull-right badge bg-green">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>ISLAMABAD</strong><span
                                                                    class="pull-right badge bg-green">0</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-green">0</span></a></li>
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
                                            <h2><?php echo 8786; ?></h2>
                                            <h4>Remaining Clusters</h4>
                                        </div>

                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>AZAD
                                                                JAMMU & KASHMIR</strong><span
                                                                    class="pull-right badge bg-red">580</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-red">2112</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>GILGIT-BALTISTAN</strong><span
                                                                    class="pull-right badge bg-red">433</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>KHYBER
                                                                PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-red">1853</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>PUNJAB</strong><span
                                                                    class="pull-right badge bg-red">1839</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>ISLAMABAD</strong><span
                                                                    class="pull-right badge bg-red">113</span></a></li>
                                                    <li><a href="<?php echo base_url() . 'tpvics/dashboard' ?>"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-red">1856</span></a></li>
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
                                    <th>Division</th>
                                    <th>Cluster Number</th>
                                    <th>Total Structures</th>
                                    <th>Residential Structures</th>
                                    <th>Total Households</th>
                                    <th>Eligible Households</th>
                                    <th>Randomized Forms</th>
                                    <th>Collected Forms</th>
                                    <th>Status</th>

                                </tr>
                                </thead>

                                <tbody>

                                <?php

                                foreach ($get_list->result() as $row5) {

                                    if ($row5->enumcode == 1) {
                                        $province = 'AZAD JAMMU & KASHMIR';
                                    } else if ($row5->enumcode == 2) {
                                        $province = 'PUNJAB';
                                    } else if ($row5->enumcode == 3) {
                                        $province = 'SINDH';
                                    } else if ($row5->enumcode == 4) {
                                        $province = 'BALOCHISTAN';
                                    } else if ($row5->enumcode == 5) {
                                        $province = 'FATA';
                                    } else if ($row5->enumcode == 6) {
                                        $province = 'FEDERAL CAPITAL';
                                    } else if ($row5->enumcode == 7) {
                                        $province = 'GILGIT BALTISTAN';
                                    } else if ($row5->enumcode == 8) {
                                        $province = 'AZAD JAMMU';
                                    } else if ($row5->enumcode == 9) {
                                        $province = 'ADJACENT AREAS-FR';
                                    } else {
                                        $province = '';
                                    }

                                    if (($row5->eligible_households > 25 and $row5->randomized_households < 25 and $row5->randomized_households != 0) || $row5->randomized_households > 25) {
                                        $bgcolor = '#E74C3C';
                                    } else {
                                        $bgcolor = '';
                                    }

                                    if ($row5->randomized_households > 0) {

                                        if ($row5->collected_households == 0) {
                                            $status = '<span class="label label-info">Not Attempted</span>';
                                        } else if ($row5->collected_households > 0 and $row5->collected_households < 20) {
                                            $status = '<span class="label label-danger">Pending</span>';
                                        } else {
                                            $status = '<span class="label label-success">Completed</span>';
                                        }

                                    } else {
                                        $status = '<span class="label label-warning">Not Randomized</span>';
                                    }

                                    $get_geoarea = $this->scans->query("select geoarea from clusters where cluster_no = '$row5->hh02'")->row()->geoarea;
                                    $explode = explode("|", $get_geoarea);
                                    $division = ltrim(rtrim($explode[1]));
                                    ?>
                                    <tr>
                                        <td><?php echo $province; ?></td>
                                        <td><?php echo $division; ?></td>
                                        <td><?php echo $row5->hh02; ?></td>
                                        <td><?php echo $row5->structures; ?></td>
                                        <td><?php echo $row5->residential_structures; ?></td>
                                        <td><?php echo $row5->households; ?></td>
                                        <td><?php echo $row5->eligible_households; ?></td>
                                        <td><?php echo $row5->randomized_households; ?></a></strong></td>
                                        <td>
                                            <strong><a href="<?php echo base_url() . 'tpvics/cluster_progress/' . $row5->hh02; ?>"
                                                       class="name"
                                                       target="_blank"><?php echo $row5->collected_households; ?></a></strong>
                                        </td>
                                        <td><?php echo $status; ?></td>

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
            buttons: ['excel', 'csv'],
            "scrollX": true,
            "ordering": false,
        });

    });
</script>