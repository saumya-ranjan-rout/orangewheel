<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function clear_cache() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    function get_type_name_by_id($type, $type_id = '', $field = 'name') {
        $this->db->where($type . '_id', $type_id);
        $query = $this->db->get($type);
        $result = $query->result_array();
        foreach ($result as $row)
            return $row[$field];
        //return	$this->db->get_where($type,array($type.'_id'=>$type_id))->row()->$field;
    }

 function delete_patient_diagnosis($diag_id)
    {
        $this->db->where('id', $diag_id);
        $this->db->delete('patient_diagnosis');
    }

    
    function delete_patient_consultation_history_info($pres_id)
    {
        $this->db->where('id', $pres_id);
        $this->db->delete('patient_consultation_history');
    }
    // Create a new invoice.
    function create_invoice()
    {
        $data['title']              = $this->input->post('title');
        $data['invoice_number']     = $this->input->post('invoice_number');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp']      = $this->input->post('due_timestamp');
        $data['vat_percentage']     = $this->input->post('vat_percentage');
        $data['discount_amount']    = $this->input->post('discount_amount');
        $data['status']             = $this->input->post('status');

        $invoice_entries            = array();
        $descriptions               = $this->input->post('entry_description');
        $amounts                    = $this->input->post('entry_amount');
        $number_of_entries          = sizeof($descriptions);

        for ($i = 0; $i < $number_of_entries; $i++)
        {
            if ($descriptions[$i] != "" && $amounts[$i] != "")
            {
                $new_entry          = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries']    = json_encode($invoice_entries);
        $returned_array = null_checking($data);
        $this->db->insert('invoice', $returned_array);
    }

    function select_invoice_info()
    {
        return $this->db->get('invoice')->result_array();
    }

    function select_invoice_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('invoice', array('patient_id' => $patient_id))->result_array();
    }

    function update_invoice($invoice_id)
    {
        $data['title']              = $this->input->post('title');
        $data['invoice_number']     = $this->input->post('invoice_number');
        $data['patient_id']         = $this->input->post('patient_id');
        $data['creation_timestamp'] = $this->input->post('creation_timestamp');
        $data['due_timestamp']      = $this->input->post('due_timestamp');
        $data['vat_percentage']     = $this->input->post('vat_percentage');
        $data['discount_amount']    = $this->input->post('discount_amount');
        $data['status']             = $this->input->post('status');

        $invoice_entries            = array();
        $descriptions               = $this->input->post('entry_description');
        $amounts                    = $this->input->post('entry_amount');
        $number_of_entries          = sizeof($descriptions);

        for ($i = 0; $i < $number_of_entries; $i++)
        {
            if ($descriptions[$i] != "" && $amounts[$i] != "")
            {
                $new_entry          = array('description' => $descriptions[$i], 'amount' => $amounts[$i]);
                array_push($invoice_entries, $new_entry);
            }
        }
        $data['invoice_entries']    = json_encode($invoice_entries);
        $returned_array = null_checking($data);
        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('invoice', $returned_array);
    }

    function delete_invoice($invoice_id)
    {
        $this->db->where('invoice_id', $invoice_id);
        $this->db->delete('invoice');
    }

    function calculate_invoice_total_amount($invoice_number)
    {
        $total_amount           = 0;
        $invoice                = $this->db->get_where('invoice', array('invoice_number' => $invoice_number))->result_array();
        foreach ($invoice as $row)
        {
            $invoice_entries    = json_decode($row['invoice_entries']);
            foreach ($invoice_entries as $invoice_entry)
                $total_amount  += $invoice_entry->amount;

            $vat_amount         = $total_amount * $row['vat_percentage'] / 100;
            $grand_total        = $total_amount + $vat_amount - $row['discount_amount'];
        }

        return $grand_total;
    }



    //////system settings//////
    function update_system_settings() {
        $data['description'] = $this->input->post('system_name');
        $returned_array = null_checking($data);
        $this->db->where('type', 'system_name');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('system_title');
        $returned_array = null_checking($data);
        $this->db->where('type', 'system_title');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('address');
        $returned_array = null_checking($data);
        $this->db->where('type', 'address');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('phone');
        $returned_array = null_checking($data);
        $this->db->where('type', 'phone');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('paypal_email');
        $returned_array = null_checking($data);
        $this->db->where('type', 'paypal_email');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('currency');
        $returned_array = null_checking($data);
        $this->db->where('type', 'currency');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('system_email');
        $returned_array = null_checking($data);
        $this->db->where('type', 'system_email');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('buyer');
        $returned_array = null_checking($data);
        $this->db->where('type', 'buyer');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('purchase_code');
        $returned_array = null_checking($data);
        $this->db->where('type', 'purchase_code');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('language');
        $returned_array = null_checking($data);
        $this->db->where('type', 'language');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('text_align');
        $returned_array = null_checking($data);
        $this->db->where('type', 'text_align');
        $this->db->update('settings', $returned_array);

        move_uploaded_file($_FILES['logo']['tmp_name'], 'uploads/logo.png');
    }

    // SMS settings.
    function update_sms_settings() {

        $data['description'] = $this->input->post('clickatell_user');
        $returned_array = null_checking($data);
        $this->db->where('type', 'clickatell_user');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('clickatell_password');
        $returned_array = null_checking($data);
        $this->db->where('type', 'clickatell_password');
        $this->db->update('settings', $returned_array);

        $data['description'] = $this->input->post('clickatell_api_id');
        $returned_array = null_checking($data);
        $this->db->where('type', 'clickatell_api_id');
        $this->db->update('settings', $returned_array);
    }

    /////creates log/////
    function create_log($data) {
        $data['timestamp'] = strtotime(date('Y-m-d') . ' ' . date('H:i:s'));
        $data['ip'] = $_SERVER["REMOTE_ADDR"];
        $location = new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/' . $_SERVER["REMOTE_ADDR"]));
        $data['location'] = $location->City . ' , ' . $location->CountryName;
        $this->db->insert('log', $data);
    }

    ////////BACKUP RESTORE/////////
    function create_backup($type) {
        $this->load->dbutil();


        $options = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );


        if ($type == 'all') {
            $tables = array('');
            $file_name = 'system_backup';
        } else {
            $tables = array('tables' => array($type));
            $file_name = 'backup_' . $type;
        }

        $backup = & $this->dbutil->backup(array_merge($options, $tables));


        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
    }

    /////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
    function restore_backup() {
        move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
        $this->load->dbutil();


        $prefs = array(
            'filepath' => 'uploads/backup.sql',
            'delete_after_upload' => TRUE,
            'delimiter' => ';'
        );
        $restore = & $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }

    /////////DELETE DATA FROM TABLES///////////////
    function truncate($type) {
        if ($type == 'all') {
            $this->db->truncate('student');
            $this->db->truncate('mark');
            $this->db->truncate('teacher');
            $this->db->truncate('subject');
            $this->db->truncate('class');
            $this->db->truncate('exam');
            $this->db->truncate('grade');
        } else {
            $this->db->truncate($type);
        }
    }

    ////////IMAGE URL//////////
    function get_image_url($type = '', $id = '') {
        if (file_exists('uploads/' . $type . '_image/' . $id . '.jpg'))
            $image_url = base_url() . 'uploads/' . $type . '_image/' . $id . '.jpg';
        else
            $image_url = base_url() . 'uploads/user.jpg';

        return $image_url;
    }

    function save_department_info()
    {
        $data['name'] 		   = $this->input->post('name');
        $data['description']   = $this->input->post('description');
        $returned_array        = null_checking($data);
        $this->db->insert('department',$returned_array);

        $department_id = $this->db->insert_id();
        move_uploaded_file($_FILES['dept_icon']['tmp_name'], 'uploads/frontend/department_images/'. $department_id.'.png');
    }

    function select_department_info()
    {
        return $this->db->get('department')->result_array();
    }

    function update_department_info($department_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['description'] 	= $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->where('department_id',$department_id);
        $this->db->update('department',$returned_array);
        move_uploaded_file($_FILES['dept_icon']['tmp_name'], 'uploads/frontend/department_images/'. $department_id.'.png');
    }

    function delete_department_info($department_id)
    {
        if (file_exists(base_url('uploads/frontend/department_images/'.$department_id.'.png'))) {
            unlink(base_url('uploads/frontend/department_images/'.$department_id.'.png'));
        }
        $this->db->where('department_id',$department_id);
        $this->db->delete('department');
    }

   function save_doctor_info()
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
           $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
          $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        $data['phone']          = $this->input->post('phone');
        $data['department_id'] 	= $this->input->post('department_id');
        $data['profile'] 	      = $this->input->post('profile');
        
        $social_links = array();
        $social_links_data['facebook'] =  $this->input->post('facebook');
        $social_links_data['twitter'] =  $this->input->post('twitter');
        $social_links_data['google_plus'] =  $this->input->post('google_plus');
        $social_links_data['linkedin'] =  $this->input->post('linkedin');
        array_push($social_links, $social_links_data);
        
        $data['social_links'] = json_encode($social_links);
        
           $validation = email_validation_on_create($data['email']);
       $staffid_validation = $this->staffid_validation_on_create($data['staff_id']);
        if ($validation == 1) {
             if ($staffid_validation == 1) {
        $returned_array = null_checking($data);
        $this->db->insert('doctor',$returned_array);
        
        $doctor_id  =   $this->db->insert_id();
        
        $this->email_model->account_opening_email('doctor', $data['email'], $this->input->post('password'));
        
        move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/doctor_image/' . $doctor_id . '.jpg');
         move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/doctor_image/' . $doctor_id . '_aadhar.jpg');
          move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/doctor_image/' . $doctor_id . '_pan.jpg');
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
            redirect(site_url($type.'/doctor'), 'refresh');
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            redirect(site_url($type.'/doctor'), 'refresh');
        }
    }
    
    function select_doctor_info()
    {
        return $this->db->get('doctor')->result_array();
    }
    
    function update_doctor_info($doctor_id)
    {
        $type = $this->session->userdata('login_type');
        
        
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
           $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
          $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        $data['phone']          = $this->input->post('phone');
        $data['department_id'] 	= $this->input->post('department_id');
        $data['profile'] 	      = $this->input->post('profile');
        
        $social_links = array();
        $social_links_data['facebook'] =  $this->input->post('facebook');
        $social_links_data['twitter'] =  $this->input->post('twitter');
        $social_links_data['google_plus'] =  $this->input->post('google_plus');
        $social_links_data['linkedin'] =  $this->input->post('linkedin');
        array_push($social_links, $social_links_data);
        
        $data['social_links'] = json_encode($social_links);
        
        $validation = email_validation_on_edit($data['email'], $doctor_id, 'doctor');
         $staffid_validation = $this->staffid_validation_on_edit($data['staff_id'], $doctor_id, 'doctor');
        if ($validation == 1){
            if ($staffid_validation == 1){
            $returned_array = null_checking($data);
            $this->db->where('doctor_id',$doctor_id);
            $this->db->update('doctor',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/doctor_image/' . $doctor_id . '.jpg');
              move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/doctor_image/' . $doctor_id . '_aadhar.jpg');
          move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/doctor_image/' . $doctor_id . '_pan.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        }
    }
    
    function delete_doctor_info($doctor_id)
    {
        $this->db->where('doctor_id',$doctor_id);
        $this->db->delete('doctor');
    }
    
    function save_patient_info()
    {
        $type = $this->session->userdata('login_type');
         if( $data['birth_date'] =='' ){
             $data['birth_date'] ='';
         }else{
              $data['birth_date']     = strtotime($this->input->post('birth_date'));
         }
        $data['code']       = $this->input->post('code');
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        // $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['sex']            = $this->input->post('sex');
       
        
       
        
        
        $data['age']            = $this->input->post('age');
        $data['visit_type']            = $this->input->post('visit_type');
           $data['visit_date'] = (new DateTime($this->input->post('visit_date')))->format('Y-m-d');
        $data['blood_group'] 	= $this->input->post('blood_group');
        $data['marital_status']       = $this->input->post('marital_status');
        $data['weight']       = $this->input->post('weight');
        $data['height']       = $this->input->post('height');
        $data['remarks']       = $this->input->post('remarks');
        $data['guardian_name']       = $this->input->post('guardian_name');
        $data['guardian_no']       = $this->input->post('guardian_no');
        $data['referred_by']       = $this->input->post('referred_by');
        $data['id_card'] 	      = $this->input->post('id_card');
        $data['gst_no']            = $this->input->post('gst_no');
        $data['consultation_fee']       = $this->input->post('consultation_fee');
        $data['discount_type']       = $this->input->post('discount_type');
        $data['discount_value']       = $this->input->post('discount_value');
        $data['commission_add']       = $this->input->post('commission_add');
        $data['current_street']       = $this->input->post('current_street');
        $data['current_city']       = $this->input->post('current_city');
        $data['current_state']       = $this->input->post('current_state');
        $data['current_postalcode']       = $this->input->post('current_postalcode');
        $data['permanent_street']       = $this->input->post('permanent_street');
        $data['permanent_city']       = $this->input->post('permanent_city');
        $data['permanent_state']       = $this->input->post('permanent_state');
        $data['permanent_postalcode']       = $this->input->post('permanent_postalcode');
         $data['id_card_file'] 	      = $_FILES["id_card_file"]["name"];
        
        if ($data['discount_type'] == 'percentage') {
    $to = ($data['consultation_fee'] * $data['discount_value']) / 100;
    $total = $data['consultation_fee'] - $to;
} else if ($data['discount_type'] == 'fixed') {
    $total = $data['consultation_fee'] - $data['discount_value'];
} else {
    $total = $data['consultation_fee'];
}


        // $validation = email_validation_on_create($data['email']);
        // if ($validation == 1) {
           // $returned_array = null_checking($data);
            $this->db->insert('patient',$data);
            $patient_id  =   $this->db->insert_id();
           // $this->email_model->account_opening_email('patient', $data['email'], $this->input->post('password'));
               if($this->input->post('img') != ''){
            rename('saved_images/'. $this->input->post('img'), 'uploads/patient_image/'. $patient_id . '.jpg');
            }
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/patient_image/' . $patient_id . '.jpg');
            move_uploaded_file($_FILES["id_card_file"]["tmp_name"], 'uploads/patient_image/' . $patient_id . '_id.jpg');
        //saumya new 
        if ($patient_id != '') {
            
             $consultation_data = array(
            'patient_id' => $patient_id,
            'consultation_name' => 'Consultation Charge', // Replace with the actual column name
            'qty' => '1',
            'price' => $data['consultation_fee'],
            'discount_type' => $data['discount_type'],
            'discount_price' => $data['discount_value'],
            'total_price' => $total, // Calculate total price based on your requirements
              'referred_by' =>$data['referred_by'] ,
                'visit_type' => $data['visit_type'], 
                  'remarks' =>$data['remarks'], 
            'patient_status'=>'new',
            'date' => date('d-m-Y'), // Replace with the actual column name
            'login_type'      => $type
        );
        $this->db->insert('patient_consultation_history', $consultation_data);




            return $patient_id ;
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('Error Occured'));
            redirect(site_url($type.'/patient'), 'refresh');
        }
    }
    
    
    
     function save_patient_info_saumya()
    {
        $type = $this->session->userdata('login_type');
        
        $data['code']       = $this->input->post('code');
        $data['name'] 		= $this->input->post('name');
        // $data['email'] 		= $this->input->post('email');
        // $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['sex']            = $this->input->post('sex');
        $data['birth_date']     = strtotime($this->input->post('birth_date'));
        $data['age']            = $this->input->post('age');
        $data['blood_group'] 	= $this->input->post('blood_group');
        $data['marital_status']       = $this->input->post('marital_status');
        $data['weight']       = $this->input->post('weight');
         $data['height']       = $this->input->post('height');
          $data['remarks']       = $this->input->post('remarks');
        $data['guardian_name']       = $this->input->post('guardian_name');
        $data['guardian_no']       = $this->input->post('guardian_no');
        $data['referred_by']       = $this->input->post('referred_by');
        $data['commission_add']       = $this->input->post('commission_add');
        $data['current_street']       = $this->input->post('current_street');
        $data['current_city']       = $this->input->post('current_city');
        $data['current_state']       = $this->input->post('current_state');
        $data['current_postalcode']       = $this->input->post('current_postalcode');
        $data['permanent_street']       = $this->input->post('permanent_street');
        $data['permanent_city']       = $this->input->post('permanent_city');
        $data['permanent_state']       = $this->input->post('permanent_state');
        $data['permanent_postalcode']       = $this->input->post('permanent_postalcode');
        
        // $validation = email_validation_on_create($data['email']);
        // if ($validation == 1) {
           // $returned_array = null_checking($data);
            $this->db->insert('patient',$data);
            $patient_id  =   $this->db->insert_id();
           // $this->email_model->account_opening_email('patient', $data['email'], $this->input->post('password'));
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/patient_image/' . $patient_id . '.jpg');
        //saumya new 
        if ($patient_id != '') {
            return $patient_id ;
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('Error Occured'));
            redirect(site_url($type.'/patient'), 'refresh');
        }
    }

    function save_patient_info_old()
    {
        $type = $this->session->userdata('login_type');
        
        $data['code']       = $this->input->post('code');
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['sex']            = $this->input->post('sex');
        $data['birth_date']     = strtotime($this->input->post('birth_date'));
        $data['age']            = $this->input->post('age');
        $data['blood_group'] 	= $this->input->post('blood_group');
        $data['marital_status']       = $this->input->post('marital_status');
        $data['weight']       = $this->input->post('weight');
         $data['height']       = $this->input->post('height');
          $data['remarks']       = $this->input->post('remarks');
        $data['guardian_name']       = $this->input->post('guardian_name');
        $data['guardian_no']       = $this->input->post('guardian_no');
        $data['referred_by']       = $this->input->post('referred_by');
        $data['commission_add']       = $this->input->post('commission_add');
        $data['current_street']       = $this->input->post('current_street');
        $data['current_city']       = $this->input->post('current_city');
        $data['current_state']       = $this->input->post('current_state');
        $data['current_postalcode']       = $this->input->post('current_postalcode');
        $data['permanent_street']       = $this->input->post('permanent_street');
        $data['permanent_city']       = $this->input->post('permanent_city');
        $data['permanent_state']       = $this->input->post('permanent_state');
        $data['permanent_postalcode']       = $this->input->post('permanent_postalcode');
        
       // $validation = email_validation_on_create($data['email']);
       // if ($validation == 1) {
            $returned_array = null_checking($data);
            $this->db->insert('patient',$returned_array);
            $patient_id  =   $this->db->insert_id();
           // $this->email_model->account_opening_email('patient', $data['email'], $this->input->post('password'));
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/patient_image/' . $patient_id . '.jpg');
      //  }
       /* else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            redirect(site_url($type.'/patient'), 'refresh');
        }*/
    }
    
    
    function select_patient_info()
    {
        //return $this->db->get('patient')->result_array();
        $this->db->select('patient.*, blood_bank.blood_group as bloodgroup');
        $this->db->from('patient');
        $this->db->join('blood_bank', 'patient.blood_group = blood_bank.blood_group_id ', 'left');
        return $this->db->get()->result_array();
    }
    
       function select_prescription_info()
    {          
      $this->db->select('prescription.*,doctor.name as dname,patient.name,patient.phone,patient.sex,patient.code,patient.guardian_name,patient.guardian_no')
    ->from('prescription')
    ->join('doctor', 'prescription.doctor_id = doctor.doctor_id')
    ->join('patient', 'prescription.patient_id = patient.patient_id');
    
      return $this->db->get()->result_array();
    }
    
     function prescription_info()
    {          
      $this->db->select('prescription.*,doctor.name as dname,patient.name,patient.phone,patient.sex,patient.code,patient.guardian_name,patient.guardian_no')
    ->from('prescription')
    ->join('doctor', 'prescription.doctor_id = doctor.doctor_id')
    ->join('patient', 'prescription.patient_id = patient.patient_id')
     ->group_by('prescription.patient_id');
      return $this->db->get()->result_array();
    }
    
    function select_patient_info_by_patient_id( $patient_id = '' )
    {
        return $this->db->get_where('patient', array('patient_id' => $patient_id))->result_array();
    }
    function update_patient_info($patient_id)
    {
        $type             = $this->session->userdata('login_type');
         if( $data['birth_date'] =='' ){
             $data['birth_date'] ='';
         }else{
              $data['birth_date']     = strtotime($this->input->post('birth_date'));
         }
         
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['phone']          = $this->input->post('phone');
        $data['sex']            = $this->input->post('sex');
      //  $data['birth_date']     = strtotime($this->input->post('birth_date'));
        $data['age']            = $this->input->post('age');
        $data['visit_type']            = $this->input->post('visit_type');
        // $data['visit_date'] = (new DateTime($this->input->post('visit_date')))->format('Y-m-d');
           $data['visit_date'] = DateTime::createFromFormat('m/d/Y', $this->input->post('visit_date'))->format('Y-m-d');
        $data['blood_group'] 	= $this->input->post('blood_group');
        $data['marital_status']       = $this->input->post('marital_status');
        $data['weight']       = $this->input->post('weight');
        $data['height']       = $this->input->post('height');
        $data['remarks']       = $this->input->post('remarks');
        $data['guardian_name']       = $this->input->post('guardian_name');
        $data['guardian_no']       = $this->input->post('guardian_no');
        $data['referred_by']       = $this->input->post('referred_by');
        $data['id_card'] 	      = $this->input->post('id_card');
        $data['gst_no']            = $this->input->post('gst_no');
        $data['consultation_fee']       = $this->input->post('consultation_fee');
        $data['discount_type']       = $this->input->post('discount_type');
        $data['discount_value']       = $this->input->post('discount_value');
        $data['commission_add']       = $this->input->post('commission_add');
        $data['current_street']       = $this->input->post('current_street');
        $data['current_city']       = $this->input->post('current_city');
        $data['current_state']       = $this->input->post('current_state');
        $data['current_postalcode']       = $this->input->post('current_postalcode');
        $data['permanent_street']       = $this->input->post('permanent_street');
        $data['permanent_city']       = $this->input->post('permanent_city');
        $data['permanent_state']       = $this->input->post('permanent_state');
        $data['permanent_postalcode']       = $this->input->post('permanent_postalcode');
         $data['id_card_file'] 	      = $_FILES["id_card_file"]["name"];
         
      //  $validation = email_validation_on_edit($data['email'], $patient_id, 'patient');
      //  if ($validation == 1) {
            $returned_array = null_checking($data);
            $this->db->where('patient_id',$patient_id);
            $this->db->update('patient',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/patient_image/' . $patient_id . '.jpg');
            move_uploaded_file($_FILES["id_card_file"]["tmp_name"], 'uploads/patient_image/' . $patient_id . '_id.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
      //  }
       /* else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        }*/
        
    }
    function update_patient_info_saumya($patient_id)
    {
        $type             = $this->session->userdata('login_type');
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['phone']          = $this->input->post('phone');
        $data['sex']            = $this->input->post('sex');
        $data['birth_date']     = strtotime($this->input->post('birth_date'));
        $data['age']            = $this->input->post('age');
        $data['blood_group'] 	= $this->input->post('blood_group');
        $data['marital_status']       = $this->input->post('marital_status');
        $data['weight']       = $this->input->post('weight');
          $data['height']       = $this->input->post('height');
            $data['remarks']       = $this->input->post('remarks');
        $data['guardian_name']       = $this->input->post('guardian_name');
        $data['guardian_no']       = $this->input->post('guardian_no');
        $data['referred_by']       = $this->input->post('referred_by');
        $data['commission_add']       = $this->input->post('commission_add');
        $data['current_street']       = $this->input->post('current_street');
        $data['current_city']       = $this->input->post('current_city');
        $data['current_state']       = $this->input->post('current_state');
        $data['current_postalcode']       = $this->input->post('current_postalcode');
        $data['permanent_street']       = $this->input->post('permanent_street');
        $data['permanent_city']       = $this->input->post('permanent_city');
        $data['permanent_state']       = $this->input->post('permanent_state');
        $data['permanent_postalcode']       = $this->input->post('permanent_postalcode');
        $validation = email_validation_on_edit($data['email'], $patient_id, 'patient');
        if ($validation == 1) {
            $returned_array = null_checking($data);
            $this->db->where('patient_id',$patient_id);
            $this->db->update('patient',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/patient_image/' . $patient_id . '.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        }
        
    }
    
    function delete_patient_info($patient_id)
    {
        $this->db->where('patient_id',$patient_id);
        $this->db->delete('patient');
    }
    
     function save_nurse_info()
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_create($data['email']);
        $staffid_validation = $this->staffid_validation_on_create($data['staff_id']);
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->insert('nurse',$returned_array);
            $nurse_id  =   $this->db->insert_id();
            $this->email_model->account_opening_email('nurse', $data['email'], $this->input->post('password'));
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/nurse_image/' . $nurse_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/nurse_image/' . $nurse_id . '_pan.jpg');
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/nurse_image/' . $nurse_id . '.jpg');
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
            redirect(site_url($type.'/nurse'), 'refresh');
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            redirect(site_url($type.'/nurse'), 'refresh');
        }
        
    }
    
    function select_nurse_info()
    {
        $this->db->select('nurse.*, blood_bank.blood_group as bloodgroup');
        $this->db->from('nurse');
        $this->db->join('blood_bank', 'nurse.blood_group = blood_bank.blood_group_id ', 'left');
        return $this->db->get()->result_array();
    }
    
    function update_nurse_info($nurse_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['email'] 		= $this->input->post('email');
        $data['phone']      = $this->input->post('phone');
        $data['staff_id']   = $this->input->post('staff_id');
        $data['gender'] 	= $this->input->post('gender');
        $data['blood_group']  = $this->input->post('blood_group');
        $data['current_address'] = $this->input->post('current_address');
        $data['permanent_address'] = $this->input->post('permanent_address');
        $data['dob'] = $this->input->post('dob');
        $data['doj'] = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_edit($data['email'], $nurse_id, 'nurse');
        $staffid_validation = $this->staffid_validation_on_edit($data['staff_id'], $nurse_id, 'nurse');
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->where('nurse_id',$nurse_id);
            $this->db->update('nurse',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/nurse_image/' . $nurse_id . '.jpg');
              move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/nurse_image/' . $nurse_id . '_aadhar.jpg');
          move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/nurse_image/' . $nurse_id . '_pan.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        } 
    }
    
    function delete_nurse_info($nurse_id)
    {
        $this->db->where('nurse_id',$nurse_id);
        $this->db->delete('nurse');
    }

   function save_pharmacist_info()
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_create($data['email']);
        $staffid_validation = $this->staffid_validation_on_create($data['staff_id']);
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->insert('pharmacist',$returned_array);
            $pharmacist_id  =   $this->db->insert_id();
            $this->email_model->account_opening_email('pharmacist', $data['email'], $this->input->post('password'));
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/pharmacist_image/' . $pharmacist_id . '.jpg');
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/pharmacist_image/' . $pharmacist_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/pharmacist_image/' . $pharmacist_id . '_pan.jpg');
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
            redirect(site_url($type.'/pharmacist'), 'refresh');
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            redirect(site_url($type.'/pharmacist'), 'refresh');
        }
    }
    
    function select_pharmacist_info()
    {
      
        $this->db->select('pharmacist.*, blood_bank.blood_group as bloodgroup');
        $this->db->from('pharmacist');
        $this->db->join('blood_bank', 'pharmacist.blood_group = blood_bank.blood_group_id ', 'left');
        return $this->db->get()->result_array();

        
    }
    
    function update_pharmacist_info($pharmacist_id)
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_edit($data['email'], $pharmacist_id, 'pharmacist');
        $staffid_validation = $this->staffid_validation_on_edit($data['staff_id'], $pharmacist_id, 'pharmacist');
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->where('pharmacist_id',$pharmacist_id);
            $this->db->update('pharmacist',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/pharmacist_image/' . $pharmacist_id . '.jpg');
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/pharmacist_image/' . $pharmacist_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/pharmacist_image/' . $pharmacist_id . '_pan.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        } 
        
    }
    
    function delete_pharmacist_info($pharmacist_id)
    {
        $this->db->where('pharmacist_id',$pharmacist_id);
        $this->db->delete('pharmacist');
    }
    
    function save_laboratorist_info()
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_create($data['email']);
        $staffid_validation = $this->staffid_validation_on_create($data['staff_id']);
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->insert('laboratorist',$returned_array);
            $laboratorist_id  =   $this->db->insert_id();
            $this->email_model->account_opening_email('laboratorist', $data['email'], $this->input->post('password'));
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/laboratorist_image/' . $laboratorist_id . '.jpg');
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/laboratorist_image/' . $laboratorist_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/laboratorist_image/' . $laboratorist_id . '_pan.jpg');
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
            redirect(site_url($type.'/laboratorist'), 'refresh');
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            redirect(site_url($type.'/laboratorist'), 'refresh');
        }
        
    }
    
    function select_laboratorist_info()
    {
       $this->db->select('laboratorist.*, blood_bank.blood_group as bloodgroup');
       $this->db->from('laboratorist');
       $this->db->join('blood_bank', 'laboratorist.blood_group = blood_bank.blood_group_id', 'left');
       return $this->db->get()->result_array();
    }
    
    function update_laboratorist_info($laboratorist_id)
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');

        $validation = email_validation_on_edit($data['email'], $laboratorist_id, 'laboratorist');
        $staffid_validation = $this->staffid_validation_on_edit($data['staff_id'], $laboratorist_id, 'laboratorist');
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->where('laboratorist_id',$laboratorist_id);
            $this->db->update('laboratorist',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/laboratorist_image/' . $laboratorist_id . '.jpg');
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/laboratorist_image/' . $laboratorist_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/laboratorist_image/' . $laboratorist_id . '_pan.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        }
        
    }
    
    function delete_laboratorist_info($laboratorist_id)
    {
        $this->db->where('laboratorist_id',$laboratorist_id);
        $this->db->delete('laboratorist');
    }
    
    

    function save_accountant_info()
    {
        $type = $this->session->userdata('login_type');
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_create($data['email']);
        $staffid_validation = $this->staffid_validation_on_create($data['staff_id']);
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->insert('accountant',$returned_array);
            $accountant_id  =   $this->db->insert_id();
            $this->email_model->account_opening_email('accountant', $data['email'], $this->input->post('password'));
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/accountant_image/' . $accountant_id . '.jpg');
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/accountant_image/' . $accountant_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/accountant_image/' . $accountant_id . '_pan.jpg');
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
            redirect(site_url($type.'/accountant'), 'refresh');
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            redirect(site_url($type.'/accountant'), 'refresh');
        }
        
    }
    
    function select_accountant_info()
    {
        $this->db->select('accountant.*, blood_bank.blood_group as bloodgroup');
        $this->db->from('accountant');
        $this->db->join('blood_bank', 'accountant.blood_group = blood_bank.blood_group_id', 'left');
        return $this->db->get()->result_array();
    }
    
    function update_accountant_info($accountant_id)
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_edit($data['email'], $accountant_id, 'accountant');
        $staffid_validation = $this->staffid_validation_on_edit($data['staff_id'], $accountant_id, 'accountant');
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->where('accountant_id',$accountant_id);
            $this->db->update('accountant',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/accountant_image/' . $accountant_id . '.jpg');
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/accountant_image/' . $accountant_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/accountant_image/' . $accountant_id . '_pan.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        }
        
    }
    
    function delete_accountant_info($accountant_id)
    {
        $this->db->where('accountant_id',$accountant_id);
        $this->db->delete('accountant');
    }
    

   function save_receptionist_info()
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_create($data['email']);
        $staffid_validation = $this->staffid_validation_on_create($data['staff_id']);
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->insert('receptionist',$returned_array);
            $receptionist_id  =   $this->db->insert_id();
            $this->email_model->account_opening_email('receptionist', $data['email'], $this->input->post('password'));
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/receptionist_image/' . $receptionist_id . '.jpg');
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/receptionist_image/' . $receptionist_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/receptionist_image/' . $receptionist_id . '_pan.jpg');
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
            redirect(site_url($type.'/receptionist'), 'refresh');
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            redirect(site_url($type.'/receptionist'), 'refresh');
        }
        
    }
    
    function select_receptionist_info()
    {
       $this->db->select('receptionist.*, blood_bank.blood_group as bloodgroup');
       $this->db->from('receptionist');
       $this->db->join('blood_bank', 'receptionist.blood_group = blood_bank.blood_group_id', 'left');
       return $this->db->get()->result_array();
    }
    
    function update_receptionist_info($receptionist_id)
    {
        $data['staff_id'] 		      = $this->input->post('staff_id');
        $data['name'] 		      = $this->input->post('name');
        $data['email'] 		      = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['phone']          = $this->input->post('phone');
        $data['gender'] 		      = $this->input->post('gender');
        $data['blood_group'] 		      = $this->input->post('blood_group');
        $data['current_address'] 	      = $this->input->post('current_address');
        $data['permanent_address'] 	      = $this->input->post('permanent_address');
        $data['dob'] 	      = $this->input->post('dob');
        $data['doj'] 	      = $this->input->post('doj');
        $data['basic_salary'] 	      = $this->input->post('basic_salary');
        $data['aadhar_card'] 	      = $this->input->post('aadhar_card');
        $data['existing_pfno'] 	      = $this->input->post('existing_pfno');
        $data['pan_card'] 	      = $this->input->post('pan_card');  
        $data['father_name'] 	      = $this->input->post('father_name');
        $data['mother_name'] 	      = $this->input->post('mother_name');
        
        $validation = email_validation_on_edit($data['email'], $receptionist_id, 'receptionist');
        $staffid_validation = $this->staffid_validation_on_edit($data['staff_id'], $receptionist_id, 'receptionist');
        if ($validation == 1) {
            if ($staffid_validation == 1) {
            $returned_array = null_checking($data);
            $this->db->where('receptionist_id',$receptionist_id);
            $this->db->update('receptionist',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/receptionist_image/' . $receptionist_id . '.jpg');
            move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/receptionist_image/' . $receptionist_id . '_aadhar.jpg');
            move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/receptionist_image/' . $receptionist_id . '_pan.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        }
        
    }
    
    function delete_receptionist_info($receptionist_id)
    {
        $this->db->where('receptionist_id',$receptionist_id);
        $this->db->delete('receptionist');
    }
    
    /***************** Tarini 16-06-2023****************************/

    function save_hr_info()
    {
        $data['staff_id']             = $this->input->post('staff_id');
        $data['name']             = $this->input->post('name');
        $data['email']            = $this->input->post('email');
        $data['password']       = sha1($this->input->post('password'));
        $data['gender']               = $this->input->post('gender');
        $data['blood_group']              = $this->input->post('blood_group');
        $data['current_address']          = $this->input->post('current_address');
        $data['permanent_address']        = $this->input->post('permanent_address');
        $data['dob']          = $this->input->post('dob');
        $data['doj']          = $this->input->post('doj');
           $data['basic_salary']          = $this->input->post('basic_salary');
        $data['aadhar_card']          = $this->input->post('aadhar_card');
          $data['existing_pfno']          = $this->input->post('existing_pfno');
        $data['pan_card']         = $this->input->post('pan_card');  
        $data['father_name']          = $this->input->post('father_name');
        $data['mother_name']          = $this->input->post('mother_name');
        $data['phone']          = $this->input->post('phone');
        $data['department_id']  = $this->input->post('department_id');
        $data['profile']          = $this->input->post('profile');
        
        $social_links = array();
        $social_links_data['facebook'] =  $this->input->post('facebook');
        $social_links_data['twitter'] =  $this->input->post('twitter');
        $social_links_data['google_plus'] =  $this->input->post('google_plus');
        $social_links_data['linkedin'] =  $this->input->post('linkedin');
        array_push($social_links, $social_links_data);
        
        $data['social_links'] = json_encode($social_links);
        
        $validation = email_validation_on_create($data['email']);
       $staffid_validation = $this->staffid_validation_on_create($data['staff_id']);
        if ($validation == 1) {
             if ($staffid_validation == 1) {
        $returned_array = null_checking($data);
        $this->db->insert('hr',$returned_array);
        
        $hr_id  =   $this->db->insert_id();
        
        $this->email_model->account_opening_email('hr', $data['email'], $this->input->post('password'));
        
        move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/hr_image/' . $hr_id . '.jpg');
         move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/hr_image/' . $hr_id . '_aadhar.jpg');
          move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/hr_image/' . $hr_id . '_pan.jpg');
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
            redirect(site_url($type.'/hr'), 'refresh');
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            redirect(site_url($type.'/hr'), 'refresh');
        }
    }
    
    function select_hr_info()
    {
        return $this->db->get('hr')->result_array();
    }
    
    function update_hr_info($hr_id)
    {
        $type = $this->session->userdata('login_type');
        
        
        $data['staff_id']             = $this->input->post('staff_id');
        $data['name']             = $this->input->post('name');
        $data['email']            = $this->input->post('email');
        $data['gender']               = $this->input->post('gender');
        $data['blood_group']              = $this->input->post('blood_group');
        $data['current_address']          = $this->input->post('current_address');
        $data['permanent_address']        = $this->input->post('permanent_address');
        $data['dob']          = $this->input->post('dob');
        $data['doj']          = $this->input->post('doj');
           $data['basic_salary']          = $this->input->post('basic_salary');
        $data['aadhar_card']          = $this->input->post('aadhar_card');
          $data['existing_pfno']          = $this->input->post('existing_pfno');
        $data['pan_card']         = $this->input->post('pan_card');  
        $data['father_name']          = $this->input->post('father_name');
        $data['mother_name']          = $this->input->post('mother_name');
        $data['phone']          = $this->input->post('phone');
        $data['department_id']  = $this->input->post('department_id');
        $data['profile']          = $this->input->post('profile');
        
        $social_links = array();
        $social_links_data['facebook'] =  $this->input->post('facebook');
        $social_links_data['twitter'] =  $this->input->post('twitter');
        $social_links_data['google_plus'] =  $this->input->post('google_plus');
        $social_links_data['linkedin'] =  $this->input->post('linkedin');
        array_push($social_links, $social_links_data);
        
        $data['social_links'] = json_encode($social_links);
        
        $validation = email_validation_on_edit($data['email'], $hr_id, 'hr');
         $staffid_validation = $this->staffid_validation_on_edit($data['staff_id'], $hr_id, 'hr');
        if ($validation == 1){
            if ($staffid_validation == 1){
            $returned_array = null_checking($data);
            $this->db->where('hr_id',$hr_id);
            $this->db->update('hr',$returned_array);
            move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/hr_image/' . $hr_id . '.jpg');
              move_uploaded_file($_FILES["aadhar_card_file"]["tmp_name"], 'uploads/hr_image/' . $hr_id . '_aadhar.jpg');
          move_uploaded_file($_FILES["pan_card_file"]["tmp_name"], 'uploads/hr_image/' . $hr_id . '_pan.jpg');
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_staffid'));
        }
        }
        else{
            $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
        }
    }
    
    function delete_hr_info($hr_id)
    {
        $this->db->where('hr_id',$hr_id);
        $this->db->delete('hr');
    }


    /***************** Tarini 16-06-2023****************************/

    function save_bed_allotment_info()
    {
        $data['bed_id']                 = $this->input->post('bed_id');
        $data['patient_id'] 		    = $this->input->post('patient_id');
        $data['allotment_timestamp'] 	= strtotime($this->input->post('allotment_timestamp'));
       // $data['discharge_timestamp']    = strtotime($this->input->post('discharge_timestamp'));
        $returned_array = null_checking($data);
        $this->db->insert('bed_allotment',$returned_array);
        $data1['status']    = 'booked';
        $returned_array1 = null_checking($data1);
        $this->db->where('bed_id',$data['bed_id']);
        $this->db->update('bed',$returned_array1);
    }

    function select_bed_allotment_info()
    {
        return $this->db->get('bed_allotment')->result_array();
    }

    function update_bed_allotment_info($bed_allotment_id)
    {
        $data['bed_id']                 = $this->input->post('bed_id');
        $data['patient_id'] 		= $this->input->post('patient_id');
        $data['allotment_timestamp'] 	= strtotime($this->input->post('allotment_timestamp'));
       // $data['discharge_timestamp']    = strtotime($this->input->post('discharge_timestamp'));
        $returned_array = null_checking($data);
        $this->db->where('bed_allotment_id',$bed_allotment_id);
        $this->db->update('bed_allotment',$returned_array);
    }
  function discharge_bed_allotment_info($bed_allotment_id)
    {
        $data['bed_id']                 = $this->input->post('bed_id');
       
       $data['discharge_timestamp']    = strtotime($this->input->post('discharge_timestamp'));
        $returned_array = null_checking($data);
        $this->db->where('bed_allotment_id',$bed_allotment_id);
        $this->db->update('bed_allotment',$returned_array);
        
         $this->db->set('status', 'available');
    $this->db->where('bed_id', $data['bed_id']);
    $this->db->update('bed');
        
    }
    function delete_bed_allotment_info($bed_allotment_id)
    {
        $this->db->where('bed_allotment_id',$bed_allotment_id);
        $this->db->delete('bed_allotment');
    }

    function select_blood_bank_info()
    {
        return $this->db->get('blood_bank')->result_array();
    }

    function update_blood_bank_info($blood_group_id)
    {
        $data['status']    = $this->input->post('status');

        $returned_array = null_checking($data);
        $this->db->where('blood_group_id',$blood_group_id);
        $this->db->update('blood_bank',$returned_array);
    }

    function save_report_info()
    {
        $data['type'] 		= $this->input->post('type');
        $data['description']    = $this->input->post('description');
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['patient_id']     = $this->input->post('patient_id');

        $login_type             = $this->session->userdata('login_type');
        if($login_type=='nurse')
            $data['doctor_id']  = $this->input->post('doctor_id');
        else $data['doctor_id'] = $this->session->userdata('login_user_id');

        // Multiple File Upload
        $file_names = array();
        for ($i = 0; $i < count($_FILES['userfile']['name']); $i++)
            if($_FILES['userfile']['name'][$i] != '') {
                array_push($file_names, $_FILES['userfile']['name'][$i]);
                move_uploaded_file($_FILES['userfile']['tmp_name'][$i], 'uploads/report_file/' . $_FILES['userfile']['name'][$i]);
            }

        if(!empty($file_names))
            $data['files']  = json_encode($file_names);

        $returned_array = null_checking($data);
        $this->db->insert('report',$returned_array);
    }

    function select_report_info()
    {
        return $this->db->get('report')->result_array();
    }

    function update_report_info($report_id)
    {
        $data['type'] 		= $this->input->post('type');
        $data['description']    = $this->input->post('description');
        $data['timestamp']      = strtotime($this->input->post('timestamp'));
        $data['patient_id']     = $this->input->post('patient_id');

        $login_type             = $this->session->userdata('login_type');
        if($login_type=='nurse')
            $data['doctor_id']  = $this->input->post('doctor_id');
        else $data['doctor_id'] = $this->session->userdata('login_user_id');

        $returned_array = null_checking($data);
        $this->db->where('report_id',$report_id);
        $this->db->update('report',$returned_array);
    }

    function delete_report_info($report_id)
    {
        $files = $this->db->get_where('report', array('report_id' => $report_id))->row()->files;

        if($files != '') {
            $files = json_decode($files);

            foreach ($files as $file_name)
                unlink(base_url('uploads/report_file/' . $file_name));
        }

        $this->db->where('report_id',$report_id);
        $this->db->delete('report');
    }

    function delete_report_file($report_id = '', $file_serial = '')
    {
        $files = $this->db->get_where('report', array('report_id' => $report_id))->row()->files;

        $counter    = 1;
        $file_names = array();
        $files      = json_decode($files);
        foreach ($files as $file_name) {
            if($counter == $file_serial)
                unlink(base_url('uploads/report_file/' . $file_name));
            else
                array_push($file_names, $file_name);
            $counter++;
        }

        $data['files']  = json_encode($file_names);

        $this->db->where('report_id', $report_id);
        $this->db->update('report', $data);
    }

    function save_bed_info()
    {
    
    
        $data['bed_number']     = $this->input->post('bed_number');
        $data['type'] 		= $this->input->post('type');
        $data['description']    = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->insert('bed',$returned_array);
    }

    function select_bed_info()
    {
        return $this->db->get('bed')->result_array();
    }

    function update_bed_info($bed_id)
    {
        $data['bed_number']     = $this->input->post('bed_number');
        $data['type'] 		= $this->input->post('type');
        $data['description']    = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->where('bed_id',$bed_id);
        $this->db->update('bed',$returned_array);
    }

    function delete_bed_info($bed_id)
    {
        $this->db->where('bed_id',$bed_id);
        $this->db->delete('bed');
    }

    function save_blood_donor_info()
    {
        $data['name']                       = $this->input->post('name');
        $data['email']                      = $this->input->post('email');
        $data['address']                    = $this->input->post('address');
        $data['phone']                      = $this->input->post('phone');
        $data['sex']                        = $this->input->post('sex');
        $data['age']                        = $this->input->post('age');
        $data['blood_group']                = $this->input->post('blood_group');
        $data['last_donation_timestamp']    = strtotime($this->input->post('last_donation_timestamp'));

        $returned_array = null_checking($data);
        $this->db->insert('blood_donor',$returned_array);
    }

    function select_blood_donor_info()
    {
        return $this->db->get('blood_donor')->result_array();
    }

    function update_blood_donor_info($blood_donor_id)
    {
        $data['name']                       = $this->input->post('name');
        $data['email']                      = $this->input->post('email');
        $data['address']                    = $this->input->post('address');
        $data['phone']                      = $this->input->post('phone');
        $data['sex']                        = $this->input->post('sex');
        $data['age']                        = $this->input->post('age');
        $data['blood_group']                = $this->input->post('blood_group');
        $data['last_donation_timestamp']    = strtotime($this->input->post('last_donation_timestamp'));

        $returned_array = null_checking($data);
        $this->db->where('blood_donor_id',$blood_donor_id);
        $this->db->update('blood_donor',$returned_array);
    }

    function delete_blood_donor_info($blood_donor_id)
    {
        $this->db->where('blood_donor_id',$blood_donor_id);
        $this->db->delete('blood_donor');
    }

    function save_medicine_category_info()
    {
        $data['name'] 		= $this->input->post('name');
        $data['description']    = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->insert('medicine_category',$returned_array);
    }

    function select_medicine_category_info()
    {
        return $this->db->get('medicine_category')->result_array();
    }

    function update_medicine_category_info($medicine_category_id)
    {
        $data['name'] 		= $this->input->post('name');
        $data['description'] 	= $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->where('medicine_category_id',$medicine_category_id);
        $this->db->update('medicine_category',$returned_array);
    }

    function delete_medicine_category_info($medicine_category_id)
    {
        $this->db->where('medicine_category_id',$medicine_category_id);
        $this->db->delete('medicine_category');
    }

    function save_medicine_info()
    {
        $data['name']                   = $this->input->post('name');
        $data['medicine_category_id']   = $this->input->post('medicine_category_id');
        $data['unit_id']                = $this->input->post('unit_id');
        $data['description']            = $this->input->post('description');
        $data['price']                  = $this->input->post('price');
        $data['manufacturing_company']  = $this->input->post('manufacturing_company');
        $data['total_quantity']         = $this->input->post('total_quantity');
        $data['alert_quantity']         = $this->input->post('alert_quantity');
        $data['sold_quantity']          = 0;
        $returned_array = null_checking($data);
        $this->db->insert('medicine',$returned_array);
        $medicine_id  =   $this->db->insert_id();
        move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/medicine_image/' . $medicine_id . '.jpg');
    }

    function select_medicine_info()
    {
        return $this->db->get('medicine')->result_array();
    }

    function update_medicine_info($medicine_id)
    {
        $data['name']                   = $this->input->post('name');
        $data['medicine_category_id']   = $this->input->post('medicine_category_id');
        $data['unit_id']                = $this->input->post('unit_id');
        $data['description']            = $this->input->post('description');
        $data['price']                  = $this->input->post('price');
        $data['manufacturing_company']  = $this->input->post('manufacturing_company');
        $data['total_quantity']         = $this->input->post('total_quantity');
        $data['alert_quantity']         = $this->input->post('alert_quantity');
        $returned_array = null_checking($data);
        $this->db->where('medicine_id',$medicine_id);
        $this->db->update('medicine',$returned_array);
        move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/medicine_image/' . $medicine_id . '.jpg');
    }

    function delete_medicine_info($medicine_id)
    {
        $this->db->where('medicine_id',$medicine_id);
        $this->db->delete('medicine');
    }

 function save_appointment_info()
    {
        $data['timestamp']  = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['status']     = 'approved';
        $data['patient_id'] = $this->input->post('patient_id');

        if($this->session->userdata('login_type') == 'doctor')
            $data['doctor_id']  = $this->session->userdata('login_user_id');
        else
            $data['doctor_id']  = $this->input->post('doctor_id');

        $returned_array = null_checking($data);
        $this->db->insert('appointment',$returned_array);

        // Notify patient with sms.
        $notify = $this->input->post('notify');
        if($notify != '') {
            $patient_name   =   $this->db->get_where('patient',
                                array('patient_id' => $data['patient_id']))->row()->name;
            $doctor_name    =   $this->db->get_where('doctor',
                                array('doctor_id' => $data['doctor_id']))->row()->name;
            $date           =   date('l, d F Y', $data['timestamp']);
            $time           =   date('g:i a', $data['timestamp']);
            $message        =   $patient_name . ', you have an appointment with doctor ' . $doctor_name . ' on ' . $date . ' at ' . $time . '.';
            $receiver_phone =   $this->db->get_where('patient',
                                array('patient_id' => $data['patient_id']))->row()->phone;

            $this->sms_model->send_sms($message, $receiver_phone);
        }
    }


    function save_requested_appointment_info()
    {
        $data['timestamp']  = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['doctor_id']  = $this->input->post('doctor_id');
        $data['patient_id'] = $this->session->userdata('login_user_id');
        $data['status']     = 'pending';

        $returned_array = null_checking($data);
        $this->db->insert('appointment',$returned_array);
    }

   function select_appointment_info_by_doctor_id()
    {
        $this->db->order_by('timestamp', 'desc');
    
        if ($this->session->userdata('login_type') == 'doctor') {
            $doctor_id = $this->session->userdata('login_user_id');
            $this->db->where('doctor_id', $doctor_id);
        }
    
        $this->db->where('status', 'approved');
    
        return $this->db->get('appointment')->result_array();
    }

    function select_appointment_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('appointment', array('patient_id' => $patient_id, 'status' => 'approved'))->result_array();
    }

    function select_appointment_info($doctor_id = '', $start_timestamp = '', $end_timestamp = '')
    {
        $response = array();
        if($doctor_id == 'all') {
            $this->db->order_by('doctor_id', 'asc');
            $this->db->order_by('timestamp', 'desc');
            $appointments = $this->db->get_where('appointment', array('status' => 'approved'))->result_array();
            foreach ($appointments as $row) {
                if($row['timestamp'] >= $start_timestamp && $row['timestamp'] <= $end_timestamp)
                    array_push ($response, $row);
            }
        }
        else {
            $this->db->order_by('timestamp', 'desc');
            $appointments = $this->db->get_where('appointment', array('doctor_id' => $doctor_id, 'status' => 'approved'))->result_array();
            foreach ($appointments as $row) {
                if($row['timestamp'] >= $start_timestamp && $row['timestamp'] <= $end_timestamp)
                    array_push ($response, $row);
            }
        }
        return $response;
    }

    function select_pending_appointment_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('appointment', array('patient_id' => $patient_id, 'status' => 'pending'))->result_array();
    }

     function select_requested_appointment_info_by_doctor_id()
    {
        if ($this->session->userdata('login_type') == 'doctor') {
            $doctor_id = $this->session->userdata('login_user_id');
            $this->db->where('doctor_id', $doctor_id);
        }
        $this->db->where('status', 'pending');
        return $this->db->get('appointment')->result_array();
    }

    function select_requested_appointment_info()
    {
        $this->db->order_by('doctor_id', 'asc');
        return $this->db->get_where('appointment', array('status' => 'pending'))->result_array();
    }

    function select_patient_info_by_doctor_id()
    {
        $doctor_id = $this->session->userdata('login_user_id');

        //$this->db->group_by('patient_id');
        return $this->db->get_where('appointment', array(
            'doctor_id' => $doctor_id, 'status' => 'approved'))->result_array();
    }

    function select_appointments_between_loggedin_patient_and_doctor()
    {
        $patient_id = $this->session->userdata('login_user_id');

        $this->db->group_by('doctor_id');
        return $this->db->get_where('appointment', array('patient_id' => $patient_id, 'status' => 'approved'))->result_array();
    }

function update_appointment_info($appointment_id)
    {
        $data['timestamp']  = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['patient_id'] = $this->input->post('patient_id');
        if($this->session->userdata('login_type') == 'doctor'){
            $data['doctor_id']  = $this->session->userdata('login_user_id');
        } 
    else{
        $data['doctor_id']  = $this->input->post('doctor_id');
    }
        $returned_array = null_checking($data);
        $this->db->where('appointment_id',$appointment_id);
        $this->db->update('appointment',$returned_array);
        // Notify patient with sms.
        $notify = $this->input->post('notify');
        if($notify != '') {
          
            $patient_name   =   $this->db->get_where('patient',
                                array('patient_id' => $data['patient_id']))->row()->name;
            $doctor_name    =   $this->db->get_where('doctor',
                                array('doctor_id' => $data['doctor_id']))->row()->name;
            $date           =   date('l, d F Y', $data['timestamp']);
            $time           =   date('g:i a', $data['timestamp']);
            $message        =   $patient_name . ', your appointment with doctor ' . $doctor_name . ' has been updated to ' . $date . ' at ' . $time . '.';
            $receiver_phone =   $this->db->get_where('patient',
                                array('patient_id' => $data['patient_id']))->row()->phone;

            $this->sms_model->send_sms($message, $receiver_phone);
        }
    }

    function approve_appointment_info($appointment_id)
    {
        $data['timestamp']  = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['status']     = 'approved';

        if($this->session->userdata('login_type') == 'receptionist')
            $data['doctor_id'] = $this->input->post('doctor_id');

        $returned_array = null_checking($data);
        $this->db->where('appointment_id',$appointment_id);
        $this->db->update('appointment',$returned_array);

        // Notify patient with sms.
        $notify = $this->input->post('notify');
        if($notify != '') {
            $doctor_id      =   $this->db->get_where('appointment',
                                array('appointment_id' => $appointment_id))->row()->doctor_id;
            $patient_id     =   $this->db->get_where('appointment',
                                array('appointment_id' => $appointment_id))->row()->patient_id;
            $patient_name   =   $this->db->get_where('patient',
                                array('patient_id' => $patient_id))->row()->name;
            $doctor_name    =   $this->db->get_where('doctor',
                                array('doctor_id' => $doctor_id))->row()->name;
            $date           =   date('l, d F Y', $data['timestamp']);
            $time           =   date('g:i a', $data['timestamp']);
            $message        =   $patient_name . ', your requested appointment with doctor ' . $doctor_name . ' on ' . $date . ' at ' . $time . ' has been approved.';
            $receiver_phone =   $this->db->get_where('patient',
                                array('patient_id' => $patient_id))->row()->phone;

            $this->sms_model->send_sms($message, $receiver_phone);
        }
    }

    function delete_appointment_info($appointment_id)
    {
        $this->db->where('appointment_id',$appointment_id);
        $this->db->delete('appointment');
    }
    
  

    function save_prescription_info()
    {
        $data['timestamp']      = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['patient_id']     = $this->input->post('patient_id');
        $data['case_history']   = $this->input->post('case_history');
        $data['medication']     = $this->input->post('medication');
        $data['note']           = $this->input->post('note');
        $data['doctor_id']  = $this->input->post('doctor_id');
       // $data['doctor_id']      = $this->session->userdata('login_user_id');
        
        $data['follow_up']      = strtotime($this->input->post('fdate_timestamp').' '.$this->input->post('ftime_timestamp') );
        $returned_array = null_checking($data);
        $this->db->insert('prescription',$returned_array);
    }
 function self_prescription_info($patient_ids)
    {
      
        //$doctor_id = '1';
        return $this->db->get_where('prescription', array('patient_id' => $patient_ids))->result_array();
    }
    function select_prescription_info_by_doctor_id()
    {
        $doctor_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('prescription', array('doctor_id' => $doctor_id))->result_array();
    }

    function select_medication_history( $patient_id = '' )
    {
        return $this->db->get_where('prescription', array('patient_id' => $patient_id))->result_array();
    }

    function select_prescription_info_by_patient_id()
    {
        $patient_id = $this->session->userdata('login_user_id');
        return $this->db->get_where('prescription', array('patient_id' => $patient_id))->result_array();
    }

    function update_prescription_info($prescription_id)
    {
        $data['timestamp']      = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['patient_id']     = $this->input->post('patient_id');
        $data['case_history']   = $this->input->post('case_history');
        $data['medication']     = $this->input->post('medication');
        $data['note']           = $this->input->post('note');
        $data['doctor_id']      = $this->input->post('doctor_id');
        $returned_array = null_checking($data);
        $this->db->where('prescription_id',$prescription_id);
        $this->db->update('prescription',$returned_array);
    }

    function delete_prescription_info($prescription_id)
    {
        $this->db->where('prescription_id',$prescription_id);
        $this->db->delete('prescription');
    }

    function save_diagnosis_report_info()
    {
        $data['timestamp']          = strtotime($this->input->post('date_timestamp').' '.$this->input->post('time_timestamp') );
        $data['report_type']        = $this->input->post('report_type');
        $data['file_name']          = $_FILES["file_name"]["name"];
        $data['document_type']      = $this->input->post('document_type');
        $data['description']        = $this->input->post('description');
        $data['prescription_id']    = $this->input->post('prescription_id');

        $this->db->insert('diagnosis_report',$data);

        $diagnosis_report_id        = $this->db->insert_id();
        move_uploaded_file($_FILES["file_name"]["tmp_name"], 'uploads/diagnosis_report/' . $_FILES["file_name"]["name"]);
    }

    function select_diagnosis_report_info()
    {
        return $this->db->get('diagnosis_report')->result_array();
    }

    function delete_diagnosis_report_info($diagnosis_report_id)
    {
        $this->db->where('diagnosis_report_id',$diagnosis_report_id);
        $this->db->delete('diagnosis_report');
    }

    function save_notice_info()
    {
        $data['title']              = $this->input->post('title');
        $data['description']        = $this->input->post('description');
        if($this->input->post('start_timestamp') != '')
            $data['start_timestamp']    = strtotime($this->input->post('start_timestamp'));
        else
            $data['start_timestamp']    = '';
        if($this->input->post('end_timestamp') != '')
            $data['end_timestamp']      = strtotime($this->input->post('end_timestamp'));
        else
            $data['end_timestamp']      = $data['start_timestamp'];

        $returned_array = null_checking($data);
        $this->db->insert('notice',$returned_array);
    }

    function select_notice_info()
    {
        return $this->db->get('notice')->result_array();
    }

    function update_notice_info($notice_id)
    {
        $data['title']              = $this->input->post('title');
        $data['description']        = $this->input->post('description');
        if($this->input->post('start_timestamp') != '')
            $data['start_timestamp']    = strtotime($this->input->post('start_timestamp'));
        else
            $data['start_timestamp']    = '';
        if($this->input->post('end_timestamp') != '')
            $data['end_timestamp']      = strtotime($this->input->post('end_timestamp'));
        else
            $data['end_timestamp']      = $data['start_timestamp'];

        $returned_array = null_checking($data);
        $this->db->where('notice_id',$notice_id);
        $this->db->update('notice',$returned_array);
    }

    function delete_notice_info($notice_id)
    {
        $this->db->where('notice_id',$notice_id);
        $this->db->delete('notice');
    }

    function curl_request($code = '') {

        $product_code = $code;

        $personal_token = "FkA9UyDiQT0YiKwYLK3ghyFNRVV9SeUn";
        $url = "https://api.envato.com/v3/market/author/sale?code=".$product_code;
        $curl = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$product_code.'.json';
        $ch_verify = curl_init( $verify_url . '?code=' . $product_code );

        curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
        curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec( $ch_verify );
        curl_close( $ch_verify );

        $response = json_decode($cinit_verify_data, true);

        if (count($response['verify-purchase']) > 0) {
            return true;
        } else {
            return false;
        }

    }

    ////////private message//////
    function send_new_private_message() {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));

        $reciever   = $this->input->post('reciever');
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->num_rows();
        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code                        = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender']              = $sender;
            $data_message_thread['reciever']            = $reciever;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'reciever' => $reciever))->row()->message_thread_code;
        if ($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $reciever, 'reciever' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);

        return $message_thread_code;
    }

    function send_reply_message($message_thread_code) {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));
        $sender     = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);
    }

    function mark_thread_messages_read($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
                $unread_message_counter++;
        }
        return $unread_message_counter;
    }

    //CREATE MEDICINE SALE
    function create_medicine_sale() {
        $data['bill_no']     = $this->input->post('bill_no');
        $data['patient_id']     = $this->input->post('patient_id');
        $data['total_amount']   = $this->input->post('total_amount');
        $data['payment_status']     = $this->input->post('payment_status');
        $data['payment_mode_id']     = $this->input->post('payment_mode_id');
        $medicines              = array();
        $medicine_ids           = $this->input->post('medicine_id');
        $medicine_quantities    = $this->input->post('medicine_quantity');
        $number_of_entries      = sizeof($medicine_ids);

        for($i = 0; $i < $number_of_entries; $i++)
        {
            if($medicine_ids[$i] != "" && $medicine_quantities[$i] != "")
            {
                $new_entry = array('medicine_id' => $medicine_ids[$i], 'quantity' => $medicine_quantities[$i]);
                array_push($medicines, $new_entry);

                // UPDATE MEDICINE INVENTORY
                $sold_quantity = $this->db->get_where('medicine', array('medicine_id' => $medicine_ids[$i]))->row()->sold_quantity;

                $data2['sold_quantity'] = $sold_quantity + $medicine_quantities[$i];

                $this->db->update('medicine', $data2, array('medicine_id' => $medicine_ids[$i]));
            }
        }
        $data['medicines']     = json_encode($medicines);
        $returned_array = null_checking($data);
        $this->db->insert('medicine_sale', $returned_array);
    }

    //upload pathology_report
    function save_pathology_report($param1 = ""){
      if (!file_exists('uploads/pathology_reports/')) {
        $oldmask = umask(0);  // helpful when used in linux server
        mkdir ('uploads/pathology_reports/', 0777);
      }

      $data['code']       = substr(md5(rand(0, 1000000000)), 0, 10);
      $data['patient_id'] = $param1;
      $data['test_name']  = $this->input->post('pathology_test_name');
      $file_name = $_FILES['pathology_report']['name'];
      $extension = pathinfo($file_name, PATHINFO_EXTENSION);
      $modified_file_name = $data['code'].'.'.$extension;
      move_uploaded_file($_FILES['pathology_report']['tmp_name'], 'uploads/pathology_reports/'. $modified_file_name);
      $data['pathology_report'] = $modified_file_name;
      $this->db->insert('pathology_report', $data);
    }
    function save_tpa_management()
    {
        $data['tpa_name'] = $this->input->post('tpa_name');
        $data['code'] = $this->input->post('code');
        $data['contact_no'] = $this->input->post('contact_no');
        $data['address'] = $this->input->post('address');
        $data['contact_person_name'] = $this->input->post('contact_person_name');
        $data['contact_person_phone'] = $this->input->post('contact_person_phone');
        $returned_array        = null_checking($data);
        $this->db->insert('tpa_management',$returned_array); 
    }

    function select_tpa_management()
    {
        return $this->db->get('tpa_management')->result_array();
    }

    function update_tpa_management($tpa_id)
    {
        $data['tpa_name'] = $this->input->post('tpa_name');
        $data['code'] = $this->input->post('code');
        $data['contact_no'] = $this->input->post('contact_no');
        $data['address'] = $this->input->post('address');
        $data['contact_person_name'] = $this->input->post('contact_person_name');
        $data['contact_person_phone'] = $this->input->post('contact_person_phone');
        $returned_array        = null_checking($data);
        $this->db->where('tpa_id',$tpa_id);
        $this->db->update('tpa_management',$returned_array);
    }

    function delete_tpa_management($tpa_id)
    {
        $this->db->where('tpa_id',$tpa_id);
        $this->db->delete('tpa_management'); 
    }
     function save_income_head()
    {
        $data['income_head_name'] = $this->input->post('income_head_name');       
        $data['description'] = $this->input->post('description');       
        $returned_array        = null_checking($data);
        $this->db->insert('income_head',$returned_array); 
    }

    function select_income_head()
    {
        return $this->db->get('income_head')->result_array();
    }

    function update_income_head($income_id)
    {
        $data['income_head_name'] = $this->input->post('income_head_name');       
        $data['description'] = $this->input->post('description');       
        $returned_array        = null_checking($data);
        $this->db->where('income_id',$income_id);
        $this->db->update('income_head',$returned_array); 
    }

    function delete_income_head($income_id)
    {
        $this->db->where('income_id',$income_id);
        $this->db->delete('income_head'); 
    }

    function save_expense_head()
    {
        $data['expense_head_name'] = $this->input->post('expense_head_name');       
        $data['description'] = $this->input->post('description');       
        $returned_array        = null_checking($data);
        $this->db->insert('expense_head',$returned_array); 
    }

    function select_expense_head()
    {
        return $this->db->get('expense_head')->result_array();
    }

    function update_expense_head($expense_id)
    {
        $data['expense_head_name'] = $this->input->post('expense_head_name');       
        $data['description'] = $this->input->post('description');       
        $returned_array        = null_checking($data);
        $this->db->where('expense_id',$expense_id);
        $this->db->update('expense_head',$returned_array); 
    }

    function delete_expense_head($expense_id)
    {
        $this->db->where('expense_id',$expense_id);
        $this->db->delete('expense_head'); 
    }

    function save_income()
    {
        $data['income_head_id'] = $this->input->post('income_head_id');
        $data['name'] = $this->input->post('name');
        $data['invoice_no'] = $this->input->post('invoice_no');
        $data['date'] = date('Y-m-d', strtotime($this->input->post('date')));
        $data['amount'] = $this->input->post('amount');
        $data['document'] = $_FILES['document']['name'];       
        $data['description'] = $this->input->post('description');
        $returned_array        = null_checking($data);
        $this->db->insert('income',$returned_array); 
        move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/frontend/income_files/'.$_FILES['document']['name']);
    }

    function select_income()
    {
        $this->db->select('income.*,income_head.income_head_name')->from('income');
        $this->db->join('income_head', 'income.income_head_id = income_head.income_id', 'left');
        return $this->db->get('')->result_array();
    }

    function update_income($inc_id)
    {
        $data['income_head_id'] = $this->input->post('income_head_id');
        $data['name'] = $this->input->post('name');
        $data['invoice_no'] = $this->input->post('invoice_no');
        $data['date'] = date('Y-m-d', strtotime($this->input->post('date')));
        $data['amount'] = $this->input->post('amount');
        $data['document'] = $_FILES['document']['name'];       
        $data['description'] = $this->input->post('description');
        $returned_array        = null_checking($data);
        $this->db->where('inc_id',$inc_id);
        $this->db->update('income',$returned_array); 
        move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/frontend/income_files/'.$_FILES['document']['name']);
    }

    function delete_income($inc_id)
    {
        $this->db->where('inc_id',$inc_id);
        $this->db->delete('income'); 
    }

    function save_expense()
    {
        $data['expense_head_id'] = $this->input->post('expense_head_id');
        $data['name'] = $this->input->post('name');
        $data['invoice_no'] = $this->input->post('invoice_no');
        $data['date'] = date('Y-m-d', strtotime($this->input->post('date')));
        $data['amount'] = $this->input->post('amount');
        $data['document'] = $_FILES['document']['name'];       
        $data['description'] = $this->input->post('description');
        $returned_array        = null_checking($data);
        $this->db->insert('expense',$returned_array); 
        move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/frontend/expense_files/'.$_FILES['document']['name']);
    }

    function select_expense()
    {
        $this->db->select('expense.*,expense_head.expense_head_name')->from('expense');
        $this->db->join('expense_head', 'expense.expense_head_id = expense_head.expense_id', 'left');
        return $this->db->get('')->result_array();
    }

    function update_expense($exp_id)
    {
        $data['expense_head_id'] = $this->input->post('expense_head_id');
        $data['name'] = $this->input->post('name');
        $data['invoice_no'] = $this->input->post('invoice_no');
        $data['date'] = date('Y-m-d', strtotime($this->input->post('date')));
        $data['amount'] = $this->input->post('amount');
        $data['document'] = $_FILES['document']['name'];       
        $data['description'] = $this->input->post('description');
        $returned_array        = null_checking($data);
        $this->db->where('exp_id',$exp_id);
        $this->db->update('expense',$returned_array); 
        move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/frontend/expense_files/'.$_FILES['document']['name']);
    }

    function delete_expense($exp_id)
    {
        $this->db->where('exp_id',$exp_id);
        $this->db->delete('expense'); 
    }
    //Manoj
    function select_item_category_info()
    {
        return $this->db->where('is_active', 'Y')->get('item_category')->result_array();
    }
    function save_item_category_info()
    {
        $data['item_category']         = $this->input->post('item_category');
        $data['description']         = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->insert('item_category', $returned_array);
    }
    function update_item_category_info($item_category_id)
    {
        $data['item_category']         = $this->input->post('item_category');
        $data['description']         = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->where('id', $item_category_id);
        $this->db->update('item_category', $returned_array);
    }
    function delete_item_category_info($item_category_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $item_category_id);
        $this->db->update('item_category', $data);
        // $this->db->delete('item_category');
    }

    function select_item_store_info()
    {
        return $this->db->where('is_active', 'Y')->get('item_store')->result_array();
    }
    function save_item_store_info()
    {
        $data['item_store']         = $this->input->post('item_store');
        $data['store_code']         = $this->input->post('store_code');
        $data['description']         = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->insert('item_store', $returned_array);
    }
    function update_item_store_info($item_store_id)
    {
        $data['item_store']         = $this->input->post('item_store');
        $data['store_code']         = $this->input->post('store_code');
        $data['description']         = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->where('id', $item_store_id);
        $this->db->update('item_store', $returned_array);
    }
    function delete_item_store_info($item_store_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $item_store_id);
        $this->db->update('item_store', $data);
    }

    function select_item_supplier_info()
    {
        return $this->db->where('is_active', 'Y')->get('item_supplier')->result_array();
    }
    function save_item_supplier_info()
    {
        $data['item_supplier']         = $this->input->post('item_supplier');
        $data['supplier_code']         = $this->input->post('supplier_code');
        $data['phone']                 = $this->input->post('phone');
        $data['email']                 = $this->input->post('email');
        $data['address']               = $this->input->post('address');
        $data['contact_person_name']   = $this->input->post('contact_person_name');
        $data['contact_person_phone']  = $this->input->post('contact_person_phone');
        $data['contact_person_email']  = $this->input->post('contact_person_email');
        $data['description']           = $this->input->post('description');
$data['gst_no']                 = $this->input->post('gst_no');
        $data['dl_no']                 = $this->input->post('dl_no');



      //  $returned_array = null_checking($data);
        $this->db->insert('item_supplier', $data);
    }
    function update_item_supplier_info($item_supplier_id)
    {
        $data['item_supplier']         = $this->input->post('item_supplier');
        $data['supplier_code']         = $this->input->post('supplier_code');
        $data['phone']                 = $this->input->post('phone');
        $data['email']                 = $this->input->post('email');
        $data['address']               = $this->input->post('address');
        $data['contact_person_name']   = $this->input->post('contact_person_name');
        $data['contact_person_phone']  = $this->input->post('contact_person_phone');
        $data['contact_person_email']  = $this->input->post('contact_person_email');
        $data['description']           = $this->input->post('description');

        $returned_array = null_checking($data);
        $this->db->where('id', $item_supplier_id);
        $this->db->update('item_supplier', $returned_array);
    }
    function delete_item_supplier_info($item_supplier_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $item_supplier_id);
        $this->db->update('item_supplier', $data);
    }
    function select_item_info()
    {
        $this->db->select('item.*, item_category.item_category');
        $this->db->from('item');
        $this->db->join('item_category', 'item_category.id = item.item_category_id', 'left');
        $this->db->where('item.is_active', 'Y');
        $result = $this->db->get()->result_array();
        return $result;
    }
      function select_demoitem_info()
    {
  
        $this->db->select('demoitem.*, item_category.item_category');
        $this->db->from('demoitem');
        $this->db->join('item_category', 'item_category.id = demoitem.item_category_id', 'left');
        $this->db->where('demoitem.is_active', 'Y');
        $result = $this->db->get()->result_array();
        return $result;
    }
     function select_diag_info()
    {
        $this->db->select('diagnosis.*');
        $this->db->from('diagnosis');
      
        $result = $this->db->get()->result_array();
        return $result;
    }
  function save_item_info_17_04_2024()
    {
        $data['model']         = $this->input->post('model');
        $data['serial_no']         = $this->input->post('serial_no');
        $data['item_category_id']         = $this->input->post('item_category_id');
        $data['item_sub_category_id']       = $this->input->post('item_sub_category_id');
        $data['type']     = $this->input->post('type');
        $data['channel']     = $this->input->post('channel');
        $data['fitting_range']     = $this->input->post('fitting_range');
        $data['warranty_id']     = $this->input->post('warranty_id');
        $data['unit']     = $this->input->post('unit');
        $data['unit_price']     = $this->input->post('unit_price');

        $data['lr']     = $this->input->post('lr');
        $data['quantity']     = $this->input->post('quantity');
        $data['additional_name']     = $this->input->post('additional_name');
        $data['hsn_code']     = $this->input->post('hsn_code');
        $data['batch_no']     = $this->input->post('batch_no');
        $data['gst']     = $this->input->post('gst');

        $returned_array = null_checking($data);
        $this->db->insert('item', $returned_array);
        $item_id  =   $this->db->insert_id();
        // Prepare data for item_price_details table
        $price_data = array(
            'item_id' => $item_id,
            'sl_no' => $data['serial_no'],
            'unit_price' => $data['unit_price'],
            'date_time' => date('d-m-Y') // Current date and time
        );

        // Insert data into item_price_details table
        $this->db->insert('item_price_details', $price_data);

        //move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/item_image/' . $item_id . '.jpg');
    }
    
      function save_item_info()
    {
        
        // echo $this->input->post('demo');
        // echo $this->input->post('hearing_accessories');
        // exit();
        
        
        $data['model']         = $this->input->post('model');
        $data['serial_no']         = $this->input->post('serial_no');
        $data['item_category_id']         = $this->input->post('item_category_id');
        $data['item_sub_category_id']       = $this->input->post('item_sub_category_id');
        $data['type']     = $this->input->post('type');
        $data['channel']     = $this->input->post('channel');
        $data['fitting_range']     = $this->input->post('fitting_range');
        $data['warranty_id']     = $this->input->post('warranty_id');
        $data['unit']     = $this->input->post('unit');
        $data['unit_price']     = $this->input->post('unit_price');

        $data['lr']     = $this->input->post('lr');
        $data['quantity']     = $this->input->post('quantity');
        $data['additional_name']     = $this->input->post('additional_name');
        $data['hsn_code']     = $this->input->post('hsn_code');
        $data['batch_no']     = $this->input->post('batch_no');
        $data['gst']     = $this->input->post('gst');
          $data['demo'] =  $this->input->post('demo');

 $data['hearing_accessories'] =  $this->input->post('hearing_accessories');
 $data['hearing_aid'] =  $this->input->post('hearing_aid');

     //   $returned_array = null_checking($data);
        $this->db->insert('item', $data);
        $item_id  =   $this->db->insert_id();
        // Prepare data for item_price_details table
        $price_data = array(
            'item_id' => $item_id,
            'sl_no' => $data['serial_no'],
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'date_time' => date('d-m-Y') // Current date and time
        );

        // Insert data into item_price_details table
        $this->db->insert('item_price_details', $price_data);

        //move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/item_image/' . $item_id . '.jpg');
    }
     function save_item_info_06_05_2024()
    {
        
        // echo $this->input->post('demo');
        // echo $this->input->post('hearing_accessories');
        // exit();
        
        
        $data['model']         = $this->input->post('model');
        $data['serial_no']         = $this->input->post('serial_no');
        $data['item_category_id']         = $this->input->post('item_category_id');
        $data['item_sub_category_id']       = $this->input->post('item_sub_category_id');
        $data['type']     = $this->input->post('type');
        $data['channel']     = $this->input->post('channel');
        $data['fitting_range']     = $this->input->post('fitting_range');
        $data['warranty_id']     = $this->input->post('warranty_id');
        $data['unit']     = $this->input->post('unit');
        $data['unit_price']     = $this->input->post('unit_price');

        $data['lr']     = $this->input->post('lr');
        $data['quantity']     = $this->input->post('quantity');
        $data['additional_name']     = $this->input->post('additional_name');
        $data['hsn_code']     = $this->input->post('hsn_code');
        $data['batch_no']     = $this->input->post('batch_no');
        $data['gst']     = $this->input->post('gst');
          $data['demo'] =  $this->input->post('demo');

 $data['hearing_accessories'] =  $this->input->post('hearing_accessories');
 $data['hearing_aid'] =  $this->input->post('hearing_aid');

     //   $returned_array = null_checking($data);
        $this->db->insert('item', $data);
        $item_id  =   $this->db->insert_id();
        // Prepare data for item_price_details table
        $price_data = array(
            'item_id' => $item_id,
            'sl_no' => $data['serial_no'],
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'date_time' => date('d-m-Y') // Current date and time
        );

        // Insert data into item_price_details table
        $this->db->insert('item_price_details', $price_data);

        //move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/item_image/' . $item_id . '.jpg');
    }
  function save_demoitem_info()
    {
        $data['model']         = $this->input->post('model');
        $data['serial_no']         = $this->input->post('serial_no');
        $data['item_category_id']         = $this->input->post('item_category_id');
        $data['item_sub_category_id']       = $this->input->post('item_sub_category_id');
        $data['type']     = $this->input->post('type');
        $data['channel']     = $this->input->post('channel');
        $data['fitting_range']     = $this->input->post('fitting_range');
        $data['warranty_id']     = $this->input->post('warranty_id');
        $data['unit']     = $this->input->post('unit');
        $data['unit_price']     = $this->input->post('unit_price');

        $data['lr']     = $this->input->post('lr');
        $data['quantity']     = $this->input->post('quantity');
        $data['additional_name']     = $this->input->post('additional_name');
        $data['hsn_code']     = $this->input->post('hsn_code');
        $data['batch_no']     = $this->input->post('batch_no');
        $data['gst']     = $this->input->post('gst');

        $returned_array = null_checking($data);
        $this->db->insert('demoitem', $returned_array);
        $item_id  =   $this->db->insert_id();
        $demoprice_data = array(
            'item_id' => $item_id,
            'sl_no' => $data['serial_no'],
            'unit_price' => $data['unit_price'],
            'date_time' => date('d-m-Y') // Current date and time
        );

        // Insert data into item_price_details table
        $this->db->insert('demoitem_price_details', $demoprice_data);

        //move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/item_image/' . $item_id . '.jpg');
    }
   
   function update_item_info_17_04_2024($item_id)
    {
        $data['model']         = $this->input->post('model');
        $data['serial_no']         = $this->input->post('serial_no');
        $data['item_category_id']         = $this->input->post('item_category_id');
        $data['item_sub_category_id']       = $this->input->post('item_sub_category_id');
        $data['type']     = $this->input->post('type');
        $data['channel']     = $this->input->post('channel');
        $data['fitting_range']     = $this->input->post('fitting_range');
        $data['warranty_id']     = $this->input->post('warranty_id');
        $data['unit']     = $this->input->post('unit');
        $data['unit_price']     = $this->input->post('unit_price');
          $data['new_price']     = $this->input->post('new_price');
        $data['lr']     = $this->input->post('lr');
        $data['quantity']     = $this->input->post('quantity');
        $data['additional_name']     = $this->input->post('additional_name');
        $data['hsn_code']     = $this->input->post('hsn_code');
        $data['batch_no']     = $this->input->post('batch_no');
        $data['gst']     = $this->input->post('gst');

        $returned_array = null_checking($data);
        $this->db->where('id', $item_id);
        $this->db->update('item', $returned_array);
        // move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/item_image/' . $item_id . '.jpg');
        $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    }
         function update_item_info($item_id)
    {
        $data['model']         = $this->input->post('model');
        $data['serial_no']         = $this->input->post('serial_no');
        $data['item_category_id']         = $this->input->post('item_category_id');
        $data['item_sub_category_id']       = $this->input->post('item_sub_category_id');
        $data['type']     = $this->input->post('type');
        $data['channel']     = $this->input->post('channel');
        $data['fitting_range']     = $this->input->post('fitting_range');
        $data['warranty_id']     = $this->input->post('warranty_id');
        $data['unit']     = $this->input->post('unit');
        $data['unit_price']     = $this->input->post('unit_price');
          $data['new_price']     = $this->input->post('new_price');
        $data['lr']     = $this->input->post('lr');
       // $data['quantity']     = $this->input->post('quantity');
        $data['additional_name']     = $this->input->post('additional_name');
        $data['hsn_code']     = $this->input->post('hsn_code');
        $data['batch_no']     = $this->input->post('batch_no');
        $data['gst']     = $this->input->post('gst');
        $data['demo']     = $this->input->post('demo');
          $data['hearing_accessories']     = $this->input->post('hearing_accessories');
             $data['hearing_aid'] =  $this->input->post('hearing_aid');

      //  $returned_array = null_checking($data);
        $this->db->where('id', $item_id);
        $this->db->update('item', $data);
        // move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/item_image/' . $item_id . '.jpg');
        $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    }
    
     function update_item_info_06_05_2024($item_id)
    {
        $data['model']         = $this->input->post('model');
        $data['serial_no']         = $this->input->post('serial_no');
        $data['item_category_id']         = $this->input->post('item_category_id');
        $data['item_sub_category_id']       = $this->input->post('item_sub_category_id');
        $data['type']     = $this->input->post('type');
        $data['channel']     = $this->input->post('channel');
        $data['fitting_range']     = $this->input->post('fitting_range');
        $data['warranty_id']     = $this->input->post('warranty_id');
        $data['unit']     = $this->input->post('unit');
        $data['unit_price']     = $this->input->post('unit_price');
          $data['new_price']     = $this->input->post('new_price');
        $data['lr']     = $this->input->post('lr');
       // $data['quantity']     = $this->input->post('quantity');
        $data['additional_name']     = $this->input->post('additional_name');
        $data['hsn_code']     = $this->input->post('hsn_code');
        $data['batch_no']     = $this->input->post('batch_no');
        $data['gst']     = $this->input->post('gst');
        $data['demo']     = $this->input->post('demo');
          $data['hearing_accessories']     = $this->input->post('hearing_accessories');

      //  $returned_array = null_checking($data);
        $this->db->where('id', $item_id);
        $this->db->update('item', $data);
        // move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/item_image/' . $item_id . '.jpg');
        $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    }
    
    
    function update_demoitem_info($item_id)
    {
        $data['model']         = $this->input->post('model');
        $data['serial_no']         = $this->input->post('serial_no');
        $data['item_category_id']         = $this->input->post('item_category_id');
        $data['item_sub_category_id']       = $this->input->post('item_sub_category_id');
        $data['type']     = $this->input->post('type');
        $data['channel']     = $this->input->post('channel');
        $data['fitting_range']     = $this->input->post('fitting_range');
        $data['warranty_id']     = $this->input->post('warranty_id');
        $data['unit']     = $this->input->post('unit');
        $data['unit_price']     = $this->input->post('unit_price');
        $data['new_price']     = $this->input->post('new_price');
        $data['lr']     = $this->input->post('lr');
        $data['quantity']     = $this->input->post('quantity');
        $data['additional_name']     = $this->input->post('additional_name');
        $data['hsn_code']     = $this->input->post('hsn_code');
        $data['batch_no']     = $this->input->post('batch_no');
        $data['gst']     = $this->input->post('gst');

        $returned_array = null_checking($data);
        $this->db->where('id', $item_id);
        $this->db->update('demoitem', $returned_array);
        // move_uploaded_file($_FILES["image"]["tmp_name"], 'uploads/item_image/' . $item_id . '.jpg');
        $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    }
    function delete_item_info($item_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $item_id);
        $this->db->update('item', $data);
    }
    
     function delete_demoitem_info($item_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $item_id);
        $this->db->update('demoitem', $data);
    }
    function select_item_stock_info()
    {
        $this->db->select('item_stock.*, item.model,item_category.item_category,item_supplier.item_supplier,item_store.item_store');
        $this->db->from('item_stock');
        $this->db->join('item', 'item.id = item_stock.item_id', 'left');
        $this->db->join('item_category', 'item_category.id = item.item_category_id', 'left');
        $this->db->join('item_supplier', 'item_supplier.id = item_stock.supplier_id', 'left');
        $this->db->join('item_store', 'item_store.id = item_stock.store_id', 'left');
        $this->db->where('item_stock.is_active', 'Y');
        $result = $this->db->get()->result_array();
        return $result;
    }
    function search_item_stock_info()
    {
        $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
        $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
        $this->db->select('item_stock.*, item.model,item_category.item_category,item_supplier.item_supplier,item_store.item_store');
        $this->db->from('item_stock');
        $this->db->join('item', 'item.id = item_stock.item_id', 'left');
        $this->db->join('item_category', 'item_category.id = item.item_category_id', 'left');
        $this->db->join('item_supplier', 'item_supplier.id = item_stock.supplier_id', 'left');
        $this->db->join('item_store', 'item_store.id = item_stock.store_id', 'left');
        $this->db->where('item_stock.is_active', 'Y');
        $this->db->where('item_stock.date >=', $date_from);
        $this->db->where('item_stock.date <=', $date_to);
        $result = $this->db->get()->result_array();
        return $result;
    }
    function save_item_stock_info()
    {
        $data['item_id']         = $this->input->post('item_id');
        $data['supplier_id']         = $this->input->post('supplier_id');
        $data['store_id']       = $this->input->post('store_id');
        $data['quantity']     = $this->input->post('quantity');
        $data['purchase_price']     = $this->input->post('purchase_price');
        $data['rate']     = $this->input->post('rate');
        $data['date']     = date('Y-m-d', strtotime($this->input->post('date')));
        $data['description']     = $this->input->post('description');

        $returned_array = null_checking($data);
        $this->db->insert('item_stock', $returned_array);
        $item_stock_id  =   $this->db->insert_id();

        if (isset($_FILES["attachment"]) && !empty($_FILES['attachment']['name'])) {

            $fileInfo = pathinfo($_FILES["attachment"]["name"]);

            $attachment_name = $item_stock_id . '.' . $fileInfo['extension'];

            move_uploaded_file($_FILES["attachment"]["tmp_name"], "./uploads/item_stock_attachment/" . $attachment_name);

            $data = array('file_name' => $_FILES["attachment"]["name"], 'upload_name' => $attachment_name, 'attachment' => 'uploads/item_stock_attachment/' . $attachment_name);
            $this->db->where('id', $item_stock_id);
            $this->db->update('item_stock', $data);
        }
    }
    function update_item_stock_info($item_stock_id)
    {
        $data['item_id']         = $this->input->post('item_id');
        $data['supplier_id']         = $this->input->post('supplier_id');
        $data['store_id']       = $this->input->post('store_id');
        $data['quantity']     = $this->input->post('quantity');
        $data['purchase_price']     = $this->input->post('purchase_price');
        $data['rate']     = $this->input->post('rate');
        $data['date']     = date('Y-m-d', strtotime($this->input->post('date')));
        $data['description']     = $this->input->post('description');

        $returned_array = null_checking($data);
        $this->db->where('id', $item_stock_id);
        $this->db->update('item_stock', $returned_array);

        if (isset($_FILES["attachment"]) && !empty($_FILES['attachment']['name'])) {
            $fileInfo = pathinfo($_FILES["attachment"]["name"]);
            $attachment_name = $item_stock_id . '.' . $fileInfo['extension'];
            move_uploaded_file($_FILES["attachment"]["tmp_name"], "./uploads/item_stock_attachment/" . $attachment_name);
            $data = array('file_name' => $_FILES["attachment"]["name"], 'upload_name' => $attachment_name, 'attachment' => 'uploads/item_stock_attachment/' . $attachment_name);
            $this->db->where('id', $item_stock_id);
            $this->db->update('item_stock', $data);
        }
        $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    }
    function delete_item_stock_info($item_stock_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $item_stock_id);
        $this->db->update('item_stock', $data);
    }
    function select_item_issue_info()
    {
        $this->db->select('item_issue.*, item.model,item_category.item_category,doctor.name as doctor_name');
        $this->db->from('item_issue');
        $this->db->join('doctor', 'doctor.doctor_id = item_issue.issue_to', 'left');
        $this->db->join('item', 'item.id = item_issue.item_id', 'left');
        $this->db->join('item_category', 'item_category.id = item.item_category_id', 'left');
        $this->db->where('item_issue.is_active', 'Y');
        $result = $this->db->get()->result_array();
        return $result;
    }
    function search_item_issue_info()
    {
        $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
        $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
        $this->db->select('item_issue.*, item.model,item_category.item_category,doctor.name as doctor_name');
        $this->db->from('item_issue');
        $this->db->join('doctor', 'doctor.doctor_id = item_issue.issue_to', 'left');
        $this->db->join('item', 'item.id = item_issue.item_id', 'left');
        $this->db->join('item_category', 'item_category.id = item.item_category_id', 'left');
        $this->db->where('item_issue.is_active', 'Y');
        $this->db->where('item_issue.issue_date >=', $date_from);
        $this->db->where('item_issue.issue_date <=', $date_to);
        $result = $this->db->get()->result_array();
        return $result;
    }
    function save_item_issue_info()
    {
        $data['issue_to']         = $this->input->post('issue_to');
        $data['issue_by']         = $this->input->post('issue_by');
        $data['issue_date']     = date('Y-m-d', strtotime($this->input->post('issue_date')));
        $data['return_date']     = date('Y-m-d', strtotime($this->input->post('return_date')));
        $data['item_id']     = $this->input->post('item_id');
        $data['quantity']     = $this->input->post('quantity');
        $data['note']     = $this->input->post('note');

        $returned_array = null_checking($data);
        $this->db->insert('item_issue', $returned_array);
        $item_issue_id  =   $this->db->insert_id();
    }
    function update_item_issue_status($item_issue_id)
    {
        $data['is_returned'] = 1;
        $this->db->where('id', $item_issue_id);
        $this->db->update('item_issue', $data);
    }
    function delete_item_issue_info($item_issue_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $item_issue_id);
        $this->db->update('item_issue', $data);
    }
 
