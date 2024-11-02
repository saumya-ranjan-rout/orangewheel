<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
           <a href="<?php echo site_url('login'); ?>">
                <img src="<?php echo base_url('uploads/logo3.jpg');?>"  style=" max-height: 120px;width: 150px; "/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>
    <div class="sidebar-user-info">

        <div class="sui-normal">
            <a href="#" class="user-link">
                <img src="<?php echo $this->crud_model->get_image_url($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));?>" alt="" class="img-circle" style="height:44px;">

                <span><?php echo get_phrase('welcome'); ?>,</span>
                <strong><?php
                    echo $this->db->get_where($this->session->userdata('login_type'), array($this->session->userdata('login_type') . '_id' =>
                        $this->session->userdata('login_user_id')))->row()->name;
                    ?>
                </strong>
            </a>
        </div>

        <div class="sui-hover inline-links animate-in"><!-- You can remove "inline-links" class to make links appear vertically, class "animate-in" will make A elements animateable when click on user profile -->
            <a href="<?php echo site_url('admin/manage_profile');?>">
                <i class="entypo-pencil"></i>
                <?php echo get_phrase('edit_profile'); ?>
            </a>

            <a href="<?php echo site_url('admin/manage_profile');?>">
                <i class="entypo-lock"></i>
                <?php echo get_phrase('change_password'); ?>
            </a>

            <span class="close-sui-popup">×</span><!-- this is mandatory -->
        </div>
    </div>

    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/dashboard');?>">
                <i class="fa fa-desktop"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
   <li class="<?php if ($page_name == 'manage_patient') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/patient');?>">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('patient'); ?></span>
            </a>
        </li>
        <li class="<?php if ($page_name == 'manage_doctor_history') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/doctor_history');?>">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('doctor_history'); ?></span>
            </a>
        </li>
    <li class="<?php if ($page_name == 'show_payment_history' || $page_name == 'follow_up' || $page_name == 'show_unit_master' || $page_name == 'manage_consultation'|| $page_name == 'manage_diagnosis'|| $page_name == 'manage_warranty' )
                        echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-cogs"></i>
                <span><?php echo get_phrase('monitor_hospital'); ?></span>
            </a>
            <ul>
               
                <li class="<?php if ($page_name == 'manage_diagnosis') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/diagnosis');?>">
               <i class="entypo-dot"></i>
                <span><?php echo get_phrase('diagnosis')?></span>
            </a>
        </li>
        <li class="<?php if ($page_name == 'manage_warranty') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/warranty');?>">
                <i class="entypo-dot"></i>
                <span><?php echo get_phrase('warranty')?></span>
            </a>
        </li>
               <!-- <li class="<?php if ($page_name == 'manage_consultation') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/manage_consultation');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('consultation_fee'); ?></span>
                    </a>
                </li>-->
              <!-- <li class="<?php if ($page_name == 'show_payment_history') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/payment_history');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('payment_history'); ?></span>
                    </a>
                </li>
                  <li class="<?php if ($page_name == 'follow_up') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/follow_up');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('Follow up'); ?></span>
                    </a>
                </li>-->
                <li class="<?php if ($page_name == 'show_unit_master') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/unit_master');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Unit'; ?></span>
                    </a>
                </li>
            </ul>
        </li>

            <li class="<?php if ($page_name == 'manage_department' || $page_name == 'department_facilities' || $page_name == 'manage_doctor' || 
                 $page_name == 'manage_accountant' || $page_name == 'manage_receptionist' || $page_name == 'manage_hr' ) echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-users"></i>
                <span><?php echo get_phrase('HRMS'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_department' || $page_name == 'department_facilities') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/department');?>">
                <i class="fa fa-sitemap"></i>
                <span><?php echo get_phrase('department'); ?></span>
            </a>
        </li>
            <li class="<?php if ($page_name == 'manage_doctor') echo 'active'; ?>">
            <a href="<?php echo site_url('admin/doctor');?>">
                <i class="fa fa-user-md"></i>
                <span><?php echo get_phrase('Audiologists'); ?></span>
            </a>
        </li>
     
      

      <!--  <li class="<?php if ($page_name == 'manage_pharmacist') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/pharmacist');?>">
                <i class="fa fa-medkit"></i>
                <span><?php echo get_phrase('pharmacist'); ?></span>
            </a>
        </li>

        <li class="<?php if ($page_name == 'manage_laboratorist') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/laboratorist');?>">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('laboratorist'); ?></span>
            </a>
        </li>-->

        <li class="<?php if ($page_name == 'manage_accountant') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/accountant');?>">
                <i class="fa fa-money"></i>
                <span><?php echo get_phrase('accountant'); ?></span>
            </a>
        </li>

        <li class="<?php if ($page_name == 'manage_receptionist') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/receptionist');?>">
                <i class="fa fa-plus-square"></i>
                <span><?php echo get_phrase('receptionist'); ?></span>
            </a>
        </li>
        
     
        
        
         <!----------------------- Tarini 16-06-2023------------------------->
        <li class="<?php if ($page_name == 'manage_hr') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/hr');?>">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('hr'); ?></span>
            </a>
        </li>
        <!----------------------- Tarini 16-06-2023------------------------->
            </ul>
        </li>
         <!--  <li class="<?php if ($page_name == 'manage_appointment' || $page_name == 'manage_requested_appointment') 
            echo 'opened active';?> ">
                <a href="#">
                    <i class="fa fa-calendar"></i>
                    <span><?php echo get_phrase('appointment'); ?></span>
                </a>
                <ul>
                    <li class="<?php if ($page_name == 'manage_appointment') echo 'active'; ?> ">
                        <a href="<?php echo site_url('admin/appointment');?>">
                            <i class="entypo-dot"></i>
                            <span><?php echo get_phrase('appointment_list'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'manage_requested_appointment') echo 'active'; ?> ">
                        <a href="<?php echo site_url('admin/appointment_requested');?>">
                            <i class="entypo-dot"></i>
                            <span><?php echo get_phrase('requested_appointments'); ?></span>
                        </a>
                    </li>
                </ul>
        </li>-->
      <!--  <li class="<?php if ($page_name == 'manage_patient_history') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/patient_history');?>">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('Patient History')?></span>
            </a>
        </li>
        <li class="<?php if ($page_name == 'manage_prescription') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/prescription');?>">
                <i class="fa fa-edit"></i>
                <span><?php echo get_phrase("prescription") ?></span>
            </a>
        </li>-->
        
          
       <!-- <li class="<?php if ($page_name == 'manage_medicine_category' || $page_name == 'manage_medicine' || $page_name == 'medicine_sale' || $page_name == 'medicine_sale_add') echo 'opened active'; ?> ">
            <a href="#">
                <i class="fa fa-medkit"></i>
                <span><?php echo 'Pharmacy' ?></span>
            </a>
            <ul>
                 <li class="<?php if ($page_name == 'manage_medicine_category') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/medicine_category'); ?>">
                 <i class="entypo-dot"></i>
                <span><?php echo get_phrase('medicine_category'); ?></span>
            </a>
        </li>
        
                
                <li class="<?php if ($page_name == 'manage_medicine') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/medicine'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('manage_medicines'); ?></span>
                    </a>
                </li>
                
                <li class="<?php if ($page_name == 'medicine_sale' || $page_name == 'medicine_sale_add') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/medicine_sale'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('medicine_sales'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
