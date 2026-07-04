<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manageproducts extends CI_Controller {
/**

	 * Index Page for this controller.
*/	
	public function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			global $uInfo;
			$uInfo=$this->session->userdata('dealer_session_info');
			
			if (!($this->session->userdata('dealer_session_info'))) {
				redirect(base_url().'dealer/login');
			}
			$this->load->model('manageproducts_model');
			$this->load->model('common');
		}
	
	public function index()
	{
		global $uInfo;

		if (isset($uInfo) && !empty($uInfo)) {
			$data['title'] = 'Products | Inventory';
			$data['heading'] = 'View Products';
			redirect(base_url().'dealer/manageproducts/viewProducts');
		}
		
	}

	public function viewProducts()
	{
		global $uInfo;
		$config = array();
        $config["base_url"] = base_url() . "dealer/manageproducts/viewProducts";
        $total_row = $this->manageproducts_model->record_count($uInfo['comp_code']);
        
        $config["total_rows"] = $total_row;
        $config["per_page"] = 6;
        $config['uri_segment'] = 4;
        
       // $config['num_links'] = $config["total_rows"] / $config["per_page"];
        $config['num_links'] = 2; // Number of pagination link
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;

        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';

        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';

        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';

        $this->pagination->initialize($config);
        
        $page_number = $this->uri->segment(4);
        //$page =($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $offset = ($page_number  == NULL) ? 0 : ($page_number * $config['per_page']) - $config['per_page'];
        $data["product"] = $this->manageproducts_model->getAllProduct($config["per_page"], $offset,$uInfo['comp_code']);
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );

	//$this->session->set_flashdata('success_msg', 'Product Added successfuly ! ! !');


		$data['title'] = 'Products | Inventory';
		$data['heading'] = 'View Products';
		$this->load->view('manageProducts/viewProducts', $data);
	}

	public function add_cart()
	{ 
		
		global $uInfo;
		$userId=$uInfo['user_ID'];
		$dealerId=$uInfo['dealer_id'];
	
		/*Added by manoj*/
		/*
			'discount' => 1,
			'tax' => 3,
		*/


		$batchId=$this->input->post('batch_id');
		$skuVal=$this->input->post('product_name');
		$pId=$this->input->post('product_id');
		$productPrice=$this->input->post('product_price');
		$product_name=product_name($pId);

		

		$productData=getSku('product',['product_id'=>$pId]);
		$offerId=$productData[0]['offer_id'];
		$taxId=$productData[0]['product_tax'];
		$gst=$productData[0]['gst_rate'];
		$gstInc = $productData[0]['gst_inc'];

		if($gstInc == 1) {
			$gstRate = $productData[0]['gst_rate'];
		} else {
			$gstRate = '0';
		}

		$offerDetails=getOfferIdByOffer($offerId);
		if(!empty($offerDetails)) {
			$discount = $offerDetails->offer_discount;
		} else {
			$discount = 0;
		}
		$taxDetails=getSku('tax',['tax_id'=>$taxId, 'tax_status'=>1]);
		if(!empty($taxDetails)) {
			$tax = $taxDetails[0]['rate'];
		} else {
			$tax = 0;
		}

			
		$insert_data=[];
		if(isset($skuVal) && !empty($skuVal) && is_array($skuVal)) {
			
			/*$productBatchPrice = getSku('warehouse_inventory',['warehouse_id'=>$centralWarehouse, 'comp_code'=>$compCode, 'master_product_id'=>$pId, 'batch_id'=>$batchId]);

        	if(isset($productBatchPrice) && !empty($productBatchPrice)) {
				$qty = $productBatchPrice[0]['stock_qty'];
				if($productBatchPrice[0]['price'] == 0) {
					$productPrice = $product[0]['product_price'];
				} else {
					$productPrice = $productBatchPrice[0]['price'];
				}
			} else {
				$productPrice = $product[0]['product_price'];
			}*/

			

			foreach($skuVal as $key=>$skuVals) {
				$cartKeyWithBatch = $key.'_'.$batchId;

			$where=['product_id'=>trim($key), 'dealer_id'=>$dealerId, 'batch_id'=>$batchId, 'master_product_id'=>$pId, 'created_by'=>$userId];

			$getDiscount=getSku('dealer_product_price',$where);

			$productPrice = getVariations($key,$pId);
	          if(!empty($productPrice) && isset($productPrice))
	          {
	            $productPrice = $productPrice;
	          }
	          else{
	            $productPrice = $this->input->post('product_price');
	          }
	         // $productPrice = $productPrice[$key];
			
			if(!empty($getDiscount)) {
				$type=$getDiscount[0]['type'];
				$priceType=$getDiscount[0]['price_type'];
				$discount=$getDiscount[0]['price'];
				
				if($priceType==1) {
					$disPrice = (($discount*$productPrice)/100);
					$priceType = '%';
					if($type==1) {
						$disType='Discount';
						$price=$productPrice-$disPrice;
						$discountAmount=$discount.$priceType.'('.$disType.')';
						$originalprice=$productPrice; // Orignial price for discount
					}

					if($type==2) {
						$disType='Extra';
						$price=$productPrice+$disPrice;
						//$discountAmount=$discount.$priceType.'('.$disType.')';
						$discountAmount='';
						$originalprice=$price; // Original price for add extra price in product price
					}
				}

				if($priceType==2) {
					$priceType = 'Fixed';
					if($type==1) {
						$disType='Discount';
						$price=$productPrice-$discount;
						$discountAmount=$discount.'('.$priceType.' '.$disType.')';
						$originalprice=$productPrice; // Orignial price for discount
					}

					if($type==2) {
						$disType='Extra';
						$price=$productPrice+$discount;
						//$discountAmount=$discount.'('.$priceType.' '.$disType.')';
						$discountAmount='';
						$originalprice=$price; // Original price for add extra price in product price
					}
				}
				
			} else {
				$discountAmount='';
				$disType='';
				$price = $productPrice;
				$originalprice = $productPrice;
			}

			//$price = $productPrice*$skuVals;

			$insert_data[] = ['id'=>$key,
							  'name'=>$product_name,
							  'original_price'=>$originalprice,
							  'price'=>round($price, 2),
							  'qty'=>$skuVals,
							  'discount'=>(($discountAmount!='') ? $discountAmount : '-'),
							  'tax'=>$tax,
							  'gst_per'=>$gst,
							  'pId'=>$pId,
							  'gstAmtWithProductAmt'=>round($price, 2),
							  'tax_inc'=>$gstInc
							];
			}


			
		}
		//echo '<pre>';
		//print_r($insert_data);die;
		/*$insert_data = array(
			'id' => $this->input->post('product_id'),
			'name' => $this->input->post('product_name'),
			'price' => $this->input->post('product_price'),
			'qty' => 1,
			'discount' => 1,
			'tax' => 3,
		);*/	
		
        // This function add items into cart.
			$cart_insert = $this->cart->insert($insert_data);
        // This will show insert data in cart.
			//redirect(base_url().'dealer/manageproducts/viewProducts');
			$view_cart_count = count($this->cart->contents());
			
			echo $view_cart_count;
	    
	}


	public function remove($rowid) {
        
		global $uInfo;
		
        // Check rowid value.
		if ($rowid==="all"){
            // Destroy data which store in  session.
			$this->cart->destroy();
		}else{
            // Destroy selected rowid in session.
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
            // Update cart data, after cancle.
			$this->cart->update($data);
		}
		
        // This will show cancle data in cart.
		redirect(base_url().'dealer/manageproducts/viewCart');
	}

	public function update_cart(){
        global $uInfo;        
        // Recieve post values,calcute them and update
        $cart_info =  $_POST['cart'] ;
        //echo '<pre>';
        //print_r($cart_info);die;
 		foreach( $cart_info as $id => $cart)
		{	
            $rowid = $cart['rowid'];
            $price = $cart['price'];
            $amount = $price * $cart['qty'];
            $qty = $cart['qty'];
            
			$data = array(
				'rowid'   => $rowid,
				'price'   => $price,
				'amount' =>  $amount,
				'qty'     => $qty
			);

			
            
			$this->cart->update($data);
		}
		redirect(base_url().'dealer/manageproducts/viewCart');    
	}	

	public function viewCart()
	{
		global $uInfo;
		$data['title'] = 'Products | Inventory';
		$data['heading'] = 'View Cart';
		$this->load->view('manageProducts/viewCart', $data);
	}

	public function checkout()
	{
		global $uInfo;
		$data['creditDealerDetails'] = $this->common->getDealerDetails($uInfo['dealer_id']);
		$data['title'] = 'Products | Inventory';
		$data['heading'] = 'Billing Info';
		$this->load->view('manageProducts/checkout', $data);
	}

	function generateDealerInvoiceNumber(){
		$fyear=$this->config->item('financial_year');
		$uInfo=$this->session->userdata('dealer_session_info');

	}

	public function save_order()
	{
		//echo '<pre>';
		//print_r($_POST);
		//print_r($this->cart->contents());
		//die;
		global $uInfo;
		$country = $uInfo['country'];
		$state = $uInfo['state'];

		$igst_flg=0;
		$igst_amt=0;
		$cgst_amt=0;
		$sgst_amt=0;

        // This will store all values which inserted  from user.
		$dealer_id = $this->input->post('dealer_id');
		$customer = array(
			'dealer_id' => $dealer_id,
			'fname' 	=> $this->input->post('fname'),
			'lname' 	=> $this->input->post('lname'),
			'email' 	=> $this->input->post('email'),
			'city' 		=> $this->input->post('city'),
			'address' 	=> $this->input->post('address'),
			'zipcode' 	=> $this->input->post('zipcode'),
			'mobile_number' => $this->input->post('mobile_number'),
			'create_date' 	=> date('Y-m-d')
		);		
                 // And store user imformation in database.
		$cust_id = $this->manageproducts_model->insert_customer($customer);

		$order = array(
			'date' 			=> date('Y-m-d'),
			'customer_id' 	=> $cust_id,
			'dealer_id'		=> $dealer_id,
			'order_status' => 1, // For Pending
			'comp_code'     => $uInfo['comp_code'],
			'cust_ship_address_notes' =>  $this->input->post('cust_ship_address_notes'),
		);		

		$ord_id = $this->manageproducts_model->insert_order($order);

		$whereDealer = ['dealer_id'=>$dealer_id];
		$getDealerInfo = getSku('dealer',$whereDealer);
		/*$state = $getDealerInfo[0]['state'];*/


		$total_cgst=0;$total_sgst=0;$total_igst=0;
		
		if ($cart = $this->cart->contents()):
			foreach ($cart as $item):

				$order_detail = array(
					'order_id' 		=> $ord_id,
					'product_id' 	=> $item['id'],
					'quantity' 		=> $item['qty'],
					'price' 		=> $item['price'],
					'date'			=> date('Y-m-d'),
					'master_product_id' => $item['pId']
				);


            // Insert product imformation with order detail, store in cart also store in database. 
                
		        $this->manageproducts_model->insert_order_detail($order_detail);

		         // Manage the gst for specific item
		        $itm_igst_amt=0;
				$itm_cgst_amt=0;
				$itm_sgst_amt=0;
				$igp=0;
				$cgp=0;
				$sgp=0;

				if($item['tax_inc'] == 0)
				{
					if($country != 101) {
					$igp=$item['gst_per'];
					$itm_igst_amt=round((($item['subtotal']*$item['gst_per'])/100),2);
					} else {
						$gp=round(($item['gst_per']/2),2);
						$cgp=$gp;
						$sgp=$gp;
						$itm_cgst_amt=round((($item['subtotal']*$gp)/100),2);
						$itm_sgst_amt=round((($item['subtotal']*$gp)/100),2);
					}	
				}
				else{
					if($country != 101) {
					$igp=$item['gst_per'];
					$itm_igst_amt=0;
					} else {
						$gp=round(($item['gst_per']/2),2);
						$cgp=$gp;
						$sgp=$gp;
						$itm_cgst_amt=0;
						$itm_sgst_amt=0;
					}	
				}

				/*if($item['gst_per'] != '') {
					$gp=round(($item['gst_per']/2),2);
					$cgp=$gp;
					$sgp=$gp;
					$itm_cgst_amt=round((($item['price']*$gp)/100),2);
					$itm_sgst_amt=round((($item['price']*$gp)/100),2);
				}*/

				$itemData=['dealer_id'=>$dealer_id,
							'order_id'=>$ord_id,
							'product_ID'=>$item['id'],
							'tax_per'=>$item['gst_per'],
							'gst_inc'=>$item['tax_inc'],
							'gst_flg'=>0,
							'cgst_per' =>$cgp,
							'cgst_amt' =>$itm_cgst_amt,
							'sgst_per' =>$sgp,
							'sgst_amt' =>$itm_sgst_amt,
							'igst_per' =>$igp,
							'igst_amt' =>$itm_igst_amt,
							'master_product_id'=>$item['pId']];

				$insertDealerItem = commonInsert('dealer_item',$itemData);


				$total_cgst += $itm_cgst_amt;
			    $total_sgst += $itm_sgst_amt;
			    $total_igst += $itm_igst_amt;
			endforeach;
		endif;

			/********** dealer_credit_limits (07-Feb-2017) **********/
			$grandTotal = $this->input->post('grandTotal') + $total_cgst + $itm_sgst_amt + $itm_igst_amt;
			$dealerCreditLimits = $this->input->post('dealerCreditLimits');
			$dealer_credit_limits = $dealerCreditLimits - $grandTotal;
			$data = array(
						'dealer_credit_limits' => $dealer_credit_limits
					);
			$this->manageproducts_model->updateCreditAmount('dealer', 'dealer_id', $dealer_id, $data);
			/********** dealer_credit_limits (07-Feb-2017) **********/
			
			/********** dealer account debited with total amount of order  (20-Apr-2017) **********/
			$existing_balance = get_dealer_existing_balance($dealer_id);
			
		 	if($existing_balance!='' && $existing_balance > $grandTotal) {
		 		$total_amt  =  $existing_balance + $grandTotal; 
		 	} 
		 	else if($existing_balance!='' && $existing_balance < $grandTotal) {
		 		$total_amt  =  $existing_balance + $grandTotal; 
		 	}
		 	else if($existing_balance!='' && $existing_balance == $grandTotal) {
		 		$total_amt  =  $existing_balance - $grandTotal; 
		 	}
		 	else {
		 		$total_amt = $grandTotal;
		 	}

			$inv_with_pad= str_pad($ord_id, 8,0,STR_PAD_LEFT);
			
			$fyear=date('Y');
			$uInfo=$this->session->userdata('dealer_session_info');
			$prefix=$this->config->item('dealer_invoice_shortcode');

			$invoiceId = $prefix.'-'.$fyear.'-'.$inv_with_pad;
			
			$DealerAccontData = array(
				'dealer_user_id' => $dealer_id,
				'invoice_id' => $invoiceId,
				'order_id'   => $ord_id,
				'credit' => 0,
				'debit' => $grandTotal,
				'amount' => $grandTotal,
				'comp_code' => $uInfo['comp_code'],
				'total_amount' => $total_amt,
				'created' => date('Y-m-d'),
			);
			
			$this->db->insert('dealer_account', $DealerAccontData);	
			
			/********** dealer account debited with total amount of order  (20-Apr-2017) **********/
			
			
			/********** shipping address save in table (11-Feb-2017) **********/
			$shippingAddress = $this->input->post('shipping_address');
			if(isset($shippingAddress) && !empty($shippingAddress)){
			$shippingData = array(
						'order_id' => $ord_id,
						'dealer_id' => $dealer_id,
						'shipping_address' => $this->input->post('shipping_address'),
						'shipping_city' => $this->input->post('shipping_city'),
						'shipping_state' => $this->input->post('shipping_state'),
						'shipping_country' => $this->input->post('shipping_country'),
						'shipping_zipcode' => $this->input->post('shipping_zipcode'),
						'shipping_mobile_number' => $this->input->post('shipping_mobile_number'),
						'shipping_notes' => $this->input->post('shipping_notes'),
						'ip_address' => $this->input->ip_address(),
						'create_date' => date("Y-m-d h:i:s"),
						'modified_date' => date("Y-m-d h:i:s")
					);
			$this->manageproducts_model->insert_shipping_address($shippingData);
			}
			/********** shipping address save in table (11-Feb-2017) **********/
	        // After storing all information in database load "billing_success".
            $data['title'] = 'Products | Inventory';
			$data['heading'] = 'Billing Success';
			$data['orderInfo'] = $this->manageproducts_model->getOrderInfo($ord_id);
			$this->load->view('manageProducts/billingSuccess', $data);

			// Destroy data which store in  session.
			$this->cart->destroy();
	}

	public function productAddToCart($productId) {
		$data['productId'] = $productId;
		$data['title'] = 'Products | Atrribute';
		$data['heading'] = 'Products Atrribute';
		$this->load->view('manageProducts/productAddToCart', $data);
	}

	public function getProductByFilter() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];

		$productName = $this->input->post('product_name');
		$catId = $this->input->post('category_name');
		$startamt = $this->input->post('product_start_amt');
		$endamt = $this->input->post('product_end_amt');
		//$offset = $this->input->post('offset');
      

        $data["product"] = $this->manageproducts_model->getProductByFilter($compCode, $productName, $catId, $startamt, $endamt);

        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );

	//$this->session->set_flashdata('success_msg', 'Product Added successfuly ! ! !');
        $data['productName'] = $productName != '' ? $productName : '';
        $data['catId'] = $catId != '' ? $catId : '';
        $data['startamt'] = $startamt;
        $data['endamt'] = $endamt;

		$data['title'] = 'Products | Filter';
		$data['heading'] = 'View Products';
		$this->load->view('manageProducts/viewProductsByFilter', $data);
	}




	public function getProductByLoadMore() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];

		$productName = $this->input->post('product_name');
		$catId = $this->input->post('category_name');
		$startamt = $this->input->post('product_start_amt');
		$endamt = $this->input->post('product_end_amt');
		$offset = $this->input->post('offset');

        $data["product"] = $this->manageproducts_model->getProductByFilter($compCode, $productName, $catId, $startamt, $endamt, $offset);

        if(!empty($data["product"])) {
        	$totalProduct = count($data["product"]);
        } else {
        	$totalProduct = 0;
        }

        $data['total_product'] = $totalProduct;

	//$this->session->set_flashdata('success_msg', 'Product Added successfuly ! ! !');
        $data['productName'] = $productName != '' ? $productName : '';
        $data['catId'] = $catId != '' ? $catId : '';
        $data['startamt'] = $startamt;
        $data['endamt'] = $endamt;
        $data['offset'] = $offset;

		$data['title'] = 'Products | Filter';
		$data['heading'] = 'View Products';

		$this->load->view('manageProducts/viewProductsByLoadMore', $data);
	}


}