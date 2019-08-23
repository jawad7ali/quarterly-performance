 <!------ Include the above in your HEAD tag ---------->
<div class="container">
    <style type="text/css">
        .dash-box-body h3 {
     
            height: 77px;
        }
    </style>
    <div class="row">
        <?php 
        $current_quarter =preg_replace("/[^0-9]/", "", $current_quarter);
        $i='1';
            foreach ($all_departments as $row) {
                if($row['member_ids'] !=''){
                    $submited_mem = $this->user_model->get_submited_members_total_dash($row['member_ids'],$current_quarter);
                   // echo $this->db->last_query();
                }else{
                    $submited_mem ='0';
                }
                //print_r($row);
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

