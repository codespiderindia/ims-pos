<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style>
.wrapper{
    width:700px;
    margin:50px auto;
    font-family:Arial, Helvetica, sans-serif;
    font-size:14px;
}
p{
    margin:3px;
}
#store-table {
  font-size: 12px 
}
#store-table th, #store-table td{
  border:1px solid #333; 
  padding:5px;
}
.pdf-logo{
  text-align: center;
}
</style>
</head>
<body>  
        <div class="wrapper">

           <div class="pdf-logo">
            <?php $getCompImg = getCompanyDetail($comp_code, 'comp_image');
             $compImg = $getCompImg[0]->comp_image;
              $image = 'file://'.$_SERVER['DOCUMENT_ROOT'].'/inventory/uploads/company_image/'.$compImg;
             ?>

            <img src="<?php echo $image; ?>" width="50" />
          </div>
          
        <div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y'); ?></div>       
        <div style="text-align:center; font-weight:bold; text-transform:uppercase;">Product Report</div>
        
        <div>
            <table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;"> 
                  <thead>
                     <tr style="font-weight:bold; border-bottom:1px solid #ccc;">
                        <th class="center">#</th>
                        <th style="padding:5px;">Product Name</th>
                        <th style="padding:5px;">Category</th>
                        <th style="padding:5px;">Sub Category</th>
                        <th style="padding:5px;">Sub of Sub Category</th>
                        <th style="padding:5px;">Attributes</th>
                        <th style="padding:5px;">Product Price</th>
                        <th style="padding:5px;">Product Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($allProduct)) {
                      $cnt3=1;
           foreach($allProduct as $allProducts) { ?>
            <tr>
                <td><?php echo $cnt3; ?></td>  
                <td class=""><?php echo $allProducts->product_name; ?></td>
                <td><?php 
                    $productCategory = getParentCategory($allProducts->product_category);
                     if(isset($productCategory) && !empty($productCategory)){
                        echo $productCategory->cat_name;
                     }
                ?></td> 
              <td><?php
               $productSubCategory = getParentCategory($allProducts->product_sub_category);
               if(isset($productSubCategory) && !empty($productSubCategory)){
                              echo $productSubCategory->cat_name;
               }
                if($allProducts->product_sub_category==0)
               {
              echo "Not Define";
               }
               ?></td>
              <td><?php $productSubCategory = getParentCategory($allProducts->product_sub_of_sub_category);
               if(isset($productSubCategory) && !empty($productSubCategory)){
                              echo $productSubCategory->cat_name;
               }
               if($allProducts->product_sub_of_sub_category==0)
               {
              echo "Not Define";
               } ?></td>
               <td><?php
                $attr_name = get_attribute_by_productID($allProducts->product_id);
                   if(isset($attr_name) && !empty($attr_name)){
                     $count_array = count($attr_name);
                     if(!empty($attr_name)){
                       for($i=0;$i<$count_array;$i++){
                        echo $attr_name[$i]; 
                       }
                     }else{
                      echo "Not Set";
                     }
                  }     
                ?></td>
                <td><?php echo $allProducts->product_price;?></td>
                <td><?php if($allProducts->product_status == "1"){echo "active";}else{echo "inactive";}?></td>
            </tr>
  <?php $cnt3++; }
  } ?>
  </tbody>
               </table>
        </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Product Report</div>
    </div><!--wrapper-->
</body>
</html>