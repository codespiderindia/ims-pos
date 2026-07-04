<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style type="text/css">
   .category_cls {
      float: left;
   }
   .newcategory {
      width: 150px;
      float: left;
      text-align: center;
      color: #438EB9;
   }
</style>
         <!--PAGE CONTENT BEGINS-->
         
               <label class="control-label" for="product_name">Attribute</label>
               <div class="controls productMenu">
                  <?php $attributs = getAttributesByCompCode($uinfo['comp_code']);?>
                  <ul>
                     <?php 
                        if(isset($productAttrInfo) && !empty($productAttrInfo)){
                  $count_productAttrInfo = count($productAttrInfo);
                        $attr_ids_array = array();
                        foreach($productAttrInfo as $vals) {
                        
                        array_push($attr_ids_array,$vals['attribute_id']);
                        }
                       
                  
                        $attribute_id_val_array =  json_decode($productAttrInfo[0]['json_attribute_value']);
                        echo '<pre>';
                        print_r($attribute_id_val_array);
                        echo $attribute_id_val_array->$attr_id.'<br>';
                  }
                  
                        foreach($attributs as $attributs){
                        
                        ?>
                     <li id="attribute_enter_<?php echo $attributs['attribute_id']; ?>">
                        <input type="checkbox" class="attribute_id" id="attribute_id_<?php echo $attributs['attribute_id']; ?>" name="attribute_id" value="<?php echo $attributs['attribute_id']?>" <?php 
                           if(isset($attr_ids_array) && !empty($attr_ids_array)){
                     if( in_array( $attributs['attribute_id'],$attr_ids_array)) {
                           echo "checked"; 
                           
                           }
                  }
                     ?>  
                           />
                        <span class="lbl labelname__<?php echo $attributs['attribute_id']; ?>"><?php echo $attributs['attribute_name']?></span>
                        <div style="<?php 
                  
                  if( isset($attr_ids_array) && !empty($attr_ids_array) && in_array( $attributs['attribute_id'],$attr_ids_array)) {  echo "display:block";  } else { echo "display:none"; } 
                  ?>"  id="attribute_add_div_<?php echo $attributs['attribute_id'];?>">
                           <select id="text_<?php echo $attributs['attribute_id']; ?>" class="multipleSelect" multiple name="attr_value[<?php echo $attributs['attribute_id']; ?>][]">
                              <?php 
                                 $get_attribute_values = get_attribute_values($attributs['attribute_id']);
                                 $attr_id = $attributs['attribute_id'];
                                 echo '<pre>';
                                 print_r($get_attribute_values);
                                 foreach($get_attribute_values as $attributes){
                         
                         if(isset($attribute_id_val_array) && !empty($attribute_id_val_array) && in_array( $attributes['attribute_value_id'],$attribute_id_val_array->$attr_id)) {
                         ?>
                              <option selected label="<?php echo $attributes['attribute_value'];?>" value="<?php echo $attributes['attribute_value_id'];?>"><?php echo $attributes['attribute_value'];?></option>
                              <?php }
                       else{
                       ?>
                       <option label="<?php echo $attributes['attribute_value'];?>" value="<?php echo $attributes['attribute_value_id'];?>"><?php echo $attributes['attribute_value'];?></option>
                       <?php }
                       }
                       ?>
                           </select>
                           <button type="button" id="<?php echo $attributs['attribute_id']; ?>" class="addnew btn btn-info buttonThemeColor">Add new</button>
                           <span id="error_<?php echo $attributs['attribute_id']; ?>" for="attr_value" class="product_help-inline attribute_value"> <?php //echo form_error('attr_value') ?> </span>
                        </div>
                     </li>
                     <?php 
                        }?>
                  </ul>
                  <span for="attr_value" class="product_help-inline attribute_value"> <?php //echo form_error('attr_value') ?> </span>
               </div>
         <!--PAGE CONTENT ENDS-->
      
<!--multiselect scripts related to this page-->
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css"
   rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js"
   type="text/javascript"></script>
<script type="text/javascript">
   $('#add_tax').multiselect({
   		includeSelectAllOption: true
   	});
</script>
<!--multiselect scripts related to this page-->
<!--multiselect scripts related to this page-->
<!--autocomplete scripts related to this page-->
<script src="<?php echo base_url();?>/assets/js/fastselect.standalone.js"></script>
<script>
   $('.multipleSelect').fastselect();
</script>
<!--autocomplete scripts related to this page-->
<script>
   $(document).ready(function(){
   
   	$( ".attribute_id" ).on('click',function() { 
   	  var h3_id = $(this).attr("id").split('attribute_id_');
   	  //alert(h3_id[1]);
   	  $( "#attribute_add_div_"+h3_id[1] ).toggle();
   	  $( "#error_"+h3_id[1] ).empty();
   	});
   	
   	function uniqId() {
   	  return Math.round(new Date().getTime() + (Math.random() * 100));
   	}
   	
   	$( ".addnew" ).click(function() {
   		var attrValue = prompt("Enter a name for the new attribute value:", "");
   		
   		var attr_id = $(this).attr("id");
   		if (attrValue != null && attrValue.length>0) {
   			//$("#text_"+attr_id).val(person);
   			var url="<?php echo site_url();?>webadmin/manageproduct/addAttrValue";
   				$.ajax({
   				url: url,
   				type:'POST',
   				data:"attribute_value="+attrValue+"&attribute_id="+attr_id+"&prodcut_id="+uniqId(),
   				success: function(data){
   				
   					//alert(data);
   					
   					$('#attribute_add_div_'+attr_id).html(data); 
   				}
   				});
   				
   		}
   		else{
   			alert("Please enter value");
   		}
   	});
   });
   
</script>
</body>
</html>