<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managesales_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
	}

 	

  
 
	function get_search_suggestions($search, $filters = array('is_deleted' => FALSE, 'search_custom' => FALSE), $unique = FALSE, $limit = 25)
	{
		$suggestions = array();

		$this->db->select('product_id, product_name, product_barcode_text');
		$this->db->from('product');
		$this->db->like('product_name', $search);
		$this->db->or_like('product_barcode_text', $search);
		$this->db->order_by('product_name', 'asc');
		foreach($this->db->get()->result() as $row)
		{
			$prd_name=$row->product_barcode_text." (".$row->product_name.")";
			$suggestions[] = array('value' => $row->product_id, 'label' => $prd_name);
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}

		return $suggestions;
	}

	function getItemInfoByID($itmID){
		$this->db->select("product_id,product_name,product_tax,product_price,gst_rate");
		$this->db->from('product');
		$this->db->where('product_id',$itmID);
		$this->db->or_where('product_barcode_text',(int) $itmID);

		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}

	function getItemDiscount($frmDB=true, $disc){

	}	

	function getItemTax($frmDB=true, $disc){


	}

	// Add Function -Start
	public function add_item(&$item_id, $quantity = 1, $item_location, $discount = 0, $price = NULL, $description = NULL, $serialnumber = NULL, $include_deleted = FALSE, $print_option = '0', $stock_type = '0')
	{
		$item_info = $this->getItemInfoByID($item_id);

	

		$item_id = $item_info->product_id;

		

		

		if(is_null($price))
		{
			$price = $item_info->unit_price;
		}
		elseif($price == 0)
		{
			$price = 0.00;
			$discount = 0.00;
		}

	

		$total = $this->get_item_total($quantity, $price, $discount);
		$discounted_total = $this->get_item_total($quantity, $price, $discount, TRUE);
		//Item already exists and is not serialized, add to quantity
		
		/*
		if(!$itemalreadyinsale || $item_info->is_serialized)
		{
			$item = array($insertkey => array(
					'item_id' => $item_id,
					'item_location' => $item_location,
					'stock_name' => $this->CI->Stock_location->get_location_name($item_location),
					'line' => $insertkey,
					'name' => $item_info->name,
					'item_number' => $item_info->item_number,
					'description' => $description != NULL ? $description : $item_info->description,
					'serialnumber' => $serialnumber != NULL ? $serialnumber : '',
					'allow_alt_description' => $item_info->allow_alt_description,
					'is_serialized' => $item_info->is_serialized,
					'quantity' => $quantity,
					'discount' => $discount,
					'in_stock' => $this->CI->Item_quantity->get_item_quantity($item_id, $item_location)->quantity,
					'price' => $price,
					'total' => $total,
					'discounted_total' => $discounted_total,
					'print_option' => $print_option,
					'stock_type' => $stock_type,
					'tax_category_id' => $item_info->tax_category_id
				)
			);
			//add to existing array
			$items += $item;
		}
		else
		{
			$line = &$items[$updatekey];
			$line['quantity'] = $quantity;
			$line['total'] = $total;
			$line['discounted_total'] = $discounted_total;
		}

		$this->set_cart($items);
*/
		return TRUE;
	}
	//Add Function - End

	/*public function get_item_total($quantity, $price, $discount_percentage, $include_discount = FALSE)  
	{
		$total = $quantity * $price;
		if($include_discount)
		{
			$discount_amount = $this->get_item_discount($quantity, $price, $discount_percentage);

			$item_disc_diff=$total - $discount_amount;
			return $item_disc_diff;
		}

		return $total;
	}
	
	public function get_item_discount($quantity, $price, $discount_percentage)
	{
		$total = $quantity * $price;
		$discount_fraction = $discount_percentage/100;
		$disc=$total * $discount_fraction;
		return $disc;
	}
*/
  	
}
