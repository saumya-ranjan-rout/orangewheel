<style>
.rounded-circle {
    border-radius: 50%!important;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}
img {
    vertical-align: middle;
    border-style: none;
}
#hideDefault { display: none; }
        /* Style for the search results container */
        #search-results {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        /* Style for each search item */
        .search-item {
            padding: 5px;
            cursor: pointer;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            transition: background-color 0.2s;
        }

        /* Hover effect for search items */
        .search-item:hover {
            background-color: #e0e0e0;
        }
    </style>
<?php

// $tpa_management_info = $this->db->get('tpa_management')->result_array();
$bloodgroup_info = $this->db->get('blood_bank')->result_array(); ?>
<?php  $query=$this->db->select('code')->from('patient')->order_by('patient_id', 'DESC')->limit(1)->get();
        if ($query->num_rows() > 0) {
$stringValue =$query->row()->code;
$numericPart = (int)substr($stringValue, strpos($stringValue, '.') + 1);
$incrementedNumericPart = $numericPart + 1;
$lastinvoice = substr($stringValue, 0, strpos($stringValue, '.') + 1) . $incrementedNumericPart;

        } else {
            $stringValue="Pt.1000";
            $numericPart = (int)substr($stringValue, strpos($stringValue, '.') + 1);
$incrementedNumericPart = $numericPart + 1;
$lastinvoice = substr($stringValue, 0, strpos($stringValue, '.') + 1) . $incrementedNumericPart;
        }
        ?>
<div class="row">
<div class="col-md-12">

<div class="panel panel-primary" data-collapsed="0">

<div class="panel-heading">
<div class="panel-title">
<h3><?php echo get_phrase('add_patient'); ?></h3>
</div>
</div>

<div class="panel-body">

<form role="form" class="form-horizontal form-groups" 
 method="post" enctype="multipart/form-data"  id="myForm"> <!-- onsubmit="submitForm()"onsubmit="disableButton()" action="<?php //echo site_url('admin/patient/create'); ?>"  -->

<div class="form-group">
<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Patient Id'); ?>  <small style="color:red;">*</small></label>

<div class="col-sm-7">
<input type="text" name="code" class="form-control" id="code" value="<?php echo $lastinvoice; ?>"  readonly required>
</div>
</div>
<div class="form-group">
<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name'); ?>  <small style="color:red;">*</small></label>

<div class="col-sm-7">
<input type="text" name="name" class="form-control" id="name" required>
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email'); ?>  </label>

<div class="col-sm-7">
<input type="email" name="email" class="form-control" id="field-1" >
</div>
</div>

<!-- <div class="form-group">
<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('password'); ?>   </label>

<div class="col-sm-7">
<input type="password" name="password" class="form-control" id="field-1" >
</div>
</div> -->



<div class="form-group">
<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('phone'); ?> <small style="color:red;">*</small></label>

<div class="col-sm-7">
<input type="text" name="phone"id="phone" pattern="[0-9]{10}" class="form-control" id="field-1" >
</div>
</div>

<div class="form-group">
<label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('sex'); ?>  <small style="color:red;">*</small></label>

<div class="col-sm-7">
<select name="sex" id="sex" class="form-control" required>
<option value=""><?php echo get_phrase('Select Sex'); ?></option>
<option value="male">Male</option>
<option value="female">Female</option>
<option value="other">Other</option>
</select>
</div>
</div>
<div class="form-group">
<label for="field-ta" class="col-sm-3 control-label"><?php echo get_phrase('blood_group'); ?>  </label>

