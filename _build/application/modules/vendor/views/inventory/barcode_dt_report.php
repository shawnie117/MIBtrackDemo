
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
 <style>
    hr{
        margin: 15px 0;
    }
 </style>
   
   <div class="page-content">
      <!-- BEGIN PAGE BASE CONTENT -->
	
	<?php $icon = "icon-plus"; if($action=="Edit"){ $icon = "icon-pencil"; }  ?>
      <div class="row">
	  <div class="col-md-12">
         <div class="portlet light bordered" style="height:110vh;" >
		 <ul class="page-breadcrumb breadcrumb">
	<li><a href="<?php echo base_url(get_module()."/dashboard")?>">Home</a><i class="fa fa-circle"></i></li>
	<li><a href="<?php echo base_url(get_module()."/inventory/supplier_report")?>"> Barcode Report</a><i class="fa fa-circle"></i></li>
	<li><span class="active"><?php echo $page_title; ?></span></li>
	
	</ul>

    <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
<span class="caption-subject font-red-mint sbold float-right total_count">( Total - 0 )</span>	
<div class="row">
                                        <div style="max-height:200vh; width:100%; margin-left:0%; overflow-y:auto;">
                                            <div class="col-sm-6" style="padding:0px;">
         
                                        <fieldset title=" Supplier Details" class="myfieldset"  style="margin-left: auto;
    margin-top: 7%;
    margin-right: auto;
    margin-bottom: 2%;
    height: 49rem;
    padding: 10px;
    width:49rem;
    padding-right: 2%;
    border: 1px solid darkgrey;
    border-top: solid 2px;
    border-top-color: #67c8ef;" >
                                            
                                            
                                            <table class="mytbl" style=" width: 95%;
    margin-bottom: 10px;
    margin-top: 10px;
    margin-left: 3.5%;">
                                               
                                                <tbody><tr>
                                                    <td style="width: 25%">
                                                        <span id="body_lblcltMemID" style="font-weight:bold;"></span>

                                                    </td>
                                                     <td style="width: 75%">
                                                        <span id="body_lblClientID"></span>

                                                    </td>
                                                </tr>
                                    

                                                <tr>
    
    
                                                   <td style="width: 25%">
                                                        <span id="body_Label2" style="font-weight:bold;"> ID :</span>
                                                    </td>
                                            
                                                    <td style="width: 75%">
                                                        <span id="body_lblName" style="color:Maroon;font-weight:bold;">17771</span>
                                                    </td>


                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                    
                                                
                                                     <td style="width: 25%">
                                                        <span id="body_Label4" style="font-weight:bold;">Item Name :</span>
                                                    </td>
                                                    
                                                    <td style="width:75%">
                                                        <span id="body_lblMob1">SCAN PACK 111</span>

                                                        <span id="body_lblMob2"></span>
                                                    </td>
                                                    </tr>
                                                    <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>                                         
                                                <tr>
                                                     <td style="width: 25%">
                                                        <span id="body_Label19" style="font-weight:bold;">Category : </span>
                                                    </td>
                                                      <td style="width: 75%">
                                                        <span id="body_lblLandline"></span>

                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                    <td style="width: 25%">
                                                        <span id="body_Label5" style="font-weight:bold;">Item Make :</span>
                                                    </td>
                                                      <td style="width: 75%">
                                                        <span id="body_lblEmail">Aayu</span>
                                                    </td>

                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                   <tr>
                                                      <td style="width: 25%">
                                                        <span id="body_Label31" style="font-weight:bold;">Item Code :</span>
                                                    </td>
                                                      <td style="width: 75%">
                                                        <span id="body_lblgst"></span>
                                                       
                                                    </td>

                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                      <td style="width: 25%">
                                                        <span id="body_Label6" style="font-weight:bold;">Unit :</span>
                                                    </td>
                                                      <td style="width: 75%">
                                                        <span id="body_Label7"></span>
                                                       
                                                    </td>

                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                       <td style="width: 25%">
                                                        <span id="body_Label24" style="font-weight:bold;">Bufferline :</span>
                                                    </td>
                                                     <td style="width: 75%">
                                                        <span id="body_lblfax"></span>
                                                       
                                                    </td>
                                                        </tr>
                                                        <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                     <td style="width: 25%">
                                                        <span id="body_Label3" style="font-weight:bold;">Quantity :</span>
                                                    </td>
                                                    <td style="width:75%" colspan="3">
                                                        <span id="body_lblAddress"> 0 </span>
                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                 <tr>
                                                 <td style="width: 25%">
                                                        <span id="body_Label16" style="font-weight:bold;">Supplier</span>
                                                    </td>
                                                    <td style="width:75%">
                                                        <span id="body_lblContact">A.L. Pckg.</span>
                                                    </td>
                                                </tr>
                                                
                                                
                                               
                                            </tbody></table>
                                        </fieldset>




                                     </div>
                                          <div class="col-sm-6" style="padding:0px; margin-top:2.51%">
                                                  <fieldset title=" Supplier Details" class="myfieldset" style=" margin-left: auto;
    margin-top: 2%;
    margin-right: auto;
    margin-bottom: 2%;
    padding-right: 2%;
    padding:10px;
    width:49rem;
    border: 1px solid darkgrey;
    border-top: solid 2px;
    border-top-color: #ef8d6d;" >
                                                                                        <table class="mytbl" style=" width: 95%;
    margin-bottom: 10px;
    margin-top: 10px;
    margin-left: 3.5%;
    border-top-color: #67c8ef;">
                                               
                                                <tbody><tr>
                                                    <td style="width: 25%">
                                                        <span id="body_Label8" style="font-weight:bold;"></span>

                                                    </td>

                                                     <td style="width: 75%">
                                                        <span id="body_Label9"></span>

                                                    </td>
                                                </tr>
                                                 <tr>
                                                     <td style="width: 25%">
                                                        <span id="body_Label28" style="font-weight:bold;">Purchase Price :</span>
                                                    </td>
                                                    <td style="width: 75%">
                                                        <span id="body_lblcountry">50</span>
                                                       
                                                    </td>
                                                    </tr>
                                                    <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                  <tr>
                                                    

                                                
                                                   <td style="width: 25%">
                                                        <span id="body_Label25" style="font-weight:bold;">Sale Price :</span>
                                                    </td>
                                                     <td style="width: 75%">
                                                        <span id="body_lblstate">40</span>
                                                        
                                                    </td>
                                                    </tr>
                                                    <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                   

                                                
                                                      <td style="width: 25%">
                                                        <span id="body_Label21" style="font-weight:bold;">GST :</span>
                                                    </td>
                                                   <td style="width: 75%">
                                                        <span id="body_lblcity">0</span>

                                                    </td>
                                                    </tr>
                                                    <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                     <td style="width: 25%">
                                                        <span id="body_Label23" style="font-weight:bold;">HSN Code :</span>
                                                    </td>
                                                     <td style="width: 75%">
                                                        <span id="body_lblpin"> </span>

                                                    </td>

                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                     <td>
                                                        <span id="body_Label26" style="font-weight:bold;">Added Data Time :</span>
                                                    </td>
                                                    <td>
                                                        <span id="body_lblOther"></span>
                                                       
                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                  <tr>
                                                     <td>
                                                        <span id="body_Label10" style="font-weight:bold;"> Added By :</span>
                                                    </td>
                                                    <td>
                                                        <span id="body_lbladdeddate"></span>
                                                        <span id="body_lbladdedtime"></span>
                                                       
                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                  <tr>
                                                     <td>
                                                        <span id="body_Label15" style="font-weight:bold;">Modified Date Time :</span>
                                                    </td>
                                                    <td>
                                                        <span id="body_lbladdedby"></span>
                                                       
                                                       
                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                 <tr>
                                                     <td>
                                                        <span id="body_Label12" style="font-weight:bold;">Modify By :</span>
                                                    </td>
                                                    <td>
                                                         <span id="body_lblmoddate"></span>
                                                       
                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                 <tr>
                                                     <td>
                                                        <span id="body_Label11" style="font-weight:bold;">Modify By :</span>
                                                    </td>
                                                    <td>
                                                         <span id="body_lblmodby">kamdhenu</span>
                                                       
                                                    </td>
                                                </tr>
                                               
                                            </tbody></table>
                                        </fieldset>
                                            </div>
                                          
                                       <div class="col-sm-12">
                                             
                                                <div class="col-sm-12">
                                                 
                                                </div>
                                                <fieldset id="body_sd" title="Supplied Item Details" style="border:none" class="myfieldsetgrid">

                                                    <div style=" overflow:auto; overflow-x: hidden; margin-left:-2%; width: 104%">
                                                        <div>

	</div>
                                                    </div>

                                                </fieldset>
                                            
                                       </div>
                                        <div class="col-sm-6" style="padding:0;"></div>
                                            <div class="col-sm-12">
                                                <div class="form-group" style="width: 100%; text-align: center; margin-top: 0%;">
                                                    <br>
                                                    <input type="submit" name="ctl00$body$btnback" value="Back" id="body_btnback" class="btn btn-primary">

                                                    
                                                  
                                                       </div>
                                            </div>
                                       
                                           
                                           
                                     


                                    
</div>



