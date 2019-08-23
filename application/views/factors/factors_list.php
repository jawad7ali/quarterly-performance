<div class="factorslist-lthr">
<h2><?php echo $title; ?></h2>
<a href="<?php echo base_url(); ?>factors/add/0/<?php echo $this->uri->segment('3') ?>" class="btn btn-primary btn-sm btn-tlhr-eval">Add Evaluation Factor</a>
<?php //print_r($factors_list); ?>
<div class="factors_list">
	<table class="table table-striped">
	  <thead>
	    <tr>
	      <th>Sr.#</th>
	      <th>Category Name</th>
	      <th >Factors Description</th>
	      <th class="actions">Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php $i=1; foreach ($factors_list as $key => $value): ?>
	  		<tr>
	  			<td><?php echo $i; ?></td>
	  			<td><?php echo @$value['name']; ?></td>
	  			<td><?php echo @$value['description']; ?></td>
	  			<td class="actions">
	  			<a class="btn btn-info btn-xs" href="<?php echo base_url(); ?>factors/add/<?php echo @$value['fac_id']; ?>/<?php echo $value['factor_type'] ?>">Edit</a>
	  			<a class="btn btn-danger btn-xs" onclick="javascript:deleteConfirm('<?php echo base_url().'factors/delete_factor/'.@$value['fac_id'].'/'.@$value['cat_id'];?>/<?php echo $value['factor_type'] ?>');" deleteConfirm href="#">Delete</a></td>
	  		</tr>
	  	<?php $i++; endforeach ?>
	  </tbody>
	</table>
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