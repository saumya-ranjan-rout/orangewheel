<button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_pathology_patient_report'); ?>');" class="btn btn-primary pull-right">
    <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_patient_report'); ?>
</button>
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('patient_name'); ?></th>
            <th><?php echo get_phrase('test_name'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
            <th><?php echo get_phrase('description'); ?></th>
            <th><?php echo get_phrase('doctor'); ?></th>
            <th><?php echo get_phrase('charge(_rs_)'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($pathology_patient_report_info as $row) { ?>
            <tr>
                <td><?php echo $row['patient_name'] ?></td>
                <td><?php echo $row['test_name']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['doctor_name'] ?></td>
                <td><?php echo $row['charge']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
                <td>
                    <?php if ($row['attachment']) {
                    ?>
                        <a href="<?php echo base_url(); ?>uploads/pathology_patient_report_attachment/<?php echo $row['upload_name'] ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?php echo $this->lang->line('download'); ?>">
                            <i class="fa fa-download"></i>
                        </a>
                    <?php }
                    ?>
                    <a onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_pathology_patient_report/' . $row['id']); ?>');" class="btn btn-info btn-sm">
                        <i class="fa fa-pencil"></i>&nbsp;
                        <?php echo get_phrase('edit'); ?>
                    </a>
                    
                     
                    <a onclick="print('<?php echo $row['id']; ?>')" class="btn btn-primary btn-sm">
                        <i class="fa fa-print"></i>&nbsp;
                        <?php echo get_phrase('print'); ?>
                    </a>

                    <!--<a onclick="showAjaxModal('<?php echo site_url('modal/popup/view_pathology_report/' . $row['id']); ?>');" class="btn btn-default btn-sm">-->
                    <!--    <i class="fa fa-eye"></i> &nbsp;-->
                    <!--    <?php echo get_phrase('view_report'); ?>-->
                    <!--</a>-->

                    <a onclick="confirm_modal('<?php echo site_url('admin/pathology_patient_report/delete/' . $row['id']); ?>')" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-o"></i>&nbsp;
                        <?php echo get_phrase('delete'); ?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(window).load(function() {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function(i, el) {
            var $this = $(el),
                $p = $this.closest('tr');

            $(el).on('change', function() {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checboxes
        $(".pagination a").click(function(ev) {
            replaceCheckboxes();
        });
    });
</script>
<script type="text/javascript">
    function print(id) {
        //alert(id);

        $.ajax({
            url: '<?php echo site_url('admin/getReport/'); ?>' + id,
            success: function(response) {

                popup(response);
            }
        });
    }


    function popup(data) {
        var base_url = '<?php echo base_url() ?>';
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({
            "position": "absolute",
            "top": "-1000000px"
        });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        // frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function() {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            window.location.reload(true);
        }, 500);

        return true;
    }
</script>