<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


///source
//https://github.com/EllisLab/CodeIgniter/wiki/helper-dropdown-country-code

if( ! function_exists('country_dropdown')){
	//selected country would be retrieved from a database or as post data
function  country_dropdown($name, $id, $class, $selected_country,$top_countries=array(), $all, $selection=NULL, $show_all=TRUE ){
	// You may want to pull this from an array within the helper
	$countries = config_item('country_list');

	$html = "<select name='{$name}' id='{$id}' class='{$class}'>";
	$selected = NULL;
	if(in_array($selection,$top_countries)){
		$top_selection = $selection;
		$all_selection = NULL;
	}else{
		$top_selection = NULL;
		$all_selection = $selection;
	}
	if(!empty($selected_country)&&$selected_country!='all'&&$selected_country!='select'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='{$selected_country}'{$selected}>{$countries[$selected_country]}</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}else if($selected_country=='all'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='all'>All</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}else if($selected_country=='select'){
		$html .= "<optgroup label='Selected Country'>";
		if($selected_country === $top_selection){
			$selected = "SELECTED";
		}
		$html .= "<option value='select'>Select</option>";
		$selected = NULL;
		$html .= "</optgroup>";
	}
	if(!empty($all)&&$all=='all'&&$selected_country!='all'){
		$html .= "<option value='all'>All</option>";
		$selected = NULL;
	}
	if(!empty($all)&&$all=='select'&&$selected_country!='select'){
		$html .= "<option value='select'>Select</option>";
		$selected = NULL;
	}
	
	if(!empty($top_countries)){
		$html .= "<optgroup label='Top Countries'>";
		foreach($top_countries as $value){
			if(array_key_exists($value, $countries)){
				if($value === $top_selection){
					$selected = "SELECTED";
				}
			$html .= "<option value='{$value}'{$selected}>{$countries[$value]}</option>";
			$selected = NULL;
			}
		}
		$html .= "</optgroup>";
	}

	if($show_all){
		$html .= "<optgroup label='All Countries'>";
		foreach($countries as $key => $country){
			if($key === $all_selection){
				$selected = "SELECTED";
			}
			$html .= "<option value='{$key}'{$selected}>{$country}</option>";
			$selected = NULL;
		}
		$html .= "</optgroup>";
	}
	
	$html .= "</select>";
	return $html;
    }
}

