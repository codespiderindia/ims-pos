<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('sendMail')){
	function sendMail($from, $to, $subject, $message, $successMsg, $errorMsg){
		$ci =& get_instance();
		$ci->email->from($from);
		$ci->email->to($to);
		$ci->email->subject($subject);
		$ci->email->message($message);
		if($ci->email->send()){
			$msg = $ci->session->set_flashdata('success_mail', $successMsg);
		}else{
			//$show_error = show_error($this->email->print_debugger());
			$msg = $ci->session->set_flashdata('error_mail', $errorMsg);
		}	
		return $msg;
	}
}