<!--delete option add in timeline<br>
if delete it will delete from 2nd table and updatefollowup date to last follow up date or to 00000000<br>
design left side with css<br>
-->
<style>
.events-list {
  width: 100%;
  font-size: 0.9em;
}

.events-list tr td {
  padding: 5px 20px 5px 0;
}

.events-list tr td:last-child {
  padding: 5px 0;
  text-align: right;
}

.events-list tr:hover .event-date {
  border-left: 5px solid #4f8db3;
}

.events-list .event-date {
  margin: 3px 0;
  padding: 2px 10px;
  border-left: 5px solid #CFCFCF;
  -webkit-transition: all .25s linear;
  -moz-transition: all .25s linear;
  -o-transition: all .25s linear;
  -ms-transition: all .25s linear;
  transition: all .25s linear;
}

.events-list .event-date .event-day {
  color: #004A5B;
  font-size: 1.2em;
  font-weight: 600;
  text-align: left;
}

.events-list .event-date .event-month {
  color: #777;
  font-size: 1em;
  font-weight: 600;
  text-align: left;
}

.events-list .event-date .event-venue,
.events-list .event-date .event-price {
  white-space: nowrap;
}
</style>
<div style="clear:both;"></div>
<br>
<div class="row">

 <div class="col-sm-4" style="border: 1px solid #ccc;">
    <div class="blog-post blog-single-post">
        <div class="single-post-title">
            <h2>Upcoming Followup</h2>
        </div>
        <div class="single-post-content" style="height: 720px; overflow-y: auto;">
            <table class="events-list">
                <?php
                $current_date = date('Y-m-d'); // Get today's date

                $this->db->order_by('followup_date', 'asc');
                $patient_issues = $this->db->where('issue_type', 'invoice')->get('patient_item_issue')->result_array();

                $patient_details = []; // Array to store patient details
  $has_followups = false; // Flag to track if there are any follow-up schedules

                foreach ($patient_issues as $row) {
                    $models = json_decode($row['models'], true);

                    if (!empty($models)) {
                        foreach ($models as $model) {
                            $model_info = $this->db->get_where('item', array('id' => $model['model_id'], 'hearing_accessories' => 1))->row();
                        }

                        $followup_date = ($row['followup_date'] == '0000-00-00') ? date('Y-m-d', strtotime($row['invoice_date'] . ' +15 days')) : $row['followup_date'];

                        if ($followup_date >= $current_date) {
                            $new_month = date('M', strtotime($followup_date));
                            $new_day = date('d', strtotime($followup_date));

                            // Fetch patient details if not already fetched
                            if (!isset($patient_details[$row['patient_id']])) {
                                $patient_details[$row['patient_id']] = $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row();
                            }

                            $patient_name = $patient_details[$row['patient_id']]->name;
                            $patient_phone = $patient_details[$row['patient_id']]->phone;
   $has_followups = true; 
                            ?>
                            <tr>
                                <td>
                                    <div class="event-date">
                                        <div class="event-day"><?php echo $new_day; ?></div>
                                        <div class="event-month"><?php echo $new_month; ?></div>
                                    </div>
                                </td>
                                <td><?php echo $row['bill_no'] ;
                                
                             $this->db->order_by('id', 'desc');
$this->db->where('item_issue_id', $row['id']);
$this->db->limit(1);
$follow = $this->db->get('next_followup')->row();
 $f=$follow->created_date;
 $fn=$follow->next_followup_date;
if($f == $fn){
    echo '<br><span style="color:green">Follow up done</span>';
}


?>
                                
                                </td>
                                <td class="event-venue hidden-xs">
                                    <?php echo $patient_name; ?><br>
                                    <?php echo $patient_phone; ?>
                                </td>
                               <td>
                                    <a <?php echo ($followup_date == $current_date) ? 'onclick="showAjaxModal(\'' . site_url('modal/popup/add_followup/' . $row['id']) . '\');" ' : ''; ?>>
                                        <i class="fa fa-phone" title="<?php echo ($followup_date == $current_date) ? 'Call' : 'Modal will open on next follow up date'; ?>" style="color: <?php echo ($followup_date == $current_date) ? 'green' : 'red'; ?>"></i>
                                    </a>
                                    
                                    
                                    
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }

                // If there are no follow-up schedules, display "No follow-up schedule"
                if (empty($patient_issues) || !$has_followups) {
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: red; font-weight: bold; font-size: 16px;">....No follow-up Schedule....</td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>


 <div class="col-sm-8">
   <center> <h3> <b >Hearning Accessories List</b></h3> </center>
     <table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th style="width: 67px;">#</th>
            <th><?php echo get_phrase('invoice_no'); ?></th>
            <th><?php echo get_phrase('models'); ?></th>
            <th><?php echo get_phrase('patient'); ?></th>
             <th><?php echo get_phrase('phone'); ?></th>
            <th><?php echo get_phrase('issue_date'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>

    <tbody>
      <?php
         $current_date1 = date('Y-m-d'); // Get today's date

$counter1        = 1;
$this->db->order_by('id', 'desc');
$patient_issues1 = $this->db->where('issue_type', 'invoice')->get('patient_item_issue')->result_array();
  $patient_details1 = [];
foreach ($patient_issues1 as $row1) {
    $models1 = json_decode($row1['models'], true);
   $hearing_accessories1 = [];
 foreach ($models1 as $model1) {
        $model_info1 = $this->db->get_where('item', array('id' => $model1['model_id'], 'hearing_accessories' => 1))->row();
        if ($model_info1) {
            $hearing_accessories1[] = $model_info1->model;
        }
    }

    $followup_date1 = ($row1['followup_date'] == '0000-00-00') ? date('Y-m-d') : $row1['followup_date'];

    
       // $new_date = date('Y-m-d', strtotime($inv_date . ' +15 days'));
       
       
       
        
        
    if (!isset($patient_details1[$row1['patient_id']])) {
                                $patient_details1[$row1['patient_id']] = $this->db->get_where('patient', array('patient_id' => $row1['patient_id']))->row();
                            }

                            $patient_name1 = $patient_details1[$row1['patient_id']]->name;
                            $patient_phone1 = $patient_details1[$row1['patient_id']]->phone;
    // If there are any hearing accessories, display them in one row
    if (!empty($hearing_accessories1)) {
?>
        <tr>
            <td><?php echo $counter1++; ?></td>
            <td><?php echo $row1['bill_no'] ?></td>
            <td>
                <div>
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: center;">
                                <?php echo implode(', ', $hearing_accessories1); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td>
                <?php echo $patient_name1; ?>
            </td>
             <td>
                <?php echo $patient_phone1; ?>
            </td>
            <td>
              <?php echo $row1['invoice_date'] ?>
            </td>
            <td>
              
                <a onclick="showAjaxModal('<?php echo site_url('modal/popup/followup_timeline/' . $row1['id']); ?>');"  class="btn btn-primary" title="timeline">
                    <i class="fa fa-eye"></i>
                </a>
              
                    
                  <a <?php echo ($followup_date1 == $current_date1 || $followup_date1 == '0000-00-00' ) ? 'onclick="showAjaxModal(\'' . site_url('modal/popup/add_followup/' . $row1['id']) . '\');" ' : ''; ?> class="btn btn-<?php echo ($followup_date1 == $current_date1 || $followup_date1 == '0000-00-00' ) ? 'success' : ($followup_date1 < $current_date1 ? 'warning' : 'danger'); ?>">
    <i class="fa fa-pencil" title="<?php echo ($followup_date1 == $current_date1 || $followup_date1 == '0000-00-00' ) ? 'Call' : ($followup_date1 < $current_date1 ? 'Stopped follow up' : 'Modal will open on next follow up date'); ?>"></i>
</a>


                    
                  
            </td>
        </tr>
<?php
    }
}
?>

    </tbody>
</table>

        </div> 
    
    </div>
    





<script type="text/javascript">
    jQuery(document).ready(function($) {
        var outerTable = $("#table-2").DataTable({
            "sPaginationType": "bootstrap",
            "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            buttons: [{
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: {
                        columns: [0, 1,2, 3, 4, 5],
                        format: {
                            body: function(data, row, column, node) {
                                if ($(node).hasClass("child")) {
                                    return $(node).text().trim();
                                } else {
                                    return $(node).text().trim();
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1,2, 3, 4, 5],
                        format: {
                            body: function(data, row, column, node) {
                                if ($(node).hasClass("child")) {
                                    return '';
                                } else {
                                    return $(node).text().trim();
                                }
                            }
                        }
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: 'Csv',
                    exportOptions: {
                         columns: [0, 1,2, 3, 4, 5],
                        format: {
                            body: function(data, row, column, node) {
                                if ($(node).hasClass("child")) {
                                    return '';
                                } else {
                                    return $(node).text().trim();
                                }
                            }
                        }
                    }
                }
            ]
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });
    });
</script>