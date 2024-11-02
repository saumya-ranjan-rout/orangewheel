<?php //$insertedId=1; ?>

<table width="100%" border="0">
    <tr>
    <td ><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>"  style="height:100px; width:100%;" class="img-responsive"/></td>
    <td align="right"></td>
    </tr>
    </table>
    <hr>
    
     <table width="100%" border="0">
             <tr>
        <td align="left" valign="top" class="left-column">
            Patient Id: <?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->code; ?><br>
            Patient Name: <?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->name; ?><br>
            Address: <?php $res=$this->db->get_where('patient', array('patient_id' => $insertedId))->row(); echo $res->current_street.",".$res->current_city."<br>".$res->current_state.",".$res->current_postalcode; ?><br>
            Phone: <?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->phone; ?><br>
        </td>
         <td align="" valign="top" class="">
           Age: <?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->age; ?><br>
            Sex: <?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->sex; ?><br>
            Weight: <?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->weight; ?><br>
        </td>
        <td align="right" valign="top" class="right-column">
          <?php
$visitType = $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->visit_type;

$walkInChecked = '';
$appointmentChecked = '';
if ($visitType === 'walk-in') {
    $walkInChecked = 'checked';
} elseif ($visitType === 'appointment') {
    $appointmentChecked = 'checked';
}
?>
            Date: <?php echo date('d/m/Y'); ?><br>
             <label for="vehicle1"> Walk In</label>
  <input type="checkbox" id="visit_type" name="visit_type" <?php echo $walkInChecked; ?>><br>
   <label for="vehicle1">Appointment </label>
  <input type="checkbox" id="visit_type" name="visit_type" <?php echo $appointmentChecked; ?>><br>
        </td>
    </tr>
    
   <!-- <tr>
        <td align="left" valign="top" class="left-column">
            Patient Id: <?php echo $this->db->get_where('patient', array('patient_id' =>$insertedId))->row()->code; ?><br>
            Patient Name: <?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->name; ?><br>
            Phone: <?php echo $this->db->get_where('patient', array('patient_id' =>$insertedId))->row()->phone; ?><br>
        </td>
        <td align="right" valign="top" class="right-column">
            Current Address: <?php $res=$this->db->get_where('patient', array('patient_id' => $insertedId))->row(); echo $res->current_street.",".$res->current_city.",".$res->current_state.",".$res->current_postalcode; ?><br>
            Age: <?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->age; ?><br>
            Date: <?php echo date('d/m/Y'); ?><br>
        </td>
    </tr>-->
</table>
      <hr>
    
    
  <!--  <table width="100%" border="0">    
 
    <tr>
    <td align="left" valign="top" style="width: 50%;">
    Patient Id:<?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->code; ?><br>
    <hr>Time:<?php echo date('Y-m-d H:i:s'); ?><br>
  <hr> Blood Group:<?php echo $this->db->select('blood_bank.blood_group')->from('blood_bank')->join('patient', 'blood_bank.blood_group_id = patient.blood_group')->where('patient.patient_id',$insertedId)->get()->row()->blood_group; ?><br>            
   <br> Current Address:<?php $res=$this->db->get_where('patient', array('patient_id' => $insertedId))->row(); echo $res->current_street.",".$res->current_city.",".$res->current_state.",".$res->current_postalcode; ?><br>

</td>
    <td align="right" valign="top" style="width: 50%;">
    Name:<?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->name; ?><br>
   <hr> Phone:<?php echo $this->db->get_where('patient', array('patient_id' => $insertedId))->row()->phone; ?><br>
   <hr> Permanent Address:<?php $res=$this->db->get_where('patient', array('patient_id' => $insertedId))->row(); echo $res->permanent_street.",".$res->permanent_city.",".$res->permanent_state.",".$res->permanent_postalcode; ?><br>
    </td>
    </tr>
    </table>-->
    
    
    
    <div class="footer-image">
    <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%"/>
    </div>
    <div class="watermark">
    <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%"/>
    </div>
    