function search_patient_item_issue_info()
    {
        $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
        $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
        $patient_id = $this->input->post('patient_id');
        $this->db->select('patient_item_issue.*,patient.name as patient_name');
        $this->db->from('patient_item_issue');
        $this->db->join('patient', 'patient.patient_id = patient_item_issue.patient_id', 'left');
        $this->db->where('patient_item_issue.is_active', 'Y');
        $this->db->where('patient_item_issue.issue_type', 'invoice');
        $this->db->where('patient_item_issue.invoice_date >=', $date_from);
        $this->db->where('patient_item_issue.invoice_date <=', $date_to);
        if ($patient_id)
            $this->db->where('patient_item_issue.patient_id', $patient_id);
        $result = $this->db->get()->result_array();
        return $result;
    }
   
    function select_patient_item_issue_info()
    {
       $date= date('Y-m-d');
        $this->db->select('patient_item_issue.*,patient.name as patient_name');
        $this->db->from('patient_item_issue');
        $this->db->join('patient', 'patient.patient_id = patient_item_issue.patient_id', 'left');
        $this->db->where('patient_item_issue.issue_type', 'invoice');
         $this->db->where('patient_item_issue.invoice_date', $date);
        
        $this->db->where('patient_item_issue.is_active', 'Y');
        $result = $this->db->get()->result_array();
        return $result;
    }
    function select_patient_item_challan_info()
    {
          $date= date('Y-m-d');
        $this->db->select('patient_item_issue.*,patient.name as patient_name');
        $this->db->from('patient_item_issue');
        $this->db->join('patient', 'patient.patient_id = patient_item_issue.patient_id', 'left');
        $this->db->where('patient_item_issue.issue_type', "challan");
         $this->db->where('patient_item_issue.challan_date', $date);
        $this->db->where('patient_item_issue.is_active', 'Y');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
     function save_patient_diagnosis_info()
    {
        $type = $this->session->userdata('login_type');
        $patient_id = $this->input->post('patient_id');
        if ($patient_id != '') {
        $data['patient_id']     = $patient_id;
        $data['sum_total_price']   = $this->input->post('sum_total_price');
        $data['payment_status']     = $this->input->post('payment_status');
        $data['payment_mode_id']     = $this->input->post('payment_mode_id');
        // $data['creation_timestamp'] = $this->input->post('creation_timestamp');
         
         $input_date = $this->input->post('creation_timestamp');
$date_obj = DateTime::createFromFormat('m/d/Y', $input_date);
$formatted_date = $date_obj->format('Y-m-d');
$data['date'] = $formatted_date;


        $diagnosis_ids           = $this->input->post('diagnosis_id');
        $diagnosis_quantities    = $this->input->post('diagnosis_quantity');
        $diagnosis_price    = $this->input->post('diagnosis_price');
        $discount_type    = $this->input->post('discount_type');
         $discount_prices   = $this->input->post('discount_price');
        $total_prices    = $this->input->post('total_price');
       //  $data['date']     = date('d-m-Y');
          $type = $this->session->userdata('login_type');
           $data['login_type']  =$type;
        $number_of_entries      = sizeof($diagnosis_ids);
        $diagnosis       = array();

        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($diagnosis_ids[$i] != "" && $diagnosis_quantities[$i] != "" && $diagnosis_price[$i] != "") {
                $new_entry = array('diagnosis_id' => $diagnosis_ids[$i], 'quantity' => $diagnosis_quantities[$i], 'diagnosis_price' => $diagnosis_price[$i],'discount_type' => $discount_type[$i], 'discount_price' => $discount_prices[$i], 'total_price' => $total_prices[$i]);
                array_push($diagnosis, $new_entry);
            }
        }
        $data['diagnosis_id']     = json_encode($diagnosis);
        $returned_array = null_checking($data);
        $this->db->insert('patient_diagnosis', $returned_array);
        return $patient_id ;
    }
    else{
        $this->session->set_flashdata('error_message', get_phrase('Error Occured'));
        redirect(site_url($type.'/patient_diagnosis_add/'.$patient_id), 'refresh');
    }

    }
        function save_patient_item_issue_info_07_11_2023()
    {
        $data['bill_no']     = $this->input->post('bill_no');
        $data['patient_id']     = $this->input->post('patient_id');
       
        $data['grand_total']   = $this->input->post('grand_total');
        $data['received_amount']   = $this->input->post('received_amount');
        $data['due_amount']   = $this->input->post('due_amount');
        $data['payment_status']     = $this->input->post('payment_status');
        $data['payment_mode_id']     = $this->input->post('payment_mode_id');
        $data['issue_type']     = $this->input->post('issue_type');
        $data['dispatched_through']     = $this->input->post('dispatched_through');
        // $data['destination']     = $this->input->post('destination');
        $data['delivery_note']     = $this->input->post('delivery_note');
        if ($this->input->post('issue_type') == 'challan') {
            $data['challan_status']     = 1;
            $data['challan_date']     = date('Y-m-d');
        } else {
            $data['invoice_date']     = date('Y-m-d');
        }
        $model_ids           = $this->input->post('model_id');
        $model_quantities    = $this->input->post('model_quantity');
        $model_prices    = $this->input->post('model_price');

        // $basic_prices    = $this->input->post('basic_price');
        $tax_percentages    = $this->input->post('tax_percentage');
        $taxes    = $this->input->post('tax');
        $discount_percentages    = $this->input->post('discount_percentage');
        $discounts    = $this->input->post('discount');
        $total_prices    = $this->input->post('total_price');

        $number_of_entries      = sizeof($model_ids);
        $models              = array();

        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
                $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i]);
                array_push($models, $new_entry);
            }
        }
        $data['models']     = json_encode($models);
        $returned_array = null_checking($data);
        $this->db->insert('patient_item_issue', $returned_array);
    }
    
    function save_patient_item_issue_info_21_09()
    {
        $data['bill_no']     = $this->input->post('bill_no');
        $data['patient_id']     = $this->input->post('patient_id');
        $data['sum_total_price']   = $this->input->post('sum_total_price');
        $data['discount_type']   = $this->input->post('discount_type');
        $data['discount_value']   = $this->input->post('discount_value');
        $data['total_amount']   = $this->input->post('total_amount');
        $data['tax_type']   = $this->input->post('tax_type');
        $data['tax_per']   = $this->input->post('tax_per');
        $data['tax_amount']   = $this->input->post('tax_amount');
        $data['grand_total']   = $this->input->post('grand_total');
        $data['received_amount']   = $this->input->post('received_amount');
        $data['due_amount']   = $this->input->post('due_amount');
        $data['payment_status']     = $this->input->post('payment_status');
        $data['payment_mode_id']     = $this->input->post('payment_mode_id');
        $data['issue_type']     = $this->input->post('issue_type');
        $data['dispatched_through']     = $this->input->post('dispatched_through');
        $data['destination']     = $this->input->post('destination');
        $data['delivery_note']     = $this->input->post('delivery_note');
        if ($this->input->post('issue_type') == 'challan') {
            $data['challan_status']     = 1;
            $data['challan_date']     = date('Y-m-d');
        } else {
            $data['invoice_date']     = date('Y-m-d');
        }
        $model_ids           = $this->input->post('model_id');
        $model_quantities    = $this->input->post('model_quantity');
        $model_prices    = $this->input->post('model_price');

        $basic_prices    = $this->input->post('basic_price');
        $tax_percentages    = $this->input->post('tax_percentage');
        $taxes    = $this->input->post('tax');
        $total_prices    = $this->input->post('total_price');

        $number_of_entries      = sizeof($model_ids);
        $models              = array();

        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
                $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i], 'basic_price' => $basic_prices[$i], 'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i], 'total_price' => $total_prices[$i]);
                array_push($models, $new_entry);
            }
        }
        $data['models']     = json_encode($models);
        $returned_array = null_checking($data);
        $this->db->insert('patient_item_issue', $returned_array);
    }
    function convert_to_invoice()
    {
        $patient_item_issue_id     = $this->input->post('id');
        $data['invoice_date']     = $this->input->post('invoice_date');
        $data['issue_type'] = 'invoice';
        $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $data);
    }
    function update_patient_item_issue_status($patient_item_issue_id)
    {
        $data['payment_status'] = 'paid';
        $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $data);
    }
    //Manoj End
