<?php
defined('_JEXEC') or die;
$pricingtables = $params->get('pricingtables', []);
$itemsInRow = $params->get('itemsInRow');
?>

<div class="container">
	<div class="row">
	  <?php foreach ($pricingtables as $pricingtable) { ?>
		  <div class="col-12 col-md-6 col-lg-<?php echo $itemsInRow;  ?> pricing-card <?php if($pricingtable->hightlight) {echo 'hightlight';}?> d-lg-flex">
			<div class="card card-normal">
				<?php if(!empty($pricingtable->title) or !empty($pricingtable->subtitle))  { ?>
				  <div class="card-header">

					<?php if(empty(!$pricingtable->headerBacground_icon) or empty(!$pricingtable->headerBacground_upload)) { ?>
						<div class="img-cover">
							<?php  if($pricingtable->headerBacground=="icon"){?>
								<i class="<?php echo $pricingtable->headerBacground_icon; ?>"></i>
							<?php } else{?>
								<img src="<?php echo $pricingtable->headerBacground_upload; ?>">
							<?php } ?>
						</div>
					<?php } ?>
				</div>
				<?php } ?> 

				<?php if(!empty($pricingtable->title))  { ?>
					<div class="pricing-title center pt-4">
						<h5 class=""><?php echo $pricingtable->title; ?></h5>
					</div>
				<?php } ?>

				<?php if(!empty($pricingtable->subtitle))  { ?>
					<div class="pricing-subtitle center">
						<p><?php echo $pricingtable->subtitle; ?></p>
					</div>
				<?php } ?>
				
				<?php if(!empty($pricingtable->description)){?>
				  <div class="card-body">
						<?php echo $pricingtable->description; ?>
				  </div>
				<?php }	 ?>
			<?php if(!empty($pricingtable->pricing) or  !empty($pricingtable->period) or !empty($pricingtable->button_text) or !empty($pricingtable->bottom_line)){?>
				  <div class="card-footer">
					  <?php if(!empty($pricingtable->pricing) and !empty($pricingtable->period) ){?>
						<div class="price" style="<?php if($pricingtable->pricingColor) {echo 'color: ' . $pricingtable->pricingColor;}?>"><?php echo $pricingtable->pricing; ?>
						  <small><?php echo $pricingtable->period; ?></small>
						</div>
						<?php } ?>
						<?php if($pricingtable->buttonhide){?>	
							<?php if(!empty($pricingtable->button_text)) {?>
								<a href="<?php echo JRoute::_('index.php?Itemid=' . $pricingtable->button_link);  ?>" class="btn btn-primary"><?php echo $pricingtable->button_text; ?></a>
							<?php } ?>
						<?php } ?>
						<?php if(!empty($pricingtable->bottom_line)) {?>
							<p class="bottom-line">
							  <?php echo $pricingtable->bottom_line; ?>
							</p>
						<?php } ?>
				  </div>
			<?php } ?>
			</div>
		  </div>
	  <?php } ?>
	</div>
</div>