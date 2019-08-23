 <style type="text/css">
 	.radiobut{
 		pointer-events: none;
   		cursor: default;
 	}
 </style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="dashboard">

    <div class="row">

        <div class="col-md-12">
        		<!-- <button class="btn btn-success"><i class="fa fa-arrow-left"></i> Back</button>
        		<br><br> -->
            <ul class="dashboard-tabs">
            <?php 
            $i =0;
            foreach ($all_colleagues as $row) { ?>
                <li class="<?php if($i == '0'){ ?>active <?php } ?>">
                    <a href="#tabs<?php echo $i; ?>" class="btn" aria-controls="tabs<?php echo $i; ?>" role="tab" data-toggle="tab">
                        <span class="fa fa-user"></span>
                        <h4><?php echo $row['Firstname']; ?></h4>
                    </a>
                </li> 
            <?php $i++; } ?>
            </ul>
        </div>
        <div class="tab-content col-md-12">
        	<?php 
            $j =0;
            foreach ($all_colleagues as $row) { ?>
            <div role="tabpanel" class="tab-pane <?php if($j == '0'){ ?>active <?php } ?>" id="tabs<?php echo $j; ?>">
               <!-- 	 <div class="row">
	<div class="col-md-12 text-center">
		<h2><?php echo $title; ?></h2>		
	</div>
</div> -->
<div class="user-info">
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_name" class="form-control col-form-label" >Name:</label>
		</div> 
		
		<div class="col-md-10">
 
			<input type="text" readonly="" name="" class="form-control" placeholder="Member Name" value="<?php echo $row['Firstname']." ".$row['Lastname']; ?>" >
			 

		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_designation" class="form-control col-form-label" >Designation:</label>
		</div>
		<div class="col-md-4">
			<input type="text" readonly="" name="" class="form-control" placeholder="Designation" value="<?php echo $row['designation_name']; ?>" >
			 
		</div>
		<div class="col-md-2">
			<label for="user_department" class="form-control col-form-label" >Department:</label>
		</div>
		<div class="col-md-4">
			<input type="text" readonly="" name="" class="form-control" placeholder="Department" value="<?php echo $row['dept_name']; ?>" >
			 
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_lead" class="form-control col-form-label" >Team Lead/Supervisor:</label>
		</div>
		<div class="col-md-4">
			<input type="text" readonly="" name="" class="form-control" placeholder="Team Lead/Supervisor" value="<?php echo $row['Team_lead']; ?>" >
			  
		</div>
		<div class="col-md-2">
			<label for="evaluation_date" class="form-control col-form-label" >Date:</label>
		</div>
		<div class="col-md-4">
			<input readonly="" type="text" name="evaluation_date" class="form-control datepicker" placeholder="Enter Date" value="<?php echo @$row['created_date']; ?>" required >
		</div>
		 
	</div>
	 

</div>
<table class="table table-bordered table-inverse factors-table">
	  <thead>
	    <tr>
	      <th>Sr.#</th>
	      <th colspan="7">Evaluation Factors</th>
	      <th>Remarks</th>	      
	    </tr>
	  </thead>
	  <tbody> 
	  	<?php
	 
	  	$selected_factors_list = $this->rating_model->view_submited_factors($row['eval_id'],$row['user_id'],$this->uri->segment('4'));
	  	$l=1; foreach ($selected_factors_list as $key => $value): ?>
	  		<?php @$rating_number = $value['rating_number'];  $active_class ='active'; ?>
	  		<tr>
	  			<td><?php echo $l; ?></td>
	  			
			<input type="hidden" name="count_fac[]" value="<?php echo $l; ?>">
			<td colspan  ="7" >
	  		<div class="question-wrapper set1">
                <div class="statement">
                    <?php echo '<b>'.$value['name'].' : </b>'.$value['description']; ?>
                </div>
                <div class="row decision">
                    <div class="hidden-xs col-sm-3 caption left">Superb</div>
                    <div class="col-xs-12 col-sm-6 options btn-group" data-toggle="buttons" role="group" aria-label="Options">
                        <input type="hidden" name="mtl_rating_<?php echo $l; ?>" value="<?php echo @$value['rating_id'] ?>" autocomplete="off">
                        <label  class="btn btn-default radiobut option agree max <?php if(@$rating_number== 6){echo $active_class;} ?>"  data-toggle="tooltip" title="Superb">
                            <input disabled required="" alt="superb" type="radio" name="btn_radio_rating<?php echo $l; ?>" value="6" <?php echo  set_radio('btn_radio_rating'.$l, '6', @$value['rating_number'] == '6' ); ?> autocomplete="off">  
                        </label>
                        <label class="btn btn-default radiobut option agree med <?php if(@$rating_number== 5){echo $active_class;} ?>" data-toggle="tooltip" title="Great">
                            <input disabled type="radio"  required="" name="btn_radio_rating<?php echo $l; ?>" value="5" <?php echo  set_radio('btn_radio_rating'.$l, '5', @$value['rating_number'] == '5' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default radiobut option agree min <?php if(@$rating_number== 4){echo $active_class;} ?>" data-toggle="tooltip" title="Good" >
                            <input disabled type="radio"  required="" name="btn_radio_rating<?php echo $l; ?>" value="4" <?php echo  set_radio('btn_radio_rating'.$l, '4', @$value['rating_number'] == '4' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default radiobut option agree minn <?php if(@$rating_number== 3){echo $active_class;} ?>" data-toggle="tooltip" title="Needs Improvement" >
                            <input disabled type="radio"  required="" name="btn_radio_rating<?php echo $l; ?>" value="3" <?php echo  set_radio('btn_radio_rating'.$l, '3', @$value['rating_number'] == '3' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default radiobut option disagree minus <?php if(@$rating_number== 2){echo $active_class;} ?>" data-toggle="tooltip" title="Failing" >
                            <input disabled type="radio"  required="" name="btn_radio_rating<?php echo $l; ?>" value="2" <?php echo  set_radio('btn_radio_rating'.$l, '2', @$value['rating_number'] == '2' ); ?> autocomplete="off">
                        </label>
                       
                    </div>
                    <div class="hidden-xs col-sm-3 caption right">Failing</div>
                </div>
                <div class="row decision mobile visible-xs">
                    <div class="col-xs-6 caption left">Superb</div>
                    <div class="col-xs-6 caption right">Failing</div>
                </div>
            </div>
			<input type="hidden" name="eval_fact_id<?php echo $l; ?>" value="<?php echo $value['fac_id']; ?>">
	  		</td>
					

  			<td><textarea disabled class="evaluate_remarks_text" name="remarks<?php echo $l; ?>" id="remarks<?php echo $l; ?>" cols="28" rows="5"><?php echo @$value['rating_remarks'] ?></textarea></td>
  			<input type="hidden" name="mtl_id" value="<?php echo @$value['mtl_id'] ?>">

	  		</tr>
	  	<?php $l++; endforeach ?>
	  </tbody>
	</table>
	<div class="form-group row evaluate-recommendations">
		<div class="col-md-12 text-center">
			<label for="recommendations" class="form-control col-form-label" >Recommendations:</label>
			<textarea class="form-control" name="evaluate_recommendation" id="evaluate_recommendation" cols="30" rows="10" disabled><?php echo @$row['recommendations']; ?></textarea>
		</div>
	</div>
<div class="overall-rating">
	<label class="custom-control custom-radio" >
	  	<!-- <input id="radio1" name="overall_rating" type="radio" value="(05-06)" class="custom-control-input" <?php echo  set_radio('overall_rating', '(05-06)', @$value['mtl_overall_rating'] == '(05-06)' ); ?>  required> -->
	  	<span class="custom-control-indicator">Superb</span><span class="number">(05-06)</span>
	  	<span class="custom-control-description">Employee is working superb and extraordinary expectations</span>
	</label>
	<br>
	<label class="custom-control custom-radio">
	  	<!-- <input id="radio1" name="overall_rating" type="radio" value="(04-05)" class="custom-control-input" <?php echo  set_radio('overall_rating', '(04-05)', @$value['mtl_overall_rating'] == '(04-05)' ); ?> > -->
	  	<span class="custom-control-indicator">Great</span><span class="number">(04-05)</span>
	  	<span class="custom-control-description">Employee is working great and above the expectations</span>
	</label>
	<br>
	<label class="custom-control custom-radio">
	  	<!-- <input id="radio1" name="overall_rating" type="radio" value="(03-04)" class="custom-control-input" <?php echo  set_radio('btn_radio_rating', '(03-04)', @$value['mtl_overall_rating'] == '(03-04)' ); ?>> -->
	  	<span class="custom-control-indicator">Good</span><span class="number">(03-04)</span>
	  	<span class="custom-control-description">Employee is working good and meeting the expectations</span>
	</label>
	<br>
	<label class="custom-control custom-radio">
	  	<!-- <input id="radio1" name="overall_rating" type="radio" value="(02-03)" class="custom-control-input" <?php echo  set_radio('btn_radio_rating', '(02-03)', @$value['mtl_overall_rating'] == '(02-03)' ); ?>> -->
	  	<span class="custom-control-indicator">Need Improvement</span><span class="number">(02-03)</span>
	  	<span class="custom-control-description">Employee is working below the expecations and needs little improvement</span>
	</label>
	<br>
	<label class="custom-control custom-radio">
	  	<!-- <input id="radio1" name="overall_rating" type="radio" value="(01-02)" class="custom-control-input" <?php echo  set_radio('btn_radio_rating', '(01-02)', @$value['mtl_overall_rating'] == '(01-02)' ); ?>> -->
	  	<span class="custom-control-indicator">Failing</span><span class="number">(01-02)</span>
	  	<span class="custom-control-description">Employee is working below the expecations and needs strong improvement</span>
	</label>
</div>
 
            </div>
            <?php $j++; } ?>
        </div>
    </div>
</div>




 
<script>
	$(function(){
		$(".btn_radio_rating1").prop("disabled", false);
	});
</script>