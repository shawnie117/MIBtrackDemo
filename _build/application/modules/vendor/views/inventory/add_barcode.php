<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
      <?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
         <div class="col-md-12">
            <!-- Adjusted portlet height and added background color -->
            <div class="portlet light bordered" style="min-height:100vh; background-color:white;">
               <div class="col-lg-10 col-sm-12">
                  <ul class="page-breadcrumb breadcrumb">
                     <li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
                     <li><a href="<?php echo base_url(get_module()."/inventory/barcode_report")?>">All Barcode Report</a><i class="fa fa-circle"></i></li>
                     <li><span class="active"><?php echo $page_title; ?></span></li>
                  </ul>
               </div>
               <center>
                  <a class="btn green btn-outline btn-sm" href="<?php echo base_url().get_module()."/inventory/scan_barcode"?>" title="Lead Graph">
                     <i class="icon-bar-chart"></i>Scan Barcode
                  </a>
               </center>
               <div class="col-md-12">
                  <div class="portlet-title">
                     <br/>
                     <div class="caption">
                        <i class="font-red-mint icon-call-out"></i>
                        <span class="caption-subject font-red-mint sbold">Add Barcode</span>
                     </div>
                     <hr style="margin:3px;"/>
                  </div>

                  <!-- Form Fields -->
                  <div class="row">
                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_name">Item Name</label> 
                        <?php echo REQUIRED_STAR; ?>
                        <select class="form-control" id="p_brand_id" name="p_brand_id">
                           <option value="">Select item name</option>
                           <?php  
                           if(!empty($item_list)){ 	
                              foreach($item_list as $area){ ?>
                                 <option value="<?php echo $area['item_id'];?>" ><?php echo $area['item_name']; ?></option>
                              <?php } 
                           } ?>	
                        </select>						
                        <?php echo form_error('p_brand_id','<span class="text-danger">','</span>'); ?>
                     </div>

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_code">Item Code <?php echo REQUIRED_STAR; ?></label>
                        <input class="form-control" id="p_code" name="p_code" type="text" placeholder="Enter Item Code" required maxlength="5" value="<?php echo isset($details['item_code'])?$details['item_code']:set_value("p_code"); ?>">
                        <?php echo form_error('p_code','<span class="text-danger">','</span>'); ?>
                     </div>

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_price">Purchase Price</label>
                        <input class="form-control" id="p_price" name="p_price" type="text" placeholder="Enter Purchase Price" required maxlength="8" value="<?php echo isset($details['item_price'])?$details['item_price']:set_value("p_price"); ?>">
                        <?php echo form_error('p_price','<span class="text-danger">','</span>'); ?>
                     </div>

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_price2">Sale Price<?php echo REQUIRED_STAR; ?></label>
                        <input class="form-control" id="p_price2" name="p_price2" type="text" placeholder="Enter Sale Price" required maxlength="8" value="<?php echo isset($details['item_price2'])?$details['item_price2']:set_value("p_price2"); ?>">
                        <?php echo form_error('p_price2','<span class="text-danger">','</span>'); ?>
                     </div>

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_desc">Item Description</label> 
                        <?php echo REQUIRED_STAR; ?>
                        <input class="form-control" id="p_desc" name="p_desc" type="text" placeholder="Enter Item Description" required maxlength="500" value="<?php echo isset($details['item_desc'])?$details['item_desc']:set_value("p_desc"); ?>">
                        <?php echo form_error('p_desc','<span class="text-danger">','</span>'); ?>
                     </div>

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_gst">GST %</label>
                        <input class="form-control" id="p_gst" name="p_gst" type="text" placeholder="Enter GST %" required maxlength="5" value="<?php echo isset($details['item_gst'])?$details['item_gst']:set_value("p_gst"); ?>">
                        <?php echo form_error('p_gst','<span class="text-danger">','</span>'); ?>
                     </div>  

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_gst_amt">GST Amt</label>
                        <input class="form-control" id="p_gst_amt" name="p_gst_amt" type="text" placeholder="Enter GST Amount" required maxlength="5" value="<?php echo isset($details['item_gst_amt'])?$details['item_gst_amt']:set_value("p_gst_amt"); ?>">
                        <?php echo form_error('p_gst_amt','<span class="text-danger">','</span>'); ?>
                     </div> 

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_itempack">Pieces <?php echo REQUIRED_STAR; ?></label>
                        <input class="form-control" id="p_itempack" name="p_itempack" type="text" placeholder="Enter Pieces" required maxlength="5" value="<?php echo isset($details['item_pack'])?$details['item_pack']:set_value("p_itempack"); ?>">
                        <?php echo form_error('p_itempack','<span class="text-danger">','</span>'); ?>
                     </div>

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_no">Item No.<?php echo REQUIRED_STAR; ?></label>
                        <input class="form-control" id="p_no" name="p_no" type="text" placeholder="Enter Item No." required maxlength="10" value="<?php echo isset($details['item_no'])?$details['item_no']:set_value("p_no"); ?>">
                        <?php echo form_error('p_no','<span class="text-danger">','</span>'); ?>
                     </div> 

                     <div class="form-group col-md-3 col-sm-6 col-xs-12">
                        <label for="p_quantity">Label Qty</label>
                        <input class="form-control" id="p_quantity" name="p_quantity" type="text" placeholder="Enter Label Quantity" maxlength="5" value="<?php echo isset($details['item_qty'])?$details['item_qty']:set_value("p_quantity"); ?>">
                        <?php echo form_error('p_quantity','<span class="text-danger">','</span>'); ?>
                     </div>
                  </div>	

                  <div class="form-actions" style="margin-bottom: 20px;">  
                     <div class="col-md-12">
                        <center>						  
                           <button type="submit" class="btn btn-success">Submit</button>
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
