<div class="breadcrumbs" id="breadcrumbs">
<?php
if(!function_exists('generateBreadcrumb')){
function generateBreadcrumb(){
  $ci = &get_instance();
  $i=1;
  $uri = $ci->uri->segment($i);
  $link = '
  <ul class="breadcrumb">
	<li>
		<i class="icon-home home-icon"></i>';
 
  while($uri != ''){
    $prep_link = '';
	
  for($j=1; $j<=$i;$j++){
    $prep_link .= $ci->uri->segment($j).'/';
  }
 
  if($ci->uri->segment($i)=='webadmin')
  {
	  $breadcrumb_text = 'Home';
	  
  }
  else{
		if(!is_numeric($ci->uri->segment($i))){
	  $breadcrumb_text = $ci->uri->segment($i);
  }
  }
  
  if($ci->uri->segment($i+1) == '' or is_numeric($ci->uri->segment($i+1))){
    //if(!is_numeric($ci->uri->segment($i))){
	$link.='<li class="active">';
    $link.=ucfirst($breadcrumb_text).'</li> ';
	//}
  }else{
	  if(!is_numeric($ci->uri->segment($i))){
    $link.='<li>';
    $link.=ucfirst($breadcrumb_text).'<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span></li> ';}
  }
 
  $i++;
  $uri = $ci->uri->segment($i);
  if(is_numeric($ci->uri->segment($i))){break;}
  }
    $link .= '</li></ul>';
    return $link;
  }
}
 
 
 echo generateBreadcrumb();
?>
</div>