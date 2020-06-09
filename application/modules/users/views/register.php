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
                <small></small>
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <!--<div class="box-header">
                          <h3 class="box-title">Data Table With Full Features</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-3"></div>
                            <div class="col-md-6">
                                <?= validation_errors("<p style='color:red;'>", "</p>") ?>
                                <?php if (validation_errors()) { ?>
                                    <hr style="border: none; height: 5px;color: #333;background-color:red;"><?php } ?>
                                <?php echo form_open_multipart("index.php/Users/register"); ?>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control" required
                                               placeholder="Full Name"
                                               value="<?php echo set_value('full_name', $this->session->userdata('full_name')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Username</label>
                                        <input type="text" name="username" id="username" class="form-control" required
                                               placeholder="Username"
                                               value="<?php echo set_value('username', $this->session->userdata('username')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">District Id</label>
                                        <input type="text" name="dist_id" id="dist_id" class="form-control" required
                                               placeholder="District Id"
                                               value="<?php echo set_value('dist_id', $this->session->userdata('dist_id')); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Designation</label>
                                        <input type="text" name="designation" id="designation" class="form-control"
                                               placeholder="Designation"
                                               value="<?php echo set_value('designation', $this->session->userdata('designation')); ?>">
                                    </div>
                                    <div class="input-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                               required
                                               placeholder="Password">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default reveal" type="button"
                                                    style="margin-top:25px;"><i
                                                        class="glyphicon glyphicon-eye-open"></i></button>
                                        </span>
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <label class="control-label">Confirm Password</label>
                                        <input type="password" name="passwordagain" id="passwordagain" required
                                               class="form-control" placeholder="Password Again">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default reveal2" type="button"
                                                    style="margin-top:25px;"><i
                                                        class="glyphicon glyphicon-eye-open"></i></button>
                                        </span>
                                    </div>
                                    <!--<div class="form-group" style="display:none" id="app_div">
                                      <label>App:</label>
                                      <select class="form-control select2" name="app[]" multiple id="user_app" style="width:100%;">
                                          <option value="1">Lisitng</option>
                                          <option value="2">Survey App</option>
                                      </select>
                                    </div>-->
                                </div>
                                <div class="box-footer">
                                    <?php echo form_submit('submit', "Register User", 'class="btn btn-primary"'); ?>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="col-sm-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php echo $this->load->view('includes/footer'); ?>
</div>
<?php echo $this->load->view('includes/scripts'); ?>
<script>
    $(function () {
        $(".reveal").on('click', function () {
            var $pwd = $("#password");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });
        $(".reveal2").on('click', function () {
            var $pwd2 = $("#passwordagain");
            if ($pwd2.attr('type') === 'password') {
                $pwd2.attr('type', 'text');
            } else {
                $pwd2.attr('type', 'password');
            }
        });
        $('#example1').DataTable();
        $('.select2').select2();
        $("#type").change(function () {
            var type = $("#type").val();
            if (type == 2 || type == 3) {
                $('#app_div').css('display', 'block');
            } else {
                $('#app_div').css('display', 'none');
                $('#user_app').select2().select2('val', '0');
            }
        });
    });
</script>