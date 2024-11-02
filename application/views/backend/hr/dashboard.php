<style>
.info-box {
    display: block;
    min-height: 50px;
    background: #fff;
    width: 100%;
    border: solid 1px #c5d6de;
     box-shadow: 0 1px 1px rgba(0,0,0,0.1); 
    border-radius: 4px;
    margin-bottom: 15px;
}
.info-box a {
    color: #333;
    text-decoration: none;
    width: 100%;
    display: block;
}
.info-box-icon {
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: left;
    height: 50px;
    width: 50px;
    text-align: center;
    font-size: 24px;
    line-height: 50px;
    background: rgba(0,0,0,0.2);
}
.info-box-content {
    padding: 4px 10px;
    margin-left: 50px;
}
.info-box-text {
    text-transform: capitalize;
}
.info-box-number {
    display: block;
    font-family: 'Roboto-Bold';
    font-size: 16px;
}
 .info-box-text {
    display: block;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.bg-green {
    background-color: #66aa18 !important;
     color: #fff !important;
}

</style>
<div class="row">
    <!-- CALENDAR-->
<div class="row" >
                                <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('patients') ?>">
                            
                                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> <?php echo get_phrase('patients') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('patient'); ?></span>
                                </div>
                           
                        </div> </div>
                          <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('Audiologist') ?>">
  
                                <span class="info-box-icon bg-green"><i class="fa fa-user-md"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> <?php echo get_phrase('Audiologist') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('doctor'); ?></span>
                                </div>
                          
                        </div> </div>
                          <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('Hr') ?>">
                             
                                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> <?php echo get_phrase('Hr') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('hr'); ?></span>
                                </div>
                          
                        </div> </div>
                          <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('accountant') ?>">
                         
                                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo get_phrase('accountant') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('accountant'); ?></span>
                                </div>
                         
                        </div> </div>
                        
                         <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('receptionist') ?>">
                          
                                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo get_phrase('receptionist') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('receptionist'); ?></span>
                                </div>
                           
                        </div> </div>
                        
                        
                         <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('today_visit'); ?>">
                           
                                <span class="info-box-icon bg-green"><i class="fa fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo get_phrase('today_visit'); ?></span>
                                    <span class="info-box-number" >  <?php
            $date = date('d-m-Y');
            $this->db->where('date', $date);
            $countp = $this->db->count_all_results('patient_consultation_history');
            ?><?php echo $countp ?></span>
                                </div>
                          
                        </div> </div>
                   

                        
                        
                
        </div>
    <div class="col-md-12 col-xs-12"> 
<h3 style="color:#547898;">Calendar :</h3>	
        <div class="panel panel-primary " data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fa fa-calendar"></i>
                    <?php echo get_phrase('event_schedule'); ?>
                </div>
            </div>
            <div class="panel-body" style="padding:0px;">
                <div class="calendar-env">
                    <div class="calendar-body">
                        <div id="event_calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function()
    {
        $('#appointment_calendar').fullCalendar
        ({
            header:
            {
                left: 'title',
                right: 'month,agendaWeek,agendaDay today prev,next'
            },

            editable: false,
            firstDay: 1,
            height: 530,
            droppable: false,

            events:
            [
                <?php
                $doctor_id      = $this->session->userdata('login_user_id');
                $appointments   = $this->db->get_where('appointment' , array('doctor_id' => $doctor_id ))->result_array();
                foreach ($appointments as $row):
                ?>
                    {
                        title   :   "<?php  $name = $this->db->get_where('patient' , 
                                                array('patient_id' => $row['patient_id'] ))->row()->name;
                                            echo $name;?>",
                        start   :   new Date(<?php echo date('Y', $row['timestamp']); ?>, 
                                        <?php echo date('m', $row['timestamp']) - 1; ?>, 
                                        <?php echo date('d', $row['timestamp']); ?>,
                                        <?php echo date('H', $row['timestamp']); ?>),
                        allDay: false
                    },
                <?php endforeach ?>
            ]
        });
    });
</script>
<script type="text/javascript">
    
    $(document).ready(function()
    {
        $('#followup_calendar').fullCalendar
        ({
            header:
            {
                left: 'title',
                right: 'month,agendaWeek,agendaDay today prev,next'
            },

            editable: false,
            firstDay: 1,
            height: 530,
            droppable: false,

            events:
            [
                <?php
                $doctor_id      = $this->session->userdata('login_user_id');
                $appointments   = $this->db->get_where('prescription' , array('doctor_id' => $doctor_id ))->result_array();
                foreach ($appointments as $row):
                ?>
                    {
                        title   :   "<?php  $name = $this->db->get_where('patient' , 
                                                array('patient_id' => $row['patient_id'] ))->row()->name;
                                            echo $name; ?> ",
                        start   :   new Date(<?php echo date('Y', $row['follow_up']); ?>, 
                                        <?php echo date('m', $row['follow_up']) - 1; ?>, 
                                        <?php echo date('d', $row['follow_up']); ?>,
                                        <?php echo date('H', $row['follow_up']); ?>,
										<?php echo date('i', $row['follow_up']); ?>),
                        allDay: false
                    },
                <?php endforeach ?>
            ]
        });
    });
</script>
<script type="text/javascript">
    
    $(document).ready(function()
    {	
        $('#event_calendar').fullCalendar
        ({
            header:
            {
                left: 'title',
                right: 'month,agendaWeek,agendaDay today prev,next'
            },

            editable: false,
            firstDay: 1,
            height: 530,
            droppable: false,

            events:
            [
                <?php
                $notices   = $this->db->get('notice')->result_array();
                foreach ($notices as $row):
                ?>
                    {
                        title   :   "<?php echo $title = $this->db->get_where('notice' , 
                                        array('notice_id' => $row['notice_id'] ))->row()->title;?>",
                        start   :   new Date(<?php echo date('Y', $row['start_timestamp']); ?>, 
                                        <?php echo date('m', $row['start_timestamp']) - 1; ?>, 
                                        <?php echo date('d', $row['start_timestamp']); ?>),
                        end     :   new Date(<?php echo date('Y', $row['end_timestamp']); ?>, 
                                        <?php echo date('m', $row['end_timestamp']) - 1; ?>, 
                                        <?php echo date('d', $row['end_timestamp']); ?>),
                        allDay: true
                    },
                <?php endforeach ?>
            ]
        });
    });
</script>