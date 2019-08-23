<?php
class Rating_model extends CI_Model{
	public function __construct(){
		
	}

	/* 
	***************************************************								
	 	TEAM LEAD TO H.R (lthr) FUNCTIONS STARTS	
	***************************************************								
	*/
	// Get All Factors
	public function get_factors_by_tbl($factor_type){
		$this->db->select('qpe_eval_factors.description,qpe_eval_factors.factor_type,qpe_categories.name,qpe_categories.id as cat_id,qpe_eval_factors.id as fac_id');
		$this->db->join('qpe_categories', 'qpe_categories.id = qpe_eval_factors.category');
		$this->db->where('qpe_eval_factors.factor_type',$factor_type);
		$query = $this->db->get('qpe_eval_factors');
		return $query->result_array();
	}
	public function edit_factors_by_id($factors_id){
		$this->db->select('qpe_eval_factors.description,qpe_eval_factors.factor_type,qpe_categories.name,qpe_categories.id as cat_id,qpe_eval_factors.id as fac_id');
		$factors_id = $this->uri->segment(3);			
		$this->db->join('qpe_categories', 'qpe_categories.id = qpe_eval_factors.category');
		$query = $this->db->get_where('qpe_eval_factors', array('qpe_eval_factors.id' => $factors_id));
		return $query->row_array();
	}
	// Show Evaluate list lthr (Team Lead to H.R)
	public function evaluate_list(){
						
		// $this->db->join('tlhr_eval_ratings', 'tlhr_eval_ratings.tlhr_id = qpeteamleadtohr.tlhr_id');
		// $this->db->join('tlhr_eval_factors', 'tlhr_eval_factors.tlhr_eval_fact_id = tlhr_eval_ratings.tlhr_eval_fact_id');
		// $this->db->join('tlhr_categories', 'tlhr_categories.tlhr_cat_id = tlhr_eval_factors.tlhr_eval_cat');
		// $this->db->join('user', 'user.User_id = qpeteamleadtohr.tlhr_name');
		// $this->db->join('departments', 'departments.dept_id = qpeteamleadtohr.tlhr_department');
		// $this->db->join('projects', 'projects.project_id = qpeteamleadtohr.tlhr_project');
		// $this->db->join('designations', 'designations.designation_id = qpeteamleadtohr.tlhr_designation');
		
		//$this->db->group_by("qpeteamleadtohr");
		$query = $this->db->get('qpe_evaluation');

		return $query->result_array();
	}
	public function evaluate_list_by_department($department){
		$this->db->select('a.id as eval_id,b.Firstname,b.Lastname,d.designation_name,c.dept_name');
		$this->db->from('qpe_evaluation a');
		$this->db->join('user b', 'a.user_id = b.User_id');
		$this->db->join('departments c', 'c.dept_id = b.department');
		$this->db->join('designations d', 'd.designation_id = b.Designation');
		$this->db->where('b.department',$department);
		$this->db->group_by('a.user_id');
		$query = $this->db->get();
		return $query->result_array();
	}
	// Show Evaluation List Detail lthr (Team Lead to H.R)
	public function evaluate_member_detail($id, $order_by){
						 
		$this->db->select('a.*,b.Firstname,b.Firstname,b.Lastname,d.designation_name,c.dept_name,b.Team_lead,b.Firstname');
        $this->db->from('qpe_evaluation a'); 
        if($id !=''){
        	$this->db->where("a.`id` = ". $id ."");
        }
        $this->db->join('user b', 'a.user_id = b.User_id');
        $this->db->join('departments c', 'b.department = c.dept_id');
        $this->db->join('designations d', 'd.designation_id = b.Designation');
        $this->db->order_by('a.id', $order_by);
        $query = $this->db->get();
         //echo $this->db->last_query();
        // exit();
        return $query->row_array();
	}
		// Add Evaluation Factors and Edit Evaluation Factor (Member to Team Lead)
		public function update_member_to_lead($factor_id=0,$cat_id=0){
			// Insert The Evaluation Factor
			if(empty($factor_id) || $factor_id=0 || empty($cat_id) || $cat_id=0){
				// Category data array
				$data_category = array(
					'name' => $this->input->post('category_name'),
					'status' => '1',
					'created_at' => date('Y-m-d H:i:s'),
					'modified_at' => date('Y-m-d H:i:s'),
				);
				// Insert Category
				$result =  $this->db->insert('qpe_categories', $data_category);
				
				$insert_id = $this->db->insert_id();

				// Check If Category inserted
				if($insert_id){
					// Category data array
					$data_factors = array(
						'description' => $this->input->post('factor_description'),
						'factor_type' => $this->input->post('factor_type'),
						'category' => $insert_id,
						'created_at' => date('Y-m-d H:i:s'),
						'modified_at' => date('Y-m-d H:i:s'),
					);
					// Insert Factors
					$result =  $this->db->insert('qpe_eval_factors', $data_factors);
					return $result;
				}
			}else{
				
				$data_factors = array(
					'description' => $this->input->post('factor_description'),
					'modified_at' => date('Y-m-d H:i:s'),
				);

                $data_cat_factors = array(
					'name' => $this->input->post('category_name'),
					'modified_at' => date('Y-m-d H:i:s'),
				);
				
 				$factor_id   = $this->input->post("factor_id");
            	$cat_id = $this->input->post("category_id");

				$this->db->where('id', $factor_id);
				$this->db->where('category', $cat_id);
                
                if($this->db->update('qpe_eval_factors', $data_factors)){
			        $this->db->where('id', $cat_id);
			        $this->db->update('qpe_categories', $data_cat_factors);
                }
			}
		}
		// Delete Evaluation Factors
		public function delete_factor($factor_id,$cat_id){
			$this->db->where('id', $cat_id);
			if($this->db->delete('qpe_eval_factors')){
				$this->db->where('id', $cat_id);
				$this->db->delete('qpe_categories');
				return true;	
			}
			
		}
		// Get All Factors lthr (Team Lead to H.R)
		public function lthr_get_factors($limit = FALSE, $offset = FALSE){

			$this->db->join('tlhr_categories', 'tlhr_cat_id = tlhr_eval_cat');
			$query = $this->db->get('tlhr_eval_factors');
			return $query->result_array();
		
		}
		// Get Selected Factors lthr (Team Lead to H.R)
		public function lthr_get_selected_factors($tlhr_name=0,$tlhr_id=0){
			// check if user exists in ratings table
			$user_id = $this->session->userdata('user_id');
			$this->db->join('qpeteamleadtohr', 'qpeteamleadtohr.tlhr_id = tlhr_eval_ratings.tlhr_id');
			$this->db->where(array('tlhr_eval_ratings.User_id' => $user_id));
			$this->db->where(array('qpeteamleadtohr.tlhr_name' => $tlhr_name));
			$query = $this->db->get('tlhr_eval_ratings');
			$check_array = $query->result_array();
			// echo $this->db->last_query();
			// exit;
			// If user exists in the table
			if(!empty($check_array) && !empty($tlhr_name)){
				$this->db->join('tlhr_eval_factors', 'tlhr_eval_factors.tlhr_eval_fact_id =  tlhr_eval_ratings.tlhr_eval_fact_id');
				$this->db->join('tlhr_categories', 'tlhr_categories.tlhr_cat_id = tlhr_eval_factors.tlhr_eval_cat');
				$this->db->join('qpeteamleadtohr', 'qpeteamleadtohr.tlhr_id = tlhr_eval_ratings.tlhr_id');
				$this->db->join('user', 'user.User_id = qpeteamleadtohr.tlhr_name');
				$this->db->where(array('qpeteamleadtohr.tlhr_name' => $tlhr_name));
				$query = $this->db->get('tlhr_eval_ratings');
				// echo $this->db->last_query();
				// print_r($query->result_array());
				// exit;
				return $query->result_array();
			}
			// else if user doesn't exists in the table
		    else{
		    	$this->db->join('tlhr_categories', 'tlhr_cat_id = tlhr_eval_cat');
				$query = $this->db->get('tlhr_eval_factors');

				return $query->result_array();

		    }
		}
		

