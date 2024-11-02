<button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_doctor');?>');" 
    class="btn btn-primary pull-right">
        <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_doctor'); ?>
</button>
<div style="clear:both;"></div>


<button onclick="exportTableToExcel('table-2')" class="btn btn-success pull-right">
    <i class="fa fa-download"></i>&nbsp;<?php echo get_phrase('excel'); ?>
</button>
<br>

<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('image');?></th>
            <th><?php echo get_phrase('name');?></th>
            <th><?php echo get_phrase('email');?></th>
            <th><?php echo get_phrase('phone');?></th>
            <th><?php echo get_phrase('department');?></th>
            <th><?php echo get_phrase('options');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($doctor_info as $row) { ?>   
            <tr>
                <td>
                    <img src="<?php echo $this->crud_model->get_image_url('doctor' , $row['doctor_id']);?>" 
                         class="img-circle" width="40px" height="40px">
                </td>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['phone']?></td>
                <td>
                    <?php $name = $this->db->get_where('department' , array('department_id' => $row['department_id'] ))->row()->name;
                        echo $name;?>
                </td>
                <td>
                    <a  onclick="showAjaxModal('<?php echo site_url('modal/popup/edit_doctor/'.$row['doctor_id']);?>');" 
                        class="btn btn-info btn-sm">
                        <i class="fa fa-pencil"></i>&nbsp;<?php echo get_phrase('edit');?>
                    </a>
                    <a onclick="confirm_modal('<?php echo site_url('admin/doctor/delete/'.$row['doctor_id']); ?>')"
                        class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-o"></i>&nbsp;<?php echo get_phrase('delete');?>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

   

    <script>
        $(document).ready(function() {
            $('#table-2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel',
                    'csv'
                ]
            });
        });
    </script>

<script type="text/javascript">
    jQuery(window).load(function ()
    {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Highlighted rows
        $("#table-2 tbody input[type=checkbox]").each(function (i, el)
        {
            var $this = $(el),
                    $p = $this.closest('tr');

            $(el).on('change', function ()
            {
                var is_checked = $this.is(':checked');

                $p[is_checked ? 'addClass' : 'removeClass']('highlight');
            });
        });

        // Replace Checboxes
        $(".pagination a").click(function (ev)
        {
            replaceCheckboxes();
        });
    });
</script>



<script type="text/javascript">
   function exportTableToExcel(tableID) {
  var table = document.getElementById(tableID);
  var filename = 'data_export_' + Date.now() + '.xls';

  var downloadLink;
  var dataType = 'application/vnd.ms-excel';

  var tableData = table.outerHTML.replace(/ /g, '%20');

  // Create download link element
  downloadLink = document.createElement('a');
  document.body.appendChild(downloadLink);

  if (navigator.msSaveOrOpenBlob) {
    var blob = new Blob(['\ufeff', tableData], {
      type: dataType
    });
    navigator.msSaveOrOpenBlob(blob, filename);
  } else {
    // Create a data URI
    var hrefData = 'data:' + dataType + ', ' + tableData;

    // Set the download link href
    downloadLink.href = hrefData;

    // Set the file name
    downloadLink.download = filename;

    // Trigger the download
    downloadLink.click();
  }
}

</script>

