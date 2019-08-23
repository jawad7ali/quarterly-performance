<?php if($this->session->flashdata('user_registered')): ?>
<?php echo '<p class="alert alert-success">'.$this->session->flashdata('user_registered').'</p>'; ?>
<?php endif; ?>
<?php if (isset($message)) {
    echo '<p class="alert alert-info">'.$message.'</p>';
} elseif (isset($error)) {
    echo '<p class="alert alert-danger"><strong>Error: </strong>'.$error.'</p>';
}?>

<style>

</style>

<?php echo form_open('rating/evaluate_rating_lthr/'.$user_id.' '); ?>
<div class="row">
  <div class="col-md-12 text-center">
    <h2><?php echo $title; ?></h2>    
  </div>
</div>
<div class="user-info">
  <div class="form-group row">
    <div class="col-md-3">
      <label for="user_name" class="form-control col-form-label" >Name:</label>
    </div>
    <?php 
     $evaluated_user_id =@$selected_factors_list[0]['tlhr_name']; 
    ?>
    
    <div class="col-md-9">
      <select class="form-control" name="user_name" id="user_name" >
          <option value="">Select User Name</option>
          <?php foreach($lthr_all_members as $kk=>$vv){ ?>
          <option <?php if($evaluated_user_id==$vv['User_id']){echo 'Selected="Selected"';}  ?>  value="<?php echo $vv['User_id']; ?>"><?php echo $vv['Firstname']." ".$vv['Lastname']; ?></option>
          <?php } ?>
      </select>
    
    </div>
  </div>
  <div class="form-group row">
    <div class="col-md-3">
      <label for="user_designation" class="form-control col-form-label" >Designation:</label>
    </div>
    <div class="col-md-3">
      <input type="text" name="user_designation" class="form-control" placeholder="Enter Designation" value="<?php echo @$selected_factors_list[0]['tlhr_designation']; ?>" required autofocus>
    </div>
    <div class="col-md-3">
      <label for="user_department" class="form-control col-form-label" >Department:</label>
    </div>
    <div class="col-md-3">
      <input type="text" name="user_department" class="form-control" placeholder="Enter Department" value="<?php echo @$selected_factors_list[0]['tlhr_department']; ?>" required autofocus>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-md-3">
      <label for="user_lead" class="form-control col-form-label" >Team Lead/Supervisor:</label>
    </div>
    <div class="col-md-3">
       <select class="form-control" name="selectLeadType" id="selectLeadType">
          <option value="TeamLead" <?php if(@$selected_factors_list[0]['tlhr_lead_type'] === 'TeamLead'){echo 'selected';} ?>> Team Lead</option>
          <option value="Supervisor" <?php if(@$selected_factors_list[0]['tlhr_lead_type'] === 'Supervisor'){echo 'selected';} ?> >Supervisor</option>
          <option value="Manager" <?php if(@$selected_factors_list[0]['tlhr_lead_type'] === 'Manager'){echo 'selected';} ?>> Manager</option>
      </select>
    </div>
    <div class="col-md-3">
      <label for="lead_name" id="leadNameLabel" class="form-control col-form-label" ><span><?php if(!empty($selected_factors_list[0]['tlhr_lead_type'])){echo $selected_factors_list[0]['tlhr_lead_type']. '</span> Name:';}else{ ?>Team Lead</span> Name:<?php } ?></label>
    </div>
    <div class="col-md-3">
      <input type="text" name="lead_name" class="form-control" placeholder="Enter Name" value="<?php echo @$selected_factors_list[0]['tlhr_lead_name']; ?>" required autofocus>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-md-3">
      <label for="user_joining_date" class="form-control col-form-label" >Joining Date:</label>
    </div>
    <div class="col-md-3">
      <input type="text" name="user_joining_date" class="form-control datepicker" placeholder="Enter Joining Date" value="<?php echo date("Y-m-d",strtotime(@$selected_factors_list[0]['tlhr_joining_date'])); ?>"  required autofocus>
    </div>
    <div class="col-md-3">
      <label for="evaluation_quarter" class="form-control col-form-label" >Quarter:</label>
    </div>
    <div class="col-md-3">
      <input type="text" name="evaluation_quarter" class="form-control" placeholder="Enter Quarter" value="<?php echo @$selected_factors_list[0]['tlhr_quarter']; ?>" required autofocus>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-md-3">
      <label for="user_project" class="form-control col-form-label" >Module:</label>
    </div>
    <div class="col-md-3">
      <input type="text" name="user_project" class="form-control" placeholder="Enter Module" value="<?php echo @$selected_factors_list[0]['tlhr_project']; ?>" required autofocus>
    </div>
    <div class="col-md-3">
      <label for="evaluation_date" class="form-control col-form-label" >Date:</label>
    </div>
    <div class="col-md-3">
      <input type="text" name="evaluation_date" class="form-control datepicker" placeholder="Enter Date" value="<?php echo date('Y-m-d'); ?>" value="<?php echo @$selected_factors_list[0]['tlhr_date']; ?>" required autofocus>
    </div>
  </div>

