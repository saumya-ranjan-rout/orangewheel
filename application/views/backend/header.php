<style>


#notification-list {
    position: absolute; /* Position the notification list absolutely */
    top: 100%; /* Position the notification list below the bell icon */
    z-index: 999; /* Ensure the notification list appears on top of other elements */
    background-color: #fff; /* Set background color */
    border: 1px solid #ccc; /* Add border */
    padding: 5px; /* Add padding */
    min-height: 300px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add shadow */
    max-height: 500px; /* Set a maximum height for the notification list */
    overflow-y: auto; /* Enable vertical scrolling when the content exceeds the maximum height */
    list-style: none; /* Remove bullet points from list items */
    border-radius: 10%;
}

#notification-list li {
    padding: 10px; /* Add padding to each list item */
    border-bottom: 1px solid #eee; /* Add a border between list items */
}

/* Hide the notification list by default */
#notification-list.hidden {
    display: none;
}
#notification-count {
    position: absolute;
     top: 0;
      background-color: red;
       color: white;
        border-radius: 50%;
         padding: 2px 5px;
          font-size: 8px;
}
 .scrolling-text-container {
  width: 100%;
  overflow: hidden;
}

.scrolling-text {
     white-space: nowrap;
  display: inline; /* Make the text container only as wide as its content */
  background-color: #ffe4c4; /* Background color for the text */
  padding: 5px; /* Add some padding to make the background visible */
  color:black;
  font-weight:500;
  animation: scroll 50s linear infinite;
}

@keyframes scroll {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-100%);
  }
}
</style>

<div class="row">
    <div class="col-md-12 col-sm-12 clearfix" style="text-align:center;">
        <h2 style="font-weight:200; margin:0px;"><?php echo $system_name; ?></h2>
    </div>
    <div class="col-md-12 col-sm-12 clearfix" hidden>
<div class="scrolling-text-container">
    
 <?php 
  $current_date ='2024-04-26';
 // $current_date = date('Y-m-d');
  $this->db->order_by('followup_date', 'asc');
  $patient_issues = $this->db->where('issue_type', 'invoice')->get('patient_item_issue')->result_array();
  foreach ($patient_issues as $row) {
    if($row['followup_date'] == $current_date) {
      echo '<div class="scrolling-text">&nbsp;' . $row['bill_no'] . '</div>';
    }
  }
  ?>
