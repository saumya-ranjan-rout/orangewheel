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
    <div id="challan_print">

        <table width="100%" border="0">
            <tr>
                <td><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>" style="height:100px; width:100%;" class="img-responsive" /></td>
                <td align="right"></td>
            </tr>
        </table>
        <br>
        <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <tbody>
                <tr>
                    <td colspan="2" rowspan="2" width='55%'>
                        <b><?php echo $this->db->get_where('settings', array('type' => 'system_name'))->row()->description; ?></b><br>
                        <?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
                        <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?>
                    </td>
                    <td colspan="2" rowspan="2" width='45%'>Buyer<br>
                        <b><?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->name; ?></b><br>
                        <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->current_street; ?><br>
                        <?php echo $this->db->get_where('patient', array('patient_id' => $row['patient_id']))->row()->phone; ?>
                    </td>
                </tr>
                <tr>
                </tr>


                <tr>
                    <td>Challan No.<br><b><?php echo $row['bill_no']; ?></b></td>
                    <td>Dated<br><b><?php echo date("d-m-Y", strtotime($row['challan_date'])); ?></b></td>
                    <td>Mode of Payment<br><b><?php echo $row['payment_mode']; ?></b></td>
                    <td>Dispathed Through<br><b><?php echo $row['dispatched_through']; ?></b></td>
                </tr>
                <tr>
                    <td colspan="2">Destination<br><b><?php echo $row['destination']; ?></b></td>
                    <td colspan="2">Delivery Note<br><b><?php echo $row['delivery_note']; ?></b></td>
                </tr>
            </tbody>
        </table>
        <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th class="text-center">Sl No.</th>
                    <th colspan="2" class="text-center">Description</th>
                    <th class="text-center">Serial No</th>
                    <th class="text-center">HSN Code</th>
                    <th class="text-center">Batch</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Unit</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">GST Rate</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- CHALLAN ENTRY STARTS HERE-->
                <div id="challan_entry">
                    <?php
                    $i                  = 1;
                    $total_quantity  = 0;
                    $models          = json_decode($row['models']);
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
                        <tr>
                            <td class="text-center" style="border-bottom: 0;border-top: 0;"><?php echo $i++; ?></td>
                            <td colspan="2" style="border-bottom: 0;border-top: 0;"><?php echo $model_info['model']; ?> </td>
                            <td style="border-bottom: 0;border-top: 0;"><?php echo $model_info['serial_no']; ?></td>
                            <td style="border-bottom: 0;border-top: 0;"><?php echo $model_info['hsn_code']; ?></td>
                            <td style="border-bottom: 0;border-top: 0;"><?php echo $model_info['batch_no']; ?></td>
                            <td style="border-bottom: 0;border-top: 0;"><?php echo $row2->quantity; ?></td>
                            <td style="border-bottom: 0;border-top: 0;"><?php echo $model_info['unit_name']; ?></td>
                            <td style="border-bottom: 0;border-top: 0;"><?php echo $row2->price; ?></td>
                            <td style="border-bottom: 0;border-top: 0;"><?php if ($row2->tax_percentage > 0) echo $row2->tax_percentage . "%"; ?></td>
                            <td style="border-bottom: 0;border-top: 0;"><?php echo $row2->total_price; ?></td>
                        </tr>
                    <?php } ?>
                </div>
                <!-- CHALLAN ENTRY ENDS HERE-->
                <?php if ($row['discount_type']) { ?>
                    <tr>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td colspan="2" style="border-bottom: 0;border-top: 0;">
                            <?php if ($row['discount_type'] == 'fixed') {
                                echo 'Discount';
                            } else {
                                echo 'Discount (' . $row['discount_value'] . '% )';
                            } ?>
                        </td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;">-
                            <?php if ($row['discount_type'] == 'fixed') {
                                echo $row['discount_value'];
                            } else {
                                $disc = $row['sum_total_price'] * $row['discount_value'] / 100;
                                echo number_format($disc, 2);
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($row['tax_type']) { ?>
                    <tr>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td colspan="2" style="border-bottom: 0;border-top: 0;">
                            <?php if ($row['tax_type'] == 'CGST & SGST') {
                                echo 'CGST ' . ($row['tax_per'] / 2) . '%<br>';
                                echo 'SGST ' . ($row['tax_per'] / 2) . '%';
                            } else if ($row['tax_type'] == 'IGST') {
                                echo 'IGST ' . $row['tax_per'] . '%';
                            } ?>
                        </td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;"></td>
                        <td style="border-bottom: 0;border-top: 0;">
                            <?php if ($row['tax_type'] == 'CGST & SGST') {
                                echo  number_format(($row['tax_amount'] / 2), 2) . '<br>';
                                echo  number_format(($row['tax_amount'] / 2), 2);
                            } else if ($row['tax_type'] == 'IGST') {
                                echo  $row['tax_amount'];
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td colspan="2">Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo $total_quantity; ?></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo $row['grand_total']; ?></b></td>
                </tr>
            </tbody>
        </table>
        <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <tr>
                <td>Amount Chargeable (in words)<br><b><?php echo convertAmountToWords($row['grand_total']); ?></b></td>
            </tr>
        </table>
        <?php if ($row['tax_type'] == 'CGST & SGST') { ?>
            <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th rowspan="2">HSN/SAC</th>
                        <th rowspan="2">Taxable Value</th>
                        <th colspan="2">Central Tax</th>
                        <th colspan="2">State Tax</th>
                        <th rowspan="2">Total Tax Amount</th>
                    </tr>
                    <tr>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_taxable = 0;
                    $total_central_tax = 0;
                    $total_state_tax = 0;
                    $total_tax = 0;
                    foreach ($models as $row3) {
                        $this->db->select('item.*')->from('item');
                        $this->db->where('item.id', $row3->model_id);
                        $query3 = $this->db->get();
                        $model_info2 = $query3->row_array();
                        if ($row3->tax_percentage > 0) {
                    ?>
                            <tr>
                                <td><?php echo $model_info2['hsn_code']; ?></td>
                                <td>
                                    <?php echo $row3->basic_price;
                                    $total_taxable += $row3->basic_price; ?>
                                </td>
                                <td><?php echo $row3->tax_percentage / 2; ?>%</td>
                                <td>
                                    <?php echo $row3->tax / 2;
                                    $total_central_tax += $row3->tax / 2; ?>
                                </td>
                                <td><?php echo $row3->tax_percentage / 2; ?>%</td>
                                <td>
                                    <?php echo $row3->tax / 2;
                                    $total_state_tax += $row3->tax / 2; ?>
                                </td>
                                <td>
                                    <?php echo $row3->tax;
                                    $total_tax += $row3->tax; ?>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                    <tr>
                        <td><b>Total</b></td>
                        <td><b><?php echo $total_taxable; ?></b></td>
                        <td></td>
                        <td><b><?php echo $total_central_tax; ?></b></td>
                        <td></td>
                        <td><b><?php echo $total_state_tax; ?></b></td>
                        <td><b><?php echo $total_tax; ?></b></td>
                    </tr>
                </tbody>
            </table>
        <?php } else if ($row['tax_type'] == 'IGST') { ?>
            <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>HSN/SAC</th>
                        <th>Taxable Value</th>
                        <th>IGST</th>
                        <th>Tax Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_taxable = 0;
                    $total_central_tax = 0;
                    $total_state_tax = 0;
                    $total_tax = 0;
                    foreach ($models as $row3) {
                        $this->db->select('item.*')->from('item');
                        $this->db->where('item.id', $row3->model_id);
                        $query3 = $this->db->get();
                        $model_info2 = $query3->row_array();
                        if ($row3->tax_percentage > 0) {
                    ?>
                            <tr>
                                <td><?php echo $model_info2['hsn_code']; ?></td>
                                <td>
                                    <?php echo $row3->basic_price;
                                    $total_taxable += $row3->basic_price; ?>
                                </td>
                                <td><?php echo $row3->tax_percentage; ?>%</td>
                                <td>
                                    <?php echo $row3->tax;
                                    $total_tax += $row3->tax; ?>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                    <tr>
                        <td><b>Total</b></td>
                        <td><b><?php echo $total_taxable; ?></b></td>
                        <td></td>
                        <td><b><?php echo $total_tax; ?></b></td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>

        <table table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <?php if ($total_tax > 0) { ?>
                <tr>
                    <td colspan="2">Tax Amount (in words) : <b><?php echo convertAmountToWords($total_tax); ?></b></td>
                </tr>
            <?php } ?>
            <tr>
                <td width="50%">
                    Company's PAN :<b> ART89ER56</b><br>
                    <u>Declaration</u><br>
                    We declare that this challan shows the actual price of the goods described and that all particulars are true and correct.<br>
                    TERMS AND CONDITIONS:<br>
                    (1) 24% interest will be charged on all challan not paid within 30 days from the date of challan.<br>
                    (2) Claims of defects after 5 days will not be entertrained.<br>
                    (3) Goods sold will not be taken.
                </td>
                <td width="50%">
                    Company's Bank Details<br>
                    Bank Name : State Bank Of India (SBI)<br>
                    A/c No. : 65454333323 <br>
                    Branch & IFSC Code : Bhubaneswar IRC Village & SBIN0005978

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

    <a onClick="PrintElem('#challan_print')" class="btn btn-primary hidden-print">
        <i class="fa fa-print"></i> &nbsp;
        <?php echo get_phrase('print_challan'); ?>
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

    $amount = number_format($amount, 2, '.', '');
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
        var mywindow = window.open('', 'challan', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Item Challan</title>');
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