<div class="page-content-wrapper">
<div class="page-content amc-portfolio-page">
  <ul class="page-breadcrumb breadcrumb"><li><a href="<?php echo get_module_path(); ?>dashboard">Home</a></li><li>AMC Portfolio</li></ul>
  <?php
    $total=count($contracts); $active=0; $attention=0; $value=0; $visitsDone=0; $visitsTotal=0;
    foreach($contracts as $c){
      if(in_array($c['cust_subs_status'],array('Active','Renewed'))) $active++;
      if(in_array($c['cust_subs_status'],array('Due Soon','Due Today','Expired','Paused','Draft'))) $attention++;
      $value+=(float)$c['contract_value']; $visitsDone+=(int)$c['services_completed']; $visitsTotal+=(int)$c['services_total'];
    }
  ?>
  <div class="amc-hero">
    <div><span>DEMO AMC COMMAND CENTRE</span><h2>Complete AMC Portfolio</h2><p>Every contract is synthetic and follows today's date automatically.</p></div>
    <div class="amc-hero-actions"><a href="<?php echo get_module_path(); ?>masters/add_amc" class="btn btn-info"><i class="fa fa-plus"></i> New AMC Plan</a><a href="<?php echo get_module_path(); ?>dashboard/tour?tour=amc&lang=en" class="btn btn-success"><i class="fa fa-play"></i> Play AMC Tour</a></div>
  </div>
  <div class="amc-kpis">
    <div><b><?php echo $total; ?></b><small>Total Contracts</small></div><div><b><?php echo $active; ?></b><small>Active / Renewed</small></div><div><b><?php echo $attention; ?></b><small>Need Attention</small></div><div><b>₹<?php echo number_format($value); ?></b><small>Contract Value</small></div><div><b><?php echo $visitsDone; ?>/<?php echo $visitsTotal; ?></b><small>Visits Completed</small></div><div><b><?php echo count($plans); ?></b><small>Plan Masters</small></div>
  </div>
  <div class="portlet light bordered">
    <div class="portlet-title"><div class="caption"><i class="fa fa-shield font-blue"></i><span class="caption-subject bold">Customer AMC Lifecycle</span></div></div>
    <div class="amc-filters">
      <input id="amc-search" class="form-control" placeholder="Search customer, mobile or plan">
      <select id="amc-status" class="form-control"><option value="">All lifecycle states</option><option>Active</option><option>Renewed</option><option>Due Soon</option><option>Due Today</option><option>Draft</option><option>Paused</option><option>Expired</option></select>
      <select id="amc-payment" class="form-control"><option value="">All payments</option><option>Paid</option><option>Partial</option><option>Pending</option><option>Overdue</option></select>
      <button id="amc-clear" class="btn btn-default">Clear</button><span id="amc-visible-count"><?php echo $total; ?> contracts</span>
    </div>
    <div class="table-responsive"><table class="table table-striped table-hover" id="amc-portfolio-table"><thead><tr><th>Customer</th><th>AMC Plan</th><th>Lifecycle</th><th>Payment</th><th>Coverage</th><th>Service Progress</th><th class="text-right">Value</th><th>Action</th></tr></thead><tbody>
    <?php foreach($contracts as $c):
      $statusClass=in_array($c['cust_subs_status'],array('Active','Renewed'))?'success':(in_array($c['cust_subs_status'],array('Expired','Due Today'))?'danger':'warning');
      $paymentClass=$c['payment_status']==='Paid'?'success':($c['payment_status']==='Overdue'?'danger':'warning');
      $percent=(int)$c['services_total']?round(((int)$c['services_completed']/(int)$c['services_total'])*100):0;
    ?>
      <tr data-status="<?php echo html_escape($c['cust_subs_status']); ?>" data-payment="<?php echo html_escape($c['payment_status']); ?>">
        <td><strong><?php echo html_escape($c['customer_name']); ?></strong><small><?php echo html_escape($c['customer_contact']); ?></small></td>
        <td><?php echo html_escape($c['amc_name']); ?></td><td><span class="label label-<?php echo $statusClass; ?>"><?php echo html_escape($c['cust_subs_status']); ?></span></td><td><span class="label label-<?php echo $paymentClass; ?>"><?php echo html_escape($c['payment_status']); ?></span></td>
        <td><small><?php echo html_escape($c['cust_subs_startdate_n']); ?></small><br><strong>to <?php echo html_escape($c['cust_subs_enddate_n']); ?></strong></td>
        <td><div class="progress"><div class="progress-bar progress-bar-info" style="width:<?php echo $percent; ?>%"></div></div><small><?php echo (int)$c['services_completed']; ?> of <?php echo (int)$c['services_total']; ?> visits</small></td>
        <td class="text-right">₹<?php echo number_format((float)$c['contract_value']); ?></td><td><a class="btn btn-primary btn-xs" href="<?php echo get_module_path(); ?>customers/view_customer/?id=<?php echo base64_encode($c['customer_id']); ?>&history=amc">View Customer</a></td>
      </tr>
    <?php endforeach; ?></tbody></table></div>
    <div id="amc-no-results" class="alert alert-warning" style="display:none"><strong>No AMC matches these filters.</strong> Clear a filter or add the missing customer contract. <a href="<?php echo get_module_path(); ?>customers/customer_report" class="btn btn-xs btn-warning">Open Customers</a></div>
  </div>
