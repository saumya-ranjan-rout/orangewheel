
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th><?php echo get_phrase('Name'); ?></th>
            <th><?php echo get_phrase('Code'); ?></th>
            <th><?php echo get_phrase('Follow-up Date'); ?></th>
        </tr>
    </thead>

    <tbody>
        <?php   $prescription_notification = $this->db->get('prescription')->result_array();
        foreach ($prescription_notification as $row) { 
              $follow_up_date = date('Y-m-d', $row["follow_up"]);
                $today = date('Y-m-d');
           if($follow_up_date >= $today){
                 $patient_row = $this->db->get_where('patient', array('patient_id' => $rw["patient_id"]))->row_array();
           ?>
            <tr>
                <td><?php echo $patient_row['name'] ?></td>
                <td><?php echo $patient_row['code'] ?></td>
                <td>
                  <?php echo $follow_up_date; ?>  
                </td>
            </tr>
        <?php 
        }
        }
        ?>
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