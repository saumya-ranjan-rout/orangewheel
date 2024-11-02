<style type="text/css">

    
    .printablea4 {
        width: 100%;
    }

    .printablea4>tbody>tr>th,
    .printablea4>tbody>tr>td {
        padding: 2px 0;
        line-height: 1.42857143;
        vertical-align: top;
        font-size: 12px;
    }

    tfoot td {
        height: 170px;
    }

    thead td {
        height: 110px;
    }

    .watermark {
        position: fixed;
        top: 40%;
        bottom: 0;
        left: 0;
        right: 10px;
        z-index: -1;
        opacity: 0.1;
        background-position: center;

    }

    .on_print {
        display: none;
    }

    @media print {
        .report-header {
            position: fixed;
            top: 0px;
            height: 300px;
            display: block;
            width: 100%;
            overflow: visible;
        }

        .report-footer {
            position: fixed;
            bottom: 0px;
            height: 170px;
            display: block;
            width: 100%;
            overflow: visible;
        }

        .on_print {
            display: block;
        }

        .report-footer {
          height: 100px; /* Adjust the height to match the actual height of the footer image */

        }
    }
</style>

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Prescription</title>
</head>

<body>

    <div class="watermark on_print"> <img src="<?php echo base_url() . 'uploads/hospital_content/watermark-header.png' ?>"> </div>


    <div class="report-header">
        <img src="<?php echo base_url() . 'uploads/hospital_content/header.png' ?>" style="height:100px; width:100%;" class="img-responsive">
    </div>
    <table width="100%" class="printablea4">
        <thead>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>

                    <table width="100%" class="printablea4">

                        <tr>

                            <th>&nbsp;</th>
                            <td>&nbsp;</td>
                            <th class="text-right">&nbsp;</th>
                            <th class="text-right"><?php echo get_phrase('date'); ?> :
                                <?php echo date('d-m-Y', strtotime($row['date'])); ?></th>
                        </tr>

                    </table>

                </td>
            </tr>
            <tr>
                <td>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px" />
                    <table width="100%" class="printablea4">
                        <tr>
                            <th width="25%"><?php echo get_phrase('patient_name'); ?></th>
                            <td width="25%"><?php echo $row['patient_name']; ?>(<?php echo $row['code']; ?>)</td>
                            <th width="25%"><?php echo get_phrase('gender'); ?></th>
                            <td width="25%"><?php echo $row['sex']; ?></td>

                        </tr>
                        <tr>
                            <th width="25%"><?php echo get_phrase('doctor'); ?></th>
                            <td><?php echo $row['doctor_name']; ?></td>
                            <th width="25%"><?php echo get_phrase('age'); ?></th>
                            <td><?php echo $row['age']; ?></td>
                        </tr>
                        <tr>
                            <th width="25%"><?php echo get_phrase('blood_group'); ?></th>
                            <td><?php echo $row['blood_group']; ?></td>
                            <th width="25%"></th>
                            <td></td>
                        </tr>

                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px" />
                </td>
            </tr>

            <tr>
                <td>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top:0px" />

                    <table width="100%" class="printablea4">
                        <tr>
                            <th width="25%" align="left"><?php echo get_phrase('test_name'); ?></th>
                            <th width="25%" align="left"><?php echo get_phrase('short_name'); ?></th>
                            <th width="25%" align="left"><?php echo get_phrase('description'); ?></th>
                            <th width="25%" align="right"><?php echo get_phrase('total'); ?></th>
                        </tr>

                        <tr>
                            <td><?php echo $row['test_name']; ?> </td>
                            <td><?php echo $row['short_name']; ?> </td>
                          
                            <td><?php echo $row['description']; ?> </td>
                            <td align="right"><?php echo $row['charge']; ?> </td>
                        </tr>

                    </table>

                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px" />
                </td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>

    <div class="report-footer">
        <table class="printablea4" width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <div class="pprinta4">
                        <img src="<?php echo base_url() . 'uploads/hospital_content/footer.png' ?>" class="img-responsive" style="width: 100%">
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>