</div></div>
<style>
.amc-hero{background:linear-gradient(120deg,#102942,#21628c);color:#fff;padding:22px;border-radius:12px;display:flex;justify-content:space-between;align-items:center;margin-bottom:15px}.amc-hero span{font-size:10px;letter-spacing:1.5px;color:#55dce7}.amc-hero h2{margin:5px 0}.amc-hero p{margin:0;color:#cfe3f1}.amc-hero-actions{display:flex;gap:8px}.amc-kpis{display:grid;grid-template-columns:repeat(6,1fr);gap:10px;margin-bottom:15px}.amc-kpis div{background:#fff;border:1px solid #dce5ef;border-radius:9px;padding:14px;box-shadow:0 3px 10px rgba(30,55,80,.06)}.amc-kpis b,.amc-kpis small{display:block}.amc-kpis b{font-size:21px;color:#1d5d89}.amc-kpis small{margin-top:4px;color:#718096}.amc-filters{display:grid;grid-template-columns:2fr 1fr 1fr auto auto;gap:8px;align-items:center;margin-bottom:14px}.amc-portfolio-page td small{display:block;color:#778394}.amc-portfolio-page .progress{height:7px;margin:3px 0 4px;min-width:90px}@media(max-width:1000px){.amc-kpis{grid-template-columns:repeat(3,1fr)}.amc-filters{grid-template-columns:1fr 1fr}.amc-hero{align-items:flex-start;flex-direction:column;gap:14px}}
</style>
<script>
(function(){function filter(){var q=document.getElementById('amc-search').value.toLowerCase(),s=document.getElementById('amc-status').value,p=document.getElementById('amc-payment').value,n=0;document.querySelectorAll('#amc-portfolio-table tbody tr').forEach(function(r){var show=(!q||r.textContent.toLowerCase().indexOf(q)>-1)&&(!s||r.dataset.status===s)&&(!p||r.dataset.payment===p);r.style.display=show?'':'none';if(show)n++;});document.getElementById('amc-visible-count').textContent=n+' contract'+(n===1?'':'s');document.getElementById('amc-no-results').style.display=n?'none':'block';}['amc-search','amc-status','amc-payment'].forEach(function(id){document.getElementById(id).addEventListener(id==='amc-search'?'input':'change',filter);});document.getElementById('amc-clear').onclick=function(){document.getElementById('amc-search').value='';document.getElementById('amc-status').value='';document.getElementById('amc-payment').value='';filter();};})();
</script>
