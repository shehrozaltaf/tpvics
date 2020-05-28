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
                            <h3 class="box-title">Upload Excel</h3>
                        </div>

                        <form id="document_form" method="post"
                              onsubmit="return false" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="idTable">Select Table</label>
                                    <select class="form-control" id="idTable" name="idTable" required>
                                        <option value="0" readonly="readonly">Select Table</option>
                                        <?php if (isset($get_table) && $get_table != '') {
                                            foreach ($get_table as $key => $values) {
                                                echo '<option value="' . $values . '">' . $values . '</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="document_file">Upload File</label>
                                    <input type="file"
                                           name="document_file"
                                           id="document_file"
                                           required aria-describedby="document_file_addon">
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary mybtn" onclick="addData()">Submit</button>
                            </div>

                        </form>
                        <div class=" box-body response">
                            <h4 class="res_heading"></h4>
                            <p class="res_msg"></p>
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

<script src="<?php echo base_url(); ?>assets/core.js"></script>

<script>
    $(document).ready(function () {
        $('#document_file').change(function () {
            $('#document_label').text(this.files[0].name);
        });

    });

    function addData() {
        $('#idTable').css('border', '1px solid #babfc7');
        $('#document_file').css('border', '1px solid #babfc7');
        var flag = 0;
        var data = {};
        data['idTable'] = $('#idTable').val();
        data['document_file'] = $('#document_file').val();
        if (data['idTable'] == '' || data['idTable'] == undefined) {
            $('#idTable').css('border', '1px solid red');
            alert('Invalid Project');
            flag = 1;
            return false;
        }

        if (data['document_file'] == '' || data['document_file'] == undefined) {
            $('#document_file').css('border', '1px solid red');
            alert('Invalid File');
            flag = 1;
            return false;
        }

        if (flag == 0) {
            $('.res_heading').html('');
            $('.res_msg').html('');
            $('.mybtn').attr('disabled', 'disabled');
            var formData = new FormData($("#document_form")[0]);
            CallAjax('<?php echo base_url('index.php/Tpvics/addExcelData')?>', formData, 'POST', function (result) {
                $('.mybtn').removeAttr('disabled', 'disabled');
                try {
                    var response = JSON.parse(result);
                    console.log(response);
                    if (response[0] == 'Success') {

                        $('.res_heading').html(response[0]).css('color', 'green');
                        $('.res_msg').html(response[1]).css('color', 'green');
                    } else {
                        $('.res_heading').html(response[0]).css('color', 'red');
                        $('.res_msg').html(response[1].message).css('color', 'red');
                    }

                } catch (e) {
                }
            }, true);
        }
    }
</script>
