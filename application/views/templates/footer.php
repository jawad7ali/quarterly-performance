		</div> <!-- end div of container -->
<footer>
	<nav class="navbar navbar-default">
      <div class="container footer">
        <div class="text-center">
        	CopyRights &copy; QPE <?php echo date('Y'); ?> 
        </div>
      
      </div>
    </nav>
    
    	<?php if($this->uri->segment('2') != 'update_manage_user'){ ?>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
       	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<?php }else{ ?>
		<script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
		<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
		<?php } ?>
		<script src="<?php echo base_url(); ?>assets/timepicker/jquery-ui-timepicker-addon.js"></script>
		<script src="<?php echo base_url(); ?>assets/evaluate/js/footer-vendors-v13860.js?v=1"></script>
		<script src="<?php echo base_url(); ?>assets/evaluate/js/16p-core30f4.js?v=3"></script>
        <script src="<?php echo base_url(); ?>assets/evaluate/js/test3860.js?v=1"></script>
     	<?php if($this->uri->segment('2') != 'update_manage_user'){ ?>
		<script>
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip();   
		});
		</script>
		<?php } ?>
	    <script>
	    		$( function() {
	    $( ".datepicker" ).datepicker({
	    	dateFormat: "yy-mm-dd"
	    	// timeFormat: 'HH:mm:ss'
	    });
	 });
    	$j('#test-form .option').button();
    	</script>
        <script>
		  
		  $('#selectLeadType').on('click', function() {
			var leadType = this.value;
			$('#leadNameLabel').children('span').text(leadType);
			});
		  
		  </script>
<?php if($this->uri->segment('2') == 'update_manage_user'){ ?>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
	    $('.js-example-basic-multiple').select2();
	});

</script>
<?php } ?>
</footer>		  
	</body>
</html>