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
                            <h3 class="box-title">TPVICS Sync Report</h3>
                        </div>
                        <div class="box-body">
                            <table id="get_list" class="table table-bordered table-responsive" width="100%">
                                <thead>
                                <tr>
                                    <?php foreach ($get_list[0] as $k => $r) { ?>
                                        <th><?php echo strtoupper($k); ?></th>

                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($get_list as $key => $rows) {
                                    $cluster = $rows->Cluster;
                                    $FormDate = $rows->FormDate;
                                    ?>
                                    <tr>
                                        <td onclick="getHousehold(this)" data-cluster="<?php echo $cluster ?>"
                                            data-formDate="<?php echo $FormDate ?>"><?php echo $cluster ?></td>
                                        <td><?php echo $FormDate ?></td>
                                        <td><?php echo $rows->Synced; ?></td>
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

<!-- Modal -->
<div class="modal fade" id="clusterModal" tabindex="-1" role="dialog" aria-labelledby="clusterModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clusterModalLabel">Cluster Data</h5>
                <p>Cluster: <span class="cluster_text"></span>, FormDate: <span class="formdate_text"></span></p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <h4>Households</h4>
                <ul class="body_text" style="list-style: decimal;"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- ./wrapper -->
<?php echo $this->load->view('includes/scripts'); ?>
<!-- page script -->
<script>

    function getHousehold(obj) {
        var cluster = $(obj).attr('data-cluster');
        var formDate = $(obj).attr('data-formDate');
        if (cluster != undefined && cluster != '' && formDate != undefined && formDate != '') {
            $('.cluster_text').text(cluster);
            $('.formdate_text').text(formDate);

            $('#clusterModal').modal('show');
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/Tpvics/getHousehold',
                data: 'cluster=' + cluster + '&formDate=' + formDate,
                method: 'POST',
                success: function (res) {
                    var items = '';
                    if (res != '' && JSON.parse(res).length > 0) {
                        var response = JSON.parse(res);
                        try {
                            $.each(response, function (i, v) {
                                items += '<li>' + v.hhno + '</li>';
                            })
                        } catch (e) {
                        }
                    }
                    $('.body_text').html(items);
                }

            })
        } else {
            alert('Invalid Cluster');
        }
    }

    $(document).ready(function () {
        var table = $('#get_list').DataTable({
            responsive: true,
            dom: '<"top"Bfrt<"clear">>rt<"bottom"ilp>',
            buttons: ['excel', 'csv'],
            "pageLength": 25,
            "scrollX": true,
            "ordering": true,
            "order": [[1, "desc"]]

        });

    });
</script>