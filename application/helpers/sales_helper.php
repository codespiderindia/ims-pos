<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('getIndianCurrency')){
    function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '').$paise ;
}
}


/*https://stackoverflow.com/questions/25967530/convert-number-to-words-in-indian-currency-format-with-paise-value*/

if(!function_exists('getStateNameByID')){
    function getStateNameByID($sID){
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->select('name');
        $CI->db->from('states');
        $CI->db->where('id',$sID);
         $query = $CI->db->get();
            if($query->num_rows() > 0)
                return $query->row()->name;
            else
                return FALSE;

    }

}

if(!function_exists('getUserFullNameByID')){
    function getUserFullNameByID($uID){
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->select('user_full_name');
        $CI->db->from('user_master');
        $CI->db->where('user_ID',$uID);
         $query = $CI->db->get();
            if($query->num_rows() > 0)
                return $query->row()->user_full_name;
            else
                return FALSE;

    }

}

if(!function_exists('generateRandomString')){
    function generateRandomString($length = 10) {
       // $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}




?>