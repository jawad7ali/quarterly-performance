 <!------ Include the above in your HEAD tag ---------->
<div class="container">
    <style type="text/css">
        .dash-box-body h3 {
     
            height: 77px;
        }
    </style>
    <div class="row">
        <?php 
        $i='1';
            foreach ($all_departments as $row) {
                if($row['member_ids'] !=''){
                    $submited_mem = $this->user_model->get_submited_members_total($row['member_ids']);
                }else{
                    $submited_mem ='0';
                }
                
        ?> 
        <div class="col-md-4">
            <div style="height: 346px;" class="dash-box dash-box-color-<?php echo $i++;; ?>" >
                <div class="dash-box-icon">
                    <i class="glyphicon glyphicon-cloud"></i>
                </div>
                <div class="dash-box-body">
                    <span class="dash-box-title"> Submitted Members </span>
                    <span class="dash-box-count"><?php echo $submited_mem->totalsubmited ? $submited_mem->totalsubmited :'0'; ?></span>
                    <span class="dash-box-title">Remaining Members</span>
                    <span class="dash-box-count"><?php echo $row['total']-$submited_mem->totalsubmited; ?></span>
                    <h3 ><?php echo $row['dept_name']; ?> <br> Team</h3 >
                </div>
                
                <div class="dash-box-action">
                   <a href="<?php echo base_url(); ?>evaluation/department/<?php echo $row['id']; ?>"><button> More Info</button></a>
                </div>              
            </div>
        </div>
        <?php  } ?>
        <!-- <div class="col-md-4">
            <div class="dash-box dash-box-color-2">
                <div class="dash-box-icon">
                    <i class="glyphicon glyphicon-cloud"></i>
                </div>
                <div class="dash-box-body">
                    <span class="dash-box-title"> Submitted Members </span>
                    <span class="dash-box-count">5</span>
                    <span class="dash-box-title">Remaining Members</span>
                    <span class="dash-box-count">3</span>
                    <h3 >QA Team</h3 >
                </div>
                
                <div class="dash-box-action">
                    <button>More Info</button>
                </div>              
            </div>
        </div>
        <div class="col-md-4">
            <div class="dash-box dash-box-color-3">
                <div class="dash-box-icon">
                    <i class="glyphicon glyphicon-cloud"></i>
                </div>
                <div class="dash-box-body">
                    <span class="dash-box-title"> Submitted Members</span>
                    <span class="dash-box-count">5</span>
                    <span class="dash-box-title">Remaining Members</span>
                    <span class="dash-box-count">3</span>
                    <h3 >Recruitment Team</h3 >
                </div>
                
                <div class="dash-box-action">
                    <button>More Info</button>
                </div>              
            </div>
        </div> -->
    </div>
</div>
 
 

<script type="text/javascript"> 
function deleteConfirm(url)
 {
    if(confirm('Do you want to Delete this record ?'))
    {
        window.location.href=url;
    }
 }