<div class="col-sm-7">
<select name="blood_group" id="blood_group" class="form-control" >
<option value=""><?php echo get_phrase('Select Blood Group'); ?></option>
<?php foreach ($bloodgroup_info as $row) { ?>
    <option value="<?php echo $row['blood_group_id']; ?>"><?php echo $row['blood_group']; ?></option>
    <?php } ?>
    </select>
    </div>
    </div>
    
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('birth_date'); ?> </label>
    
    <div class="col-sm-7">
    <input type="text" name="birth_date" class="form-control datepicker" id="birth_date" >
    </div>
    </div>
    
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('age'); ?></label>
    
    <div class="col-sm-7">
    <input type="text" name="age" class="form-control" id="age" >
    </div>
    </div>

    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('visit_type'); ?><small style="color:red;">*</small></label>
    
    <div class="col-sm-7">
    <select id="visit_type" name="visit_type" class="form-control" required>
    <option value="">Select Visit Type</option>
    <option value="walk-in">Walk-in</option>
    <option value="appointment">Appointment</option>
    </select>
    </div>
    </div>
    
        <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('visit_date'); ?>  </label>
    
    <div class="col-sm-7">
    <input type="text" name="visit_date" class="form-control datepicker" id="visit_date">
    </div>
    </div>
    
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Marital Status'); ?></label>
    <div class="col-sm-7">
    <select id="marital_status" name="marital_status" class="form-control">
    <option value="">Select Marital Status</option>
    <option value="single">Single</option>
    <option value="married">Married</option>
    <option value="divorced">Divorced</option>
    <option value="widowed">Widowed</option>
    <option value="other">Other</option>
    </select>
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Weight'); ?></label>
    
    <div class="col-sm-7">
    <input type="text" name="weight" class="form-control" id="weight" >
    </div>
    </div>
     <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Height'); ?></label>
    
    <div class="col-sm-7">
    <input type="text" name="height" class="form-control" id="height" >
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Guardian Name'); ?>  </label>
    
    <div class="col-sm-7">
    <input type="text" name="guardian_name" class="form-control" id="guardian_name" >
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Guardian Number'); ?> </label>
    
    <div class="col-sm-7">
    <input type="text" name="guardian_no" pattern="[0-9]{10}" class="form-control" id="guardian_no" >
    </div>
    </div>
    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Referral Doctor'); ?></label>
    
    <div class="col-sm-7">
    <!-- <input type="text" name="referred_by" class="form-control" id="referred_by"value="self"> id="search-input" -->
    <span>e.g:Name(Mobile No)</span>
    <input type="text"  name="referred_by" class="form-control" id="referred_by"value="self">
    <ul id="search-results"></ul>
    </div>
    </div>

   <div class="form-group">
      <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('ID Card'); ?> </label>

      <div class="col-sm-4">
        <input type="text" name="id_card" class="form-control" id="field-1" >
      </div>
