<?php echo form_open('factors/submit_factor'); ?>
<input type="hidden" name="factor_type" value="<?php echo $this->uri->segment('4'); ?>">

	<div class="row">
		<div class="col-md-10">
<a href="<?php echo base_url(); ?>factors/listing/<?php echo $this->uri->segment('4'); ?>" class="btn btn-success btn-sm">Back to Factors List</a>		
		<h1 class="text-center"><?php echo $title; ?></h1>
			<div class="form-group row">
				<div class="col-md-3">
					<label for="category_name" class="form-control col-form-label" >Category Name:</label>
				</div>
				<div class="col-md-8">
					<input type="text" name="category_name" class="form-control" value="<?php if(isset( $factors_row) && !empty($factors_row)){ echo $factors_row['name'];}  ?>" placeholder="Enter Category Name" required autofocus>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-3">
					<label for="description" class="form-control col-form-label" >Factor Description:</label>
				</div>
				<div class="col-md-8">
					<textarea class="form-control" name="factor_description" id="factor_description" cols="30" rows="10" autofocus><?php if(isset( $factors_row) && !empty($factors_row)){ echo $factors_row['description'];} ?></textarea>
				</div>
			</div>
			<input type="hidden" name="category_id"  value="<?php if(isset( $factors_row) && !empty($factors_row)){ echo $factors_row['cat_id'];}  ?>" >
			<input type="hidden" name="factor_id"  value="<?php if(isset( $factors_row) && !empty($factors_row)){ echo $factors_row['fac_id'];}  ?>" >

			<button type="submit" class="btn btn-primary"><?php if(isset( $factors_row) && !empty($factors_row)){ echo 'Update Evaluation'; }else{ echo 'Add Evaluation';} ?></button>
		</div>
	</div>
<?php echo form_close(); ?>