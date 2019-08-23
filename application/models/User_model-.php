<?php
class User_model extends CI_Model{
	// Show All qpe_Departments
	public function all_departments_for_dashboard(){
		$query = $this->db->query("SELECT qpe_departments.dept_id as id,qpe_departments.dept_name,COUNT(qpe_user.User_id) AS total,GROUP_CONCAT(qpe_user.User_id SEPARATOR ',') as member_ids  FROM qpe_departments LEFT JOIN qpe_user ON qpe_departments.dept_id = qpe_user.department where (qpe_user.User_type='Member' or qpe_user.User_type='TeamLead') GROUP BY qpe_departments.dept_id ");
		if($query->result_array()){
			return $query->result_array();
		}
		else{
			return $query->result_array();	
		}			
	}
	// Show All qpe_Departments
	public function all_departments(){
		$query = $this->db->get('qpe_departments');
		if($query->result_array()){
			return $query->result_array();
		}
		else{
			return $query->result_array();	
		}			
	}
	public function all_teamLead($department){
		// $this->db->where('User_type', 'TeamLead');
		// $this->db->or_where('User_type', 'Member');
		// $this->db->where("department != '".$department."'");
		// echo $this->session->userdata('department');
		$query = $this->db->query("SELECT * FROM `qpe_user` WHERE (`User_type` = 'TeamLead' OR `User_type` = 'Member' OR `User_type` = 'CEO' OR `User_type`='SiteLead') AND `department` != '$department'");
		// echo "SELECT * FROM `qpe_user` WHERE (`User_type` = 'TeamLead' OR `User_type` = 'Member') AND `department` != '$department'";
		// // echo $this->db->last_query();
		//  exit();
		return $query->result_array();
		 		
	}
	// Get Department by ID
	public function get_department_by_id($dept_id){
		$this->db->where('dept_id', $dept_id);
		$query = $this->db->get('qpe_departments');
		if($query->result_array()){
			return $query->row_array();
		}			
	}
	// Add & Update Department
	public function update_department($dept_id=0){
		// qpe_User data array
		$data = array(
			'dept_name' => $this->input->post('department_name'),
		);
		$deptt = $dept_id;
		if($dept_id=0 || empty($dept_id)){
			// Insert department
			return $this->db->insert('qpe_departments', $data);
			$this->session->set_flashdata('user_department', 'Department Successfully Inserted!');
		}
		else{
			// Update Department
			$this->db->where('dept_id', $deptt);
			$this->db->update('qpe_departments', $data);
			$this->session->set_flashdata('user_department_updated', 'Department Successfully Updated!');
		}
	}

	// Delete Department
	public function delete_department($dept_id){
		$this->db->where('dept_id', $dept_id);
		$this->db->delete('qpe_departments');
		return true;	
	}
	// Show All qpe_Designations
	public function all_designations(){
		$query = $this->db->get('qpe_designations');
		if($query->result_array()){
			return $query->result_array();
		}
		else{
			return $query->result_array();	
		}			
	}
	// Get Designation by ID
	public function get_designation_by_id($designation_id){
		$this->db->where('designation_id', $designation_id);
		$query = $this->db->get('qpe_designations');
		if($query->result_array()){
			return $query->row_array();
		}			
	}
	// Add & Update Designation
	public function update_designation($designation_id=0){
		// qpe_User data array
		$data = array(
			'designation_name' => $this->input->post('designation_name'),
			'designation_desc' => 'Designation Description',
			'designation_status' => $this->input->post('designation_status'),
		);
		$designationt = $designation_id;
		if($designation_id=0 || empty($designation_id)){
			// Insert designation
			$this->db->set('designation_added_by', $this->input->post('designation_added_by') );
			$this->db->set('designation_created_date', 'NOW()', FALSE);
			$this->db->set('designation_modified_date', 'NOW()', FALSE);
			return $this->db->insert('qpe_designations', $data);
			$this->session->set_flashdata('user_designation', 'Designation Successfully Inserted!');
		}
		else{
			// Update Designation
			$this->db->set('designation_modified_date', 'NOW()', FALSE);
			$this->db->where('designation_id', $designationt);
			$this->db->update('qpe_designations', $data);
			$this->session->set_flashdata('user_designation_updated', 'Designation Successfully Updated!');
		}
	}
	// Delete Designation
	public function delete_designation($designation_id){
		$this->db->where('designation_id', $designation_id);
		$this->db->delete('qpe_designations');
		return true;	
	}
	// Show All Users
	public function all_manage_users($department){
		$this->db->join('qpe_designations', 'qpe_designations.designation_id = qpe_user.Designation');
		$this->db->join('qpe_departments', 'qpe_departments.dept_id = qpe_user.department');
		$this->db->where('qpe_user.department', $department);
		$this->db->order_by('qpe_user.Joining_date','asc');
		$query = $this->db->get('qpe_user');
		//echo $this->db->last_query();
		if($query->result_array()){
			return $query->result_array();
		}
		else{
			return $query->result_array();	
		}			
	}
	// Show All Users
	public function get_exists_department(){
		$this->db->join('qpe_departments', 'qpe_departments.dept_id = qpe_user.department');
		$this->db->group_by('qpe_user.department');
		$this->db->order_by('qpe_user.User_id','asc');
		$query = $this->db->get('qpe_user');
		//echo $this->db->last_query();
		if($query->result_array()){
			return $query->result_array();
		}
		else{
			return $query->result_array();	
		}			
	}
	// Get qpe_User by ID
	public function get_manage_user_by_id($user_id){
		$this->db->join('qpe_designations', 'qpe_designations.designation_id = qpe_user.Designation');
		$this->db->where('User_id', $user_id);
		$query = $this->db->get('qpe_user');
		if($query->result_array()){
			return $query->row_array();
		}			
	}
	public function register($enc_password){
		// qpe_User data array
		$data = array(
			'Firstname' => $this->input->post('firstname'),
			'Lastname' => $this->input->post('lastname'),
			'Email' => $this->input->post('email'),
            'Designation' => $this->input->post('designation'),
            'User_type' => $this->input->post('user_type'),
            'password' => $enc_password
		);

		// Insert user
		return $this->db->insert('qpe_user', $data);
	}