		// Get Factors by id lthr (Team Lead to H.R)
		public function lthr_get_factors_by_id($factors_id){
			$factors_id = $this->uri->segment(3);			
			$this->db->join('tlhr_categories', 'tlhr_cat_id = tlhr_eval_cat');
			$query = $this->db->get_where('tlhr_eval_factors', array('tlhr_eval_fact_id' => $factors_id));
			return $query->row_array();
		}

		// Insert Evaluation lthr (Team Lead to H.R)
		public function evaluate_lthr($data,$user_id=0,$tlhr_id=0){
			// get all values
			$data_category = array(
					'tlhr_name' => $this->input->post('user_name'),
					'tlhr_designation' => $this->input->post('user_designation'),
					'tlhr_lead_name' => $this->input->post('lead_name'),
					'tlhr_lead_type' => $this->input->post('selectLeadType'),
					'tlhr_department' => $this->input->post('user_department'),
					'tlhr_joining_date' => $this->input->post('user_joining_date'),
					'tlhr_quarter' => $this->input->post('evaluation_quarter'),
					'tlhr_project' => $this->input->post('user_project'),
					'tlhr_date' => $this->input->post('evaluation_date'),
					'tlhr_recommendations' => $this->input->post('evaluate_recommendation'),
				);
				
				$session_user_id = $this->session->userdata('user_id');
				// Check into ratings table if user exists and user evaluator exists
				$tlhr_name = $this->input->post('user_name');
				$this->db->join('qpeteamleadtohr', 'qpeteamleadtohr.tlhr_id = tlhr_eval_ratings.tlhr_id');
				$this->db->where(array('tlhr_eval_ratings.User_id' => $session_user_id));
				$this->db->where(array('qpeteamleadtohr.tlhr_name' => $tlhr_name));
				$query = $this->db->get('tlhr_eval_ratings');
				$check_array = $query->result_array();

				if(empty($check_array)){
				$this->db->set('tlhr_created_date', 'NOW()', FALSE);
				$this->db->set('tlhr_modified_date', 'NOW()', FALSE);
				// Insert into qpeteamleadtohr table
				$result =  $this->db->insert('qpeteamleadtohr', $data_category);
				$insert_id = $this->db->insert_id();

				// Check If qpeteamleadtohr inserted
				if($insert_id){
					$count = $data['count_factors'];

					// Category data array
					for ($i=1; $i <= $count ; $i++) { 
						$data_factors = array(
						'tlhr_rating_number' => $this->input->post('btn_radio_rating'.$i),
						'tlhr_rating_avg' => '0',
						'tlhr_rating_remarks' => $this->input->post('remarks'.$i),
						'tlhr_overall_rating' => $this->input->post('overall_rating'),
						'tlhr_eval_fact_id' => $this->input->post('eval_fact_id'.$i),
						'User_id' => $data['user_id'],
						'tlhr_id' => $insert_id,
						);
					$this->db->set('tlhr_rating_created_date', 'NOW()', FALSE);
					$this->db->set('tlhr_rating_modified_date', 'NOW()', FALSE);

					// Insert Rating
					$result =  $this->db->insert('tlhr_eval_ratings', $data_factors);
					
				   }
				   return $result;
				}
			} // update if already inserted the evaluation
			else{
				$tlhr_id = $this->input->post('tlhr_id');
				$this->db->where(array('tlhr_eval_ratings.User_id' => $user_id));
				$this->db->where(array('tlhr_eval_ratings.tlhr_id' => $tlhr_id));
				$query = $this->db->get('tlhr_eval_ratings');
				// echo $this->db->last_query();
				$eval_rating = $query->result_array();
				$count = COUNT($eval_rating);
				// Update ratings table
				for ($i=1; $i <= $count ; $i++) { 
						$rating_id = $this->input->post('tlhr_rating_'.$i);
						$data_factors = array(
						'tlhr_rating_number' => $this->input->post('btn_radio_rating'.$i),
						'tlhr_rating_avg' => '0',
						'tlhr_rating_remarks' => $this->input->post('remarks'.$i),
						'tlhr_overall_rating' => $this->input->post('overall_rating'),
						'tlhr_eval_fact_id' => $this->input->post('eval_fact_id'.$i),
						'User_id' => $data['user_id'],
						);
					$this->db->set('tlhr_rating_modified_date', 'NOW()', FALSE);

					// Insert Rating
					$this->db->where('tlhr_rating_id', $rating_id);
					$result =  $this->db->update('tlhr_eval_ratings', $data_factors);
				   }
				// Update qpeteamleader table   
				if($result){
					
					$tlhr_id = $this->input->post('tlhr_id');
					$this->db->where('tlhr_id', $tlhr_id);
					$this->db->set('tlhr_modified_date', 'NOW()', FALSE);
					$result =  $this->db->update('qpeteamleadtohr', $data_category);

				}   
				return $result;
			}

		}

