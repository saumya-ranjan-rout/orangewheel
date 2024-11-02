<?php
$payment_mode_info = $this->db->get('payment_mode')->result_array();
$patient_id=$patient_id['patient_id '];
?>
<ol class="breadcrumb bc-3" style="margin-bottom: 0px;">
    <li>
        <a href="<?php echo site_url('admin'); ?>">
            <i class="entypo-folder"></i>
            <?php echo get_phrase('dashboard'); ?>
        </a>
    </li>

</ol>
<br>



<div class="panel panel-primary" data-collapsed="0">

    <div class="panel-heading">
        <div class="panel-title">
            <h3><?php echo get_phrase('add_diagnosis'); ?></h3>
        </div>
    </div>

    <div class="panel-body">
    <form role="form" class="form-horizontal form-groups" 
 method="post" enctype="multipart/form-data"  id="myForm"> <!-- onsubmit="submitForm()"onsubmit="disableButton()" action="<?php //echo site_url('admin/patient/create'); ?>"  -->

        <!-- <form role="form" class="form-horizontal form-groups" action="<?php echo site_url('admin/patient_diagnosis_insert/create'); ?>" method="post" enctype="multipart/form-data"> -->
            <div class="row">
               
                <div class="col-sm-4">
                   
                    <input type="hidden" name="patient_id" class="form-control" value="<?php echo $patient_id; ?>" id="field-1" readonly required>
                </div>
              
            </div>
            <span id="models">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-4">
                        <label><?php echo get_phrase('diagnosis'); ?> <small style="color:red;">*</small></label>
                        <select name="diagnosis_id[]" class="form-control select2" onchange="get_diag(this.value, 1)" required>
                            <option value=""><?php echo get_phrase('select_a_diagnosis '); ?></option>
                            <?php
                            foreach ($diag_info as $row) {
                               ?>
                                
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['name']; ?>
                                    </option>
                           
                            <?php } ?>
                        </select>
                    </div>
                   

                    <div class="col-sm-1">
                        <label><?php echo get_phrase('quantity'); ?></label>
                        <input type="number" class="form-control" name="diagnosis_quantity[]" id="diagnosis_quantity_1" min="1" max="999" value="1" readonly required />
                    </div>

                    <div class="col-sm-1">
                        <label><?php echo get_phrase('price'); ?></label>
                        <input type="text" class="form-control" id="diagnosis_price_1" name="diagnosis_price[]" value="" readonly />
                    </div>

                    <div class="col-sm-1">
                        <label><?php echo get_phrase('discount_type'); ?></label>
                        <input type="text" class="form-control" id="discount_type_1" name="discount_type[]" value="" readonly />
                    </div>
                   
                    <div class="col-sm-2">
                        <label><?php echo get_phrase('discount_price'); ?>/%</label>
                        <input type="text" class="form-control" id="discount_price_1" name="discount_price[]" value="" readonly />
                    </div>
                     <div class="col-sm-2">
                        <label><?php echo get_phrase('total_price'); ?></label>
                        <input type="text" class="form-control" id="total_price_1" name="total_price[]" value="" readonly />
                    </div>
                    
                    <div class="col-sm-1">
                        <label><?php echo get_phrase('action'); ?></label>
                    </div>
                </div>
            </span>

            <span id="model_input">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-sm-4">
                        <select name="diagnosis_id[]" class="form-control" onchange="get_diag(this.value)" id="diagnosis_id">
                            <option value=""><?php echo get_phrase('select_a_diagnosis '); ?></option>
                            <?php
                            foreach ($diag_info as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['name']; ?>
                                    </option>
                            <?php 
                            } ?>
                        </select>
                    </div>

                   

                    <div class="col-sm-1">
                        <input type="number" class="form-control" name="diagnosis_quantity[]" id="diagnosis_quantity" min="1" max="999" value="1" readonly required />
                    </div>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" id="diagnosis_price" name="diagnosis_price[]" value="" readonly />
                    </div>
                    <div class="col-sm-1">
                        <input type="text" class="form-control" id="discount_type" name="discount_type[]" value="" readonly />
                    </div>
                   
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="discount_price" name="discount_price[]" value="" readonly />
                    </div>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" id="total_price" name="total_price[]" value="" readonly />
                    </div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-danger" id="model_delete" onclick="deletemodelParentElement(this)">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
            </span>

            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-11" align="left">
                    <button type="button" class="btn btn-primary btn-sm" onClick="add_model()">
                        <i class="fa fa-plus"></i> &nbsp;
                        <?php echo get_phrase('add_diagnosis'); ?>
                    </button>

                  
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-8 control-label"><?php echo get_phrase('sum_total_price'); ?></label>
                <div class="col-sm-2">
                    <input type="number" name="sum_total_price" class="form-control" id="sum_total_price" value="0" readonly />
                </div>
            </div>
          

            <!--<div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-8 control-label"><?php echo get_phrase('grand_total'); ?></label>

                <div class="col-sm-2">
                    <input type="number" name="grand_total" class="form-control" id="grand_total" readonly />
                </div>
            </div>-->


            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-1" class="col-sm-8 control-label"><?php echo get_phrase('payment_status'); ?> <small style="color:red;">*</small></label>
                <div class="col-sm-2">
                    <select name="payment_status" class="form-control" id="payment_status" required>
                        <option value=""><?php echo get_phrase('select_a_status'); ?></option>
                        <option value="advance_paid"><?php echo get_phrase('advance_paid'); ?></option>
                        <option value="paid"><?php echo get_phrase('paid'); ?></option>
                        <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
                        <option value="partial"><?php echo get_phrase('partial'); ?></option>
                    </select>
                </div>
            </div>

            <div class="row" align="right" style="margin-top: 10px;">
                <label for="field-ta" class="col-sm-8 control-label"><?php echo get_phrase('payment_mode'); ?></label>
                <div class="col-sm-2">
                    <select name="payment_mode_id" class="form-control">
                        <option value=""><?php echo get_phrase('select_payment_mode'); ?></option>
                        <?php foreach ($payment_mode_info as $row) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['payment_mode']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="row" align="right" style="margin-top: 10px;">
                <div class="col-sm-12">
                    <button id='submit_button' type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> &nbsp; <?php echo get_phrase('add_diagnosis'); ?>
                    </button>
                </div>
            </div>
        </form>

    </div>

