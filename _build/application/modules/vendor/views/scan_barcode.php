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
	
	<a class="pull-right btn green btn-outline btn-sm" href="<?php echo base_url().get_module()."/reports/customer_analysis_graph"?>" title ="Lead Graph"><i class="icon-bar-chart"></i>Scan Barcode</a>    
	</ul>

    <div class="col-md-12">
					     <div class="portlet-title">
					            <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-call-out"></i>
								  <span class="caption-subject font-red-mint sbold">Barcode Details</span>
							   </div>
							    <hr style="margin:3px;"/>
</div>
					 		<div class="form-group col-md-6">
                           <label for="p_name">Item Name</label> <?php echo REQUIRED_STAR; ?>
						   <select class="form-control" id="p_brand_id" name="p_brand_id" >
							<option value=""> Select item name</option>
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
                           <label for="p_code">Item Code <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_code" name="p_code" type="text" placeholder="Enter Item Code"  required maxlength="5" value="<?php echo isset($details['item_code'])?$details['item_code']:set_value("p_code"); ?>">
						    <?php echo form_error('p_code','<span class="text-danger">','</span>'); ?>
                        </div>
						   <div class="form-group col-md-4">
                           <label for="p_price">Purchase Price<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_price" name="p_price" type="text" placeholder="Enter Purchase Price" required maxlength="8" value="<?php echo isset($details['item_price'])?$details['item_price']:set_value("p_price"); ?>">
						    <?php echo form_error('p_price','<span class="text-danger">','</span>'); ?>
                           </div>  
						   <div class="form-group col-md-4">
                           <label for="p_price2">Sale Price<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_price2" name="p_price2" type="text" placeholder="Enter Sale Price" required maxlength="8" value="<?php echo isset($details['item_price2'])?$details['item_price2']:set_value("p_price2"); ?>">
						    <?php echo form_error('p_price2','<span class="text-danger">','</span>'); ?>
                           </div>  
						    <div class="form-group col-md-4">
                           <label for="p_desc">Item Description</label> <?php echo REQUIRED_STAR; ?>
						   <input class="form-control" id="p_desc" name="p_desc" type="text" placeholder="Enter Item Description" required maxlength="500" value="<?php echo isset($details['item_desc'])?$details['item_desc']:set_value("p_desc"); ?>">
						    <?php echo form_error('p_desc','<span class="text-danger">','</span>'); ?>
                           </div>
						   <div class="form-group col-md-4">
                           <label for="p_gst">GST %<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_gst" name="p_gst" type="text" placeholder="Enter GST %" required maxlength="5" value="<?php echo isset($details['item_gst'])?$details['item_gst']:set_value("p_gst"); ?>">
						    <?php echo form_error('p_gst','<span class="text-danger">','</span>'); ?>
                           </div>  
                           <div class="form-group col-md-4">
                           <label for="p_itempack">Pieces <?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_itempack" name="p_itempack" type="text" placeholder="Enter Pieces"  required maxlength="5" value="<?php echo isset($details['item_pack'])?$details['item_pack']:set_value("p_itempack"); ?>">
						    <?php echo form_error('p_itempack','<span class="text-danger">','</span>'); ?>
                        </div>	
						   <div class="form-group col-md-4">
                           <label for="p_no">Item No.<?php echo REQUIRED_STAR; ?></label>
						   <input class="form-control" id="p_no" name="p_no" type="text" placeholder="Enter Item No." required maxlength="10" value="<?php echo isset($details['item_no'])?$details['item_no']:set_value("p_no"); ?>">
						    <?php echo form_error('p_no','<span class="text-danger">','</span>'); ?>
                           </div> 
					        
						  <div class="form-group col-md-4">
                           <label for="p_quantity">Quantity</label>
						   <input class="form-control" id="p_quantity" name="p_quantity" type="text" placeholder="Enter Quantity"  maxlength="5" value="<?php echo isset($details['item_qty'])?$details['item_qty']:set_value("p_quantity"); ?>">
						    <?php echo form_error('p_quantity','<span class="text-danger">','</span>'); ?>
                           </div> 
</div>	
                      
	
						   <div class="form-actions">
						 <div class="col-md-12">
						 <center>						  
                           <button type="submit" class="btn btn-success" >Submit</button>
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