	// Show Evaluate list lthr (Team Lead to H.R)
	public function evaluate_lthr_list(){
						
		$this->db->join('tlhr_eval_ratings', 'tlhr_eval_ratings.tlhr_id = qpeteamleadtohr.tlhr_id');
		$this->db->join('tlhr_eval_factors', 'tlhr_eval_factors.tlhr_eval_fact_id = tlhr_eval_ratings.tlhr_eval_fact_id');
		$this->db->join('tlhr_categories', 'tlhr_categories.tlhr_cat_id = tlhr_eval_factors.tlhr_eval_cat');
		$this->db->join('user', 'user.User_id = qpeteamleadtohr.tlhr_name');
		$this->db->join('departments', 'departments.dept_id = qpeteamleadtohr.tlhr_department');
		$this->db->join('projects', 'projects.project_id = qpeteamleadtohr.tlhr_project');
		$this->db->join('designations', 'designations.designation_id = qpeteamleadtohr.tlhr_designation');
		
		$this->db->group_by("qpeteamleadtohr.tlhr_id");
		$query = $this->db->get('qpeteamleadtohr');

		return $query->result_array();
	}

	// Show Evaluation List Detail lthr (Team Lead to H.R)
	public function evaluate_lthr_list_detail($tlhr_id){
						
		$this->db->join('tlhr_eval_ratings', 'tlhr_eval_ratings.tlhr_id = qpeteamleadtohr.tlhr_id');
		$this->db->join('tlhr_eval_factors', 'tlhr_eval_factors.tlhr_eval_fact_id = tlhr_eval_ratings.tlhr_eval_fact_id');
		$this->db->join('tlhr_categories', 'tlhr_categories.tlhr_cat_id = tlhr_eval_factors.tlhr_eval_cat');
		$this->db->join('user', 'qpeteamleadtohr.tlhr_name = user.User_id');
		$this->db->join('departments', 'departments.dept_id = qpeteamleadtohr.tlhr_department');
		$this->db->join('projects', 'projects.project_id = qpeteamleadtohr.tlhr_project');
		$this->db->join('designations', 'designations.designation_id = qpeteamleadtohr.tlhr_designation');
		
		$query = $this->db->get_where('qpeteamleadtohr',array('qpeteamleadtohr.tlhr_id' => $tlhr_id));

		return $query->result_array();
	}


