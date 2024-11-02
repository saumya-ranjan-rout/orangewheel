<!-- <button onclick="showAjaxModal('<?php echo site_url('modal/popup/add_patient');?>');" 
    class="btn btn-primary pull-right">
        <i class="fa fa-plus"></i>&nbsp;<?php echo get_phrase('add_patient'); ?>
</button> -->
<div style="clear:both;"></div>
<br>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
           
            <th><?php echo get_phrase('Patient Name');?></th>
          
            <th><?php echo get_phrase('Guardian Name');?></th>
            <th><?php echo get_phrase('Gender');?></th>
            <th><?php echo get_phrase('Phone');?></th>
           
            <th><?php echo get_phrase('Last Visit');?></th>
            <th><?php echo get_phrase('Total Visit');?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($patient_info as $row) {
          $this->db->select('*')
            ->from('prescription')
            ->where('patient_id', $row['patient_id']);

        $query = $this->db->get();
        $num = $query->num_rows();
        //
       $this->db->select('*')
            ->from('prescription')
            ->where('patient_id', $row['patient_id'])
            ->order_by('prescription_id', 'DESC')
            ->limit(1);

        $query = $this->db->get();
        $lastvisit = $query->row_array();



         ?>   
            <tr>
                <td>
                     <a style="color:blue;" href="<?php echo site_url('admin/patient_history_details?id='.$row['patient_id'].'&name='.$row['name']);?>">
                      <?php echo $row['name']?>[<?php echo $row['code']?>]
                    </a></td>
                <!-- <td><a  style="color:blue;"href="<?php echo site_url('admin/patient_details');?>"><?php echo $row['name']?></a></td> -->
              
                 <td><?php echo $row['guardian_name']?><br><?php echo $row['guardian_no']?></td>
                <td><?php echo $row['sex']?></td>
                <td><?php echo $row['phone']; ?></td>
             
                <td><?php echo date("d M, Y -  H:i", $row['timestamp']); ?></td>
                <td><?php echo $num; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

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