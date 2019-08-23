 <style type="text/css">
 	.dash-box{
 		margin: 8px 0 24px;
 	}
 	.dash-box-body{
 		padding: 10px 5px;
 	}
 	.modal-body{
 		padding: 0px 32px;
 	}
 	.dash-alig{ 
 		text-align: center;
 	}
 	.dash-box-color-5 {
 		background: linear-gradient(to bottom, rgba(255, 86, 65, 1) 0%, rgb(0, 0, 0) 100%);
 	}
 	.count-combain{
 		line-height: 27px;
 		text-align: left;
 		display: block;
 	}
 	.dash-box-title{
 		left: 0px;
 		color: white;
    	font-weight: bold;
    	letter-spacing: normal;
	    -webkit-font-smoothing: antialiased;
	    font-family: 'Open Sans', Arial, sans-serif;
 	}
 	.dash-box-count{
 		color: white;
    	font-weight: bold;
 		position: absolute;
    	right: 10px;
 	}
 	.total{
 		border-style: groove;
    	padding: 5px;
 	}
 	.modal-loader{
 		display: none;
 		z-index: 99;
	    position: absolute;
	    left: 30%;
	    right: 0px;
 	} 
 	.rating-link:hover, .rating-link:focus {
    	text-decoration: none;
	}
 </style>
<h2><?php echo $evaluate_list[0]['dept_name']; ?></h2> 
<div class="evaluate_list">
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th>Sr #</th>
	      <th>Name</th>
	      <th>Designation</th>
	      <th>Department</th>
	      <th>Average</th> 
	      <th>Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php $i=1; foreach ($evaluate_list as $key => $value){
	  		$evltr_info = $this->rating_model->getevelter_info($value['evltr']);
	  		$member_avgrow = $this->rating_model->get_avg_by_id($value['User_id'],'Member');
	  		
	  		//echo $this->db->last_query();

	  		$hr_avgrow = $this->rating_model->get_avg_by_id($value['User_id'],'hr');
	  		$trainer_avgrow = $this->rating_model->get_avg_by_id($value['User_id'],'trainer');
	  		$SiteLead_avgrow = $this->rating_model->get_avg_by_id($value['User_id'],'SiteLead');
	  		$CEO_avgrow = $this->rating_model->get_avg_by_id($value['User_id'],'CEO');
	  		//echo $this->db->last_query();

	  		//echo $lead_avgrow->avg;
	  		$lead_avg ='';
	  		$evaluate_list_fact = $this->rating_model->evaluate_list_by_department_byId($value['User_id']);
	  		//echo $this->db->last_query();
	  		foreach ($evaluate_list_fact as $row) {
	  			if($row['factor_type'] == 'mtm' || $row['factor_type'] == 'mtl'){
	  				$lead_avgrow = $this->rating_model->get_avg_by_id($row['User_id'],'TeamLead');
		  			$lead_rating_per = (($lead_avgrow->avg / 6) * 100)/100;
		  			 $lead_avg = $lead_rating_per * 30;
		  		}else{
		  			$lead_avgrow = $this->rating_model->get_avg_by_id($row['User_id'],'TeamLead');
		  			$lead_rating_per = (($lead_avgrow->avg / 6) * 100)/100;
		  			$lead_avg = $lead_rating_per * 50;
		  		}
	  			//$factor_type[] =$row['factor_type'];
	  		}
	  	//	exit();
	  		//print_r($factor_type);

	  		


	  		$member_rating_per = (($member_avgrow->avg / 6) * 100)/100;
	  		$member_avg = $member_rating_per * 30;

	  		$hr_rating_per = (($hr_avgrow->avg / 6) * 100)/100;
	  		$hr_avg = $hr_rating_per * 10;

	  		$trainer_rating_per = (($trainer_avgrow->avg / 6) * 100)/100;
	  		$trainer_avg = $trainer_rating_per * 10;
	  		
	  		if($value['User_type'] == 'TeamLead' && $evltr_info->User_type !='TeamLead'){
		  		$SiteLead_rating_per = (($SiteLead_avgrow->avg / 6) * 100)/100;
		  		$SiteLead_avg = $SiteLead_rating_per * 50/100 ;
		  		$CEO_rating_per = (($CEO_avgrow->avg / 6) * 100)/100;
		  		$CEO_avg = $CEO_rating_per * 50/100 ;
		  		$totalrating =$SiteLead_avg + $CEO_avg;
		  		$totalAvg = (($totalrating) * 100)/2;
		  		$totalAvg = ($totalAvg)+($member_avg)+($hr_avg)+($trainer_avg);
	  		}else{
	  			$totalAvg = ($lead_avg)+($member_avg)+($hr_avg)+($trainer_avg);
	  		}
	  	?>
	  		<tr <?php if($value['User_type'] == 'TeamLead'){ echo 'style="background-color: #8c6573; color: white;"';} ?>>  			
	  			<td><?php echo $i; ?></td>
	  			<td><?php echo $value['Firstname'].' '. $value['Lastname']; ?></td>
	  			<td><?php echo $value['designation_name']; ?></td>
	  			<td><?php echo $value['dept_name']; ?></td>
	  			<td> <?php echo number_format($totalAvg,2).'%'; ?> </td> 
	  			<td> 
					<!-- <a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>evaluation/evaluate_detail/<?php echo $value['eval_id']; ?>">Details</a> -->

					<a class="btn btn-info btn-xs" href="javascript:;" onclick="detailpopup('<?php echo $value['Firstname'].' '. $value['Lastname']; ?>','<?php echo $value['User_id']; ?>','<?php echo $value['User_type']; ?>')">	Average Details</a>
			 	</td>
	  		</tr>
	  	<?php $i++; } ?>
	  </tbody>
	</table>
</div>

<script type="text/javascript"> 
function deleteConfirm(url)
 {
    if(confirm('Do you want to Delete this record ?'))
    {
        window.location.href=url;
    }
 }
</script>



<script type="text/javascript">
	function detailpopup(name,uid,designation) {

		$('.avgContent').css('opacity','0.3');
		$('.modal-loader').css('display','block');
		$('.modal-title').html(name);
		 jQuery.ajax({
          url: '<?php echo base_url() ?>evaluation/averageByQuarter/'+uid+'/'+designation,
          cache: false,
          success: function (data) {
            if(data !=''){
              	$('#myModal').modal('show');
            	$(".avgContent").html(data);
            	$('.avgContent').css('opacity','3');
              	$('.modal-loader').css('display','none');
            }
          },error: function (data){
            alert(data);
            $('.avgContent').css('opacity','3'); 
          }
      });


		
	}
</script>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
       <img class="modal-loader" src="<?php echo base_url() ?>assets/loader.gif">
    <div class="avgContent">
      
	</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>