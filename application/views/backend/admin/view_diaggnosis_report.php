<?php
$date=date('Y-m-d');
$conditions = array(
    'patient_id' => $param2,
    'date' => $date
);
//$edit_data = $this->db->get_where('patient_diagnosis', $conditions)->result_array();

$this->db->select('patient_diagnosis.*,payment_mode.payment_mode')->from('patient_diagnosis');
$this->db->join('payment_mode', 'patient_diagnosis.payment_mode_id = payment_mode.id', 'left');
$this->db->where($conditions);
$query = $this->db->get();
$edit_data = $query->result_array();
foreach ($edit_data as $row):
?>
<style>

    .footer-image {
        display: none;
    }

    @media print {
        .footer-image {
            display: block;
            position: fixed;
            bottom: 20px;
            left: 0;
            width: 100%;
            height: 80px;
            background-repeat: no-repeat;
            background-position: bottom left;
        }
    }
.watermark {
    position: fixed;
    top: 55%;
    left: 55%;
    transform: translate(-50%, -50%);
    opacity: 0.4;
    z-index: -1;
    pointer-events: none;
    width: 100%;
    height: 100%;
}

    }
</style>
    <div id="invoice_print">

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
                      <b> <?php echo $row['payment_status']; ?></b>
                </td>
                <td align="right" valign="top" style="width: 45%;">
                  <!--   Bill No:<?php  echo $row['bill_no'];?><br> -->
               
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
                   
                    <th><?php echo 'Discount'; ?></th>
                     <th><?php echo get_phrase('total_price'); ?></th>

                </tr>
            </thead>

            <tbody>
                <!-- INVOICE ENTRY STARTS HERE-->
            <div id="invoice_entry">
                <?php
              
                $i                  = 1;
                $diagnosis          = json_decode($row['diagnosis_id']);
                    foreach ($diagnosis as $row2) {
                            $this->db->select('diagnosis.name as diagnosis_name')->from('diagnosis');
                        $this->db->where('diagnosis.id', $row2->diagnosis_id);
                        $query2 = $this->db->get();
                        $diagnosis_info = $query2->row_array();
?>

              
                    <tr>
                        <td align="center"><?php echo $i++; ?></td>
                        <td align="left"><?php echo $diagnosis_info['diagnosis_name']; ?></td>
                         <td align="center"><?php echo $row2->quantity; ?></td>
                          <td align="center"><?php echo $row2->diagnosis_price; ?></td>
                         
                            <td align="center"><?php echo $row2->discount_price; ?></td>
                             <td align="right"><?php echo $row2->total_price; ?></td>
                        
                    </tr>
               <?php } ?>
            </div>
            <!-- INVOICE ENTRY ENDS HERE-->
            </tbody>
        </table><br><br>
        <table width="100%" border="0">
            <tr>
                <td align="right" width="90%"><h4><?php echo get_phrase('graind_total'); ?> :</h4></td>
              <td align="right"><h4> <?php if($row['sum_total_price'] == Null){ echo"Nil";}else{ echo "₹ ".$row['sum_total_price'];} ?> </h4></td>
            </tr>
             
        </table>

        <div class="footer-image">
            <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%"/>
        </div>

        <!-- Watermark -->
        <div class="watermark">
            <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%"/>
        </div>

    </div>
    <br>

    <a onClick="PrintElem('#invoice_print')" class="btn btn-primary hidden-print">
        <i class="fa fa-print"></i> &nbsp;
        <?php echo get_phrase('print');?>
    </a>
    <br><br>

<?php endforeach; ?>

<!-- <script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Invoice</title>');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url('assets/css/neon-theme.css');?>" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url('assets/js/datatables/responsive/css/datatables.responsive.css');?>" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script> -->
<script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function PrintElem(elem) {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Medicine Sale Invoice</title>');
        mywindow.document.write('<style type="text/css">');
        mywindow.document.write('@media print {');
        mywindow.document.write('.footer-image {');
        mywindow.document.write('position: fixed;');
        mywindow.document.write('bottom: 20px;');
        mywindow.document.write('left: 0;');
        mywindow.document.write('width: 100%;');
        mywindow.document.write('height: 80px;');
        mywindow.document.write('background-repeat: no-repeat;');
        mywindow.document.write('background-position: bottom left;');
        mywindow.document.write('}');
        mywindow.document.write('.watermark {');
        mywindow.document.write('position: fixed;');
        mywindow.document.write('top: 55%;');
        mywindow.document.write('left: 55%;');
        mywindow.document.write('width: 100%;');
        mywindow.document.write('transform: translate(-50%, -50%);');
        mywindow.document.write('opacity: 0.1;');
        mywindow.document.write('}');
        mywindow.document.write('.hidden-print {');
        mywindow.document.write('display: none;');
        mywindow.document.write('}');
        mywindow.document.write('}');
        mywindow.document.write('</style>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<div class="footer-image"></div>');
        mywindow.document.write('<div class="watermark"></div>');
        mywindow.document.write($(elem).html());
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>


