<?php
/**
 * CodeIgniter
 * @title      Factors Controller
 * @author     Jawad Ali
 * @Date       12/09/2019
 */
class Factors extends MY_Controller{
	public function __construct()
    {
    	parent::__construct();
		$this->load->model('rating_model');
		//$this->load->model('factor_model');
		if($this->session->userdata('user_type') != 'Admin'){
        	redirect('dashboard');
        }
    } 
	public function listing($type){
		 
		$data['factors_list'] = $this->rating_model->get_factors_by_tbl($type);
		if($type == 'mtm'){
			$data['title'] = 'Performance Evaluation Team Member To Team Member';
 	    }elseif($type == 'mtl'){
 	    	$data['title'] = 'Performance Evaluation Team Member To Team Lead';
 	    }elseif($type == 'ltm'){
 	    	$data['title'] = 'Performance Evaluation Team Lead To Team Member';
 	    }elseif($type == 'lthr'){
 	    	$data['title'] = 'Performance Evaluation HR To Team Lead';
 	    }elseif($type == 'ttm'){
 	    	$data['title'] = 'Performance Evaluation Trainer To Members';
 	    }elseif($type == 'stl'){
 	    	$data['title'] = 'Performance Evaluation Site Lead/HR To Team Lead';
 	    }else{
 	    	redirect('dashboard');
 	    }
		$this->show_view('factors/factors_list', $data);
	}
    public function add($factor_id ='0'){
		$data['title'] = 'Add Evaluation Factor';
		$data['factors_list'] = $this->rating_model->mtl_get_factors();
		if($factor_id != '0'){
			$data['factors_row'] = $this->rating_model->edit_factors_by_id($factor_id);
		}else{
			$data['factors_row'] = '';
		}
		
		$this->show_view('factors/add_factor', $data);
	}

	public function submit_factor(){
		$data['title'] = 'Add Evaluation Factor';
		$this->form_validation->set_rules('category_name', 'Category', 'required');
		//$this->form_validation->set_rules('factor_description', 'Factor Description', 'required');
        $factor_id   = $this->input->post("factor_id");
        $category_id = $this->input->post("category_id");
		if($this->form_validation->run() === TRUE){
			if(!empty($factor_id)){
				$this->rating_model->update_member_to_lead($factor_id,$category_id);
	     	    $this->session->set_flashdata('success', 'Evaluation Factor Successfully Updated');

	     	    if($this->input->post("factor_type") == 'mtm'){
	     	    	redirect('factors/listing/mtm');
	     	    }
	     	    if($this->input->post("factor_type") == 'mtl'){
	     	    	redirect('factors/listing/mtl');
	     	    }
	     	    if($this->input->post("factor_type") == 'ltm'){
	     	    	redirect('factors/listing/ltm');
	     	    }
	     	    if($this->input->post("factor_type") == 'ttm'){
	     	    	redirect('factors/listing/ttm');
	     	    }
	     	    if($this->input->post("factor_type") == 'lthr'){
	     	    	redirect('factors/listing/lthr');
	     	    }
	     	    if($this->input->post("factor_type") == 'stl'){
	     	    	redirect('factors/listing/stl');
	     	    }else{
	     	    	redirect('dashboard');
	     	    }
				
	        }else{
				$this->rating_model->update_member_to_lead();
				$this->session->set_flashdata('success', 'Evaluation Factor Successfully Inserted');
				if($this->input->post("factor_type") == 'mtm'){
	     	    	redirect('factors/listing/mtm');
	     	    }
	     	    if($this->input->post("factor_type") == 'mtl'){
	     	    	redirect('factors/listing/mtl');
	     	    }
	     	    if($this->input->post("factor_type") == 'ltm'){
	     	    	redirect('factors/listing/ltm');
	     	    }
	     	    if($this->input->post("factor_type") == 'ttm'){
	     	    	redirect('factors/listing/ttm');
	     	    }
	     	    if($this->input->post("factor_type") == 'lthr'){
	     	    	redirect('factors/listing/lthr');
	     	    }if($this->input->post("factor_type") == 'stl'){
	     	    	redirect('factors/listing/stl');
	     	    }else{
	     	    	redirect('dashboard');
	     	    }
			}
		}
	}

	public function delete_factor($factor_id,$category_id,$type){
		$this->rating_model->delete_factor($factor_id,$category_id);
		// Set message
		$this->session->set_flashdata('evaluation_success_delete', 'Evaluation has been Successfully Deleted');
		if($type == 'mtm'){
 	    	redirect('factors/listing/mtm');
 	    }
 	    if($type == 'mtl'){
 	    	redirect('factors/listing/mtl');
 	    }
 	    if($type == 'ltm'){
 	    	redirect('factors/listing/ltm');
 	    }
 	    if($type == 'ttm'){
	     	    	redirect('factors/listing/ttm');
	     	    }
 	    if($type == 'lthr'){
 	    	redirect('factors/listing/lthr');
 	    }
 	    if($type == 'stl'){
	    	redirect('factors/listing/stl');
	    }else{
 	    	redirect('dashboard');
 	    }
	}
    
}