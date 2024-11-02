<div class="row">
    <!-- CALENDAR-->
    <div class="col-md-6 col-xs-6">
<h3 style="color:#547898;">Appointment schedule :</h3>    
        <div class="panel panel-primary " data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fa fa-calendar"></i>
                    <?php echo get_phrase('appointment_schedule'); ?>
                </div>
            </div>
            <div class="panel-body" style="padding:0px;">
                <div class="calendar-env">
                    <div class="calendar-body">
                        <div id="appointment_calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-6"> 
<h3 style="color:#547898;">Event schedule :</h3>	
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
<div class="row"> <div class="col-md-12 col-xs-12"> 
<h3 style="color:#547898;">follow up schedule :</h3>   
        <div class="panel panel-primary " data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fa fa-calendar"></i>
                    <?php echo get_phrase('followup_schedule'); ?>
                </div>
            </div>
            <div class="panel-body" style="padding:0px;">
                <div class="calendar-env">
                    <div class="calendar-body">
                       <a href="<?php echo site_url('doctor/message');?>"> <div id="followup_calendar"></div></a>
                    </div>
                </div>
            </div>
        </div>
    </div></div>

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