	// get all Users/Members(members Only) 
	public function lthr_all_members(){
		$user_id = $this->session->userdata('user_id');
		$qry_all_members =$this->db->query("SELECT `User_id`,`Firstname`, `Lastname` FROM `user` WHERE  `Designation`='Member' AND `User_id`!= ". $user_id ." AND user.user_id NOT IN (SELECT tlhr_name from qpeteamleadtohr) ");
		$all_members = $qry_all_members->result_array();
		return $all_members;
	}

	// Delete Evaluation item lthr (Team Lead to H.R)
	public function delete_evaluate_lthr_item($tlhr_id=0){
		$this->db->where('tlhr_id', $tlhr_id);
		if($this->db->delete('qpeteamleadtohr')){
			$this->db->where('tlhr_id', $tlhr_id);
			$this->db->delete('tlhr_eval_ratings');
			return true;	
		}
	}

/* 
********************************************************								
 	TEAM LEAD TO TEAM MEMBERS (ltm) FUNCTIONS STARTS	
********************************************************								
*/
		// Get All Factors ltm (Team Lead to Member)
		public function ltm_get_factors($limit = FALSE, $offset = FALSE){

			$this->db->join('tlm_categories', 'tlm_cat_id = tlm_eval_cat');
			$query = $this->db->get('tlm_eval_factors');
			return $query->result_array();
		
		}
		// Get Selected Factors ltm (Team Lead to Member)
		public function ltm_get_selected_factors($tlm_name=0,$tlm_id=0){
			// check if user exists in ratings table
			$user_id = $this->session->userdata('user_id');
			$this->db->join('qpeteamleadtomember', 'qpeteamleadtomember.tlm_id = tlm_eval_ratings.tlm_id');
			$this->db->where(array('tlm_eval_ratings.User_id' => $user_id));
			$this->db->where(array('qpeteamleadtomember.tlm_name' => $tlm_name));
			$query = $this->db->get('tlm_eval_ratings');
			$check_array = $query->result_array();
			// echo $this->db->last_query();
			// exit;
			// If user exists in the table
			if(!empty($check_array) && !empty($tlm_name)){
				$this->db->join('tlm_eval_factors', 'tlm_eval_factors.tlm_eval_fact_id =  tlm_eval_ratings.tlm_eval_fact_id');
				$this->db->join('tlm_categories', 'tlm_categories.tlm_cat_id = tlm_eval_factors.tlm_eval_cat');
				$this->db->join('qpeteamleadtomember', 'qpeteamleadtomember.tlm_id = tlm_eval_ratings.tlm_id');
				$this->db->join('user', 'user.User_id = qpeteamleadtomember.tlm_name');
				$this->db->where(array('qpeteamleadtomember.tlm_name' => $tlm_name));
				$query = $this->db->get('tlm_eval_ratings');
				// echo $this->db->last_query();
				// print_r($query->result_array());
				// exit;
				return $query->result_array();
			}
			// else if user doesn't exists in the table
		    else{
		    	$this->db->join('tlm_categories', 'tlm_cat_id = tlm_eval_cat');
				$query = $this->db->get('tlm_eval_factors');

				return $query->result_array();

		    }
		}
		

		// Get Factors by id ltm (Team Lead to Member)
		public function ltm_get_factors_by_id($factors_id){
			$factors_id = $this->uri->segment(3);			
			$this->db->join('tlm_categories', 'tlm_cat_id = tlm_eval_cat');
			$query = $this->db->get_where('tlm_eval_factors', array('tlm_eval_fact_id' => $factors_id));
			return $query->row_array();
		}

