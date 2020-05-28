<?php
$this->load->module('users');
$user = $this->users->get_user();
?>

<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>districts/dashboard" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>TPVICS</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>TPVICS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url(); ?>files/profile_images/pictures/emp.png" class="user-image">
                        <span class="hidden-xs"><?php echo $user->full_name; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo base_url(); ?>files/profile_images/pictures/emp.png"
                                 class="img-circle">

                            <p>
                                <?php echo $user->full_name; ?> - <?php echo $user->designation; ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url(); ?>index.php/users/edit_user/<?php echo $user->id; ?>"
                                   class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url(); ?>index.php/users/logout"
                                   class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>