<div class="col-sm-3">
        <input type="file" name="id_card_file" class="form-control " id="field-1" accept=".jpg, .jpeg, .png" >
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label"><?php echo get_phrase('GST No');?></label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="gst_no" />
    </div>
    </div>

    <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Consultation Fee'); ?><small style="color:red;">*</small></label>
    
    <div class="col-sm-7">
    <input type="number" name="consultation_fee" class="form-control" id="consultation_fee" required>
    </div>
    </div>

    <div class="form-group">
    <label class="col-sm-3 control-label"><?php echo get_phrase('Discount_type');?></label>
    <div class="col-sm-7">                             
    <select class="form-control" name="discount_type" id="discount_type">
    <option value="">None</option>
    <option value="fixed">Fixed</option>
    <!--<option value="percentage">Percentage</option>-->
    </select>
    </div>
    </div>

    <div class="form-group" id="discount_value_field" style="display: none">
      <label class="col-sm-3 control-label" id="discount_value_label"><?php echo get_phrase('Discount_Value');?></label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="discount_value"/>
    </div>
    </div>
    
   <!-- <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Commission Add'); ?></label>
    
    <div class="col-sm-7">
    <input type="number" name="commission_add" class="form-control" id="commission_add" >
    </div>
    </div>-->
    <div class="form-group">
    <div class="col-sm-6">
    <label for="field-1" class="control-label"><?php echo get_phrase('Current Address'); ?></label><br><br>
    </div>
    <div class="col-sm-6">
    <label for="field-1" class="control-label"><?php echo get_phrase('Permanent Address'); ?></label><br>
    <input type="checkbox" id="sameAddressCheckbox"><label for="sameAddressCheckbox" style="font-size:10px;">Same as Current Address</label>
    
    </div>
    </div>
    
    <div class="form-group">
    <div class="col-sm-6">
    <div class="row">
    <div class="col-sm-12">
    <label for="currentStreet"  class="col-sm-3 control-label" style="font-size:10px;"> Street:</label>
    <div class="col-sm-9">
    <input type="text" id="current_street" class="form-control" name="current_street">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="currentCity" class="col-sm-3 control-label" style="font-size:10px;"> City:</label>
    <div class="col-sm-9">
    <input type="text" id="current_city" class="form-control" name="current_city">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="currentState" class="col-sm-3 control-label" style="font-size:10px;"> State:</label>
    <div class="col-sm-9">
    <input type="text" id="current_state" class="form-control" name="current_state" value="Odisha">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="currentPostalCode" class="col-sm-3 control-label" style="font-size:10px;"> Postal Code:</label>
    <div class="col-sm-9">
    <input type="text" id="current_postalcode"class="form-control"  name="current_postalcode">
    </div>
    </div>
    </div>
    </div>
    <div class="col-sm-6">
    <div class="row">
    <div class="col-sm-12">
    <label for="permanentStreet" class="col-sm-3 control-label" style="font-size:10px;"> Street:</label>
    <div class="col-sm-9">
    <input type="text" id="permanent_street" class="form-control" name="permanent_street">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="permanentCity" class="col-sm-3 control-label" style="font-size:10px;"> City:</label>
    <div class="col-sm-9">
    <input type="text" id="permanent_city" class="form-control" name="permanent_city">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="permanentState" class="col-sm-3 control-label" style="font-size:10px;"> State:</label>
    <div class="col-sm-9">
    <input type="text" id="permanent_state" class="form-control" name="permanent_state">
    </div>
    </div>
    <div class="col-sm-12">
    <label for="permanentPostalCode" class="col-sm-3 control-label" style="font-size:10px;"> Postal Code:</label>
    <div class="col-sm-9">
    <input type="text" id="permanent_postalcode" class="form-control" name="permanent_postalcode">
    </div>
    </div>
    </div>
    
    </div>
    </div>
    
     <div class="form-group">
    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('Remarks'); ?></label>
    
    <div class="col-sm-7">
    <textarea type="text" name="remarks" class="form-control" id="remarks" ></textarea>
    </div>
    </div>
    
    
    <!--<div class="form-group">-->
    <!--<label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>-->
    
    <!--<div class="col-sm-7">-->
    
    <!--<div class="fileinput fileinput-new" data-provides="fileinput">-->
    <!--<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">-->
    <!--<img src="http://placehold.it/200x150" alt="...">-->
    <!--</div>-->
    <!--<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>-->
    <!--<div>-->
    <!--<span class="btn btn-white btn-file">-->
    <!--<span class="fileinput-new">Select image</span>-->
    <!--<span class="fileinput-exists">Change</span>-->
    <!--<input type="file" name="image" accept="image/*" id="image">  -->
   
    <!--</span>-->
    <!--<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>-->
    <!--</div>-->
    <!--</div>-->
    
    <!--</div>-->
    <!--</div>-->
    
    
    <div class="form-group">
    <label class="col-sm-3 control-label"><?php echo get_phrase('image'); ?></label>
    
    <div class="col-sm-7">
    
    <div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
    <img src="http://placehold.it/200x150" alt="...">
    </div>
    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
    <div>
    <span class="btn btn-white btn-file">
    <span class="fileinput-new">Select image</span>
    <span class="fileinput-exists">Change</span>
    <input type="file" name="image" accept="image/png, image/jpeg, image/jpg" >
    </span>
    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
    <b>OR</b>
    <a href="#" onclick="myFunction()" style="margin-left: 20px;"><img src="<?php echo base_url('uploads/camera.jpg');?>" alt="user-img" title="Web Cam" class="rounded-circle img-fluid" height="80" width="80" ></a>
    </div>
    <div class="row">
    <div class="col-sm-6">
    <div id="hideDefault" class="form-row">
    <h5>Capture Web camera image</h5>
    <div id="my_camera"></div>
    <input type=button value="Take Snapshot" onClick="take_snapshot()">
    
    


    </div></div><div class="col-sm-6"><div id="results" class="form-row"></div></div>
