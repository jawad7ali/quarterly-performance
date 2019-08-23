<?php
/**
 * CodeIgniter
 * @title      Dashboard Controller
 * @author     Jawad Ali
 * @Date       01/09/2019
 */
class Dashboard extends MY_Controller{
	// Register user
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('rating_model');
        // Your own constructor code
        
    }
	// Dashboard Function
	public function index($eval_id=''){
		//echo $this->session->userdata('user_type');
		if($this->session->userdata('user_type') == 'Admin'){
			$this->AdminDashboard();
		}
		if($this->session->userdata('user_type') == 'Member'){
			$this->MemberDashboard($eval_id);
		}
		if($this->session->userdata('user_type') == 'TeamLead'){
			$this->TeamLeadDashboard($eval_id);
		}
		if($this->session->userdata('user_type') == 'trainer'){
			$this->TrainerDashboard($eval_id);
		}
		if($this->session->userdata('user_type') == 'hr'){
			$this->hrDashboard($eval_id);
		}
		if($this->session->userdata('user_type') == 'SiteLead' || $this->session->userdata('user_type') == 'CEO'){
			$this->SiteLeadDashboard($eval_id);
		}
	}
	// Dashboard Function
	public function AdminDashboard(){
		$data['title'] = 'Dashboard';
        // $data['lthr_all_members'] = $this->rating_model->lthr_all_members();
        // $data['ltm_all_members'] = $this->rating_model->ltm_all_members();
        // $data['mtl_all_members'] = $this->rating_model->mtl_all_members();
        $data['all_departments'] = $this->user_model->all_departments_for_dashboard();
        $data['current_quarter'] = $this->current_quarter();
		$this->show_view('users/dashboard', $data);
	}
	// Dashboard Function
 	public function MemberDashboard($eval_id=''){
    	
    	$data['user_capability'] = $this->rating_model->current_qur_ofLogin_user();
    	$data['curentQuarter'] = $this->current_quarter();
		$data['title'] = 'Quarterly Performance Evaluation ('.$data['curentQuarter'].' Quarter Of '.date('Y').')';                   	
		$data['user_id']   = $this->session->userdata('user_id');
		$data['email']     = $this->session->userdata('email');
		$data['logged_in'] = $this->session->userdata('logged_in');
        $data['all_factors_list'] = $this->rating_model->mtl_get_factors();
        
        //echo $this->db->last_query();
        $data['eval_info'] = $this->rating_model->eval_by_user_id($eval_id,'','desc');
        //back button id
        $data['backid'] = $this->rating_model->eval_by_user_id('',$eval_id,'desc');
        //echo $this->db->last_query();
		$data['eval_id'] = $eval_id;
		if($data['eval_info']->evaluate_user !='' ){
			$ids = $this->rating_model->evalute_user_ids($data['curentQuarter']);
			 
			$nextid = $this->rating_model->evalute_user($ids->ids);
			if($eval_id !=''){
				
				$data['dep_member'] = $this->rating_model->department_members($data['user_id'],$data['eval_info']->evaluate_user);
			}else{

				$data['dep_member'] = $this->rating_model->department_members_nextid($data['user_id'],$nextid->User_id);

			}
		}else{
			$data['dep_member'] = $this->rating_model->department_members($data['user_id']);
		}
		if($this->session->userdata('user_type') == 'Member' && $data['dep_member']['User_type'] == 'TeamLead'){
			$eval_type= 'mtl';
		}
		if($this->session->userdata('user_type') == 'Member' && $data['dep_member']['User_type'] == 'Member'){
			$eval_type= 'mtm';
		}
		if($this->session->userdata('user_type') == 'Member' && $data['dep_member']['User_type'] == 'CEO'){
			$eval_type= 'mtl';
		}
		if($this->session->userdata('user_type') == 'TeamLead' && $data['dep_member']['User_type'] == 'Member'){
			$eval_type= 'ltm';
		}
		if($this->session->userdata('user_type') == 'TeamLead' && $data['dep_member']['User_type'] == 'TeamLead'){
			$eval_type= 'mtm';
		}
		if($this->session->userdata('user_type') == 'TeamLead' && $data['dep_member']['User_type'] == 'CEO'){
			$eval_type= 'mtl';
		}
		if($this->session->userdata('user_type') == 'TeamLead' && $data['dep_member']['User_type'] == 'SiteLead'){
			$eval_type= 'mtl';
		}
		// echo $data['dep_member']['User_type'];
		// exit();
		$data['selected_factors_list'] = $this->rating_model->get_selected_factors($eval_id,$eval_type);
		//echo $this->db->last_query();
		$this->show_view('member/evaluate-form', $data);
	}
	//public function MemberDashboard(){
	//$data['title'] = 'Dashboard';
 	//$data['lthr_all_members'] = $this->rating_model->lthr_all_members();
 	//$data['ltm_all_members'] = $this->rating_model->ltm_all_members();
 	//$data['mtl_all_members'] = $this->rating_model->mtl_all_members();
	// 	$this->show_view('users/dashboard', $data);
	// }
	// Dashboard Function
	public function TeamLeadDashboard($eval_id=''){

		$data['user_capability'] = $this->rating_model->current_qur_ofLogin_user();
		$data['curentQuarter'] = $this->current_quarter();
		$data['title'] = 'Quarterly Performance Evaluation ('.$data['curentQuarter'].' Quarter Of '.date('Y').')';                   	
		$data['user_id']   = $this->session->userdata('user_id');
		$data['email']     = $this->session->userdata('email');
		$data['logged_in'] = $this->session->userdata('logged_in');

        $data['all_factors_list'] = $this->rating_model->mtl_get_factors();
        
        //echo $this->db->last_query();
        $data['eval_info'] = $this->rating_model->eval_by_user_id($eval_id,'','desc');
        //back button id
        $data['backid'] = $this->rating_model->eval_by_user_id('',$eval_id,'desc');
        //echo $this->db->last_query();
		$data['eval_id'] = $eval_id;

		if($data['eval_info']->evaluate_user !='' ){
			$ids = $this->rating_model->evalute_user_ids($data['curentQuarter']);
			$nextid = $this->rating_model->evalute_user($ids->ids);
          
			if($eval_id !=''){ 

				$data['dep_member'] = $this->rating_model->department_members($data['user_id'],$data['eval_info']->evaluate_user);
			}else{
				$data['dep_member'] = $this->rating_model->department_members_nextid($data['user_id'],$nextid->User_id);
				 //echo $this->db->last_query();
				//print_r($data['dep_member']);
			}

		}else{
			$data['dep_member'] = $this->rating_model->department_members($data['user_id']);
			// echo $this->db->last_query();
			// exit();
		}
		
		if($this->session->userdata('user_type') == 'Member' && $data['dep_member']['User_type'] == 'TeamLead'){
			$eval_type= 'mtl';
		}
		if($this->session->userdata('user_type') == 'Member' && $data['dep_member']['User_type'] == 'Member'){
			$eval_type= 'mtm';
		}
		if($this->session->userdata('user_type') == 'TeamLead' && $data['dep_member']['User_type'] == 'Member'){
			$eval_type= 'ltm';
		}
		if($this->session->userdata('user_type') == 'TeamLead' && $data['dep_member']['User_type'] == 'TeamLead'){
			$eval_type= 'mtm';
		}
		if($this->session->userdata('user_type') == 'TeamLead' && $data['dep_member']['User_type'] == 'CEO'){
			$eval_type= 'mtl';
		}
		if($this->session->userdata('user_type') == 'TeamLead' && $data['dep_member']['User_type'] == 'SiteLead'){
			$eval_type= 'mtl';
		}
		$data['selected_factors_list'] = $this->rating_model->get_selected_factors($eval_id,$eval_type);
		//echo $this->db->last_query();

		$this->show_view('member/evaluate-form', $data);
	}
	// Evaluation Rating mtl ( Member to Team Lead)
    public function evaluate_submit(){
    	
		$data['user_id']   = $this->session->userdata('user_id');
		$data['email']     = $this->session->userdata('email');
		$data['logged_in'] = $this->session->userdata('logged_in');

    	$data['count_factors'] = COUNT($_POST['count_fac']);
    	$data['selected_factors_list'] = $this->rating_model->get_selected_factors();

		$this->rating_model->evaluate_member($data);
		// Set message
		if($this->input->post('submit') == 'final'){
			$this->session->set_flashdata('evaluate_success', 'Evaluation submited successfully.');
		}
		
		if($this->input->post('next') !=''){
			redirect('dashboard/index/'.$this->input->post('next'));
		}else{
			redirect('dashboard');
		}
	}
	// Dashboard Function
	public function TrainerDashboard($eval_id='',$department =''){
		$data['user_capability'] = $this->rating_model->current_qur_ofLogin_user();
		$data['curentQuarter'] = $this->current_quarter();
		$data['title'] = 'Quarterly Performance Evaluation ('.$data['curentQuarter'].' Quarter Of '.date('Y').')';                   	
		$data['user_id']   = $this->session->userdata('user_id');
		$data['email']     = $this->session->userdata('email');
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['all_departments'] = $this->rating_model->all_departments();
        $data['all_factors_list'] = $this->rating_model->mtl_get_factors();
        
        //echo $this->db->last_query();
        $data['eval_info'] = $this->rating_model->eval_by_user_id($eval_id,'','desc');
        //back button id
        $data['backid'] = $this->rating_model->eval_by_user_id('',$eval_id,'desc');
        //echo $this->db->last_query();
		$data['eval_id'] = $eval_id;
		if($data['eval_info']->evaluate_user !='' ){
			$ids = $this->rating_model->evalute_user_ids($data['curentQuarter']);
			$nextid = $this->rating_model->evalute_trainer_user($ids->ids);
			//echo $this->db->last_query();
			if($eval_id !=''){

				$data['dep_member'] = $this->rating_model->department_members_trainer($data['user_id'],$data['eval_info']->evaluate_user,$department);
			}else{

				$data['dep_member'] = $this->rating_model->department_members_trainer_nextid($data['user_id'],$nextid->User_id,$department);
				//print_r($data['dep_member']);
			}
		}else{
			
			$data['dep_member'] = $this->rating_model->department_members_trainer($data['user_id'],'',$department);
		}

		$data['selected_factors_list'] = $this->rating_model->get_selected_factors($eval_id,'ttm');
		//echo $this->db->last_query();
		$this->show_view('member/evaluate-form', $data);
	}
	// Dashboard Function
	public function hrDashboard($eval_id='',$department =''){
		$data['user_capability'] = $this->rating_model->current_qur_ofLogin_user();
		$data['curentQuarter'] = $this->current_quarter();
		$data['title'] = 'Quarterly Performance Evaluation ('.$data['curentQuarter'].' Quarter Of '.date('Y').')';                   	
		$data['user_id']   = $this->session->userdata('user_id');
		$data['email']     = $this->session->userdata('email');
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['all_departments'] = $this->rating_model->all_departments();
        $data['all_factors_list'] = $this->rating_model->mtl_get_factors();
        
        //echo $this->db->last_query();
        $data['eval_info'] = $this->rating_model->eval_by_user_id($eval_id,'','desc');
        //back button id
        $data['backid'] = $this->rating_model->eval_by_user_id('',$eval_id,'desc');
        //echo $this->db->last_query();
		$data['eval_id'] = $eval_id;
		if($data['eval_info']->evaluate_user !='' ){
			$ids = $this->rating_model->evalute_user_ids($data['curentQuarter']);
			$nextid = $this->rating_model->evalute_trainer_user($ids->ids);
			if($eval_id !=''){
				$data['dep_member'] = $this->rating_model->department_members_trainer($data['user_id'],$data['eval_info']->evaluate_user,$department);
			}else{
				$data['dep_member'] = $this->rating_model->department_members_trainer_nextid($data['user_id'],$nextid->User_id,$department);
				//print_r($data['dep_member']);
			}
		}else{

			$data['dep_member'] = $this->rating_model->department_members_trainer($data['user_id'],'',$department);
		}

		$data['selected_factors_list'] = $this->rating_model->get_selected_factors($eval_id,'lthr');
		//echo $this->db->last_query();
		$this->show_view('member/evaluate-form', $data);
	}
	// Dashboard Function
	public function SiteLeadDashboard($eval_id='',$department =''){
		$data['user_capability'] = $this->rating_model->current_qur_ofLogin_user();
		$data['curentQuarter'] = $this->current_quarter();
		$data['title'] = 'Quarterly Performance Evaluation ('.$data['curentQuarter'].' Quarter Of '.date('Y').')';                   	
		$data['user_id']   = $this->session->userdata('user_id');
		$data['email']     = $this->session->userdata('email');
		$data['logged_in'] = $this->session->userdata('logged_in');
		$data['all_departments'] = $this->rating_model->all_departments();
        $data['all_factors_list'] = $this->rating_model->mtl_get_factors();
        
        //echo $this->db->last_query();
        $data['eval_info'] = $this->rating_model->eval_by_user_id($eval_id,'','desc');
        //back button id
        $data['backid'] = $this->rating_model->eval_by_user_id('',$eval_id,'desc');
        //echo $this->db->last_query();
		$data['eval_id'] = $eval_id;
		if($data['eval_info']->evaluate_user !='' ){
			$ids = $this->rating_model->evalute_user_ids($data['curentQuarter']);
			$nextid = $this->rating_model->evalute_SiteLead_user($ids->ids);
			if($eval_id !=''){
				$data['dep_member'] = $this->rating_model->department_members_SiteLead($data['user_id'],$data['eval_info']->evaluate_user,$department);
			}else{
				$data['dep_member'] = $this->rating_model->department_members_SiteLead_nextid($data['user_id'],$nextid->User_id,$department);
				//print_r($data['dep_member']);
			}
		}else{

			$data['dep_member'] = $this->rating_model->department_members_SiteLead($data['user_id'],'',$department);
		}

		$data['selected_factors_list'] = $this->rating_model->get_selected_factors($eval_id,'stl');
		//echo $this->db->last_query();
		$this->show_view('member/evaluate-form', $data);
	}
}