<?php
$edit_data = $this->db->get_where('payroll', array('payroll_id' => $param2))->result_array();
foreach ($edit_data as $row):
    $user = $this->db->get_where($row['user_type'], array($row['user_type'] . '_id' => $row['user_id']))->row();
    $date = explode(',', $row['date']);
    $month_list = array('january', 'february', 'march', 'april', 'may', 'june', 'july',
        'august', 'september', 'october', 'november', 'december');
    for ($i = 0; $i < 12; $i++)
        if ($i == $date[0])
            $month = get_phrase($month_list[$i-1]);
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
    <div id="payroll_print">
         <table width="100%" border="0">
            <tr>
                <td ><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>"  style="height:100px; width:100%;" class="img-responsive"/></td>
                <td align="right"></td>
            </tr>
        </table>
        <!-- <table width="100%" border="0">
            <tr>
                <td width="50%"><img src="<?php echo base_url();?>uploads/logo3.jpg" style="max-height:80px;"></td>
                <td align="right">
                    <h4><?php echo get_phrase('payroll_code'); ?> : <?php echo $row['payroll_code']; ?></h4>
                    <h5><?php echo get_phrase('employee'); ?> : <?php echo $user->name; ?></h5>
                    <h5><?php echo get_phrase('account_type'); ?> : <?php echo get_phrase($row['user_type']); ?></h5>
                    <h5><?php echo get_phrase('date'); ?> : <?php echo $month . ', ' . $date[1]; ?></h5>
                    <h5>
                        <?php echo get_phrase('status'); ?> :
                        <?php
                        if($row['status'] == 0)
                            echo get_phrase('unpaid');
                        else
                            echo get_phrase('paid'); ?>
                    </h5>
                </td>
            </tr>
        </table>
        
        <hr><br> -->
        <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px" />
                    <table width="100%" class="printablea4">
                        <tr>
                            <th width="25%"><?php echo get_phrase('payroll_code'); ?></th>
                            <td width="25%"><?php echo $row['payroll_code']; ?></td>
                            <th width="25%"><?php echo get_phrase('employee'); ?></th>
                            <td width="25%"><?php echo $user->name; ?></td>

                        </tr>
                        <tr>
                            <th width="25%"><?php echo get_phrase('account_type'); ?></th>
                            <td><?php echo get_phrase($row['user_type']); ?></td>
                            <th width="25%"><?php echo get_phrase('date'); ?></th>
                            <td><?php echo $month . ', ' . $date[1]; ?></td>
                        </tr>
                        <tr>
                            <th width="25%"> <?php echo get_phrase('status'); ?></th>
                            <td><?php
                        if($row['status'] == 0)
                            echo get_phrase('unpaid');
                        else
                            echo get_phrase('paid'); ?></td>
                            <th width="25%"></th>
                            <td></td>
                        </tr>

                    </table>
          <hr><br>           
        <h4 style="text-align: center;"><?php echo get_phrase('allowance_summary'); ?></h4>
        <?php if($row['allowances'] == '') { ?>
            <div class="alert alert-info"><?php echo get_phrase('no_allowances');?></div>
        <?php } else { ?>
            <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th width="60%"><?php echo get_phrase('type'); ?></th>
                        <th><?php echo get_phrase('amount'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <div>
                        <?php
                        $total_allowance    = 0;
                        $allowances         = json_decode($row['allowances']);
                        $i = 1;
                        foreach ($allowances as $allowance)
                        {
                            $total_allowance += $allowance->amount; ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td>
                                    <?php echo $allowance->type; ?>
                                </td>
                                <td class="text-right">
                                    <?php echo $allowance->amount; ?>
                                </td>
                            </tr>
                        <?php }  ?>
                    </div>
                </tbody>
            </table>
        <?php } ?>
        
        <br>
        <h4 style="text-align: center;"><?php echo get_phrase('deduction_summary'); ?></h4>
        <?php if ($row['deductions'] == '') { ?>
            <div class="alert alert-info"><?php echo get_phrase('no_deductions'); ?></div>
        <?php } else { ?>
            <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th width="60%"><?php echo get_phrase('type'); ?></th>
                        <th><?php echo get_phrase('amount'); ?></th>
                    </tr>
                </thead>

                <tbody>
                <div>
                    <?php
                    $total_deduction = 0;
                    $deductions = json_decode($row['deductions']);
                    $i = 1;
                    foreach ($deductions as $deduction) {
                        $total_deduction += $deduction->amount;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td>
                                <?php echo $deduction->type; ?>
                            </td>
                            <td class="text-right">
                                <?php echo $deduction->amount; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </div>
                </tbody>
            </table>
        <?php } ?>
        
        <br>
        <h3 style="text-align: center; margin-bottom: 0px;"><?php echo get_phrase('payroll_summary'); ?></h3>
        <center><hr style="margin: 5px 0px 5px 0px; width: 50%;"></center>
        <center>
            <table>
                <tr>
                    <td style="font-weight: 600; font-size: 15px; color: #000;">
                        <?php echo get_phrase('basic_salary'); ?></td>
                    <td style="font-weight: 600; font-size: 15px; color: #000; width: 15%;
                        text-align: center;"> : </td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        text-align: right;"><?php echo $row['joining_salary']; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; font-size: 15px; color: #000;">
                        <?php echo get_phrase('total_allowance'); ?></td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        width: 15%; text-align: center;"> : </td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        text-align: right;"><?php echo $total_allowance; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; font-size: 15px; color: #000;">
                        <?php echo get_phrase('total_deduction'); ?></td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        width: 15%; text-align: center;"> : </td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        text-align: right;"><?php echo $total_deduction; ?></td>
                </tr>
                <tr>
                    <td colspan="3"><hr style="margin: 5px 0px;"></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; font-size: 15px; color: #000;">
                        <?php echo get_phrase('net_salary'); ?></td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        width: 15%; text-align: center;"> : </td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        text-align: right;">
                        <?php
                        $net_salary = $row['joining_salary'] + $total_allowance - $total_deduction;
                        echo $net_salary; ?>
                    </td>
                </tr>
            </table>
        </center>
        <div class="footer-image">
            <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%"/>
        </div>

        <!-- Watermark -->
        <div class="watermark">
            <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%"/>
        </div>
        <br>
    </div>

    <a onClick="PrintElem('#payroll_print')" class="btn btn-primary hidden-print">
        <i class="fa fa-print"></i>&nbsp;
        <?php echo get_phrase('print_payroll_details'); ?>
    </a>


<?php endforeach; ?>




<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    /*function Popup(data)
    {
        var mywindow = window.open('', 'payroll', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Payroll Details</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }*/
    function Popup(data)
    {
        var mywindow = window.open('', 'payroll', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Payroll Details</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('<style>');
        mywindow.document.write('@media print {');
        mywindow.document.write('    body {');
        mywindow.document.write('        font-size: 12px;');
        mywindow.document.write('    }');
        mywindow.document.write('    table {');
        mywindow.document.write('        border-collapse: collapse;');
        mywindow.document.write('        width: 100%;');
        mywindow.document.write('    }');
        mywindow.document.write('    th.text-center, td.text-center {');
        mywindow.document.write('        text-align: center;');
        mywindow.document.write('    }');
        mywindow.document.write('    th {');
        mywindow.document.write('        background-color: #f2f2f2;');
        mywindow.document.write('    }');
        mywindow.document.write('    .text-right {');
        mywindow.document.write('        text-align: right;');
        mywindow.document.write('    }');
        mywindow.document.write('}');
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
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>