</div>



    </div>
    </div>
    </div>
    
    <div class="col-sm-3 control-label col-sm-offset-2">
    <button type="submit" class="btn btn-success" id="myButton">
    <i class="fa fa-check"></i> <?php echo get_phrase('save');?>
    </button>
    </div>
    </form>
    
    </div>
    
    </div>
    
    </div>
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>

        $(document).ready(function() {
            $('#referred_by').keyup(function() {
                var term = $(this).val();
               // alert(term);
                if (term !== '') {
                //  alert(term);
                    $.ajax({
                        url: '<?= site_url('admin/search_referal_doctor') ?>',
                        type: 'GET',
                        data: { term: term },
                        dataType: 'json',
                        success: function(data) {

                          $('#search-results').empty();
                            $.each(data, function(index, product) {
                                $('#search-results').append('<li class="search-item">' + product.referred_by + '</li>');
                            });

                            // Handle click event on search results
                            $('.search-item').click(function() {
                                var selectedItem = $(this).text();
                                
                                $('#referred_by').val(selectedItem);
                                $('#search-results').empty(); // Clear the results
                            });
                        
                        }
                    });
                } else {
                 // alert("hi");
                    $('#search-results').empty();
                }
            });
        });
    </script>


    <script>
      
  $(document).ready(function() {
  //  alert("hi");
    $('#myForm').submit(function(event) {
      event.preventDefault();

      var formData = new FormData($(this)[0]);
      $.ajax({
        url: '<?php echo site_url('admin/patient_create'); ?>',
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
  url: '<?php echo site_url('admin/prescription_load'); ?>',
  data: { inserted_id: inserted_id },
  success: function(response) {
    $('#prescription_print').html(response);
  //  alert(response);
  $('#modal_ajax').modal('hide');
   // PrintElemt('#prescription_print');
      PrintElemt('#prescription_print',inserted_id);
  }
});


  }
 function myFunction() {
  var x = document.getElementById("hideDefault");
  var w = document.getElementById("results");
  if (x.style.display === "none") {
    x.style.display = "block";
    w.style.display = "block";
  } else {
    x.style.display = "none";
    w.style.display = "none";
  }
}

function take_snapshot() {
      // take snapshot and get image data
      Webcam.snap( function(data_uri) {
        // display results in page
        
          
        Webcam.upload( data_uri, '<?php echo site_url('admin/upload_image'); ?>', function(code, text) {
			  var str = text;
  var res = str.substring(13);
  var imagePath = '<?php echo base_url('saved_images/'); ?>' + res;
          document.getElementById('results').innerHTML = 
          '<h5>Here is your image:</h5>' + 
		  '<input type="text" name="img" class="form-control" value="'+res+'">' + 
          '<img width="150" height="113" src="'+imagePath+'" />';
        } );  
      } );
    }
	$(".unHide").click(function() {
    $(".hideDefault").show();
});
    Webcam.set({
        width: 150,
        height: 150,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( '#my_camera' );
</script>


<script type="text/javascript">

    
    // function PrintElemt(elem) {
    //     // alert("hi2");
    //     var mywindow = window.open('', 'invoice', 'height=400,width=600');
    //     mywindow.document.write('<html><head><title>Prescription Invoice</title>');
    //     mywindow.document.write('<style type="text/css">');
    //     mywindow.document.write('@media print {');
    //         mywindow.document.write('.footer-image {');
    //             mywindow.document.write('position: fixed;');
    //             mywindow.document.write('bottom: 20px;');
    //             mywindow.document.write('left: 0;');
    //             mywindow.document.write('width: 100%;');
    //             mywindow.document.write('height: 80px;');
    //             mywindow.document.write('background-repeat: no-repeat;');
    //             mywindow.document.write('background-position: bottom left;');
    //             mywindow.document.write('}');
    //             mywindow.document.write('.watermark {');
    //                 mywindow.document.write('position: fixed;');
    //                 mywindow.document.write('top: 55%;');
    //                 mywindow.document.write('left: 55%;');
    //                 mywindow.document.write('width: 100%;');
    //                 mywindow.document.write('transform: translate(-50%, -50%);');
    //                 mywindow.document.write('opacity: 0.1;');
    //                 mywindow.document.write('}');
    //                 mywindow.document.write('.hidden-print {');
    //                     mywindow.document.write('display: none;');
    //                     mywindow.document.write('}');
    //                     mywindow.document.write('}');
    //                     mywindow.document.write('</style>');
    //                     mywindow.document.write('</head><body >');
    //                   // mywindow.document.write('<div class="footer-image"></div>');
    //                     //mywindow.document.write('<div class="watermark"></div>');
    //                     mywindow.document.write($(elem).html());
    //                     mywindow.document.write('</body></html>');
                        
    //                     setTimeout(function() {
    //                     mywindow.print();
    //                     mywindow.close();
    //                   window.location.reload();
    //                   }, 1000); // Wait for 1 second to ensure the image is fully loaded
    //                  return true;
    //                 }
    
    
    
    function PrintElemt(elem,inserted_id) {
      //alert("hi7");
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Prescription Invoice</title>');
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
                mywindow.document.write('hr{');
        mywindow.document.write('border: none;');
        mywindow.document.write('border-top: 1px solid black;');

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
                    mywindow.addEventListener('beforeunload', function() {
                      loadConsultationFee(inserted_id);
                          });
                    mywindow.close();
                     return true;
                        }



                        
                        function loadConsultationFee(inserted_id) {
                          //alert("hi8");
        $.ajax({
            url: '<?php echo site_url('admin/consultation_fee_load'); ?>',
            data: { inserted_id: inserted_id },
            success: function(response) {
             //   alert(response);
      $('#consultation_fee_print').html(response);
          $('#modal_ajax').modal('hide'); 
    PrintElemw('#consultation_fee_print');
            }
        });
    }



                    function PrintElemw(elem) {
        // alert("hi9");
        var mywindow = window.open('', 'invoice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Consultation Fees</title>');
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
                mywindow.document.write('hr{');
        mywindow.document.write('border: none;');
        mywindow.document.write('border-top: 1px solid black;');

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
                       window.location.reload();
                      }, 1000); // Wait for 1 second to ensure the image is fully loaded
                     return true;
                    }
                    </script>



    <script>
    // $(document).ready(function() {
    //     // Attach the change event to the DOB input element
    //     $("#birth_date").on("change", function() {
    //         // Get the chosen DOB value
    //         var dobValue = $(this).val();
            
    //         // Calculate age
    //         var age = calculateAge(dobValue);
            
    //         // Display the age in the output element
    //         $("#age").val(age);
    //     });
    // });
    
    // Function to calculate age based on DOB
    // function calculateAge(dob) {
    //     var today = new Date();
    //     var birthDate = new Date(dob);
    //     var age = today.getFullYear() - birthDate.getFullYear();
    //     var monthDiff = today.getMonth() - birthDate.getMonth();
    //     if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
    //         age--;
    //     }
    //         if (age <= 0) {
    //       age = 0;
    //         }
    //  return age;
    // }
    
    
    $(document).ready(function() {
        // Handle checkbox click event
        $("#sameAddressCheckbox").change(function() {
            if ($(this).is(":checked")) {
                // If checkbox is checked, copy current address to permanent address
                var current_street = $("#current_street").val();
                var current_city = $("#current_city").val();
                var current_state = $("#current_state").val();
                var current_postalcode = $("#current_postalcode").val();
                $("#permanent_street").val(current_street); 
                 $("#permanent_city").val(current_city); 
                 $("#permanent_state").val(current_state);
                  $("#permanent_postalcode").val(current_postalcode);
                
            
            } else {
                // If checkbox is unchecked, clear the permanent address field
                $("#permanent_street").val("");
                $("#permanent_city").val("");
                $("#permanent_state").val("");
                $("#permanent_postalcode").val("");
   

            }
        });
    });
    
       function disableButton() {
      var button = document.getElementById("myButton");
      button.disabled = true;
    }
    
    
    
    </script>
    <script>
  /*  $(document).ready(function() {
    $('#discount_type').change(function() {
        var selectedOption = $(this).val();
        if (selectedOption === 'fixed') {
            $('#discount_value_label').text('<?php echo get_phrase('Discount_Value');?>');
            $('#discount_value_field').show();
        } else if (selectedOption === 'percentage') {
            $('#discount_value_label').text('<?php echo get_phrase('Discount_Value');?> (%)');
            $('#discount_value_field').show();
        } else {
            $('#discount_value_field').hide();
        }
    });
});
*/
$(document).ready(function() {
    $('#discount_type').change(function() {
        var selectedOption = $(this).val();
        if (selectedOption === 'fixed') {
            $('#discount_value_label').text('<?php echo get_phrase('Discount_Value');?>');
            $('#discount_value_field').show();
            $('#discount_value_input').prop('required', true);
        } else if (selectedOption === 'percentage') {
            $('#discount_value_label').text('<?php echo get_phrase('Discount_Value');?> (%)');
            $('#discount_value_field').show();
            $('#discount_value_input').prop('required', true);
        } else {
            $('#discount_value_field').hide();
            $('#discount_value_input').prop('required', false);
        }
    });
});
</script>