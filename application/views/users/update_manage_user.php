<?php if($this->session->flashdata('user_manage_user_inserted')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_manage_user_inserted').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_manage_user_updated')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_manage_user_updated').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('manage_user_success_delete')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('manage_user_success_delete').'</p>'; ?>
<?php endif; ?>
<h3><?php echo $title; ?></h3>
<?php echo form_open('preferences/update_manage_user'.'/'.@$get_manage_user['User_id']); ?>
	<div class="col-md-4 col-md-offset-2">
		<div class="form-group">
			<label>Firstname:</label>
			<input type="text" class="form-control" name="firstname" placeholder="FirstName" value="<?php echo @$get_manage_user['Firstname']; ?>" required>
		</div>	
	</div>	
	<div class="col-md-4 ">
		<div class="form-group">
			<label>Lastname</label>
			<input type="text" class="form-control" name="lastname" placeholder="LastName" value="<?php echo @$get_manage_user['Lastname']; ?>" required>
		</div>
	</div>
		
	<div class="col-md-8 col-md-offset-2">
	<div class="form-group">
		<label>Email</label>
		<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo @$get_manage_user['Email']; ?>" required>
	</div>
	<?php //if(empty(@$get_manage_user['Password'])){?>	
		<div class="form-group">
			<label>Password</label>
			<input type="text" class="form-control" value="<?php if(isset($get_manage_user['PasswordView'])){ echo $get_manage_user['PasswordView']; }else{ echo (rand(1, 1000000)); } ?>" name="password" placeholder="Password" required>
		</div>
		<!-- <div class="form-group">
			<label>Confirm Password</label>
			<input type="text" class="form-control" name="password2" placeholder="Confirm Password">
		</div> -->
	<?php //} ?>
	<div class="form-group">
		<label>Joining Date</label>
		<input type="text" class="form-control datepicker" autocomplete="off" name="Joining_date" placeholder="Joining Date" value="<?php echo @$get_manage_user['Joining_date']; ?>" required>
	</div>
	<div class="form-group">
		<label>Department</label>
		<select class="form-control departmentsel" name="department" id="department" required="">
		    <option value="">Select Department</option>
		    <?php foreach($all_departments as $kk=>$vv){ ?>
		    <option <?php if($get_manage_user['department']==$vv['dept_id']){echo 'Selected="Selected"';}  ?>  value="<?php echo $vv['dept_id']; ?>"><?php echo $vv['dept_name']; ?></option>
		    <?php } ?>
		</select>
	</div>
	<div class="form-group">
		<label>Designation</label>
		<select class="form-control" name="designation" id="designation" onchange="team_leads(this.value)">
			    <option value="">Select Designation</option>
			    <?php foreach($all_designations as $kk=>$vv){ ?>
			    <option <?php if($get_manage_user['Designation']==$vv['designation_id']){echo 'Selected="Selected"';}  ?>  value="<?php echo $vv['designation_id']; ?>"><?php echo $vv['designation_name']; ?></option>
			    <?php } ?>
			</select>
		<!-- <input type="text" class="form-control" name="designation" value="<?php echo @$get_manage_user['designation_name']; ?>" placeholder="Designation" required> -->
	</div>
	<div class="form-group">
		<label>TeamLead</label>
		<input type="text" class="form-control team_lead" name="team_lead" placeholder="TeamLead" value="<?php echo @$get_manage_user['Team_lead']; ?>" required>
	</div>
	<div class="form-group">
		<label>User Type</label>
		<select name="user_type" id="user_type" class="form-control" onchange="load_leads(this.value)" required>
			<option value="">Please Select</option>
			<!-- <option <?php if(@$get_manage_user['User_type']=='Admin'){echo 'selected="selected"'; } ?> value="Admin">Admin</option> -->
			<option <?php if(@$get_manage_user['User_type']=='Member'){echo 'selected="selected"'; } ?> value="Member">Member</option>
			<option <?php if(@$get_manage_user['User_type']=='TeamLead'){echo 'selected="selected"'; } ?> value="TeamLead">TeamLead</option>
			<option <?php if(@$get_manage_user['User_type']=='hr'){echo 'selected="selected"'; } ?> value="hr">HR</option>
			<option <?php if(@$get_manage_user['User_type']=='trainer'){echo 'selected="selected"'; } ?> value="trainer">Trainer</option>
			<option <?php if(@$get_manage_user['User_type']=='SiteLead'){echo 'selected="selected"'; } ?> value="SiteLead">Site Lead</option>
			<option <?php if(@$get_manage_user['User_type']=='CEO'){echo 'selected="selected"'; } ?> value="CEO">CEO</option>
		</select>
	</div>
	<?php if(@$get_manage_user['User_type'] !=''){ ?>
		<div class="form-group " id="teamleadss">
			<label>Assign Other Members</label>
			<select class="js-example-basic-multiple form-control" name="assign_team_leads[]" multiple="multiple">
			  <?php foreach($all_teamLead as $row){ ?>
		    <option <?php if(in_array($row['User_id'], json_decode($get_manage_user['assign_team_leads']))){ echo 'selected'; } ?>  value="<?php echo $row['User_id']; ?>"><?php echo $row['Firstname'].' '.$row['Lastname']; ?></option>
		    <?php } ?>
			</select>
		</div>
	<?php }else{ ?> 
		<div class="form-group " id="teamleadss" style="visibility: hidden;">
			<label>Assign Other Members</label>
			<select class="js-example-basic-multiple form-control othermembers" name="assign_team_leads[]" multiple="multiple">
			</select>
		</div> 
		<!-- <div class="form-group " id="teamleadss" style="visibility: hidden;">
			<label>Assign Other Members</label>
			<select class="js-example-basic-multiple form-control" name="assign_team_leads[]" multiple="multiple">
			  <?php foreach($all_teamLead as $row){ ?>
		    <option  value="<?php echo $row['User_id']; ?>"><?php echo $row['Firstname'].' '.$row['Lastname']; ?></option>
		    <?php } ?>
			</select>
		</div> -->
	<?php } ?>


	<input type="hidden" name="manage_user_added_by" value="<?php echo $this->session->userdata('user_id'); ?>" >
	<button type="submit" class="btn btn-primary"><?php if(empty($get_manage_user)){ echo 'Add';}else{echo 'Update';} ?></button>
</div>		
<?php echo form_close(); ?>

<script type="text/javascript">
	function team_leads(val) {
		if(val == '2'){
			$('.team_lead').val('CEO');
			$('.team_lead').attr('readonly',true);
		}else{
			$('.team_lead').val('');
			$('.team_lead').attr('readonly',false);
		}
	}
	function load_leads(type) {
		//alert(type);
		//if(type == 'TeamLead'){
			$('#teamleadss').css('visibility','');
			// var dataString = 'department='+ $('department').val();
			//alert (dataString);return false;
			$.ajax({
			type: "POST",
			url: "<?php echo base_url() ?>preferences/othermembers/"+ $('.departmentsel').val(),
			data: '',
			success: function(data) {
			   $('.othermembers').html(data);
			}
			});
			return false;
		// }else{
		// 	$('#teamleadss').css('visibility','hidden');
		// }
	}
</script>