		// Insert Evaluation ltm (Team Lead to Member)
		public function evaluate_ltm($data,$user_id=0,$tlm_id=0){
			// get all values
			$data_category = array(
					'tlm_name' => $this->input->post('user_name'),
					'tlm_designation' => $this->input->post('user_designation'),
					'tlm_lead_name' => $this->input->post('lead_name'),
					'tlm_lead_type' => $this->input->post('selectLeadType'),
					'tlm_department' => $this->input->post('user_department'),
					'tlm_joining_date' => $this->input->post('user_joining_date'),
					'tlm_quarter' => $this->input->post('evaluation_quarter'),
					'tlm_project' => $this->input->post('user_project'),
					'tlm_date' => $this->input->post('evaluation_date'),
					'tlm_recommendations' => $this->input->post('evaluate_recommendation'),
				);
				
				$session_user_id = $this->session->userdata('user_id');
				// Check into ratings table if user exists and user evaluator exists
				$tlm_name = $this->input->post('user_name');
				$this->db->join('qpeteamleadtomember', 'qpeteamleadtomember.tlm_id = tlm_eval_ratings.tlm_id');
				$this->db->where(array('tlm_eval_ratings.User_id' => $session_user_id));
				$this->db->where(array('qpeteamleadtomember.tlm_name' => $tlm_name));
				$query = $this->db->get('tlm_eval_ratings');
				$check_array = $query->result_array();

				if(empty($check_array)){
				$this->db->set('tlm_created_date', 'NOW()', FALSE);
				$this->db->set('tlm_modified_date', 'NOW()', FALSE);
				// Insert into qpeteamleadtomember table
				$result =  $this->db->insert('qpeteamleadtomember', $data_category);
				$insert_id = $this->db->insert_id();

				// Check If qpeteamleadtomember inserted
				if($insert_id){
					$count = $data['count_factors'];

					// Category data array
					for ($i=1; $i <= $count ; $i++) { 
						$data_factors = array(
						'tlm_rating_number' => $this->input->post('btn_radio_rating'.$i),
						'tlm_rating_avg' => '0',
						'tlm_rating_remarks' => $this->input->post('remarks'.$i),
						'tlm_overall_rating' => $this->input->post('overall_rating'),
						'tlm_eval_fact_id' => $this->input->post('eval_fact_id'.$i),
						'User_id' => $data['user_id'],
						'tlm_id' => $insert_id,
						);
					$this->db->set('tlm_rating_created_date', 'NOW()', FALSE);
					$this->db->set('tlm_rating_modified_date', 'NOW()', FALSE);

					// Insert Rating
					$result =  $this->db->insert('tlm_eval_ratings', $data_factors);
					
				   }
				   return $result;
				}
			} // update if already inserted the evaluation
			else{
				$tlm_id = $this->input->post('tlm_id');
				$this->db->where(array('tlm_eval_ratings.User_id' => $user_id));
				$this->db->where(array('tlm_eval_ratings.tlm_id' => $tlm_id));
				$query = $this->db->get('tlm_eval_ratings');
				// echo $this->db->last_query();
				$eval_rating = $query->result_array();
				$count = COUNT($eval_rating);
				// Update ratings table
				for ($i=1; $i <= $count ; $i++) { 
						$rating_id = $this->input->post('tlm_rating_'.$i);
						$data_factors = array(
						'tlm_rating_number' => $this->input->post('btn_radio_rating'.$i),
						'tlm_rating_avg' => '0',
						'tlm_overall_rating' => $this->input->post('overall_rating'),
						'tlm_rating_remarks' => $this->input->post('remarks'.$i),
						'tlm_eval_fact_id' => $this->input->post('eval_fact_id'.$i),
						'User_id' => $data['user_id'],
						);
					$this->db->set('tlm_rating_modified_date', 'NOW()', FALSE);

					// Insert Rating
					$this->db->where('tlm_rating_id', $rating_id);
					$result =  $this->db->update('tlm_eval_ratings', $data_factors);
				   }
				// Update qpeteamleader table   
				if($result){
					
					$tlm_id = $this->input->post('tlm_id');
					$this->db->where('tlm_id', $tlm_id);
					$this->db->set('tlm_modified_date', 'NOW()', FALSE);
					$result =  $this->db->update('qpeteamleadtomember', $data_category);

				}   
				return $result;
			}

		}

	// Show Evaluate list ltm (Team Lead to Member)
	public function evaluate_ltm_list(){
						
		$this->db->join('tlm_eval_ratings', 'tlm_eval_ratings.tlm_id = qpeteamleadtomember.tlm_id');
		$this->db->join('tlm_eval_factors', 'tlm_eval_factors.tlm_eval_fact_id = tlm_eval_ratings.tlm_eval_fact_id');
		$this->db->join('tlm_categories', 'tlm_categories.tlm_cat_id = tlm_eval_factors.tlm_eval_cat');
		$this->db->join('user', 'user.User_id = qpeteamleadtomember.tlm_name');
		$this->db->join('departments', 'departments.dept_id = qpeteamleadtomember.tlm_department');
		$this->db->join('projects', 'projects.project_id = qpeteamleadtomember.tlm_project');
		$this->db->join('designations', 'designations.designation_id = qpeteamleadtomember.tlm_designation');
		
		$this->db->group_by("qpeteamleadtomember.tlm_id");
		$query = $this->db->get('qpeteamleadtomember');

		return $query->result_array();
	}

	// Show Evaluation List Detail ltm (Team Lead to Member)
	public function evaluate_ltm_list_detail($tlm_id){
						
		$this->db->join('tlm_eval_ratings', 'tlm_eval_ratings.tlm_id = qpeteamleadtomember.tlm_id');
		$this->db->join('tlm_eval_factors', 'tlm_eval_factors.tlm_eval_fact_id = tlm_eval_ratings.tlm_eval_fact_id');
		$this->db->join('tlm_categories', 'tlm_categories.tlm_cat_id = tlm_eval_factors.tlm_eval_cat');
		$this->db->join('user', 'qpeteamleadtomember.tlm_name = user.User_id');
		$this->db->join('departments', 'departments.dept_id = qpeteamleadtomember.tlm_department');
		$this->db->join('projects', 'projects.project_id = qpeteamleadtomember.tlm_project');
		$this->db->join('designations', 'designations.designation_id = qpeteamleadtomember.tlm_designation');

		$query = $this->db->get_where('qpeteamleadtomember',array('qpeteamleadtomember.tlm_id' => $tlm_id));

		return $query->result_array();
	}


	// get all Users/Members(members Only) Evaluated Users ltm (Team Lead to Member)
	public function ltm_all_members(){
		$user_id = $this->session->userdata('user_id');
		$qry_all_members =$this->db->query("SELECT `User_id`,`Firstname`, `Lastname` FROM `user` WHERE  `Designation`='Member' AND `User_id`!= ". $user_id ." AND user.user_id NOT IN (SELECT tlm_name from qpeteamleadtomember) ");
		$all_members = $qry_all_members->result_array();
		return $all_members;
	}