if( ! function_exists('getYearcombo')){
function getYearcombo($yearselected){
		$year = '<select name="qry_year" id="qry_year" style="width:150px;">'; 
		$time = time();
		$current_year = date("Y", $time);
		
		for($i = $current_year-5; $i <= ($current_year+5); $i++){
			if($i == $yearselected){
				$year .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			}else{
				$year .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$year .= '</select>';
		return $year;
	}
}

if( ! function_exists('getMonthcombo')){	
function getMonthcombo($selectedMonth=''){
$monthNames = array(1=>"January" ,  2=>"February",3=>"March" , 4=>"April", 5=>"May", 6=>"June", 7=>"July" , 8=>"August", 9=>"September", 10 =>"October", 11=>"November", 12=>"December");

		$monthcombo = '<select name="qry_month" id="qry_month" style="width:150px;">';
		
		foreach($monthNames as $key => $month){ 
			if($key == $selectedMonth)
				$monthcombo .='<option value="'.$key.'" selected="selected">'.$month.'</option>';
			else
				$monthcombo .='<option value="'.$key.'">'.$month.'</option>';
		}
		$monthcombo .= '</select>';
		return $monthcombo;
	}
}

if( ! function_exists('getdaysName')){	
function getdaysName(){	
			$html = '';
		for($i=0; $i<5; $i++){
			$html .= '<th align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>Su</strong></th>
					  <th align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Mo</strong></th>
					  <th align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Tu</strong></th>
					  <th align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>We</strong></th>
					  <th align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Th</strong></th>
					  <th align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Fr</strong></th>
					  <th align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>Sa</strong></th>';
		}
		
			$html .= '<th align="center" bgcolor="#ffbc5b" style="color:#040404"><strong>Su</strong></th>
					  <th align="center" bgcolor="#cfcfcf" style="color:#040404"><strong>Mo</strong></th>';   
		return $html;
	}
}
if( ! function_exists('genAvailRowByRoomtype')){	
function genAvailRowByRoomtype($monthNames,$year,$roomtype){	
			$html = '';
			if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date('Y');
$time = time();
$today         = date("Y/n/j", $time);
$current_month = date("n", $time);
$current_year  = date("Y", $time);
$cMonth        = 1;
$cYear         = $year;
$month=$monthNames;
			//foreach($monthNames as $key => $month){ 
				$timestamp = mktime(0, 0, 0, $month, 1, $cYear);
				$maxday    = date("t",$timestamp);
				$thismonth = getdate ($timestamp);
				$startday  = $thismonth['wday'];
				$no_of_td  = $maxday+$startday;
				//YYYY-MM-DD date format
				$date_form = "$cYear-$month-";
				$trColor = 'background-color:#F2F2F2;';
				
				$CI =& get_instance();
				$CI->load->model('booking');
				$tot_rooms=$CI->booking->getRoomCountByRoomtype($roomtype);
				
				echo '<tr style="height:25px;font-size:8px; '.$trColor.'">'; 
				for ($i=0; $i<($maxday+$startday); $i++) {
					if($i<$startday){
						$dt=$date_form."0";
					}else{
						$dt=$date_form.($i - $startday + 1);
					}
					
					$bookroom=$CI->booking->getBookedRoomsCountByRoomtype($dt,$roomtype);
				  
								   					
					if($i < $startday){ 
						echo "<td></td>"; 
					}else{
						if($bookroom>0){
							$noOfRoom = $tot_rooms - $bookroom;
						}else{																					
								$noOfRoom = $tot_rooms;							
							
						}
						
						//if($no_of_room){
							$color = '#bffcc1';
							$font_color="#000000";
						//}if($no_of_room==$bookroom){
							$color = '#f3747f';
							$font_color="#000000";
						//}
												
						if($i == 0 || $i == 6 || $i == 7 || $i == 13 || $i == 14 || $i == 20 || $i == 21 || $i == 27 || $i == 28 || $i == 34 || $i == 35){							
							if($time > strtotime($date_form.($i - $startday + 1))){
								if($today == $date_form.($i - $startday + 1)){
									$color = '#36a4ed';
									$font_color="#ffffff";
								}else{
									$color = '#f2f2f2';
									$font_color="#cccaca";
								}
									
							}
																					
							echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";' valign='middle' >".$noOfRoom."</td>";
								
						}else{
							if($time > strtotime($date_form.($i - $startday + 1))){
								
								if($today == $date_form.($i - $startday + 1)){
									$color = '#36a4ed';
									$font_color="#000000";
								}else{
									$color = '#f2f2f2';
									$font_color="#ababac";
								}
							}
							
							echo "<td align='center' valign='middle' >". $noOfRoom."</td>";
						}
					}
				}
				for($td=$no_of_td; $td<38-1; $td++){  
					echo "<td></td>"; 
				}
				 echo "</tr> <tr><td colspan=\"37\"><hr></td></tr>"; 
			//}
		//return $html;
	}
}
if( ! function_exists('getSingleRoomAvailStatusByDate')){	
function getSingleRoomAvailStatusByDate($monthNames,$year,$roomID){	
			$html = '';
			if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date('Y');
$time = time();
$today         = date("Y/n/j", $time);
$current_month = date("n", $time);
$current_year  = date("Y", $time);
$cMonth        = 1;
$cYear= $year;
$month=$monthNames;

			//foreach($monthNames as $key => $month){ 
				$timestamp = mktime(0, 0, 0, $month, 1, $cYear);
				$maxday    = date("t",$timestamp);
				$thismonth = getdate ($timestamp);
				$startday  = $thismonth['wday'];
				$no_of_td  = $maxday+$startday;
				//YYYY-MM-DD date format
				$date_form = "$cYear-$month-";
				$trColor = 'background-color:#F2F2F2;';
				
				
				
				echo '<tr style="height:25px;font-size:8px; '.$trColor.'">'; 
				for ($i=0; $i<($maxday+$startday); $i++) {
					$CI =& get_instance();
					$CI->load->model('booking');
					$roomInfo=$CI->booking->getRoomInfoById($roomID);
					$room_num=ucwords($roomInfo->room_name);
					$room_type=ucwords($roomInfo->room_type);
					$room_type_id=$roomInfo->roomtype_id;
					
					if($i<$startday){
						$dt=$date_form."0";
					}else{
						$dt=$date_form.($i - $startday + 1);
						$room_address="R-$room_type_id-$roomID-$dt";
					}
					
					
					$bookroom=$CI->booking->checkRoomAvailByDate($dt,$roomID);

					if($i < $startday){ 
						echo '<td style="border:1px solid #ccc;"></td>'; 
					}else{
						if(isset($bookroom) && !empty($bookroom)){
							$avail_state ='B';
							$bdata=$CI->booking->getBookingDetails($bookroom->reservation_ID);
							//var_dump($bdata);
						}else{																					
								$avail_state ='A';							
							
						}
						
						//if($no_of_room){
							$color = '#bffcc1';
							$font_color="#000000";
						//}if($no_of_room==$bookroom){
							$color = '#f3747f';
							$font_color="#000000";
						//}
												
						if($i == 0 || $i == 6 || $i == 7 || $i == 13 || $i == 14 || $i == 20 || $i == 21 || $i == 27 || $i == 28 || $i == 34 || $i == 35){							
							if($time > strtotime($date_form.($i - $startday + 1))){
								if($today == $date_form.($i - $startday + 1)){
									$color = '#36a4ed';
									$font_color="#ffffff";
								}else{
									$color = '#f2f2f2';
									$font_color="#cccaca";
								}
									
							}
							
							if(isset($bookroom) && !empty($bookroom)){
							
							//var_dump($bdata);
							echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";border:1px solid #ccc;' valign='middle' class='free' data-content='".$bdata->name."' data-placement='top' data-trigger='hover' data-rel='popover'  data-original-title='Booked: ".$bdata->start_date." to ".$bdata->end_date."' date='".$dt."' id='$room_address'>x</td>";
						}else{																					
													
							echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";border:1px solid #ccc;' valign='middle' date='".$dt."' id='$room_address' class='avail' room-title='$room_type ($room_num)'></td>";
						}	
																				
							//echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";' valign='middle' >".$avail_state."</td>";
								
						}else{
							if($time > strtotime($date_form.($i - $startday + 1))){
								
								if($today == $date_form.($i - $startday + 1)){
									$color = '#36a4ed';
									$font_color="#000000";
								}else{
									$color = '#f2f2f2';
									$font_color="#ababac";
								}
							}
							
							if(isset($bookroom) && !empty($bookroom)){
							echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";border:1px solid #ccc;' valign='middle' class='free' data-content='".$bdata->name."' data-placement='top' data-trigger='hover' data-rel='popover'  data-original-title='Booked: ".$bdata->start_date." to ".$bdata->end_date."' date='".$dt."' id='$room_address'>x</td>";
						}else{																					
													
							echo "<td style='border:1px solid #ccc;' align='center' valign='middle' date='".$dt."' id='$room_address' class='avail' room-title='$room_type ($room_num)' ></td>";
						}	
							//echo "<td align='center' valign='middle' >".$avail_state."</td>";
						}
					}
				}
				for($td=$no_of_td; $td<38-1; $td++){  
					echo "<td></td>"; 
				}
				 echo "</tr> <tr><td colspan=\"37\"><hr></td></tr>"; 
			//}
		//return $html;
	}
}



if( ! function_exists('getMonthDate')){	
function getMonthDate($monthNames,$year){	
			$html = '';
			if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date('Y');
$time = time();
$today         = date("Y/n/j", $time);
$current_month = date("n", $time);
$current_year  = date("Y", $time);
$cMonth        = 1;
$cYear         = $year;
$month=$monthNames;
			//foreach($monthNames as $key => $month){ 
				$timestamp = mktime(0, 0, 0, $month, 1, $cYear);
				$maxday    = date("t",$timestamp);
				$thismonth = getdate ($timestamp);
				$startday  = $thismonth['wday'];
				$no_of_td  = $maxday+$startday;
				//YYYY-MM-DD date format
				$date_form = "$cYear-$month-";
				
				if(isset($_POST['submit'])){
					if(isset($_POST['capacity_id']) && $_POST['capacity_id'] != 0){
						$sql = 'where roomtype_id='.$_POST['roomtype'].' and capacity_id='.$_POST['capacity_id'];
					}else{
						$sql = 'where roomtype_id='.$_POST['roomtype'];
					}
				}else{
					$sql = '';
				}
				//$row = mysql_fetch_assoc(mysql_query("SELECT count(*) AS no_of_room FROM `bsi_room` ".$sql));
				//$no_of_room = $row['no_of_room'];
				if($current_month == $month && $current_year == $cYear){
					//$trColor = 'background-color:#ffdf80;';
					$trColor = 'background-color:#F2F2F2;';
				}else{
					/*if($month % 2 == 0){
						$trColor = 'background-color:#F2F2F2;';
					}else{
						$trColor = 'background-color:#FFFFFF;';
					}*/
					$trColor = 'background-color:#F2F2F2;';
				}
				
				echo '<tr style="height:25px;font-size:8px; '.$trColor.'">'; 
				for ($i=0; $i<($maxday+$startday); $i++) {
					if($i<$startday){
						$dt=$date_form."0";
					}else{
						$dt=$date_form.($i - $startday + 1);
					}
					$bookroom=0;
				  
								   					
					if($i < $startday){ 
						echo "<th></th>"; 
					}else{
						/*if($bookroom>0){
							$noOfRoom = $no_of_room - $bookroom;
						}else{																					
								$noOfRoom = $no_of_room;							
							
						}*/
						
						//if($no_of_room){
							$color = '#bffcc1';
							$font_color="#000000";
						//}if($no_of_room==$bookroom){
							$color = '#f3747f';
							$font_color="#000000";
						//}
												
						if($i == 0 || $i == 6 || $i == 7 || $i == 13 || $i == 14 || $i == 20 || $i == 21 || $i == 27 || $i == 28 || $i == 34 || $i == 35){							
							if($time > strtotime($date_form.($i - $startday + 1))){
								if($today == $date_form.($i - $startday + 1)){
									$color = '#36a4ed';
									$font_color="#ffffff";
								}else{
									$color = '#f2f2f2';
									$font_color="#cccaca";
								}
									
							}
																					
							echo "<th align='center' bgcolor='#ffbc5b' style='color:".$font_color.";' valign='middle' >".($i - $startday + 1)."</th>";
								
						}else{
							if($time > strtotime($date_form.($i - $startday + 1))){
								
								if($today == $date_form.($i - $startday + 1)){
									$color = '#36a4ed';
									$font_color="#000000";
								}else{
									$color = '#f2f2f2';
									$font_color="#ababac";
								}
							}
							
							echo "<th align='center' valign='middle' >". ($i - $startday + 1) ."</th>";
						}
					}
				}
				for($td=$no_of_td; $td<38-1; $td++){  
					echo "<th></th>"; 
				}
				 echo "</tr> <tr><th colspan=\"37\"><hr></th></tr>"; 
		//	}
		//return $html;
	}
}

if( ! function_exists('getRoomtypeCapacityPriceInput')){	
function getRoomtypeCapacityPriceInput($monthNames,$year,$capType,$cap,$roomType,$ratetype){
	
			$html = '';
			if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date('Y');
$time = time();
$today         = date("Y/n/j", $time);
$current_month = date("n", $time);
$current_year  = date("Y", $time);
$cMonth        = 1;
$cYear         = $year;
$month=$monthNames;

			//foreach($monthNames as $key => $month){ 
				$timestamp = mktime(0, 0, 0, $month, 1, $cYear);
				$maxday    = date("t",$timestamp);
				$thismonth = getdate ($timestamp);
				$startday  = $thismonth['wday'];
				$no_of_td  = $maxday+$startday;
				//YYYY-MM-DD date format
				$date_form = "$cYear-$month-";
				$trColor = 'background-color:#F2F2F2;';
				
				$CI =& get_instance();
				$CI->load->database();
				$uInfo=$CI->session->userdata('hoteladmin_session_info');
				
				echo '<tr style="height:25px;font-size:8px; '.$trColor.'">'; 
				for ($i=0; $i<($maxday+$startday); $i++) {
					if($i<$startday){
						$dt=$date_form."0";
					}else{
						$dt=$date_form.($i - $startday + 1);
						$arrCtr=$i - $startday + 1;
					}
					
					//$bookroom=$CI->booking->getBookedRoomsCountByRoomtype($dt,$roomtype);
				  
								   					
					if($i < $startday){ 
						echo "<td></td>"; 
					}else{
						/*if($bookroom>0){
							$noOfRoom = $tot_rooms - $bookroom;
						}else{																					
								$noOfRoom = $tot_rooms;							
							
						}*/
						
						//if($no_of_room){
							$color = '#bffcc1';
							$font_color="#000000";
						//}if($no_of_room==$bookroom){
							$color = '#f3747f';
							$font_color="#000000";
						//}
												
						if($i == 0 || $i == 6 || $i == 7 || $i == 13 || $i == 14 || $i == 20 || $i == 21 || $i == 27 || $i == 28 || $i == 34 || $i == 35){							
							if($time > strtotime($date_form.($i - $startday + 1))){
								if($today == $date_form.($i - $startday + 1)){
									$color = '#36a4ed';
									$font_color="#ffffff";
								}else{
									$color = '#f2f2f2';
									$font_color="#cccaca";
								}
									
							}
							
							if($capType=="A"){
								
								
								$res = $CI->db->select("price")->get_where('room_priceplan_master', array('roomtype_id' => $roomType,'capacity_type' =>$capType,'capacity' => $cap,'hotel_id' => $uInfo['hotel_id'],'default_plan' =>1,'rate_type'=>$ratetype,'price_date'=>$dt))->row();	
								if(isset($res) && !empty($res)){
									echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";' valign='middle' ><input type='text' id='zip' name='adult_price[".$cap."][".$arrCtr."]' class='pricebox' value='".$res->price."'></td>";
								}
								else{
									echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";' valign='middle' ><input type='text' id='zip' name='adult_price[".$cap."][".$arrCtr."]' class='pricebox'></td>";
								}
																					
							
							}
							if($capType=="C"){
								$res = $CI->db->select("price")->get_where('room_priceplan_master', array('roomtype_id' => $roomType,'capacity_type' =>$capType,'capacity' => $cap,'hotel_id' => $uInfo['hotel_id'],'default_plan' =>1,'rate_type'=>$ratetype,'price_date'=>$dt))->row();
								
								if(isset($res) && !empty($res)){
									echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";' valign='middle' ><input type='text' id='zip' name='child_price[".$cap."][".$arrCtr."]' class='pricebox'  value='".$res->price."'></td>";
								}
								else{
									echo "<td align='center' bgcolor='#ffbc5b' style='color:".$font_color.";' valign='middle' ><input type='text' id='zip' name='child_price[".$cap."][".$arrCtr."]' class='pricebox'></td>";
								}
																						
							
							}
								
						}else{
							if($time > strtotime($date_form.($i - $startday + 1))){
								
								if($today == $date_form.($i - $startday + 1)){
									$color = '#36a4ed';
									$font_color="#000000";
								}else{
									$color = '#f2f2f2';
									$font_color="#ababac";
								}
							}
							if($capType=="A"){
								
								
								$res = $CI->db->select("price")->get_where('room_priceplan_master', array('roomtype_id' => $roomType,'capacity_type' =>$capType,'capacity' => $cap,'hotel_id' => $uInfo['hotel_id'],'default_plan' =>1,'rate_type'=>$ratetype,'price_date'=>$dt))->row();
								if(isset($res) && !empty($res)){
									echo "<td align='center'  valign='middle' ><input type='text' id='zip' name='adult_price[".$cap."][".$arrCtr."]' class='pricebox' value='".$res->price."'></td>";
								}
								else{
									echo "<td align='center'  valign='middle' ><input type='text' id='zip' name='adult_price[".$cap."][".$arrCtr."]' class='pricebox'></td>";
								}
																					
							
							}
							if($capType=="C"){
								$res = $CI->db->select("price")->get_where('room_priceplan_master', array('roomtype_id' => $roomType,'capacity_type' =>$capType,'capacity' => $cap,'hotel_id' => $uInfo['hotel_id'],'default_plan' =>1,'rate_type'=>$ratetype,'price_date'=>$dt))->row();
								if(isset($res) && !empty($res)){
									echo "<td align='center'  valign='middle' ><input type='text' id='zip' name='child_price[".$cap."][".$arrCtr."]' class='pricebox'  value='".$res->price."'></td>";
								}
								else{
									echo "<td align='center' valign='middle' ><input type='text' id='zip' name='child_price[".$cap."][".$arrCtr."]' class='pricebox'></td>";
								}
																						
							
							}
						}
					}
				}
				for($td=$no_of_td; $td<38-1; $td++){  
					echo "<td></td>"; 
				}
				 echo "</tr> <tr><td colspan=\"37\"><hr></td></tr>"; 
			//}
		//return $html;
	
}
}

if(!function_exists('getDateRangeArray')){
	function getDateRangeArray($startDate, $endDate, $nightAdjustment = true) {	
		$date_arr = array(); 
		$day_array=array(); 
		$total_array=array();
	     $time_from = mktime(1,0,0,substr($startDate,5,2), substr($startDate,8,2),substr($startDate,0,4));
		 $time_to = mktime(1,0,0,substr($endDate,5,2), substr($endDate,8,2),substr($endDate,0,4));		
		if ($time_to >= $time_from) { 
			if($nightAdjustment){
				while ($time_from < $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, date('D',$time_from));
					$time_from+= 86400; // add 24 hours
				}
			}else{
				while($time_from <= $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, $time_from);
					$time_from+= 86400; // add 24 hours
				}
			}			
		}  
		array_push($total_array, $date_arr);
		array_push($total_array, $day_array);
		return $total_array;		
	}
}

if(!function_exists('getRoomsCountInCartByType')){
	function getRoomsCountInCartByType($roomtypeID) {
		$CI =& get_instance();
		$CI->load->library('cart');	
		$ctr=0;
		foreach($CI->cart->contents() as $k=>$v){
			if($roomtypeID==$v['room_type']){
				$ctr+=$v['numOfRooms'];
			}
			
		}
		return $ctr;
	
	}
}

if(!function_exists('getRoomTypeInCart')){
	function getRoomTypeInCart() {
		$CI =& get_instance();
		$CI->load->library('cart');	
		$room_type_arr=array();
		
		foreach($CI->cart->contents() as $k=>$v){
			if(!in_array($v['room_type'],$room_type_arr)){
				$room_type_arr[]=$v['room_type'];
			}
		}
		return $room_type_arr;
	
	}
}

if(!function_exists('currency_symbol')){
	function currency_symbol() {
		return "$";
	}
}

if(!function_exists('currency_code')){
	function currency_code() {
		return "USD";
	}
}