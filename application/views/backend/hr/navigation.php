<style>
.page-container .sidebar-menu #main-menu li a{
color:#ffffff;
}
</style><div class="sidebar-menu" style="background-color:#22576d !important;">
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
            <a href="<?php echo site_url('hr/manage_profile');?>">
                <i class="entypo-pencil"></i>
                <?php echo get_phrase('edit_profile'); ?>
            </a>

            <a href="<?php echo site_url('hr/manage_profile');?>">
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
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> " >
            <a href="<?php echo site_url('hr/dashboard');?>"  >
                <i class="fa fa-desktop"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

    

       
      <li class="<?php if ($page_name == 'manage_department' || $page_name == 'department_facilities' || $page_name == 'manage_doctor' || 
                 $page_name == 'manage_accountant' || $page_name == 'manage_receptionist' || $page_name == 'manage_hr' ) echo 'opened active';?> ">
            <a href="#">
                <i class="fa fa-users"></i>
                <span><?php echo get_phrase('HRMS'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'manage_department' || $page_name == 'department_facilities') echo 'active'; ?> ">
            <a href="<?php echo site_url('hr/department');?>">
                <i class="fa fa-sitemap"></i>
                <span><?php echo get_phrase('department'); ?></span>
            </a>
        </li>
            <li class="<?php if ($page_name == 'manage_doctor') echo 'active'; ?>">
            <a href="#">
                <i class="fa fa-user-md"></i>
                <span><?php echo get_phrase('Audiologists'); ?></span>
            </a>
        </li>

        <li class="<?php if ($page_name == 'manage_accountant') echo 'active'; ?> ">
            <a href="#">
                <i class="fa fa-money"></i>
                <span><?php echo get_phrase('accountant'); ?></span>
            </a>
        </li>

        <li class="<?php if ($page_name == 'manage_receptionist') echo 'active'; ?> ">
            <a href="#">
                <i class="fa fa-plus-square"></i>
                <span><?php echo get_phrase('receptionist'); ?></span>
            </a>
        </li>
        
     
        <li class="<?php if ($page_name == 'manage_hr') echo 'active'; ?> ">
            <a href="#">
                <i class="fa fa-user"></i>
                <span><?php echo get_phrase('hr'); ?></span>
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
                    <a href="<?php echo site_url('hr/payroll');?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_payroll'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'payroll_list') echo 'active'; ?> ">
                    <a href="<?php echo site_url('hr/payroll_list');?>">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('payroll_list'); ?></span>
                    </a>
                </li>
            </ul>
        </li>
       



    </ul>

</div>