</div>
<table class="table table-bordered table-inverse factors-table">
    <thead>
      <tr>
        <th>Sr.#</th>
        <th>Evaluation Factors</th>
        <th>Superb</th>
        <th>Great</th>
        <th>Good</th>
        <th>Needs Improvement</th>
        <th>Failing</th>
        <th>Remarks</th>        
      </tr>
    </thead>
    <tbody>
        

        
        
      <?php $i=1; foreach ($selected_factors_list as $key => $value): ?>
        <?php @$tlhr_rating_number = $value['tlhr_rating_number'];  $active_class ='active'; ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td class="factor-description"><?php echo '<b>'.$value['tlhr_cat_name'].' : </b>'.$value['tlhr_eval_description']; ?></td>
      
      <td colspan  ="5" >
        <div class="question-wrapper set1">
                <div class="statement">
                    You find it difficult to introduce yourself to other people.
                </div>
                <div class="row decision">
                    <div class="hidden-xs col-sm-3 caption left">Agree</div>
                    <div class="col-xs-12 col-sm-6 options btn-group" data-toggle="buttons" role="group" aria-label="Options">
                        <input type="hidden" name="tlhr_rating_<?php echo $i; ?>" value="<?php echo @$value['tlhr_rating_id'] ?>" autocomplete="off">
                        <label class="btn btn-default option agree max <?php if(@$tlhr_rating_number== 3){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="3" <?php echo  set_radio('btn_radio_rating'.$i, '3', @$value['tlhr_rating_number'] == '3' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option agree med <?php if(@$tlhr_rating_number== 2){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="2" <?php echo  set_radio('btn_radio_rating'.$i, '2', @$value['tlhr_rating_number'] == '2' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option agree min <?php if(@$tlhr_rating_number== 1){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="1" <?php echo  set_radio('btn_radio_rating'.$i, '1', @$value['tlhr_rating_number'] == '1' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option neutral <?php if(@$tlhr_rating_number== 0){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="0" <?php echo  set_radio('btn_radio_rating'.$i, '0', @$value['tlhr_rating_number'] == '0' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option disagree min <?php if(@$tlhr_rating_number== -1){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="-1" <?php echo  set_radio('btn_radio_rating'.$i, '-1', @$value['tlhr_rating_number'] == '-1' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option disagree med <?php if(@$tlhr_rating_number== -2){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="-2" <?php echo  set_radio('btn_radio_rating'.$i, '-2', @$value['tlhr_rating_number'] == '-2' ); ?> autocomplete="off">
                        </label>
                        <label class="btn btn-default option disagree max <?php if(@$tlhr_rating_number== -3){echo $active_class;} ?>" >
                            <input type="radio" name="btn_radio_rating<?php echo $i; ?>" value="-3" <?php echo  set_radio('btn_radio_rating'.$i, '-3', @$value['tlhr_rating_number'] == '-3' ); ?> autocomplete="off">
                        </label>
                    </div>
                    <div class="hidden-xs col-sm-3 caption right">Disagree</div>
                </div>
                <div class="row decision mobile visible-xs">
                    <div class="col-xs-6 caption left">Agree</div>
                    <div class="col-xs-6 caption right">Disagree</div>
                </div>
            </div>
      <input type="hidden" name="eval_fact_id<?php echo $i; ?>" value="<?php echo $value['tlhr_eval_fact_id']; ?>">
        </td>
          

        <td><textarea class="evaluate_remarks_text" name="remarks<?php echo $i; ?>" id="remarks<?php echo $i; ?>" cols="28" rows="5"><?php echo @$value['tlhr_rating_remarks'] ?></textarea></td>
        <input type="hidden" name="tlhr_id" value="<?php echo @$value['tlhr_id'] ?>">

        </tr>
      <?php $i++; endforeach ?>
    </tbody>
  </table>
  <div class="form-group row evaluate-recommendations">
    <div class="col-md-12 text-center">
      <label for="recommendations" class="form-control col-form-label" >Recommendations:</label>
      <textarea class="form-control" name="evaluate_recommendation" id="evaluate_recommendation" cols="30" rows="10" required autofocus><?php echo @$selected_factors_list[0]['tlhr_recommendations']; ?></textarea>
    </div>
  </div>
  <button type="submit" style="float:right;" class="btn btn-primary">Evaluate</button>
<?php echo form_close(); ?> 
<div class="row">
  <div class="col-md-12">
    <table class="table-evaluate-instructions">
      <tr>
        <td class="font-weight-bold">Superb</td>
        <td>(05-06)</td>
        <td>Employee is working superb and extraordinary expectations</td>
      </tr>
      <tr>
        <td>Great</td>
        <td>(04-05)</td>
        <td>Employee is working great and above the expectations</td>
      </tr>
      <tr>
        <td>Good</td>
        <td>(03-04)</td>
        <td>Employee is working good and meeting the expectations</td>
      </tr>
      <tr>
        <td>Need Improvement</td>
        <td>(02-03)</td>
        <td>Employee is working below the expecations and needs little improvement</td>
      </tr>
      <tr>
        <td>Failing</td>
        <td>(01-02)</td>
        <td>Employee is working below the expecations and needs strong improvement</td>
      </tr>

    </table>
  </div>
</div>