	// Delete Evaluation item ltm (Team Lead to Member)
	public function delete_evaluate_ltm_item($tlm_id=0){
		$this->db->where('tlm_id', $tlm_id);
		if($this->db->delete('qpeteamleadtomember')){
			$this->db->where('tlm_id', $tlm_id);
			$this->db->delete('tlm_eval_ratings');
			return true;	
		}
	}

/* 
********************************************************								
 	TEAM Members TO TEAM Lead (mtl) FUNCTIONS STARTS	
********************************************************								
*/
		// Get All Factors mtl (  Member To Team Lead )
		public function mtl_get_factors($limit = FALSE, $offset = FALSE){

			$this->db->join('mtl_categories', 'mtl_cat_id = mtl_eval_cat');
			$query = $this->db->get('mtl_eval_factors');
			return $query->result_array();
		
		}
		// Get Selected Factors mtl ( Member To Team Lead )
		public function mtl_get_selected_factors($eval_id=0,$factor_type=''){
			// check if user exists in ratings table
			$user_id = $this->session->userdata('user_id');
			$this->db->join('qpe_evaluation', 'qpe_evaluation.id = qpe_ratings.mtl_id');
			$this->db->where(array('qpe_evaluation.user_id' => $user_id));
			$this->db->where(array('qpe_evaluation.id' => $eval_id));
			$query = $this->db->get('qpe_ratings');
			$check_array = $query->result_array();
			 //echo $this->db->last_query();
			// exit;
			// If user exists in the table
			if(!empty($check_array) && !empty($user_id)){
				$this->db->select('qpe_ratings.mtl_id,qpe_ratings.mtl_rating_remarks,qpe_ratings.mtl_rating_number,qpe_ratings.mtl_rating_id,qpe_eval_factors.description,qpe_eval_factors.factor_type,qpe_categories.name,qpe_categories.id as cat_id,qpe_eval_factors.id as fac_id');

				$this->db->join('qpe_eval_factors', 'qpe_eval_factors.id =  qpe_ratings.mtl_eval_fact_id','inner');
				$this->db->join('qpe_categories', 'qpe_categories.id = qpe_eval_factors.category','inner');
				$this->db->join('qpe_evaluation', 'qpe_evaluation.id = qpe_ratings.mtl_id','inner');
				$this->db->join('user', 'user.User_id = qpe_evaluation.user_id','inner');
				$this->db->where(array('qpe_evaluation.user_id' => $user_id));
				$this->db->where(array('qpe_evaluation.id' => $eval_id));
				$this->db->where(array('qpe_eval_factors.factor_type' => $factor_type));
				$query = $this->db->get('qpe_ratings');
				//echo $this->db->last_query();
				//print_r($query->result_array());
				//exit;
				return $query->result_array();
			}
			// else if user doesn't exists in the table
		    else{ 
		    	$this->db->select('qpe_eval_factors.description,qpe_eval_factors.factor_type,qpe_categories.name,qpe_categories.id as cat_id,qpe_eval_factors.id as fac_id');
		    	$this->db->join('qpe_categories', 'qpe_categories.id = qpe_eval_factors.id');
		    	$this->db->where(array('qpe_eval_factors.factor_type' => $factor_type));
				$query = $this->db->get('qpe_eval_factors');
				//echo $this->db->last_query();
				return $query->result_array();

		    }
		}
		

		// Get Factors by id mtl ( Member To Team Lead)
		public function mtl_get_factors_by_id($factors_id){
			$factors_id = $this->uri->segment(3);			
			$this->db->join('mtl_categories', 'mtl_cat_id = mtl_eval_cat');
			$query = $this->db->get_where('mtl_eval_factors', array('mtl_eval_fact_id' => $factors_id));
			return $query->row_array();
		}

