<div class="col-md-4">
	<div class="form-group form-control-default required">
		<label for="customQuoteFieldTitle blue-grey-800">Title</label>
		<input name="customQuoteFieldTitle[]" type="text" class="form-control margin-bottom-10 customQuoteFieldTitle" data-not-call-calculating="true" placeholder="Title" value="<?php echo $title; ?>" required>
	</div>
</div>
<div class="col-md-3">
	<div class="form-group form-control-default required">
		<label for="customQuoteFieldPrice blue-grey-800">Price - inc tax</label>
		<input name="customQuoteFieldPrice[]" type="number" min="0" class="form-control margin-bottom-10 customQuoteFieldPrice" placeholder="0.00" value="<?php echo $price; ?>" required>
	</div>
</div>
<div class="col-md-4">
	<div class="form-group form-control-default required">
		<label for="customQuoteFieldDescription blue-grey-800">Description</label>
		<textarea name="customQuoteFieldDescription[]" class="form-control margin-bottom-10 customQuoteFieldDescription" data-not-call-calculating="true" placeholder="Description" required><?php echo $description; ?></textarea>
	</div>
</div>
<div class="col-md-1 padding-top-35">
	<a <?php if($customFieldId == 0): ?>style="display:none;"<?php endif; ?> class="btn btn-xs btn-raised btn-round btn-danger btn-icon deleteCustomQuoteField">
		<i class="icon wb-minus margin-horizontal-0"></i>
	</a>
</div>