function search_income()
    {
        $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
        $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
        
        $this->db->select('income.*,income_head.income_head_name')->from('income');
        $this->db->join('income_head', 'income.income_head_id = income_head.income_id', 'left');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $results=$query->result_array();
    }

    function search_expense()
    {
        $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
        $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
 
        $this->db->select('expense.*,expense_head.expense_head_name')->from('expense');
        $this->db->join('expense_head', 'expense.expense_head_id = expense_head.expense_id', 'left');
        $this->db->where('date >=', $date_from);
        $this->db->where('date <=', $date_to);
        $query = $this->db->get();
        return $results=$query->result_array();
    }
    // Manoj
    
    function select_pathology_test_category_info()
    {
        return $this->db->where('is_active', 'Y')->get('pathology_test_category')->result_array();
    }
    function save_pathology_test_category_info()
    {
        $data['test_category']         = $this->input->post('test_category');
        $data['description']         = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->insert('pathology_test_category', $returned_array);
    }
    function update_pathology_test_category_info($pathology_test_category_id)
    {
        $data['test_category']         = $this->input->post('test_category');
        $data['description']         = $this->input->post('description');
        $returned_array = null_checking($data);
        $this->db->where('id', $pathology_test_category_id);
        $this->db->update('pathology_test_category', $returned_array);
    }
    function delete_pathology_test_category_info($pathology_test_category_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $pathology_test_category_id);
        $this->db->update('pathology_test_category', $data);
    }
    function select_pathology_test_info()
    {
        $this->db->select('pathology_test.*, pathology_test_category.test_category');
        $this->db->from('pathology_test');
        $this->db->join('pathology_test_category', 'pathology_test_category.id = pathology_test.test_category_id', 'left');
        $this->db->where('pathology_test.is_active', 'Y');
        $result = $this->db->get()->result_array();
        return $result;
    }
    function save_pathology_test_info()
    {
        $data['test_name']         = $this->input->post('test_name');
        $data['short_name']         = $this->input->post('short_name');
        $data['test_type']       = $this->input->post('test_type');
        $data['test_category_id']     = $this->input->post('test_category_id');
        $data['unit']         = $this->input->post('unit');
        $data['sub_category']         = $this->input->post('sub_category');
        $data['report_days']         = $this->input->post('report_days');
        $data['method']         = $this->input->post('method');
        $data['price']         = $this->input->post('price');
        $data['description']         = $this->input->post('description');

        $returned_array = null_checking($data);
        $this->db->insert('pathology_test', $returned_array);
        $pathology_test_id  =   $this->db->insert_id();
    }
    function update_pathology_test_info($pathology_test_id)
    {
        $data['test_name']         = $this->input->post('test_name');
        $data['short_name']         = $this->input->post('short_name');
        $data['test_type']       = $this->input->post('test_type');
        $data['test_category_id']     = $this->input->post('test_category_id');
        $data['unit']         = $this->input->post('unit');
        $data['sub_category']         = $this->input->post('sub_category');
        $data['report_days']         = $this->input->post('report_days');
        $data['method']         = $this->input->post('method');
        $data['price']         = $this->input->post('price');
        $data['description']         = $this->input->post('description');

        $returned_array = null_checking($data);
        $this->db->where('id', $pathology_test_id);
        $this->db->update('pathology_test', $returned_array);
        $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    }
    function delete_pathology_test_info($pathology_test_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $pathology_test_id);
        $this->db->update('pathology_test', $data);
    }
    function select_pathology_patient_report_info()
    {
        $this->db->select('pathology_patient_report.*, pathology_test.test_name,patient.name as patient_name,doctor.name as doctor_name');
        $this->db->from('pathology_patient_report');
        $this->db->join('pathology_test', 'pathology_test.id = pathology_patient_report.pathology_test_id', 'left');
        $this->db->join('patient', 'patient.patient_id = pathology_patient_report.patient_id', 'left');
        $this->db->join('doctor', 'doctor.doctor_id = pathology_patient_report.doctor_id', 'left');
        $this->db->where('pathology_patient_report.is_active', 'Y');
        $result = $this->db->get()->result_array();
        return $result;
    }
    function search_pathology_patient_report_info()
    {
        $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
        $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
        $this->db->select('pathology_patient_report.*, pathology_test.test_name,patient.name as patient_name,doctor.name as doctor_name');
        $this->db->from('pathology_patient_report');
        $this->db->join('pathology_test', 'pathology_test.id = pathology_patient_report.pathology_test_id', 'left');
        $this->db->join('patient', 'patient.patient_id = pathology_patient_report.patient_id', 'left');
        $this->db->join('doctor', 'doctor.doctor_id = pathology_patient_report.doctor_id', 'left');
        $this->db->where('pathology_patient_report.is_active', 'Y');
        $this->db->where('pathology_patient_report.date >=', $date_from);
        $this->db->where('pathology_patient_report.date <=', $date_to);
        $result = $this->db->get()->result_array();
        return $result;
    }
    function save_pathology_patient_report_info()
    {
        $data['patient_id']         = $this->input->post('patient_id');
        $data['pathology_test_id']         = $this->input->post('pathology_test_id');
        $data['doctor_id']       = $this->input->post('doctor_id');
        $data['charge']     = $this->input->post('charge');
        $data['date']     = date('Y-m-d', strtotime($this->input->post('date')));
        $data['description']     = $this->input->post('description');
        $data['payment_status']     = $this->input->post('payment_status');
        $data['payment_mode_id']     = $this->input->post('payment_mode_id');
        if ($this->input->post('payment_status') == 'paid') {
            $data['payment_date']     = date('Y-m-d H:i:s');
        }

        $returned_array = null_checking($data);
        $this->db->insert('pathology_patient_report', $returned_array);
        $pathology_patient_report_id  =   $this->db->insert_id();

        if (isset($_FILES["attachment"]) && !empty($_FILES['attachment']['name'])) {

            $fileInfo = pathinfo($_FILES["attachment"]["name"]);

            $attachment_name = $pathology_patient_report_id . '.' . $fileInfo['extension'];

            move_uploaded_file($_FILES["attachment"]["tmp_name"], "./uploads/pathology_patient_report_attachment/" . $attachment_name);

            $data = array('file_name' => $_FILES["attachment"]["name"], 'upload_name' => $attachment_name, 'attachment' => 'uploads/pathology_patient_report_attachment/' . $attachment_name);
            $this->db->where('id', $pathology_patient_report_id);
            $this->db->update('pathology_patient_report', $data);
        }
    }
    function update_pathology_patient_report_info($pathology_patient_report_id)
    {
        $data['patient_id']         = $this->input->post('patient_id');
        $data['pathology_test_id']         = $this->input->post('pathology_test_id');
        $data['doctor_id']       = $this->input->post('doctor_id');
        $data['charge']     = $this->input->post('charge');
        $data['date']     = date('Y-m-d', strtotime($this->input->post('date')));
        $data['description']     = $this->input->post('description');
        $data['payment_status']     = $this->input->post('payment_status');
        $data['payment_mode_id']     = $this->input->post('payment_mode_id');
        if ($this->input->post('payment_status') == 'paid') {
            $data['payment_date']     = date('Y-m-d H:i:s');
        }

        $returned_array = null_checking($data);
        $this->db->where('id', $pathology_patient_report_id);
        $this->db->update('pathology_patient_report', $returned_array);

        if (isset($_FILES["attachment"]) && !empty($_FILES['attachment']['name'])) {
            $fileInfo = pathinfo($_FILES["attachment"]["name"]);
            $attachment_name = $pathology_patient_report_id . '.' . $fileInfo['extension'];
            move_uploaded_file($_FILES["attachment"]["tmp_name"], "./uploads/pathology_patient_report_attachment/" . $attachment_name);
            $data = array('file_name' => $_FILES["attachment"]["name"], 'upload_name' => $attachment_name, 'attachment' => 'uploads/pathology_patient_report_attachment/' . $attachment_name);
            $this->db->where('id', $pathology_patient_report_id);
            $this->db->update('pathology_patient_report', $data);
        }
        $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    }
    function delete_pathology_patient_report_info($pathology_patient_report_id)
    {
        $data['is_active'] = "N";
        $this->db->where('id', $pathology_patient_report_id);
        $this->db->update('pathology_patient_report', $data);
    }
    // Manoj End
    
          function update_followup_info($follow_up_id)
    {
        $data['days']         = $this->input->post('days');
        $returned_array = null_checking($data);
        $this->db->where('id', $follow_up_id);
        $this->db->update('follow_up', $returned_array);
    }
      function alert_medicine_info()
    {
     return $this->db->select('*')->from('medicine')->where('(total_quantity - sold_quantity) <= alert_quantity', null, false)->or_where('(total_quantity - sold_quantity) = alert_quantity', null, false)->get()->result_array();

        //return $this->db->get('medicine')->result_array();
    }
    
      function staffid_validation_on_create($staff_id)
    {
       
        $num_rows = 0;
        $user_array = array('doctor', 'nurse', 'pharmacist', 'laboratorist', 'accountant', 'receptionist');
        $size = sizeof($user_array);

        for ($i = 0; $i < $size; $i++) {
            $this->db->where('staff_id', $staff_id);
            $query = $this->db->get($user_array[$i]);
            $num_rows = $query->num_rows();
            if ($num_rows > 0) {
                return 0;
            }
        }
        return 1;
    }
    
    	function staffid_validation_on_edit($staff_id, $id, $type){
		$num_rows = 0;
		$user_array = array('doctor', 'nurse', 'pharmacist', 'laboratorist', 'accountant', 'receptionist');
		$size = sizeof($user_array);
		for($i = 0; $i < $size; $i++){
			if($type == $user_array[$i]){
				$this->db->where_not_in($user_array[$i].'_id', $id);
				$this->db->where('staff_id', $staff_id);
				$num_rows = $this->db->get($user_array[$i])->num_rows();
				if($num_rows > 0){
					return 0;
				}
			}
			else{
				$this->db->where('staff_id', $staff_id);
				$num_rows = $this->db->get($user_array[$i])->num_rows();
				if($num_rows > 0){
					return 0;
				}
			}
		}
		return 1;
	}
	
	function save_unit()
    {
        $data['unit_name'] = $this->input->post('unit_name');
        $returned_array = null_checking($data);
        $this->db->insert('unit', $returned_array);
    }

    function select_unit()
    {
        return $this->db->get('unit')->result_array();
    }

    function update_unit($unit_id)
    {
        $data['unit_name'] = $this->input->post('unit_name');
        $returned_array = null_checking($data);
        $this->db->where('unit_id', $unit_id);
        $this->db->update('unit', $returned_array);
    }

    function delete_unit($unit_id)
    {
        $this->db->where('unit_id', $unit_id);
        $this->db->delete('unit');
    }
    
    function save_item_subcategory_info()
    {
        $data['item_category']         = $this->input->post('item_category');
        $data['item_subcategory']         = $this->input->post('item_subcategory');
        $returned_array = null_checking($data);
        $this->db->insert('item_subcategory', $returned_array);
    }

    function select_item_subcategory_info()
    {
        $this->db->select('item_subcategory.*, item_category.item_category');
        $this->db->from('item_subcategory');
        $this->db->join('item_category', 'item_category.id = item_subcategory.item_category', 'left');
        $result = $this->db->get()->result_array();
        return $result;
    }

    function update_item_subcategory_info($item_id)
    {
        $data['item_category']         = $this->input->post('item_category');
        $data['item_subcategory']         = $this->input->post('item_subcategory');
        $returned_array = null_checking($data);
        $this->db->where('item_id', $item_id);
        $this->db->update('item_subcategory',$returned_array);
    }

    function delete_item_subcategory_info($item_id)
    {
        $this->db->where('item_id', $item_id);
        $this->db->delete('item_subcategory');
    }
    function save_warranty_info()
    {
        $data['name']         = $this->input->post('name');
         $data['year_month']         = $this->input->post('year_month');
       // $returned_array = null_checking($data);
        $this->db->insert('warranty', $data);
    }

    function select_warranty_info()
    {
        return $this->db->get('warranty')->result_array();
    }

    function update_warranty_info($warranty_id)
    {
        $data['name']         = $this->input->post('name');
         $data['year_month']         = $this->input->post('year_month');
        $returned_array = null_checking($data);
        $this->db->where('id', $warranty_id);
        $this->db->update('warranty',$returned_array);
    }

    function delete_warranty_info($warranty_id)
    {
        $this->db->where('id', $warranty_id);
        $this->db->delete('warranty');  
    }
    function save_diagnosis_info()
    {
        $data['slno']         = $this->input->post('slno');
        $data['name']         = $this->input->post('name');
        $data['qty']         = $this->input->post('qty');
        $data['price']         = $this->input->post('price');
        $data['discount_type']         = $this->input->post('discount_type');
        $data['discount_price']         = $this->input->post('discount_price');
       // $returned_array = null_checking($data);
        $this->db->insert('diagnosis', $data);
    }

    function select_diagnosis_info()
    {
        return $this->db->get('diagnosis')->result_array();
    }

    function update_diagnosis_info($diagnosis_id)
    {
        $data['slno']         = $this->input->post('slno');
        $data['name']         = $this->input->post('name');
        $data['qty']         = $this->input->post('qty');
        $data['price']         = $this->input->post('price');
        $data['discount_type']         = $this->input->post('discount_type');
        $data['discount_price']         = $this->input->post('discount_price');
        $returned_array = null_checking($data);
        $this->db->where('id', $diagnosis_id);
        $this->db->update('diagnosis',$returned_array);
    }

    function delete_diagnosis_info($diagnosis_id)
    {
        $this->db->where('id', $diagnosis_id);
        $this->db->delete('diagnosis');
    }
       function add_consultation_fee($patient_id)
    {
        $type = $this->session->userdata('login_type');
        
        $data['patient_id']       = $this->input->post('patient_id');
        $data['date']       = $this->input->post('date');
        $data['consultation_name']       = $this->input->post('consultation_name');
        $data['qty']       = $this->input->post('qty');
        $data['price']       = $this->input->post('price');
        $data['discount_type']       = $this->input->post('discount_type');
        // $data['discount_price']       = $this->input->post('discount_price');
        // $data['total_price']       = $this->input->post('total_price');
        
          $data['referred_by']       = $this->input->post('referred_by');
            $data['visit_type']       = $this->input->post('visit_type');
              $data['remarks']       = $this->input->post('remarks');
                $data['patient_status']       = 'existing';
        $data['login_type']       = $type;

        if ($data['discount_type'] == 'fixed') {
            $discount_price      = $data['price'];
            $total = 0;
        } else {
            $discount_price       = 0;
            $total = $data['price'];
        }
        
        $data['total_price']       = $total;
        $data['discount_price'] =$discount_price;
         $existingRecord = $this->db->get_where('patient_consultation_history', array('patient_id' => $data['patient_id'], 'date' => $data['date']))->row();

    if ($existingRecord) {
       $this->session->set_flashdata('error_message', get_phrase('You_have_already_generated_consultaion_fee_for_this patient_on_this_date'));
       
        return;
    }

           // $returned_array = null_checking($data);
            $this->db->insert('patient_consultation_history',$data);
           // $patient_id  =   $this->db->insert_id();
          
       
    }
    
    
      function add_consultation_fee_07_11_2023($patient_id)
    {
        $type = $this->session->userdata('login_type');
        
        $data['patient_id']       = $this->input->post('patient_id');
        $data['date']       = $this->input->post('date');
        $data['consultation_name']       = $this->input->post('consultation_name');
        $data['qty']       = $this->input->post('qty');
        $data['price']       = $this->input->post('price');
        $data['discount_type']       = $this->input->post('discount_type');
        $data['discount_price']       = $this->input->post('discount_price');
        $data['total_price']       = $this->input->post('total_price');
        
          $data['referred_by']       = $this->input->post('referred_by');
            $data['visit_type']       = $this->input->post('visit_type');
              $data['remarks']       = $this->input->post('remarks');
                $data['patient_status']       = 'existing';
        $data['login_type']       = $type;
        

         $existingRecord = $this->db->get_where('patient_consultation_history', array('patient_id' => $data['patient_id'], 'date' => $data['date']))->row();

    if ($existingRecord) {
       $this->session->set_flashdata('error_message', get_phrase('You_have_already_generated_consultaion_fee_for_this patient_on_this_date'));
       
        return;
    }

           // $returned_array = null_checking($data);
            $this->db->insert('patient_consultation_history',$data);
           // $patient_id  =   $this->db->insert_id();
          
       
    }
    
     function add_diagnosis_fee($patient_id)
    {
        $type = $this->session->userdata('login_type');
        
        $data['patient_id']       = $this->input->post('patient_id');
        $data['date']       = date('Y-m-d', strtotime($this->input->post('date')));

        $data['diagnosis_id']       = $this->input->post('diagnosis_id');
        $data['login_type']       = $type;
        

         $existingRecord = $this->db->get_where('patient_diagnosis', array('patient_id' => $data['patient_id'], 'date' => $data['date']))->row();

    if ($existingRecord) {
       $this->session->set_flashdata('error_message', get_phrase('You_have_already_added_diagnosis_report_for_this patient_on_this_date'));
       
        return;
    }

            $returned_array = null_checking($data);
            $this->db->insert('patient_diagnosis',$returned_array);
           // $patient_id  =   $this->db->insert_id();
      
          
       
    }
     function patient_visit_history($patient_id)
    {
        //return $this->db->get('patient')->result_array();
        $this->db->select('patient.*, blood_bank.blood_group as bloodgroup');
        $this->db->from('patient');
        $this->db->join('blood_bank', 'patient.blood_group = blood_bank.blood_group_id ', 'left');
          $this->db->where('patient.patient_id', $patient_id);
      return $this->db->get()->row_array(); 
    }
  //saumya
  
    function patient_checkup_info($patient_id)
    {
        $this->db->select('patient_consultation_history.*, patient.code, patient.name, patient.phone, patient.sex, patient.age');
        $this->db->from('patient_consultation_history');
        $this->db->join('patient', 'patient_consultation_history.patient_id = patient.patient_id', 'left');
        $this->db->where('patient_consultation_history.patient_id', $patient_id);
        return $this->db->get()->result_array();
    }
    
    function save_patient_document()
    {
        $type = $this->session->userdata('login_type');
    
        $patient_id = $this->input->post('patient_id');
        $patient_consultation_history_id = $this->input->post('patient_consultation_history_id');
        $name = $this->input->post('name');
        $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); // Get the file extension
        $data["{$name}_document"] = $patient_id . $patient_consultation_history_id . $name . '.' . $file_extension;
        $this->db->where('id',$patient_consultation_history_id);
        $this->db->update('patient_consultation_history',$data);
        
        move_uploaded_file($_FILES["file"]["tmp_name"], 'uploads/patient_image/' . $patient_id . $patient_consultation_history_id . $name . '.' . $file_extension);
    }
     function save_patient_pres_document_old()
    {
     $patient_id = $this->input->post('patient_id');
  $patient_info = $this->db->get_where('patient', array('patient_id' => $patient_id))->row();
    $pname = $patient_info->name;
    $code = $patient_info->code;
    
        $type = $this->session->userdata('login_type');
       
        $patient_consultation_history_id = $this->input->post('patient_consultation_history_id');
        $name = $this->input->post('name');
         $name_extension = $pname . '_' . $code . '_' . $patient_consultation_history_id.'_'.$name;
        $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); // Get the file extension
        $data["{$name}_document"] = $name_extension . '.' . $file_extension;
        $this->db->where('id',$patient_consultation_history_id);
        $this->db->update('patient_consultation_history',$data);
        move_uploaded_file($_FILES["file"]["tmp_name"], 'uploads/patient_image/' . $name_extension . '.' . $file_extension);
    }
    function save_patient_pres_document()
{
    $patient_id = $this->input->post('patient_id');
    $patient_info = $this->db->get_where('patient', array('patient_id' => $patient_id))->row();
    $pname = $patient_info->name;
    $phone = $patient_info->phone;

    $type = $this->session->userdata('login_type');
    $prescription_id = $this->input->post('prescription_id');
    $name = $this->input->post('name');
    $date = date('d-m-Y');
    $name_extension = $pname . '_' . $phone . '_' . $prescription_id . '_' . $name;
    $file_extension = pathinfo($_FILES["prescription_document"]["name"], PATHINFO_EXTENSION); // Get the file extension
    // $data["{$name}_document"] = $name_extension . '.' . $file_extension;

    $insert_data = array(
        'patient_id' => $patient_id,
        'prescription_id' => $prescription_id,
        'prescription_document' => $name_extension . '.' . $file_extension,
        'date' => $date
    );

    $this->db->insert('prescription_upload', $insert_data);
    
    $inserted_id = $this->db->insert_id();
    $new_document_name = $inserted_id . '_' . $name_extension . '.' . $file_extension;
    move_uploaded_file($_FILES["prescription_document"]["tmp_name"], 'uploads/patient_image/' . $new_document_name);
    //end

    // move_uploaded_file($_FILES["prescription_document"]["tmp_name"], 'uploads/patient_image/' . $name_extension . '.' . $file_extension);
}
     function save_patient_diag_document_old()
    {
        $type = $this->session->userdata('login_type');
        $patient_id = $this->input->post('patient_id');
         $patient_info = $this->db->get_where('patient', array('patient_id' => $patient_id))->row();
    $pname = $patient_info->name;
    $code = $patient_info->phone;
                           
        $patient_consultation_history_id = $this->input->post('patient_consultation_history_id');
        $name = $this->input->post('name');
         $name_extension = $pname . '_' . $code . '_' . $patient_consultation_history_id.'_'.$name;
        $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); // Get the file extension
        $data["{$name}_document"] =  $name_extension . '.' . $file_extension;
         $data['patient_id']         = $patient_id;
         $data['date']         = date('d-m-Y');
         $data['diagnosis_id']  =$patient_consultation_history_id;
         
         
        $this->db->insert('diagnosis_document_upload', $data);
        move_uploaded_file($_FILES["file"]["tmp_name"], 'uploads/patient_image/' .  $name_extension . '.' . $file_extension);
    }
    
    function save_patient_diag_document()
{
    $patient_id = $this->input->post('patient_id');
    $patient_info = $this->db->get_where('patient', array('patient_id' => $patient_id))->row();
    $pname = $patient_info->name;
    $phone = $patient_info->phone;

    $type = $this->session->userdata('login_type');
    $diag_id = $this->input->post('patient_consultation_history_id');
    $name = $this->input->post('name');
    $date = date('d-m-Y');
    $name_extension = $pname . '_' . $phone . '_' . $diag_id . '_' . $name;
    $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION); // Get the file extension
    // $data["{$name}_document"] = $name_extension . '.' . $file_extension;

    $insert_data = array(
        'patient_id' => $patient_id,
        'diagnosis_id' => $diag_id,
        'diagnosis_document' => $name_extension . '.' . $file_extension,
        'date' => $date
    );

    $this->db->insert('diagnosis_document_upload', $insert_data);
    
    $inserted_id = $this->db->insert_id();
    $new_document_name = $inserted_id . '_' . $name_extension . '.' . $file_extension;
    move_uploaded_file($_FILES["file"]["tmp_name"], 'uploads/patient_image/' . $new_document_name);
    //end

    // move_uploaded_file($_FILES["prescription_document"]["tmp_name"], 'uploads/patient_image/' . $name_extension . '.' . $file_extension);
}
     function save_purchase_entry_info()
    {
        $data['supplier_id']         = $this->input->post('supplier_id');
        $data['invoice_no']         = $this->input->post('invoice_no');
        $data['supplier_invoice_no']         = $this->input->post('supplier_invoice_no');
        $data['invoice_date']     = date('m/d/Y', strtotime($this->input->post('invoice_date')));
        $data['total_amount']     = $this->input->post('total_amount');
        $data['discount_type']     = $this->input->post('discount_type');
        $data['discount_value']     = $this->input->post('discount_value');
        $data['tax_type']     = $this->input->post('tax_type');
        $data['tax_value']     = $this->input->post('tax_value');
        $data['grand_total']     = $this->input->post('grand_total');
        $data['payment_status']     = $this->input->post('payment_status');
        $data['payment_mode_id']     = $this->input->post('payment_mode_id');
        $data['received_amount']     = $this->input->post('received_amount');
        $data['due_amount']     = $this->input->post('due_amount');
      

            $item_id=$this->input->post('item_id');
            $item_quantity=$this->input->post('item_quantity');
            $item_batch=$this->input->post('item_batch');
            $item_price=$this->input->post('item_price');
            $item_amount=$this->input->post('item_amount');
            $item_array   = array();

        foreach ($item_id as $key => $value) {
            if($value != ''){
            $item_array[] = array(
                'item_id' => $value,
                'item_quantity' => $item_quantity[$key],
                'item_batch' => $item_batch[$key],
                'item_price'   => $item_price[$key],
                'item_amount'  => $item_amount[$key]
            );
        }
        }
    
        $data['items'] = serialize($item_array);
        $returned_array = null_checking($data);
        $this->db->insert('purchase', $returned_array);
}
function select_purchase_entry_items_info($purchase_id)
{
    $this->db->select('purchase.*');
    $this->db->from('purchase');
    $this->db->where('purchase.id', $purchase_id);
    return $this->db->get()->row_array();
}

