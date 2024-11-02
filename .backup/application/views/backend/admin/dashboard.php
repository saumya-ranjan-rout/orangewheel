<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style>
  .card {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

   .card-header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
    }
/*.box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border: solid 1px #c5d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1); 
}*/
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
.bg-green {
    background-color: #66aa18 !important;
     color: #fff !important;
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
@media (min-width: 1200px)
.col20 {
    width: 20%;
}
.badge {
  display: inline-block;
  min-width: 10px;
  padding: 3px 7px;
  font-size: 11px;
  font-weight: normal;
  color: #fff;
  line-height: 1;
  vertical-align: middle;
  white-space: nowrap;
  text-align: center;
  
  border-radius: 10px;
}
.label-info {
  background-color: #21a9e1;
}
.highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 660px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
</style>

<div class="row" >
                                <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('patients') ?>">
                             <a href="<?php echo site_url('admin/patient'); ?>">
                                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> <?php echo get_phrase('patients') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('patient'); ?></span>
                                </div>
                            </a>
                        </div> </div>
                          <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('Audiologist') ?>">
  <a href="<?php echo site_url('admin/doctor'); ?>">
                                <span class="info-box-icon bg-green"><i class="fa fa-user-md"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> <?php echo get_phrase('Audiologist') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('doctor'); ?></span>
                                </div>
                            </a>
                        </div> </div>
                          <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('Hr') ?>">
                              <a href="<?php echo site_url('admin/hr'); ?>">
                                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"> <?php echo get_phrase('Hr') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('hr'); ?></span>
                                </div>
                            </a>
                        </div> </div>
                          <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('accountant') ?>">
                           <a href="<?php echo site_url('admin/accountant'); ?>">
                                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo get_phrase('accountant') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('accountant'); ?></span>
                                </div>
                            </a>
                        </div> </div>
                        
                         <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('receptionist') ?>">
                           <a href="<?php echo site_url('admin/receptionist'); ?>">
                                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo get_phrase('receptionist') ?></span>
                                    <span class="info-box-number" ><?php echo $this->db->count_all('receptionist'); ?></span>
                                </div>
                            </a>
                        </div> </div>
                        
                        
                         <div class="col-lg-3  col20">
                        <div class="info-box" title="<?php echo get_phrase('today_visit'); ?>">
                           <a href="<?php echo site_url('admin/today_visit'); ?>">
                                <span class="info-box-icon bg-green"><i class="fa fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?php echo get_phrase('today_visit'); ?></span>
                                    <span class="info-box-number" >  <?php
            $date = date('d-m-Y');
            $this->db->where('date', $date);
            $countp = $this->db->count_all_results('patient_consultation_history');
            ?><?php echo $countp ?></span>
                                </div>
                            </a>
                        </div> </div>
                   

                        
                        
                
        </div>
        
<!--<div class="row">
      <div class="col-sm-3">
        <a href="<?php echo site_url('admin/patient'); ?>">
            <div class="tile-stats tile-white-red">
                <div class="icon"><i class="fa fa-users"  style="color:#f56954"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('patient'); ?>" 
                     data-duration="1500" data-delay="0"><?php echo $this->db->count_all('patient'); ?></div>
                <h3><?php echo get_phrase('patients') ?></h3>
            </div>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="<?php echo site_url('admin/doctor'); ?>">
            <div class="tile-stats tile-white tile-white-primary">
                <div class="icon"><i class="fa fa-user-md" style="color:black"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('doctor'); ?>"
                     data-duration="1500" data-delay="0"><?php echo $this->db->count_all('doctor'); ?></div>
                <h3><?php echo get_phrase('Audiologist') ?></h3>
            </div>
        </a>
    </div>
 <div class="col-sm-3">
        <a href="<?php echo site_url('admin/hr'); ?>">
            <div class="tile-stats tile-white-aqua">
                <div class="icon"><i class="fa fa-user" style="color:#00c0ef"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('hr'); ?>" 
                     data-duration="1500" data-delay="0"><?php echo $this->db->count_all('hr'); ?></div>
                <h3><?php echo get_phrase('Hr') ?></h3>
            </div>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="<?php echo site_url('admin/accountant'); ?>">
            <div class="tile-stats tile-white-purple">
                <div class="icon"><i class="fa fa-user" style="color:#ba79cb"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('accountant'); ?>" 
                     data-duration="1500" data-delay="0"><?php echo $this->db->count_all('accountant'); ?></div>
                <h3><?php echo get_phrase('accountant') ?></h3>
            </div>
        </a>
    </div>
  
</div>

<br />

<div class="row">
 

<div class="col-sm-3">
        <a href="<?php echo site_url('admin/receptionist'); ?>">
            <div class="tile-stats tile-white-blue">
                <div class="icon"><i class="fa fa-user" style="color:#0073b7"></i></div>
                <div class="num" data-start="0" data-end="<?php echo $this->db->count_all('receptionist'); ?>" 
                     data-duration="1500" data-delay="0"><?php echo $this->db->count_all('receptionist'); ?></div>
                <h3><?php echo get_phrase('receptionist') ?></h3>
            </div>
        </a>
    </div>
<div class="col-sm-3">
    <a href="<?php echo site_url('admin/today_visit'); ?>">
        <div class="tile-stats tile-white-pink">
            <div class="icon"><i class="fa fa-calendar" style="color:#ec3b83"></i></div>
            <?php
            $date = date('d-m-Y');
            $this->db->where('date', $date);
            $countp = $this->db->count_all_results('patient_consultation_history');
            ?>
            <div class="num" data-start="0" data-end="<?php echo $countp; ?>" data-duration="1500" data-delay="0"><?php echo $countp; ?></div>
            <h3><?php echo get_phrase('today_visit'); ?></h3>
        </div>
    </a>
</div>
  
</div>-->

<br />


<div class="container">
    <div class="row">
        
         <div class="col-sm-6">
             
<h4>Today Patient Visits and Registrations</h4>
<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>            
            <th><?php echo get_phrase('Patient Id');?></th>
            <th><?php echo get_phrase('name');?></th>
            <th><?php echo get_phrase('referred_by');?></th>
            <th><?php echo get_phrase('visit_type');?></th>     
             <th><?php echo get_phrase('patent_type');?></th>          
                                 
        </tr>
    </thead>

    <tbody>
        <?php foreach ($patient_consultation_history_info as $row) {             
        $currentDate = date('d-m-Y');        
        if ($row['date'] == $currentDate) { ?>
            <tr>
                <td><?php echo $row['patient_code']?></td>
                <td><?php echo $row['patient_name']?></td>
                <td><?php echo $row['referred_by']?></td>
                 <td>
                        <?php if ($row['visit_type'] == 'appointment') { ?>
                            <span class="badge label-info"><?php echo $row['visit_type']?></span>
                        <?php } else if ($row['visit_type'] == 'walk-in') { ?>
                            <span class="badge label-danger"><?php echo $row['visit_type']?></span>
                        <?php } ?>
                    </td>           
                    
                     <td> <?php if ($row['patient_status'] == 'new') { ?>
        <span class="badge label-success">New Patient</span>
    <?php } elseif ($row['patient_status'] == 'existing') { ?>
        <span class="badge label-primary">Existing Patient</span>
    <?php } ?></td>
                           
            </tr>
        <?php
        }
     } ?>
    </tbody>
</table>
             </div>
        <div class="col-sm-6 ">
             <div class="card">
              <div class="card-header">Today Patient Visit Type</div>
                <div class="card-body">
<figure class="highcharts-figure">
    
     <?php
$date = date('d-m-Y');
$totalAppointments = $this->db->where('visit_type', 'appointment')
    ->where('date', $date)
    ->count_all_results('patient_consultation_history');

$totalWalkIns = $this->db->where('visit_type', 'walk-in')
    ->where('date', $date)
    ->count_all_results('patient_consultation_history');

$dataAvailable = ($totalAppointments + $totalWalkIns) > 0;
?>


 <?php if (!$dataAvailable){ ?>      
                          <p style="color: red; font-weight: bold;">Data not available!!!</p>
      
                
                
                <?php } else { ?>
                
                <div id="container"></div>
                
                
                
                  <?php }  ?>
   
   
</figure></div>

  </div>
            </div>


</div>








</div>    
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">Today's Income VS Expense</div>
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <?php
$datep = date('Y-m-d');
$this->db->select_sum('amount', 'total_amount');
$this->db->where('date', $datep);
$query_income = $this->db->get('income');
if ($query_income->num_rows() > 0) {
    $row = $query_income->row();
    $totalAmount_income = $row->total_amount;
} else {
    $totalAmount_income = 0;
}

$this->db->select_sum('amount', 'total_amount');
$this->db->where('date', $datep);
$query_expense = $this->db->get('expense');
if ($query_expense->num_rows() > 0) {
    $row = $query_expense->row();
    $totalAmount_expense = $row->total_amount;
} else {
    $totalAmount_expense = 0;
}

                        if ($totalAmount_income == 0 && $totalAmount_expense == 0) {
      echo '<p style="color: red; font-weight: bold;">Sorry, No Data Available For Today!!!</p>';
  
} else { ?>
                        <div id="container2"></div>
                        
                        
                      <?php } ?>  
                        
                    </figure>
                </div>
            </div>
        </div>
        
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">Monthly Income VS Expense</div>
                <div class="card-body">
            <figure class="highcharts-figure">
                
                <?php
$currentYear = date('Y');
$year = $this->db->where('YEAR(date)', $currentYear)
                ->get('expense')
                ->result_array();

$expensemonthlyTotals = array_fill(0, 12, 0); // Initialize an array to store monthly totals

foreach ($year as $row) {
    $month = date('n', strtotime($row['date'])); // Extract month from date
    $amount = $row['amount']; // Get the expense amount

    $expensemonthlyTotals[$month - 1] += $amount; // Accumulate the expense amount for each month
}

$incomeyear = $this->db->where('YEAR(date)', $currentYear)
                ->get('income')
                ->result_array();

$incomemonthlyTotals = array_fill(0, 12, 0); 

foreach ($incomeyear as $row1) {
    $income_month = date('n', strtotime($row1['date'])); // Extract month from date
    $income_amount = $row1['amount']; // Get the expense amount

    $incomemonthlyTotals[$income_month - 1] += $income_amount; // Accumulate the expense amount for each month
}

$dataAvailable = false;

foreach ($expensemonthlyTotals as $expenseTotal) {
    if ($expenseTotal > 0) {
        $dataAvailable = true;
        break;
    }
}

foreach ($incomemonthlyTotals as $incomeTotal) {
    if ($incomeTotal > 0) {
        $dataAvailable = true;
        break;
    }
}
?>
          <?php if (!$dataAvailable){ ?>      
                          <p style="color: red; font-weight: bold;">Data not available!!!</p>
      
                
                
                <?php } else { ?>
                
                <div id="container3"></div>
                
                
                
                  <?php }  ?>
                
                
               
            </figure>   </div>
            </div>     
        </div> 
       
        
    </div>
</div>

<script>
  
    Highcharts.chart('container', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Today Patient Visit Type',
            align: 'left'
        },
       

        accessibility: {
            announceNewData: {
                enabled: true
            },
            point: {
                valueSuffix: '%'
            }
        },

       plotOptions: {
    series: {
        borderRadius: 5,
        dataLabels: {
            enabled: true,
            format: '{point.name}: {point.y:.0f}',
              style: {
                    fontSize: '14px' // Increase the font size here
                }
        }
    }
},
 

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
        },

        series: [
            {
                name: 'Patients',
                colorByPoint: true,
                data: [
                    {
                        name: 'Total Patient',
                        y: <?php echo $totalAppointments + $totalWalkIns; ?>,
                         color: '#66bb6a'
                    },
                    {
                        name: 'Walk-In',
                        y: <?php echo $totalWalkIns; ?>,
                        color: '#ef5350'
                    },
                    {
                        name: 'Appointment',
                        y: <?php echo $totalAppointments; ?>,
                        color: '#21a9e1'
                    }
                ]
            }
        ],

    });
