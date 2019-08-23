<?php
class Rating_model extends CI_Model{
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
		$query = $this->db->get('qpe_evaluation');
		return $query->result_array();
	}
	public function evaluate_list_by_department($department){
		$this->db->select('f.factor_type,a.user_id as evltr,b.User_type,a.evaluate_user as eval_id,b.User_id,b.Firstname,b.Lastname,d.designation_name,c.dept_name');
		$this->db->from('qpe_evaluation a');
		$this->db->join('qpe_user b', 'a.evaluate_user = b.User_id');
		$this->db->join('qpe_departments c', 'c.dept_id = b.department');
		$this->db->join('qpe_designations d', 'd.designation_id = b.Designation');
		$this->db->join('qpe_ratings e', 'e.eval_id = a.id');
		$this->db->join('qpe_eval_factors f', 'f.id = e.eval_fact_id');
		$this->db->where('b.department',$department);
		$this->db->group_by('a.evaluate_user');
		$query = $this->db->get();
		// echo $this->db->last_query();
		// exit();
		return $query->result_array();
	}
	public function evaluate_list_by_department_byId($id){
		$this->db->select('e.id as ratid,f.factor_type,a.user_id as evltr,b.User_type,a.evaluate_user as eval_id,b.User_id,b.Firstname,b.Lastname,d.designation_name,c.dept_name');
		$this->db->from('qpe_evaluation a');
		$this->db->join('qpe_user b', 'a.evaluate_user = b.User_id');
		$this->db->join('qpe_departments c', 'c.dept_id = b.department');
		$this->db->join('qpe_designations d', 'd.designation_id = b.Designation');
		$this->db->join('qpe_ratings e', 'e.eval_id = a.id');
		$this->db->join('qpe_eval_factors f', 'f.id = e.eval_fact_id');
		$this->db->where('a.evaluate_user',$id);
		$this->db->group_by('f.factor_type');
		$query = $this->db->get();
		 //echo $this->db->last_query();
		// exit();
		return $query->result_array();
	}
	// Show Evaluation List Detail lthr (Team Lead to H.R)
	public function evaluate_member_detail($id, $order_by,$quarter=''){
						 
		$this->db->select('a.user_id as user_id,a.id as eval_id,a.evaluate_user,b.Firstname,b.Firstname,b.Lastname,d.designation_name,c.dept_name,b.Team_lead,b.Firstname');
        $this->db->from('qpe_evaluation a'); 
        if($id !=''){
        	$this->db->where("a.`evaluate_user` = ". $id ."");
        }
        if($quarter !=''){
        	$this->db->where("QUARTER(DATE_ADD(a.created_date,INTERVAL -60 DAY)) = ". $quarter ."");
        }
        
        $this->db->join('qpe_user b', 'a.user_id = b.User_id');
        $this->db->join('qpe_departments c', 'b.department = c.dept_id');
        $this->db->join('qpe_designations d', 'd.designation_id = b.Designation');
        $this->db->order_by('a.id', $order_by);
        $query = $this->db->get();
         //echo $this->db->last_query();
        // exit();
        return $query->row_array();
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
	// get all Users/Members(members Only) Evaluated Users mtl ( Member To Team Lead )
	public function mtl_all_members(){
		$user_id = $this->session->userdata('user_id');
		$qry_all_members =$this->db->query("SELECT `User_id`,`Firstname`, `Lastname` FROM `qpe_user` WHERE  `Designation`='Member' AND `User_id`!= ". $user_id ." AND qpe_user.user_id NOT IN (SELECT user_id from qpe_evaluation) ");
		$all_members = $qry_all_members->result_array();
		return $all_members;
	}

	public function department_members($user_id, $nextid=''){
		$nextrec ='';
		$selfid ='';
		if($nextid !=''){
			$nextrec =" AND a.`User_id`= ". $nextid ."";
		}
		
		if($nextid ==''){
			if($user_id == '76'){
				$selfid =" AND a.`User_id` !=39 " ;
			}
			if($user_id == '44'){
				$selfid =" AND a.`User_id` !=78 ";
			}
		}
			$assign = $this->get_assign_leads();
        
		$department = $this->session->userdata('department');
		$this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name,a.User_type');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where(" a.`User_id`!= ". $user_id ." ".$selfid." ".$nextrec." AND a.department='".$department."' and a.Joining_date <= NOW() - INTERVAL 3 MONTH and (a.User_type`='Member' or a.User_type`='TeamLead' or a.User_type`='CEO')");
       
       if($department == '17'){
       		if(!empty(json_decode($assign->assign_team_leads)))	{
	        	$this->db->or_where("a.User_id IN ('".implode("','", json_decode($assign->assign_team_leads))."'	) ");
	        }
       	}else{
       		if(!empty(json_decode($assign->assign_team_leads)) && $nextid !='')	{
	        	$this->db->or_where("a.User_id IN ('".implode("','", json_decode($assign->assign_team_leads))."'	) ");
	        }
       	}
		// if(!empty(json_decode($assign->assign_team_leads)) && $nextid !='')	{
  //       	$this->db->or_where("a.User_id IN ('".implode("','", json_decode($assign->assign_team_leads))."'	) ");
  //       }
       	$this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
        return $query->row_array();

	}
	public function get_assign_leads(){

		$user_id = $this->session->userdata('user_id');
		$this->db->select('*');
        $this->db->from('qpe_user');
        $this->db->where("`User_id` = ". $user_id ."");
        $query1 = $this->db->get();
        return $query1->row();
        
	}
	public function department_members_nextid($user_id, $nextid=''){			
		 
		$department = $this->session->userdata('department');
			$assign = $this->get_assign_leads();
        
        if($nextid !='' && in_array($nextid, json_decode($assign->assign_team_leads)) ){
        	$department ='';
        }else{
        	$department ="AND a.department='".$department."'";
        }
		$this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name,a.User_type');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where(" a.`User_id`!= ". $user_id ."  AND a.`User_id`= '". $nextid ."' ".$department." and a.Joining_date <= NOW() - INTERVAL 3 MONTH and (a.User_type`='Member' or a.User_type`='TeamLead' or a.User_type`='CEO' or `a`.`User_type` = 'SiteLead')");

        // if(!empty(json_decode($assign->assign_team_leads)))	{
        // 	$this->db->or_where("a.User_id IN ('".implode("','", json_decode($assign->assign_team_leads))."'	) ");
        // }
        $this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        // echo $this->db->last_query();
        // exit();
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
        // echo $this->db->last_query();
        // exit();
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
	public function evalute_user_ids($curentQuarter){
		$user_id = $this->session->userdata('user_id');
		$this->db->select("GROUP_CONCAT(evaluate_user SEPARATOR ',') as ids");
        $this->db->from('qpe_evaluation');
        $this->db->where("QUARTER(DATE_ADD(created_date,INTERVAL -60 DAY)) = '".substr($curentQuarter, 0,1)."' and YEAR(`created_date`)='".date('Y')."' ");
        $this->db->where("`User_id` = ". $user_id ."");
        $query = $this->db->get();

        return $query->row();
        
	}
	public function evalute_user($ids){
		$user_id = $this->session->userdata('user_id');
		$department = $this->session->userdata('department');
		$assign = $this->get_assign_leads();
        
        $this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where(" a.department='".$department."' and a.Joining_date <= NOW() - INTERVAL 3 MONTH");
        if($department == '10'){
        	$this->db->where("a.User_type !='hr'");
        	$this->db->where("a.User_type !='CEO'");
        	$this->db->where("a.User_type !='trainer'");
        }
        if($department == '7'){
        	$this->db->where("a.User_type !='SiteLead'");
        }
        if($this->session->userdata('user_type') == 'TeamLead'){
        	if($user_id == '76'){
				$selfid = '39';
				$self =",". $selfid ."";
			}
			if($user_id == '44'){
				$selfid = '78';
				$self =",". $selfid ."";
			}
			

        }else{
        	$self ="";
        }
        //$this->db->where("`User_id` IN (". $ids .")");
        if($ids !=''){
        	$this->db->where("`User_id` NOT IN (". $ids .','.$user_id.$self.")");
        }else{
        	$this->db->where("`User_id` NOT IN (".$user_id.$self.")");
        }
        //print_r($assign);
        if(!empty(json_decode($assign->assign_team_leads)))	{
        	$arr =json_decode($assign->assign_team_leads);

			for ($i=0; $i < count(explode(',', $ids)); $i++) { 
				//print_r($arr);
				if(in_array(explode(',', $ids)[$i], $arr)){
					$pos = array_search(explode(',', $ids)[$i], $arr);
				}else{ } 
				unset($arr[$pos]);
			}
        	$this->db->or_where("User_id IN ('".implode("','", $arr)."'	) ");
        }
        $this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        //  echo $this->db->last_query();
        // exit();
        return $query->row();

	}
	public function evalute_user_last($ids){
		$user_id = $this->session->userdata('user_id');
		$department = $this->session->userdata('department');
		$assign = $this->get_assign_leads();
        
        if($this->session->userdata('user_type') == 'SiteLead' || $this->session->userdata('user_type') == 'CEO'){
        	if($user_id == '39'){
				$selfid = '76';
				$self =",". $selfid ."";
			}
			if($user_id == '78'){
				$selfid = '44';
				$self =",". $selfid ."";
			}
			

        }else{
        	$self ="";
        }
        if($this->session->userdata('user_type') == 'TeamLead'){
        	if($user_id == '76'){
				$selfid = '39';
				$self =",". $selfid ."";
			}
			if($user_id == '44'){
				$selfid = '78';
				$self =",". $selfid ."";
			}
			

        }else{
        	$self ="";
        }

        $this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where("a.department='".$department."' and a.Joining_date <= NOW() - INTERVAL 3 MONTH");
        $this->db->where("a.status",'Enable');
        
        if($ids !=''){
        	$this->db->where("`User_id` NOT IN (". $ids .','.$user_id.$self.")");
        }else{
        	$this->db->where("`User_id` NOT IN (".$user_id.$self.")");
        }
        if($department == '10'){
        	$this->db->where("a.User_type !='hr'");
        	$this->db->where("a.User_type !='CEO'");
        	$this->db->where("a.User_type !='trainer'");
        }
        if($department == '7'){
        	$this->db->where("a.User_type !='SiteLead'");
        }
        if(!empty(json_decode($assign->assign_team_leads)))	{
        	$arr =json_decode($assign->assign_team_leads);
			for ($i=0; $i < count(explode(',', $ids)); $i++) { 
				//print_r($arr);
				if(in_array(explode(',', $ids)[$i], $arr)){
					$pos = array_search(explode(',', $ids)[$i], $arr);
				}else{ } 
				unset($arr[$pos]);
			}
        	$this->db->or_where("User_id IN ('".implode("','", $arr)."'	) ");
        }
        $query = $this->db->get();
         //echo $this->db->last_query();
		// exit;
        return $query->result();

	}
	// Delete Evaluation item mtl ( Member To Team Lead )
	public function delete_evaluate_mtl_item($mtl_id=0){
		$this->db->where('id', $mtl_id);
		if($this->db->delete('qpe_evaluation')){
			$this->db->where('id', $mtl_id);
			$this->db->delete('qpe_ratings');
			return true;	
		}
	}
	// Get All Factors mtl (  Member To Team Lead )
	public function mtl_get_factors($limit = FALSE, $offset = FALSE){

		$this->db->join('qpe_member_categories', 'mtl_cat_id = mtl_eval_cat');
		$query = $this->db->get('qpe_member_eval_factors');
		return $query->result_array();
	
	}
	// Get Selected Factors 
	public function get_selected_factors($eval_id=0,$factor_type=''){
		// check if user exists in ratings table
		$user_id = $this->session->userdata('user_id');
		$this->db->join('qpe_evaluation', 'qpe_evaluation.id = qpe_ratings.eval_id');
		$this->db->where(array('qpe_evaluation.user_id' => $user_id));
		$this->db->where(array('qpe_evaluation.id' => $eval_id));
		$query = $this->db->get('qpe_ratings');
		$check_array = $query->result_array();
		 //echo $this->db->last_query();
		// exit;
		// If user exists in the table
		if(!empty($check_array) && !empty($user_id)){
			$this->db->select('qpe_ratings.id as rating_id,qpe_ratings.rating_remarks,qpe_ratings.rating_number,qpe_ratings.id as mtl_rating_id,qpe_eval_factors.description,qpe_eval_factors.factor_type,qpe_categories.name,qpe_categories.id as cat_id,qpe_eval_factors.id as fac_id');

			$this->db->join('qpe_eval_factors', 'qpe_eval_factors.id =  qpe_ratings.eval_fact_id','inner');
			$this->db->join('qpe_categories', 'qpe_categories.id = qpe_eval_factors.category','inner');
			$this->db->join('qpe_evaluation', 'qpe_evaluation.id = qpe_ratings.eval_id','inner');
			$this->db->join('qpe_user', 'qpe_user.User_id = qpe_evaluation.user_id','inner');
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
	// Insert Evaluation mtl ( Member To Team Lead )
	public function evaluate_member($data,$user_id=0,$mtl_id=0){
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
						'rating_number' => $this->input->post('btn_radio_rating'.$i),
						'rating_avg' => '0',
						'rating_remarks' => $this->input->post('remarks'.$i),
						'evaluate_user' =>$this->input->post('evaluate_user'),
						'eval_fact_id' => $this->input->post('eval_fact_id'.$i),
						'User_id' => $data['user_id'],
						'rating_created_date' => date('Y-m-d'),
						'rating_modified_date' => date('Y-m-d'),
						'eval_id' => $insert_id,
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
			$this->db->where(array('qpe_ratings.id' => $mtl_id));
			$query = $this->db->get('qpe_ratings');
			// echo $this->db->last_query();
			// exit();
			$eval_rating = $query->result_array();
			$count = COUNT($eval_rating);
			
			// Update ratings table
			for ($i=1; $i <= $count ; $i++) { 
					$rating_id = $this->input->post('mtl_rating_'.$i);
					$data_factors = array(
					'rating_number' => $this->input->post('btn_radio_rating'.$i),
					'rating_avg' => '0',
					'rating_remarks' => $this->input->post('remarks'.$i),
					//'mtl_overall_rating' => $this->input->post('overall_rating'),
					'eval_fact_id' => $this->input->post('eval_fact_id'.$i),
					'User_id' => $data['user_id'],
					);
				$this->db->set('rating_modified_date', 'NOW()', FALSE);

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
	// Get Selected Factors 
	public function view_submited_factors($eval_id,$user_id,$quarter=''){
		 
			$this->db->select('qpe_ratings.id as mtl_rating_id,qpe_ratings.rating_remarks,qpe_ratings.rating_number,qpe_ratings.id as mtl_rating_id,qpe_eval_factors.description,qpe_eval_factors.factor_type,qpe_categories.name,qpe_categories.id as cat_id,qpe_eval_factors.id as fac_id');

			$this->db->join('qpe_eval_factors', 'qpe_eval_factors.id =  qpe_ratings.eval_fact_id','inner');
			$this->db->join('qpe_categories', 'qpe_categories.id = qpe_eval_factors.category','inner');
			$this->db->join('qpe_evaluation', 'qpe_evaluation.id = qpe_ratings.eval_id','inner');
			$this->db->join('qpe_user', 'qpe_user.User_id = qpe_evaluation.evaluate_user','inner');
			$this->db->where(array('qpe_evaluation.id' => $eval_id,'qpe_ratings.user_id' => $user_id));
			if($quarter !=''){
	        	$this->db->where("QUARTER(DATE_ADD(qpe_ratings.`rating_created_date`,INTERVAL -60 DAY)) = ". $quarter ."");
	        }
			$query = $this->db->get('qpe_ratings');
			//echo $this->db->last_query();
			return $query->result_array();
		 
	}
	public function evaluate_list_by_member($uid,$quarter=''){
		$this->db->select('a.id as eval_id,a.user_id,b.Firstname,b.Lastname,d.designation_name,c.dept_name,b.Team_lead,a.created_date,a.recommendations');
		$this->db->from('qpe_evaluation a');
		$this->db->join('qpe_user b', 'a.user_id = b.User_id');
		$this->db->join('qpe_departments c', 'c.dept_id = b.department');
		$this->db->join('qpe_designations d', 'd.designation_id = b.Designation');
		$this->db->where('a.evaluate_user',$uid);
		if($quarter !=''){
        	$this->db->where("QUARTER(DATE_ADD(a.`created_date`,INTERVAL -60 DAY)) = ". $quarter ."");
        }
		$this->db->group_by('a.user_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
 
	public function get_avg_by_id($uid,$u_type,$year ='', $quarter =''){
		$where ='';
		//echo $quarter;
		if($year !='' && $quarter !=''){
			$where =" AND YEAR(rating_created_date) ='".$year."' AND  QUARTER(DATE_ADD(rating_created_date,INTERVAL -60 DAY))  ='".$quarter."'";
		}
		$query = $this->db->query("SELECT AVG(rating_number) as avg FROM `qpe_ratings` a INNER join qpe_user b on a.`User_id`=b.`User_id` WHERE b.User_type='".$u_type."' and a.evaluate_user='".$uid."' ".$where."  ");
	///	echo "SELECT AVG(rating_number) as avg FROM `qpe_ratings` a INNER join qpe_user b on a.`User_id`=b.`User_id` WHERE b.User_type='".$u_type."' and a.evaluate_user='".$uid."' ".$where."  ";
		return $query->row();
	}
	public function get_avg_by_id_multi($uid,$u_type,$rid){
		
		 
		$query = $this->db->query("SELECT AVG(rating_number) as avg FROM `qpe_ratings` a INNER join qpe_user b on a.`User_id`=b.`User_id` WHERE b.User_type='".$u_type."' and a.evaluate_user='".$uid."' and a.id='".$rid."'   ");
		//echo "SELECT AVG(rating_number) as avg FROM `qpe_ratings` a INNER join qpe_user b on a.`User_id`=b.`User_id` WHERE b.User_type='".$u_type."' and a.evaluate_user='".$uid."' ".$where."  ";
		return $query->row();
	}
	public function get_avgBy_yearly($uid){

		$this->db->select('f.factor_type,Year(a.created_date) as year,a.user_id');
		$this->db->from('qpe_evaluation a');
		$this->db->join('qpe_user b', 'a.evaluate_user = b.User_id');
		$this->db->join('qpe_departments c', 'c.dept_id = b.department');
		$this->db->join('qpe_designations d', 'd.designation_id = b.Designation');
		$this->db->join('qpe_ratings e', 'e.eval_id = a.id');
		$this->db->join('qpe_eval_factors f', 'f.id = e.eval_fact_id');
		$this->db->where('a.evaluate_user',$uid);
		$this->db->group_by('YEAR(a.created_date)');
		$this->db->order_by('YEAR(a.created_date)','desc');
		$query = $this->db->get();
		// echo $this->db->last_query();
		// exit(); 
		// $query = $this->db->query("SELECT Year(created_date) as year,user_id FROM `qpe_evaluation` where evaluate_user='".$uid."' GROUP BY YEAR(created_date) order by Year(created_date) desc");
		return $query->result();
	}
	public function get_quarterBy_yearly($year){

		$query = $this->db->query("SELECT QUARTER(DATE_ADD(created_date,INTERVAL -60 DAY)) as quarter FROM `qpe_evaluation` WHERE YEAR(created_date)='".$year."' GROUP BY YEAR(created_date), QUARTER(DATE_ADD(created_date,INTERVAL -60 DAY)) order by YEAR(created_date), QUARTER(DATE_ADD(created_date,INTERVAL -60 DAY)) asc");
		return $query->result();
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
	public function department_members_trainer($user_id, $nextid='',$department=''){
		$nextrec ='';
		$departmentstaus='';
		if($nextid !=''){
			$nextrec =" AND a.`User_id`= ". $nextid ."";
		}
		if($department !=''){
			$departmentstaus =" AND a.department='".$department."'";
		}
		//$department = $this->session->userdata('department');
		$this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name,a.User_type');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where(" a.`User_id`!= ". $user_id ." ".$nextrec." ".$departmentstaus." and a.Joining_date <= NOW() - INTERVAL 3 MONTH and (a.User_type !='SiteLead' and a.User_type !='hr' and a.User_type !='CEO' and a.User_type !='trainer')");
        $this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row_array();

	}
	public function department_members_trainer_nextid($user_id, $nextid='',$department=''){
		$departmentstaus='';	
		if($department !=''){
			$departmentstaus =" AND a.department='".$department."'";
		}
		//$department = $this->session->userdata('department');
		$this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name,a.User_type');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where(" a.`User_id`!= ". $user_id ."  AND a.`User_id`= '". $nextid ."' ".$departmentstaus." and a.Joining_date <= NOW() - INTERVAL 3 MONTH and (a.User_type !='SiteLead' and a.User_type !='hr' and a.User_type !='CEO' and a.User_type !='trainer')");
        $this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
	}
	// Show All qpe_Departments
	public function all_departments(){

		$query = $this->db->query("SELECT qpe_departments.dept_id as id,qpe_departments.dept_name FROM qpe_departments LEFT JOIN qpe_user ON qpe_departments.dept_id = qpe_user.department where (qpe_user.User_type !='SiteLead' and qpe_user.User_type !='hr' and qpe_user.User_type !='CEO' and qpe_user.User_type !='trainer')  GROUP BY qpe_departments.dept_id");
		if($query->result_array()){
			return $query->result_array();
		}
		else{
			return $query->result_array();	
		}			
	}
	public function evalute_trainer_user($ids,$department){
		$departmentstaus='';	
		if($department !=''){
			$departmentstaus =" AND a.department='".$department."'";
		}
		$user_id = $this->session->userdata('user_id');
        $this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where("(a.User_type !='SiteLead' and a.User_type !='hr' and a.User_type !='CEO' and a.User_type !='trainer') ".$departmentstaus." and a.Joining_date <= NOW() - INTERVAL 3 MONTH");
        if($ids !=''){
        	$this->db->where("`User_id` NOT IN (". $ids .','.$user_id.")");
        }else{
        	$this->db->where("`User_id` NOT IN (".$user_id.")");
        }
        $this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();

	}
	public function evalute_SiteLead_user($ids,$department){
		$departmentstaus='';
		if($department !=''){
			$departmentstaus =" AND a.department='".$department."'";
		}
		$user_id = $this->session->userdata('user_id');
		if($user_id == '39'){
			$selfid = '76';
		}
		if($user_id == '78'){
			$selfid = '44';
		}
		
        $this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where("a.User_type ='TeamLead' ".$departmentstaus." and a.Joining_date <= NOW() - INTERVAL 3 MONTH");
        if($ids !=''){
        	$this->db->where("`User_id` NOT IN (". $ids .','.$user_id.','.$selfid.")");
        }else{
        	$this->db->where("`User_id` NOT IN (".$user_id.','.$selfid.")");
        }
        $this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();

	}
	public function department_members_SiteLead($user_id, $nextid='',$department=''){
		$nextrec ='';
		$departmentstaus='';
		if($nextid !=''){
			$nextrec =" AND a.`User_id`= ". $nextid ."";
		}
		if($nextid ==''){
			if($user_id == '39'){
				$selfid =" AND a.`User_id` != 76" ;
			}
			if($user_id == '78'){
				$selfid =" AND a.`User_id` != 44";
			}
		}
		if($department !=''){
			$departmentstaus =" AND a.department='".$department."'";
		}
		//$department = $this->session->userdata('department');
		$this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name,a.User_type');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where(" a.`User_id`!= ". $user_id ." ".$selfid." ".$nextrec." ".$departmentstaus." and a.Joining_date <= NOW() - INTERVAL 3 MONTH and a.User_type`='TeamLead'");
        $this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
	}
	public function department_members_SiteLead_nextid($user_id, $nextid='',$department=''){
		$departmentstaus='';	
		if($department !=''){
			$departmentstaus =" AND a.department='".$department."'";
		}
		$this->db->select('a.Team_lead,a.`User_id`,a.`Firstname`, a.`Lastname`,b.dept_name,c.designation_name,a.User_type');
        $this->db->from('qpe_user a');
        $this->db->join('qpe_departments b','a.department=b.dept_id','INNER');
        $this->db->join('qpe_designations c','a.Designation=c.designation_id','INNER');
        $this->db->where(" a.`User_id`!= ". $user_id ."  AND a.`User_id`= '". $nextid ."' ".$departmentstaus." and a.Joining_date <= NOW() - INTERVAL 3 MONTH and a.User_type`='TeamLead' ");
        $this->db->where("a.status",'Enable');
        $this->db->order_by('User_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row_array();
	}
	public function current_qur_ofLogin_user(){
		$user_id = $this->session->userdata('user_id');
		//echo "SELECT `User_id` FROM `qpe_user` WHERE  Joining_date <= NOW() - INTERVAL 3 MONTH and `User_id` = ". $user_id ." ";
		$qry =$this->db->query("SELECT `User_id` FROM `qpe_user` WHERE  Joining_date <= NOW() - INTERVAL 3 MONTH and `User_id` = ". $user_id ." ");
		if ($qry->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	public function getevelter_info($user_id){
		$this->db->select('*');
        $this->db->from('qpe_user');
        $this->db->where("`User_id` = ". $user_id ."");
        $query1 = $this->db->get();
        return $query1->row();
        
	}
}