</script>
<!-- <div class="dashboard">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <ul class="dashboard-tabs">
                <li class="active">
                    <a href="#profile" class="btn" aria-controls="profile" role="tab" data-toggle="tab">
                        <span class="fa fa-user"></span>
                        <h4>Evaluation</h4>
                    </a>
                </li>
                <li>
                    <a href="#statistics" class="btn" aria-controls="statistics" role="tab" data-toggle="tab">
                        <span class="fa fa-clock-o"></span>
                        <h4>Statistics</h4>
                    </a>
                </li>
                <li>
                    <a href="#donate" class="btn" aria-controls="donate" role="tab" data-toggle="tab">
                        <span class="fa fa-usd"></span>
                        <h4>Donate</h4>
                    </a>
                </li>
                <li>
                    <a href="#settings" class="btn" aria-controls="settings" role="tab" data-toggle="tab">
                        <span class="fa fa-cog"></span>
                        <h4>Settings</h4>
                    </a>
                </li>
                <li>
                    <a href="#help" class="btn" aria-controls="help" role="tab" data-toggle="tab">
                        <span class="fa fa-question"></span>
                        <h4>Help</h4>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content col-md-12">
            <div role="tabpanel" class="tab-pane profile-pane active" id="profile">
                <div>
                    <div>
                        <div class="header">
                            <h4>Team Member to Team Lead Evaluation</h4>   
                        </div>
                        <div class="">  
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>factors/listing/mtl">
                                        <div class="dashboard-box">
                                            Evaluation Factors
                                        </div>
                                    </a>
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>rating/evaluate_mtl_list">
                                        <div class="dashboard-box" style="background: #d1e5e5;">
                                            Evaluation List
                                        </div>
                                    </a> 
                           
                                 <div class="header" style="margin: 9px 0px 0px;">
                                    <h4>Team Member To Team Member Evaluation</h4>   
                                </div>
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>factors/listing/mtm">
                                        <div class="dashboard-box">
                                            Evaluation Factors
                                        </div>
                                    </a>  
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>rating/evaluate_mtm_list">
                                        <div class="dashboard-box" style="background: #d1e5e5;">
                                            Evaluation List
                                        </div>
                                    </a>
                                    <div class="header" style="margin: 9px 0px 0px;">
                                    <h4>Team Member To H.R Evaluation</h4>   
                                </div>
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>factors/listing/lthr">
                                        <div class="dashboard-box">
                                            Evaluation Factors
                                        </div>
                                    </a>  
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>rating/evaluate_lthr_list">
                                        <div class="dashboard-box" style="background: #d1e5e5;">
                                            Evaluation List
                                        </div>
                                    </a>

                                    <div class="header" style="margin: 9px 0px 0px;">
                                    <h4>Team Leam to Team Member Evaluation</h4>   
                                </div>
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>factors/listing/ltm">
                                        <div class="dashboard-box">
                                            Evaluation Factors
                                        </div>
                                    </a> 
                               
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>rating/evaluate_ltm_list">
                                        <div class="dashboard-box" style="background: #d1e5e5;">
                                            Evaluation List
                                        </div>
                                    </a>

                        </div>
                    </div>
                    <div>
                        <div class="header" style="background: #83708a">
                            <h4>Preferences</h4>   
                        </div>
                        <div class="">
                                                                
                                      <a class="dashboard-box-link" href="<?php echo base_url(); ?>preferences/project">
                                        <div class="dashboard-box">
                                            Projects
                                        </div>
                                    </a>
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>preferences/department">
                                        <div class="dashboard-box" style="background: #d1e5e5;">
                                            Departments
                                        </div>
                                    </a>
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>preferences/designation">
                                        <div class="dashboard-box">
                                            Designations
                                        </div>
                                    </a>
                                    <a class="dashboard-box-link" href="<?php echo base_url(); ?>preferences/manage_users">
                                        <div class="dashboard-box" style="background: #d1e5e5;">
                                            Users
                                        </div>
                                    </a>
                               
                                 
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="statistics">
            Statistics
            </div>
            <div role="tabpanel" class="tab-pane" id="donate">
            Donate
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">
            Settings
            </div>
            <div role="tabpanel" class="tab-pane help-pane" id="help">
       
                <div class="jumbotron jumbotron-sm">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <h1 class="h1">Contact us <small>Feel free to contact us</small></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="well well-sm">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Company Name</label>
                                                <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-envelope"></span>
                                                    </span>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="subject">Subject</label>
                                                <select id="subject" name="subject" class="form-control" required="required">
                                                    <option value="na" selected="">Choose One:</option>
                                                    <option value="service">General Customer Service</option>
                                                    <option value="suggestions">Suggestions</option>
                                                    <option value="product">Product Support</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Message</label>
                                                <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required" placeholder="Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">Send Message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <form>
                                <legend><span class="fa fa-globe"></span>Our office</legend>
                                <address>
                                    <strong>Givingest</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    <abbr title="Phone">P:</abbr>
                                    (123) 456-7890
                                </address>
                                <address>
                                    <strong>Full Name</strong><br>
                                    <a href="mailto:#">first.last@example.com</a>
                                </address>
                            </form>
                        </div>
                    </div>
                </div>
           
            </div>
        </div>
    </div>
