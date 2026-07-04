<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageSales extends CI_Controller {

	function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			global $uInfo;

			$this->load->library('cart');
			$uInfo=$this->session->userdata('sales_session_info');
			$this->load->helper('url');
			$this->load->model('common');
			$this->load->model(['managesales_model']);
			if (!($this->session->userdata('sales_session_info'))) {
				redirect(base_url().'sales/login');
			}
			
		}
	
	 function index(){
		
		global $uInfo;
		$sale_type=0;
		if (isset($uInfo) && !empty($uInfo)) {
			
			$st=$this->session->userdata('sale_type');
			if(isset($st)){
				$sale_type=$this->session->userdata('sale_type');
			}

			$data['title'] = 'Dashboard | Sales';
			$data['cart_items'] = $this->cart->contents(); 
			$data['sale_type']=$sale_type;

			//var_dump($this->cart->contents());

			$this->load->view('managesales/addOrder', $data);
		}
		
	}
	
	/*
	* Customer auto suggestions
	*/	
	function customerAutoSuggest(){
		
		$this->load->model('managesales_model');
		$suggestions = array();
		$search = $this->input->get('term') != '' ? $this->input->get('term') : NULL;
		$sg = $this->managesales_model->get_customer_suggestions($search, array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE);

		$suggestions=$sg;

		echo json_encode($suggestions);
	}

	/*
	* Item suggestios and barcode scan
	*/	
	function itemAutoSuggest(){
		global $uInfo;
		$compCode=$uInfo['comp_code'];

		$this->load->model('managesales_model');
		$suggestions = array();
		$search = $this->input->get('term') != '' ? $this->input->get('term') : NULL;
		
		$sg = $this->managesales_model->get_item_suggestions($search, array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE);

		$suggestions=$sg;
		echo json_encode($suggestions);
	}

	/*
	* Add Item to cart before Credit Note scanning
	*/
	
	/*
	function addItemToCart_ori(){
		
		$this->load->library('cart');
		$itemID=(int) $this->input->post('item');
		$itemArr= $this->managesales_model->getItemInfoByID($itemID);
		
		$quantity=1;
		$price=$itemArr['product_price'];
		$discount=5;

		$item_data = array(
			'id' => $itemArr['product_id'],
			'name' => $itemArr['product_name'],
			'qty' => 1,
			'price' => $itemArr['product_price'],
			'unit' => $itemArr['product_unit'],
			'discount' => 1,
			'tax' => 3,
		);

		$this->cart->insert($item_data);

		$data['cart_items'] = $this->cart->contents(); 

		$this->load->view('managesales/cart_view', $data);

	}

	*/

	/*
	* Add Item new with credit not scanning
	*/

	function addItemToCart(){
		global $uInfo;
		$this->load->library('cart');

		$chk=$this->input->post('chk_sri');
		$flg_sale=$this->input->post('hid_sale_type_1');

		$chk_have_invoice=$this->input->post('chk_sale_invoice');
		//echo "<pre>";

		//print_r($this->input->post());die;
			
		if(isset($chk) && !empty($chk) && isset($flg_sale) && ($flg_sale == '' || $flg_sale == '0')){ 
			// If Condition For Select Sales with checked "Have Credit Note"

			if($this->session->userdata('saleID')) {
				$this->session->unset_userdata('saleID');
			}
				
			$srn=$this->input->post('item');
			$itemArr= $this->managesales_model->getSRInfoByInvoiceID($srn);

			
			if(isset($itemArr) && !empty($itemArr)){
				$mode_name=$itemArr['cnote_number'];
				/*Add Invoice*/
					$payData = array(
					'mode' => $mode_name,
					'amount' => $itemArr['amount'],
					);
					if(!array_key_exists($mode_name,$this->cart->pay_contents())){
						$this->cart->insert_payment($payData);
					}
				/*End*/
			}
			
		}
		elseif(isset($chk_have_invoice) && !empty($chk_have_invoice) && isset($flg_sale) && ($flg_sale != '' || $flg_sale != '0')){
			// Select Return Sales With Checked Have Invoice


				/*$saleID=$this->input->post('item');
				$this->load_sale($saleID);*/

				$saleInvoice=$this->input->post('item');
				$getSale=$this->managesales_model->getSalesIdByInvoice($saleInvoice);

				$saleID=$getSale['sale_ID'];
				$this->session->set_userdata('saleID',$saleID);
				$this->session->set_userdata('chk_have_invoice',$chk_have_invoice);
				$this->load_sale($saleID);

		} else { // Only for Sale Item 

				if($this->session->userdata('saleID')) {
					$this->session->unset_userdata('saleID');
				}

				$itemID=$this->input->post('item');

				// Sale Item Using Barcode with Company Code
				$itemBarcode = $this->managesales_model->getItemInfoByBarcode($itemID, $uInfo['comp_code']);

				if(isset($itemBarcode) && !empty($itemBarcode)) {
					$itemSkuDetail = $itemBarcode;
				} else {
					// Sale Item Using Item Sku with Company Code
					//$itemArr= $this->managesales_model->getItemInfoByID($itemID);
					$itemSkuDetail= $this->managesales_model->getItemInfoBySku($itemID, $uInfo['comp_code']);
				}

				$itemArr=$this->managesales_model->getItemInfoByID($itemSkuDetail['product_id']);


				$vendorSkuDetail = $this->managesales_model->getvendorSkuDetail($itemSkuDetail['sku'], $itemArr['product_id'], $uInfo['comp_code']);


				if(isset($vendorSkuDetail) && !empty($vendorSkuDetail)) {
					if(isset($itemArr) && !empty($itemArr)) {
						$markupAmt = $itemArr['markup_amt'];
						$skuProductMrp = $markupAmt + $vendorSkuDetail['price'];
					}
				} else {
						$skuProductMrp = $itemArr['product_mrp'];
				}

				$getLoyaltyPoint=$this->managesales_model->getPointsByCatId($itemArr['product_category'], $uInfo['comp_code']);
				

				/* Get Offer Details */
				$amt='';$offerVal='';
				if($itemArr['offer_id']!='') {
					$offerWhere=['offer_id'=>$itemArr['offer_id']];
					$getOffer=getSku('offer',$offerWhere);


					if(!empty($getOffer)) {
						$offerType=$getOffer[0]['percentage_or_fixed'];

						$endDate=$getOffer[0]['date_duration_end'];
						$freeProductDate=$getOffer[0]['start_date_free_product'];
						$todayDate = date('Y-m-d');
						$freeProductName=$getOffer[0]['free_product'];

						$endDate1 = date('Y-m-d', strtotime($endDate));
                		$startDate1 = date('Y-m-d', strtotime($todayDate));

						/*if((date('Y-m-d', strtotime($endDate))) >= (date('Y-m-d', strtotime($todayDate)))) {*/

						if((($endDate1 >= $startDate1) && ($endDate != '')) || ($freeProductName != 'NULL')){

							if($offerType==1 || $offerType==2) {
								$offer=$getOffer[0]['offer_discount'];
							} else {
								$offer=$getOffer[0]['free_product'];
							}

							switch($offerType) {
								case 1: 
								   $amt=round(($skuProductMrp * $offer)/100, 2);
								   $offerVal = $skuProductMrp-$amt;
								   $offerType='%(Discount)';
								   break;
								case 2:
									$amt=$offer;
									$offerVal = $skuProductMrp-$amt;
									//$amt=$itemArr['product_mrp'] - $offer;
									$offerType='(Fixed Discount)';
									break;
								case 3:
									$amt=$skuProductMrp;
									$offerVal = $skuProductMrp;
									$offerType='(FreeProduct)';
									break;
							}

							$offerData=['id'=>$itemSkuDetail['sku'],
									'offer_id'=>$itemArr['offer_id'],
									'offer_name'=>isset($getOffer[0]['offer_name']) ? $getOffer[0]['offer_name'] : '',
									'offer_type'=>isset($offerType) ? $offerType : '',
									'discount_freeproduct'=>(isset($offer) ? $offer.$offerType : ''),
									'product_price' => (isset($amt) ? $amt : $itemArr['product_mrp'])];

							$this->cart->insert_offer($offerData);
						}
					}
				}
				/* END Of Offer Details */



				/* Get Tax Details */
				$taxAmt='';
				if($itemArr['product_tax']!='') {
					$explodeArray=explode(',',$itemArr['product_tax']);
					$getTax=$this->managesales_model->getTaxesByTaxId($explodeArray);
					
				//	$getTax=getSku('tax',$taxWhere);
					if(!empty($getTax)) {
						$taxRate=0;
						$taxName='';$taxIds='';$alltax='';$taxrate='';
						foreach($getTax as $getTaxs) {
							$taxRate+=$getTaxs['rate'];
							$taxName.=$getTaxs['tax_name'].',';
							$taxIds.=$getTaxs['tax_id'].',';
							$alltax = $getTaxs['rate'].'%'.',';
							$taxrate .= $getTaxs['rate'].'%'.',';
						}
						if(isset($offerVal) && $offerVal != '') {
							$taxPrice = $offerVal;
						} else {
							$taxPrice = $skuProductMrp;
						}
						
						$taxAmt=($taxPrice * $taxRate)/100;
						$taxData=['id'=>$itemSkuDetail['sku'],
									 'tax_name'=>rtrim($taxName, ','),
									 'tax_ids'=>rtrim($taxIds, ','),
									  'rate'=>$taxRate.'%',
									  'tax_rate'=>rtrim($taxrate, ','),
									  'product_price'=>round($taxAmt,2)];
						$this->cart->insert_tax($taxData);
					}
				}
				/* END Of Tax Details */


				$quantity=1;
				//$price=$itemArr['product_price'];
				$price=getVariationPriceBySku($itemSkuDetail['sku'],$itemSkuDetail['product_id'],$itemArr['product_price']);//$itemArr['product_price'];
				$discount=5;
				
					if($taxAmt!=''&&$offerVal!='') {
						$productPrice=$taxAmt+$offerVal;
					} elseif($offerVal!='') {
						//$productPrice=$itemArr['product_mrp'] - $amt;
						$productPrice=$offerVal;
					} elseif($taxAmt!='') {
						$productPrice=$price + $taxAmt;
					} else {
						$productPrice=$price;
					}


				/* Loyalty Point Minus*/

				if(!empty($getLoyaltyPoint)) {
					$lPoints = $getLoyaltyPoint->loyalty_point;
					$lPrice = $getLoyaltyPoint->price;

					if(isset($lPoints) && $lPoints != '' && $lPoints != 0) {

						if($lPoints>1) {
							if($productPrice > $lPrice) {
								$calculateOnePoint = $lPrice/$lPoints;
								$remainingPrice = $productPrice-$lPrice;

								$getPoint = round($remainingPrice/$calculateOnePoint, 2);

								$allPoints = $lPoints+$getPoint;
							} else {
								$calculateOnePoint = $lPrice/$lPoints;
								$newLPoint = round($lPrice/$productPrice);

								if($productPrice > $calculateOnePoint) {
									$remainingPrice = $productPrice-$calculateOnePoint;
									$getPoint = round($remainingPrice/$calculateOnePoint, 2);
								} else {
									$remainingPrice = $calculateOnePoint-$productPrice;
									$getPoint = round($remainingPrice/$calculateOnePoint, 2);
									$allPoints = $getPoint+$newLPoint;
								}
								$allPoints = $getPoint;
							}
							
						} else {
							if($productPrice > $lPrice) {
								$remainingPrice = $productPrice-$lPrice;
								$getPoint = round($remainingPrice/$lPrice, 2);

								$allPoints = $lPoints+$getPoint;
							} else {
								$getPoint = round($productPrice/$lPrice, 2);

								$allPoints = $getPoint;
							}
							
						}

						$afterDetect = $productPrice-$lPoints;
						$product_price_after_detectpoint = round($afterDetect, 2);
					} else {
						$product_price_after_detectpoint = round($productPrice, 2);
					}
				}

				$saleCustomerInfo = $this->session->userdata('sale_customer_info');

				$point_data = ['id' => $itemSkuDetail['sku'],
							'customer_id'=>(isset($saleCustomerInfo['customer_id']) ? $saleCustomerInfo['customer_id'] : ''),
						   'points'=>(isset($allPoints) ? $allPoints : 0)];
			
				$this->cart->insert_loyalty_point($point_data);

				/* Loyalty Point Minus*/


				/* Gst Calculation */
				$gstInc = $itemArr['gst_inc'];
				if($gstInc == 0) {
					$gstRate = $itemArr['gst_rate'];
					$productMrp = $productPrice;
					$gstAmtWithProductAmt=$productMrp + (($productMrp * $gstRate)/100);
				} else {
					$gstRate = '0';
					$gstAmtWithProductAmt=$productPrice;
				}
				/* Gst Calculation */

			$item_data = array(
				'master_product_id' => $itemArr['product_id'],
				'name' => $itemArr['product_name'],
				'id' => $itemSkuDetail['sku'],
				'qty' => 1,
				'product_price' => $productPrice,
				'markup_per' => $itemArr['markup_per'],
				'markup_amt' => $itemArr['markup_amt'],
				'product_mrp'=>$price,
				'loyalty_point'=>(isset($allPoints) ? $allPoints : 0),
				'loyalty_price'=>(isset($lPrice) ? $lPrice : 0),
				//'price' => $itemArr['product_mrp'],
				'product_tax'=>(isset($getTax[0]['rate']) ? $getTax[0]['rate'] : ''),
				'price' => round($productPrice, 2),
				'gst_per' =>$itemArr['gst_rate'],
				'unit' => $itemArr['product_unit'],
				'discount' => 0,
				'tax' => $gstRate,
				'tax_inc'=>$gstInc,
				'gstAmtWithProductAmt'=>round($gstAmtWithProductAmt, 2),
				'tax_inc_gst_rate'=>$gstRate
			);

			/*echo '<pre>';
			print_r($item_data);
			die;*/

			$this->cart->insert($item_data);

			//	$this->session->set_userdata('product_offer_info',$offerData);
				if($this->session->userdata('_sale_discount')){
					$discount=$this->session->userdata('_sale_discount');
					$this->cart->insert_sale_discount("percent", $discount[0]['percent']);
				}
			}

		$data['cart_items'] = $this->cart->contents(); 
		$this->load->view('managesales/cart_view', $data);
	}
	
	/*
	* delete single cart contents/items
	*/
	function delete_item($rowid = FALSE, $sku = FALSE) {
		
		$data = array(
            'rowid'   => $rowid,
            'qty'     => 0
        );
        $this->cart->update($data);

        $this->cart->remove_offer($sku);
        $this->cart->remove_tax($sku);
        $this->cart->remove_loyalty_point($sku);

        	if($this->session->userdata('_sale_discount')){
				$discount=$this->session->userdata('_sale_discount');
				$this->cart->insert_sale_discount("percent", $discount[0]['percent']);
			}

			if($this->session->userdata('saleID'))
			{
				$this->session->unset_userdata('saleID');
			}
		redirect('sales/managesales');
		
	}

	/*
	* Edit cart contents/items
	*/
	function editable(){
		$this->load->view('managesales/editable');
	}

	/*
	* Edit cart contents/items
	*/
	function edit_cart_item(){
		
		$item_data = array(
		'rowid' => $this->input->post('pk'),
		$this->input->post('name') => $this->input->post('value')
		);

		$this->cart->update($item_data);

		$getCardData = $this->cart->contents();
		
		if($this->input->post('value') != 0) {
			$qty=$getCardData[$this->input->post('pk')]['qty'];
			$sku=$getCardData[$this->input->post('pk')]['id'];

			$loyaltyPoint = $this->session->userdata('_product_loyalty_point_');

			if(isset($loyaltyPoint[$sku])) {
				$getPoint = $getCardData[$this->input->post('pk')]['loyalty_point'];
				$calculatePoint = $getPoint*$qty;
			}

			$saleCustomerInfo = $this->session->userdata('sale_customer_info');

			$point_data = ['id' => $sku,
						'customer_id'=>(isset($saleCustomerInfo['customer_id']) ? $saleCustomerInfo['customer_id'] : ''),
					   'pointsUpdate'=>(isset($calculatePoint) ? $calculatePoint : 0)];
		
			$this->cart->insert_loyalty_point($point_data);
		}
		$data['cart_items'] = $this->cart->contents(); 
		if($this->session->userdata('_sale_discount')){
				$discount=$this->session->userdata('_sale_discount');
				$this->cart->insert_sale_discount("percent", $discount[0]['percent']);
			}
		$this->load->view('managesales/cart_view', $data);
	}

	/*
	* Refresh/Reload cart total
	*/	
	function reloadCartTotal(){
		$data=array();
		$this->load->view('managesales/cart_total', $data);
	}

	/*
	* Add payment to cart total
	*/
	function add_payment(){
		$this->session->unset_userdata('chk_have_invoice');
			
		$sale_type=$this->input->post('hid_sale_type');
		$pay_mode='';
		switch ($sale_type) {
			case 1:
				$pay_mode=$this->input->post('ret_pay_mode');

				unset($this->cart->_payment_options_amount);
				$this->session->unset_userdata('_payment_options_amount');
				break;
			case 0:
				$pay_mode=$this->input->post('pay_mode');
				break;
		}

		$item_data = array(
			'mode' => $pay_mode,
			'amount' => $this->input->post('pay_amount'),
		);
		$this->cart->insert_payment($item_data);
	
		$this->reloadCartTotal();
	}

	/*
	* Remove payment and paymethod from cart
	*/
	function remove_payment(){

		$pay_id=$this->input->post('pay_id');
		$this->cart->remove_payment($pay_id);
		$this->reloadCartTotal();
	}

	function fetch_pay(){
		$cc=array();
		if ($this->session->userdata('_payment_options_amount') !== FALSE)
		{
			$cc = $this->session->userdata('_payment_options_amount');
		}
		var_dump($cc);
	}

	function mypdf(){

		$data=array();
	  	$this->load->view('managesales/pdf',$data);
	}

	/*
	* Complete sale and generate Invoice
	*/
	function complete_sale(){
		global $uInfo;
	
	  if($this->input->post())
	   {
	   		$uInfo=$this->session->userdata('sales_session_info');
	     	$sData=array(
				'remark' => $this->input->post('sale_comment')
			);
			$saleType=$this->session->userdata('sale_type');

			$saleCustomerInfo = $this->session->userdata('sale_customer_info');
			$loyaltyPoint = $this->session->userdata('_product_loyalty_point_');
	   
		   	$totalPoint=0;
		   	foreach($loyaltyPoint as $loyaltyPoints) {
		   		$totalPoint += $loyaltyPoints['points'];
		   	}

			$param="";
			if($saleType){
				$returnID=$this->managesales_model->create_sale_return($sData);
				$param="1-".$returnID;
				$insertPoints=$returnID;
			}else{
				$saleID=$this->managesales_model->create_sale($sData);	
				$param="0-".$saleID;

				$pointData=['sale_id'=>$saleID,
							'customer_id'=>(isset($saleCustomerInfo['customer_id']) ? $saleCustomerInfo['customer_id'] : 0),
							'points'=>$totalPoint,
							'created_date'=>date('Y-m-d h:i:s')];
				$insertLoyaltyPoints=$this->managesales_model->saleLoyaltyPoint($pointData);
				$insertPoints = $saleID;
			}

	     	if((isset($saleID) && !empty($saleID)) || (isset($returnID) && !empty($returnID)) ){
	     		
	     		$this->cart->destroy();
	     		$this->session->unset_userdata('sale_customer_info');
	     		$this->session->unset_userdata('sale_type');
	     		$this->session->unset_userdata('_product_offer_');
	     		$this->session->unset_userdata('_product_tax_');
	     		$this->session->unset_userdata('_product_loyalty_point_');
	     		
	     		if($saleType){
	     			event_log('return_completed',$uInfo['user_ID'],$insertPoints,'return_completed','SALE',date("Y-m-d h:i:s"),'Successfully Return Item.');

	     			redirect(base_url().'sales/managesales/sales_invoice/'.$param);

	     		}else{
	     			event_log('sale_completed',$uInfo['user_ID'],$insertPoints,'sale_completed','SALE',date("Y-m-d h:i:s"),'Successfully Purchased.');

	     			redirect(base_url().'sales/managesales/sales_invoice/'.$param);
	     		}
	     	}
		}
		else
		{
		  redirect(base_url().'sales/managesales');
		} 
	}


	function sales_invoice(){

		$uInfo=$this->session->userdata('sales_session_info');
		$param= $this->uri->segment(4);


		if (strpos($param, '-') === false) {
			$saleID=$param;	
			$saleType = 0;
		} else {
			$param=explode("-", $param);

			$saleType=$param[0];

			if($saleType){
				$returnID=$param[1];
			}else{
				$saleID=$param[1];	
			}
		}

		$companyDetails = getSku('companies',['comp_id'=>$uInfo['comp_code']]);


	     	if((isset($saleID) && !empty($saleID)) || (isset($returnID) && !empty($returnID)) ){
	     		//$this->cart->destroy();
	     		if($saleType){

	     			/// Sales return block need to be developed
	     			$retData=array();
					$retData['ret_ID']= $returnID;
					$retData['ret_detail']=$this->managesales_model->getReturnDetailByID($returnID);
					$retData['ret_items']=$this->managesales_model->getReturnItemsByID($returnID);
					$retData['ret_payments']=$this->managesales_model->getReturnPaymentsByID($returnID);

					$retData['ret_store_info']=$this->managesales_model->getStoreInfoByID($uInfo['store']);

					$retData['ret_credit_note']=$this->managesales_model->getCreditNote($returnID);


					$companyId = (isset($retData['ret_store_info']['comp_code']) && ($retData['ret_store_info']['comp_code'] != '')) ? $retData['ret_store_info']['comp_code'] : $uInfo['comp_code'];

			     	$companyUserId = (isset($retData['ret_store_info']['user_ID']) && ($retData['ret_store_info']['user_ID'] != '')) ? $retData['ret_store_info']['user_ID'] : $uInfo['user_ID'];

					$retData['companyDetails'] = $this->managesales_model->companyInfoById($companyId, $companyUserId);
					$retData['companyID'] = $companyId;

					$retData['companyFirmInfo'] = $this->managesales_model->companyFirmInfoById($companyId, $companyUserId);

					/*$companyUserId = $retData['ret_store_info']['user_ID'];

					$retData['companyDetails'] = $this->managesales_model->companyInfoById($companyUserId);*/

					$custID=false;
					$custID=$this->managesales_model->getReturnCustomerByID($returnID);

					if($custID){
						$retData['ret_customer']=$this->managesales_model->getCustomerInfoByID($custID);
					}

					$this->load->view('managesales/print_return_invoice',$retData);

	     		} else {
	     			
					$saleData=array();
					$saleData['sale_ID']= $saleID;
					$saleData['sale_detail']=$this->managesales_model->getSaleDetailByID($saleID);
					$saleData['sale_items']=$this->managesales_model->getSaleItemsByID($saleID);

					$saleData['sale_payments']=$this->managesales_model->getSalePaymentsByID($saleID);

					$saleData['sale_store_info']=$this->managesales_model->getStoreInfoByID($uInfo['store']);
					

					$custID=false;
					$custID=$this->managesales_model->getSaleCustomerByID($saleID);

					if($custID){
					$saleData['sale_customer']=$this->managesales_model->getCustomerInfoByID($custID);
					}

					$companyId = (isset($saleData['sale_store_info']['comp_code']) && ($saleData['sale_store_info']['comp_code'] != '')) ? $saleData['sale_store_info']['comp_code'] : $uInfo['comp_code'];
			     	$companyUserId = (isset($saleData['sale_store_info']['user_ID']) && ($saleData['sale_store_info']['user_ID'] != '')) ? $saleData['sale_store_info']['user_ID'] : $uInfo['user_ID'];

					$saleData['companyDetails'] = $this->managesales_model->companyInfoById($companyId, $companyUserId);
					$saleData['companyID'] = $companyId;


					/*echo $companyId.'=='.$companyUserId;
					die;*/

					$saleData['companyFirmInfo'] = $this->managesales_model->companyFirmInfoById($companyId, $companyUserId);
					/*if(isset($companyFirmInfo) && !empty($companyFirmInfo)) {
						$saleData['companyFirmDetails'] = $companyFirmInfo;
					} else {
						$saleData['companyFirmDetails'] = '';
					}*/

					/*$companyUserId = $saleData['sale_store_info']['user_ID'];

					$saleData['companyDetails'] = $this->managesales_model->companyInfoById($companyUserId);
					$saleData['companyID'] = $companyUserId;*/

					
					$this->load->view('managesales/print_invoice',$saleData);
	     		}
	     	}
	}

	/*
	* Load sale in cart by ID
	*/

	function load_sale($saleID){

		
		$this->load->library('cart');
		$this->clear_sale();
/*		$chk=$this->input->post('chk_sri');
		$flg_sale=$this->input->post('hid_sale_type_1');

				$retFlg=$this->input->post('hid_sale_type_1');*/
		
				$custID=false;
				$cData="";
				$custID=$this->managesales_model->getSaleCustomerByID($saleID);
				$chk_have_invoice = $this->session->userdata('chk_have_invoice');

				if($custID){
				$cData=$this->managesales_model->getCustomerInfoByID($custID);

				$customer_data = array(
				'customer_id' => $cData['customer_id'],
				'customer_name' => $cData['fname']."" .$cData['lname'],
				'customer_email' => $cData['email'],
				'customer_phone' => $cData['mobile_number'],
				'customer_city_name' => $cData['city'],
				'customer_address' => $cData['address'],
				'customer_city' => $cData['city_id'],
				'customer_state' => $cData['state_id'],
				'customer_country' => $cData['country_id'],
				'cust_gst_number' => $cData['cust_gst_number']
				);

				$this->session->set_userdata('sale_customer_info',$customer_data);
				}

			$saleItems=$this->managesales_model->getSaleItemsByID($saleID);

			if(isset($saleItems) && !empty($saleItems)){
				foreach ($saleItems as $itm) {


			/*$item_data = array(
				'master_product_id' => $itemArr['product_id'],
				'name' => $itemArr['product_name'],
				'id' => $itemSkuDetail['sku'],
				'qty' => 1,
				'product_price' => $itemArr['product_price'],
				'markup_per' => $itemArr['markup_per'],
				'markup_amt' => $itemArr['markup_amt'],
				'product_mrp'=>$itemArr['product_mrp'],
				'loyalty_point'=>(isset($allPoints) ? $allPoints : 0),
				'loyalty_price'=>(isset($lPrice) ? $lPrice : 0),
				//'price' => $itemArr['product_mrp'],
				'product_tax'=>($getTax[0]['rate'] != '' ? $getTax[0]['rate'] : ''),
				'price' => round($productPrice, 2),
				'gst_per' =>$itemArr['gst_rate'],
				'unit' => $itemArr['product_unit'],
				'discount' => 0,
				'tax' => 5,
				'tax_inc'=>1
			);*/


				$item_data = array(
				'master_product_id' => $itm['master_product_id'],
				'id' => $itm['product_ID'],
				'name' => $itm['product_detail'],
				'qty' => $itm['quantity'],
				'product_price' => $itm['item_cost_price'],
				//'markup_per' => $itemArr['markup_per'],
				//'markup_amt' => $itemArr['markup_amt'],
				'loyalty_point' => $itm['loyalty_point'],
				'product_mrp' => $itm['product_mrp'],
				'price' => $itm['item_cost_price'],
				'gst_per' =>$itm['tax_per'],
				'unit' => 'pcs',
				'discount' => 0,
				'tax' => 5,
				'tax_inc'=>1,
				'chk_have_invoice' => (isset($chk_have_invoice) && !empty($chk_have_invoice)) ? $chk_have_invoice : 0
				);

				$this->cart->insert($item_data);

				/* Get Offer */
				$offerwhere=['sale_ID'=>$saleID,'product_ID'=>$itm['product_ID']];
				
				$offerData=getSku('sale_offer',$offerwhere);


				if(!empty($offerData)) {
					$where=['offer_id'=>$offerData[0]['offer_ID']];
					$getOffer=getSku('offer',$where);

					if(!empty($getOffer)) {
						$offerType=$getOffer[0]['percentage_or_fixed'];
						$endDate=$getOffer[0]['date_duration_end'];
						$freeProductDate=$getOffer[0]['start_date_free_product'];
						$todayDate = date('Y-m-d');

						if((date('Y-m-d', strtotime($endDate))) >= (date('Y-m-d', strtotime($todayDate)))) {

							if($offerType==1 || $offerType==2) {
								$offer=$getOffer[0]['offer_discount'];
							} else {
								$offer=$getOffer[0]['free_product'];
							}

							switch($offerType) {
								case 1: 
								   $amt=round(($itm['product_mrp'] * $offer)/100, 2);
								   $offerVal = $itm['product_mrp']-$amt;
								   $offerType='%(Discount)';
								   break;
								case 2:
									$amt=$offer;
									$offerVal = $itm['product_mrp']-$amt;
									//$amt=$itemArr['product_mrp'] - $offer;
									$offerType='(Fixed Discount)';
									break;
								case 3:
									$amt=$itm['product_mrp'];
									$offerVal = $itm['product_mrp'];
									$offerType='(FreeProduct)';
									break;
							}

							$offerData=['id'=>$itm['product_ID'],
									'offer_id'=>$itm['offer_id'],
									'offer_name'=>isset($getOffer[0]['offer_name']) ? $getOffer[0]['offer_name'] : '',
									'offer_type'=>isset($offerType) ? $offerType : '',
									'discount_freeproduct'=>(isset($offer) ? $offer.$offerType : ''),
									'product_price' => (isset($amt) ? $amt : $itm['product_mrp'])];

							$this->cart->insert_offer($offerData);
						}

					}
					
				}
				/* Get Offer */



				/* Get Tax */
					$taxwhere=['sale_ID'=>$saleID,'product_ID'=>$itm['product_ID']];
					$taxData=getSku('sale_tax',$taxwhere);

					if(!empty($taxData)) {
						$taxIds=$taxData[0]['tax_id'];
						$explodeArray=explode(',',$taxIds);

						$getTax=$this->managesales_model->getTaxesByTaxId($explodeArray);

						if(!empty($getTax)) {
							$taxRate=0;
							$taxName='';$taxIds='';$alltax='';$taxrate='';
							foreach($getTax as $getTaxs) {
								$taxRate+=$getTaxs['rate'];
								$taxName.=$getTaxs['tax_name'].',';
								$taxIds.=$getTaxs['tax_id'].',';
								$alltax = $getTaxs['rate'].'%'.',';
								$taxrate .= $getTaxs['rate'].'%'.',';
							}

							if(isset($offerVal) && $offerVal != '') {
								$taxPrice = $offerVal;
							} else {
								$taxPrice = $itm['product_mrp'];
							}

							$taxAmt=($taxPrice * $taxRate)/100;
							$taxData=['id'=>$itm['product_ID'],
										 'tax_name'=>rtrim($taxName, ','),
										 'tax_ids'=>rtrim($taxIds, ','),
										  'rate'=>$taxRate.'%',
										  'tax_rate'=>rtrim($taxrate, ','),
										  'product_price'=>round($taxAmt,2)];
							$this->cart->insert_tax($taxData);

							/*$taxAmt=((isset($amt) ? $amt : $itm['product_mrp']) * $taxRate)/100;
							$taxData=['id'=>$itm['product_ID'],
										 'tax_name'=>rtrim($taxName, ','),
										 'tax_ids'=>rtrim($taxIds, ','),
										  'rate'=>$taxRate.'%',
										  'product_price'=>round($taxAmt,2)];
							$this->cart->insert_tax($taxData);*/
						}
					}
				/* Get Tax */

				
				/* Get Loyalty Point */
					$pointWhere=['sale_id'=>$saleID];
					$pointData=getSku('sale_loyalty_point',$pointWhere);

					if($itm['loyalty_point'] != '' || $itm['loyalty_point'] != 0) {

						$point_data = ['id' =>$itm['product_ID'],
							'customer_id'=>(isset($cData['customer_id']) ? $cData['customer_id'] : ''),
						   'points'=>(isset($itm['loyalty_point']) ? $itm['loyalty_point'] : 0)];
			
						$this->cart->insert_loyalty_point($point_data);

					}
				/* Get Loyalty Point */
				}
				

				$disArr=array();
				$saleDetail=$this->managesales_model->getSaleDetailByID($saleID);
				if(!empty($saleDetail)) {
					$disArr['percent']=round($saleDetail['discount_per'],2);
					$disArr['amount']=round($saleDetail['discount_amt'],2);

					$this->cart->load_discount($disArr);
				}
				
				$cart_items = $this->cart->contents(); 

				//echo '<pre>';
				//print_r($carreloadCartTotalt_items);
			}else{
				echo "No Record Found!";
			}
	}


	/*
	* Load sell customer for sale return
	*/
	function load_sell_customer(){

	}

	/*End*/

	/*End*/

	function clear_sale(){
		$this->cart->destroy();
		$this->session->unset_userdata('sale_customer_info');
	}
	/*
	* Change Sales Return Invoice Format
	*/

	function change_return_invoice_format(){
		$uInfo=$this->session->userdata('sales_session_info');
		$frmt=$this->input->post('inv_opt');
		$returnID=$this->input->post('retID');
		/*Fetch Sale Info*/
		$retData=array();
		
	     	if(isset($returnID) && !empty($returnID)){
	     		
	     			$where = ['return_ID'=>$returnID];
					$retData['ret_detail']=$this->managesales_model->getReturnDetailByID($returnID);
					$retData['ret_items']=$this->managesales_model->getReturnItemsByID($returnID);
					$retData['ret_payments']=$this->managesales_model->getReturnPaymentsByID($returnID);

					$retData['ret_store_info']=$this->managesales_model->getStoreInfoByID($uInfo['store']);


					$getCnoteDetail=getSku('credit_note',$where);
					$retData['ret_credit_note']=$getCnoteDetail;


			     	$companyId = (isset($retData['ret_store_info']['comp_code']) && ($retData['ret_store_info']['comp_code'] != '')) ? $retData['ret_store_info']['comp_code'] : $uInfo['comp_code'];

			     	$companyUserId = (isset($retData['ret_store_info']['user_ID']) && ($retData['ret_store_info']['user_ID'] != '')) ? $retData['ret_store_info']['user_ID'] : $uInfo['user_ID'];
			     	

					$retData['companyDetails'] = $this->managesales_model->companyInfoById($companyId, $companyUserId);
					$retData['companyID'] = $companyId;

					$retData['companyFirmInfo'] = $this->managesales_model->companyFirmInfoById($companyId, $companyUserId);

					$custID=false;
					$custID=$this->managesales_model->getReturnCustomerByID($returnID);

					if($custID){
						$retData['ret_customer']=$this->managesales_model->getCustomerInfoByID($custID);
					}
	     	}

		
		/*End*/

		switch ($frmt) {
			case 'A4':
				$this->load->view('managesales/print_return_invoice_A4',$retData);
				break;
			case 'A5':
				$this->load->view('managesales/print_return_invoice_A5',$retData);
				break;
			case 'THRML':
				$this->load->view('managesales/print_return_invoice_thermal',$retData);
				break;	
			
			default:
				
				echo "print in A4";
				break;
		}
	}

	/*
	* Change sales  Invoice Format
	*/
	function change_invoice_format(){
		$uInfo=$this->session->userdata('sales_session_info');
		$frmt=$this->input->post('inv_opt');
		$saleID=$this->input->post('saleID');
		/*Fetch Sale Info*/
		$saleData=array();
	     	if(isset($saleID) && !empty($saleID)){
	     		
	     		
				$saleData['sale_detail']=$this->managesales_model->getSaleDetailByID($saleID);
				$saleData['sale_items']=$this->managesales_model->getSaleItemsByID($saleID);
				$saleData['sale_payments']=$this->managesales_model->getSalePaymentsByID($saleID);

				$saleData['sale_store_info']=$this->managesales_model->getStoreInfoByID($uInfo['store']);


				$custID=false;
				$custID=$this->managesales_model->getSaleCustomerByID($saleID);
				
				if($custID){
					$saleData['sale_customer']=$this->managesales_model->getCustomerInfoByID($custID);
				}
	     	}

	     	$companyId = (isset($saleData['sale_store_info']['comp_code']) && ($saleData['sale_store_info']['comp_code'] != '')) ? $saleData['sale_store_info']['comp_code'] : $uInfo['comp_code'];

			$companyUserId = (isset($saleData['sale_store_info']['user_ID']) && ($saleData['sale_store_info']['user_ID'] != '')) ? $saleData['sale_store_info']['user_ID'] : $uInfo['user_ID'];

			$saleData['companyDetails'] = $this->managesales_model->companyInfoById($companyId, $companyUserId);
			$saleData['companyID'] = $companyId;

			$saleData['companyFirmInfo'] = $this->managesales_model->companyFirmInfoById($companyId, $companyUserId);
		
		/*End*/

		switch ($frmt) {
			case 'A4':
				$this->load->view('managesales/print_invoice_A4',$saleData);
				break;
			case 'A5':
				$this->load->view('managesales/print_invoice_A5',$saleData);
				break;
			case 'THRML':
				$this->load->view('managesales/print_invoice_thermal',$saleData);
				break;	
			
			default:
				
				echo "print in A4";
				break;
		}
	

	}

	/*
	* Apply percent discount on total cart
	*/
	function apply_percent_discount(){
		
		$val=$this->input->post('value');
		$this->cart->insert_sale_discount("percent", $val);
		$cc = $this->session->userdata('_sale_discount');

	}

	/*
	* Apply fixed amount/value discount on total cart
	*/
	function apply_fixed_discount(){

		$val=$this->input->post('value');
		$this->cart->insert_sale_discount("value", $val);
		$cc = $this->session->userdata('_sale_discount');

	}

	/*
	* Add Existing Customer to Sale
	*/
	function add_sell_customer(){
		

		if ($this->session->userdata('sale_customer_info') !== FALSE)
		{
			$this->session->unset_userdata('sale_customer_info');
		}

		$custID=$this->input->post('customer');

		$cData=$this->managesales_model->getCustomerInfoByID($custID);

		$customer_data = array(
		'customer_id' => $cData['customer_id'],
		'customer_name' => $cData['fname']."" .$cData['lname'],
		'customer_email' => $cData['email'],
		'customer_phone' => $cData['mobile_number'],
		'customer_city_name' => $cData['city'],
		'customer_address' => $cData['address'],
		'customer_city' => $cData['city_id'],
		'customer_state' => $cData['state_id'],
		'customer_country' => $cData['country_id'],
		'cust_gst_number' => $cData['cust_gst_number'],
		);
		$this->session->set_userdata('sale_customer_info',$customer_data);
		$cName=$cData['fname']."" .$cData['lname'];

		

		$txt='<table width="100%" style="text-align: center;">
						<tr>
							<td>
									
								<table>
									<tr><td width="50%">Name:</td><td width="50%">'.$cName.'</td></tr>
									<tr><td width="50%">Email:</td><td width="50%">'.$cData['email'].'</td></tr>
									<tr><td width="50%">Phone:</td><td width="50%">'.$cData['mobile_number'].'</td></tr>
								</table>
								
							</td>
						</tr>
						<tr>
							<td>
								<button class="btn btn-sm btn-success" id="btn_add_payment" onclick="remove_customer();">
												<i class="ace-icon fa fa-plus"></i>
												<span class="bigger-110 no-text-shadow">Remove Customer</span>
											</button>
							</td>
						</tr>
						</table>';
			echo $txt;

	}

	/*
	* Load Sale Customer
	*/

	function load_sale_customer(){
		
		$cData=array();

		$cData=$this->session->userdata('sale_customer_info');

		if (isset($cData) && !empty($cData))
		{

		$txt='<table width="100%" style="text-align: center;">
						<tr>
							<td>
									
								<table>
								<tr><td width="50%">Name:</td><td width="50%">'.$cData['customer_name'].'</td></tr>
									<tr><td width="50%">Email:</td><td width="50%">'.$cData['customer_email'].'</td></tr>
									<tr><td width="50%">Phone:</td><td width="50%">'.$cData['customer_phone'].'</td></tr>
								</table>
								
							</td>
						</tr>
						<tr>
							<td>
								<button class="btn btn-sm btn-success" id="btn_add_payment" onclick="remove_customer();">
												<i class="ace-icon fa fa-plus"></i>
												<span class="bigger-110 no-text-shadow">Remove Customer</span>
											</button>
							</td>
						</tr>
						</table>';
			echo $txt;
		}
	}

	/*End*/


	/*
	* Load Item Offer
	*/
		function load_item_offer(){

			$cData=$this->session->userdata('_product_offer_');

			if (isset($cData) && !empty($cData))
			{
				$txt='';
				$txt.='<table style="border-bottom: 2px solid #ccc; width: 100%; border-collapse: separate;">
									<thead><tr>
										<th>Item</th>
										<th>Offer</th>
									</tr></thead>
									<tbody>';
									$fixedSum=0;
									 foreach($cData as $key=>$cDatas) { 
									 	$type=$cDatas['offer_type'];

										if($type==2) {
											if(is_numeric($cDatas['discount'])) {
												$fixedSum +=$cDatas['discount'];
											}
										}

										if($type==1) {
											if(is_numeric($cDatas['discount'])) {
												$perDiscount = $cDatas['discount'];

												//$amt=($cDatas['product_price'] * $perDiscount)/100;
												$this->cart->offerpercent_discount($perDiscount);
											}
										}

								$txt.='<tr class="'.$fixedSum.'">
											<td>'.$key.'</td>
											<td>'.$cDatas['discount'].'</td>
										</tr>';
									} 
									$txt.='</tbody>
								</table>';

				$offerDiscount = $this->cart->total_offerfixed_discount($fixedSum);
				//$offerDiscount = $this->session->set_userdata('offer_discount', $sum);
				
			echo $txt;
				}
		}
	/*End*/


	/*
	* Load Item Tax
	*/
		function load_item_tax(){
			$cData=$this->session->userdata('_product_tax_');

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
			


			if (isset($res) && !empty($res))
			{
				$txt='';
				$txt.='<table style="border-bottom: 2px solid #ccc; width: 100%; border-collapse: separate;">
					<thead><tr>
						<th>Item</th>
						<th>Tax Name</th>
						<th>Rate</th>
					</tr></thead>
					<tbody>';
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
					 } 	
					
						$txt.='</tbody>
					</table>';
			echo $txt;
			}
		}
	/*End*/


	/* Reprint Button */
		function reprint_button() {
			$saleID=$this->session->userdata('saleID');

			if(isset($saleID) && !empty($saleID)) {
				$txt='';
				$txt .= '<a href="'.base_url().'sales/managesales/sales_invoice/'.$saleID.'"><button>Re-Print</button></a>';

				echo $txt;
			}
		}
	/*End*/


	function fixedOffer_discount(){
		if($this->session->userdata('_offer_discount')){
			$saleArr=$this->session->userdata('_offer_discount');
			echo $saleArr[0];
		}else{
			echo (int) 0;
		}
	}


	/*
	* Unlink customer from sale
	*/
	function remove_customer(){
		if ($this->session->userdata('sale_customer_info') !== FALSE)
		{
			$this->session->unset_userdata('sale_customer_info');
		}
	}

	/*
	* Add New Customer
	*/
	function addNewCustomer(){
		global $uInfo;
		$compCode=$uInfo['comp_code'];


		$this->form_validation->set_rules('cust_fname', 'First Name', 'required|alpha');
		//$this->form_validation->set_rules('cust_lname', 'Last Name', 'required|alpha');
		//$this->form_validation->set_rules('cust_email', 'Email', 'required|valid_email|is_unique[customers.email]');
		$this->form_validation->set_rules('cust_phone', 'Phone', 'required|numeric');
		//$this->form_validation->set_rules('store_country', 'Country', 'required');
		//$this->form_validation->set_rules('store_state', 'State', 'required');
		//$this->form_validation->set_rules('store_city', 'City', 'required');


		if ($this->form_validation->run() == FALSE)
		{
			$data = array(
                'cust_fname'=> form_error('cust_fname'),
				//'cust_lname'=> form_error( 'cust_lname'),
				//'cust_email'=> form_error('cust_email'),
				'cust_phone'=> form_error('cust_phone'),
				//'store_country'=> form_error('store_country'),
				//'store_state'=> form_error('store_state'),
				//'store_city'=> form_error('store_city'),
				'error'=>true,
            );

            echo json_encode($data);
			
		}
		else{
			//$this->form_validation->set_message('is_unique',"This %s is already in use.");
			$data = array(
				'fname' => $this->input->post('cust_fname'),
				'lname' => $this->input->post('cust_lname'),
				'email' => $this->input->post('cust_email'),
				'zipcode' => $this->input->post('cust_zip'),
				'address' => $this->input->post('cust_address'),
				'mobile_number' => $this->input->post('cust_phone'),
				'country_id' => $this->input->post('store_country'),
				'state_id' => $this->input->post('store_state'),
				'city_id' => $this->input->post('store_city'),
				'create_date' => date('Y-m-d'),
				'comp_code' => $compCode,
				);

			$custID=$this->managesales_model->insertCustomer($data);
			$cData=$this->managesales_model->getCustomerInfoByID($custID);

			$customer_data = array(
			'customer_id' => $cData['customer_id'],
			'customer_name' => $cData['fname']."" .$cData['lname'],
			'customer_email' => $cData['email'],
			'customer_phone' => $cData['mobile_number'],
			'customer_city' => $cData['city'],
			'customer_state' => $cData['address'],
			);
			$this->session->set_userdata('sale_customer_info',$customer_data);
			$cName=$cData['fname']."" .$cData['lname'];

			$txt='<table width="100%" style="text-align: center;">
						<tr><td width="50%">Name:</td><td width="50%">'.$cName.'</td></tr>
						<tr><td width="50%">Email:</td><td width="50%">'.$cData['email'].'</td></tr>
						<tr><td width="50%">Phone:</td><td width="50%">'.$cData['mobile_number'].'</td></tr>
						<tr>
							<td colspan="2">
								<button class="btn btn-sm btn-success" id="btn_add_payment" onclick="remove_customer();">
									<i class="ace-icon fa fa-plus"></i>
									<span class="bigger-110 no-text-shadow">Remove Customer</span>
								</button>
							</td>
						</tr>
					</table>';
			echo json_encode(array('op'=>$txt,'error'=>false));
		}
	}

	/*
	* Change Sale type (sale/return)
	*/
	function change_sale_type(){

		$tp=(int) $this->input->get('stype');
		switch ($tp) {
			case 0:
				$this->session->set_userdata('sale_type',0);

				unset($this->cart->_payment_options_amount);
				$this->session->unset_userdata('_payment_options_amount');
				break;
			case 1:
				$this->session->set_userdata('sale_type',1);
				unset($this->cart->_payment_options_amount);
				$this->session->unset_userdata('_payment_options_amount');
				break;

		}


	}

	function updt_qty(){
		//$i=1;
		$this->db->query("UPDATE store_inventory SET stock_qty=stock_qty+1 WHERE id=1");
		
		echo  $this->db->last_query();exit;

	}

