<?php
$this->db->select('patient_item_issue.*,payment_mode.payment_mode,patient.name as patient_name,patient.address as patient_address')->from('patient_item_issue');
$this->db->join('payment_mode', 'patient_item_issue.payment_mode_id = payment_mode.id', 'left');
$this->db->join('patient', 'patient_item_issue.patient_id = patient.patient_id', 'left');
$this->db->where('patient_item_issue.id', $id);
$query = $this->db->get();
$row = $query->row_array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<style>
.td {
    border: 1px solid #000 !important;
    padding: 8px;
}
table td{
    font-family: 'Courier New', Courier, monospace;
    font-weight: bold;
}
</style>
</head>

<body>
<table width="529" >
  <tr>
    <td height="117" colspan="5" style="text-align:center"><?php echo strtoupper($this->db->get_where('settings', array('type' => 'system_name'))->row()->description); ?>
<br>

<?php echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?><br>
 Phone : <?php echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?><br>
 GSTIN : <br><br>
 RECEIPT ADVICE
</td>
  </tr>
  <tr>
    <td height="64" colspan="3">To,<br>
 &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["patient_name"]; ?><br>
 &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["patient_address"]; ?></td>
    <td colspan="2">Date : <?php echo $row["money_receipt_date"]; ?><br>&nbsp;&nbsp;cc : all concerned
</td>
  </tr>
    <tr>
    <td height="48" colspan="5">Dear Sir,<br>
    &nbsp;&nbsp;&nbsp;&nbsp;Kindly note that we have credited your account on account of the following
Particulars.</td>
  </tr>
  <tr>
    <td height="24" colspan="5"></td>
  </tr>
     <tr>
       <td height="27" colspan="4" class="td">DESCRIPTION</td>
 
       <td class="td">AMOUNT</td>
  </tr>
   <tr>
       <td height="180" colspan="4" class="td">&nbsp;Being <br><br> &nbsp;&nbsp; &nbsp;&nbsp; <?php echo $row["payment_mode"]; ?><br><br><br>
       Narration <br>&nbsp;&nbsp; &nbsp;&nbsp; ADVANCE<br>&nbsp;Bill Adjustment Detail <br>&nbsp;&nbsp; &nbsp;&nbsp;New Ref. ADVANCE &nbsp;&nbsp; &nbsp;&nbsp;<?php echo $row["money_receipt_date"]; ?>&nbsp;&nbsp; &nbsp;&nbsp;Rs.<?php echo $row["received_amount"]; ?></td>
 
     <td class="td">Rs.<?php echo $row["received_amount"]; ?> </td>
  </tr>
   <tr>
       <td height="27" colspan="4" class="td">Rs.<?php echo convertAmountToWords($row["received_amount"]); ?> Only</td>
 
       <td class="td">Rs.<?php echo $row["received_amount"]; ?></td>
  </tr>
  <tr>
    <td height="24" colspan="5"></td>
  </tr>
 <tr>
    <td height="49" colspan="3">Please Debit the above in our account and acknowledge.</td>
    <td height="49" colspan="2" style="text-align:right;">for <?php echo strtoupper($this->db->get_where('settings', array('type' => 'system_name'))->row()->description); ?></td>
  </tr>
  <tr>
    <td height="49">( Prepared By)</td>
    <td height="49" colspan="2" style="text-align:center">( Accountant ) </td>
    <td height="49" colspan="2">( Prop. )</td>
  </tr>
</table>
</body>
</html>
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