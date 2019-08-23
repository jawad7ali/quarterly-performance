<?php
/**
 * CodeIgniter
 * @title      Evaluation Controller
 * @author     Jawad Ali
 * @Date       12/09/2019
 */
class Evaluation extends MY_Controller{
	// Register user
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('rating_model');
        // Your own constructor code
        if($this->session->userdata('user_type') != 'Admin'){
        	redirect('dashboard');
        }
    }
	// Dashboard Function
	public function department($deparment=''){
		if($deparment == ''){
			redirect('dashboard');
		}
		$data['evaluate_list'] = $this->rating_model->evaluate_list_by_department($deparment);
		//echo $this->db->last_query();
        $data['all_departments'] = $this->user_model->all_departments_for_dashboard();
		$this->show_view('users/list_by_department', $data);
	}
	// Evaluation Detail/View Page lthr (Team Lead to H.R)
	public function evaluate_detail($id='',$quarter=''){
		if($id == ''){
			redirect('dashboard');
		}
		$data['title'] = 'Quarterly Performance Evaluation Detail';
		$data['user_id']   = $this->session->userdata('user_id');
		$data['email']     = $this->session->userdata('email');
		$data['logged_in'] = $this->session->userdata('logged_in');
        $data['evaluate_member_detail'] = $this->rating_model->evaluate_member_detail($id,'desc',$quarter);
        //$data['eval_info'] = $this->rating_model->evaluate_member_ratings($eval_id,'','desc');
        // $data['eval_info'] = $this->rating_model->evaluate_member_ratings($eval_id,'','desc');
        
        // $data['dep_member'] = $this->rating_model->department_members($data['user_id'],$nextid->User_id);
        $data['all_colleagues'] = $this->rating_model->evaluate_list_by_member($data['evaluate_member_detail']['evaluate_user'],$quarter);
        $this->show_view('rating/evaluate_detail', $data);
	}
	public function averageByQuarter($uid,$designation)
	{ 
  		$yearlydata = $this->rating_model->get_avgBy_yearly($uid);
  		$html ='';
  		foreach ($yearlydata as $row) {
  			$year =$row->year;
			
  			$html .='
  			<div class="row">
	        <h3><b>'.$year.' Evaluation</b></h5>';
	        $quarterlydata = $this->rating_model->get_quarterBy_yearly($year);
	        foreach ($quarterlydata as $row2) {
	        	$quarter =$row2->quarter;
	        	$qurElement ='';

	        	if ($quarter == 1){ $qurElement = '1st'; };
			    if ($quarter == 2){ $qurElement = '2nd'; };
			    if ($quarter == 3){ $qurElement = '3rd'; };
			    if ($quarter == 4){ $qurElement = '4th'; };

			    $evltr_info = $this->rating_model->getevelter_info($row->user_id);
				$member_avgrow = $this->rating_model->get_avg_by_id($uid,'Member',$year,$quarter);

				//echo $this->db->last_query();
				//print_r($member_avgrow);
				//echo $row['factor_type'];
				//echo $this->db->last_query();
		  		//$lead_avgrow = $this->rating_model->get_avg_by_id($uid,'TeamLead',$year,$quarter);
		  		$hr_avgrow = $this->rating_model->get_avg_by_id($uid,'hr',$year,$quarter);
		  		$trainer_avgrow = $this->rating_model->get_avg_by_id($uid,'trainer',$year,$quarter);
		  		$SiteLead_avgrow = $this->rating_model->get_avg_by_id($uid,'SiteLead',$year,$quarter);
	  			$CEO_avgrow = $this->rating_model->get_avg_by_id($uid,'CEO',$year,$quarter);
	  			

	  			$lead_avg ='';
		  		$evaluate_list_fact = $this->rating_model->evaluate_list_by_department_byId($uid);
		  		
		  		foreach ($evaluate_list_fact as $row) {
		  		    // $row['factor_type'];
		  			if($row['factor_type'] == 'mtm' || $row['factor_type'] == 'mtl'){
		  		        
		  				$lead_avgrow = $this->rating_model->get_avg_by_id($uid,'TeamLead',$year,$quarter);
		  				//echo $this->db->last_query();
			  			$lead_rating_per = (($lead_avgrow->avg / 6) * 100)/100;
			  			 $lead_avg = $lead_rating_per * 30;
			  		}else{
			  		    
			  			$lead_avgrow = $this->rating_model->get_avg_by_id($uid,'TeamLead',$year,$quarter);
			  			$lead_rating_per = (($lead_avgrow->avg / 6) * 100)/100;
			  			$lead_avg = $lead_rating_per * 50;
			  		}
		  			//$factor_type[] =$row['factor_type'];
		  		}
		  		//print_r($lead_rating_per);

	  			// if($row->factor_type == 'mtm' || $row->factor_type == 'mtl'){
		  		// 	$lead_rating_per = (($lead_avgrow->avg / 6) * 100)/100;
		  		// 	$lead_avg = $lead_rating_per * 30;
		  		// }else{
		  		// 	$lead_rating_per = (($lead_avgrow->avg / 6) * 100)/100;
		  		// 	$lead_avg = $lead_rating_per * 50;
		  		// }
		  		// $lead_rating_per = (($lead_avgrow->avg / 6) * 100)/100;
		  		// $lead_avg = $lead_rating_per * 50;

		  		$member_rating_per = (($member_avgrow->avg / 6) * 100)/100;
		  		$member_avg = $member_rating_per * 30;

		  		$hr_rating_per = (($hr_avgrow->avg / 6) * 100)/100;
		  		$hr_avg = $hr_rating_per * 10;

		  		$trainer_rating_per = (($trainer_avgrow->avg / 6) * 100)/100;
		  		$trainer_avg = $trainer_rating_per * 10;

		  		//$totalAvg = ($lead_avg)+($member_avg)+($hr_avg)+($trainer_avg);

		  		
		  		if($designation == 'TeamLead' && $evltr_info->User_type !='TeamLead'){
			  		$SiteLead_rating_per = (($SiteLead_avgrow->avg / 6) * 100)/100;
			  		$SiteLead_avg = $SiteLead_rating_per * 50/100 ;
			  		$CEO_rating_per = (($CEO_avgrow->avg / 6) * 100)/100;
			  		$CEO_avg = $CEO_rating_per * 50/100;
			  		$CEO_totalavg = (($CEO_avg) * 100)/2;
			  		$SiteLead_totalavg = (($SiteLead_avg) * 100)/2;
			  		$totalrating =$SiteLead_avg + $CEO_avg;
			  		$totalAvg = (($totalrating) * 100)/2;
			  		$totalAvg = ($totalAvg)+($member_avg)+($hr_avg)+($trainer_avg);
		  		}else{
		  			$totalAvg = ($lead_avg)+($member_avg)+($hr_avg)+($trainer_avg);
		  		}
		  		
		  		//echo $lead_avg;
                // $totsiteavg =$SiteLead_totalavg/100 *50;
                // $totceoavg =$CEO_totalavg/100 *50;
                
		    	$html .='<div class="col-md-3 dash-alig">
		        	<h5><b>'.$qurElement.' quarter of '.$year.'</b></h5>
		        	<a class="rating-link" href="'.base_url().'evaluation/evaluate_detail/'.$uid.'/'.$quarter.'">
		            <div class="dash-box dash-box-color-1">
		                <div class="dash-box-body">';
		                if($designation == 'TeamLead' ){
			                $html .='<div class="count-combain">
		                    	<span class="dash-box-title"> CEO & Site Lead  </span>
		                    	<span class="dash-box-count">'.number_format(($SiteLead_totalavg +$CEO_totalavg) ,2).'%</span>
		                    </div>
		                  <!--  <div class="count-combain"> 
		                    	<span class="dash-box-title"> CEO	</span>
		                    	<span class="dash-box-count">'.number_format($CEO_totalavg,2).'%</span>
		                    </div>-->';
		                    $html .='<div class="count-combain">
		                    	<span class="dash-box-title"> Team Lead  </span>
		                    	<span class="dash-box-count">'.number_format($lead_avg,2).'%</span>
		                    </div>';
	                    }else{
		                	$html .='<div class="count-combain">
		                    	<span class="dash-box-title"> Team Lead  </span>
		                    	<span class="dash-box-count">'.number_format($lead_avg,2).'%</span>
		                    </div>';
		                }
		                    $html .='<div class="count-combain">
		                    	<span class="dash-box-title">Team Member </span>
		                    	<span class="dash-box-count">'.number_format($member_avg,2).'%</span>
		                    </div>
		                    <div class="count-combain">
		                    	<span class="dash-box-title">Hr </span>
		                    	<span class="dash-box-count">'.number_format($hr_avg,2).'%</span>
		                    </div>
		                    <div class="count-combain">
		                    	<span class="dash-box-title">Trainer </span>
		                    	<span class="dash-box-count">'.number_format($trainer_avg,2).'%</span>
		                    </div>
		                    <div class="count-combain total">
		                    	<span class="dash-box-title">Total </span>
		                    	<span class="dash-box-count">'.number_format($totalAvg,2).'%</span>
		                    </div>
		                    
		                </div>   
		            </div>
		            </a>
		        </div>';
	    	}
        	$html .='</div>';
    	}
    	echo $html;
	}


}