function gst(){

	$cnote_num=$this->managesales_model->generateCNoteNumber();

	$inv_sr= str_pad($cnote_num, 8,0,STR_PAD_LEFT);
	

	$prefix=$this->config->item('sales_invoice_shortcode');
	$fin_year=$this->config->item('financial_year');

	echo $inv_num=$prefix."-".$fin_year."-".$inv_sr;
	var_dump($cnote_num);

	$cart_contents=$this->session->userdata('_sale_discount');

	echo "<pre>";
	print_r($cart_contents);

	$cart_contents1=$this->session->userdata('cart_contents');

	echo "<pre>";
	print_r($cart_contents1);
	
	//$uInfo=$this->session->userdata('sales_session_info');
	//var_dump($uInfo);die;
	//$sid=70;
	//echo $this->cart->get_gst_total();
	//echo round(5/2,2);
	//echo str_pad(3651, 8,0,STR_PAD_LEFT);
	//$saleInfo=$this->managesales_model->getSaleCustomerByID($sid);
	//var_dump($saleInfo);

	/*For Invoice Generation*/
	//https://stackoverflow.com/questions/12265423/how-to-generate-invoice-number-with-special-requirement-using-php-or-mysql
}


/*
* Daily Day Close
*/
function dailyDayClose() {
	global $uInfo;
	$data['title'] = 'Dashboard | Daliy Day Close';
	$userId=$uInfo['user_ID'];
	$compCode=$uInfo['comp_code'];
	$todayDate = date('Y-m-d');
	//$todayDate = '2018-01-19';

	$getDailyReturndata=$this->managesales_model->dailyReturnInfo($userId, $todayDate);

	foreach($getDailyReturndata as $getDailyReturndatas) {
		$returnId=$getDailyReturndatas['rId'];
		$subTotal[$returnId]=round($getDailyReturndatas['sub_total']);

		$method=$getDailyReturndatas['payment_method'];

		$retResult[$returnId][$method]=$getDailyReturndatas['payment_amount'];
		$retResult[$returnId]['sub_total']=round($getDailyReturndatas['sub_total']);
	}

	if(!empty($retResult)) {
		$data['daily_retresult']=$retResult;
	}

	$getDailySaleData=$this->managesales_model->dailySaleInfo($userId, $todayDate);
	
	foreach($getDailySaleData as $getDailySaleDatas) {
		$saleId=$getDailySaleDatas['sale_ID'];
		$subTotal[$saleId]=round($getDailySaleDatas['sub_total']);

		$method=$getDailySaleDatas['payment_method'];

		$result[$saleId][$method]=$getDailySaleDatas['payment_amount'];
		$result[$saleId]['sub_total']=round($getDailySaleDatas['sub_total']);
	}
	if(!empty($result)) {
		$data['daily_result']=$result;
	}

	//$todayDate1 = '2018-01-30';
	$data['getDayCloseInfo']=$this->managesales_model->getDayClose($todayDate,$userId);
//echo $this->db->last_query();
	$this->load->view('managesales/dailyday_close',$data);
}