		// Insert Evaluation mtl ( Member To Team Lead )
		public function evaluate_mtl($data,$user_id=0,$mtl_id=0){
			// get all values
			$session_user_id = $this->session->userdata('user_id');
			$data_category = array(
				'status'	=> '1',
				'user_id' =>$session_user_id,
				'evaluate_user' =>$this->input->post('evaluate_user'),
				'created_date' => date('Y-m-d'),
				'modified_date' => date('Y-m-d'),
				'recommendations' => $this->input->post('evaluate_recommendation')
			);
			// Check into ratings table if user exists and user evaluator exists
			 

			if($this->input->post('post_type') == 'insert'){
				// Insert into qpe_evaluation table
				$result =  $this->db->insert('qpe_evaluation', $data_category);
				$insert_id = $this->db->insert_id();
				// Check If qpe_evaluation inserted
				if($insert_id){
					$count = $data['count_factors'];
					// Category data array
					for ($i=1; $i <= $count ; $i++) { 
						$data_factors = array(
							'mtl_rating_number' => $this->input->post('btn_radio_rating'.$i),
							'mtl_rating_avg' => '0',
							'mtl_rating_remarks' => $this->input->post('remarks'.$i),
							// 'mtl_overall_rating' => $this->input->post('overall_rating'),
							'mtl_eval_fact_id' => $this->input->post('eval_fact_id'.$i),
							'User_id' => $data['user_id'],
							'mtl_rating_created_date' => date('Y-m-d'),
							'mtl_rating_modified_date' => date('Y-m-d'),
							'mtl_id' => $insert_id,
						); 
						// Insert Rating
						$result =  $this->db->insert('qpe_ratings', $data_factors);
					
				   }
				   return $result;
				}
			}elseif($this->input->post('post_type') == 'update'){

				// update if already inserted the evaluation
				$mtl_id = $this->input->post('mtl_id');
				$this->db->where(array('qpe_ratings.User_id' => $session_user_id));
				$this->db->where(array('qpe_ratings.mtl_id' => $mtl_id));
				$query = $this->db->get('qpe_ratings');
				// echo $this->db->last_query();
				// exit();
				$eval_rating = $query->result_array();
				$count = COUNT($eval_rating);
				
				// Update ratings table
				for ($i=1; $i <= $count ; $i++) { 
						$rating_id = $this->input->post('mtl_rating_'.$i);
						$data_factors = array(
						'mtl_rating_number' => $this->input->post('btn_radio_rating'.$i),
						'mtl_rating_avg' => '0',
						'mtl_rating_remarks' => $this->input->post('remarks'.$i),
						//'mtl_overall_rating' => $this->input->post('overall_rating'),
						'mtl_eval_fact_id' => $this->input->post('eval_fact_id'.$i),
						'User_id' => $data['user_id'],
						);
					$this->db->set('mtl_rating_modified_date', 'NOW()', FALSE);

					// Insert Rating
					$this->db->where('mtl_rating_id', $rating_id);
					$result =  $this->db->update('qpe_ratings', $data_factors);
				}
				// Update qpeteamleader table   
				if($result){
					
					$mtl_id = $this->input->post('mtl_id');
					$this->db->where('id', $mtl_id);
					$this->db->set('modified_date', 'NOW()', FALSE);
					$result =  $this->db->update('qpe_evaluation', $data_category);

				}   
				return $result;
			}

		}

		// Show Evaluate list mtl ( Member To Team Lead )
		public function evaluate_mtl_list(){
							
			$this->db->join('qpe_ratings', 'qpe_ratings.mtl_id = qpe_evaluation.id');
			$this->db->join('mtl_eval_factors', 'mtl_eval_factors.mtl_eval_fact_id = qpe_ratings.mtl_eval_fact_id');
			$this->db->join('mtl_categories', 'mtl_categories.mtl_cat_id = mtl_eval_factors.mtl_eval_cat');
			$this->db->join('user', 'user.User_id = qpe_evaluation.user_id');
			$this->db->join('departments', 'departments.dept_id = qpe_evaluation.mtl_department');
			$this->db->join('projects', 'projects.project_id = qpe_evaluation.mtl_project');
			$this->db->join('designations', 'designations.designation_id = qpe_evaluation.mtl_designation');
			
			$this->db->group_by("qpe_evaluation.id");
			$query = $this->db->get('qpe_evaluation');

			return $query->result_array();
		}

		// Show Evaluation List Detail mtl ( Member To Team Lead )
		public function evaluate_mtl_list_detail($mtl_id){
							
			$this->db->join('qpe_ratings', 'qpe_ratings.mtl_id = qpe_evaluation.id');
			$this->db->join('mtl_eval_factors', 'mtl_eval_factors.mtl_eval_fact_id = qpe_ratings.mtl_eval_fact_id');
			$this->db->join('mtl_categories', 'mtl_categories.mtl_cat_id = mtl_eval_factors.mtl_eval_cat');
			$this->db->join('user', 'qpe_evaluation.user_id = user.User_id');
			$this->db->join('departments', 'departments.dept_id = qpe_evaluation.mtl_department');
			$this->db->join('projects', 'projects.project_id = qpe_evaluation.mtl_project');
			$this->db->join('designations', 'designations.designation_id = qpe_evaluation.mtl_designation');

			$query = $this->db->get_where('qpe_evaluation',array('qpe_evaluation.id' => $mtl_id));

			return $query->result_array();
		}


		// get all Users/Members(members Only) Evaluated Users mtl ( Member To Team Lead )
		public function mtl_all_members(){
			$user_id = $this->session->userdata('user_id');
			$qry_all_members =$this->db->query("SELECT `User_id`,`Firstname`, `Lastname` FROM `user` WHERE  `Designation`='Member' AND `User_id`!= ". $user_id ." AND user.user_id NOT IN (SELECT user_id from qpe_evaluation) ");
			$all_members = $qry_all_members->result_array();
			return $all_members;
		}

