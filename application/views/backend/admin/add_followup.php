
<?php

$query = $this->db->get_where('patient_item_issue', array('id' => $param2))->result_array();
foreach ($query as $row) {
  $models = json_decode($row['models'], true);
   $hearing_accessories = [];
 foreach ($models as $model) {
        $model_info = $this->db->get_where('item', array('id' => $model['model_id'], 'hearing_accessories' => 1))->row();
        if ($model_info) {
            $hearing_accessories[] = $model_info->model;
        }
    }
  $fdate = date("m/d/Y");
    $tdate = date("m/d/Y");
?>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('Add Phone Call Log Details'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/add_followup/'.$row['id']); ?>" 
                        method="post" enctype="multipart/form-data">
<input type="hidden" name="item_issue_id" class="form-control"   value="<?php echo $row['id'];?>">


 <table  class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <tbody>
                <tr>
                    <td width='32%'>Invoice No.<br><b><?php echo $row['bill_no']; ?></b></td>
                    <td width='18%'>Dated<br><b><?php echo date("d-m-Y", strtotime($row['invoice_date'])); ?></b></td>
                    <td width='35%'>Name<br><b><?php  echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name;?></b></td>
                    <td width='15%'>Phone<br><b><?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->phone;?></b></td>
                    
                </tr>
                  <tr>
                 <td colspan="4">Models &nbsp;:&nbsp;&nbsp;<b>   <?php echo implode(', ', $hearing_accessories); ?></b></td>
                </tr>
            </tbody>
        </table>
     
     
     
     
   
   
         
                        <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date'); ?></label>

                            <div class="col-sm-5">
                              
                                 <input id="date_from" name="date" placeholder="" type="text" class="form-control datepicker" value="<?php echo $fdate; ?>"  required/>
                            </div>
                        </div>
 
           
                        
                        <label class="container">
   Do you want to Stop Follow Up?
    <input type="checkbox" name="stop" value="1" id="stop_follow_up">
       <span class="item-text">Yes</span>
   
</label>

<div class="form-group answer" >
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('next follow up date'); ?> <small style="color:red;">*</small></label>
    <div class="col-sm-5">
        <input id="date_to" name="followup_date" placeholder="" type="text" class="form-control datepicker" value="<?php echo $tdate; ?>" required/>
    </div>
</div>


 <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('call_by'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-5">
                                <input type="text" name="call_by" class="form-control"  placeholder="Name"required>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('call from contact no'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-5">
                                <input type="tel" name="contact" class="form-control" placeholder="phone no" required>
                            </div>
                        </div>
                        
                        
                        
                        
                         <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('call_duration'); ?></label>

                            <div class="col-sm-5">
                                <input type="text" name="call_duration" class="form-control" placeholder="call duration" >
                            </div>
                        </div>
                    
                         <div class="form-group">
                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('note'); ?> <small style="color:red;">*</small></label>

                            <div class="col-sm-9">
                               
                                 <textarea name="note" class="form-control html5editor" id="field-ta" rows="5" required
                       data-stylesheet-url="<?php echo base_url();?>assets/css/wysihtml5-color.css"> </textarea>
                       
                            </div>
                        </div>
                       
                        <div class="col-sm-3 control-label col-sm-offset-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> <?php echo get_phrase('add');?>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>


$(".answer").show();
$("#stop_follow_up").click(function() {
    if($(this).is(":checked")) {
        $(".answer").hide();
    } else {
        $(".answer").show();
    }
});
</script>

