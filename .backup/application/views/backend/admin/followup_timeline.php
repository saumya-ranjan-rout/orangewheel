<style>

@import url("https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap");

*,
*:before,
*:after {
	box-sizing: border-box;
}

:root {
	--c-grey-100: #f4f6f8;
	--c-grey-200: #e3e3e3;
	--c-grey-300: #b2b2b2;
	--c-grey-400: #7b7b7b;
	--c-grey-500: #3d3d3d;

	--c-blue-500: #688afd;
}

/* End basic CSS override */

.timeline {
	width: 85%;
	max-width: 700px;
	margin-left: auto;
	margin-right: auto;
	display: flex;
	flex-direction: column;
	padding: 32px 0 32px 32px;
	border-left: 2px solid var(--c-grey-200);
	font-size: 1.125rem;
}

.timeline-item {
	display: flex;
	gap: 24px;
	& + * {
		margin-top: 24px;
	}
	& + .extra-space {
		margin-top: 48px;
	}
}

.timeline-item-icon {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 40px;
	height: 40px;
	border-radius: 50%;
	margin-left: -52px;
	flex-shrink: 0;
	overflow: hidden;
	box-shadow: 0 0 0 6px #fff;
	svg {
		width: 20px;
		height: 20px;
	}

	&.faded-icon {
		background-color: var(--c-grey-100);
		color: var(--c-grey-400);
	}

	&.filled-icon {
		background-color: var(--c-blue-500);
		color: #fff;
	}
}

.timeline-item-description {
	display: flex;
	padding-top: 6px;
	gap: 8px;
	color: var(--c-grey-400);

	img {
		flex-shrink: 0;
	}
	a {
		color: var(--c-grey-500);
		font-weight: 500;
		text-decoration: none;
		&:hover,
		&:focus {
			outline: 0; // Don't actually do this
			color: var(--c-blue-500);
		}
	}
}

.avatar {
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 50%;
	overflow: hidden;
	aspect-ratio: 1 / 1;
	flex-shrink: 0;
	width: 40px;
	height: 40px;
	&.small {
		width: 28px;
		height: 28px;
	}

	img {
		object-fit: cover;
	}
}

.comment {
	margin-top: 12px;
	color: var(--c-grey-500);
	border: 1px solid var(--c-grey-200);
	box-shadow: 0 4px 4px 0 var(--c-grey-100);
	border-radius: 6px;
	padding: 16px;
	font-size: 1rem;
}


</style>

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-primary" data-collapsed="0">

                <div class="panel-heading">
                    <div class="panel-title">
                        <h3><?php echo get_phrase('Phone Call Log History'); ?></h3>
                    </div>
                </div>

                <div class="panel-body">

                    <ol class="timeline" id="invoice_print">

<?php
    $this->db->order_by('created_date', 'asc');
    $query = $this->db->get_where('next_followup', array('item_issue_id' => $param2))->result_array();
    if ($query) {
        foreach ($query as $row) {
?>
    <li class="timeline-item | extra-space">
        <span class="timeline-item-icon | filled-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z" />
                <path fill="currentColor" d="M6.455 19L2 22.5V4a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H6.455zM7 10v2h2v-2H7zm4 0v2h2v-2h-2zm4 0v2h2v-2h-2z" />
            </svg>
        </span>
        <div class="timeline-item-wrapper">
            <div class="timeline-item-description">
                <i class="avatar | small">
                     <img src="<?php echo $this->crud_model->get_image_url($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));?>" alt="" class="img-circle" style="height:30px;">
                </i>
                <span><?php echo $row["call_by"];?> called on <?php 
                echo $formatted_date = date("F j, Y", strtotime($row["created_date"]));
                ?> for <?php echo $row["call_duration"];?></time></span>
            </div>
            <div class="comment " >
                <p><?php echo $row["note"];?></p>
            </div>
        </div>
    </li>
<?php  
        }
    } else {
        // Display a message if no data is available
        echo "<span style='color:red;font-weight:bold'>No data available</span>";
    }
?>
</ol>
 <br>
 <?php
  if ($query) { ?>
    <a onClick="PrintElem('#invoice_print')" class="btn btn-primary hidden-print">
        <i class="fa fa-print"></i> &nbsp;
        <?php echo get_phrase('print'); ?>
    </a>
    <?php }?>

                </div>

            </div>

        </div>
    </div>


<script type="text/javascript">
    function PrintElem(elem) {
        Popup($(elem).html());
    }

  function PrintElem(elem) {
    var mywindow = window.open('', 'invoice', 'height=400,width=600');
    mywindow.document.write('<html><head><title>PHONE LOG CONVERSATION</title>');
    mywindow.document.write('<style type="text/css">');
    mywindow.document.write('@media print {');
    mywindow.document.write('.footer-image {');
    mywindow.document.write('position: fixed;');
    mywindow.document.write('bottom: 10px;');
    mywindow.document.write('left: 0;');
    mywindow.document.write('width: 100%;');
    mywindow.document.write('height: 80px;');
    mywindow.document.write('background-repeat: no-repeat;');
    mywindow.document.write('background-position: bottom left;');
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

    // Loop through each li element and print desired content
    $(elem).find('li').each(function() {
        var callBy = $(this).find('.timeline-item-description span').text();
        var note = $(this).find('.comment p').text();
        mywindow.document.write('<div class="timeline-item-description">');
        mywindow.document.write('<span>' + callBy + '</span>');
        mywindow.document.write('</div>');
        mywindow.document.write('<div class="comment">');
        mywindow.document.write('<p>' + note + '</p>');
        mywindow.document.write('</div>');
    });

    mywindow.document.write('</body></html>');

    mywindow.print();
    mywindow.close();

    return true;
}
</script>

