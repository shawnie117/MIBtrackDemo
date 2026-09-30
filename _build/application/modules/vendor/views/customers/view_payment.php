<?php $role_id = $this->session->userdata('user_role_id'); ?>
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE BASE CONTENT -->
		<!--div class="page-head">		
		<div class="page-title">
			<h1><?php echo $page_title; ?></h1>
		</div>	
	   </div-->

		<div class="row">
			<div class="portlet light bordered">
				<ul class="page-breadcrumb breadcrumb">
					<li><a href="<?php echo base_url(get_module() . "/dashboard") ?>">Home</a><i class="fa fa-circle"></i></li>
					<li><a href="<?php echo base_url(get_module() . "/customers/payment_report") ?>">All Payment Report </a><i class="fa fa-circle"></i></li>
					<li><span class="active"><?php echo $page_title; ?></span></li>
				</ul>
				<!--div class="portlet-title">
               <div class="caption">
                  <i class="font-green-sharp icon-eye"></i>
                  <span class="caption-subject font-green-sharp sbold"><?php echo $page_title; ?></span>
			
			   </div>
            </div-->
				<div class="row">
					<center>
						<div class="col-md-8">
							<?php
							$this->load->helper('form');
							$error = $this->session->flashdata('error');
							if ($error) {
							?>

								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->session->flashdata('error'); ?>
								</div>
							<?php } ?>
							<?php
							$success = $this->session->flashdata('success');
							if ($success) {
							?>

								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->session->flashdata('success'); ?>
								</div>
							<?php } ?>


						</div>
					</center>
					<div class="portlet-body">
						<?php //echo "<pre/>";  print_r($details);die;
						$id = base64_encode($ref_id);
						if (!empty($details)) {
							$clientList = $details[0]['clientList'];
							$detailList = $details['detailList'];
							$paymentList = $details['paymentList'];
							if (!empty($clientList)) {
								$clientList = $clientList[0];
						?>

								<div class="col-md-6">
									<div class="portlet-title">
										<div class="caption">
											<i class="font-red-mint icon-book-open"></i>
											<span class="caption-subject font-red-mint sbold">Customer Details</span>
										</div>
										<hr style="margin:3px;" />
									</div>
									<div class="slimScrollDiv200">
										<table class="table table-striped table-bordered table-advance table-hover">
											<tbody>
												<tr>
													<th width="40%">Customer Name</th>
													<td><?php echo isset($clientList['customer_name']) ? $clientList['customer_name'] : ""; ?></td>
												</tr>
												<tr>
													<th>Customer Address </th>
													<td><?php echo isset($clientList['customer_address']) ? $clientList['customer_address'] : ""; ?></td>
												</tr>
												<tr>
													<th>Customer Contact </th>
													<td><?php echo isset($clientList['customer_contact']) ? $clientList['customer_contact'] : ""; ?></td>
												</tr>
												<tr>
													<th>Customer GST No.</th>
													<td><?php echo isset($clientList['customer_gstno']) ? $clientList['customer_gstno'] : ""; ?></td>
												</tr>
											</tbody>
										</table>

									</div>
								</div>


								<div class="col-md-6">
									<div class="portlet-title">
										<br />
										<div class="caption">
											<i class="font-red-mint icon-check"></i>
											<span class="caption-subject font-red-mint sbold">OneTime/AMC/Product Details</span>
										</div>
										<hr style="margin:3px;" />
									</div>
									<?php if (!empty($allDetailList)) { ?>


										<table class="table table-bordered">
											<tr class="success">
												<th>Sr</th>
												<th>Invoice ID</th>
												<th>Product Type</th>
												<th>Qty</th>
												<!-- <th>Rate</th> -->
												<th>Amount</th>
											</tr>

											<?php $i = 1;
											foreach ($allDetailList as $d) { ?>
												<tr>
													<td><?php echo $i++; ?></td>
													<td><?php echo $d['cbpd_cbpmid']; ?></td>
													<td><?php echo $d['cbpd_product_type_name']; ?></td>
													<td><?php echo $d['cbpd_qty']; ?></td>
													<td><?php echo $d['cbpd_rate']; ?></td>
													<!-- <td><?php echo $d['cbpd_saleprice']; ?></td> -->
												</tr>
											<?php } ?>
										</table>
									<?php } ?>

								</div>

								<?php if (!empty($details)) { ?>

									<?php foreach ($details as $invIndex => $inv) {

										$paymentList = isset($inv['paymentList']) ? $inv['paymentList'] : [];
									?>

										<div class="col-md-12">
											<div class="portlet-title">
												<br />
												<div class="caption">
													<i class="font-red-mint icon-wallet"></i>
													<span class="caption-subject font-red-mint sbold">
														Payment Details - Invoice <?php echo $inv['cbpm_billno']; ?>
													</span>
												</div>

											</div>

											<table class="table table-condensed table-hover">
												<tbody>
													<tr>
														<th width="20%">Invoice No</th>
														<td><?php echo $inv['cbpm_billno']; ?></td>

														<th>Package Amount</th>
														<td><?php echo $inv['cbpm_amount']; ?></td>

														<th>Total Amount</th>
														<td><?php echo $inv['cbpm_total_amnt']; ?></td>
													</tr>

													<tr>
														<th>Received Payment</th>
														<td><?php echo $inv['cbpm_received_amnt']; ?></td>

														<th>Balance Payment</th>
														<td><?php echo $inv['cbpm_balance_amnt']; ?></td>

														<th>Discount</th>
														<td><?php echo $inv['cbpm_save_price']; ?></td>
													</tr>
												</tbody>
											</table>

											<!-- PAYMENT LIST -->
											<?php if (!empty($paymentList)) { ?>
												<table class="table table-striped table-bordered table-advance table-hover">
													<tbody>
														<tr class="success">
															<th>Sr No</th>
															<th>Receipt No</th>
															<th>Bill Book No</th>
															<th>Paid Date</th>
															<th>Paid Amt</th>
															<th>Pay Mode</th>
															<th>Chq/Card No</th>
															<th>Bank Details</th>
															<th>Remark</th>
															<th>Status</th>
															<th>Chq Status</th>
														</tr>

														<?php $i = 1;
														foreach ($paymentList as $pyment) { ?>
															<tr>
																<td><?php echo $i++; ?></td>
																<td><?php echo $pyment['cp_receiptno']; ?></td>
																<td><?php echo $pyment['cp_uibillno']; ?></td>
																<td><?php echo $pyment['cp_udate_n']; ?></td>
																<td><?php echo $pyment['cp_amount']; ?></td>
																<td><?php echo $pyment['cp_paytype']; ?></td>
																<td><?php echo $pyment['cp_chq_no']; ?></td>
																<td><?php echo $pyment['cp_bank_details']; ?></td>
																<td><?php echo $pyment['cp_payment_remark']; ?></td>

																<td>
																	<?php
																	if ($pyment['cp_status'] == "Paid") {
																		echo "<span class='label label-success'>Paid</span>";
																	} elseif ($pyment['cp_status'] == "Closed" || $pyment['cp_status'] == "Cancel") {
																		echo "<span class='label label-danger'>" . $pyment['cp_status'] . "</span>";
																	} else {
																		echo "<span class='label label-warning'>" . $pyment['cp_status'] . "</span>";
																	}
																	?>
																</td>

																<td>
																	<?php
																	if ($pyment['cp_chq_clear_status'] == "Paid") {
																		echo "<span class='label label-success'>Paid</span>";
																	} elseif ($pyment['cp_chq_clear_status'] == "Closed" || $pyment['cp_chq_clear_status'] == "Cancel") {
																		echo "<span class='label label-danger'>" . $pyment['cp_chq_clear_status'] . "</span>";
																	} else {
																		echo "<span class='label label-warning'>" . $pyment['cp_chq_clear_status'] . "</span>";
																	}
																	?>
																</td>

															</tr>
														<?php } ?>

													</tbody>
												</table>
											<?php }  ?>

											<hr style="border:2px solid #ddd;margin:30px 0;">
										</div>

								<?php }
								} ?>


							<?php }   ?>


							<div class="col-md-12">
								<div class="form-actions ">
									<div class="col-md-offset-1 col-md-10">
										<center>
											<!-- <?php $history = $this->input->get("history");
													if (isset($history) && $history == "back") { ?>
								  <a class="btn btn-success btn-sm"
									href="<?php echo get_module_path(); ?>customers/add_customer_payment/?ref_id=<?php echo $id; ?>"
									title="Make Payment"><i class="fa fa-check"></i>Make Payment</a>

								   <a onclick="window.history.back();" class="btn btn-danger btn-sm"><i class="fa fa-history"></i>Back</a>
							 <?php } else {  ?>
							 <a class="btn btn-success btn-sm"
									href="<?php echo get_module_path(); ?>customers/add_customer_payment/?ref_id=<?php echo $id; ?>"
									title="Make Payment"><i class="fa fa-check"></i>Make Payment</a>
						   <a href="<?php echo get_module_path(); ?>customers/payment_report?history=back&highlight=<?php echo $this->input->get("id"); ?>" class="btn btn-danger"><i class="fa fa-history"></i>Back</a>
						   <?php }   ?> -->

											<!-- add by ritika 26 june-->
											<?php $history = $this->input->get("history"); ?>

											<a class="btn btn-success btn-sm"
												href="<?php echo get_module_path(); ?>customers/add_customer_payment/?ref_id=<?php echo $id; ?>"
												title="Make Payment">
												<i class="fa fa-check"></i>Make Payment
											</a>

											<?php if ($history == "dashboard") { ?>

												<a href="<?php echo get_module_path(); ?>dashboard"
													class="btn btn-danger btn-sm">
													<i class="fa fa-history"></i>Back
												</a>

											<?php } elseif ($history == "back") { ?>

												<a onclick="window.history.back();"
													class="btn btn-danger btn-sm">
													<i class="fa fa-history"></i>Back
												</a>

											<?php } else { ?>

												<a href="<?php echo get_module_path(); ?>customers/payment_report?history=back&highlight=<?php echo $this->input->get("id"); ?>"
													class="btn btn-danger btn-sm">
													<i class="fa fa-history"></i>Back
												</a>

											<?php } ?>
										</center>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
						<?php } else { ?>
							<div class="alert alert-danger alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								Payment Details Not Found !!!
							</div>
						<?php } ?>

					</div>
				</div>
			</div>
			<!-- END PAGE BASE CONTENT -->
		</div>
		<!-- END CONTENT BODY -->
	</div>