</script>
<script type="text/javascript">

    jQuery(document).ready(function() {
    var $ = jQuery;

    var table = $("#table-2").DataTable({
        "sPaginationType": "bootstrap",
        "dom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'B>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Specify the column indices to include in the copy
                }
            },
            {
    extend: 'excel',
    text: 'Excel',
    exportOptions: {
        columns: [0, 1, 2, 3, 4]
    }
},          {
    extend: 'csv',
    text: 'Csv',
    exportOptions: {
        columns: [0, 1, 2, 3, 4]
    }
}
        ]
    });

    $(".dataTables_wrapper select").select2({
        minimumResultsForSearch: -1
    });

    // Highlighted rows
    $("#table-2 tbody input[type=checkbox]").each(function(i, el) {
        var $this = $(el),
            $p = $this.closest('tr');

        $(el).on('change', function() {
            var is_checked = $this.is(':checked');

            $p[is_checked ? 'addClass' : 'removeClass']('highlight');
        });
    });

    // Replace Checkboxes
    $(".pagination a").click(function(ev) {
        replaceCheckboxes();
    });

    // Manually add the Buttons to the DataTables layout
    table.buttons().container()
        .appendTo('.export-data'); // Replace '.export-data' with the appropriate selector for the container element where you want the buttons to appear
});
</script>
<script>

    Highcharts.chart('container2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
           text: 'Income VS Expense',
           align: 'center'
        },
        tooltip: {
           pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        accessibility: {
            point: {
                valueSuffix: ''
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false,
                    
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Categories',
            colorByPoint: true,
            data: [{
               name: '<span style="font-size: 12px;font-weight:bold">Income</span>',
           
             y: <?php echo $totalAmount_income; ?>,
               
                sliced: true,
                selected: true,
                 color: 'orange'
            }, {
                name: '<span style="font-size: 12px;font-weight:bold">Expense</span>',
                y: <?php echo $totalAmount_expense; ?>,
                 color: 'green'
            }]
        }]
    });
</script>
<script>

Highcharts.chart('container3', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Income & Expense'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        accessibility: {
            description: 'Months of the year'
        }
    },
    yAxis: {
        title: {
            text: 'Income & Expense'
        },
        labels: {
            format: '₹{value}'
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
              //  lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Expense',
        marker: {
            symbol: 'square'
        },
        data: <?php echo json_encode($expensemonthlyTotals); ?>,
        color:'orange'
    }, {
        name: 'Income',
        marker: {
            symbol: 'diamond'
        },
        data: <?php echo json_encode($incomemonthlyTotals); ?>,
        color:'green'
        
    }]
});
</script>
