<?php
	$slt=0;
	$st=$this->session->userdata('sale_type');
	if(isset($st)){
		$slt=$this->session->userdata('sale_type');
	}


?>

<div class="widget-box">
				<div class="widget-header">
					<h4 class="smaller">
						Offer Info.
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main ">
						<div class="row-fluid">
						<!-- <div class="form-horizontal"> -->
			<?php $offerInfo=$this->session->userdata('_product_offer_'); ?>

					<table style="border-bottom: 2px solid #ccc; width: 100%; border-collapse: separate;">
						<thead><tr>
							<th>Item</th>
							<th>Offer</th>
						</tr></thead>
						<tbody>
							<?php 
							$fixedSum=0;
						if(!empty($offerInfo)) {
							foreach($offerInfo as $key=>$offerInfos) {
								$type=$offerInfos['offer_type'];
								/*if($type==1) {
									$offerType='(%)';
								}elseif($type==2) {
									$offerType='(Fixed)';
								}else {
									$offerType='(FreeProduct)';
								}*/

								if($type==2) {
									if(is_numeric($offerInfos['discount'])) {
										$fixedSum +=$offerInfos['discount'];
									}
								}

								if($type==1) {
									if(is_numeric($offerInfos['discount'])) {
										$perDiscount = $offerInfos['discount'];
										//$amt=($offerInfos['product_price'] * $perDiscount)/100;


										$this->cart->offerpercent_discount($perDiscount);
									}
								}
								
							 ?>
							<tr>
								<td><?php echo $key; ?></td>
								<td><?php echo $offerInfos['discount']; ?></td>
							</tr>
							<?php } } ?>
							
						</tbody>
					</table>
					<?php 
					$offerDiscount = $this->cart->total_offerfixed_discount($fixedSum); ?>
					</div>
						
					</div>
					</div>
				</div>