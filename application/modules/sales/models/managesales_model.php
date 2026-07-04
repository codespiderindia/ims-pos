<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managesales_model extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library('email');
		global $uInfo;
		$uInfo=$this->session->userdata('sales_session_info');
	}

	public function getWarehouseIsCentral(){
		global $uInfo;

		$this->db->select('warehouse_id');
		$this->db->from('warehouse');
		$this->db->where(array('is_central' => '1','comp_code'=>$uInfo['comp_code']));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}
 
	function get_item_suggestions($search, $filters = array('is_deleted' => FALSE, 'search_custom' => FALSE), $unique = FALSE, $limit = 25)
	{
		global $uInfo;
		$compCode=$uInfo['comp_code'];

		$suggestions = array();
		$this->db->select('a.product_id,a.sku,a.attribute_id,GROUP_CONCAT(a.variation_id) as variation_id');
		$this->db->from('product_variations_relations as a');
		$this->db->join('product as b', 'b.product_id = a.product_id','LEFT');
		$this->db->where('b.comp_code',$compCode);
		//$this->db->where('a.flag',1);
		//$this->db->like('b.product_barcode_text', $search);
		$this->db->like('a.sku', $search, 'both');

		$this->db->order_by('a.sku', 'asc');
		$this->db->group_by('a.sku');

		/*$q=$this->db->get()->result();
		echo $this->db->last_query();
		echo '<pre>';
		print_r($q);*/
		
		foreach($this->db->get()->result() as $row)
		{
			$sku=$row->sku;
			$variationId=$row->variation_id;
			$productId=$row->product_id;
			$productName=product_name($productId);

			if($variationId != 0) {
				$arrayVariationId=explode(',', $variationId);
				$this->db->select('*');
				$this->db->from('attribute_value');
				$this->db->where_in('attribute_value_id', $arrayVariationId);
				$result=$this->db->get()->result();
			
				$variations='';
				foreach($result as $results) {
					$variations.=$results->attribute_value.',';
				}
				
				//$where=['attribute_value_id'=>$row->variation_id];
				//$variations=getSku('attribute_value',$where);
			
			//	$variation.=$variations[0]['attribute_value'].',';
				$val=$productName.''.'('.rtrim($variations,',').')';
				$suggestions[]=array('value'=>$sku,'label'=>$val);
			} else {
				$val=$productName.''.'(MainProduct)';
				$suggestions[]=array('value'=>$sku,'label'=>$val);
			}
		}

		/*$this->db->select('product_id, product_name, product_barcode_text');
		$this->db->from('product');
		$this->db->where('comp_code', $compCode);
		$this->db->like('product_name', $search);
		if($search != '') {
			$this->db->or_like('product_barcode_text', $search);
		}
		$this->db->order_by('product_name', 'asc');

		foreach($this->db->get()->result() as $row)
		{
			$prd_name=$row->product_barcode_text." (".$row->product_name.")";
			$suggestions[] = array('value' => $row->product_id, 'label' => $prd_name);
		}*/

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}

		return $suggestions;
	}

	function get_customer_suggestions($search, $filters = array('is_deleted' => FALSE, 'search_custom' => FALSE), $unique = FALSE, $limit = 25)
	{
		global $uInfo;
		$suggestions = array();
		$compCode = $uInfo['comp_code'];

		$this->db->select('customer_id');
		$this->db->select('email');
		$this->db->select("CONCAT_WS((' '),(fname),(lname)) as cust_name");
		$this->db->from('customers');
		//$this->db->like("CONCAT_WS((' '),(fname),(lname))", $search);

		$this->db->like("mobile_number", $search);
		$this->db->like("comp_code", $compCode);

	//	$this->db->or_like('product_barcode_text', $search);
	//	$this->db->order_by('product_name', 'asc');

		foreach($this->db->get()->result() as $row)
		{
			$cust_name=$row->cust_name." (".$row->email.")";
			$suggestions[] = array('value' => $row->customer_id, 'label' => $cust_name);
		}
		
		//echo  $this->db->last_query();
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		//var_dump($suggestions);
		return $suggestions;
	}

	function getItemInfoByID($itmID){
		$this->db->select("product_id,product_name,product_category,product_tax,offer_id,product_price,markup_per,markup_amt,product_mrp,gst_rate,product_unit,gst_inc");
		$this->db->from('product');
		$this->db->where('product_id',$itmID);
	//	$this->db->or_where('product_barcode_text',(int) $itmID);

		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	//function generateSalesInvoiceNumber($locID,$storeID){
	function generateSalesInvoiceNumber(){
		$fyear=$this->config->item('financial_year');
		$uInfo=$this->session->userdata('sales_session_info');
		$this->db->select("(invoice_serial_number + 1) as inv_sno");
		$this->db->from('sales_invoice');
		$this->db->where('comp_ID',$uInfo['comp_code']);
		$this->db->where('loc_ID',$uInfo['location']);
		$this->db->where('store_ID',$uInfo['store']);
		$this->db->where('invoice_financial_year',$fyear);
		$this->db->order_by('invoice_serial_number', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		//echo  $this->db->last_query();exit;
		if($query->num_rows() > 0)
			return $query->row('inv_sno');
		else
			return FALSE;

	}

	function generateSalesReturnInvoiceNumber(){
		$fyear=$this->config->item('financial_year');
		$uInfo=$this->session->userdata('sales_session_info');
		$this->db->select("(ret_invoice_serial_number + 1) as inv_sno");
		$this->db->from('sale_return_invoice');
		$this->db->where('comp_ID',$uInfo['comp_code']);
		$this->db->where('loc_ID',$uInfo['location']);
		$this->db->where('store_ID',$uInfo['store']);
		$this->db->where('ret_invoice_financial_year',$fyear);
		$this->db->order_by('ret_invoice_serial_number', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		//echo  $this->db->last_query();exit;
		if($query->num_rows() > 0)
			return $query->row('inv_sno');
		else
			return FALSE;

	}

	function generateCNoteNumber(){
		$fyear=$this->config->item('financial_year');
		$uInfo=$this->session->userdata('sales_session_info');
		$this->db->select("(cnote_serial_number + 1) as cnote_sno");
		$this->db->from('credit_note');
		$this->db->where('comp_ID',$uInfo['comp_code']);
		$this->db->where('loc_ID',$uInfo['location']);
		$this->db->where('store_ID',$uInfo['store']);
		$this->db->where('cnote_financial_year',$fyear);
		$this->db->order_by('cnote_serial_number', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		//echo  $this->db->last_query();exit;
		if($query->num_rows() > 0)
			return $query->row('cnote_sno');
		else
			return FALSE;

	}

	function create_sale_return($sData){

		//var_dump($this->session->userdata('cart_contents'));
		$igst_flg=0;
		$igst_amt=0;
		$cgst_amt=0;
		$sgst_amt=0;
		$cart_contents=$this->session->userdata('cart_contents');
		$cart_items=$this->cart->contents();

		$uInfo=$this->session->userdata('sales_session_info');

		$custInfo=$this->session->userdata('sale_customer_info');
		
		//var_dump($uInfo);
		//var_dump($custInfo);die;
		$paymentInfo=$this->session->userdata('_payment_options_amount');

		//var_dump($paymentInfo);exit;
		$saleType=$this->session->userdata('sale_type');

		$total_items=$cart_contents['total_items'];
		$cart_total=$cart_contents['cart_total'];
		$cart_total_inc_discount_tax=$cart_contents['cart_total_inc_discount_tax'];


	// Insert sale info	
		$sale_data=array(
				'employee_ID' => $uInfo['user_ID'],
				'sale_type' => $saleType,
				'company_ID' => $uInfo['comp_code'],
				'location_ID' => $uInfo['location'],
				'store_ID' => $uInfo['store'],
				'store_gst_number' => ($uInfo['store_gst'] != '') ? $uInfo['store_gst'] : '',
				'total_items' => $total_items,
				'sub_total' => $cart_total,
				'total' => $cart_total_inc_discount_tax,
				'remark' => $sData['remark'],
				'date_time_created' => date('Y-m-d H:i:s'),
				'comp_code' => $uInfo['comp_code']
			);
		if(isset($custInfo) && !empty($custInfo)){
			
			$sale_data['customer_ID']=$custInfo['customer_id'];
			$sale_data['cust_gst_number']=$custInfo['cust_gst_number'];
			if($custInfo['customer_state']!=$uInfo['store_state']){
				$igst_flg=1;
			} else {
				$igst_flg=0;
			}
		}

		
		$this->db->insert('sale_return', $sale_data);
    	$saleID = $this->db->insert_id();

    // Ends Here

        if(isset($saleID) && !empty($saleID)){

        	/*
			* Generate Invoice
			* Start
        	*/

			

			$inv_serial=$this->generateSalesReturnInvoiceNumber($saleType);
			
			if(!$inv_serial){
				$inv_serial=1;
			}

			$inv_with_pad= str_pad($inv_serial, 8,0,STR_PAD_LEFT);
			
			
			$prefix=$this->config->item('sales_return_invoice_shortcode');

			$fyear=$this->config->item('financial_year');
			$store_code=$uInfo['store_code'];
			if($store_code != '')
			{
				$inv_num=$prefix."-".$store_code."-".$fyear."-".$inv_with_pad;
			} else {
				$inv_num=$prefix."-".$store_code."-".$fyear."-".$inv_with_pad."-".time();
			}
			

			$invData=array(
						'return_ID' => $saleID,
						'comp_ID' => $uInfo['comp_code'],
						'loc_ID' => $uInfo['location'],
						'store_ID' => $uInfo['store'],
						'user_ID' => $uInfo['user_ID'],
						'ret_invoice_serial_number' => $inv_serial,
						'ret_invoice_number' => $inv_num,
						'ret_invoice_financial_year' => $fyear,
						'dt_created' => date("Y-m-d:h-i-s"),
						'dt_updated' => date("Y-m-d:h-i-s"),
					);
			
			$this->db->insert('sale_return_invoice', $invData);

        	/*
			* End
        	*/

        	/*
			* Update Invoice Number In Sale Tab.
        	*/
				$updtInv = array(
				'ret_invoice_number' => $inv_num,
				);
				$this->db->where('return_ID', $saleID);
				$this->db->update('sale_return', $updtInv); 
        	/*
			* End
        	*/

        	
        	if(isset($cart_items) && !empty($cart_items)){
				foreach ($cart_items as $item) {
					//echo $item['name'];
					$itm_igst_amt=0;
					$itm_cgst_amt=0;
					$itm_sgst_amt=0;
					$igp=0;
					$cgp=0;
					$sgp=0;
					if($igst_flg){
						$igp=$item['gst_per'];
						$itm_igst_amt=round((($item['price']*$item['gst_per'])/100),2);
					}else{
						$gp=round(($item['gst_per']/2),2);
						$cgp=$gp;
						$sgp=$gp;
						$itm_cgst_amt=round((($item['price']*$gp)/100),2);
						$itm_sgst_amt=round((($item['price']*$gp)/100),2);

					}
				// Insert Sale Items
					$itemData=array(
						'return_ID' => $saleID,
						'product_ID' => $item['id'],
						'product_detail' => $item['name'],
						'quantity' => $item['qty'],
						'item_cost_price' => $item['price'],
						'item_unit_price' => round($item['subtotal_inc_discount_tax']/$item['qty'],2),
						'discount_per' => $item['discount'],
						'tax_per' => $item['tax'],
						'item_subtotal' => $item['subtotal_inc_discount_tax'],
						'item_subtotal_without_tax_and_dis' => $item['subtotal'],
						'cgst_per' =>$cgp,
						'cgst_amt' =>$itm_cgst_amt,
						'sgst_per' =>$sgp,
						'sgst_amt' =>$itm_sgst_amt,
						'igst_per' =>$igp,
						'igst_amt' =>$itm_igst_amt,
						'master_product_id' => $item['master_product_id']
					);
					$this->db->insert('sale_return_items', $itemData);

					
					/*Update Stock Inventory - Start*/
						$this->db->select("*");
						$this->db->from('store_inventory');
						$this->db->where('product_id',$item['id']);
						$this->db->where('store_id',$uInfo['store']);
						
						$query = $this->db->get();
						if($query->num_rows() > 0){
							$stk_prd= $query->row_array();
							
							$updtQty=0;
							
							switch ($saleType) {
								case 1:
									$updtQty=$stk_prd['stock_qty'] + $item['qty'];
									break;
								case 0:
							
									$updtQty=$stk_prd['stock_qty'] - $item['qty'];
									
									/*
									* To restrict stock in minus
									*/

									/*if($updtQty <=0){
										$updtQty=0;

									}*/
									break;
								
								
							}

							

							$this->db->query("UPDATE store_inventory SET stock_qty=".$updtQty." WHERE store_id=".$uInfo['store']." AND product_id=".$item['id']);
					//echo  $this->db->last_query();exit;


						}
						
					/*Update Stock Inventory - End*/
					
				
				}

				// Insert Sale Payments
				foreach ($paymentInfo as $key=>$val) {
					
					if($key=="cnote"){

						
						/**
						* Create Credit Note Number	
						*/
							$prefix=$this->config->item('credit_note_shortcode');
							$cn_str=generateRandomString(6);
							$cnote_num=$prefix." ".$cn_str;
						/*
						* End
						*/
						$cnoteArr=array(
							'return_ID' => $saleID,
							'cnote_number' => $cnote_num,
							'cnote_barcode' =>base64_encode($cnote_num),
							'amount' => $val,
							'used' => 0,
							'dt_created'=>date('Y-m-d : h-i-s')
						);
					$this->db->insert('credit_note', $cnoteArr);					

					}


					$payData=array(
						'return_ID' => $saleID,
						'payment_method' => $key,
						'payment_amount' => $val,
						'code_if_any' => '',
						
					);
					$this->db->insert('sale_return_payments`', $payData);

					
				

				}
        	}
        	
			
        	
        }else{
        	return FALSE;
        }
		
		return $saleID;
	
	}
	
	function create_sale($sData){
		//var_dump($this->session->userdata('cart_contents'));
		$igst_flg=0;
		$igst_amt=0;
		$cgst_amt=0;
		$sgst_amt=0;
		$dInfo=array();
		$cart_contents=$this->session->userdata('cart_contents');

		$cart_items=$this->cart->contents();

		$uInfo=$this->session->userdata('sales_session_info');

		if($this->session->userdata('_sale_discount')){
			$dInfo = $this->session->userdata('_sale_discount');	
		}else{
			$per=0;
			$amt=0;
			$disArr=array();

			$disArr['percent']=round($per,2);
			$disArr['amount']=round($amt,2);
			
			array_push($dInfo, $disArr);
		}

		$custInfo=$this->session->userdata('sale_customer_info');

		$offerInfo=$this->session->userdata('_product_offer_');

		$taxInfo=$this->session->userdata('_product_tax_');

		
		//var_dump($uInfo);
		//var_dump($custInfo);die;
		$paymentInfo=$this->session->userdata('_payment_options_amount');

		//var_dump($paymentInfo);exit;
		$saleType=$this->session->userdata('sale_type');

		$total_items=$cart_contents['total_items'];
		$cart_total=$cart_contents['cart_total'];
		$cart_total_new=$this->cart->total_inc_sale_discount();
		$cart_total_inc_discount_tax=$cart_contents['cart_total_inc_discount_tax'];


	// Insert sale info	
		$sale_data=array(
				'employee_ID' => $uInfo['user_ID'],
				'sale_type' => $saleType,
				'company_ID' => $uInfo['comp_code'],
				'location_ID' => $uInfo['location'],
				'store_ID' => $uInfo['store'],
				'store_gst_number' => (isset($uInfo['store_gst']) ? $uInfo['store_gst'] : 0),
				'total_items' => $total_items,
				'discount_amt' => $dInfo[0]['amount'],
				'discount_per' => $dInfo[0]['percent'],
				'sub_total' => $cart_total,
				'total_new' => $cart_total_new,
				'total' => $cart_total_inc_discount_tax,
				'remark' => $sData['remark'],
				'date_time_created' => date('Y-m-d H:i:s'),
				'comp_code' => $uInfo['comp_code']
			);

		if(isset($custInfo) && !empty($custInfo)){
			
			$sale_data['customer_ID']=$custInfo['customer_id'];
			$sale_data['cust_gst_number']=(isset($custInfo['cust_gst_number']) ? $custInfo['cust_gst_number'] : 0);
			if($custInfo['customer_state']!=$uInfo['store_state']){
				$igst_flg=1;
			}

		}

		$this->db->insert('sale', $sale_data);
        $saleID = $this->db->insert_id();
    // Ends Here

        if(isset($saleID) && !empty($saleID)){

        	/*
			* Generate Invoice
			* Start
        	*/

			$inv_serial=$this->generateSalesInvoiceNumber();
			
			if(!$inv_serial){
				$inv_serial=1;
			}

			$inv_with_pad= str_pad($inv_serial, 8,0,STR_PAD_LEFT);
			$prefix=$this->config->item('sales_invoice_shortcode');
			$fyear=$this->config->item('financial_year');
			$store_code=$uInfo['store_code'];
			if($store_code != '') {
				$inv_num=$prefix."-".$store_code."-".$fyear."-".$inv_with_pad;
			} else {
				$inv_num=$prefix."-".$store_code."-".$fyear."-".$inv_with_pad."-".time();
			}
			

			$invData=array(
						'sale_ID' => $saleID,
						'comp_ID' => $uInfo['comp_code'],
						'loc_ID' => $uInfo['location'],
						'store_ID' => $uInfo['store'],
						'user_ID' => $uInfo['user_ID'],
						'invoice_serial_number' => $inv_serial,
						'invoice_number' => $inv_num,
						'invoice_financial_year' => $fyear,
						'dt_created' => date("Y-m-d:h-i-s"),
						'dt_updated' => date("Y-m-d:h-i-s"),
					);
			
			$this->db->insert('sales_invoice', $invData);

        	/*
			* End
        	*/

        	/*
			* Update Invoice Number In Sale Tab.
        	*/
        	$randomlen = generateRandomString(4);
        	$inv_barcode = $store_code."-".$fyear.'-'.$inv_with_pad.'-'.$randomlen;
				$updtInv = array(
				'invoice_number' => $inv_num,
				'invoice_barcode'=> $inv_barcode
				);
				$this->db->where('sale_ID', $saleID);
				$this->db->update('sale', $updtInv); 
        	/*
			* End
        	*/


        	if(isset($cart_items) && !empty($cart_items)){
				foreach ($cart_items as $item) {
					//echo $item['name'];
					$itm_igst_amt=0;
					$itm_cgst_amt=0;
					$itm_sgst_amt=0;
					$igp=0;
					$cgp=0;
					$sgp=0;
					if($igst_flg){
						$igp=$item['gst_per'];
						$itm_igst_amt=round((($item['qty']*$item['price']*$item['gst_per'])/100),2);
					}else{
						$gp=round(($item['gst_per']/2),2);
						$cgp=$gp;
						$sgp=$gp;
						$itm_cgst_amt=round((($item['qty']*$item['price']*$gp)/100),2);
						$itm_sgst_amt=round((($item['qty']*$item['price']*$gp)/100),2);

					}
				// Insert Sale Items
					$itemData=array(
						'sale_ID' => $saleID,
						'product_ID' => $item['id'],
						'product_detail' => $item['name'],
						'quantity' => $item['qty'],
						'item_cost_price' => $item['price'],
						'item_unit_price' => round($item['subtotal_inc_discount_tax']/$item['qty'],2),
						'product_mrp' => $item['product_mrp'],
						'discount_per' => $item['discount'],
						'tax_per' => $item['tax'],
						'product_tax' => $item['product_tax'].'%',
						'gst_inc' => $item['tax_inc'],
						'loyalty_point' => $item['loyalty_point'],
						'item_subtotal' => $item['subtotal_inc_discount_tax'],
						'item_subtotal_without_tax_and_dis' => $item['subtotal'],
						'cgst_per' =>$cgp,
						'cgst_amt' =>$itm_cgst_amt,
						'sgst_per' =>$sgp,
						'sgst_amt' =>$itm_sgst_amt,
						'igst_per' =>$igp,
						'igst_amt' =>$itm_igst_amt,
						'master_product_id' =>$item['master_product_id'],
					);
					$this->db->insert('sale_items', $itemData);
					$lastItemId=$this->db->insert_id();

					$sku=$item['id'];

					/* Insert Sale Offer */
					$offerData=$offerInfo[$sku];
					$saleOffer = [
							'sale_ID'=>$saleID,
							'sale_item_ID'=>$lastItemId,
							'product_ID'=>$item['id'],
							'offer_ID'=>$offerData['offer_id'],
							'offer_discount'=>$offerData['discount'],
							'offer_price'=>$offerData['product_price'],
							'created_date'=>date('Y-m-d h:i:s')
						];
					$this->db->insert('sale_offer', $saleOffer);
					/* Insert Sale Offer */


					/* Insert Sale Tax */
					$taxData=$taxInfo[$sku];

					if(!empty($taxData)) {
						$saleTax = ['sale_ID'=>$saleID,
								'sale_item_ID'=>$lastItemId,
								'product_ID'=>$item['id'],
								'tax_id'=>$taxData['tax_ids'],
								'tax_rate'=>$taxData['rate'],
								'tax_price'=>$taxData['product_price'],
								'created_date'=>date('Y-m-d h:i:s')];
						$this->db->insert('sale_tax', $saleTax);
					}
					
					/* Insert Sale Tax */

					
					/*Update Stock Inventory - Start*/
						$this->db->select("*");
						$this->db->from('store_inventory');
						$this->db->where('product_id',$item['id']);
						$this->db->where('store_id',$uInfo['store']);
						
						$query = $this->db->get();
						if($query->num_rows() > 0){
							$stk_prd= $query->row_array();
							
							$updtQty=0;
							
							switch ($saleType) {
								case 1:
									$updtQty=$stk_prd['stock_qty'] + $item['qty'];
									break;
								case 0:
							
									$updtQty=$stk_prd['stock_qty'] - $item['qty'];
									
									/*
									* To restrict stock in minus
									*/

									/*if($updtQty <=0){
										$updtQty=0;

									}*/
									break;
								
							}


							$this->db->query("UPDATE store_inventory SET stock_qty=".$updtQty." WHERE store_id=".$uInfo['store']." AND product_id=".$item['id']);
					//echo  $this->db->last_query();exit;


						}
						
					/*Update Stock Inventory - End*/
					
				}

				// Insert Sale Payments
				foreach ($paymentInfo as $key=>$val) {

					$payData=array(
						'sale_ID' => $saleID,
						'payment_method' => $key,
						'payment_amount' => $val,
						'code_if_any' => '',
						'created_date' => date('Y-m-d h:i:s')
					);
					$this->db->insert('sale_payments`', $payData);

					$crd_note=explode(" ", $key);

					if(count($crd_note)>=2){

							$cnoteArr=array(
							'used' => 1,
							);
							
							$this->db->WHERE("cnote_number LIKE","%$key%");
							$this->db->update('credit_note', $cnoteArr);
					}
				//var_dump($item);exit;

				}
        	}
        	
			
        	
        }else{
        	return FALSE;
        }
		
		return $saleID;
	}

	function getSaleDetailByID($saleID){
		$this->db->select("*");
		$this->db->from('sale');
		$this->db->where('sale_ID',$saleID);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;

	}

	// Get sale return detail
	function getReturnDetailByID($retID){
		$this->db->select("*");
		$this->db->from('sale_return');
		$this->db->where('return_ID',$retID);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;

	}

	function getSaleItemsByID($saleID){
		$this->db->select("*");
		$this->db->from('sale_items');
		$this->db->join('product', 'product.product_id = sale_items.master_product_id', 'left');

		$this->db->where('sale_ID',$saleID);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;

	}

	// Get return Items
	function getReturnItemsByID($retID){
		$this->db->select("*");
		$this->db->from('sale_return_items');
		$this->db->join('product', 'product.product_id = sale_return_items.master_product_id', 'left');

		$this->db->where('return_ID',$retID);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function getSalePaymentsByID($saleID){
		$this->db->select("*");
		$this->db->from('sale_payments');
		$this->db->where('sale_ID',$saleID);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;

	}

	// 

	function getReturnPaymentsByID($retID){
		$this->db->select("*");
		$this->db->from('sale_return_payments');
		$this->db->where('return_ID',$retID);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}

	function getCustomerInfoByID($cid){
		$this->db->select("*");
		$this->db->from('customers');
		$this->db->where('customer_id',$cid);
	
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;

	}

	function getSaleCustomerByID($saleID){
		$this->db->select("customer_ID");
		$this->db->from('sale');
		//$this->db->join('customers as c','c.customer_id=s.customer_ID','left');
		$this->db->where('sale_ID',$saleID);
	
		$custID = $this->db->get()->row('customer_ID');

		if(isset($custID) && !empty($custID)){
			

			return $custID;	
		}else{
			return false;
		}
	}


// Get Return customer info
	function getReturnCustomerByID($retID){
		$this->db->select("customer_ID");
		$this->db->from('sale_return');
		//$this->db->join('customers as c','c.customer_id=s.customer_ID','left');
		$this->db->where('return_ID',$retID);
	
		$custID = $this->db->get()->row('customer_ID');

		if(isset($custID) && !empty($custID)){
			

			return $custID;	
		}else{
			return false;
		}

		

	}

	function insertCustomer($cData){

		if($this->db->insert('customers',$cData))
			 return $this->db->insert_id();
		 else
			 return false;
	}

	function getSRInfoByInvoiceID($srnID){
		$this->db->select("*");
		$this->db->from('credit_note');
		$this->db->where('used',0);
		$this->db->like('cnote_number',$srnID);

		$query = $this->db->get();
		//echo  $this->db->last_query();exit;
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;

	}

	function getStoreInfoByID($strID){
		$this->db->select("*");
		$this->db->from('store');
		$this->db->join('companies', 'companies.comp_id = store.comp_code', 'left');
		$this->db->where('store_id',$strID);
		$query = $this->db->get();

		//echo  $this->db->last_query();exit;
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;

	}
	

	function getSalesIdByInvoice($invoice) {
		$this->db->select("*");
		$this->db->from('sale');
		$this->db->where('invoice_number',$invoice);
		$query = $this->db->get();

		//echo  $this->db->last_query();exit;
		if($query->num_rows() > 0)

			return $query->row_array();
		else
			return FALSE;
	}


	function getCreditNote($returnId) {
		$this->db->select("*");
		$this->db->from('credit_note');
		$this->db->where('return_ID',$returnId);
		$query = $this->db->get();

		//echo  $this->db->last_query();exit;
		if($query->num_rows() > 0)

			return $query->row_array();
		else
			return FALSE;
	}


	function getReturnIdByInvoice($invoice) {
		$this->db->select("*");
		$this->db->from('sale_return_invoice');
		$this->db->where('ret_invoice_number',$invoice);
		$query = $this->db->get();

		//echo  $this->db->last_query();exit;
		if($query->num_rows() > 0)

			return $query->row_array();
		else
			return FALSE;
	}

	
	function getItemInfoBySku($itmID, $compCode){
		$this->db->select("a.product_id,a.sku,b.product_name,b.product_category,b.product_tax,b.offer_id,b.product_price,b.markup_per,b.markup_amt,b.product_mrp,b.gst_rate,b.product_unit");
		$this->db->from('product_variations_relations as a');
		$this->db->join('product as b','b.product_id = a.product_id', 'LEFT');
		$this->db->where('a.sku',$itmID);
		$this->db->where('b.comp_code', $compCode);
		//$this->db->where('flag', 1);

		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function getTaxesByTaxId($id) {
		$this->db->select("*");
		$this->db->from('tax');
		$this->db->where_in('tax_id',$id);
		$this->db->where('tax_status',1);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
	}


	function getPointsByCatId($catId, $compCode) {
		$this->db->select('*');
		$this->db->from('loyalty_point');
		$this->db->where(['category_id'=>$catId, 'comp_code'=>$compCode]);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}


	function saleLoyaltyPoint($data) {
		$this->db->insert('sale_loyalty_point', $data);
    	$saleLoyaltyPoint = $this->db->insert_id();
    	return $saleLoyaltyPoint;
	}

	function dailySaleInfo($userid, $date) {
		global $uInfo;
		$this->db->select('a.sale_ID,a.sub_total,b.*');
		$this->db->from('sale as a');
		$this->db->join('sale_payments as b','b.sale_ID = a.sale_ID', 'LEFT');
		$this->db->where("`a.date_time_created` LIKE '%$date%'");
		$this->db->where('a.comp_code',$uInfo['comp_code']);
		$this->db->where('a.employee_ID',$userid);
	//	$this->db->group_by('a.sale_ID');
		$query = $this->db->get();
		return $query->result_array();
	}

	function dailyReturnInfo($userId, $date) {
		global $uInfo;
		$this->db->select('a.return_ID as rId,a.sub_total,b.*');
		$this->db->from('sale_return as a');
		$this->db->join('sale_return_payments as b','b.return_ID = a.return_ID', 'LEFT');
		$this->db->where("`a.date_time_created` LIKE '%$date%'");
		$this->db->where('a.comp_code',$uInfo['comp_code']);
		$this->db->where('a.employee_ID',$userId);
		$query = $this->db->get();
		/*echo $this->db->last_query();
		die;*/
		return $query->result_array();
	}

	function getDayClose($date,$userId) {
		global $uInfo;
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where("`user_ID`",$userId);
		$query = $this->db->get();
		if($query->num_rows()>0){
			$res = $query->row();

			$this->db->select('*');
			$this->db->from('day_close');
			$this->db->where("`created_date` LIKE '%$date%'");
			$query = $this->db->get();
			if($query->num_rows()>0){
				$res1 = $query->result_array();
				return ['dayClose'=>$res1, 'userInfo'=>$res];
			} else {
				return ['userInfo'=>$res];
			}

		} else {
			return false;
		}


		/*$this->db->select('*');
		$this->db->from('day_close as a');
		$this->db->join('user_master as b', 'b.user_ID = a.user_id');
		$this->db->where("`a.created_date` LIKE '%$date%'");
		$this->db->where("`a.user_ID`",$userId);
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}*/
	}

	function getDayInfo($date,$userId) {
		global $uInfo;
		$this->db->select('*');
		$this->db->from('day_close');
		$this->db->where("`created_date` LIKE '%$date%'");
		$this->db->where('comp_code',$uInfo['comp_code']);
		$this->db->where('user_id',$userId);
		$query = $this->db->get();
		/*echo $this->db->last_query();
		die;*/
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	function updateDayInfo($data,$userId,$todayDate) {
		$this->db->where("`created_date` LIKE '%$todayDate%'");
		$this->db->where('user_id',$userId);
		$this->db->update('day_close',$data);
	}

	function companyInfoById($companyId, $userId) {
		global $uInfo;
		$this->db->select('b.comp_name, b.comp_address, b.comp_image, a.invoice_header, a.invoice_footer');
		$this->db->from('user_master as a');
		$this->db->join('companies as b', 'a.comp_code = b.comp_id', 'LEFT');
		$this->db->where(['a.comp_code'=>$companyId]);
		$query = $this->db->get();
		/*echo $this->db->last_query();
		die;*/
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function companyFirmInfoById($companyCode, $userId) {
		global $uInfo;
		$this->db->select('firm_name, firm_logo, firm_address, firm_teen_num');
		$this->db->from('firm_details');
		$this->db->where(['comp_code'=>$companyCode]);
		$query = $this->db->get();

		if($query->num_rows()>0){
			return $query->row();
		} else {
			return false;
		}
	}



	function getItemInfoByBarcode($itmebarcode, $compcode){
		$this->db->select("a.product_id,b.sku,a.product_name,a.product_category,a.product_tax,a.offer_id,a.product_price,a.markup_per,a.markup_amt,a.product_mrp,a.gst_rate,a.product_unit");
		$this->db->from('product as a');
		$this->db->join('product_variations_relations as b', 'b.product_id = a.product_id');
		//$this->db->where('a.comp_code',$compcode);
		$this->db->where(['a.comp_code'=>$compcode, 'b.relation_common_id'=>0, 'b.attribute_id'=>0, 'b.variation_id'=>0]);
		//$this->db->or_where(['a.comp_code'=>$compcode]);
		$this->db->like('a.product_barcode_text',$itmebarcode);
		$query = $this->db->get();
		/*echo $this->db->last_query();
		die;*/
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function getvendorSkuDetail($sku, $productId, $compCode) {
		$this->db->select('quantity,price');
		$this->db->from('vendor_to_wh_product');
		$this->db->where(['product_id'=>$sku, 'master_product_id'=>$productId, 'comp_code'=>$compCode]);

		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}
  	
}