<?php
$edit_data      = $this->db->get_where('prescription', array('prescription_id' => $param2))->result_array();
foreach ($edit_data as $row):
$patient_info   = $this->db->get_where('patient' , array('patient_id' => $row['patient_id'] ))->result_array();
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
    <div id="prescription_print">
         <table width="100%" border="0">
            <tr>
                <td ><img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>"  style="height:100px; width:100%;" class="img-responsive"/></td>
                <td align="right"></td>
            </tr>
        </table>
        <hr><br>
        <table width="100%" border="0">
            <tr>
                <td align="left" valign="top">
                    <?php foreach ($patient_info as $row2){ ?>
                        <?php echo 'Patient Name: '.$row2['name']; ?><br>
                        <?php echo 'Age: '.$row2['age']; ?><br>
                        <?php echo 'Sex: '.$row2['sex']; ?><br>
                    <?php } ?>
                </td>
                <td align="right" valign="top">
                    <?php $name = $this->db->get_where('doctor' , array('doctor_id' => $row['doctor_id'] ))->row()->name;
                          echo 'Doctor Name: '.$name;?><br>
                    <?php echo 'Date: '.date("d M, Y", $row['timestamp']); ?><br>
                    <?php echo 'Time: '.date("H:i", $row['timestamp']); ?><br>
                </td>
            </tr>
        </table>
        <hr>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-primary" data-collapsed="0">
                        
                    <div class="panel-body">
                            
                        <b><?php echo get_phrase('case_history'); ?> :</b>
                        
                        <p><?php echo $row['case_history']; ?></p>
                        
                        <hr>
                            
                        <b><?php echo get_phrase('medication'); ?> :</b>
                        
                        <p><?php echo $row['medication']; ?></p>
                        
                        <hr>
                        
                        <b><?php echo get_phrase('note'); ?> :</b>
                        
                        <p><?php echo $row['note']; ?></p>

                    </div>

                </div>

            </div>
        </div>
        <div class="footer-image">
            <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%"/>
        </div>

        <!-- Watermark -->
        <div class="watermark">
            <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>" class="img-responsive" style="width: 300%"/>
        </div>
    </div>
    <br>

    <a onClick="PrintElem('#prescription_print')" class="btn btn-primary hidden-print">
        <i class="fa fa-print"></i>&nbsp;
        <?php echo get_phrase('print_prescription');?>
    </a>
<?php endforeach; ?>




<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    /*function Popup(data)
    {
        var mywindow = window.open('', 'prescription', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Prescription</title>');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url('assets/css/neon-theme.css');?>" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="<?php echo base_url('assets/js/datatables/responsive/css/datatables.responsive.css');?>" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }*/
    function Popup(data)
    {
        var mywindow = window.open('', 'prescription', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Prescription</title>');
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