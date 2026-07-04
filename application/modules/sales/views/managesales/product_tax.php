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
						Tax Info.
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main ">
						<div class="row-fluid">
						<!-- <div class="form-horizontal"> -->
			<?php $cData=$this->session->userdata('_product_tax_'); 

					$res=[];
					if(isset($cData) && !empty($cData)) {
						foreach ($cData as $key => $cDatas) {
							$name = explode(',',$cDatas['tax_name']);
							$taxIds = explode(',',$cDatas['tax_ids']);
							$taxRate = explode(',',$cDatas['tax_rate']);

							if(count($name) > 0) {
								for($i=0; $i<count($name); $i++) {
									$res[$key][$taxIds[$i]] = ['product_sku'=>$key,
														'tax_name'=>(isset($name[$i]) ? $name[$i] : ''),
														'rate'=>(isset($taxRate[$i]) ? $taxRate[$i] : '')];
								}
			 				} else {
			 					$res[$key] = ['product_sku'=>$key,
										'tax_name'=>$cDatas['tax_name'],
										'rate'=>$cDatas['tax_rate']];
			 				}
						}
					}

					?>

					<table style="border-bottom: 2px solid #ccc; width: 100%; border-collapse: separate;">
						<thead><tr>
							<th>Item</th>
							<th>Tax Name</th>
							<th>Rate</th>
							</tr>
						</thead>
						<tbody>
							<?php 
						if(!empty($res)) {
							$txt = '';
							 foreach($res as $key=>$cDatas) { 
								 if(count($cDatas) > 0) {

								 	foreach($cDatas as $cDatass) {
								 		$txt.='<tr>
											<td>'.$key.'</td>
											<td>'.$cDatass['tax_name'].'</td>
											<td>'.$cDatass['rate'].'</td>
										</tr>';
									} 

								 }	else {
								 	$txt.='<tr>
											<td>'.$key.'</td>
											<td>'.$cDatas['tax_name'].'</td>
											<td>'.$cDatas['rate'].'</td>
										</tr>';
									} 
								 } 	 } ?>
						</tbody>
					</table>
					</div>
						
					</div>
					</div>
				</div>