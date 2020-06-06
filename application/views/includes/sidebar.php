<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url(); ?>files/profile_images/pictures/emp.png" class="img-circle">
            </div>
            <div class="pull-left info">
                <!--<p>Ali Khan</p>-->
            </div>
        </div>
        <!-- Other Navigation -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header" style=" font-size:20px;font-weight:900;color:#FFFFFF; text-shadow:#99FF66;">Navigation
            </li>
            <li <?php if ($this->uri->segment(1) == 'Tpvics' and $this->uri->segment(2) == 'index') { ?> class="active" <?php } ?>>
                <a href="<?php echo base_url(); ?>index.php/Tpvics/index"><i class="fa fa-bar-chart"></i> <span>Linelisting Progress</span></a>
            </li>
            <li <?php if ($this->uri->segment(1) == 'Tpvics' and $this->uri->segment(2) == 'sync_report') { ?> class="active" <?php } ?>>
                <a href="<?php echo base_url(); ?>index.php/Tpvics/sync_report"><i class="fa fa-bar-chart"></i> <span>Survey Report</span></a>
            </li>
            <li <?php if ($this->uri->segment(1) == 'Tpvics' and $this->uri->segment(2) == 'dashboard') { ?> class="active" <?php } ?>>
                <a href="<?php echo base_url(); ?>index.php/Tpvics/dashboard"><i class="fa fa-bar-chart"></i> <span>Data Collection Progress</span></a>
            </li>
            <li <?php if ($this->uri->segment(1) == 'Tpvics' and $this->uri->segment(2) == 'dashboard') { ?> class="active" <?php } ?>>
                <a href="<?php echo base_url(); ?>index.php/Tpvics/skipQuestions"><i class="fa fa-bar-chart"></i> <span>Skip Questions</span></a>
            </li>




            <!--   <li <?php /*if ($this->uri->segment(1) == 'tpvics' and $this->uri->segment(2) == 'add_five') { */ ?> class="active" <?php /*} */ ?>>
                <a href="<?php /*echo base_url(); */ ?>index.php/tpvics/add_five"><i class="fa fa-bar-chart"></i>
                    <span>Add 5 Cases</span></a></li>-->

            <?php if ($this->users->in_group('admin')) { ?>

                <li <?php if ($this->uri->segment(1) == 'Tpvics' and $this->uri->segment(2) == 'upload_excel_data') { ?> class="active" <?php } ?>>
                    <a href="<?php echo base_url(); ?>index.php/Tpvics/upload_excel_data"><i
                                class="fa fa-bar-chart"></i> <span>Upload Data</span></a>
                </li>


                <li <?php if ($this->uri->segment(1) == 'users'){ ?>class="treeview active"
                    <?php } else { ?>class="treeview" <?php } ?>>

                    <a href="#"><i class="fa fa-group"></i> User Management
                        <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">

                        <li <?php if ($this->uri->segment(2) == 'index') { ?> class="active" <?php } ?>><a
                                    href="<?php echo base_url(); ?>index.php/users/index"><i class="fa fa-user"></i>
                                <span>View Users</span></a>
                        </li>
                        <li <?php if ($this->uri->segment(2) == 'register') { ?> class="active" <?php } ?>><a
                                    href="<?php echo base_url(); ?>index.php/users/register"><i class="fa fa-user"></i>
                                <span>Create User</span></a>
                        </li>

                        <li <?php if ($this->uri->segment(2) == 'create_group') { ?> class="active" <?php } ?>><a
                                    href="<?php echo base_url(); ?>index.php/users/create_group"><i
                                        class="fa fa-user"></i> <span>Create Group</span></a>
                        </li>


                    </ul>
                </li>
            <?php } ?>


        </ul>

    </section>
    <!-- /.sidebar -->
</aside>