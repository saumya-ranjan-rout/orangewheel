<?php
$date=date('d-m-Y');
$conditions = array(
    'patient_id' => $insertedId,
    'date' => $date
);
$edit_data = $this->db->get_where('patient_consultation_history', $conditions)->result_array();
foreach ($edit_data as $row):
?>

 

        <table width="100%" border="0">
            <tr>
                <td ><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>"  style="height:100px; width:100%;" class="img-responsive"/></td>
                <td align="right"></td>
            </tr>
        </table>
        <hr>
        <table width="100%" border="0">    
            <tr>
                <td align="left"><h4><?php echo get_phrase('payment_to'); ?> </h4></td>
                <td align="right"><h4><?php echo get_phrase('bill_to'); ?> </h4></td>
            </tr>

            <tr>
                <td align="left" valign="top" style="width: 55%;">
                    <?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                    <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br>            
                </td>
                <td align="right" valign="top" style="width: 45%;">
                  <!--   Bill No:<?php  echo $row['bill_no'];?><br> -->
                   <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->code; ?><br>
                    <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name; ?><br>
                    <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->current_street; ?><br>
                    <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->phone; ?><br>
                      <?php echo date('d/m/Y');?><br>
                </td>
            </tr>
        </table>
        <hr>
       <!--  <h4><?php echo get_phrase('medicines'); ?></h4> -->
        <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th width="40%"><?php echo get_phrase('name'); ?></th>
                    <th><?php echo get_phrase('quantity'); ?></th>
                    <th><?php echo get_phrase('price'); ?></th>
                    <th><?php echo get_phrase('discount_type'); ?></th>
                    <th><?php echo get_phrase('discount_price'); ?>/%</th>

                </tr>
            </thead>

            <tbody>
                <!-- INVOICE ENTRY STARTS HERE-->
            <div id="invoice_entry">
                <?php
              
                $i                  = 1;
?>

              
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td>
                            <?php
                          //  $medicine_info = $this->db->get_where('medicine', array('medicine_id' => $row2->medicine_id))->row();
                           // echo $medicine_info->name;
                          echo $row['consultation_name']; ?>
                        </td>
                        <td align="center">
                            <?php echo $row['qty']; ?>
                        </td>
                        <td align="center">
                            <?php echo $row['price']; ?>
                        </td>
                         <td align="center">
                            <?php echo $row['discount_type']; ?>
                        </td>
                         <td class="text-right" align="right">
                            <?php echo $row['discount_price']; ?>
                        </td>
                    </tr>
               
            </div>
            <!-- INVOICE ENTRY ENDS HERE-->
            </tbody>
        </table>
        <table width="100%" border="0">
            <tr>
                <td align="right" width="90%"><h4><?php echo get_phrase('total_price'); ?> :</h4></td>
                
                <?php if($row['total_price'] == '0.00'){?>
                    <td align="right"><h4>NIL </h4></td>
           <?php     } else{ ?>
            <td align="right"><h4>₹ <?php echo $row['total_price']; ?> </h4></td>
         <?php }   ?>
                
            </tr>
        </table>

        <div class="footer-image">
            <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%"/>
        </div>

   
        <div class="watermark">
            <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%"/>
        </div>




<?php endforeach; ?>

