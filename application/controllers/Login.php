<?php
/**
 * CodeIgniter
 * @title      Login Controller
 * @author     Jawad Ali
 * @Date       03/09/2019
 */
class Login extends CI_Controller{
	// Register user
	public function __construct()
    {
    	parent::__construct();
        // Your own constructor code
    }
	public function index(){
		$data['title'] = 'Login';
		$this->load->view('templates/header', $data);
		$this->load->view('users/login', $data);
		$this->load->view('templates/footer', $data);
	}
 
	// Register Function
	public function register(){
		$data['title'] = 'Registeration Form';
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');
		if($this->form_validation->run() === FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('users/register', $data);
			$this->load->view('templates/footer', $data);
		} else {
			// Encrypt password
			$enc_password = md5($this->input->post('password'));
			$this->user_model->register($enc_password);
			// Set message
			$this->session->set_flashdata('success', 'You are now registered and can log in');
			redirect('users');
		}
	}
	// Log in user
	public function auth(){
		 
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run() === FALSE){
			$this->show_view('users/login', $data);
		} else {
			// Get email
			$email = $this->input->post('email');
			// Get and encrypt the password
			$password = md5($this->input->post('password'));
			// Login user
			$user_id = $this->user_model->login($email, $password);
			$info = $this->user_model->get_user_info($email,$password);
			if($user_id){
				// Create session
				$user_data = array(
					'user_id' => $user_id,
					'email' => $email,
					'user_type' => $info->User_type,
					'department' => $info->department,
					'Designation' => $info->Designation,
					'username' => $info->Firstname.' '.$info->Lastname,
					'logged_in' => true
				);
				$this->session->set_userdata($user_data);
				// Set message
				$this->session->set_flashdata('success', 'You are now logged in');
				redirect('dashboard');
			} else {
				// Set message
				$this->session->set_flashdata('error', 'Login is invalid');
				redirect('login');
			}		
		}
	}
	// Log user out
	public function logout(){
		// Unset user data
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('email');
		// Set message
		$this->session->set_flashdata('user_loggedout', 'You are now logged out');
		redirect('login');
	}
	// Check if email exists
	public function check_username_exists($email){
		$this->form_validation->set_message('check_username_exists', 'That email is taken. Please choose a different one');
		if($this->user_model->check_username_exists($email)){
			return true;
		} else {
			return false;
		}
	}
	// Check if email exists
	public function check_email_exists($email){
	$this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');
		if($this->user_model->check_email_exists($email)){
			return true;
		} else {
			return false;
		}
	}
	// Admin dashboard
	public function admin(){
		$data['title'] = 'Admin';
		// $this->load->model('rating_model');
		//$data['lthr_all_members'] = $this->rating_model->lthr_all_members();
		//$data['ltm_all_members'] = $this->rating_model->ltm_all_members();
		//$data['mtl_all_members'] = $this->rating_model->mtl_all_members();
		$this->load->view('templates/header', $data);
		$this->load->view('users/admin_dashboard', $data);
		$this->load->view('templates/footer', $data);
	}


 
}