</div>
<!-- END CONTENT -->

<!-- START MODAL -->

<div class="modal fade" id="form_modal_lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-resolve" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-green-sharp">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Resolve Ticket</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Are you really Want To Resolve This Ticket ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-success btn-resolve" data-toggle="modal" data-target="#form_modal">Resolve</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-close" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-red-mint">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Close Ticket</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Are you really Want To Close This Ticket ? </p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-close" data-toggle="modal" data-target="#form_modal">Close Ticket</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-deactivate1" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-red-mint">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title font-white" id="myModalLabel"><i class="font-bold icon-check"></i>&nbsp; Deactivate Ticket</h4>
			</div>
			<div class="modal-body">
				<p id="myModalBody">Are you really Want To Deactivate This Ticket ? </p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-deactivate" data-toggle="modal" data-target="#form_modal">Deactivate</a>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="form_modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		</div>
	</div>
</div>
<!--END START MODAL -->
<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$("#form_modal").on("show.bs.modal", function(e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});
		$("#form_modal_lg").on("show.bs.modal", function(e) {
			var link = $(e.relatedTarget);
			$(this).data('bs.modal', null);
			$(this).find(".modal-content").load(link.attr("href"));
		});


		$('#confirm-deactivate1').on('show.bs.modal', function(e) {
			$(this).find('.btn-deactivate').attr('href', $(e.relatedTarget).data('href'));
		});
		$('#confirm-resolve').on('show.bs.modal', function(e) {
			$(this).find('.btn-resolve').attr('href', $(e.relatedTarget).data('href'));
		});
		$('#confirm-close').on('show.bs.modal', function(e) {
			$(this).find('.btn-close').attr('href', $(e.relatedTarget).data('href'));
		});
		$('#confirm-cancel').on('show.bs.modal', function(e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

	});
</script>