function update_purchase_entry_info($purchase_id)
    {
        $data['supplier_id']         = $this->input->post('supplier_id');
        $data['invoice_no']         = $this->input->post('invoice_no');
        $data['supplier_invoice_no']         = $this->input->post('supplier_invoice_no');
        $data['invoice_date']     = date('m/d/Y', strtotime($this->input->post('invoice_date')));
        $data['total_amount']     = $this->input->post('total_amount');
        $data['discount_type']     = $this->input->post('discount_type');
        $data['discount_value']     = $this->input->post('discount_value');
        $data['tax_type']     = $this->input->post('tax_type');
        $data['tax_value']     = $this->input->post('tax_value');
        $data['grand_total']     = $this->input->post('grand_total');
        $data['payment_status']     = $this->input->post('payment_status');
        $data['payment_mode_id']     = $this->input->post('payment_mode_id');
        $data['received_amount']     = $this->input->post('received_amount');
        $data['due_amount']     = $this->input->post('due_amount');
      

            $item_id=$this->input->post('item_id');
            $item_quantity=$this->input->post('item_quantity');
            $item_batch=$this->input->post('item_batch');
            $item_price=$this->input->post('item_price');
            $item_amount=$this->input->post('item_amount');
            $item_array   = array();

        foreach ($item_id as $key => $value) {
            if($value != ''){
            $item_array[] = array(
                'item_id' => $value,
                'item_quantity' => $item_quantity[$key],
                'item_batch' => $item_batch[$key],
                'item_price'   => $item_price[$key],
                'item_amount'  => $item_amount[$key]
            );
        }
        }
    
        $data['items'] = serialize($item_array);
        $returned_array = null_checking($data);
       // Assuming you have the purchase_id value
        $this->db->where('id', $purchase_id); 
        $this->db->update('purchase', $returned_array);
        
}