</div>
<div id="diagnosis_print" style="display:none;">  
        <!-- style="display:none;" -->
    </div>


<script type="text/javascript">
  $(document).ready(function() {
$('#myForm').submit(function(event) {
      event.preventDefault();

      var formData = new FormData($(this)[0]);
      $.ajax({
        url: '<?php echo site_url('admin/patient_diagnosis_insert/create'); ?>',
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
      toastr.info('Patient Info Saved Successfuly');
          getdivdata(response.inserted_id);
        },
        error: function() {
        toastr.error('Error Occured');
        }
      });
    });
  });

  function getdivdata(inserted_id) {
    //alert(elem);
   $.ajax({
  url: '<?php echo site_url('admin/diagnosis_load'); ?>',
  data: { inserted_id: inserted_id },
  success: function(response) {
    $('#diagnosis_print').html(response);
  //  alert(response);
  $('#modal_ajax').modal('hide');
   // PrintElemt('#prescription_print');
      PrintElemt('#diagnosis_print',inserted_id);
  }
});


  }

  function PrintElemt(elem,inserted_id) {
      //alert("hi7");
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
             
                        setTimeout(function() {
                        mywindow.print();
                        mywindow.close();
                    //    window.location.reload();
                    window.location.href = '<?php echo site_url('admin/patient'); ?>';
                      }, 1000); // Wait for 1 second to ensure the image is fully loaded
                     return true;
                        }




    var model_count = 1;
    var sum_total_price = 0;
    var deleted_models = [];

  /*  $(document).ready(function() {
        $('#submit_button').attr('disabled', 'true');
    });*/

    function get_diag(diagnosis_id, append_id) {
        if (diagnosis_id != '') {
            $.ajax({
                url: '<?php echo site_url('admin/get_diag/'); ?>' + diagnosis_id,
                success: function(response) {
                    // alert(response);
                    var data = JSON.parse(response);
                    $('#diagnosis_quantity_' + append_id).attr('max', data.qty);
                    $('#diagnosis_price_' + append_id).attr('value', data.price);
                     $('#discount_type_' + append_id).attr('value', data.discount_type);
                     $('#discount_price_' + append_id).attr('value', data.discount_price);
                     
                   
                    calculate_total_price(append_id);
                }
            });

        } else {
            $('#diagnosis_quantity_' + append_id).attr('max', 1);
            $('#diagnosis_price_' + append_id).attr('value', "");
              $('#discount_type_' + append_id).attr('value', "");
               $('#discount_price_' + append_id).attr('value', "");
              
            calculate_total_price(append_id);
        }
    }


function calculate_total_price(append_id) {
    var diagnosis_price = parseFloat($('#diagnosis_price_' + append_id).val());
    var discount_type = $('#discount_type_' + append_id).val();
    var discount_price = parseFloat($('#discount_price_' + append_id).val());

    var total_price = diagnosis_price;

    if (discount_type === 'fixed') {
        total_price -= discount_price;
    } else if (discount_type === 'percentage') {
        var discount_amount = (diagnosis_price * discount_price) / 100;
        total_price -= discount_amount;

    }

    $('#total_price_' + append_id).val(total_price.toFixed(2)); // Update total price field
     calculate_sum_total_price();
}


    $('#model_input').hide();

    // CREATING BLANK model INPUT
    var blank_model = '';
    $(document).ready(function() {
        blank_model = $('#model_input').html();
    });

    function add_model() {
        model_count++;
       // var newModel = blank_model.replace(/_1/g, '_' + model_count); // Replace _1 with the new model_count
   // $("#models").append(newModel);
        $("#models").append(blank_model);
        $('#diagnosis_id').attr('id', 'diagnosis_id_' + model_count);
        $('#diagnosis_id_' + model_count).attr('onchange', 'get_diag(this.value, ' + model_count + ')');
       
        $('#diagnosis_quantity').attr('id', 'diagnosis_quantity_' + model_count);
        $('#diagnosis_price').attr('id', 'diagnosis_price_' + model_count);
        $('#discount_type').attr('id', 'discount_type_' + model_count);
       
       
        $('#discount_price').attr('id', 'discount_price_' + model_count);
         $('#total_price').attr('id', 'total_price_' + model_count);
        $('#model_delete').attr('id', 'model_delete_' + model_count);
        $('#model_delete_' + model_count).attr('onclick', 'deletemodelParentElement(this, ' + model_count + ')');
        $('#diagnosis_id_' + model_count).select2();
        
     
   // $('#discount_price_' + model_count).attr('onchange', 'calculate_total_price(' + model_count + ')');

    }
function calculate_sum_total_price() {
        var total;
        for (i = 1; i <= model_count; i++) {
            if (jQuery.inArray(i, deleted_models) == -1) {
              
                total = $('#total_price_' + i).val();
                if (total != '') {
                    total = parseFloat(total);
                    sum_total_price = total + sum_total_price;
                }
            }
        }
        $('#sum_total_price').attr('value', sum_total_price);
        sum_total_price = 0;
       // calculate_total_amount();
    }
 function deletemodelParentElement(n, model_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_models.push(model_count);
        calculate_sum_total_price(); // Recalculate the total price after removing the row
    }

  
</script>