		public function department_members($user_id, $nextid=''){
			$nextrec ='';
			if($nextid !=''){
				$nextrec =" AND a.`User_id`= ". $nextid ."";
			}

			$department = $this->session->userdata('department');
			$this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name,a.User_type');
	        $this->db->from('user a');
	        $this->db->join('departments b','a.department=b.dept_id','INNER');
	        $this->db->join('designations c','a.Designation=c.designation_id','INNER');
	        $this->db->where(" a.`User_id`!= ". $user_id ." ".$nextrec." AND a.department='".$department."' and a.Joining_date <= NOW() - INTERVAL 3 MONTH and (a.User_type`='Member' or a.User_type`='TeamLead')");

	        $this->db->order_by('User_id', 'desc');
	        $this->db->limit('1');
	        $query = $this->db->get();
	        //echo $this->db->last_query();
	        return $query->row_array();

		}
		public function department_members_nextid($user_id, $nextid=''){			
			 
			$department = $this->session->userdata('department');
			$this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name,a.User_type');
	        $this->db->from('user a');
	        $this->db->join('departments b','a.department=b.dept_id','INNER');
	        $this->db->join('designations c','a.Designation=c.designation_id','INNER');
	        $this->db->where(" a.`User_id`!= ". $user_id ."  AND a.`User_id`= '". $nextid ."' AND a.department='".$department."' and a.Joining_date <= NOW() - INTERVAL 3 MONTH and (a.User_type`='Member' or a.User_type`='TeamLead')");

	        $this->db->order_by('User_id', 'desc');
	        $this->db->limit('1');
	        $query = $this->db->get();
	        //echo $this->db->last_query();
	        return $query->row_array();

		}
		public function eval_by_user_id($evaluate_user,$backid,$order_by){
			$user_id = $this->session->userdata('user_id');
			$this->db->select('*');
	        $this->db->from('qpe_evaluation');
	        $this->db->where("`User_id` = ". $user_id ."");
	        if($evaluate_user !=''){
	        	$this->db->where("`id` = ". $evaluate_user ."");
	        }
	        if($backid !=''){
	        	$this->db->where("`id` < ". $backid ."");
	        }
	        $this->db->order_by('id', $order_by);
	        $query = $this->db->get();
	        
	        return $query->row();
	        
		}
		public function eval_by_user_id_nxt($evaluate_user,$backid,$order_by){
			$user_id = $this->session->userdata('user_id');
			$this->db->select('*');
	        $this->db->from('qpe_evaluation');
	        $this->db->where("`User_id` = ". $user_id ."");
	        if($evaluate_user !=''){
	        	$this->db->where("`id` = ". $evaluate_user ."");
	        }
	        if($backid !=''){
	        	$this->db->where("`id` > ". $backid ."");
	        }
	        $this->db->order_by('id', $order_by);
	        $query = $this->db->get();
	        
	        return $query->row();
	        
		}
		public function evalute_user_ids(){
			$user_id = $this->session->userdata('user_id');
			$this->db->select("GROUP_CONCAT(evaluate_user SEPARATOR ',') as ids");
	        $this->db->from('qpe_evaluation');
	        $this->db->where("`User_id` = ". $user_id ."");
	        $query = $this->db->get();
	        return $query->row();
	        
		}
		public function evalute_user($ids){
			$user_id = $this->session->userdata('user_id');
			$department = $this->session->userdata('department');
	        $this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name');
	        $this->db->from('user a');
	        $this->db->join('departments b','a.department=b.dept_id','INNER');
	        $this->db->join('designations c','a.Designation=c.designation_id','INNER');
	        $this->db->where("a.User_type`='Member' AND a.department='".$department."' and a.Joining_date <= NOW() - INTERVAL 3 MONTH");
	        if($ids !=''){
	        	$this->db->where("`User_id` NOT IN (". $ids .','.$user_id.")");
	        }else{
	        	$this->db->where("`User_id` NOT IN (".$user_id.")");
	        }
	        
	      //  $this->db->where("`User_id` != ". $user_id ."");
	        $this->db->order_by('User_id', 'desc');
	        $this->db->limit('1');
	        $query = $this->db->get();
	        //echo $this->db->last_query();
	        return $query->row();

		}
		public function evalute_user_last($ids){
			$user_id = $this->session->userdata('user_id');
			$department = $this->session->userdata('department');
	        $this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name');
	        $this->db->from('user a');
	        $this->db->join('departments b','a.department=b.dept_id','INNER');
	        $this->db->join('designations c','a.Designation=c.designation_id','INNER');
	        $this->db->where("a.User_type`='Member' AND a.department='".$department."' and a.Joining_date <= NOW() - INTERVAL 3 MONTH");
	        if($ids !=''){
	        	$this->db->where("`User_id` NOT IN (". $ids .','.$user_id.")");
	        }else{
	        	$this->db->where("`User_id` NOT IN (".$user_id.")");
	        }
	      //  $this->db->where("`User_id` != ". $user_id ."");
	      //  $this->db->order_by('User_id', 'desc');
	       // $this->db->limit('1');
	        $query = $this->db->get();
	        //echo $this->db->last_query();
	        return $query->result();

		}
		// Delete Evaluation item mtl ( Member To Team Lead )
		public function delete_evaluate_mtl_item($mtl_id=0){
			$this->db->where('mtl_id', $mtl_id);
			if($this->db->delete('qpe_evaluation')){
				$this->db->where('mtl_id', $mtl_id);
				$this->db->delete('qpe_ratings');
				return true;	
			}
		}

}