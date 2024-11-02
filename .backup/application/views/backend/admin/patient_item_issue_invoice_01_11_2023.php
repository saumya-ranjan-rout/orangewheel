<?php
$this->db->select('patient_item_issue.*,payment_mode.payment_mode')->from('patient_item_issue');
$this->db->join('payment_mode', 'patient_item_issue.payment_mode_id = payment_mode.id', 'left');
$this->db->where('patient_item_issue.id', $param2);
$query = $this->db->get();
$edit_data = $query->result_array();


foreach ($edit_data as $row) :
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
    </style>
    <div id="invoice_print">

        <table width="100%" border="0">
            <tr>
                <td><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>" style="height:90px; width:100%;" class="img-responsive" /></td>
                <td align="right"></td>
            </tr>
            <tr>
                <td colspan="14"align="center" ><h3 style="font-family:	Lucida Console;font-weight:bold;">Invoice</h3></td>
               
            </tr>
        </table>
      
 
        <table  class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <tbody>
                <tr>
                    <td colspan="7" rowspan="2" width='50%'>
                        <b><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></b><br>
                        <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                        <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?>
                    </td>
                    <td colspan="7" rowspan="2" width='50%'>Buyer<br>
                        <b><?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name; ?></b><br>
                        <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->current_street; ?><br>
                        <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->phone; ?>
                    </td>
                </tr>
                </tbody>
        </table>
        <table  class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <tbody>
                <tr>
                    <td colspan="4"width='25%'>Invoice No.<br><b><?php echo $row['bill_no']; ?></b></td>
                    <td colspan="4"width='25%'>Dated<br><b><?php echo date("d-m-Y", strtotime($row['invoice_date'])); ?></b></td>
                    <td colspan="4"width='25%'>Mode of Payment<br><b><?php echo $row['payment_mode']; ?></b></td>
                    <td colspan="5"width='25%'>Dispathed Through<br><b><?php echo $row['dispatched_through']; ?></b></td>
                </tr>
                <tr>
                    <!-- <?php if ($row['challan_status'] == 1) { ?>
                        <td>Challan No<br><b><?php echo $row['bill_no']; ?></b><br>
                            Dated<br><b><?php echo date("d-m-Y", strtotime($row['challan_date'])); ?></b>
                        </td>
                        <td>Destination<br><b><?php echo $row['destination']; ?></b></td>
                    <?php } else { ?>
                        <td colspan="2">Destination<br><b><?php echo $row['destination']; ?></b></td>
                    <?php } ?> -->

                    <td colspan="14">Delivery Note&nbsp;:&nbsp;&nbsp;<b><?php echo $row['delivery_note']; ?></b></td>
                </tr>
            </tbody>
        </table>
     
 


        <table  class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;width: 100%; table-layout: fixed;">
            <thead>
                <tr>
                    <th class="text-center" style="overflow: hidden; width: 4%;">Sl No.</th>
                    <th colspan="2" class="text-center" style="overflow: hidden; width: 15%;">Description</th>
                    <th class="text-center" style="overflow: hidden; width: 8%;">Serial No</th>
                    <!-- <th class="text-center">HSN Code</th> -->
                    <th class="text-center" style="overflow: hidden; width: 8%;">Batch</th>
                    <th class="text-center" style=" overflow: hidden; width: 5%;" >Qty</th>
                    <th class="text-center" style="overflow: hidden; width: 5%;">Unit</th>
                    <th class="text-center" style="overflow: hidden; width: 10%;">Price</th>
                    <th class="text-center" style="overflow: hidden; width: 6%;">Disc<br>(%)</th>
                    <th class="text-center" style="overflow: hidden; width: 9%;">Discount</th>
                    <th class="text-center" style="overflow: hidden; width: 5%;">Tax<br>(%)</th>
                    <th class="text-center" style="overflow: hidden; width: 10%;">Tax<br>Amount</th>
                    <th colspan="2" class="text-center" style="overflow: hidden; width: 15%;">Total Amount</th>
                </tr>
            </thead>
            <tbody >
                <!-- INVOICE ENTRY STARTS HERE-->
                <div id="invoice_entry">
                    <?php
                    $i                  = 1;
                    $total_quantity  = 0;
                    $models          = json_decode($row['models']);

                    $tax_row = [];
                    $tax_row_time = [];
                    $tax_row_value = [];
                    $totalamount=0;
                    foreach ($models as $row2) {

                        $this->db->select('item.*,unit.unit_name')->from('item');
                        $this->db->join('unit', 'item.unit = unit.unit_id', 'left');
                        $this->db->where('item.id', $row2->model_id);
                        $query2 = $this->db->get();
                        $model_info = $query2->row_array();
                        $total_quantity += $row2->quantity;


                        //$model_info = $this->db->get_where('item', array('id' => $row2->model_id))->row();
                    ?>
                        <!-- [{"model_id":"2","quantity":"1","price":"649990.00","basic_price":"649990","tax_percentage":"12","tax":"77998.8","total_price":"727988.8"},{"model_id":"3","quantity":"1","price":"424990.00","basic_price":"424990","tax_percentage":"","tax":"0","total_price":"424990"}] -->
                        <tr >
                            <td class="text-center" style="border-bottom: 0;border-top: 0;overflow: hidden; width: 4%;"><?php echo $i++; ?></td>
                            <td colspan="2" style="border-bottom: 0;border-top: 0;overflow: hidden; width: 15%;font-size:12px;"><?php echo $model_info['model']; ?> </td>
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:8%;font-size:12px;"><?php echo $model_info['serial_no']; ?></td>
                            <!-- <td style="border-bottom: 0;border-top: 0;"><?php echo $model_info['hsn_code']; ?></td> -->
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:8%;"><?php echo $model_info['batch_no']; ?></td>
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:5%;"><?php echo $row2->quantity; ?></td>
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:5%;"><?php if($model_info['unit_name'] == "Piece"){ echo "Pcs"; }else{ echo $model_info['unit_name'];} ?></td>
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:10%;"><?php echo $row2->price; ?></td>
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:6%;"><?php if ($row2->discount_percentage > 0) echo $row2->discount_percentage . "%"; ?></td>
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:9%;"><?php echo $row2->discount; ?></td>
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:5%;"><?php if ($row2->tax_percentage > 0) echo $row2->tax_percentage . "%"; ?></td>
                            <td style="border-bottom: 0;border-top: 0;overflow: hidden; width:10%;"><?php  echo $row2->tax; ?></td>
                            <td colspan="2" style="border-bottom: 0;border-top: 0;overflow: hidden; width:15%;"><?php echo $row2->total_price; ?></td>
                        </tr>
                       
                    <?php

     if ($row2->tax_percentage > 0) {
        $tax_percentage = $row2->tax_percentage; // Store the tax percentage for readability
    
        if (in_array($tax_percentage, $tax_row)) {
            // If the tax percentage already exists in $tax_row, find its index and increment the count in $tax_row_time
            $index = array_search($tax_percentage, $tax_row);
            if (isset($tax_row_time[$index])) {
                $tax_row_time[$index]++;
            }
            if (isset($tax_row_value[$index])) {
                $tax_row_value[$index] += $row2->tax;
            }
        } else {
            // If the tax percentage is not in $tax_row, add it to $tax_row and initialize the count in $tax_row_time to 1
            $tax_row[] = $tax_percentage;
            $tax_row_time[] = 1; // Initialize the count to 1
            $tax_row_value[] = $row2->tax; // Initialize the count to 1
        }
    }
    
                  $totalamount+=$row2->total_price;     
                        } ?>





                </div>
                <!-- INVOICE ENTRY ENDS HERE-->
                <?php //if ($row['discount_type']) { ?>
                    <!-- <tr>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td colspan="2" style="border-bottom: 0;border-top: 0;">
                            <?php
                            //  if ($row['discount_type'] == 'fixed') {
                            //     echo 'Discount';
                            // } else {
                            //     echo 'Discount (' . $row['discount_value'] . '% )';
                            // } 
                            ?>
                        </td>
                        <td style="border-bottom: 0;border-top: 0;"></td>-->
                        <!-- <td style="border-bottom: 0;border-top: 0;"></td> -->
                        <!--<td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;">-
                            <?php 
                            // if ($row['discount_type'] == 'fixed') {
                            //     echo $row['discount_value'];
                            // } else {
                            //     $disc = $row['sum_total_price'] * $row['discount_value'] / 100;
                            //     echo floor($disc * 100) / 100;
                            // } 
                            ?>
                        </td>
                    </tr> -->
                <?php //} ?>
                <?php //if ($row['tax_type']) { ?>
                    <!-- <tr>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td colspan="2" style="border-bottom: 0;border-top: 0;">
                            <?php 
                            // if ($row['tax_type'] == 'CGST & SGST') {
                            //     echo 'CGST ' . ($row['tax_per'] / 2) . '%<br>';
                            //     echo 'SGST ' . ($row['tax_per'] / 2) . '%';
                            // } else if ($row['tax_type'] == 'IGST') {
                            //     echo 'IGST ' . $row['tax_per'] . '%';
                            // } 
                            ?>
                        </td>
                        <td style="border-bottom: 0;border-top: 0;"></td>-->
                        <!-- <td style="border-bottom: 0;border-top: 0;"></td> -->
                        <!--<td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;">
                            <?php 
                            // if ($row['tax_type'] == 'CGST & SGST') {

                            //     echo  floor($row['tax_amount'] * 100 / 2) / 100 . '<br>';
                            //     echo  floor($row['tax_amount'] * 100 / 2) / 100;
                            //     // echo  number_format(($row['tax_amount'] / 2), 2, '.', '');
                            // } else if ($row['tax_type'] == 'IGST') {
                            //     echo  $row['tax_amount'];
                            // }
                             ?>
                        </td>
                    </tr> -->
                <?php // } ?>
                <tr>
                    <!-- <td></td>
                    <td colspan="2">Total</td>
                    <td></td>
                    <td></td> -->
                     <!--<td></td>
                    <td><b><?php //echo $total_quantity; ?></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> -->
                    <td align="right" colspan="12" width="85%"><b>Total</b></td>
                    <td align="right" colspan="2" width="15%"><b><?php echo number_format($totalamount,2);  ?></b></td>
                </tr>
            </tbody>
        </table>
     
        <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <tr>
                <td style="font-size: 14px;">Amount Chargeable (in words)<br><b><?php echo convertAmountToWords($totalamount); ?></b></td>
            </tr>
        </table>


        <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>HSN/SAC</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th>Tax Amount</th>
                    </tr>
                </thead>
                <tbody>
                  <?php 
                //    $tax_row;
                //    $tax_row_time; 
                    $total_tax_row_value=0;
                //    $count_tax_row = count($tax_row);
              

                    foreach ($tax_row as $key => $value) {
                       // echo "Key: $key, Value: $value<br>";

                       $taxrowtime = ($value*$tax_row_time[$key])/2;
                       $taxrowvalue = $tax_row_value[$key];
                       if($key == 0){
                    
                   ?>
                            <tr>
                                <td rowspan="<?php echo count($tax_row); ?>" width='25%'><?php   
                        echo $this->db->select('hsn_code')->from('item')->order_by('id', 'asc')->get()->row()->hsn_code;
                        ?>    </td>
                                <td width='25%'><?php echo $taxrowtime;?></td>
                                <td width='25%'><?php echo $taxrowtime;?></td>
                                <td width='25%'><?php echo number_format($taxrowvalue,2); ?></td>
                            </tr>
                            <?php 
                       }else{

                       ?>
                            <tr>
                                
                                <td width='25%'><?php echo $taxrowtime;?></td>
                                <td width='25%'><?php echo $taxrowtime;?></td>
                                <td width='25%'><?php echo number_format($taxrowvalue,2); ?></td>
                            </tr>
            <?php 
                       }
                       $total_tax_row_value+=$taxrowvalue;
                   }
                   ?>
                    <tr>
                        <td width='75%' colspan="3" align="right"><b>Total</b></td>
                      
                        <td width='25%'><b><?php echo number_format($total_tax_row_value,2); ?></b></td>
                    </tr>
                </tbody>
            </table>


            <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
          
          <tr>
              <td width="50%" style="font-size:14px;">
                  Company's PAN :<b> <?php echo $this->db->get_where('bank_details', array('type' => 'pan_no'))->row()->description; ?></b><br>
                  <u>Declaration</u><br>
                  We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.<br>
                  TERMS AND CONDITIONS:<br>
                  <!-- (1) 24% interest will be charged on all invoice not paid within 30 days from the date of invoice.<br>
                  (2) Claims of defects after 5 days will not be entertrained.<br> -->
                   Goods sold will not be taken.
              </td>
              <td width="50%" style="font-size:14px;">
                  Company's Bank Details<br>
                  Bank Name :<?php echo $this->db->get_where('bank_details', array('type' => 'bank_name'))->row()->description; ?><br>
                  A/c No. : <?php echo $this->db->get_where('bank_details', array('type' => 'ac_no'))->row()->description; ?> <br>
                  Branch & IFSC Code : <?php echo $this->db->get_where('bank_details', array('type' => 'branch'))->row()->description; ?> & <?php echo $this->db->get_where('bank_details', array('type' => 'ifsc_code'))->row()->description; ?>

              </td>
          </tr>
      </table>


        <div class="footer-image">
            <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%" />
        </div>

        <!-- Watermark -->
        <div class="watermark">
            <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%" />
        </div>

    </div>
    <br>

    <a onClick="PrintElem('#invoice_print')" class="btn btn-primary hidden-print">
        <i class="fa fa-print"></i> &nbsp;
        <?php echo get_phrase('print_invoice'); ?>
    </a>
    <br><br>

