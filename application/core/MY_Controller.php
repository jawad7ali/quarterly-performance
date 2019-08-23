<?php
/**
* Created By:   Jawad Ali
* Dated:        21-04-2014

* This Controller use for load a 
  view files in every single userside Controller
  like:
  class yourController extends MY_Controller(){}
*/
class MY_Controller extends CI_Controller{

	public function __construct()
  {
      parent::__construct();
      $this->load->library('session');
      if($this->session->userdata('logged_in') == false){
        $this->session->set_flashdata('error_msg', 'You are not login. Please login to continue.');
          redirect('login');
      }
  }
  public function current_quarter()
  {
    $month = date('n');
    if ($month <= 4) return '1st';
    if ($month <= 8) return '2nd';
    if ($month <= 10) return '3rd';
    if ($month <= 1) return '4th';
    return 'Last';
  }

  public function show_view($view, $data = array())
  {
      $this->load->view('templates/header', $data);
      $this->load->view($view, $data);
      $this->load->view('templates/footer', $data);
  }
  //this function for sent email for signup approver has cridentionals 
  public function send_mail($email,  $name, $key, $des, $type ='') { 
     

      $from_email = 'info@peekter.com'; 
      $to_email =     $email;
      //Load email library 
      $this->load->library('email');
      $config = array (
        'mailtype' => 'html',
        'charset'  => 'utf-8',
        'protocol' => 'mail',
        'priority' => '1'
      );
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      $this->email->from($from_email, 'PEEKTER'); 
      $data = array(
           'name' => $name,
           'email'=> $email,
           'key'=> $key,
           'description'  => $des,
           'type' => $type
      );
      $this->email->to($to_email);
      $this->email->subject('Account activation');

      $body = $this->load->view('userside/mails/registrationMail.php',$data,TRUE);
      $this->email->message($body);  
      $this->email->send();

    } 

  } 