</div> -->





<!-- <h1>Dashboard</h1>
    <h3><a href="<?php echo base_url(); ?>rating/member_to_lead">Performance Evaluation T.M to T.L</a></h3>
    <?php if(!empty($mtl_all_members)){ ?>
    <h5><a href="<?php echo base_url(); ?>rating/evaluate_mtl">Start Evaluation</a></h5>
    <?php } ?>
    <h5><a href="<?php echo base_url(); ?>rating/evaluate_mtl_list">Evaluation List</a></h5>


    <h3><a href="<?php echo base_url(); ?>rating/lead_to_hr">Performance Evaluation T.L to H.R</a></h3>  
    <?php if(!empty($lthr_all_members)){ ?>
    <h5><a href="<?php echo base_url(); ?>rating/evaluate_lthr">Start Evaluation</a></h5>
    <?php } ?>
    <h5><a href="<?php echo base_url(); ?>rating/evaluate_lthr_list">Evaluation List</a></h5>
    <h3><a href="<?php echo base_url(); ?>rating/lead_to_member">Performance Evaluation T.L to T.M</a></h3>
    <?php if(!empty($ltm_all_members)){ ?>
    <h5><a href="<?php echo base_url(); ?>rating/evaluate_ltm">Start Evaluation</a></h5>
    <?php } ?>
    <h5><a href="<?php echo base_url(); ?>rating/evaluate_ltm_list">Evaluation List</a></h5> -->    
 

<script type="text/javascript">
    $(function() {
    var toggleFunction;
    $('.toggle-handle').click(toggleFunction = function() {
        var area = $('#' + $(this).attr('data-area'));
        if(area.hasClass('expanded')) {
            area.removeClass('expanded');
        } else {
            area.addClass('expanded');
        }
        $(this).blur();
        return false;
    });
    
    $('#supportedCauses').append(
        $(document.createElement('div')).attr('id', 'pane4').addClass('cause-info').append(
            $(document.createElement('div')).append(
                $(document.createElement('img')).attr('src', 'http://lorempixel.com/420/420/people'),
                $(document.createElement('div')).append(
                    $(document.createElement('h4')).text('[Name]'),
                    $(document.createElement('h4')).text('[Cause]')
                ),
                $(document.createElement('div')).append(
                    $(document.createElement('h4')).text('[X] Votes')
                )
            ),
            $(document.createElement('div')).append(
                $(document.createElement('h4')).text('About:'),
                $(document.createElement('div')).append(
                    $(document.createElement('p')).text(
                        'Nam ex ullum assum apeirian, facilisi splendide quo ex. Sea et nonumy accusata, in utinam vocent facilis vix. \
                        Cu vix eripuit temporibus mediocritatem, denique theophrastus ne mel, et graecis maiorum mediocritatem per. \
                        Magna tacimates sed eu, sit no graeco latine referrentur. Id sed assum quaerendum, apeirian erroribus ut his. Ex mei mazim minimum.'
                    ),
                    $(document.createElement('h5')).html('More at <a>[Website]</a>')
                ),
                $(document.createElement('button')).addClass('btn btn-primary pull-right').text('Give')
            ),
            $(document.createElement('div')).append(
                $(document.createElement('h2')).append(
                    $(document.createElement('a')).append(
                        $(document.createElement('span')).addClass('fa fa-chevron-down')
                    ).attr('href', '#pane4').attr('data-area', 'pane4').click(toggleFunction)
                )
            )
        )
    );
});
</script>

