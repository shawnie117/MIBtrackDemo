<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered" style="height:80vh;" >
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/inventory/barcode_report")?>"> All Barcode Details</a><i class="fa fa-circle"></i></li>
	<li><span class="active"><?php echo $page_title; ?></span></li>
		</ul>

    <div class="col-md-12">
					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Modify Scan Items Barcode</span>
							   </div>
							    <hr style="margin:3px;"/>
</div>
					 		<div class="form-group col-md-6">
                           <label for="p_name">Item Name</label> <?php echo REQUIRED_STAR; ?>
						   <select class="form-control" id="p_brand_id" name="p_brand_id" >
							<option value="">-----Select Item-----</option>
							 <?php  if(!empty($brand_list )){ 	 						
								foreach($brand_list as $brand){ 
                                    $brand_id =  isset($details['p_name'])?$details['p_name']:set_value("p_name");
									$selected  = $brand_id == $brand['p_name']?"selected":"";
									?>
									<option value="<?php echo $brand['p_name'];?>" <?php echo $selected;?>><?php echo $brand['p_name']; ?></option>
							<?php } } ?>	
						   </select>						
						    <?php echo form_error('p_brand_id','<span class="text-danger">','</span>'); ?>
								</div>

                           <div class="form-group col-md-6">
                           <label for="p_code">Barcode<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_code" name="p_code" type="text" placeholder="Enter Barcode"  required maxlength="5" value="<?php echo isset($details['item_code'])?$details['item_code']:set_value("p_code"); ?>">
						    <?php echo form_error('p_code','<span class="text-danger">','</span>'); ?>
                        </div>
                        <div class="form-group col-md-4">
                           <label for="p_price">Old Barcode<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_price" name="p_price" type="text" placeholder="Enter Old Barcode" required maxlength="8" value="<?php echo isset($details['item_price'])?$details['item_price']:set_value("p_price"); ?>">
				
							 <?php  if(!empty($brand_list )){ 	 						
								foreach($brand_list as $brand){ 
                                    $brand_id =  isset($details['p_name'])?$details['p_name']:set_value("p_name");
									$selected  = $brand_id == $brand['p_name']?"selected":"";
									?>
									<option value="<?php echo $brand['p_name'];?>" <?php echo $selected;?>><?php echo $brand['p_name']; ?></option>
							<?php } } ?>	
						   </select>
						   <?php echo form_error('p_price','<span class="text-danger">','</span>'); ?>
                           </div> 
						   <div class="form-group col-md-4">
                           <label for="p_price">Purchase Price<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_price" name="p_price" type="text" placeholder="Enter Purchase Price" required maxlength="8" value="<?php echo isset($details['item_price'])?$details['item_price']:set_value("p_price"); ?>">
						    <?php echo form_error('p_price','<span class="text-danger">','</span>'); ?>
                           </div>  
						   <div class="form-group col-md-4">
                           <label for="p_price2">Sale Price</label>
						   <input class="form-control" id="p_price2" name="p_price2" type="text" placeholder="Enter Sale Price" required maxlength="8" value="<?php echo isset($details['item_price2'])?$details['item_price2']:set_value("p_price2"); ?>">
						    <?php echo form_error('p_price2','<span class="text-danger">','</span>'); ?>
                           </div>  
						   
						
	
						   <div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                           <button type="submit" class="btn btn-success" >MODIFY</button>
                          <a href="<?php echo get_module_path();?>inventory/add_barcode/?history=back" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						  </center>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
