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
                            <h3 class="box-title">Line Listing Progress</h3>
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
                                            ?>
                                            <h2><?php echo $total_clusters; ?></h2>
                                            <h4>Total Clusters</h4>
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
                                        <div class="widget-user-header bg-green">
                                            <h2><?php echo $gt_c ?></h2>
                                            <h4>Completed Clusters</h4>
                                        </div>

                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d1_c'; ?>"><strong>KHYBER
                                                                PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $d1_c; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d2_c'; ?>"><strong>PUNJAB</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $d2_c; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d3_c'; ?>"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $d3_c; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d4_c'; ?>"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $d4_c; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d7_c'; ?>"><strong>GILGIT
                                                                BALTISTAN</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $d7_c; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d8_c'; ?>"><strong>AZAD
                                                                JAMMU AND KASHMIR</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $d8_c; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d9_c'; ?>"><strong>ADJACENT
                                                                AREAS-FR</strong><span
                                                                    class="pull-right badge bg-green"><?php echo $d9_c; ?></span></a>
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
                                            <h2><?php echo $gt_ip ?></h2>
                                            <h4>In Progress Clusters</h4>
                                        </div>
                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <!-- <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>AZAD JAMMU & KASHMIR</strong><span class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>BALOCHISTAN</strong><span class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>GILGIT-BALTISTAN</strong><span class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>KHYBER PAKHTUNKHWA</strong><span class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>PUNJAB</strong><span class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>ISLAMABAD</strong><span class="pull-right badge bg-orange">0</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>SINDH</strong><span class="pull-right badge bg-orange">0</span></a></li>-->
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d1_ip'; ?>"><strong>KHYBER
                                                                PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-orange"><?php echo $d1_ip; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d2_ip'; ?>"><strong>PUNJAB</strong><span
                                                                    class="pull-right badge bg-orange"><?php echo $d2_ip; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d3_ip'; ?>"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-orange"><?php echo $d3_ip; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d4_ip'; ?>"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-orange"><?php echo $d4_ip; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d7_ip'; ?>"><strong>GILGIT
                                                                BALTISTAN</strong><span
                                                                    class="pull-right badge bg-orange"><?php echo $d7_ip; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d8_ip'; ?>"><strong>AZAD
                                                                JAMMU AND KASHMIR</strong><span
                                                                    class="pull-right badge bg-orange"><?php echo $d8_ip; ?></span></a>
                                                    </li>

                                                    <li>
                                                        <a href="<?php echo base_url() . 'index.php/tpvics/index/d9_ip'; ?>"><strong>ADJACENT
                                                                AREAS-FR</strong><span
                                                                    class="pull-right badge bg-orange"><?php echo $d9_ip; ?></span></a>
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
                                        <div class="widget-user-header bg-red">
                                            <h2><?php echo $gt_r; ?></h2>
                                            <h4>Remaining Clusters</h4>
                                        </div>
                                        <?php if ($this->users->in_group('admin') || $this->users->in_group('management')) { ?>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <!-- <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>AZAD JAMMU & KASHMIR</strong><span class="pull-right badge bg-red">580</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>BALOCHISTAN</strong><span class="pull-right badge bg-red">2112</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>GILGIT-BALTISTAN</strong><span class="pull-right badge bg-red">433</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>KHYBER PAKHTUNKHWA</strong><span class="pull-right badge bg-red">1853</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>PUNJAB</strong><span class="pull-right badge bg-red">1839</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>ISLAMABAD</strong><span class="pull-right badge bg-red">113</span></a></li>
                                                    <li><a href="<?php /*echo base_url().'tpvics/dashboard'*/ ?>"><strong>SINDH</strong><span class="pull-right badge bg-red">1856</span></a></li>-->
                                                    <li><a href="#"><strong>KHYBER PAKHTUNKHWA</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $d1_r; ?></span></a>
                                                    </li>
                                                    <li><a href="#"><strong>PUNJAB</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $d2_r; ?></span></a>
                                                    </li>
                                                    <li><a href="#"><strong>SINDH</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $d3_r; ?></span></a>
                                                    </li>
                                                    <li><a href="#"><strong>BALOCHISTAN</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $d4_r; ?></span></a>
                                                    </li>
                                                    <li><a href="#"><strong>GILGIT BALTISTAN</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $d7_r; ?></span></a>
                                                    </li>
                                                    <li><a href="#"><strong>AZAD
                                                                JAMMU AND KASHMIR</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $d8_r; ?></span></a>
                                                    </li>
                                                    <li><a href="#"><strong>ADJACENT AREAS-FR</strong><span
                                                                    class="pull-right badge bg-red"><?php echo $d9_r; ?></span></a>
                                                    </li>
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
                            <h3 class="box-title">List of Completed and In Progress Clusters</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table id="get_list" class="table table-bordered table-striped table-responsive"
                                   width="100%">

                                <thead>
                                <tr>
                                    <th>Province</th>
                                    <th>District</th>
                                    <th>Cluster Number</th>
                                    <th>Total Structures</th>
                                    <th>Residential Structures</th>
                                    <th>HH Targeted Children</th>
                                    <th>Children 12-23 Months</th>
                                    <th>Collecting Tabs</th>
                                    <th>Completed Tabs</th>
                                    <th>Status</th>

                                    <?php if ((!empty($this->uri->segment(3)) and substr($this->uri->segment(3), 3, 1) == 'c')) { ?>
                                        <th width="15%">Randomize</th>
                                    <?php } ?>

                                </tr>
                                </thead>

                                <tbody>

                                <?php

                                foreach ($get_list->result() as $row2) {
                                    $get_geoarea = $this->tpvics->query("select geoarea from clusters where cluster_no = '$row2->hh02'")->row()->geoarea;
                                    $explode = explode("|", $get_geoarea);
                                    $division = ltrim(rtrim($explode[1]));

                                    if ($row2->enumcode == 1) {
                                        $province = 'Khyber Paktunkhwa';
                                    } elseif ($row2->enumcode == 2) {
                                        $province = 'Punjab';
                                    } elseif ($row2->enumcode == 3) {
                                        $province = 'Sindh';
                                    } elseif ($row2->enumcode == 4) {
                                        $province = 'Balochistan';
                                    } elseif ($row2->enumcode == 7) {
                                        $province = 'Gilgit Baltistan';
                                    } elseif ($row2->enumcode == 8) {
                                        $province = 'AZAD JAMMU AND KASHMIR';
                                    } elseif ($row2->enumcode == 9) {
                                        $province = 'Adjacent Areas-FR';
                                    } else {
                                        $province = ltrim(rtrim($explode[0]));
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $province; ?></td>
                                        <td><?php echo $division; ?></td>
                                        <td><?php echo $row2->hh02; ?></td>
                                        <td><?php echo $row2->structures; ?></td>
                                        <td><?php echo $row2->residential_structures; ?></td>
                                        <td><?php echo $row2->target_children; ?></td>
                                        <td><?php if (isset($row2->no_of_children) && $row2->no_of_children != '') {
                                                echo $row2->no_of_children;
                                            } else {
                                                echo '0';
                                            } ?></td>
                                        <td><?php echo $row2->collecting_tabs; ?></td>
                                        <td><?php echo $row2->completed_tabs; ?></td>
                                        <td><?php
                                            $rand_show = '';
                                            foreach ($status as $s_key => $stat) {
                                                if ($s_key == $row2->hh02) {
                                                    echo $stat;
                                                    if ($rand_show != 'Randomized') {
                                                        $rand_show = 'true';
                                                    }

                                                }

                                            } ?></td>

                                        <?php if ((!empty($this->uri->segment(3)) and substr($this->uri->segment(3), 3, 1) == 'c')) {
                                            $cluster = $this->tpvics->query("select randomized from clusters where cluster_no = '$row2->hh02'")->row();
                                            if ($this->users->in_group('admin') || $this->users->in_group('management')) {
                                                $anchor = anchor("index.php/Tpvics/systematic_randomizer/" . $row2->hh02 . "/" . $this->uri->segment(3), '<i class="fa fa-edit"></i> Randomize', 'class="btn-sm btn-primary"');
                                            } else {
                                                $anchor = anchor("index.php/Tpvics/systematic_randomizer/" . $row2->hh02, '<i class="fa fa-edit"></i> Randomize', 'class="btn-sm btn-primary"');
                                            }
                                            ?>
                                            <td><?php if ($cluster->randomized == 0 && $rand_show == 'true') {
                                                    echo $anchor;
                                                } else {
                                                    echo anchor("index.php/tpvics/make_pdf/" . $row2->hh02, '<i class="fa fa-print"></i> Print', ['target' => '_blank', 'class' => 'btn-sm btn-success']);
                                                    echo "|";
                                                    echo anchor("index.php/tpvics/get_excel/" . $row2->hh02, '<i class="fa fa-print"></i> Get Excel', ['target' => '_blank', 'class' => 'btn-sm btn-success']);
                                                } ?></td>
                                        <?php } ?>

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
        });

    });
</script>