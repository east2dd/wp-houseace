<?php 
	if(empty($customQuoteFieldTitle)){
		$customQuoteFieldTitle[] = '';
		$customQuoteFieldDescription[] = '';
		$customQuoteFieldPrice[] = '';
	}
?>
<div class="row margin-top-40">
	<div class="row blue-grey-800">
		<div class="col-md-12 text-center">
			<div class="font-size-20 blue-grey-800 text-center">Add manual items</div><p>
			This is where you can add manual items to your quote, this is for project specific scope that you haven't created options for. All totals will be added to the grand total.
			</p>
		</div><hr>
	</div>
	<div class="customQuoteFieldContainer" data-rows="<?php echo count($customQuoteFieldTitle); ?>">
		<?php foreach($customQuoteFieldTitle as $customFieldId => $title ): ?>
			<?php $description = $customQuoteFieldDescription[$customFieldId]; ?>
			<?php $price = $customQuoteFieldPrice[$customFieldId]; ?>
			<div class="row customQuoteFieldRow">
				<?php include('customQuoteFieldRow.php'); ?>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="text-center">
				<a class="btn btn-sm btn-primary btn-raised btn-default populateCustomQuoteField">
					<i class="icon wb-plus margin-horizontal-0"></i> ADD MORE
				</a>
			</div>
		</div>
	</div>
</div>