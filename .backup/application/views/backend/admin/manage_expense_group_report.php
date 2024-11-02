<!--Added on 12-06-2023-->
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">-->
<!--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">-->
<!--<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>-->
<!--<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>-->
<!--Added on 12-06-2023-->
<?php if ($this->input->post()) {
    $fdate = date('m/d/Y', strtotime($date_from));
    $tdate = date('m/d/Y', strtotime($date_to));
} else {
    $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
} ?>
<div class="row">
    <form action="<?php echo site_url('admin/expense_group_report'); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-3" id="fromdate">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Date From(<span style="color:#14b914">m/d/y</span>) <span style="color:red">*</span></label>
                <input id="date_from" name="date_from" placeholder="" type="text" class="form-control datepicker" value="<?php echo $fdate; ?>" />
            </div>
        </div>

        <div class="col-md-3" id="todate">
            <div class="form-group">
                <label class="control-label" style="margin-bottom: 11px;">Date To(<span style="color:#14b914">m/d/y</span>) <span style="color:red">*</span></label>
                <input id="date_to" name="date_to" placeholder="" type="text" class="form-control datepicker" value="<?php echo $tdate; ?>" />
            </div>
        </div>

        <div class="col-md-3" style="margin-top: 30px;">
            <button type="submit" class="btn btn-info">Search</button>
        </div>
    </form>
</div>
<div style="clear:both;"></div>
<div align="center">
    <?php
    if ($this->input->post()) {
    ?>
        <h4 style="color:#818da1;">Showing Results From <span style="color:#14b914"><?php echo date('d-m-Y', strtotime($date_from)) ?></span> To <span style="color:#14b914"><?php echo date('d-m-Y', strtotime($date_to)); ?></span></h4>
     <?php } else{?>
         <h4 style="color:#818da1;">Showing Results For <span style="color:#14b914"><?php echo date('d-m-Y') ?></span> </h4>
  <?php  }
  ?>
</div>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th>Expense Head</th>
           
            <th>Name</th>
            <th>Date</th>
            <th>Invoice Number</th>
            <th>Amount(Rs.)</th>                       
        </tr>        
    </thead>

    <tbody>
        <?php 
                if ($this->input->post()) {
            $dateFrom = date('Y-m-d', strtotime($date_from));
            $dateTo = date('Y-m-d', strtotime($date_to));
        } else {
            $dateFrom = date("Y-m-d");
            $dateTo = date("Y-m-d");
        }
        
        // Filter the income array based on the selected date range
        $filteredExpense = array_filter($expense, function($row) use ($dateFrom, $dateTo) {
            $rowDate = date("Y-m-d", strtotime($row['date']));
            return ($rowDate >= $dateFrom && $rowDate <= $dateTo);
        });
        
        $count = 1;
        $grand_total = 0;
        foreach ($filteredExpense as $row) {
            
       
            $grand_total = $grand_total + $row['amount'];
            ?>   
            <tr>
                <td><?php echo $row['expense_head_name']?></td>
               
                <td><?php echo $row['name']?></td>
                <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                <td><?php echo $row['invoice_no']?></td>
                <td><?php echo $row['amount']?></td>                
            </tr>
        <?php
        $count++;
     } ?>
    </tbody>
    <tfoot>
        <tr>
            <td style=" border-right-style:hidden"></td>
            <td style=" border-right-style:hidden;border-left-style:hidden"></td>
           
            <td style=" border-left-style:hidden;border-right-style:hidden;"></td>
            <td style="border-left-style:hidden;text-align:right;font-weight:bold;color:#000">Grand Total :</td>
            <td style="font-weight:bold;color:#000"><?php echo ("Rs. " . number_format($grand_total, 2, '.', '')); ?>
            </td>
        </tr>
    </tfoot>
</table>
<!--<script>
$(document).ready(function() {
    $('#table-2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            
        ]
    } );
} );
</script>-->
<script type="text/javascript">
     jQuery(document).ready(function() {
    var $ = jQuery;

    var table = $("#table-2").DataTable({
        "sPaginationType": "bootstrap",
        "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0, 1, 2, 3, 4]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0, 1, 2, 3, 4]
    }
}
        ]
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

    // Replace Checkboxes
    $(".pagination a").click(function(ev) {
        replaceCheckboxes();
    });

    // Manually add the Buttons to the DataTables layout
    table.buttons().container()
        .appendTo('.export-data'); // Replace '.export-data' with the appropriate selector for the container element where you want the buttons to appear
});
</script>