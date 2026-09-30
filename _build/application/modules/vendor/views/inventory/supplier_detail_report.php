
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
	<li><a href="<?php echo base_url(get_module()."/inventory/supplier_report")?>"> Supplier Report</a><i class="fa fa-circle"></i></li>
	<li><span class="active"><?php echo $page_title; ?></span></li>
	
	</ul>
	<!-- <a class="pull-right btn green btn-outline btn-sm" href="<?php echo base_url().get_module()."/inventory/modify_scan_barcode"?>" title ="Lead Graph"><i class="icon-bar-chart"></i>Modify Scan Barcode</a>     -->

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
    border-top-color: #67c8ef;
    >
                                            
                                            
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
                                                        <span id="body_Label2" style="font-weight:bold;"> Suplier Name :</span>
                                                    </td>
                                            
                                                    <td style="width: 75%">
                                                        <span id="body_lblName" style="color:Maroon;font-weight:bold;">Sonam Jha</span>
                                                    </td>


                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                    
                                                
                                                     <td style="width: 25%">
                                                        <span id="body_Label4" style="font-weight:bold;">Contact No.:</span>
                                                    </td>
                                                    
                                                    <td style="width:75%">
                                                        <span id="body_lblMob1">9967534266</span>

                                                        <span id="body_lblMob2"></span>
                                                    </td>
                                                    </tr>
                                                    <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>                                         
                                                <tr>
                                                     <td style="width: 25%">
                                                        <span id="body_Label19" style="font-weight:bold;">Landline No.:</span>
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
                                                        <span id="body_Label5" style="font-weight:bold;">Email :</span>
                                                    </td>
                                                      <td style="width: 75%">
                                                        <span id="body_lblEmail">sonam@gmail.com</span>
                                                    </td>

                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                   <tr>
                                                      <td style="width: 25%">
                                                        <span id="body_Label31" style="font-weight:bold;">Gst No.:</span>
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
                                                        <span id="body_Label6" style="font-weight:bold;">PAN Card No.:</span>
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
                                                        <span id="body_Label24" style="font-weight:bold;">FAX No.:</span>
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
                                                        <span id="body_Label3" style="font-weight:bold;">Address :</span>
                                                    </td>
                                                    <td style="width:75%" colspan="3">
                                                        <span id="body_lblAddress">navi mumbai</span>
                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                 <tr>
                                                 <td style="width: 25%">
                                                        <span id="body_Label16" style="font-weight:bold;">Contact Person :</span>
                                                    </td>
                                                    <td style="width:75%">
                                                        <span id="body_lblContact">archana</span>
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
    border-top-color: #67c8ef;
">
                                               
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
                                                        <span id="body_Label28" style="font-weight:bold;">Country :</span>
                                                    </td>
                                                    <td style="width: 75%">
                                                        <span id="body_lblcountry">India</span>
                                                       
                                                    </td>
                                                    </tr>
                                                    <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                  <tr>
                                                    

                                                
                                                   <td style="width: 25%">
                                                        <span id="body_Label25" style="font-weight:bold;">State :</span>
                                                    </td>
                                                     <td style="width: 75%">
                                                        <span id="body_lblstate">Maharashtra</span>
                                                        
                                                    </td>
                                                    </tr>
                                                    <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                   

                                                
                                                      <td style="width: 25%">
                                                        <span id="body_Label21" style="font-weight:bold;">City :</span>
                                                    </td>
                                                   <td style="width: 75%">
                                                        <span id="body_lblcity">mumbai</span>

                                                    </td>
                                                    </tr>
                                                    <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                     <td style="width: 25%">
                                                        <span id="body_Label23" style="font-weight:bold;">Pincode :</span>
                                                    </td>
                                                     <td style="width: 75%">
                                                        <span id="body_lblpin">400706</span>

                                                    </td>

                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                <tr>
                                                     <td>
                                                        <span id="body_Label26" style="font-weight:bold;">Other Details :</span>
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
                                                        <span id="body_Label10" style="font-weight:bold;"> Date time :</span>
                                                    </td>
                                                    <td>
                                                        <span id="body_lbladdeddate">09-02-2024 18:41:14</span>
                                                        <span id="body_lbladdedtime"></span>
                                                       
                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                  <tr>
                                                     <td>
                                                        <span id="body_Label15" style="font-weight:bold;">Added by :</span>
                                                    </td>
                                                    <td>
                                                        <span id="body_lbladdedby">kamdhenu</span>
                                                       
                                                       
                                                    </td>
                                                </tr>
                                                <tr>
            <td colspan="2"><hr></td> <!-- Horizontal line -->
        </tr>
                                                 <tr>
                                                     <td>
                                                        <span id="body_Label12" style="font-weight:bold;">Modify Date time :</span>
                                                    </td>
                                                    <td>
                                                         <span id="body_lblmoddate">14-02-2024 12:06:21</span>
                                                       
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

                                                    <input type="submit" name="ctl00$body$btnModify" value="Modify" id="body_btnModify" class="btn btn-success">

                                                    <input type="submit" name="ctl00$body$btnback" value="Back" id="body_btnback" class="btn btn-primary">

                                                  
                                                       </div>
                                            </div>
                                       
                                           
                                           
                                     


                                    
</div>