/*
* Day Close
*/
function dayClose() {
	global $uInfo;
	$data['title'] = 'Dashboard | Day Close';
	$userId=$uInfo['user_ID'];
	$compCode=$uInfo['comp_code'];
	$todayDate=date('Y-m-d');

	$getData=$this->managesales_model->getDayInfo($todayDate,$userId);
	if(!empty($getData)) {
		$data=['store_id'=>$uInfo['store'],
			'cash'=>$this->input->post('cash'),
			'debit_card'=>$this->input->post('dcard'),
			'credit_card'=>$this->input->post('ccard'),
			'cheque'=>$this->input->post('check'),
			'cnote'=>$this->input->post('cnote'),
			'total'=>$this->input->post('total'),
			'modify_date'=>date('Y-m-d H:i:s')];

		$updateInfo = $this->managesales_model->updateDayInfo($data,$userId,$todayDate);
		$updated = 1;
	} else {
		$result=['user_id'=>$userId,
			'store_id'=>$uInfo['store'],
			'cash'=>$this->input->post('cash'),
			'debit_card'=>$this->input->post('dcard'),
			'credit_card'=>$this->input->post('ccard'),
			'cheque'=>$this->input->post('check'),
			'cnote'=>$this->input->post('cnote'),
			'total'=>$this->input->post('total'),
			'comp_code'=>$compCode,
			'created_date'=>date('Y-m-d H:i:s')];
		$inserted=commonInsert('day_close',$result);
		$updated = 1;
	}

	
	//echo $inserted;

	if($updated == 1) {
		$data = ['day_close'=>1];
		$where = ['user_ID' => $userId];

		$updateDate = updateData('user_master', $data, $where);
	}
	
	echo $updated;
}



/*
* End ManageSales Class
*/	
}

