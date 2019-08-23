<?php
/**
 * CodeIgniter
 * @title      Preferences Controller
 * @author     Jawad Ali
 * @Date       7/09/2019
 */
class Preferences extends MY_Controller{
	// Register user
	public function __construct()
    {
    	parent::__construct();
        // Your own constructor code
        if($this->session->userdata('user_type') != 'Admin'){
        	redirect('dashboard');
        }
    }
 
	/*
	*************************************************
		DEPARTMENT FUNCTIONS STARTS
	*************************************************
	*/	
	// Show Departments
	public function department(){
		
		$data['title'] = 'Departments';	
		$data['all_departments'] = $this->user_model->all_departments();
		$this->show_view('users/department', $data);
	}
	// Create Department
	public function update_department($dept_id=0){
		
		$deptt = $dept_id; 	
		if($deptt=0 || empty($deptt)){
			$data['title'] = 'Add Department';
		}	
		else{
			$data['title'] = 'Edit Department';
		}	
		$data['get_department'] = $this->user_model->get_department_by_id($dept_id);
		$this->form_validation->set_rules('department_name', 'Department Name', 'required');

		if($this->form_validation->run() === FALSE){
			$this->show_view('users/update_department', $data);
		} else {
			$this->user_model->update_department($dept_id);

			redirect('preferences/department');
		}
	}
	// Delete Department 
	public function delete_department($dept_id){
		// Check login
		 
	$this->user_model->delete_department($dept_id);
	// Set message
	$this->session->set_flashdata('department_success_delete', 'Department has been Successfully deleted');
	redirect('preferences/department');
	}
 
	/*
	*************************************************
		DESIGNATIONS FUNCTIONS STARTS
	*************************************************
	*/
	// Show Designations
	public function designation(){
		
		$data['title'] = 'Designations';	
		$data['all_designations'] = $this->user_model->all_designations();
		$this->show_view('users/designation', $data);
	}
	// Create Designation
	public function update_designation($designation_id=0){
		
		$designationt = $designation_id; 	
		if($designationt=0 || empty($designationt)){
			$data['title'] = 'Add Designation';
		}	
		else{
			$data['title'] = 'Edit Designation';
		}	
		$data['get_designation'] = $this->user_model->get_designation_by_id($designation_id);
		$this->form_validation->set_rules('designation_name', 'Designation Name', 'required');

		if($this->form_validation->run() === FALSE){
			$this->show_view('users/update_designation', $data);
		} else {
			$this->user_model->update_designation($designation_id);

			redirect('preferences/designation');
		}
	}
	// Create Designation
	public function disableUser($id, $status){
		
		$status = $this->user_model->update_user_status($id,$status);
		if($status){
			echo "done";
		}
		
		
	}
	// Delete Designation 
	public function delete_designation($designation_id){
		// Check login
		 
	$this->user_model->delete_designation($designation_id);
	// Set message
	$this->session->set_flashdata('designation_success_delete', 'Designation has been Successfully deleted');
	redirect('preferences/desgination');
	}						
	/*
	*************************************************
		USER MANGEMENT FUNCTIONS STARTS
	*************************************************
	*/
	// Show Departments
	public function manage_users(){
		
		$data['title'] = 'Users';	
		$data['exists_department'] = $this->user_model->get_exists_department();
		$this->show_view('users/manage_users', $data);
	}
	// Create User
	public function update_manage_user($User_id=0){
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('department', 'Department', 'required');
		
		$Usert = $User_id; 	
		if($Usert=0 || empty($Usert)){
			$data['title'] = 'Add User';
		}	
		else{
			$data['title'] = 'Edit User';
		}
		$data['get_manage_user'] = $this->user_model->get_manage_user_by_id($User_id);
		$data['all_designations'] = $this->user_model->all_designations();
		$data['all_departments'] = $this->user_model->all_departments();
		$data['all_teamLead'] = $this->user_model->all_teamLead($data['get_manage_user']['department']);
		if($this->form_validation->run() === FALSE){
			$this->show_view('users/update_manage_user', $data);
		} else {
			$this->user_model->update_manage_user($User_id);
			redirect('preferences/update_manage_user/'.$User_id);
		}
	}
	public function othermembers($department)
	{
		$all_teamLead = $this->user_model->all_teamLead($department);
		$html ='';
			foreach($all_teamLead as $row){
		    	$html .='<option  value="'.$row['User_id'].'">'.$row['Firstname'].' '.$row['Lastname'].'</option>';
		    }
		echo $html;
	} 

	// Delete User 
	public function delete_manage_user($User_id){
		// Check login
		 
	$this->user_model->delete_manage_user($User_id);
	// Set message
	$this->session->set_flashdata('manage_user_success_delete', 'User has been Successfully deleted');
	redirect('preferences/manage_users');
	}		
}