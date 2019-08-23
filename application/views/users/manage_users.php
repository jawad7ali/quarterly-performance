<?php if($this->session->flashdata('user_manage_user_inserted')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_manage_user_inserted').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_manage_user_updated')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_manage_user_updated').'</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('manage_user_success_delete')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('manage_user_success_delete').'</p>'; ?>
<?php endif; ?>
<h1><?php echo $title; ?></h1>
<a class="btn btn-primary btn-md" style="float:right;" href="<?php echo base_url(); ?>preferences/update_manage_user">Add User</a>
<?php if(!empty($exists_department)){ ?>
<table class="table table-inverse">
	<thead>
		<tr>
			<th>Sr.#</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Designation</th>
			<th>Team Lead</th>
			<th>User Type</th>
			<th>Actions</th>
		</tr>
	</thead>
	
		<?php foreach (@$exists_department as $row){
		?>
		<tbody style="border: 2px solid ghostwhite;">
		<tr>
			<td colspan="7"><h4><?php echo $row['dept_name']; ?></h4></td>
		</tr>


		<?php 
		$all_manage_users = $this->user_model->all_manage_users($row['department']);
		$i=1;
		foreach (@$all_manage_users as $key => $value): 
			if($value['User_type'] !='Admin'){
		?>
		 
			<tr>

				<td><?php echo $i; ?></td>
				<td><?php echo @$value['Firstname'].' '.@$value['Lastname']; ?></td>
				<td><?php echo @$value['Email']; ?></td>
				<td><?php echo @$value['designation_name']; ?></td>
				<td><?php echo @$value['Team_lead']; ?></td>
				<td><?php echo @$value['User_type']; ?></td>
				<td><a class="btn btn-info btn-xs" href="<?php echo base_url('preferences/update_manage_user'.'/'.@$value['User_id']); ?>">Edit</a> 
				<?php if(@$value['status'] == 'Disable'){ ?>
					<a class="btn btn-success btn-xs disablebutton<?php echo @$value['User_id'];?>" onclick="javascript:disableConfirm('<?php echo @$value['User_id'];?>','<?php echo @$value['status'];?>');" href="#">Enable</a> 
				<?php }else{ ?>
					<span class="statusbutton<?php echo @$value['User_id'];?>">
						<a class="btn btn-warning btn-xs disablebutton<?php echo @$value['User_id'];?>" onclick="javascript:disableConfirm('<?php echo @$value['User_id'];?>','<?php echo @$value['status'];?>');" href="javascript:;">Disable</a> 
					</span>
					
				<?php } ?>
					<a class="btn btn-danger btn-xs" onclick="javascript:deleteConfirm('<?php echo base_url().'preferences/delete_manage_user/'.@$value['User_id'];?>');" href="#">Delete</a></td>	
			</tr>
		</div>
		<?php $i++; }  endforeach ?>
		</tbody>
		<?php } ?>


	
</table>		

<script type="text/javascript"> 
function deleteConfirm(url)
 {
    if(confirm('Do you want to Delete this record ?'))
    {
        window.location.href=url;
    }
 }
function disableConfirm(id,status)
 {
 	if(status == 'Enable'){
 		var actionStatus ='Disable';
 	}else{
 		var actionStatus ='Enable';
 	}
    if(confirm('Do you want to '+actionStatus+' this record ?'))
    {
    	
    	jQuery.ajax({
          url: '<?php echo base_url() ?>preferences/disableUser/'+id+'/'+actionStatus,
          cache: false,
          success: function (data) {
            if(data =='done'){
            		if(status == 'Enable'){
        //     		jQuery(".disablebutton"+id).removeClass('btn-warning');
			    	// jQuery(".disablebutton"+id).addClass('btn-success');
			    	// jQuery(".disablebutton"+id).html('Enable');
			    	jQuery(".statusbutton"+id).html(`<a class="btn btn-success btn-xs disablebutton`+id+`" onclick="javascript:disableConfirm('`+id+`','Disable');" href="javascript:;">`+status+`</a> `);
            	}else{
        //     		jQuery(".disablebutton"+id).removeClass('btn-success');
			    	// jQuery(".disablebutton"+id).addClass('btn-warning');
			    	// jQuery(".disablebutton"+id).html('Disable');

			    	jQuery(".statusbutton"+id).html(`<a class="btn btn-warning btn-xs disablebutton`+id+`" onclick="javascript:disableConfirm('`+id+`','Enable');" href="javascript:;">`+status+`</a> `);
            	}
              	
            }
          },error: function (data){
            alert(data);
          }
      });

       // window.location.href=url;
    }
 }
</script>
<?php } else{ ?>
<h3>There are no Designations. Please Add the Designation</h3>
<?php } ?>