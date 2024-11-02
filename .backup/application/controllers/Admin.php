<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *     @author : Creativeitem
 *     date    : 1 August, 2014
 *     http://codecanyon.net/user/Creativeitem
 *     http://creativeitem.com
 */

class Admin extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('crud_model');
        $this->load->model('email_model');
        $this->load->model('sms_model');
        $this->load->model('frontend_model');
          $this->load->library('Phpmailer_lib');
         
        
        // cache control
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
    // default function, redirects to login page if no admin logged in yet
    
    public function index()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($this->session->userdata('admin_login') == 1)
            redirect(site_url('admin/dashboard'), 'refresh');
    }
    
    // ADMIN DASHBOARD
    
    function dashboard()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
         $page_data['patient_consultation_history_info'] = $this->crud_model->select_patient_consultation_history_info();
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    
    // LANGUAGE SETTINGS
    
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] = $param2;
        }
        // if ($param1 == 'update_phrase') {
        //     $language     = $param2;
        //     $total_phrase = $this->input->post('total_phrase');
        //     for ($i = 1; $i < $total_phrase; $i++) {
        //         //$data[$language]    =    $this->input->post('phrase').$i;
        //         $this->db->where('phrase_id', $i);
        //         $this->db->update('language', array(
        //             $language => $this->input->post('phrase' . $i)
        //         ));
        //     }
        //     redirect(site_url('admin/manage_language/edit_phrase/' . $language), 'refresh');
        // }
        if ($param1 == 'do_update') {
            $language        = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(site_url('admin/manage_language'), 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(site_url('admin/manage_language'), 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);
            
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(site_url('admin/manage_language'), 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            
            redirect(site_url('admin/manage_language'), 'refresh');
        }
        $page_data['page_name']  = 'manage_language';
        $page_data['page_title'] = get_phrase('manage_language');
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    public function update_phrase_with_ajax() {
        $checker['phrase_id']                = $this->input->post('phraseId');
        $updater[$this->input->post('currentEditingLanguage')] = $this->input->post('updatedValue');

        $this->db->where('phrase_id', $checker['phrase_id']);
        $this->db->update('language', $updater);

        echo $checker['phrase_id'].' '.$this->input->post('currentEditingLanguage').' '.$this->input->post('updatedValue');
    }
    
    // SYSTEM SETTINGS
    
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'do_update') {
            $this->crud_model->update_system_settings();
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }
        
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    // SMS settings.
    function sms_settings($param1 = '')
    {
        
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'do_update') {
            $this->crud_model->update_sms_settings();
            $this->session->set_flashdata('message', get_phrase('settings_updated'));
            redirect(site_url('admin/sms_settings'), 'refresh');
        }
        
        $page_data['page_name']  = 'sms_settings';
        $page_data['page_title'] = get_phrase('sms_settings');
        $this->load->view('backend/index', $page_data);
    }
    
    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */
    
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'update_profile_info') {
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $validation    = email_validation_on_edit($data['email'], $this->session->userdata('login_user_id'), 'admin');
            if ($validation == 1) {
                $returned_array = null_checking($data);
                $this->db->where('admin_id', $this->session->userdata('login_user_id'));
                $this->db->update('admin', $returned_array);
                $this->session->set_flashdata('message', get_phrase('profile_info_updated_successfuly'));
                redirect(site_url('admin/manage_profile'), 'refresh');
            } else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
                redirect(site_url('admin/manage_profile'), 'refresh');
            }
            
        }
        if ($param1 == 'change_password') {
            $current_password_input = sha1($this->input->post('password'));
            $new_password           = sha1($this->input->post('new_password'));
            $confirm_new_password   = sha1($this->input->post('confirm_new_password'));
            
            $current_password_db = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('login_user_id')
            ))->row()->password;
            
            if ($current_password_db == $current_password_input && $new_password == $confirm_new_password) {
                $this->db->where('admin_id', $this->session->userdata('login_user_id'));
                $this->db->update('admin', array(
                    'password' => $new_password
                ));
                
                $this->session->set_flashdata('message', get_phrase('password_info_updated_successfuly'));
                redirect(site_url('admin/manage_profile'), 'refresh');
            } else {
                $this->session->set_flashdata('message', get_phrase('password_update_failed'));
                redirect(site_url('admin/manage_profile'), 'refresh');
            }
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('admin', array(
            'admin_id' => $this->session->userdata('login_user_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    function department($task = "", $department_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_department_info();
            $this->session->set_flashdata('message', get_phrase('department_info_saved_successfuly'));
            redirect(site_url('admin/department'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_department_info($department_id);
            $this->session->set_flashdata('message', get_phrase('department_info_updated_successfuly'));
            redirect(site_url('admin/department'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_department_info($department_id);
            redirect(site_url('admin/department'), 'refresh');
        }
        
        $data['department_info'] = $this->crud_model->select_department_info();
        $data['page_name']       = 'manage_department';
        $data['page_title']      = get_phrase('department');
        $this->load->view('backend/index', $data);
    }
    
    function department_facilities($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'add') {
            $this->frontend_model->add_department_facility($param2);
            $this->session->set_flashdata('message', get_phrase('facility_saved_successfully'));
            redirect(site_url('admin/department_facilities/' . $param2), 'refresh');
        }
        
        if ($param1 == 'edit') {
            $this->frontend_model->edit_department_facility($param2);
            $this->session->set_flashdata('message', get_phrase('facility_updated_successfully'));
            redirect(site_url('admin/department_facilities/' . $param3), 'refresh');
        }
        
        if ($param1 == 'delete') {
            $this->frontend_model->delete_department_facility($param2);
            $this->session->set_flashdata('message', get_phrase('facility_deleted_successfully'));
            redirect(site_url('admin/department_facilities/' . $param3), 'refresh');
        }
        
        $data['department_info'] = $this->frontend_model->get_department_info($param1);
        $data['facilities']      = $this->frontend_model->get_department_facilities($param1);
        $data['page_name']       = 'department_facilities';
        $data['page_title']      = get_phrase('department_facilities') . ' | ' . $data['department_info']->name . ' ' . get_phrase('department');
        $this->load->view('backend/index', $data);
    }
    
    function doctor($task = "", $doctor_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        if ($task == "create") {
            $email      = $_POST['email'];
            $validation = email_validation_on_create($email);
            
            if ($validation == 1) {
                $this->crud_model->save_doctor_info();
                $this->session->set_flashdata('message', get_phrase('doctor_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            }
            redirect(site_url('admin/doctor'), 'refresh');
        }
        if ($task == "update") {
            $this->crud_model->update_doctor_info($doctor_id);
            redirect(site_url('admin/doctor'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_doctor_info($doctor_id);
            redirect(site_url('admin/doctor'), 'refresh');
        }
        $data['doctor_info'] = $this->crud_model->select_doctor_info();
        $data['page_name']   = 'manage_doctor';
        $data['page_title']  = get_phrase('Audiologists');
        $this->load->view('backend/index', $data);
    }
    
    function patient($task = "", $patient_id = "",$param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_patient_info();
            $this->session->set_flashdata('message', get_phrase('patient_info_saved_successfuly'));
            redirect(site_url('admin/patient'), 'refresh');
        }
        if ($task == "update") {
            $this->crud_model->update_patient_info($patient_id);
            redirect(site_url('admin/patient'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_patient_info($patient_id);
            redirect(site_url('admin/patient'), 'refresh');
        }
         if ($task == "add_consultation_fee") {
            $this->crud_model->add_consultation_fee($patient_id);
            redirect(site_url('admin/patient'), 'refresh');
        }
        
         if ($task == "add_diagnosis_fee") {
            $this->crud_model->add_diagnosis_fee($patient_id);
            redirect(site_url('admin/patient'), 'refresh');
        }
        
        
        $data['patient_info'] = $this->crud_model->select_patient_info();
        $data['page_name']    = 'manage_patient';
        $data['page_title']   = get_phrase('patient');
        $this->load->view('backend/index', $data);
    }
    
    function nurse($task = "", $nurse_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $email      = $_POST['email'];
            $validation = email_validation_on_create($email);
            
            if ($validation == 1) {
                $this->crud_model->save_nurse_info();
                $this->session->set_flashdata('message', get_phrase('nurse_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            }
            redirect(site_url('admin/nurse'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_nurse_info($nurse_id);
            redirect(site_url('admin/nurse'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_nurse_info($nurse_id);
            redirect(site_url('admin/nurse'), 'refresh');
        }
        
        $data['nurse_info'] = $this->crud_model->select_nurse_info();
        $data['page_name']  = 'manage_nurse';
        $data['page_title'] = get_phrase('nurse');
        $this->load->view('backend/index', $data);
    }
    
    function pharmacist($task = "", $pharmacist_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $email      = $_POST['email'];
            $validation = email_validation_on_create($email);
            
            if ($validation == 1) {
                $this->crud_model->save_pharmacist_info();
                $this->session->set_flashdata('message', get_phrase('pharmacist_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            }
            redirect(site_url('admin/pharmacist'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_pharmacist_info($pharmacist_id);
            redirect(site_url('admin/pharmacist'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_pharmacist_info($pharmacist_id);
            redirect(site_url('admin/pharmacist'), 'refresh');
        }
        
        $data['pharmacist_info'] = $this->crud_model->select_pharmacist_info();
        $data['page_name']       = 'manage_pharmacist';
        $data['page_title']      = get_phrase('pharmacist');
        $this->load->view('backend/index', $data);
    }
    
    function laboratorist($task = "", $laboratorist_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $email      = $_POST['email'];
            $validation = email_validation_on_create($email);
            
            if ($validation == 1) {  
                $this->crud_model->save_laboratorist_info();               
                $this->session->set_flashdata('message', get_phrase('laboratorist_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            }
            redirect(site_url('admin/laboratorist'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_laboratorist_info($laboratorist_id);
            redirect(site_url('admin/laboratorist'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_laboratorist_info($laboratorist_id);
            redirect(site_url('admin/laboratorist'), 'refresh');
        }
        
        $data['laboratorist_info'] = $this->crud_model->select_laboratorist_info();
        $data['page_name']         = 'manage_laboratorist';
        $data['page_title']        = get_phrase('laboratorist');
        $this->load->view('backend/index', $data);
    }
    
    function accountant($task = "", $accountant_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $email      = $_POST['email'];
            $validation = email_validation_on_create($email);
            
            if ($validation == 1) {  
                $this->crud_model->save_accountant_info();              
                $this->session->set_flashdata('message', get_phrase('accountant_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            }
            redirect(site_url('admin/accountant'), 'refresh');
        }
                
        if ($task == "update") {
            $this->crud_model->update_accountant_info($accountant_id);
            redirect(site_url('admin/accountant'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_accountant_info($accountant_id);
            redirect(site_url('admin/accountant'), 'refresh');
        }
        
        $data['accountant_info'] = $this->crud_model->select_accountant_info();
        $data['page_name']       = 'manage_accountant';
        $data['page_title']      = get_phrase('accountant');
        $this->load->view('backend/index', $data);
    }
    
    function receptionist($task = "", $receptionist_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $email      = $_POST['email'];
            $validation = email_validation_on_create($email);
            
            if ($validation == 1) {  
                $this->crud_model->save_receptionist_info();             
                $this->session->set_flashdata('message', get_phrase('receptionist_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            }
            redirect(site_url('admin/receptionist'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_receptionist_info($receptionist_id);
            redirect(site_url('admin/receptionist'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_receptionist_info($receptionist_id);
            redirect(site_url('admin/receptionist'), 'refresh');
        }
        
        $data['receptionist_info'] = $this->crud_model->select_receptionist_info();
        $data['page_name']         = 'manage_receptionist';
        $data['page_title']        = get_phrase('receptionist');
        $this->load->view('backend/index', $data);
    }
    
    
    /***************** Tarini 16-06-2023****************************/
    function hr($task = "", $hr_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        if ($task == "create") {
            $email      = $_POST['email'];
            $validation = email_validation_on_create($email);
            
            if ($validation == 1) {
                $this->crud_model->save_hr_info();
                $this->session->set_flashdata('message', get_phrase('hr_info_saved_successfuly'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('duplicate_email'));
            }
            redirect(site_url('admin/hr'), 'refresh');
        }
        if ($task == "update") {
            $this->crud_model->update_hr_info($hr_id);
            redirect(site_url('admin/hr'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_hr_info($hr_id);
            redirect(site_url('admin/hr'), 'refresh');
        }
        $data['hr_info'] = $this->crud_model->select_hr_info();
        $data['page_name']   = 'manage_hr';
        $data['page_title']  = get_phrase('hr');
        $this->load->view('backend/index', $data);
    }


/***************** Tarini 16-06-2023****************************/
    
    
    
    
        function appointment($task = "", $appointment_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_appointment_info();
            $this->session->set_flashdata('message', get_phrase('appointment_info_saved_successfuly'));
            redirect(site_url('admin/appointment'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_appointment_info($appointment_id);
            $this->session->set_flashdata('message', get_phrase('appointment_info_updated_successfuly'));
            redirect(site_url('admin/appointment'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_appointment_info($appointment_id);
            redirect(site_url('admin/appointment'), 'refresh');
        }
        
        $data['appointment_info'] = $this->crud_model->select_appointment_info_by_doctor_id();
        $data['page_name']        = 'manage_appointment';
        $data['page_title']       = get_phrase('appointment');
        $this->load->view('backend/index', $data);
    }
    
    function appointment_requested($task = "", $appointment_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "approve") {
            $this->crud_model->approve_appointment_info($appointment_id);
            $this->session->set_flashdata('message', get_phrase('appointment_info_approved'));
            redirect(site_url('admin/appointment_requested'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_appointment_info($appointment_id);
            redirect(site_url('admin/appointment_requested'), 'refresh');
        }
        
        $data['requested_appointment_info'] = $this->crud_model->select_requested_appointment_info_by_doctor_id();
        $data['page_name']                  = 'manage_requested_appointment';
        $data['page_title']                 = get_phrase('requested_appointment');
        $this->load->view('backend/index', $data);
    }
    function patient_history()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        
        $data['patient_info'] = $this->crud_model->prescription_info();
        $data['page_name']    = 'manage_patient_history';
        $data['page_title']   = 'Patient History';
        $this->load->view('backend/index', $data);
    }
    function payment_history($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $data['invoice_info'] = $this->crud_model->select_invoice_info();
        $data['page_name']    = 'show_payment_history';
        $data['page_title']   = get_phrase('payment_history');
        $this->load->view('backend/index', $data);
    }
    
   
        function bed_allotment($task = "", $bed_allotment_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_bed_allotment_info();
            $this->session->set_flashdata('message', get_phrase('bed_allotment_info_saved_successfuly'));
            redirect(site_url('admin/bed_allotment'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_bed_allotment_info($bed_allotment_id);
            $this->session->set_flashdata('message', get_phrase('bed_allotment_info_updated_successfuly'));
            redirect(site_url('admin/bed_allotment'), 'refresh');
        }
         if ($task == "discharge") {
            $this->crud_model->discharge_bed_allotment_info($bed_allotment_id);
            $this->session->set_flashdata('message', get_phrase('bed_allotment_info_updated_successfuly'));
            redirect(site_url('admin/bed_allotment'), 'refresh');
        }
        if ($task == "delete") {
            $this->crud_model->delete_bed_allotment_info($bed_allotment_id);
            redirect(site_url('admin/bed_allotment'), 'refresh');
        }
        
        $data['bed_allotment_info'] = $this->crud_model->select_bed_allotment_info();
        $data['page_name']          = 'show_bed_allotment';
        $data['page_title']         = get_phrase('bed_allotment');
        $this->load->view('backend/index', $data);
    }
    
    function blood_bank($task = "", $blood_group_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        if ($task == "update") {
            $this->crud_model->update_blood_bank_info($blood_group_id);
            $this->session->set_flashdata('message', get_phrase('blood_bank_info_updated_successfuly'));
            redirect(site_url('admin/blood_bank'), 'refresh');
        }
        
        $data['blood_bank_info'] = $this->crud_model->select_blood_bank_info();
        $data['page_name']       = 'show_blood_bank';
        $data['page_title']      = get_phrase('blood_bank');
        $this->load->view('backend/index', $data);
    }
    
    function blood_donor1($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $data['blood_donor_info'] = $this->crud_model->select_blood_donor_info();
        $data['page_name']        = 'show_blood_donor';
        $data['page_title']       = get_phrase('blood_donor');
        $this->load->view('backend/index', $data);
    }
      function blood_donor($task = "", $blood_donor_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_blood_donor_info();
            $this->session->set_flashdata('message', get_phrase('blood_donor_info_saved_successfuly'));
            redirect(site_url('admin/blood_donor'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_blood_donor_info($blood_donor_id);
            $this->session->set_flashdata('message', get_phrase('blood_donor_info_updated_successfuly'));
            redirect(site_url('admin/blood_donor'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_blood_donor_info($blood_donor_id);
            redirect(site_url('admin/blood_donor'), 'refresh');
        }
        
        $data['blood_donor_info'] = $this->crud_model->select_blood_donor_info();
        $data['page_name']        = 'show_blood_donor';
        $data['page_title']       = get_phrase('blood_donor');
        $this->load->view('backend/index', $data);
    }
  
    function operation_report($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $data['page_name']  = 'show_operation_report';
        $data['page_title'] = get_phrase('operation_report');
        $this->load->view('backend/index', $data);
    }
    
    function birth_report($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $data['page_name']  = 'show_birth_report';
        $data['page_title'] = get_phrase('birth_report');
        $this->load->view('backend/index', $data);
    }
    
    function death_report($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $data['page_name']  = 'show_death_report';
        $data['page_title'] = get_phrase('death_report');
        $this->load->view('backend/index', $data);
    }
    function medicine_sales_report()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $data['page_name']  = 'show_medicine_sales_report';
        $data['page_title'] = 'Medicine Sales Report';
        $this->load->view('backend/index', $data);
    }
    
    function notice($task = "", $notice_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_notice_info();
            $this->session->set_flashdata('message', get_phrase('notice_info_saved_successfuly'));
            redirect(site_url('admin/notice'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_notice_info($notice_id);
            $this->session->set_flashdata('message', get_phrase('notice_info_updated_successfuly'));
            redirect(site_url('admin/notice'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_notice_info($notice_id);
            redirect(site_url('admin/notice'), 'refresh');
        }
        
        $data['notice_info'] = $this->crud_model->select_notice_info();
        $data['page_name']   = 'manage_notice';
        $data['page_title']  = get_phrase('noticeboard');
        $this->load->view('backend/index', $data);
    }
    
    // PAYROLL
    function payroll()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $page_data['page_name']  = 'payroll_add';
        $page_data['page_title'] = get_phrase('create_payroll');
        $this->load->view('backend/index', $page_data);
    }
    
    function payroll_selector()
    {
        
       
        
        
        
        $user        = explode('-', $this->input->post('employee_id'));
        $user_type   = $user[0];
        $employee_id = $user[1];
        $month       = $this->input->post('month');
        $year        = $this->input->post('year');
        
        
        
       //   $user_id = $this->input->post('user_id');
//$user_type = $this->input->post('user_type');
$date = $this->input->post('month') . ',' . $this->input->post('year');

$this->db->where('user_id', $employee_id);
$this->db->where('user_type', $user_type);
$this->db->where('date', $date);
$duplicate_check = $this->db->get('payroll')->row();

if ($duplicate_check) {
    $this->session->set_flashdata('error_message', get_phrase('payslip_already_generated_for_this_staff_for_chosen_month_year'));
  
    redirect(site_url('admin/payroll'), 'refresh');
}
        else{
            
           $page_data['user_type']   = $user_type;
        $page_data['employee_id'] = $employee_id;
        
        
        
        redirect(site_url('admin/payroll_view/' . $user_type . '/' . $employee_id . '/' . $month . '/' . $year), 'refresh');
    }
    }
    function payroll_view($user_type = '', $employee_id = '', $month = '', $year = '')
    {
        $page_data['user_type']   = $user_type;
        $page_data['employee_id'] = $employee_id;
        $page_data['month']       = $month;
        $page_data['year']        = $year;
        $page_data['page_name']   = 'payroll_add_view';
        $page_data['page_title']  = get_phrase('create_payroll');
        $this->load->view('backend/index', $page_data);
    }
    
    function create_payroll()
    {
        
    


        $data['payroll_code']   = substr(md5(rand(100000000, 20000000000)), 0, 7);
        $data['user_id']        = $this->input->post('user_id');
        $data['user_type']      = $this->input->post('user_type');
        $data['joining_salary'] = $this->input->post('joining_salary');
        
        $allowances        = array();
        $allowance_types   = $this->input->post('allowance_type');
        $allowance_amounts = $this->input->post('allowance_amount');
        $number_of_entries = sizeof($allowance_types);
        
        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($allowance_types[$i] != "" && $allowance_amounts[$i] != "") {
                $new_entry = array(
                    'type' => $allowance_types[$i],
                    'amount' => $allowance_amounts[$i]
                );
                array_push($allowances, $new_entry);
            }
        }
        $data['allowances'] = json_encode($allowances);
        
        $deductions        = array();
        $deduction_types   = $this->input->post('deduction_type');
        $deduction_amounts = $this->input->post('deduction_amount');
        $number_of_entries = sizeof($deduction_types);
        
        for ($i = 0; $i < $number_of_entries; $i++) {
            if ($deduction_types[$i] != "" && $deduction_amounts[$i] != "") {
                $new_entry = array(
                    'type' => $deduction_types[$i],
                    'amount' => $deduction_amounts[$i]
                );
                array_push($deductions, $new_entry);
            }
        }
        $data['deductions'] = json_encode($deductions);
        $data['date']       = $this->input->post('month') . ',' . $this->input->post('year');
        $data['status']     = $this->input->post('status');
        
        $this->db->insert('payroll', $data);
        
        $this->session->set_flashdata('message', get_phrase('data_created_successfully'));
        redirect(site_url('admin/payroll_list'), 'refresh');
    }
    
    function payroll_list($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'mark_paid') {
            $data['status'] = 1;
            
            $this->db->update('payroll', $data, array(
                'payroll_id' => $param2
            ));
            
            $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
            redirect(site_url('admin/payroll_list'), 'refresh');
        }
        
        /*16-06-2023*/

        if ($param1 == 'delete') {
            $payroll_id = $param2; // Assign the value of $param2 to $payroll_id
            //echo 'Payroll ID: ' . $payroll_id;exit; // Print the value of $payroll_id for testing
            $this->db->where('payroll_id', $param2);
            $this->db->delete('payroll');
            redirect(site_url('admin/payroll_list'), 'refresh');
        
        }

        /*16-06-2023*/
        
        $page_data['page_name']  = 'payroll_list';
        $page_data['page_title'] = get_phrase('payroll_list');
        $this->load->view('backend/index', $page_data);
    }
    
    // forntend management
    function frontend($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == '' || $param1 == 'home_page') {
            $page_data['inner_page']      = 'frontend_home_page';
            $page_data['sliders']         = $this->frontend_model->get_frontend_settings('slider');
            $page_data['welcome_content'] = $this->frontend_model->get_frontend_settings('homepage_welcome_section');
        }
        
        if ($param1 == 'about_us') {
            $page_data['inner_page'] = 'frontend_about_us';
        }
        
        if ($param1 == 'blog') {
            $page_data['inner_page'] = 'frontend_blog';
            $page_data['blogs']      = $this->frontend_model->get_blogs();
        }
        
        if ($param1 == 'blog_new') {
            $page_data['inner_page'] = 'frontend_blog_new';
        }
        
        if ($param1 == 'blog_edit') {
            $page_data['blog']       = $this->frontend_model->get_blog_details($param2);
            $page_data['inner_page'] = 'frontend_blog_edit';
        }
        
        if ($param1 == 'service') {
            $page_data['inner_page'] = 'frontend_service';
            $page_data['service']    = $this->frontend_model->get_frontend_settings('service_section');
            $page_data['services']   = $this->frontend_model->get_services();
        }
        
        if ($param1 == 'settings') {
            $page_data['inner_page'] = 'frontend_settings';
        }
        
        $page_data['page_name']  = 'frontend';
        $page_data['page_title'] = get_phrase('manage_hospital_website');
        $this->load->view('backend/index', $page_data);
    }
    
    // update frontend settings
    function frontend_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'slider') {
            $this->frontend_model->update_slider();
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(site_url('admin/frontend/home_page'), 'refresh');
        }
        
        if ($param1 == 'welcome_section') {
            $this->frontend_model->update_welcome_section_content();
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(site_url('admin/frontend/home_page'), 'refresh');
        }
        
        if ($param1 == 'service_section') {
            $this->frontend_model->update_service_section();
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(site_url('admin/frontend/service'), 'refresh');
        }
        
        if ($param1 == 'service_new') {
            $this->frontend_model->add_new_service();
            $this->session->set_flashdata('message', get_phrase('service_saved_successfully'));
            redirect(site_url('admin/frontend/service'), 'refresh');
        }
        
        if ($param1 == 'service_edit') {
            $this->frontend_model->update_service($param2);
            $this->session->set_flashdata('message', get_phrase('service_updated_successfully'));
            redirect(site_url('admin/frontend/service'), 'refresh');
        }
        
        if ($param1 == 'service_delete') {
            $this->frontend_model->delete_service($param2);
            $this->session->set_flashdata('message', get_phrase('service_deleted_successfully'));
            redirect(site_url('admin/frontend/service'), 'refresh');
        }
        
        if ($param1 == 'blog_new') {
            $this->frontend_model->add_new_blog();
            $this->session->set_flashdata('message', get_phrase('blogpost_saved_successfully'));
            redirect(site_url('admin/frontend/blog'), 'refresh');
        }
        
        if ($param1 == 'blog_edit') {
            $this->frontend_model->update_blog($param2);
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(site_url('admin/frontend/blog'), 'refresh');
        }
        
        if ($param1 == 'blog_delete') {
            $this->frontend_model->delete_blog($param2);
            $this->session->set_flashdata('message', get_phrase('blog_deleted'));
            redirect(site_url('admin/frontend/blog'), 'refresh');
        }
        
        if ($param1 == 'about_us') {
            $this->frontend_model->update_about_us();
            $this->session->set_flashdata('message', get_phrase('data_updated'));
            redirect(site_url('admin/frontend/about_us'), 'refresh');
        }
        
        if ($param1 == 'settings') {
            $this->frontend_model->update_frontend_settings();
            $this->session->set_flashdata('message', get_phrase('changes_saved_successfully'));
            redirect(site_url('admin/frontend/settings'), 'refresh');
        }
    }
    
    function contact_email($param1 = '', $param2 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'delete') {
            $this->db->where('contact_email_id', $param2);
            $this->db->delete('contact_email');
            $this->session->set_flashdata('message', get_phrase('email_deleted'));
            redirect(site_url('admin/contact_email'), 'refresh');
        }
        
        $page_data['page_name']      = 'contact_email';
        $page_data['page_title']     = get_phrase('contact_emails');
        $page_data['contact_emails'] = $this->frontend_model->get_contact_emails();
        $this->load->view('backend/index', $page_data);
    }
    
    function tpa_management($task = "", $tpa_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_tpa_management();
            $this->session->set_flashdata('message', get_phrase('tpa_management_saved_successfuly'));
            redirect(site_url('admin/tpa_management'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_tpa_management($tpa_id);
            $this->session->set_flashdata('message', get_phrase('tpa_management_updated_successfuly'));
            redirect(site_url('admin/tpa_management'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_tpa_management($tpa_id);
            redirect(site_url('admin/tpa_management'), 'refresh');
        }

        $data['tpa_management'] = $this->crud_model->select_tpa_management();
        $data['page_name']   = 'manage_tpa_management';
        $data['page_title']  = 'Referred Doctor';
        $this->load->view('backend/index', $data);
    }
     function bed($task = "", $bed_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            
              $bed_number = $this->input->post('bed_number');
        $type = $this->input->post('type');

        
        $this->db->where('bed_number', $bed_number);
        $this->db->where('type', $type);
        $duplicate_data = $this->db->get('bed')->row();

        if ($duplicate_data) {
            
            $this->session->set_flashdata('error_message', get_phrase('bed_number_and_type_combination_already_exists'));
            redirect(site_url('admin/bed'), 'refresh');
        }
        
        
            $this->crud_model->save_bed_info();
            $this->session->set_flashdata('message', get_phrase('bed_info_saved_successfuly'));
            redirect(site_url('admin/bed'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_bed_info($bed_id);
            $this->session->set_flashdata('message', get_phrase('bed_info_updated_successfuly'));
            redirect(site_url('admin/bed'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_bed_info($bed_id);
            redirect(site_url('admin/bed'), 'refresh');
        }
        
        $data['bed_info']   = $this->crud_model->select_bed_info();
        $data['page_name']  = 'manage_bed';
        $data['page_title'] = get_phrase('bed');
        $this->load->view('backend/index', $data);
    }
    function income_head($task = "", $income_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_income_head();
            $this->session->set_flashdata('message', get_phrase('income_head_saved_successfuly'));
            redirect(site_url('admin/income_head'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_income_head($income_id);
            $this->session->set_flashdata('message', get_phrase('income_head_updated_successfuly'));
            redirect(site_url('admin/income_head'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_income_head($income_id);
            redirect(site_url('admin/income_head'), 'refresh');
        }

        $data['income_head'] = $this->crud_model->select_income_head();
        $data['page_name']   = 'manage_income_head';
        $data['page_title']  = 'Income Head';
        $this->load->view('backend/index', $data);
    }

    function expense_head($task = "", $expense_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_expense_head();
            $this->session->set_flashdata('message', get_phrase('expense_head_saved_successfuly'));
            redirect(site_url('admin/expense_head'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_expense_head($expense_id);
            $this->session->set_flashdata('message', get_phrase('expense_head_updated_successfuly'));
            redirect(site_url('admin/expense_head'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_expense_head($expense_id);
            redirect(site_url('admin/expense_head'), 'refresh');
        }

        $data['expense_head'] = $this->crud_model->select_expense_head();
        $data['page_name']   = 'manage_expense_head';
        $data['page_title']  = 'Expense Head';
        $this->load->view('backend/index', $data);
        
    }

    function income($task = "" , $inc_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_income();
            $this->session->set_flashdata('message', get_phrase('income_saved_successfuly'));
            redirect(site_url('admin/income'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_income($inc_id);
            $this->session->set_flashdata('message', get_phrase('income_updated_successfuly'));
            redirect(site_url('admin/income'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_income($inc_id);
            redirect(site_url('admin/income'), 'refresh');
        }
       
        $data['income'] = $this->crud_model->select_income();
        $data['page_name']   = 'manage_income';
        $data['page_title']  = 'Income';
        $this->load->view('backend/index', $data);
    }

    function expense($task = "", $exp_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_expense();
            $this->session->set_flashdata('message', get_phrase('expense_saved_successfuly'));
            redirect(site_url('admin/expense'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_expense($exp_id);
            $this->session->set_flashdata('message', get_phrase('expense_updated_successfuly'));
            redirect(site_url('admin/expense'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_expense($exp_id);
            redirect(site_url('admin/expense'), 'refresh');
        }

        $data['expense'] = $this->crud_model->select_expense();
        $data['page_name']   = 'manage_expense';
        $data['page_title']  = 'Expense';
        $this->load->view('backend/index', $data);
        
    }
    
    // Manoj
    
    function item_category($task = "", $item_category_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_item_category_info();
            $this->session->set_flashdata('message', get_phrase('item_category_info_saved_successfuly'));
            redirect(site_url('admin/item_category'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_item_category_info($item_category_id);
            redirect(site_url('admin/item_category'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_item_category_info($item_category_id);
            redirect(site_url('admin/item_category'), 'refresh');
        }

        $data['item_category_info'] = $this->crud_model->select_item_category_info();
        $data['page_name']         = 'manage_item_category';
        $data['page_title']        = get_phrase('item_category');
        $this->load->view('backend/index', $data);
    }
    function item_store($task = "", $item_store_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_item_store_info();
            $this->session->set_flashdata('message', get_phrase('item_store_info_saved_successfuly'));
            redirect(site_url('admin/item_store'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_item_store_info($item_store_id);
            redirect(site_url('admin/item_store'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_item_store_info($item_store_id);
            redirect(site_url('admin/item_store'), 'refresh');
        }

        $data['item_store_info'] = $this->crud_model->select_item_store_info();
        $data['page_name']         = 'manage_item_store';
        $data['page_title']        = get_phrase('item_store');
        $this->load->view('backend/index', $data);
    }
    function item_supplier($task = "", $item_supplier_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_item_supplier_info();
            $this->session->set_flashdata('message', get_phrase('item_supplier_info_saved_successfuly'));
            redirect(site_url('admin/item_supplier'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_item_supplier_info($item_supplier_id);
            redirect(site_url('admin/item_supplier'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_item_supplier_info($item_supplier_id);
            redirect(site_url('admin/item_supplier'), 'refresh');
        }

        $data['item_supplier_info'] = $this->crud_model->select_item_supplier_info();
        $data['page_name']         = 'manage_item_supplier';
        $data['page_title']        = get_phrase('item_supplier');
        $this->load->view('backend/index', $data);
    }
    function item($task = "", $item_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_item_info();
            $this->session->set_flashdata('message', get_phrase('item_info_saved_successfuly'));
            redirect(site_url('admin/item'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_item_info($item_id);
            redirect(site_url('admin/item'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_item_info($item_id);
            redirect(site_url('admin/item'), 'refresh');
        }
 if($this->input->post()){
            $data['post_item_category'] = $this->input->post('item_category');
            $data['post_item_subcategory'] = $this->input->post('item_subcategory');
        }
        $data['item_subcategory'] = $this->crud_model->select_item_subcategory_info();
        $data['item_category'] = $this->crud_model->select_item_category_info();
        $data['item_info'] = $this->crud_model->select_item_info();
        $data['page_name']         = 'manage_item';
        $data['page_title']        = get_phrase('item');
        $this->load->view('backend/index', $data);
    }
    function item_stock($task = "", $item_stock_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_item_stock_info();
            $this->session->set_flashdata('message', get_phrase('item_stock_info_saved_successfuly'));
            redirect(site_url('admin/item_stock'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_item_stock_info($item_stock_id);
            redirect(site_url('admin/item_stock'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_item_stock_info($item_stock_id);
            redirect(site_url('admin/item_stock'), 'refresh');
        }

        $data['item_stock_info'] = $this->crud_model->select_item_stock_info();
        $data['page_name']         = 'manage_item_stock';
        $data['page_title']        = get_phrase('item_stock');
        $this->load->view('backend/index', $data);
    }
    function item_issue($task = "", $item_issue_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_item_issue_info();
            $this->session->set_flashdata('message', get_phrase('item_issue_info_saved_successfuly'));
            redirect(site_url('admin/item_issue'), 'refresh');
        }

        if ($task == "change_status") {
            $this->crud_model->update_item_issue_status($item_issue_id);
            redirect(site_url('admin/item_issue'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_item_issue_info($item_issue_id);
            redirect(site_url('admin/item_issue'), 'refresh');
        }

        $data['item_issue_info'] = $this->crud_model->select_item_issue_info();
        $data['page_name']         = 'manage_item_issue';
        $data['page_title']        = get_phrase('item_issue');
        $this->load->view('backend/index', $data);
    }
    function get_item_stock_with_ajax($item_id)
    {
        $this->db->select('item_stock.*, SUM(quantity) AS total_stock');
        $this->db->from('item_stock');
        $this->db->group_by('item_id');
        $this->db->where('item_id', $item_id);
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        $result1 = $query->row_array();

        $this->db->select('item_issue.*, SUM(quantity) AS total_issue');
        $this->db->from('item_issue');
        $this->db->group_by('item_id');
        $this->db->where('item_id', $item_id);
        $this->db->where('is_active', 'Y');
        $this->db->where('is_returned', 0);
        $query = $this->db->get();
        $result2 = $query->row_array();

        $this->db->select('patient_item_issue.*, SUM(quantity) AS total_patient_issue');
        $this->db->from('patient_item_issue');
        $this->db->group_by('item_id');
        $this->db->where('item_id', $item_id);
        $this->db->where('is_active', 'Y');
        $query = $this->db->get();
        $result3 = $query->row_array();

        $available_quantity = $result1['total_stock'] - $result2['total_issue'] - $result3['total_patient_issue'];
        $result1['available_quantity'] = $available_quantity;
        echo json_encode($result1);
    }
     function patient_item_issue_07_11_2023($task = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_patient_item_issue_info();
            $this->session->set_flashdata('message', get_phrase('data_added_successfully'));
            if ($this->input->post('issue_type') == 'challan') {
                redirect(site_url('admin/patient_item_issue/challan_list'), 'refresh');
            } else {
                redirect(site_url('admin/patient_item_issue/invoice_list'), 'refresh');
            }
        }
        if ($task == "convert_to_invoice") {
            $this->crud_model->convert_to_invoice();
            $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
            redirect(site_url('admin/patient_item_issue/invoice_list'), 'refresh');
        }
        if ($task == "invoice_list") {
            $data['list']  = 'invoice';
            $data['page_name']  = 'manage_patient_item_issue_i';
        } else if ($task == "challan_list") {
            $data['list']  = 'challan';
            $data['page_name']  = 'manage_patient_item_issue_c';
        }

        //$data['page_name']  = 'manage_patient_item_issue';
        $data['page_title'] = get_phrase('patient_item_issue');
        $this->load->view('backend/index', $data);
    }
    function create_patient_item_issue($task = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        $data['item_info'] = $this->crud_model->select_item_info();
        $data['page_name']  = 'add_patient_item_issue';
        $data['page_title'] = get_phrase('add_patient_item_issue');
        $this->load->view('backend/index', $data);
    }

    function item_report($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        $data['item_info'] = $this->crud_model->select_item_info();
        $data['page_name']  = 'show_item_report';
        $data['page_title'] = get_phrase('item_report');
        $this->load->view('backend/index', $data);
    }
    function item_stock_report($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($this->input->post()) {
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $item_stock_info = $this->crud_model->search_item_stock_info();
        } else {
            $item_stock_info = $this->crud_model->select_item_stock_info();
        }
        $data['date_from'] = $date_from;
        $data['date_to'] =  $date_to;
        $data['item_stock_info'] = $item_stock_info;

        $data['page_name']  = 'show_item_stock_report';
        $data['page_title'] = get_phrase('item_stock_report');
        $this->load->view('backend/index', $data);
    }
    function doctor_item_issue_report($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($this->input->post()) {
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $doctor_item_issue_info = $this->crud_model->search_item_issue_info();
        } else {
            $doctor_item_issue_info = $this->crud_model->select_item_issue_info();
        }
        $data['date_from'] = $date_from;
        $data['date_to'] =  $date_to;
        $data['doctor_item_issue_info'] = $doctor_item_issue_info;


        $data['page_name']  = 'show_doctor_item_issue_report';
        $data['page_title'] = get_phrase('doctor_item_issue_report');
        $this->load->view('backend/index', $data);
    }
   function patient_item_issue_report()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($this->input->post()) {
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $data['date_from'] = $date_from;
            $data['date_to'] =  $date_to;
            $data['patient_id'] =  $this->input->post('patient_id');
            $patient_item_issue_info = $this->crud_model->search_patient_item_issue_info();
        } else {
            $patient_item_issue_info = $this->crud_model->select_patient_item_issue_info();
        }

        $data['patient_item_issue_info'] = $patient_item_issue_info;
        $data['patient_info'] = $this->crud_model->select_patient_info();


        $data['page_name']  = 'show_patient_item_issue_report';
        $data['page_title'] = get_phrase('patient_item_issue_report');
        $this->load->view('backend/index', $data);
    }
    function patient_item_challan_report()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($this->input->post()) {
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $data['date_from'] = $date_from;
            $data['date_to'] =  $date_to;
            $data['patient_id'] =  $this->input->post('patient_id');
            $patient_item_challan_info = $this->crud_model->search_patient_item_challan_info();
        } else {
            $patient_item_challan_info = $this->crud_model->select_patient_item_challan_info();
        }

        $data['patient_item_challan_info'] = $patient_item_challan_info;
        $data['patient_info'] = $this->crud_model->select_patient_info();


        $data['page_name']  = 'show_patient_item_challan_report';
        $data['page_title'] = get_phrase('patient_item_challan_report');
        $this->load->view('backend/index', $data);
    }
     function get_model_available_quantity($item_id = '')
    {
        $this->db->select('item.*,item_category.item_category');
        $this->db->from('item');
        $this->db->join('item_category', 'item_category.id = item.item_category_id', 'left');
        $this->db->where('item.id', $item_id);
        $query = $this->db->get();
        $result = $query->row_array();
        echo json_encode($result);
    }
    
     function get_diag($item_id = '')
    {
        $this->db->select('diagnosis.*');
        $this->db->from('diagnosis');
       
        $this->db->where('diagnosis.id', $item_id);
        $query = $this->db->get();
        $result = $query->row_array();
        echo json_encode($result);
    }
    //Manoj end
function income_report()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
       
        if($this->input->post()){
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $income = $this->crud_model->search_income();                                                      
        }else{
            $income = $this->crud_model->select_income();            
        }

        $data['date_from'] = $date_from;
        $data['date_to'] =  $date_to;
        $data['income'] = $income;
        $data['page_name']   = 'manage_income_report';
        $data['page_title']  = 'Income Report';
        $this->load->view('backend/index', $data);
    }

    function income_group_report()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if($this->input->post()){
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $income  = $this->crud_model->search_income();                                                 
        }else{            
            $income = $this->crud_model->select_income();
        }
        
        $data['date_from'] = $date_from;
        $data['date_to'] =  $date_to;
        $data['income'] = $income;
        $data['page_name']   = 'manage_income_group_report';
        $data['page_title']  = 'Income Group Report';
        $this->load->view('backend/index', $data);
    }

    function expense_report()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if($this->input->post()){
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $expense  = $this->crud_model->search_expense();                                       
        }else{
            $expense = $this->crud_model->select_expense();           
        }

        $data['date_from'] = $date_from;
        $data['date_to'] =  $date_to;
        $data['expense'] = $expense;
        $data['page_name']   = 'manage_expense_report';
        $data['page_title']  = 'Expense Report';
        $this->load->view('backend/index', $data);
    }

    function expense_group_report()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if($this->input->post()){
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $expense  = $this->crud_model->search_expense();                                       
        }else{
            $expense = $this->crud_model->select_expense();           
        }

        $data['date_from'] = $date_from;
        $data['date_to'] =  $date_to;
        $data['expense'] = $expense;
        $data['page_name']   = 'manage_expense_group_report';
        $data['page_title']  = 'Expense Group Report';
        $this->load->view('backend/index', $data);
    }
 function medicine_category($task = "", $medicine_category_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_medicine_category_info();
            $this->session->set_flashdata('message', get_phrase('medicine_category_info_saved_successfuly'));
            redirect(site_url('admin/medicine_category'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_medicine_category_info($medicine_category_id);
            $this->session->set_flashdata('message', get_phrase('medicine_category_info_updated_successfuly'));
            redirect(site_url('admin/medicine_category'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_medicine_category_info($medicine_category_id);
            redirect(site_url('admin/medicine_category'), 'refresh');
        }
        
        $data['medicine_category_info'] = $this->crud_model->select_medicine_category_info();
        $data['page_name']              = 'manage_medicine_category';
        $data['page_title']             = get_phrase('medicine_category');
        $this->load->view('backend/index', $data);
    }
    
    function medicine($task = "", $medicine_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_medicine_info();
            $this->session->set_flashdata('message', get_phrase('medicine_info_saved_successfuly'));
            redirect(site_url('admin/medicine'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_medicine_info($medicine_id);
            $this->session->set_flashdata('message', get_phrase('medicine_info_updated_successfuly'));
            redirect(site_url('admin/medicine'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_medicine_info($medicine_id);
            redirect(site_url('admin/medicine'), 'refresh');
        }
        
        $data['medicine_info'] = $this->crud_model->select_medicine_info();
        $data['page_name']     = 'manage_medicine';
        $data['page_title']    = get_phrase('medicine');
        $this->load->view('backend/index', $data);
    }
     function medicine_sale($task = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->create_medicine_sale();
            $this->session->set_flashdata('message', get_phrase('data_added_successfully'));
            redirect(site_url('admin/medicine_sale'), 'refresh');
        }
        
        $data['page_name']  = 'medicine_sale';
        $data['page_title'] = get_phrase('medicine_sales');
        $this->load->view('backend/index', $data);
    }
    
    function create_medicine_sale($task = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $data['page_name']  = 'medicine_sale_add';
        $data['page_title'] = get_phrase('add_medicine_sale');
        $this->load->view('backend/index', $data);
    }
    
    function get_available_quantity($medicine_id = '')
    {
        $medicine           = $this->db->get_where('medicine', array(
            'medicine_id' => $medicine_id
        ))->row();
        $available_quantity = $medicine->total_quantity - $medicine->sold_quantity;
        echo $available_quantity;
    }
    
    function get_medicine_price($medicine_id = '')
    {
        echo $this->db->get_where('medicine', array(
            'medicine_id' => $medicine_id
        ))->row()->price;
    }
 function invoice_add($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->create_invoice();
            $this->session->set_flashdata('message', get_phrase('invoice_info_saved_successfuly'));
            redirect(site_url('admin/invoice_manage'), 'refresh');
        }
        
        $data['page_name']  = 'add_invoice';
        $data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $data);
    }
    
    function invoice_manage($task = "", $invoice_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_invoice($invoice_id);
            $this->session->set_flashdata('message', get_phrase('invoice_info_updated_successfuly'));
            redirect(site_url('admin/invoice_manage'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_invoice($invoice_id);
            redirect(site_url('admin/invoice_manage'), 'refresh');
        }
        
        $data['invoice_info'] = $this->crud_model->select_invoice_info();
        $data['page_name']    = 'manage_invoice';
        $data['page_title']   = get_phrase('invoice');
        $this->load->view('backend/index', $data);
    }
    function prescription($task = "", $prescription_id = "", $menu_check = '', $patient_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_prescription_info();
            $this->session->set_flashdata('message', get_phrase('prescription_info_saved_successfuly'));
            redirect(site_url('admin/prescription'), 'refresh');
        }
        
        if ($task == "update") {
            $this->crud_model->update_prescription_info($prescription_id);
            $this->session->set_flashdata('message', get_phrase('prescription_info_updated_successfuly'));
            if ($menu_check == 'from_prescription')
                redirect(site_url('admin/prescription'), 'refresh');
            else
                redirect(site_url('admin/medication_history/' . $patient_id), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_prescription_info($prescription_id);
            if ($menu_check == 'from_prescription')
                redirect(site_url('admin/prescription'), 'refresh');
            else
                redirect(site_url('admin/medication_history/' . $patient_id), 'refresh');
        }
        
        $data['prescription_info'] = $this->crud_model->select_prescription_info();
        $data['menu_check']        = 'from_prescription';
        $data['page_name']         = 'manage_prescription';
        $data['page_title']        = get_phrase('prescription');
        $this->load->view('backend/index', $data);
    }
    
   //  function patient_history_details($task = "", $prescription_id = "", $menu_check = '', $patient_id = '')
   function patient_history_details($task = "", $prescription_id = "", $menu_check = '', $patient_id = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_prescription_info();
            $this->session->set_flashdata('message', get_phrase('prescription_info_saved_successfuly'));
            redirect(site_url('admin/patient_history_details'), 'refresh');
        }
        
      /*  if ($task == "update") {
            $this->crud_model->update_prescription_info($prescription_id);
            $this->session->set_flashdata('message', get_phrase('prescription_info_updated_successfuly'));
            if ($menu_check == 'from_prescription')
                redirect(site_url('admin/patient_history_details'), 'refresh');
            else
                redirect(site_url('admin/medication_history/' . $patient_id), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_prescription_info($prescription_id);
            if ($menu_check == 'from_prescription')
                redirect(site_url('admin/patient_history_details'), 'refresh');
            else
                redirect(site_url('admin/medication_history/' . $patient_id), 'refresh');
        }*/
         $patient_ids = $this->input->get('id');
    $data['prescription_info_self'] = $this->crud_model->self_prescription_info($patient_ids);
        $data['menu_check']        = 'from_prescription';
        $data['page_name']         = 'patient_history_details';
        $data['page_title']        = 'All Visit List';
         $data['patient_ids'] = $patient_ids;
        $this->load->view('backend/index', $data);
    }
    function diagnosis_report($task = "", $diagnosis_report_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($task == "create") {
            $this->crud_model->save_diagnosis_report_info();
            $this->session->set_flashdata('message', get_phrase('diagnosis_report_info_saved_successfuly'));
            redirect(site_url('admin/prescription'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_diagnosis_report_info($diagnosis_report_id);
            $this->session->set_flashdata('message', get_phrase('diagnosis_report_info_deleted_successfuly'));
            redirect(site_url('admin/prescription'), 'refresh');
        }
    }
    // Manoj
    function pathology_test_category($task = "", $pathology_test_category_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_pathology_test_category_info();
            $this->session->set_flashdata('message', get_phrase('pathology_test_category_info_saved_successfuly'));
            redirect(site_url('admin/pathology_test_category'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_pathology_test_category_info($pathology_test_category_id);
            redirect(site_url('admin/pathology_test_category'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_pathology_test_category_info($pathology_test_category_id);
            redirect(site_url('admin/pathology_test_category'), 'refresh');
        }

        $data['pathology_test_category_info'] = $this->crud_model->select_pathology_test_category_info();
        $data['page_name']         = 'manage_pathology_test_category';
        $data['page_title']        = get_phrase('pathology_test_category');
        $this->load->view('backend/index', $data);
    }
    function pathology_test($task = "", $pathology_test_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_pathology_test_info();
            $this->session->set_flashdata('message', get_phrase('pathology_test_info_saved_successfuly'));
            redirect(site_url('admin/pathology_test'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_pathology_test_info($pathology_test_id);
            redirect(site_url('admin/pathology_test'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_pathology_test_info($pathology_test_id);
            redirect(site_url('admin/pathology_test'), 'refresh');
        }

        $data['pathology_test_info'] = $this->crud_model->select_pathology_test_info();
        $data['page_name']         = 'manage_pathology_test';
        $data['page_title']        = get_phrase('pathology_test');
        $this->load->view('backend/index', $data);
    }
    function pathology_patient_report($task = "", $pathology_patient_report_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_pathology_patient_report_info();
            $this->session->set_flashdata('message', get_phrase('pathology_patient_report_info_saved_successfuly'));
            redirect(site_url('admin/pathology_patient_report'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_pathology_patient_report_info($pathology_patient_report_id);
            redirect(site_url('admin/pathology_patient_report'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_pathology_patient_report_info($pathology_patient_report_id);
            redirect(site_url('admin/pathology_patient_report'), 'refresh');
        }

        $data['pathology_patient_report_info'] = $this->crud_model->select_pathology_patient_report_info();
        $data['page_name']         = 'manage_pathology_patient_report';
        $data['page_title']        = get_phrase('pathology_patient_report');
        $this->load->view('backend/index', $data);
    }
    function get_charge_with_ajax($test_id)
    {
        $this->db->select('pathology_test.*');
        $this->db->from('pathology_test');
        $this->db->where('id', $test_id);
        $query = $this->db->get();
        $result = $query->row_array();
        echo json_encode($result);
    }
    function pathology_patient_report_search($task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($this->input->post()) {
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $pathology_patient_report_info = $this->crud_model->search_pathology_patient_report_info();
        } else {
            $pathology_patient_report_info = $this->crud_model->select_pathology_patient_report_info();
        }
        $data['date_from'] = $date_from;
        $data['date_to'] =  $date_to;
        $data['pathology_patient_report_info'] = $pathology_patient_report_info;

        $data['page_name']  = 'show_pathology_patient_report';
        $data['page_title'] = get_phrase('pathology_patient_report');
        $this->load->view('backend/index', $data);
    }
    function getReport($id)
    {
        $this->db->select('pathology_patient_report.*, pathology_test.test_name,pathology_test.short_name,patient.name as patient_name,doctor.name as doctor_name,patient.sex,patient.age,blood_bank.blood_group,patient.code');
        $this->db->from('pathology_patient_report');
        $this->db->join('pathology_test', 'pathology_test.id = pathology_patient_report.pathology_test_id', 'left');
        $this->db->join('patient', 'patient.patient_id = pathology_patient_report.patient_id', 'left');
         $this->db->join('blood_bank', 'blood_bank.blood_group_id  = patient.blood_group', 'left');
        $this->db->join('doctor', 'doctor.doctor_id = pathology_patient_report.doctor_id', 'left');
        $this->db->where('pathology_patient_report.id', $id);
        $data['row'] = $this->db->get()->row_array();

        $this->load->view("backend/admin/view_pathology_report", $data);
    }
    // Manoj End
         function follow_up($task = "", $follow_up_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        if ($task == "update") {
            $this->crud_model->update_followup_info($follow_up_id);
            redirect(site_url('admin/follow_up'), 'refresh');
        }
        $data['page_name']         = 'follow_up';
        $data['page_title']        = get_phrase('follow_up');
        $this->load->view('backend/index', $data);
    }
         function upcoming_followup()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        $data['page_name']         = 'upcoming_followup';
        $data['page_title']        = get_phrase('upcoming_followup');
        $this->load->view('backend/index', $data);
    }
    
    function medicine_alert_report()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
         $data['medicine_info'] = $this->crud_model->alert_medicine_info();
        $data['page_name']  = 'show_medicine_alert_report';
        $data['page_title'] = 'Medicine Alert Report';
        $this->load->view('backend/index', $data);
    }
    
    function unit_master($task = "" ,$unit_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_unit();
            $this->session->set_flashdata('message', get_phrase('unit_saved_successfuly'));
            redirect(site_url('admin/unit_master'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_unit($unit_id);
            $this->session->set_flashdata('message', get_phrase('unit_updated_successfuly'));
            redirect(site_url('admin/unit_master'), 'refresh');
        }
        
        if ($task == "delete") {
            $this->crud_model->delete_unit($unit_id);
            redirect(site_url('admin/unit_master'), 'refresh');
        }
        
        $data['unit'] = $this->crud_model->select_unit();
        $data['page_name']    = 'show_unit_master';
        $data['page_title']   = 'Unit';
        $this->load->view('backend/index', $data); 
    }
    
   function item_subcategory($task = "" , $item_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_item_subcategory_info();
            $this->session->set_flashdata('message', get_phrase('item_subcategory_info_saved_successfuly'));
            redirect(site_url('admin/item_subcategory'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_item_subcategory_info($item_id);
            redirect(site_url('admin/item_subcategory'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_item_subcategory_info($item_id);
            redirect(site_url('admin/item_subcategory'), 'refresh');
        }

        $data['item_subcategory_info'] = $this->crud_model->select_item_subcategory_info();
        $data['page_name']         = 'manage_item_subcategory';
        $data['page_title']        = get_phrase('item_subcategory');
        $this->load->view('backend/index', $data);
    }
  function manage_consultation($param1 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'update_consultation_charge') {
            $data['name']  = $this->input->post('name');
            $data['qty'] = $this->input->post('qty');
           $data['price'] = $this->input->post('price');
           $data['discount_type'] = $this->input->post('discount_type');
           $data['discount_price'] = $this->input->post('discount_price');

           
                $returned_array = null_checking($data);
                $this->db->where('id ', 1);
                $this->db->update('consultation_charge', $returned_array);
                $this->session->set_flashdata('message', get_phrase('updated_successfuly'));
                redirect(site_url('admin/manage_consultation'), 'refresh');
           
            
        }
     
        $page_data['page_name']  = 'manage_consultation';
        $page_data['page_title'] = get_phrase('consultation fee');


        $this->load->view('backend/index', $page_data);
    }
    
    function diagnosis($task = "" , $diagnosis_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_diagnosis_info();
            $this->session->set_flashdata('message', get_phrase('diagnosis_info_saved_successfuly'));
            redirect(site_url('admin/diagnosis'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_diagnosis_info($diagnosis_id);
            redirect(site_url('admin/diagnosis'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_diagnosis_info($diagnosis_id);
            redirect(site_url('admin/diagnosis'), 'refresh');
        }

        $data['diagnosis_info'] = $this->crud_model->select_diagnosis_info();
        $data['page_name']         = 'manage_diagnosis';
        $data['page_title']        = get_phrase('diagnosis');
        $this->load->view('backend/index', $data);
    }
    
    function warranty($task = "" , $warranty_id = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
            $this->crud_model->save_warranty_info();
            $this->session->set_flashdata('message', get_phrase('warranty_info_saved_successfuly'));
            redirect(site_url('admin/warranty'), 'refresh');
        }

        if ($task == "update") {
            $this->crud_model->update_warranty_info($warranty_id);
            redirect(site_url('admin/warranty'), 'refresh');
        }

        if ($task == "delete") {
            $this->crud_model->delete_warranty_info($warranty_id);
            redirect(site_url('admin/warranty'), 'refresh');
        }

        $data['warranty_info'] = $this->crud_model->select_warranty_info();
        $data['page_name']         = 'manage_warranty';
        $data['page_title']        = get_phrase('warranty');
        $this->load->view('backend/index', $data);
    }
    
    function get_sub_category_with_ajax($category_id)
    {
        $this->db->select('item_subcategory.*');
        $this->db->from('item_subcategory');
        $this->db->where('item_category', $category_id);
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
    }
     function patient_visit_history($patient_id = "",$param2 = "",$param3 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
    /*if ($task == "delete") {
        $this->crud_model->delete_patient_diagnosis($diag_id);
        $this->session->set_flashdata('message', get_phrase('diagnosis_report_info_deleted_successfuly'));
        redirect(site_url('admin/patient_visit_history/' . $patient_id), 'refresh');
    }*/
        
        $patient_info = $this->crud_model->patient_visit_history($patient_id);
       $data['patient_id'] =  $patient_id;
        $data['patient_info'] = $patient_info;
       // $data['list']  = 'invoice';
        $data['page_name']    = 'patient_visit_history';
        $data['page_title']   = get_phrase('patient_history');
        $this->load->view('backend/index', $data);
    }
    
     function patient_diagnosis_add($patient_id = "" )
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
 
        $patient_info = $this->crud_model->patient_visit_history($patient_id);
       $data['patient_id'] =  $patient_id;
        $data['patient_info'] = $patient_info;
         $data['diag_info'] = $this->crud_model->select_diag_info();
       // $data['list']  = 'invoice';
        $data['page_name']    = 'patient_diagnosis_add';
        $data['page_title']   = get_phrase('patient_diagnosis_add');
        $this->load->view('backend/index', $data);
    }
//      function patient_diagnosis_insert($task="" )
//     {
//         if ($this->session->userdata('admin_login') != 1) {
//             $this->session->set_userdata('last_page', current_url());
//             redirect(site_url(), 'refresh');
//         }
//  if ($task == "create") {
//             $this->crud_model->save_patient_diagnosis_info();
//             $this->session->set_flashdata('message', get_phrase('data_added_successfully'));
//                 redirect(site_url('admin/patient'), 'refresh');
//         }
//     }
    
//saumya
function delete_diag($patient_id="",$diag_id="")
{
    
    $this->crud_model->delete_patient_diagnosis($diag_id);
    $this->session->set_flashdata('message', get_phrase('diagnosis_report_info_deleted_successfuly'));
    redirect(site_url('admin/patient_visit_history/' . $patient_id), 'refresh');
}
function delete_pres($patient_id="",$pres_id="")
{
    
    $this->crud_model->delete_patient_consultation_history_info($pres_id);
    $this->session->set_flashdata('message', get_phrase('Patient_visit_info_deleted_successfuly'));
    redirect(site_url('admin/patient_visit_history/' . $patient_id), 'refresh');
}
function pres_upload($patient_id="",$pres_id="")
{
    
   $this->crud_model->save_patient_pres_document();
            $this->session->set_flashdata('message', get_phrase('prescription_uploaded_successfully'));
           
    redirect(site_url('admin/patient_visit_history/' . $patient_id), 'refresh');
}
function diag_upload($patient_id="",$diag_id="")
{
    
   $this->crud_model->save_patient_diag_document();
            $this->session->set_flashdata('message', get_phrase('diagnosis_uploaded_successfully'));
           
    redirect(site_url('admin/patient_visit_history/' . $patient_id), 'refresh');
}

  function patient_checkup_history($patient_id = "",$task = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        if ($task == "upload") {
            $this->crud_model->save_patient_document();
            $this->session->set_flashdata('message', get_phrase('patient_info_saved_successfuly'));
            redirect(site_url('admin/patient_checkup_history/'.$patient_id), 'refresh');
        }

        if($this->input->post()){
            $date_from = date('Y-m-d', strtotime($this->input->post('date_from')));
            $date_to = date('Y-m-d', strtotime($this->input->post('date_to')));
            $patient_info  = $this->crud_model->patient_checkup_info($patient_id);                                                 
        }else{            
            $patient_info = $this->crud_model->patient_checkup_info($patient_id);
        }
        
        $data['date_from'] = $date_from;
        $data['date_to'] =  $date_to;
        $data['patient_id'] =  $patient_id;
        $data['patient_info'] = $patient_info;
        $data['page_name']    = 'patient_checkup_history';
        $data['page_title']   = get_phrase('patient_history');
        $this->load->view('backend/index', $data);
    }
    
       function patient_create()
    {
       
        $insertedId = $this->crud_model->save_patient_info($_POST); 
        echo json_encode(array('status' => 'success','inserted_id' => $insertedId, 'message'=> get_phrase('patient_info_saved_successfuly')));
    }
    function prescription_load()
    {
        $data['insertedId'] = $this->input->get('inserted_id');
        $this->load->view('backend/admin/print_prescription', $data);
      }
      
function consultation_fee_load()
{
    $data['insertedId'] = $this->input->get('inserted_id');
    $this->load->view('backend/admin/print_consultation_fee_automatically', $data);
}
      
            function item_categorywise_subcategory() {
        $item_category_id = $this->input->post('item_category_id');
        $this->db->select('item_subcategory.*');
        $this->db->from('item_subcategory');
        $this->db->where('item_category', $item_category_id);
        $query = $this->db->get();
        $result = $query->result_array();
        
        $select = '<option value="">Select Subcategory</option>';
        foreach ($result as $row) {
          $select .= '<option value="' . $row['item_id'] . '">' . $row['item_subcategory'] . '</option>';
        }
        
        $data['arr'] = $select;
        echo json_encode($data);
      }
      
           function patient_item_history($patient_id = "")
      {
          if ($this->session->userdata('admin_login') != 1) {
              $this->session->set_userdata('last_page', current_url());
              redirect(site_url(), 'refresh');
          }
      $patient_name=$this->db->get_where('patient', array('patient_id' => $patient_id))->row()->name;
          $data['patient_id'] =  $patient_id; 
          $data['page_name']    = 'patient_item_history';
          $data['page_title']   = get_phrase($patient_name." Item History");
          $this->load->view('backend/index', $data);
      } 
 function purchase_entry($task = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        if ($task == "create") {
             $this->crud_model->save_purchase_entry_info();
             $this->session->set_flashdata('message', get_phrase('data_added_successfully'));
            redirect(site_url('admin/purchase_entry'), 'refresh');
        }
        if ($task == "update") {
            $this->crud_model->update_purchase_entry_info($param2);
            $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
           redirect(site_url('admin/purchase_entry'), 'refresh');
       }
   
    
        $data['page_name']  = 'manage_purchase_entry';
        $data['page_title'] = get_phrase('purchase_entry');
        $this->load->view('backend/index', $data);
    }
    function view_purchase_entry_items($task = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
           $data['purchase_items'] = $this->crud_model->select_purchase_entry_items_info($param2);
             $data['page_name']  = 'view_purchase_entry_items';
             $data['page_title'] = get_phrase('purchase_entry_items'). " Of  " .$data['purchase_items']["invoice_no"];
            $this->load->view('backend/index', $data);
    }
    function edit_purchase_entry($task = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        $data['item_info'] = $this->crud_model->select_item_info();
        $data['purchase_items'] = $this->crud_model->select_purchase_entry_items_info($param2);
        $data['page_name']  = 'edit_purchase_entry';
        $data['page_title'] = get_phrase('edit_purchase_entry'). " Of  " .$data['purchase_items']["invoice_no"];
        $this->load->view('backend/index', $data);
    }


    function create_purchase_entry($task = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        $data['item_info'] = $this->crud_model->select_item_info();
        $data['page_name']  = 'add_purchase_entry';
        $data['page_title'] = get_phrase('add_purchase_entry');
        $this->load->view('backend/index', $data);
    }
    function get_supplier_details($id = '')
    {
        $this->db->select('item_supplier.*');
        $this->db->from('item_supplier');
        $this->db->where('item_supplier.id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        echo json_encode($result);
    }  
    
        function get_diagnosis_details($id = '')
    {
        $this->db->select('diagnosis.*');
        $this->db->from('diagnosis');
        $this->db->where('diagnosis.id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        echo json_encode($result);
    }
    function update_patient_diagnosis_details($patient_diagnosis_id = '',$patient_id='')
    {
            if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        $data['diagnosis_id']         = $this->input->post('diagnosis_id');
        $returned_array = null_checking($data);
        $this->db->where('id', $patient_diagnosis_id);
        $this->db->update('patient_diagnosis',$returned_array);
         $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
        redirect(site_url('admin/patient_visit_history/'.$patient_id), 'refresh');

    }
     function update_patient_diagnosis_date($patient_diagnosis_id = '',$patient_id='')
    {
            if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
         $input_date = $this->input->post('creation_timestamp');
$date_obj = DateTime::createFromFormat('m/d/Y', $input_date);
$formatted_date = $date_obj->format('d-m-Y');
$data['date'] = $formatted_date;

       
        $returned_array = null_checking($data);
        $this->db->where('id', $patient_diagnosis_id);
        $this->db->update('patient_diagnosis',$returned_array);
         $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
        redirect(site_url('admin/patient_visit_history/'.$patient_id), 'refresh');

    }
    function edit_pres($task = "" ,$patient_id="", $pres_id="")
{
    if ($task == "update") {
    $this->crud_model->edit_patient_consultation_history_info($pres_id);
    $this->session->set_flashdata('message', get_phrase('Patient_visit_info_updated_successfuly'));
    redirect(site_url('admin/patient_visit_history/' . $patient_id), 'refresh');
    }
}

function today_visit()
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }

        $data['patient_consultation_history_info'] = $this->crud_model->select_patient_consultation_history_info();
        $data['page_name']         = 'manage_today_visit';
        $data['page_title']        = get_phrase('today_visit');
        $this->load->view('backend/index', $data);
    }
    function delete_pres_upload($patient_id="",$pres_id="")
{
    
    $this->crud_model->delete_prescription_upload($pres_id);
    $this->session->set_flashdata('message', get_phrase('prescription_deleted_successfuly'));
    redirect(site_url('admin/patient_visit_history/' . $patient_id), 'refresh');
}
function delete_diag_upload($patient_id="",$diag_id="")
{
    
    $this->crud_model->delete_diag_upload($pres_id);
    $this->session->set_flashdata('message', get_phrase('diagnosis_deleted_successfuly'));
    redirect(site_url('admin/patient_visit_history/' . $patient_id), 'refresh');
}
public function upload_image() {
        $filename =  time() . '.jpg';
        $filepath = 'saved_images/'; // Adjust the path according to your setup
        move_uploaded_file($_FILES['webcam']['tmp_name'], $filepath.$filename);
        echo $filepath.$filename;
    }
        public function search_referal_doctor() {
        $term = $this->input->get('term'); // Get search term from the client-side

        $results = $this->crud_model->searchProducts($term);

       echo json_encode($results);
       //echo json_encode($term);
    }
    function bank_details($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        if ($param1 == 'do_update') {
            $this->crud_model->update_bank_details();
            $this->session->set_flashdata('message', get_phrase('bankdetails_updated'));
            redirect(site_url('admin/bank_details'), 'refresh');
        }
        
        $page_data['page_name']  = 'bank_details';
        $page_data['page_title'] = get_phrase('bank_details');
        $page_data['bank_details']   = $this->db->get('bank_details')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    function doctor_history($task = "", $patient_id = "",$param2 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
        $data['doctor_history'] = $this->crud_model->select_doctor_history();
        $data['page_name']    = 'manage_doctor_history';
        $data['page_title']   = get_phrase('doctor_history');
        $this->load->view('backend/index', $data);
    }
     function doctor_visit_history()
{
    $referred_by = $this->input->get('referred_by'); // Get the "referred_by" value from the query parameter

    if ($this->session->userdata('admin_login') != 1) {
        $this->session->set_userdata('last_page', current_url());
        redirect(site_url(), 'refresh');
    }   

    $doctor_info = $this->crud_model->doctor_visit_history($referred_by);        
    $data['referred_by'] = $referred_by;
    $data['doctor_info'] = $doctor_info;
    $data['page_name']    = 'doctor_visit_history';
    $data['page_title']   = get_phrase('patients referred by <b>'.$referred_by.'</b>');
    $this->load->view('backend/index', $data);
}
function patient_diagnosis_insert($task="" )
{
    if ($this->session->userdata('admin_login') != 1) {
        $this->session->set_userdata('last_page', current_url());
        redirect(site_url(), 'refresh');
    }
if ($task == "create") {
        // $this->crud_model->save_patient_diagnosis_info();
        // $this->session->set_flashdata('message', get_phrase('data_added_successfully'));
        //     redirect(site_url('admin/patient'), 'refresh');

        $insertedId = $this->crud_model->save_patient_diagnosis_info($_POST); 
        echo json_encode(array('status' => 'success','inserted_id' => $insertedId, 'message'=> get_phrase('data_added_successfully')));
    }
}
function diagnosis_load()
{
    $data['insertedId'] = $this->input->get('inserted_id');
    $this->load->view('backend/admin/print_diagnosis', $data);
  }
  
public function send_patient_data_email()
{
    // Load the TCPDF library
    require_once(APPPATH . 'third_party/TCPDF-main/tcpdf.php');

    // Retrieve patient data from the model
    $today_patient_data = $this->crud_model->get_today_patient_data();

    // Create a new TCPDF object
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle("");
    $pdf->SetHeaderData('', 0, "Today's Patient Data", '');

    // Add a page
    $pdf->AddPage();

    // Define the HTML content
    $html = '<h2></h2>';
    $html .= '<table border="1">';
    $html .= '<tr style="background-color: #BBBBBB;"><th>Patient Id</th><th>Name</th><th>Phone</th><th>Sex</th><th>Age</th><th>Diagnosis Amount</th> <th>Item Issue Amount</th><th>Visit Type</th></tr>';

    foreach ($today_patient_data as $patient) {
       
            $todaypatientitemissueprice=0;
      
        $today_diagnosis_data = $this->crud_model->get_today_diagnosis_data($patient['patientid']);
        $today_patientitemissue_data = $this->crud_model->get_today_patientitemissue_data($patient['patientid']);
        if($today_patientitemissue_data !=''){
        foreach ($today_patientitemissue_data as $patientitemissue) {
            $dbDate = strtotime($patientitemissue["invoice_date"]);
            $todayDate = strtotime(date('d-m-Y'));
            
            if (!is_null($dbDate) && date('d-m-Y', $dbDate) == date('d-m-Y')) {
                $todaypatientitemissueprice = $patientitemissue["grand_total"];
            } else if (strtotime($patientitemissue["challan_date"]) == $todayDate) {
                $todaypatientitemissueprice = $patientitemissue["grand_total"];
            }
        }

    }

        $html .= '<tr>';
        $html .= '<td>' . $patient['patient_code'] . '</td>';
        $html .= '<td>' . $patient['patient_name'] . '</td>';
        $html .= '<td>' . $patient['patient_phone'] . '</td>';
        $html .= '<td>' . $patient['patient_sex'] . '</td>';
        $html .= '<td>' . $patient['patient_age'] . '</td>';
       
        $html .= '<td>' . $today_diagnosis_data . '</td>';
        $html .= '<td>' . $todaypatientitemissueprice . '</td>';
        $html .= '<td>' . $patient['patient_visittype'] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    // Output the HTML content as a PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Save the PDF to a temporary file
    $pdfFilePath = FCPATH . 'patient_email/file.pdf';
    $pdf->Output($pdfFilePath, 'F');

    $subject = 'Today\'s Patient Details';
    $message = 'Please go through the below attached file';
    $to = 'saumya.rout@3sdsolutions.com'; // Replace with the admin's email address
    $from = 'orangewheels123@gmail.com'; // Replace with your email address

    // Send the email using the Email_model
    $this->phpmailer_lib->load($message, $subject, $to, $from,$pdfFilePath);

    // Display a success message or perform other actions as needed
    echo json_encode('Email sent successfully');
    // echo 'Email sent successfully';
}
function create_money_receipt($task = "", $param2 = "")
{
    if ($this->session->userdata('admin_login') != 1) {
        $this->session->set_userdata('last_page', current_url());
        redirect(site_url(), 'refresh');
    }
    $data['item_info'] = $this->crud_model->select_item_info();
    $data['page_name']  = 'add_money_receipt';
    $data['page_title'] = get_phrase('add_money_receipt');
    $this->load->view('backend/index', $data);
}

function patient_item_issue($task = "", $param2 = "")
{
    if ($this->session->userdata('admin_login') != 1) {
        $this->session->set_userdata('last_page', current_url());
        redirect(site_url(), 'refresh');
    }

    if ($task == "create") {
        $this->crud_model->save_patient_item_issue_info();
        $this->session->set_flashdata('message', get_phrase('data_added_successfully'));
        if ($this->input->post('issue_type') == 'challan') {
            redirect(site_url('admin/patient_item_issue/challan_list'), 'refresh');
        } else if ($this->input->post('issue_type') == 'invoice')  {
            redirect(site_url('admin/patient_item_issue/invoice_list'), 'refresh');
        }else {
            redirect(site_url('admin/patient_item_issue/money_receipt_list'), 'refresh');
        }
    }

    if ($task == "update") {
        $this->crud_model->update_patient_item_issue_info();
        $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
        if ($this->input->post('issue_type') == 'challan') {
            redirect(site_url('admin/patient_item_issue/challan_list'), 'refresh');
        } else {
            redirect(site_url('admin/patient_item_issue/invoice_list'), 'refresh');
        }
    }

    if ($task == "mainupdate") {
        $this->crud_model->update_main_patient_item_issue_info();
        $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
        if ($this->input->post('issue_type') == 'challan') {
            redirect(site_url('admin/patient_item_issue/challan_list'), 'refresh');
        } else if ($this->input->post('issue_type') == 'invoice')  {
            redirect(site_url('admin/patient_item_issue/invoice_list'), 'refresh');
        }else {
            redirect(site_url('admin/patient_item_issue/money_receipt_list'), 'refresh');
        }
    }


    if ($task == "convert_to_invoice") {
        $this->crud_model->convert_to_invoice();
        $this->session->set_flashdata('message', get_phrase('data_updated_successfully'));
        redirect(site_url('admin/patient_item_issue/invoice_list'), 'refresh');
    }
    if ($task == "invoice_list") {
        $data['page_title'] = get_phrase('patient_item_issue');
        $data['list']  = 'invoice';
        $data['page_name']  = 'manage_patient_item_issue_i';
        
         } else if ($task == "follow_up") {
        $data['page_title'] = get_phrase('follow_up');
        $data['page_name']  = 'manage_followup';
   
    
    } else if ($task == "challan_list") {
        $data['page_title'] = get_phrase('patient_item_issue');
        $data['list']  = 'challan';
        $data['page_name']  = 'manage_patient_item_issue_c';
    } else if ($task == "money_receipt_list") {
        $data['page_title'] = get_phrase('money_receipt_list');
        $data['list']  = 'money_receipt';
        $data['page_name']  = 'manage_money_receipt';
    }

    //$data['page_name']  = 'manage_patient_item_issue';
 
    $this->load->view('backend/index', $data);
}
function generate_moneyreceipt_invoice($id = "")
{
    if (!$this->session->userdata('admin_login')) {
        $this->session->set_userdata('last_page', current_url());
        redirect(site_url(), 'refresh');
    }
    $data['item_info'] = $this->crud_model->select_item_info();
    $data['patient_item_issue_info'] = $this->crud_model->select_patientitemissue_info($id);
    $data['page_name']  = 'generate_moneyreceipt_invoice';
    $data['page_title'] = get_phrase('generate_money_receipt_invoice');
    $this->load->view('backend/index', $data);
}
public function generatePdf($id) {
    // Create a new TCPDF instance
    require_once(APPPATH . 'third_party/TCPDF-main/tcpdf.php');

    // Load HTML content from the view
    $data['id'] = $id;

    // Create a new TCPDF object
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('View Money Receipt');
     // Disable the default header
     $pdf->setPrintHeader(false);
    // Add a page
    $pdf->AddPage();

   



    // Load the view and get its HTML content
    $html = $this->load->view('backend/admin/pdf_template.php', $data, true);

    // Output the HTML content as a PDF
    $pdf->writeHTML($html, true, false, true, false, '');
   
  

    // Output the PDF to the browser
    $pdf->Output('designed_page.pdf', 'I');
}


function main_edit_patient_item_issue($task ="",$id = "")
{
    if (!$this->session->userdata('admin_login')) {
        $this->session->set_userdata('last_page', current_url());
        redirect(site_url(), 'refresh');
    }
    $data['item_info'] = $this->crud_model->select_item_info();
    $data['patient_item_issue_info'] = $this->crud_model->select_patientitemissue_info($id);
  if ($task == "money_receipt_edit") {
        $data['page_title'] = get_phrase('money_receipt_edit');
        $data['page_name']  = 'edit_money_receipt';
    }else{
        $data['page_title'] = get_phrase('patient_item_issue_edit');
        $data['page_name']  = 'edit_patient_item_issue';
    }
    $this->load->view('backend/index', $data);
}

function delete_patient_item_issue($task ="",$id = "")
{
    if (!$this->session->userdata('admin_login')) {
        $this->session->set_userdata('last_page', current_url());
        redirect(site_url(), 'refresh');
    }

    $this->crud_model->delete_patient_item_issue($id);
    $this->session->set_flashdata('message', get_phrase('data_deleted_successfully'));
  

    if ($task == 'challan') {
        redirect(site_url('admin/patient_item_issue/challan_list'), 'refresh');
    } else if ($task == 'invoice')  {
        redirect(site_url('admin/patient_item_issue/invoice_list'), 'refresh');
    }else {
        redirect(site_url('admin/patient_item_issue/money_receipt_list'), 'refresh');
    }
}

 function add_followup($param1 = '')
    {
        if ($this->session->userdata('admin_login') != 1) {
            $this->session->set_userdata('last_page', current_url());
            redirect(site_url(), 'refresh');
        }
        
     
            $this->crud_model->add_phone_log($param1);
            $this->session->set_flashdata('message', get_phrase('Phone_call_log_saved_successfully'));
            redirect(site_url('admin/patient_item_issue/follow_up'), 'refresh');
        
        
    }
} 