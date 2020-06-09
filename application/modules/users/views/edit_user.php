<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
    <?php echo $this->load->view('includes/header'); ?>
    <?php echo $this->load->view('includes/sidebar'); ?>
    <div class="content-wrapper">
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
                        <div class="box-body">
                            <div class="col-sm-3"></div>
                            <div class="col-md-6">
                                <?= validation_errors("<p style='color:red;'>", "</p>") ?>
                                <?php if (validation_errors()) { ?>
                                    <hr style="border: none; height: 5px;color: #333;background-color:red;"><?php } ?>
                                <?php echo form_open(current_url()); ?>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="control-label">Username</label>
                                        <input type="text" name="username" id="username" class="form-control"
                                               placeholder="Username" value="<?php echo $user->username; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control"
                                               placeholder="Full Name" value="<?php echo $user->full_name; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">District Id</label>
                                        <input type="text" name="dist_id" id="dist_id" class="form-control"
                                               placeholder="District Id" value="<?php echo $user->dist_id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Designation</label>
                                        <input type="text" name="designation" id="designation" class="form-control"
                                               placeholder="Designation" value="<?php echo $user->designation; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="text" name="password" id="password" class="form-control"
                                               placeholder="Password" value="<?php echo $user->password; ?>">
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <?php echo form_submit('submit', "Save User", 'class="btn btn-primary"'); ?>
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
        $('#example1').DataTable();
        $('.select2').select2();
        $("#type").change(function () {
            var type = $("#type").val();
            if (type == 2 || type == 3) {
                $('#app_div').css('display', 'block');
            } else {
                $('#app_div').css('display', 'none');
                //$('#user_app').find('option:eq(0)').prop('selected', true);
                $('#user_app').select2().select2('val', '0');
            }
        });
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })

    });
</script>