	// Log qpe_user in
	public function login($email, $password){
		// Validate
		$this->db->where('Email', $email);
		$this->db->where('Password', $password);

		$result = $this->db->get('qpe_user');
		// echo $this->db->last_query();
		// exit();
		if($result->num_rows() == 1){
			return $result->row(0)->User_id;
		} else {
			return false;
		}
	}
	// Check email exists
	public function get_user_info($email,$password){
		$query = $this->db->get_where('qpe_user', array('email' => $email,'Password' => $password));
		return $query->row();
	}
	// Check username exists
	public function check_username_exists($email){
		$query = $this->db->get_where('qpe_user', array('email' => $email));
		if(empty($query->row_array())){
			return true;
		} else {
			return false;
		}
	}

	// Check email exists
	public function check_email_exists($email){
		$query = $this->db->get_where('qpe_user', array('email' => $email));
		if(empty($query->row_array())){
			return true;
		} else {
			return false;
		}
	}

	// Add & Update User
	public function update_manage_user($user_id=0){
		// qpe_User data array
		$enc_password = md5($this->input->post('password'));
		$data = array(
			'Firstname' => $this->input->post('firstname'),
			'Lastname' => $this->input->post('lastname'),
			'Email' => $this->input->post('email'),
            'Designation' => $this->input->post('designation'),
            'Team_lead' => $this->input->post('team_lead'),
            'User_type' => $this->input->post('user_type'),
            'department' => $this->input->post('department'),
            'Joining_date' => $this->input->post('Joining_date'),
            'PasswordView' => $this->input->post('password'),
            'password' => $enc_password,
            'assign_team_leads' => json_encode($this->input->post('assign_team_leads'))
		);
		$usert = $user_id;
		if($user_id=0 || empty($user_id)){
			// Insert manage_user
			$this->session->set_flashdata('user_manage_user_inserted', 'User Successfully Inserted!');
			return $this->db->insert('qpe_user', $data);
		}
		else{
			$data = array(
			'Firstname' => $this->input->post('firstname'),
			'Lastname' => $this->input->post('lastname'),
			'Email' => $this->input->post('email'),
            'Designation' => $this->input->post('designation'),
            'Team_lead' => $this->input->post('team_lead'),
            'User_type' => $this->input->post('user_type'),
            'department' => $this->input->post('department'),
            'PasswordView' => $this->input->post('password'),
            'password' => $enc_password,
            'Joining_date' => $this->input->post('Joining_date'),
            'assign_team_leads' => json_encode($this->input->post('assign_team_leads'))
			);
			 
			// Update User
			$this->db->where('user_id', $usert);
			$this->db->update('qpe_user', $data);
			$this->session->set_flashdata('user_manage_user_updated', 'User Successfully Updated!');
		}
	}

	// Delete User
	public function delete_manage_user($user_id){
		$this->db->where('User_id', $user_id);
		$this->db->delete('qpe_user');
		return true;	
	}
	public function get_submited_members_total($ids){
		$allids = implode("','", explode(',', $ids));
		//echo "SELECT COUNT(DISTINCT user_id) as totalsubmited FROM `qpe_evaluation` WHERE user_id IN (".$ids.")";
		// $query = $this->db->query("SELECT COUNT(DISTINCT qpe_evaluation.user_id) as totalsubmited FROM `qpe_evaluation` INNER JOIN qpe_user ON qpe_evaluation.user_id=qpe_user.User_id WHERE qpe_user.department='$ids' ");
		$query = $this->db->query("SELECT COUNT(DISTINCT qpe_evaluation.user_id) as totalsubmited FROM `qpe_evaluation` INNER JOIN qpe_user ON qpe_evaluation.user_id=qpe_user.User_id WHERE qpe_evaluation.user_id IN ('".$allids."') ");
		return $query->row();
				
	}
}