function edit_patient_consultation_history_info($pres_id)
    {
        $data['referred_by']       = $this->input->post('referred_by');        
        $data['visit_type']            = $this->input->post('visit_type');        
        $data['remarks']       = $this->input->post('remarks');  
        $data['consultation_name'] 		= $this->input->post('consultation_name');  
        $data['price']       = $this->input->post('price');  
        $data['discount_type']       = $this->input->post('discount_type');
        $data['discount_price']       = $this->input->post('discount_price');  
        $data['total_price']       = $this->input->post('total_price');        
         
            $input_date = $this->input->post('date');
$date_obj = DateTime::createFromFormat('m/d/Y', $input_date);
$formatted_date = $date_obj->format('d-m-Y');
$data['date'] = $formatted_date;

        $returned_array = null_checking($data);
        $this->db->where('id',$pres_id);
        $this->db->update('patient_consultation_history',$returned_array);           
    }
    
    function select_patient_consultation_history_info()
    {
        $this->db->select('patient_consultation_history.*,patient.name as patient_name,patient.code as patient_code');
        $this->db->from('patient_consultation_history');
        $this->db->join('patient', 'patient_consultation_history.patient_id = patient.patient_id','left');
        return $this->db->get()->result_array();
    }
    function delete_prescription_upload($pres_id)
{
    // Retrieve the document name
    $document_info = $this->db->get_where('prescription_upload', array('id' => $pres_id))->row();
    $prescription_name = $document_info->prescription_document;

    // Delete the database record
    $this->db->where('id', $pres_id);
    $this->db->delete('prescription_upload');

    // Remove the uploaded file
    if ($prescription_name) {
        $file_path = 'uploads/patient_image/' . $pres_id .'_'. $prescription_name;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}

 function delete_diag_upload($diag_id)
{
    // Retrieve the document name
    $document_info = $this->db->get_where('diagnosis_document_upload', array('id' => $diag_id))->row();
    $diag_name = $document_info->diagnosis_document;

    // Delete the database record
    $this->db->where('id', $diag_id);
    $this->db->delete('diagnosis_document_upload');

    // Remove the uploaded file
    if ($diag_name) {
        $file_path = 'uploads/patient_image/' . $diag_id .'_'. $diag_name;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}
public function searchProducts($term) {
    $this->db->select('referred_by');
    $this->db->like('referred_by', $term);
    $this->db->where('referred_by !=', 'self');
    $this->db->group_by('referred_by');
    $query = $this->db->get('patient');

    return $query->result();
}

function update_bank_details() {
        $data['description'] = $this->input->post('bank_name');
        $returned_array = null_checking($data);
        $this->db->where('type', 'bank_name');
        $this->db->update('bank_details', $returned_array);

        $data['description'] = $this->input->post('ac_name');
        $returned_array = null_checking($data);
        $this->db->where('type', 'ac_name');
        $this->db->update('bank_details', $returned_array);

        $data['description'] = $this->input->post('ac_no');
        $returned_array = null_checking($data);
        $this->db->where('type', 'ac_no');
        $this->db->update('bank_details', $returned_array);

        $data['description'] = $this->input->post('branch');
        $returned_array = null_checking($data);
        $this->db->where('type', 'branch');
        $this->db->update('bank_details', $returned_array);

        $data['description'] = $this->input->post('ifsc_code');
        $returned_array = null_checking($data);
        $this->db->where('type', 'ifsc_code');
        $this->db->update('bank_details', $returned_array);

        $data['description'] = $this->input->post('pan_no');
        $returned_array = null_checking($data);
        $this->db->where('type', 'pan_no');
        $this->db->update('bank_details', $returned_array);

    }
function select_doctor_history() {
    $this->db->select('*');
    $this->db->from('patient');
     $this->db->where('referred_by !=', 'self');
    $this->db->group_by('referred_by');
    $query = $this->db->get();

    return $query->result_array();
}
function doctor_visit_history($referred_by)
{
    $this->db->select('*');
    $this->db->from('patient');   
    $this->db->where('referred_by', $referred_by);
    return $this->db->get()->result_array(); 
}


public function get_today_patient_data()
{
    $this->db->select('patient_consultation_history.*, patient.name as patient_name, patient.code as patient_code, patient.phone as patient_phone, patient.age as patient_age, patient.sex as patient_sex, patient.visit_type as patient_visittype, patient.patient_id as patientid, patient.blood_group as patient_bloodgroup');
    $this->db->from('patient_consultation_history');
    $this->db->where('patient_consultation_history.date', date('d-m-Y'));
    $this->db->join('patient', 'patient_consultation_history.patient_id = patient.patient_id', 'left');
    
    return $this->db->get()->result_array();
}
    function get_today_diagnosis_data($patient_id)
    {
        $this->db->select_sum('sum_total_price'); // Select the sum of 'sum_total_price' column
        $this->db->from('patient_diagnosis');   
        $this->db->where('patient_id', $patient_id);
        $this->db->where('date', date('Y-m-d'));
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        $result = $query->row();
        return $result->sum_total_price; // Return the sum_total_price value
    } else {
        return 0; // Return 0 if no results found or no grand_total value found
    }
    }
    
    function get_today_patientitemissue_data($patient_id)
    {
        $this->db->select('*');
        $this->db->from('patient_item_issue');
        $this->db->where('patient_id', $patient_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
function save_patient_item_issue_info_04_04_2024()
{
    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    // $data['destination']     = $this->input->post('destination');
    $data['delivery_note']     = $this->input->post('delivery_note');
    if ($this->input->post('issue_type') == 'challan') {
        $data['challan_status']     = 1;
        $data['challan_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    } else if ($this->input->post('issue_type') == 'invoice'){
        $data['invoice_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    }else if ($this->input->post('issue_type') == 'money_receipt'){
        $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date')));  
        
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
    $model_prices    = $this->input->post('model_price');

    // $basic_prices    = $this->input->post('basic_price');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i]);
            array_push($models, $new_entry);
        }
    }
    $data['models']     = json_encode($models);
    $returned_array = null_checking($data);
    $this->db->insert('patient_item_issue', $returned_array);
}

function save_patient_item_issue_info()
{
    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
    $data['coupon']   = $this->input->post('coupon');
    $data['coupon_perc']   = $this->input->post('coupon_perc');
    $data['coupon_value']   = $this->input->post('coupon_value');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    // $data['destination']     = $this->input->post('destination');
    $data['delivery_note']     = $this->input->post('delivery_note');
    if ($this->input->post('issue_type') == 'challan') {
        $data['challan_status']     = 1;
        $data['challan_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    } else if ($this->input->post('issue_type') == 'invoice'){
        $data['invoice_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    }else if ($this->input->post('issue_type') == 'money_receipt'){
        $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date')));  
        
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
    $model_prices    = $this->input->post('model_price');
     $model_old_prices    = $this->input->post('model_old_price');
    $item_price_details_ids    = $this->input->post('model_serial_no');
    // $basic_prices    = $this->input->post('basic_price');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i],'old_price' => $model_old_prices[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'item_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);


            $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
            $this->db->where('id', $item_price_details_ids[$i]);
            $this->db->update('item_price_details');

        }
    }
    $data['models']     = json_encode($models);

    $payments              = array();

            $new_payments = array('grand_total' => $this->input->post('grand_total'), 'received_amount' => $this->input->post('received_amount'), 'due_amount' => $this->input->post('due_amount'),'date' => date('Y-m-d'),'payment_status' =>  $this->input->post('payment_status'),'payment_mode_id'    => $this->input->post('payment_mode_id'));
            array_push($payments, $new_payments);

    $data['payments']     = json_encode($payments);


    $returned_array = null_checking($data);
    $this->db->insert('patient_item_issue', $returned_array);
}

function save_patient_item_issue_info_06_05_2024()
{
    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
        $data['coupon']   = $this->input->post('coupon');
    $data['coupon_perc']   = $this->input->post('coupon_perc');
    $data['coupon_value']   = $this->input->post('coupon_value');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    // $data['destination']     = $this->input->post('destination');
    $data['delivery_note']     = $this->input->post('delivery_note');
    if ($this->input->post('issue_type') == 'challan') {
        $data['challan_status']     = 1;
        $data['challan_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    } else if ($this->input->post('issue_type') == 'invoice'){
        $data['invoice_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    }else if ($this->input->post('issue_type') == 'money_receipt'){
        $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date')));  
        
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
     $model_old_prices    = $this->input->post('model_old_price');
    $model_prices    = $this->input->post('model_price');
    $item_price_details_ids    = $this->input->post('model_serial_no');
    // $basic_prices    = $this->input->post('basic_price');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'old_price' => $model_old_prices[$i],'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'item_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);


            $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
            $this->db->where('id', $model_ids[$i]);
            $this->db->update('item');

        }
    }
    $data['models']     = json_encode($models);
    $returned_array = null_checking($data);
    $this->db->insert('patient_item_issue', $returned_array);
}

function save_patient_item_issue_info_trial()
{
    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    // $data['destination']     = $this->input->post('destination');
    $data['delivery_note']     = $this->input->post('delivery_note');
    $data['demo']     = $this->input->post('item_issue_type');
    $data['return_days']     = $this->input->post('return_days');
    if ($this->input->post('issue_type') == 'challan') {
        $data['challan_status']     = 1;
        $data['challan_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    } else if ($this->input->post('issue_type') == 'invoice'){
        $data['invoice_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    }else if ($this->input->post('issue_type') == 'money_receipt'){
        $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date')));  
        
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
    $model_prices    = $this->input->post('model_price');
    $item_price_details_ids    = $this->input->post('model_serial_no');
    // $basic_prices    = $this->input->post('basic_price');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'demoitem_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);


            $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
            $this->db->where('id', $model_ids[$i]);
            $this->db->update('demoitem');

        }
    }
    $data['models']     = json_encode($models);
    $returned_array = null_checking($data);
    $this->db->insert('patient_item_issue', $returned_array);
}

    function select_patientitemissue_info($id)
    {
        $this->db->select('*');
        $this->db->from('patient_item_issue');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function update_patient_item_issue_info()
    {
        $patient_item_issue_id = $this->input->post('patient_item_issue_id');
        $data['payment_status'] = $this->input->post('payment_status');
        $data['payment_mode_id'] = $this->input->post('payment_mode_id');
        $data['issue_type'] = $this->input->post('issue_type');
        $data['dispatched_through'] = $this->input->post('dispatched_through');
        $data['delivery_note'] = $this->input->post('delivery_note');
    
        if ($data['issue_type'] == 'challan') {
            $data['challan_status'] = 1;
            $data['challan_date'] =  date('Y-m-d', strtotime($this->input->post('date')));
        } else {
            $data['invoice_date'] = date('Y-m-d', strtotime($this->input->post('date')));
        }
    
        // Assuming null_checking is a function that handles default values or checks
        $returned_array = null_checking($data);
    
        $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $returned_array);
    }

    function update_main_patient_item_issue_info_04_04_2024()
{
    $patient_item_issue_id = $this->input->post('patient_item_issue_id');
    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    // $data['destination']     = $this->input->post('destination');
    $data['delivery_note']     = $this->input->post('delivery_note');
    if ($data['issue_type'] == 'challan') {
        $data['challan_status'] = 1;
        $data['challan_date'] =  date('Y-m-d', strtotime($this->input->post('date')));
    } else if($data['issue_type'] == 'invoice') {
        $data['invoice_date'] = date('Y-m-d', strtotime($this->input->post('date')));
    }else{   //($this->input->post('issue_type') == 'money_receipt')
    $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date'))); 
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
    $model_prices    = $this->input->post('model_price');

    // $basic_prices    = $this->input->post('basic_price');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i]);
            array_push($models, $new_entry);
        }
    }
    $data['models']     = json_encode($models);
    $returned_array = null_checking($data);
    $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $returned_array);
}


    function update_main_patient_item_issue_info_17_04_2024()
{
    $patient_item_issue_id = $this->input->post('patient_item_issue_id');
    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    $data['demo']     = $this->input->post('item_issue_type');
    $data['return_days']     = $this->input->post('return_days');
    // $data['destination']     = $this->input->post('destination');
    $data['delivery_note']     = $this->input->post('delivery_note');
    if ($data['issue_type'] == 'challan') {
        $data['challan_status'] = 1;
        $data['challan_date'] =  date('Y-m-d', strtotime($this->input->post('date')));
    } else if($data['issue_type'] == 'invoice') {
        $data['invoice_date'] = date('Y-m-d', strtotime($this->input->post('date')));
    }else{   //($this->input->post('issue_type') == 'money_receipt')
    $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date'))); 
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
    $model_prices    = $this->input->post('model_price');
    $item_price_details_ids    = $this->input->post('model_serial_no');
     $available    = $this->input->post('available');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();


    /*  $item_price_details_ids    = $this->input->post('model_serial_no');
    // $basic_prices    = $this->input->post('basic_price');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'item_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);


            $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
            $this->db->where('id', $model_ids[$i]);
            $this->db->update('item'); */

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'item_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);
if($available[$i] == 0){
    $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
    $this->db->where('id', $model_ids[$i]);
    $this->db->update('item');
}
            
        }
    }
    $data['models']     = json_encode($models);
    $returned_array = null_checking($data);
    $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $returned_array);
}

 function update_main_patient_item_issue_info()
{
    $patient_item_issue_id = $this->input->post('patient_item_issue_id');
    $models = $this->db->select('*')->from('patient_item_issue')->where('id', $patient_item_issue_id)->get()->row()->models;
    $payments = $this->db->select('*')->from('patient_item_issue')->where('id', $patient_item_issue_id)->get()->row()->payments;

//     echo "Patient Item Issue ID: " . $patient_item_issue_id . "<br>";
// echo "Models: " . $models . "<br>";
// exit();

    $models_array = json_decode($models, true);
    if (!empty($models_array)) {
        foreach ($models_array as $model) {
            $item_price_details_id = $model['item_price_details_id'];
            $quantity = $model['quantity'];


            $this->db->set('quantity', 'quantity +' . $quantity, FALSE);
            $this->db->where('id', $item_price_details_id);
            $this->db->update('item_price_details');
        }
    } 


    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    $data['demo']     = $this->input->post('item_issue_type');
    $data['return_days']     = $this->input->post('return_days');
    // $data['destination']     = $this->input->post('destination');
    $data['delivery_note']     = $this->input->post('delivery_note');


    if ($this->input->post('issue_type') == 'challan') {
        $data['challan_status']     = 1;
        $data['challan_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    } else if ($this->input->post('issue_type') == 'invoice'){
        $data['invoice_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    }
    else if ($this->input->post('issue_type') == 'demo'){
        $data['invoice_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
        $data['demo']     = $this->input->post('item_issue_type');
        $data['return_days']     = $this->input->post('return_days');
    }else if ($this->input->post('issue_type') == 'money_receipt'){
        $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date')));  
        
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
    $model_prices    = $this->input->post('model_price');
        $model_old_prices    = $this->input->post('model_old_price');
    $item_price_details_ids    = $this->input->post('model_serial_no');
     $available    = $this->input->post('available');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();




    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'old_price' => $model_old_prices[$i],'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'item_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);
//if($available[$i] == 0){
    $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
    $this->db->where('id', $item_price_details_ids[$i]);
    $this->db->update('item_price_details');
//}
            
        }
    }
    $data['models']     = json_encode($models);

    $paymentss              = array();

    $payments_array = json_decode($payments, true);

    $grand_total = $this->input->post('grand_total');
    $received_amount = $this->input->post('received_amount');
     $due_amount = $this->input->post('due_amount');
$remaining_amount = 0;
    if (!empty($payments_array)) {
        $srr=1;
        foreach ($payments_array as $payment) {

            if($srr == 1){
                $remaining_amount = $due_amount;
                $new_payments = array('grand_total' => $grand_total, 'received_amount' => $received_amount, 'due_amount' => $due_amount,'date' => date('Y-m-d'),'payment_status' =>  $this->input->post('payment_status'),'payment_mode_id' => $this->input->post('payment_mode_id'));
            }else{
                $remaining_amount -= $payment['received_amount'];
                $new_payments = array('grand_total' => $grand_total, 'received_amount' => $payment['received_amount'], 'due_amount' => $remaining_amount,'date' => date('Y-m-d'),'payment_status' =>  $payment['payment_status'],'payment_mode_id' => $payment['payment_mode_id']);
            }
          
    array_push($paymentss, $new_payments);
    $srr++;

        }
    }

$data['payments']     = json_encode($paymentss);

    $returned_array = null_checking($data);
    $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $returned_array);
}


    function update_main_patient_item_issue_info_06_05_2024()
{
    $patient_item_issue_id = $this->input->post('patient_item_issue_id');
    $models = $this->db->select('*')->from('patient_item_issue')->where('id', $patient_item_issue_id)->get()->row()->models;

//     echo "Patient Item Issue ID: " . $patient_item_issue_id . "<br>";
// echo "Models: " . $models . "<br>";
// exit();

    $models_array = json_decode($models, true);
    if (!empty($models_array)) {
        foreach ($models_array as $model) {
            $item_price_details_id = $model['item_price_details_id'];
            $quantity = $model['quantity'];


            $this->db->set('quantity', 'quantity +' . $quantity, FALSE);
            $this->db->where('id', $item_price_details_id);
            $this->db->update('item_price_details');
        }
    } 

    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    $data['demo']     = $this->input->post('item_issue_type');
    $data['return_days']     = $this->input->post('return_days');
    // $data['destination']     = $this->input->post('destination');
    $data['delivery_note']     = $this->input->post('delivery_note');


    if ($this->input->post('issue_type') == 'challan') {
        $data['challan_status']     = 1;
        $data['challan_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    } else if ($this->input->post('issue_type') == 'invoice'){
        $data['invoice_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
    }
    else if ($this->input->post('issue_type') == 'demo'){
        $data['invoice_date']     =  date('Y-m-d', strtotime($this->input->post('date')));  
        $data['demo']     = $this->input->post('item_issue_type');
        $data['return_days']     = $this->input->post('return_days');
    }else if ($this->input->post('issue_type') == 'money_receipt'){
        $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date')));  
        
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
    $model_prices    = $this->input->post('model_price');
        $model_old_prices    = $this->input->post('model_old_price');
    $item_price_details_ids    = $this->input->post('model_serial_no');
     $available    = $this->input->post('available');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();


    /*  $item_price_details_ids    = $this->input->post('model_serial_no');
    // $basic_prices    = $this->input->post('basic_price');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'item_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);


            $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
            $this->db->where('id', $model_ids[$i]);
            $this->db->update('item'); */

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i],'old_price' => $model_old_prices[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'item_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);
//if($available[$i] == 0){
    $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
    $this->db->where('id', $item_price_details_ids[$i]);
    $this->db->update('item_price_details');
//}
            
        }
    }
    $data['models']     = json_encode($models);
    $returned_array = null_checking($data);
    $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $returned_array);
}


function update_main_patient_item_issue_info_trial()
{
    $patient_item_issue_id = $this->input->post('patient_item_issue_id');
    

    if($this->input->post('item_issue_type') == '2'){
    $this->db->select('models');
    $this->db->from('patient_item_issue');   
    $this->db->where('id', $patient_item_issue_id);
    $query = $this->db->get();
    $row = $query->row();

    // Check if row exists and 'models' data is not empty
    if ($row && !empty($row->models)) {
        $models = json_decode($row->models);

        // Check if $models is an array and not empty
        if (is_array($models) && !empty($models)) {
            foreach ($models as $model) {
                // Access each property of the model object
                $model_id = $model->model_id;
                $quantity = $model->quantity;
                // Update the quantity in the 'demoitem' table
                $this->db->set('quantity', 'quantity + ' . $quantity, FALSE);
                $this->db->where('id', $model_id);
                $this->db->update('demoitem');
            }
        }
    }

}

    $data['bill_no']     = $this->input->post('bill_no');
    $data['patient_id']     = $this->input->post('patient_id');
   
    $data['grand_total']   = $this->input->post('grand_total');
    $data['received_amount']   = $this->input->post('received_amount');
    $data['due_amount']   = $this->input->post('due_amount');
    $data['payment_status']     = $this->input->post('payment_status');
    $data['payment_mode_id']     = $this->input->post('payment_mode_id');
    $data['issue_type']     = $this->input->post('issue_type');
    $data['dispatched_through']     = $this->input->post('dispatched_through');
    // $data['destination']     = $this->input->post('destination');
    $data['demo']     = $this->input->post('item_issue_type');
    $data['return_days']     = $this->input->post('return_days');
    $data['delivery_note']     = $this->input->post('delivery_note');
    if ($data['issue_type'] == 'challan') {
        $data['challan_status'] = 1;
        $data['challan_date'] =  date('Y-m-d', strtotime($this->input->post('date')));
    } else if($data['issue_type'] == 'invoice') {
        $data['invoice_date'] = date('Y-m-d', strtotime($this->input->post('date')));
    }else{   //($this->input->post('issue_type') == 'money_receipt')
    $data['money_receipt_date']     =  date('Y-m-d', strtotime($this->input->post('money_receipt_date'))); 
    }
    $model_ids           = $this->input->post('model_id');
    $model_quantities    = $this->input->post('model_quantity');
    $model_prices    = $this->input->post('model_price');
    $item_price_details_ids    = $this->input->post('model_serial_no');
     $available    = $this->input->post('available');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();


    /*  $item_price_details_ids    = $this->input->post('model_serial_no');
    // $basic_prices    = $this->input->post('basic_price');
    $tax_percentages    = $this->input->post('tax_percentage');
    $taxes    = $this->input->post('tax');
    $discount_percentages    = $this->input->post('discount_percentage');
    $discounts    = $this->input->post('discount');
    $total_prices    = $this->input->post('total_price');

    $number_of_entries      = sizeof($model_ids);
    $models              = array();

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'item_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);


            $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
            $this->db->where('id', $model_ids[$i]);
            $this->db->update('item'); */

    for ($i = 0; $i < $number_of_entries; $i++) {
        if ($model_ids[$i] != "" && $model_quantities[$i] != "" && $model_prices[$i] != "") {
            $new_entry = array('model_id' => $model_ids[$i], 'quantity' => $model_quantities[$i], 'price' => $model_prices[$i],'tax_percentage' => $tax_percentages[$i], 'tax' => $taxes[$i],'discount_percentage' => $discount_percentages[$i], 'discount' => $discounts[$i], 'total_price' => $total_prices[$i],'demoitem_price_details_id' => $item_price_details_ids[$i]);
            array_push($models, $new_entry);
if($available[$i] == 0){
    $this->db->set('quantity', 'quantity - ' . $model_quantities[$i], FALSE);
    $this->db->where('id', $model_ids[$i]);
    $this->db->update('demoitem');
}
            
        }
    }
    $data['models']     = json_encode($models);
    $returned_array = null_checking($data);
    $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $returned_array);
}
function delete_patient_item_issue($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('patient_item_issue');
    }
function item_details($item_id)
    {
        $this->db->select('item.*');
        $this->db->from('item');
        $this->db->where('id', $item_id);

        $result = $this->db->get()->result_array();
        return $result;
    }
    

    function save_item_price_17_04_2024()
    {
        $sl_no = $this->input->post('sl_no');
        $unit_price = $this->input->post('unit_price');

        // Check if the sl_no already exists
        /* $existing_sl_no = $this->db->get_where('item_price_details', array('sl_no' => $sl_no))->row();

        // Check if the unit_price already exists
        $existing_unit_price = $this->db->get_where('item_price_details', array('unit_price' => $unit_price))->row();

        if ($existing_sl_no || $existing_unit_price) {
            // If a matching row exists for either sl_no or unit_price, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        }*/

        // Check if the sl_no and unit_price combination already exists
        $existing_price = $this->db->get_where('item_price_details', array('sl_no' => $sl_no, 'unit_price' => $unit_price))->row();

        if ($existing_price) {
            // If a matching row exists, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        } else {
            $data['sl_no'] = $sl_no;
            // $data['sl_no']     = $this->input->post('sl_no');
            $data['item_id']    = $this->input->post('item_id');
            $data['unit_price'] = $unit_price;
            // $data['unit_price']    = $this->input->post('unit_price');
            $data['date_time'] = date('d-m-Y', strtotime($this->input->post('date_time')));

            $returned_array = null_checking($data);
            $this->db->insert('item_price_details', $returned_array);
            $this->session->set_flashdata('message', get_phrase('item_price_details_saved_successfuly'));
        }
    }
    
    
    function save_item_price()
    {
        $sl_no = $this->input->post('sl_no');
        $quantity = $this->input->post('quantity');
        $unit_price = $this->input->post('unit_price');

        // Check if the sl_no already exists
        /* $existing_sl_no = $this->db->get_where('item_price_details', array('sl_no' => $sl_no))->row();

        // Check if the unit_price already exists
        $existing_unit_price = $this->db->get_where('item_price_details', array('unit_price' => $unit_price))->row();

        if ($existing_sl_no || $existing_unit_price) {
            // If a matching row exists for either sl_no or unit_price, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        }*/

        // Check if the sl_no and unit_price combination already exists
        $existing_price = $this->db->get_where('item_price_details', array('sl_no' => $sl_no,'quantity' => $quantity, 'unit_price' => $unit_price))->row();

        if ($existing_price) {
            // If a matching row exists, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        } else {
            $data['sl_no'] = $sl_no;
             $data['quantity']     = $quantity;
            $data['item_id']    = $this->input->post('item_id');
            $data['unit_price'] = $unit_price;
            // $data['unit_price']    = $this->input->post('unit_price');
            $data['date_time'] = date('d-m-Y', strtotime($this->input->post('date_time')));

            $returned_array = null_checking($data);
            $this->db->insert('item_price_details', $returned_array);
            $this->session->set_flashdata('message', get_phrase('item_price_details_saved_successfuly'));
        }
    }
    
    function update_item_price_17_04_2024($item_id)
    {
        $sl_no = $this->input->post('sl_no');
        $unit_price = $this->input->post('unit_price');

        // Check if the sl_no already exists for a different item_id
        /*$existing_sl_no = $this->db->get_where('item_price_details', array('sl_no' => $sl_no, 'id !=' => $item_id))->row();

        // Check if the unit_price already exists for a different item_id
        $existing_unit_price = $this->db->get_where('item_price_details', array('unit_price' => $unit_price, 'id !=' => $item_id))->row();

        if ($existing_sl_no || $existing_unit_price) {
            // If a matching row exists for either sl_no or unit_price with a different item_id, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        }*/

        // Check if the sl_no or unit_price already exists for a different item_id
        $existing_entry = $this->db->get_where('item_price_details', array('id !=' => $item_id, 'sl_no' => $sl_no, 'unit_price' => $unit_price))->row();

        if ($existing_entry) {
            // If a matching row exists for sl_no and unit_price with a different item_id, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        } else {
            // If no duplicate entry is found, proceed with updating the data
            $data['sl_no'] = $sl_no;
            // $data['sl_no']     = $this->input->post('sl_no');
            $data['unit_price'] = $unit_price;
            // $data['unit_price']    = $this->input->post('unit_price');
            $data['date_time'] = date('d-m-Y');

            $returned_array = null_checking($data);
            $this->db->where('id', $item_id);
            $this->db->update('item_price_details', $returned_array);
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
    }
    
     function update_item_price($item_id)
    {
        $sl_no = $this->input->post('sl_no');
        $unit_price = $this->input->post('unit_price');
        $quantity = $this->input->post('quantity');

        // Check if the sl_no already exists for a different item_id
        /*$existing_sl_no = $this->db->get_where('item_price_details', array('sl_no' => $sl_no, 'id !=' => $item_id))->row();

        // Check if the unit_price already exists for a different item_id
        $existing_unit_price = $this->db->get_where('item_price_details', array('unit_price' => $unit_price, 'id !=' => $item_id))->row();

        if ($existing_sl_no || $existing_unit_price) {
            // If a matching row exists for either sl_no or unit_price with a different item_id, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        }*/

        // Check if the sl_no or unit_price already exists for a different item_id
        $existing_entry = $this->db->get_where('item_price_details', array('id !=' => $item_id, 'sl_no' => $sl_no,'quantity' => $quantity, 'unit_price' => $unit_price))->row();

        if ($existing_entry) {
            // If a matching row exists for sl_no and unit_price with a different item_id, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        } else {
            // If no duplicate entry is found, proceed with updating the data
            $data['sl_no'] = $sl_no;
            $data['quantity']     = $quantity;
            // $data['sl_no']     = $this->input->post('sl_no');
            $data['unit_price'] = $unit_price;
            // $data['unit_price']    = $this->input->post('unit_price');
            $data['date_time'] = date('d-m-Y');

            $returned_array = null_checking($data);
            $this->db->where('id', $item_id);
            $this->db->update('item_price_details', $returned_array);
            $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
        }
    }

    function delete_item_price($item_id)
    {
        $this->db->where('id', $item_id);
        $this->db->delete('item_price_details');
    }
    
    public function insert_referral($data) {
        $this->db->insert('doctor_referral', $data);
        return $this->db->insert_id();
    }
    
    
   public function insert_referral_details_diagnosis($data) {
    $this->db->insert('doctor_referral_details_diagnosis', $data);
    //$this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    return $this->db->insert_id();
}

 public function insert_referral_details_item_issue($data) {
    $this->db->insert('doctor_referral_details_item_issue', $data);
 //   $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
    return $this->db->insert_id();
}

    function update_sales_return_patient_item_issue_info()
{
    $patient_item_issue_id = $this->input->post('patient_item_issue_id');
    $data['sales_return_amount']   = $this->input->post('sales_return_amount');
    $data['sales_return_due']   = $this->input->post('sales_return_due');
    $data['total_sales_return_amount']   = $this->input->post('total_sales_return_amount');
    $data['sales_return_reason']     = $this->input->post('sales_return_reason');
    $data['sales_return_date'] = date('Y-m-d', strtotime($this->input->post('sales_return_date')));
    $data['sales_return']   = 'returned';
    $returned_array = null_checking($data);
    $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $returned_array);
        /*after sales return update quantity in item*/
}
function save_demoitem_price()
    {
        $sl_no = $this->input->post('sl_no');
        $unit_price = $this->input->post('unit_price');

        // Check if the sl_no already exists
        /* $existing_sl_no = $this->db->get_where('item_price_details', array('sl_no' => $sl_no))->row();

        // Check if the unit_price already exists
        $existing_unit_price = $this->db->get_where('item_price_details', array('unit_price' => $unit_price))->row();

        if ($existing_sl_no || $existing_unit_price) {
            // If a matching row exists for either sl_no or unit_price, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        }*/

        // Check if the sl_no and unit_price combination already exists
        $existing_price = $this->db->get_where('demoitem_price_details', array('sl_no' => $sl_no, 'unit_price' => $unit_price))->row();

        if ($existing_price) {
            // If a matching row exists, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        } else {
            $data['sl_no'] = $sl_no;
            // $data['sl_no']     = $this->input->post('sl_no');
            $data['item_id']    = $this->input->post('item_id');
            $data['unit_price'] = $unit_price;
            // $data['unit_price']    = $this->input->post('unit_price');
            $data['date_time'] = date('d-m-Y', strtotime($this->input->post('date_time')));

            $returned_array = null_checking($data);
            $this->db->insert('demoitem_price_details', $returned_array);
            $this->session->set_flashdata('message', get_phrase('demoitem_price_details_saved_successfully'));
        }
    }
    function update_demoitem_price($item_id)
    {
        $sl_no = $this->input->post('sl_no');
        $unit_price = $this->input->post('unit_price');

        // Check if the sl_no already exists for a different item_id
        /*$existing_sl_no = $this->db->get_where('item_price_details', array('sl_no' => $sl_no, 'id !=' => $item_id))->row();

        // Check if the unit_price already exists for a different item_id
        $existing_unit_price = $this->db->get_where('item_price_details', array('unit_price' => $unit_price, 'id !=' => $item_id))->row();

        if ($existing_sl_no || $existing_unit_price) {
            // If a matching row exists for either sl_no or unit_price with a different item_id, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        }*/

        // Check if the sl_no or unit_price already exists for a different item_id
        $existing_entry = $this->db->get_where('demoitem_price_details', array('id !=' => $item_id, 'sl_no' => $sl_no, 'unit_price' => $unit_price))->row();

        if ($existing_entry) {
            // If a matching row exists for sl_no and unit_price with a different item_id, return an error or handle it accordingly
            $this->session->set_flashdata('error_message', get_phrase('duplicate_entry_error_message'));
        } else {
            // If no duplicate entry is found, proceed with updating the data
            $data['sl_no'] = $sl_no;
            // $data['sl_no']     = $this->input->post('sl_no');
            $data['unit_price'] = $unit_price;
            // $data['unit_price']    = $this->input->post('unit_price');
            $data['date_time'] = date('d-m-Y');

            $returned_array = null_checking($data);
            $this->db->where('id', $item_id);
            $this->db->update('demoitem_price_details', $returned_array);
            $this->session->set_flashdata('message', get_phrase('updated_successfully'));
        }
    }
    function delete_demoitem_price($item_id)
    {
        $this->db->where('id', $item_id);
        $this->db->delete('demoitem_price_details');
    }
    
    function add_phone_log($id)
    {
  
        
         $item_issue_id =$id;
        $date =  date('Y-m-d', strtotime($this->input->post('date')));
        $followup_date =  date('Y-m-d', strtotime($this->input->post('followup_date'))); 
        
           $call_by = $this->input->post('call_by');
        $contact = $this->input->post('contact');
        $call_duration = $this->input->post('call_duration');
       $note = $this->input->post('note');
       $stopped = $this->input->post('stop');
      
        
         $data = array(
        'item_issue_id' => $item_issue_id,
        'created_date' => $date,
        'next_followup_date' => $followup_date,
        'call_by' => $call_by,
        'call_phone' => $contact,
        'call_duration' => $call_duration,
        'note' => $note
    );
    
    // Insert data into next_followup table
    $this->db->insert('next_followup', $data);
    
    // Update follow-up date in patient_item_issues table
     if (!$stopped) {
    $followup_data = array(
        'followup_date' => $followup_date
    );
    $this->db->where('id', $id);
    $this->db->update('patient_item_issue', $followup_data);
     }
    }
    
    function patient_item_issue_payment()
{
    $patient_item_issue_id = $this->input->post('patient_item_issue_id');
    $payments = $this->db->select('*')->from('patient_item_issue')->where('id', $patient_item_issue_id)->get()->row()->payments;
    $paymentss              = array();
    $payments_array = json_decode($payments, true);
    $grand_total = $this->input->post('grand_total');
    $received_amount = $this->input->post('received_amount');
     $due_amount = $this->input->post('due_amount');
     $payment_status =  $this->input->post('payment_status');
     $payment_mode_id = $this->input->post('payment_mode_id');

     $new_received_amount = 0;

    if (!empty($payments_array)) {
        foreach ($payments_array as $payment) {
            $new_received_amount += $payment['received_amount'];

                $new_payments = array('grand_total' => $grand_total, 'received_amount' => $payment['received_amount'], 'due_amount' => $payment['due_amount'] ,'date' => date('Y-m-d'),'payment_status' =>  $payment['payment_status'],'payment_mode_id' => $payment['payment_mode_id']);
            
          
    array_push($paymentss, $new_payments);


        }
    }
    $new_received_amount += $received_amount;


    $new_paymentss = array('grand_total' => $grand_total, 'received_amount' => $received_amount, 'due_amount' => $due_amount ,'date' => date('Y-m-d'),'payment_status' =>  $payment_status,'payment_mode_id' => $payment_mode_id);
            
          
    array_push($paymentss, $new_paymentss);

$new_due_amount = $grand_total - $new_received_amount;
    $data['received_amount']     = $new_received_amount;
    $data['due_amount']     = $new_due_amount;
$data['payments']     = json_encode($paymentss);
$data['payment_status']     = $payment_status;

    $returned_array = null_checking($data);
    $this->db->where('id', $patient_item_issue_id);
        $this->db->update('patient_item_issue', $returned_array);
}

function update_doctor_name($doctor_name, $doctor_name_new)
{
    // Start a transaction
    $this->db->trans_start();

    // Update table 'patient'
    $this->db->where('referred_by', $doctor_name);
    $this->db->update('patient', array('referred_by' => $doctor_name_new));

    // Update table 'patient_item_issue'
    $this->db->where('referral_doctor', $doctor_name);
    $this->db->update('patient_item_issue', array('referral_doctor' => $doctor_name_new));

    // Update table 'patient_diagnosis'
    $this->db->where('referral_doctor', $doctor_name);
    $this->db->update('patient_diagnosis', array('referral_doctor' => $doctor_name_new));

    // Update table 'doctor_referral'
    $this->db->where('doctor_name', $doctor_name);
    $this->db->update('doctor_referral', array('doctor_name' => $doctor_name_new));

    // Check for any database errors
    if ($this->db->trans_status() === false) {
        // If any update fails, rollback the transaction
        $this->db->trans_rollback();
        // Handle the error, log it, or return an error message
        return false;
    } else {
        // If all updates are successful, commit the transaction
        $this->db->trans_commit();
        // Return true or any other success indication
        return true;
    }
}
function doctor_commission_report_info($doctor_name)
    {
        $date_from = date('d-m-Y', strtotime($this->input->post('date_from')));
        $date_to = date('d-m-Y', strtotime($this->input->post('date_to')));
        
        $this->db->select('doctor_referral.*')->from('doctor_referral');
       $this->db->where('doctor_referral.doctor_name', $doctor_name);
        $this->db->where('doctor_referral.payment_date >=', $date_from);
        $this->db->where('doctor_referral.payment_date <=', $date_to);
        $query = $this->db->get();
        return $results=$query->result_array();
    }

  function doctor_commission_report_info_all()
    {
        $this->db->select('doctor_referral.*');
        $this->db->from('doctor_referral');
       // $this->db->join('patient', 'patient_consultation_history.patient_id = patient.patient_id','left');
        return $this->db->get()->result_array();
    }
     function doctor_name_info()
    {
        $this->db->select('doctor_referral.*');
        $this->db->from('doctor_referral');
       // $this->db->join('patient', 'patient_consultation_history.patient_id = patient.patient_id','left');
         $this->db->group_by('doctor_referral.doctor_name');
        return $this->db->get()->result_array();
    }
    
   function doctor_commission_paid($referred_by)
{
    $this->db->select('*');
    $this->db->from('patient');   
    $this->db->where('referred_by', $referred_by);
    return $this->db->get()->result_array(); 
}
  function doctor_commission_paid_diag($referred_by, $payment_date, $referred_id) 
  {
     
     
       $this->db->select('doctor_referral_details_diagnosis.*,patient.name,patient.phone,patient.code');
    $this->db->from('doctor_referral_details_diagnosis');   
      $this->db->join('doctor_referral', 'doctor_referral_details_diagnosis.doctor_referral_id = doctor_referral.id','left');
       $this->db->join('patient', 'doctor_referral_details_diagnosis.patient_id = patient.patient_id','left');
    $this->db->where('doctor_referral.doctor_name', $referred_by);
       $this->db->where('doctor_referral.payment_date', $payment_date);
         $this->db->where('doctor_referral_details_diagnosis.doctor_referral_id', $referred_id);
       
    
    return $this->db->get()->result_array(); 
  }
public function doctor_commission_paid_item($referred_by, $payment_date, $referred_id) 
  {
       $this->db->select('doctor_referral_details_item_issue.*,patient.name,patient.phone,patient.code');
    $this->db->from('doctor_referral_details_item_issue');   
      $this->db->join('doctor_referral', 'doctor_referral_details_item_issue.doctor_referral_id = doctor_referral.id','left');
       $this->db->join('patient', 'doctor_referral_details_item_issue.patient_id = patient.patient_id','left');
    $this->db->where('doctor_referral.doctor_name', $referred_by);
     $this->db->where('doctor_referral.payment_date', $payment_date);
         $this->db->where('doctor_referral_details_item_issue.doctor_referral_id', $referred_id);
    return $this->db->get()->result_array(); 
  }
    
}
