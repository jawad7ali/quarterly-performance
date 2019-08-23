<style type="text/css">
	.decision .options .option.agree {
    	border: 4px solid #4C9070 !important;
	}
	.decision .options .option.disagree {
	    border: 4px solid #F44336 !important;;
	}
</style>
<?php
if($user_capability == false){ ?>
<div class="row">
	<div class="col-md-12 text-center">
		<br>
		<h2>You are not allowed for evaluation please contact HR.</h2>
		<br>
		<br>
		<img src="assets/error.gif">
	</div>
</div>
<?php }else{
if(empty($dep_member) && $backid->user_id == ''){ ?>
<div class="row">
	<div class="col-md-12 text-center">
		<h2><?php echo $title; ?></h2>

	</div>
</div>
<?php }elseif(empty($dep_member) && $backid->user_id != ''){ ?>
<div class="row">
	<div class="col-md-12 text-center">
		<?php if($this->session->flashdata('evaluate_success') !=''){
			echo '<h2>'.$this->session->flashdata('evaluate_success').'</h2>';
			echo '<br><br>
			<img src="assets/happy-boss-008-512.png" height="300px">';
		 }else{ ?>
		 	<br>
			<h2>You have already submitted evaluation please contact HR if you have any query.  </h2>
			<br><br>
			<img src="assets/submitted.png">
		<?php } ?>
	</div>
</div>

<?php }else{ ?>
<?php echo form_open('dashboard/evaluate_submit'); ?>

<?php if($this->uri->segment('3') !=''){ ?> 
	<input type="hidden" name="post_type" value="update">
<?php }else{ ?>
<input type="hidden" name="post_type" value="insert">
<?php } ?>
<!-- <div class="row">
	<div class="col-md-12 text-center">
		<div class="form-group row">
			 
			<div class="col-md-4">
				<select class="form-control" name="" onchange="members_byDepartment(this.value)">
					<option value="">Select Department</option>
					<?php foreach ($all_departments as $row) { ?>
						<option value="<?php echo $row['id'] ?>"><?php echo $row['dept_name'] ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4">
				<select class="form-control" name="">
					<option value="">Select Members</option>
				</select>
			</div>
			<div class="col-md-4">
				<button class="btn btn-success" style="padding: 10px 136px;">Filter</button>
			</div>
			<br><br><br><br>
		</div>
	</div>
</div> -->
<div class="row">
	<div class="col-md-12 text-center">
		<h2><?php echo $title; ?></h2>		
	</div>
</div>
<div class="user-info">
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_name" class="form-control col-form-label" >Name:</label>
		</div>
		<?php 
		 $evaluated_user_id =@$selected_factors_list[0]['mtl_name']; 
		?>
		
		<div class="col-md-10">

			<input type="hidden" name="evaluate_user" value="<?php echo $dep_member['User_id']; ?>">
			<input type="text" readonly="" name="" class="form-control" placeholder="Member Name" value="<?php echo $dep_member['Firstname']." ".$dep_member['Lastname']; ?>" >
		 
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_designation" class="form-control col-form-label" >Designation:</label>
		</div>
		<div class="col-md-4">
			<input type="text" readonly="" name="" class="form-control" placeholder="Designation" value="<?php echo $dep_member['designation_name']; ?>" > 
		</div>
		<div class="col-md-2">
			<label for="user_department" class="form-control col-form-label" >Department:</label>
		</div>
		<div class="col-md-4">
			<input type="text" readonly="" name="" class="form-control" placeholder="Department" value="<?php echo $dep_member['dept_name']; ?>" >
			 
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2">
			<label for="user_lead" class="form-control col-form-label" >Team Lead/Supervisor:</label>
		</div>
		<div class="col-md-4">
			<input type="text" readonly="" name="" class="form-control" placeholder="Team Lead/Supervisor" value="<?php echo $dep_member['Team_lead']; ?>" >
			 
		</div>
		<div class="col-md-2">
			<label for="evaluation_date" class="form-control col-form-label" >Date:</label>
		</div>
		<div class="col-md-4">
			<input readonly="" type="text" name="evaluation_date" class="form-control datepicker" placeholder="Enter Date" value="<?php echo date('Y-m-d'); ?>" value="<?php echo @$selected_factors_list[0]['mtl_date']; ?>" required >
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
	      

	      
	      
	  		<?php $i=1; foreach ($selected_factors_list as $key => $value): ?>
	  		<?php @$mtl_rating_number = $value['rating_number'];  $active_class ='active'; ?>
	  		<tr>
	  			<td><?php echo $i; ?></td>
	  			
			<input type="hidden" name="count_fac[]" value="<?php echo $i; ?>">
			<td colspan  ="7" >
	  		<div class="question-wrapper set1">
                <div class="statement">
                    <?php echo '<b>'.$value['name'].' : </b>'.$value['description']; ?>
                </div>
                <div class="row decision">
                    <div class="hidden-xs col-sm-3 caption left">Superb</div>
                    <div class="col-xs-12 col-sm-6 options btn-group" data-toggle="buttons" role="group" aria-label="Options">
                        <input type="hidden" name="mtl_rating_<?php echo $i; ?>" value="<?php echo @$value['rating_id'] ?>" autocomplete="off">
                        <label  class="btn btn-default option agree max <?php if(@$mtl_rating_number== 6){echo $active_class;} ?>"  data-toggle="tooltip" title="Superb">
                            <input required="" alt="superb" type="radio" name="btn_radio_rating<?php echo $i; ?>" value="6" <?php echo  set_radio('btn_radio_rating'.$i, '6', @$value['rating_number'] == '6' ); ?> autocomplete="off">  
                        </label>
                        <label class="btn btn-default option agree med <?php if(@$mtl_rating_number== 5){echo $active_class;} ?>" data-toggle="tooltip" title="Great">
                            <input type="radio"  required="" name="btn_radio_rating<?php echo $i; ?>" value="5" <?php echo  set_radio('btn_radio_rating'.$i, '5', @$value['rating_number'] == '5' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option agree min <?php if(@$mtl_rating_number== 4){echo $active_class;} ?>" data-toggle="tooltip" title="Good" >
                            <input type="radio"  required="" name="btn_radio_rating<?php echo $i; ?>" value="4" <?php echo  set_radio('btn_radio_rating'.$i, '4', @$value['rating_number'] == '4' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option agree minn <?php if(@$mtl_rating_number== 3){echo $active_class;} ?>" data-toggle="tooltip" title="Needs Improvement" >
                            <input type="radio"  required="" name="btn_radio_rating<?php echo $i; ?>" value="3" <?php echo  set_radio('btn_radio_rating'.$i, '3', @$value['rating_number'] == '3' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option disagree minus <?php if(@$mtl_rating_number== 2){echo $active_class;} ?>" data-toggle="tooltip" title="Failing" >
                            <input type="radio"  required="" name="btn_radio_rating<?php echo $i; ?>" value="2" <?php echo  set_radio('btn_radio_rating'.$i, '2', @$value['rating_number'] == '2' ); ?> autocomplete="off">
                        </label>
                       
                    </div>
                    <div class="hidden-xs col-sm-3 caption right">Failing</div>
                </div>
                <div class="row decision mobile visible-xs">
                    <div class="col-xs-6 caption left">Superb</div>
                    <div class="col-xs-6 caption right">Failing</div>
                </div>
            </div>
			<input type="hidden" name="eval_fact_id<?php echo $i; ?>" value="<?php echo $value['fac_id']; ?>">
	  		</td>
					

  			<td><textarea autofocus class="evaluate_remarks_text" name="remarks<?php echo $i; ?>" id="remarks<?php echo $i; ?>" cols="28" rows="5"><?php echo @$value['rating_remarks'] ?></textarea></td>
  			<input type="hidden" name="mtl_id" value="<?php echo @$value['eval_id'] ?>">

	  		</tr>
	  	<?php $i++; endforeach ?>
	  </tbody>
	</table>
	<div class="form-group row evaluate-recommendations">
		<div class="col-md-12 text-center">
			<label for="recommendations" class="form-control col-form-label" >Recommendations:</label>
			<textarea class="form-control" name="evaluate_recommendation" id="evaluate_recommendation" cols="30" rows="10" autofocus><?php echo @$selected_factors_list[0]['recommendations']; ?></textarea>
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

	<?php 
	$existids = $this->rating_model->evalute_user_ids($curentQuarter);
	$comapre = $this->rating_model->evalute_user_last($existids->ids);
//	echo count($comapre);
	if(count($comapre) == '1'){ ?>
		
		<button type="button" data-toggle="modal" data-target="#myModal" style="float:right;" class="btn btn-success">Finish</button>

	<?php
	}else{

		if($eval_id !=''){
			$nextid = $this->rating_model->eval_by_user_id_nxt('',$eval_id);
	?>
			<input type="hidden" name="next" value="<?php echo $nextid->id; ?>">
	<?php } ?>
			<button type="submit" style="float:right;" class="btn btn-success">Next</button>

	<?php if($first->id <= $this->uri->segment('3') && $this->uri->segment('3') !='' && $backid->id !=''){ ?>
			<!-- <a href="<?php echo base_url() ?>dashboard/index/<?php echo $backid->id ?>" style="float:right; margin: 0px 8px;" class="btn btn-primary">Back</a> -->
	<?php }elseif ( $this->uri->segment('3') =='' && $backid->id !='') { ?>
		<!--  <a href="<?php echo base_url() ?>dashboard/index/<?php echo $backid->id ?>" style="float:right; margin: 0px 8px;" class="btn btn-primary">Back</a> -->
	<?php } } ?> 


<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Confirm</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          If you submit this form you will no longer access of "<?php echo $curentQuarter.' Quarter Of '.date('Y') ?>" so please make sure you fill all forms correctly. 
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" name="submit" value="final" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
        
      </div>
    </div>
</div>

	<?php  echo form_close(); ?>	

<?php } } ?>
</div>
<!-- <script type="text/javascript">
	function members_byDepartment(id) {
		
	}
</script> -->