-->
       
       
       

        
    
        <li class="<?php if ($page_name == 'manage_item_category' || $page_name == 'manage_item_supplier' || $page_name == 'manage_item' || $page_name == 'manage_item_stock' || $page_name == 'manage_item_subcategory')
                        echo 'opened active'; ?> ">
            <a href="#">
                <i class="fa fa-hospital-o"></i>
                <span><?php echo get_phrase('inventory'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_item') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/item'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item'); ?></span>
                    </a>
                </li>
                     <li class="<?php if ($page_name == 'purchase_entry') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/purchase_entry'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('Purchase_entry'); ?></span>
                    </a>
                </li>
               <!-- <li class="<?php if ($page_name == 'manage_item_stock') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/item_stock'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_stock'); ?></span>
                    </a>
                </li>-->
               <!-- <li class="<?php if ($page_name == 'manage_item_issue') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/item_issue'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_issue'); ?></span>
                    </a>
                </li>-->
               <!-- <li class="<?php if ($page_name == 'manage_patient_item_issue' || $page_name == 'add_patient_item_issue') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/patient_item_issue'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('patient_item_issue'); ?></span>
                    </a>
                </li>-->
               
             
                <li class="<?php if ($page_name == 'manage_item_supplier') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/item_supplier'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_supplier'); ?></span>
                    </a>
                </li>
                 <li class="<?php if ($page_name == 'manage_item_category') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/item_category'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_category'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_item_subcategory') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/item_subcategory'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_subcategory'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="<?php if ($page_name == 'add_money_receipt' ||$page_name == 'manage_money_receipt' ||$page_name == 'manage_patient_item_issue_i' || $page_name == 'manage_patient_item_issue_c' || $page_name == 'add_patient_item_issue' || $page_name == 'manage_followup')
                        echo 'opened active'; ?> ">
            <a href="#">
                <i class="fa fa-list-alt"></i>
                <span><?php echo get_phrase('patient_item_issue'); ?></span>
            </a>
            <ul>
            <li class="<?php if ($page_name == 'add_money_receipt') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/create_money_receipt'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('add_money_receipt'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_money_receipt') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/patient_item_issue/money_receipt_list'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('manage_money_receipt'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'add_patient_item_issue') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/create_patient_item_issue'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('add_item_issue'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_patient_item_issue_i') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/patient_item_issue/invoice_list'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('invoices'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_patient_item_issue_c') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/patient_item_issue/challan_list'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('challans'); ?></span>
                    </a>
                </li>
                
                 <li class="<?php if ($page_name == 'manage_followup') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/patient_item_issue/follow_up'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('Follow Up'); ?></span>
                    </a>
                </li>
                

            </ul>
        </li>
        
      <!--  <li class="<?php if ($page_name == 'manage_pathology_test_category' || $page_name == 'manage_pathology_test' || $page_name == 'manage_pathology_patient_report') echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="fa fa-flask"></i>
                <span><?php echo get_phrase('pathology'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_pathology_patient_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/pathology_patient_report'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('pathology_patient_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_pathology_test') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/pathology_test'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('pathology_test'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_pathology_test_category') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/pathology_test_category'); ?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('pathology_test_category'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        -->
    <li class="<?php if ($page_name == 'manage_income_head'   || $page_name == 'manage_expense_head'
                            || $page_name == 'manage_income'      || $page_name == 'manage_expense')
                        echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-money"></i>
                <span><?php echo 'Finance'; ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_income_head') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/income_head');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Income Head'; ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_expense_head') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/expense_head');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Expense Head'; ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_income') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/income');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Income'; ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_expense') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/expense');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Expense'; ?></span>
                    </a>
                </li>               
            </ul>
        </li>
 <li class="<?php if ($page_name == 'add_invoice' || $page_name == 'manage_invoice') echo 'opened active has-sub'; ?> ">
            <a href="#">
                <i class="fa fa-list-alt"></i>
                <span><?php echo get_phrase('invoice'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'add_invoice') echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/invoice_add');?>">
                        <i class="fa fa-plus"></i>
                        <span><?php echo get_phrase('add_invoice'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_invoice') echo 'active'; ?>">
                    <a href="<?php echo site_url('admin/invoice_manage');?>">
                        <i class="fa fa-align-justify"></i>
                        <span><?php echo get_phrase('manage_invoice'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="<?php
            if ($page_name == 'payroll_add' || $page_name == 'payroll_add_view'
                || $page_name == 'payroll_list')
                echo 'opened active has-sub'; ?>">
            <a href="#">
                <i class="fa fa-credit-card"></i>
                <span><?php echo get_phrase('payroll'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'payroll_add' || $page_name == 'payroll_add_view') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/payroll');?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_payroll'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'payroll_list') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/payroll_list');?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('payroll_list'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
       <!-- Manoj-->
       
       <!-- Manoj End-->
       <li class="<?php if ($page_name == 'show_operation_report' || $page_name == 'show_birth_report' || $page_name == 'show_death_report' || $page_name == 'show_item_report' || $page_name == 'show_item_stock_report' || $page_name == 'show_doctor_item_issue_report' || $page_name == 'show_patient_item_issue_report' || $page_name == 'show_patient_item_challan_report' || $page_name == 'manage_income_report'   || $page_name == 'manage_expense_report' || $page_name == 'manage_income_group_report' || $page_name == 'manage_expense_group_report' )
                        echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-bar-chart-o"></i>
                <span>Reports</span>
            </a>
            <ul>
                <!--<li class="<?php if ($page_name == 'show_pathology_patient_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/pathology_patient_report_search'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('pathology_patient_report'); ?></span>
                    </a>
                </li>-->
                 <li class="<?php if ($page_name == 'manage_income_group_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/income_group_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Income Group Report'; ?></span>
                    </a>
                </li>
                  <li class="<?php if ($page_name == 'manage_expense_group_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/expense_group_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Expense Group Report'; ?></span>
                    </a>
                </li>    
                <li class="<?php if ($page_name == 'manage_income_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/income_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Income Report'; ?></span>
                    </a>
                </li>                
               
                <li class="<?php if ($page_name == 'manage_expense_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/expense_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Expense Report'; ?></span>
                    </a>
                </li>
               
                
                
                <!--Manoj-->
                <li class="<?php if ($page_name == 'show_item_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/item_report'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_report'); ?></span>
                    </a>
                </li>
                <!--<li class="<?php if ($page_name == 'show_item_stock_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/item_stock_report'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_stock_report'); ?></span>
                    </a>
                </li>-->
                
                <li class="<?php if ($page_name == 'show_patient_item_issue_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/patient_item_issue_report'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('patient_item_issue_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_patient_item_challan_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/patient_item_challan_report'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('patient_item_challan_report'); ?></span>
                    </a>
                </li>
               <!-- Manoj End-->
                
              <!--  <li class="<?php if ($page_name == 'show_operation_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/operation_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('operation_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_birth_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/birth_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('birth_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_death_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/death_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('death_report'); ?></span>
                    </a>
                </li>-->
              <!--  <li class="<?php if ($page_name == 'show_medicine_sales_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/medicine_sales_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Medicine Sales Report'; ?></span>
                    </a>
                </li>
            
                <li class="<?php if ($page_name == 'show_medicine_alert_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/medicine_alert_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Medicine Alert Report'; ?></span>
                    </a>
                </li>-->
                <!---Tarini---->
            </ul>
        </li>
       

        <!-- SETTINGS -->
        <li class="<?php if ($page_name == 'system_settings' ||$page_name == 'bank_details' || $page_name == 'manage_language' || $page_name == 'manage_profile'|| $page_name == 'manage_notice'||
                            $page_name == 'sms_settings') echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-wrench"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/system_settings');?>">
                        <span><i class="fa fa-h-square"></i> <?php echo get_phrase('system_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'bank_details') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/bank_details');?>">
                        <span><i class="fa fa-money"></i> <?php echo get_phrase('bank_details'); ?></span>
                    </a>
                </li>
             <!--   <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/manage_language');?>">
                        <span><i class="fa fa-globe"></i> <?php echo get_phrase('language_settings'); ?></span>
                    </a>
                </li>-->
                <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?> ">
                    <a href="<?php echo site_url('admin/sms_settings');?>">
                        <span><i class="entypo-paper-plane"></i><?php echo get_phrase('sms_settings'); ?></span>
                    </a>
                </li>
                 <li class="<?php if ($page_name == 'manage_notice') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/notice');?>">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
        </li>
                 <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo site_url('admin/manage_profile');?>">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>
            </ul>
        </li>

        <!-- forntend -->
       <!-- <li class="<?php if ($page_name == 'frontend') echo 'active'; ?>">
            <a href="<?php echo site_url('admin/frontend');?>">
                <i class="fa fa-laptop"></i>
                <span><?php echo get_phrase('frontend'); ?></span>
            </a>
        </li>
-->
        <!-- contact emails -->
       <!-- <li class="<?php if ($page_name == 'contact_email') echo 'active'; ?>">
            <a href="<?php echo site_url('admin/contact_email');?>">
                <i class="fa fa-envelope"></i>
                <span><?php echo get_phrase('contact_emails'); ?></span>
            </a>
        </li>-->

        <!-- ACCOUNT -->
       



    </ul>

</div>