</div> </div>
    <!-- Raw Links -->
    <div class="col-md-12 col-sm-12 clearfix ">

        <ul class="list-inline links-list pull-left">
            <!-- Language Selector -->			
            <li class="dropdown language-selector">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                    <i class="entypo-user"></i> <?php echo $this->session->userdata('login_type'); ?>
                </a>
            </li>
            
        <!--    
              <?php if($this->session->userdata('login_type') == 'admin') { ?>
            <li class="notifications dropdown">
                <?php
                
                $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

                    $total_alert_quantity = 0;
                    
                    $this->db->select('COUNT(*) AS total_count');
    $this->db->from('medicine');
  $this->db->where('(total_quantity - sold_quantity) <= alert_quantity', null, false);
$this->db->or_where('(total_quantity - sold_quantity) = alert_quantity', null, false);

    $result = $this->db->get();
                   

    if ($result) {
       $row = $result->row();
        $total_alert_quantity = $row->total_count;
    }
    
      ?>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="fa fa-medkit"style="color:blue"></i>
                   
                        <span class="badge badge-danger" style="background-color:#cf1414"><?php echo $total_alert_quantity; ?></span>
                   
                </a>

                <ul class="dropdown-menu" style="border:1px solid #9E9E9E">
                   

                    <li class="external">
                        <a href="<?php echo site_url('admin/medicine_alert_report'); ?>">
                            <?php echo 'View All Alert Quantity'; ?>
                        </a>
                    </li>				
                </ul>
            </li>
            <?php } ?>-->
            
            
            
            <?php if($this->session->userdata('login_type') == 'admin') { 
              
              $row = $this->db->order_by('id', 'DESC') ->limit(1) ->get('follow_up') ->row_array();
              $followup_days=$row['days'];
              $prescription_notification = $this->db->get('prescription')->result_array();
        
                 $total_unread_message_number = 0;
        foreach($prescription_notification as $rw){
               $follow_up_date = date('Y-m-d', $rw["follow_up"]);
                 $today = date('Y-m-d');
                 
  $date1 = new DateTime($follow_up_date);
$date2 = new DateTime($today);
$difference_days = $date2->diff($date1)->days;
                if($followup_days > $difference_days && $follow_up_date > $today){
                       $total_unread_message_number+=1;
                     
                  }
                 
            
        }
                   
                   
                if ($total_unread_message_number > 0){
                ?>
                  <li class="notifications dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="fa fa-calendar"style="color:blue"></i><span class="badge badge-danger" style="background-color:#cf1414"><?php echo $total_unread_message_number; ?></span> </a>

                <ul class="dropdown-menu">
                    <li>
                        <ul class="dropdown-menu-list scroller">


                            <?php
                         
                         foreach($prescription_notification as $rw){
                                $follow_up_date = date('Y-m-d', $rw["follow_up"]);
                $today = date('Y-m-d');
                  $date1 = new DateTime($follow_up_date);
$date2 = new DateTime($today);
$difference_days = $date1->diff($date2)->days;
                  if($followup_days > $difference_days && $follow_up_date > $today){
                       $patient_row = $this->db->get_where('patient', array('patient_id' => $rw["patient_id"]))->row_array();
                                ?>
                                  <li class="active" style="border:1px solid #E2E0E2;">
                                    <a href="<?php //echo site_url($this->session->userdata('login_type') . '/message/message_read/' . $row['message_thread_code']); ?>">
                                        <span class="image pull-right">
                                        <?php echo $follow_up_date; ?>
                                        </span>

                                        <span class="line">
                                          
                                             <?php echo $patient_row["name"]; ?>
                                            
                                           <strong>
                                            [<?php echo $patient_row["code"]; ?>]
                                            </strong>
                                        </span>

                                    </a>
                                </li>
                            <?php 
                             }
                             } 
                            ?>
                        </ul>
                    </li>

                    <li class="external" style="border:1px solid #E2E0E2;">
                        <a href="<?php echo site_url('admin/upcoming_followup'); ?>">
                            <?php echo 'View All Appointments'; ?>
                        </a>
                    </li>				
                </ul>
            </li>
            <?php 
            }
            }
            ?>
              
            
            
            <!-- Message Notifications -->
            <?php if($this->session->userdata('login_type') == 'doctor' || $this->session->userdata('login_type') == 'patient') { ?>
            <li class="notifications dropdown">
                <?php
                $total_unread_message_number = 0;
                $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');

                $this->db->where('sender', $current_user);
                $this->db->or_where('reciever', $current_user);
                $message_threads = $this->db->get('message_thread')->result_array();
                foreach ($message_threads as $row) {
                    $unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                    $total_unread_message_number += $unread_message_number;
                }
                ?>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="entypo-mail"></i>
                    <?php if ($total_unread_message_number > 0): ?>
                        <span class="badge badge-info"><?php echo $total_unread_message_number; ?></span>
                    <?php endif; ?>
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <ul class="dropdown-menu-list scroller">


                            <?php
                            $current_user = $this->session->userdata('login_type') . '-' . $this->session->userdata('login_user_id');
                            $this->db->where('sender', $current_user);
                            $this->db->or_where('reciever', $current_user);
                            $message_threads = $this->db->get('message_thread')->result_array();
                            foreach ($message_threads as $row):

                                // defining the user to show
                                if ($row['sender'] == $current_user)
                                    $user_to_show = explode('-', $row['reciever']);
                                if ($row['reciever'] == $current_user)
                                    $user_to_show = explode('-', $row['sender']);
                                $user_to_show_type = $user_to_show[0];
                                $user_to_show_id = $user_to_show[1];
                                $unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                                if ($unread_message_number == 0)
                                    continue;

                                // the last sent message from the opponent user
                                $this->db->order_by('timestamp', 'desc');
                                $last_message_row = $this->db->get_where('message', array('message_thread_code' => $row['message_thread_code']))->row();
                                $last_unread_message = $last_message_row->message;
                                $last_message_timestamp = $last_message_row->timestamp;
                                ?>
                                <li class="active">
                                    <a href="<?php echo site_url($this->session->userdata('login_type') . '/message/message_read/' . $row['message_thread_code']); ?>">
                                        <span class="image pull-right">
                                            <img src="<?php echo $this->crud_model->get_image_url($user_to_show_type, $user_to_show_id); ?>" height="48" class="img-circle" />
                                        </span>

                                        <span class="line">
                                            <strong>
                                                <?php echo $this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row()->name; ?>
                                            </strong>
                                            - <?php echo date("d M, Y", $last_message_timestamp); ?>
                                        </span>

                                        <span class="line desc small">
                                            <!-- preview of the last unread message substring -->
                                            <?php
                                            echo substr($last_unread_message, 0, 50);
                                            ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <li class="external">
                        <a href="<?php echo site_url($this->session->userdata('login_type') . '/message'); ?>">
                            <?php echo get_phrase('view_all_messages'); ?>
                        </a>
                    </li>				
                </ul>
            </li>
            <?php } ?>
        </ul>
 

        <ul class="list-inline links-list pull-right">
            
              <li>
            <?php
              $current_date = date('Y-m-d');
      $this->db->select('*');
      $this->db->from('patient_item_issue');
      $this->db->where("DATE_ADD(invoice_date, INTERVAL return_days DAY) =", $current_date); // Corrected line
      $query = $this->db->get();
      $result = $query->result_array();

                                ?>
    <a href="#" id="bell-icon" title="Trial Completed">
        <i class="fa fa-bell"></i>
        <span id="notification-count"><?php echo count($result); ?></span> <!-- Display the count of unread notifications -->
    </a>
    <!-- Notification list -->
    <ul id="notification-list" class="hidden" >
        <?php foreach ($result as $row): ?>
        <li><?php echo $row['bill_no']; ?></li>
        <?php endforeach; ?>
    </ul>
</li>
<li></li>

            <li>
                <a href="<?php echo site_url('home'); ?>" target="_blank">
                    <i class="fa fa-globe"></i> &nbsp;<?php echo get_phrase('website');?>
                </a>
            </li>
            <li class="sep"></li>
            <li>
                <a href="<?php echo site_url('login/logout'); ?>">
                    <?php echo get_phrase('logout');?> &nbsp;<i class="fa fa-sign-out"></i>
                </a>
            </li>
        </ul>
    </div>

</div>

<hr style="margin-top:0px;" />
<a class="btn btn-info pull-right" href="javascript:history.go(-1)"> <i class="fa fa-arrow-left"></i> Back</a><br><br>

<script type="text/javascript">
$(document).ready(function() {
    // Handle click event on bell icon
    $('#bell-icon').click(function() {
        $('#notification-list').toggleClass('hidden'); // Toggle visibility of notification list
    });
});
</script>