<?php endforeach; ?>
<?php
function convertAmountToWords($amount)
{
    $ones = array(
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen'
    );

    $tens = array(
        2 => 'Twenty',
        3 => 'Thirty',
        4 => 'Forty',
        5 => 'Fifty',
        6 => 'Sixty',
        7 => 'Seventy',
        8 => 'Eighty',
        9 => 'Ninety'
    );

    $amount = floor($amount * 100) / 100;
    $split_amount = explode('.', $amount);
    $rupees = (int) $split_amount[0];
    $paise = (int) $split_amount[1];

    $in_words = '';

    if ($rupees > 0) {
        $crore = floor($rupees / 10000000);
        if ($crore > 0) {
            $in_words .= $ones[$crore] . ' Crore ';
            $rupees = $rupees % 10000000;
        }

        $lakh = floor($rupees / 100000);
        if ($lakh > 0) {
            $in_words .= $ones[$lakh] . ' Lakh ';
            $rupees = $rupees % 100000;
        }

        $thousand = floor($rupees / 1000);
        if ($thousand > 0) {
            if ($thousand < 20) {
                $in_words .= $ones[$thousand] . ' Thousand ';
            } else {
                $in_words .= $tens[floor($thousand / 10)] . ' ';
                $thousand = $thousand % 10;
                if ($thousand > 0) {
                    $in_words .= $ones[$thousand] . ' ';
                }
                $in_words .= 'Thousand ';
            }
            $rupees = $rupees % 1000;
        }

        $hundred = floor($rupees / 100);
        if ($hundred > 0) {
            $in_words .= $ones[$hundred] . ' Hundred ';
            $rupees = $rupees % 100;
        }

        if ($rupees > 0) {
            if ($rupees < 20) {
                $in_words .= $ones[$rupees] . ' ';
            } else {
                $in_words .= $tens[floor($rupees / 10)] . ' ';
                $rupees = $rupees % 10;

                if ($rupees > 0) {
                    $in_words .= $ones[$rupees] . ' ';
                }
            }
        }

        $in_words .= 'Rupees ';
    }

    if ($paise > 0) {
        if ($paise < 20) {
            $in_words .= $ones[$paise] . ' ';
        } else {
            $in_words .= $tens[floor($paise / 10)] . ' ';
            $paise = $paise % 10;

            if ($paise > 0) {
                $in_words .= $ones[$paise] . ' ';
            }
        }

        $in_words .= 'Paise ';
    }

    return ucwords(trim($in_words));
}




?>

<script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function PrintElem(elem) {
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Item Sale Invoice</title>');
        mywindow.document.write('<style type="text/css">');
        mywindow.document.write('@media print {');
        mywindow.document.write('.footer-image {');
        mywindow.document.write('position: fixed;');
        mywindow.document.write('bottom: 10px;');
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