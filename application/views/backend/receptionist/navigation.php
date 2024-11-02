<div class="sidebar-menu" style="background-color:#093f23 !important;">
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
            <a href="<?php echo site_url($account_type . '/manage_profile'); ?>">
                <i class="entypo-pencil"></i>
                <?php echo get_phrase('edit_profile'); ?>
            </a>

            <a href="<?php echo site_url($account_type . '/manage_profile'); ?>">
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
            <a href="<?php echo site_url('receptionist/dashboard');?>">
                <i class="fa fa-desktop"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>
   <li class="<?php if ($page_name == 'manage_patient') echo 'active'; ?> ">
            <a href="<?php echo site_url('receptionist/patient');?>">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('patient'); ?></span>
            </a>
        </li>
        <li class="<?php if ($page_name == 'manage_doctor_history') echo 'active'; ?> ">
            <a href="<?php echo site_url('receptionist/doctor_history');?>">
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
            <a href="<?php echo site_url('receptionist/diagnosis');?>">
               <i class="entypo-dot"></i>
                <span><?php echo get_phrase('diagnosis')?></span>
            </a>
        </li>
        <li class="<?php if ($page_name == 'manage_warranty') echo 'active'; ?> ">
            <a href="<?php echo site_url('receptionist/warranty');?>">
                <i class="entypo-dot"></i>
                <span><?php echo get_phrase('warranty')?></span>
            </a>
        </li>
              
                <li class="<?php if ($page_name == 'show_unit_master') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/unit_master');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Unit'; ?></span>
                    </a>
                </li>
            </ul>
        </li>

           
       

        
    
        <li class="<?php if ($page_name == 'manage_item_category' || $page_name == 'manage_item_supplier' || $page_name == 'manage_item' || $page_name == 'manage_item_stock' || $page_name == 'manage_item_subcategory')
                        echo 'opened active'; ?> ">
            <a href="#">
                <i class="fa fa-hospital-o"></i>
                <span><?php echo get_phrase('inventory'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_item') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/item'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item'); ?></span>
                    </a>
                </li>
                     <li class="<?php if ($page_name == 'purchase_entry') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/purchase_entry'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('Purchase_entry'); ?></span>
                    </a>
                </li>
  
               
             
                <li class="<?php if ($page_name == 'manage_item_supplier') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/item_supplier'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_supplier'); ?></span>
                    </a>
                </li>
                 <li class="<?php if ($page_name == 'manage_item_category') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/item_category'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_category'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_item_subcategory') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/item_subcategory'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_subcategory'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="<?php if ($page_name == 'add_money_receipt' ||$page_name == 'manage_money_receipt' ||$page_name == 'manage_patient_item_issue_i' || $page_name == 'manage_patient_item_issue_c' || $page_name == 'add_patient_item_issue')
                        echo 'opened active'; ?> ">
            <a href="#">
                <i class="fa fa-list-alt"></i>
                <span><?php echo get_phrase('patient_item_issue'); ?></span>
            </a>
            <ul>
            <li class="<?php if ($page_name == 'add_money_receipt') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/create_money_receipt'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('add_money_receipt'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_money_receipt') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/patient_item_issue/money_receipt_list'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('manage_money_receipt'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'add_patient_item_issue') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/create_patient_item_issue'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('add_item_issue'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_patient_item_issue_i') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/patient_item_issue/invoice_list'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('invoices'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_patient_item_issue_c') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/patient_item_issue/challan_list'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('challans'); ?></span>
                    </a>
                </li>

            </ul>
        </li>
        
    
    <li class="<?php if ($page_name == 'manage_income_head'   || $page_name == 'manage_expense_head'
                            || $page_name == 'manage_income'      || $page_name == 'manage_expense')
                        echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-money"></i>
                <span><?php echo 'Finance'; ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_income_head') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/income_head');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Income Head'; ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_expense_head') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/expense_head');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Expense Head'; ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_income') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/income');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Income'; ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_expense') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/expense');?>">
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
                    <a href="<?php echo site_url('receptionist/invoice_add');?>">
                        <i class="fa fa-plus"></i>
                        <span><?php echo get_phrase('add_invoice'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_invoice') echo 'active'; ?>">
                    <a href="<?php echo site_url('receptionist/invoice_manage');?>">
                        <i class="fa fa-align-justify"></i>
                        <span><?php echo get_phrase('manage_invoice'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        
  
       
       <!-- Manoj End-->
       <li class="<?php if ($page_name == 'show_operation_report' || $page_name == 'show_birth_report' || $page_name == 'show_death_report' || $page_name == 'show_item_report' || $page_name == 'show_item_stock_report' || $page_name == 'show_doctor_item_issue_report' || $page_name == 'show_patient_item_issue_report' || $page_name == 'show_patient_item_challan_report' || $page_name == 'manage_income_report'   || $page_name == 'manage_expense_report' || $page_name == 'manage_income_group_report' || $page_name == 'manage_expense_group_report' )
                        echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-bar-chart-o"></i>
                <span>Reports</span>
            </a>
            <ul>
         
                 <li class="<?php if ($page_name == 'manage_income_group_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/income_group_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Income Group Report'; ?></span>
                    </a>
                </li>
                  <li class="<?php if ($page_name == 'manage_expense_group_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/expense_group_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Expense Group Report'; ?></span>
                    </a>
                </li>    
                <li class="<?php if ($page_name == 'manage_income_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/income_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Income Report'; ?></span>
                    </a>
                </li>                
               
                <li class="<?php if ($page_name == 'manage_expense_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/expense_report');?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo 'Expense Report'; ?></span>
                    </a>
                </li>
               
                
                
                <!--Manoj-->
                <li class="<?php if ($page_name == 'show_item_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/item_report'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('item_report'); ?></span>
                    </a>
                </li>
           
                
                <li class="<?php if ($page_name == 'show_patient_item_issue_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/patient_item_issue_report'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('patient_item_issue_report'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'show_patient_item_challan_report') echo 'active'; ?> ">
                    <a href="<?php echo site_url('receptionist/patient_item_challan_report'); ?>">
                        <i class="entypo-dot"></i>
                        <span><?php echo get_phrase('patient_item_challan_report'); ?></span>
                    </a>
                </li>
             
            </ul>
        </li>
       

   



    </ul>

</div>