<style>
.ticket-summary-page{padding:22px;}
.ticket-summary-header{background:#ffffff;border:1px solid #e6ebf2;border-radius:8px;padding:18px 20px;margin-bottom:18px;display:flex;align-items:center;justify-content:space-between;gap:15px;box-shadow:0 6px 18px rgba(31,45,61,.06);}
.ticket-summary-title{margin:0;color:#233043;font-size:22px;font-weight:700;}
.ticket-summary-subtitle{margin-top:4px;color:#7b8794;font-size:13px;}
.ticket-filter{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.ticket-filter-label{color:#667085;font-size:12px;font-weight:700;text-transform:uppercase;}
.ticket-date-field{position:relative;}
.ticket-date-field i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#0ea5a4;}
.ticket-date-input{width:150px;height:38px;border:1px solid #d9e2ec;border-radius:6px;color:#243447;padding:8px 12px 8px 36px;background:#ffffff;}
.ticket-refresh-btn{height:38px;border:0;border-radius:6px;color:#ffffff;background:#2563eb;padding:0 14px;font-weight:600;}
.ticket-kpi-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:16px;margin-bottom:18px;}
.ticket-kpi-card{background:#ffffff;border:1px solid #e6ebf2;border-radius:8px;padding:18px;min-height:128px;box-shadow:0 6px 18px rgba(31,45,61,.06);}
.ticket-kpi-card.blue{border-top:4px solid #2563eb;}
.ticket-kpi-card.green{border-top:4px solid #0f9f6e;}
.ticket-kpi-card.purple{border-top:4px solid #7c3aed;}
.ticket-kpi-card.orange{border-top:4px solid #f59e0b;}
.ticket-kpi-card.red{
    border-top:4px solid #ef4444;
}

.red .ticket-kpi-icon{
    color:#ef4444;
    background:#fef2f2;
}
.ticket-kpi-card.red{border-top:4px solid #ef4444;}
.ticket-kpi-top{display:flex;align-items:center;justify-content:space-between;gap:12px;}
.ticket-kpi-label{color:#667085;font-size:12px;font-weight:700;text-transform:uppercase;}
.ticket-kpi-icon{width:42px;height:42px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;}
.blue .ticket-kpi-icon{color:#2563eb;background:#eff6ff;}
.green .ticket-kpi-icon{color:#0f9f6e;background:#ecfdf5;}
.purple .ticket-kpi-icon{color:#7c3aed;background:#f5f3ff;}
.orange .ticket-kpi-icon{color:#f59e0b;background:#fffbeb;}
.ticket-kpi-value{margin-top:16px;color:#182230;font-size:38px;line-height:1;font-weight:700;}
.ticket-board-grid{display:grid;grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);gap:16px;margin-bottom:18px;}
.ticket-panel{background:#ffffff;border:1px solid #e6ebf2;border-radius:8px;overflow:hidden;box-shadow:0 6px 18px rgba(31,45,61,.06);margin-bottom:18px;}
.ticket-panel-head{padding:16px 18px;border-bottom:1px solid #edf1f6;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:15px;}
.ticket-panel-title{color:#233043;font-size:17px;font-weight:700;}
.ticket-panel-subtitle{color:#8a95a3;font-size:12px;margin-top:3px;}
.ticket-summary-filter-group{display:flex;align-items:center;gap:10px;flex-wrap:wrap;justify-content:flex-end;}
.ticket-panel-head .ticket-summary-inline-filter{min-width:140px;}
.ticket-summary-inline-filter{position:relative;}
.ticket-summary-inline-filter i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#98a2b3;}
.ticket-summary-inline-filter input{width:100%;height:36px;border:1px solid #d0d5dd;border-radius:6px;padding:8px 12px 8px 36px;font-size:13px;color:#344054;box-sizing:border-box;}
.ticket-summary-inline-filter.search{min-width:240px;}
.ticket-status-layout{display:grid;grid-template-columns:170px minmax(0,1fr);align-items:center;gap:20px;min-height:240px;}
.ticket-donut{width:158px;height:158px;border-radius:50%;background:conic-gradient(#0f9f6e 0deg,#e5e7eb 0deg);display:flex;align-items:center;justify-content:center;}
.ticket-donut-inner{width:104px;height:104px;border-radius:50%;background:#ffffff;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#667085;font-size:12px;font-weight:700;text-transform:uppercase;}
.ticket-donut-total{color:#182230;font-size:28px;line-height:1;margin-bottom:5px;}
.ticket-status-list,.ticket-employee-bars{display:flex;flex-direction:column;gap:12px;}
.ticket-status-list{min-width:0;width:100%;}
.ticket-employee-bars{max-height:300px;overflow-y:auto;padding-left:15px;padding-right:10px;min-width:0;width:100%;box-sizing:border-box;}
.ticket-employee-bars::-webkit-scrollbar{width:6px;}
.ticket-employee-bars::-webkit-scrollbar-track{background:#eef2f7;border-radius:999px;}
.ticket-employee-bars::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:999px;}
.ticket-status-item,.ticket-employee-bar-row{display:grid;grid-template-columns:minmax(100px,180px) minmax(80px,1fr) 42px;align-items:center;gap:10px;color:#475467;font-size:13px;min-width:0;}
.ticket-status-dot{width:10px;height:10px;border-radius:50%;display:inline-block;margin-right:7px;}
.ticket-track{height:8px;border-radius:999px;background:#eef2f7;overflow:hidden;}
.ticket-fill{height:100%;border-radius:999px;width:0%;transition:width .3s ease;}
.status-open{background:#0f9f6e;}
.status-resolved{background:#7c3aed;}
.status-closed{background:#f59e0b;}
.status-deactivated{background:#ef4444;}  

.employee-bar-name{overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}
.ticket-table-wrap{height:390px;overflow-y:auto;overflow-x:hidden;}
.ticket-data-table{width:100%;border-collapse:collapse;}
.ticket-data-table thead th{position:sticky;top:0;z-index:20;background:#f8fafc;}
.ticket-data-table th{background:#f8fafc;color:#667085;padding:13px 14px;text-align:left;font-size:12px;font-weight:700;text-transform:uppercase;border-bottom:1px solid #e6ebf2;white-space:nowrap;}
.ticket-data-table td{color:#344054;padding:13px 14px;border-bottom:1px solid #edf1f6;vertical-align:middle;}
.ticket-data-table tbody tr:hover{background:#f9fbfd;}
.ticket-empty{padding:34px 15px;color:#8a95a3;text-align:center;}
.ticket-kpi-value a{
    color: inherit;
    text-decoration: none;
}

.ticket-kpi-value a:hover{
    text-decoration: underline;
    cursor: pointer;
}
/* 30/06/26 Added by Anjali */
@media(max-width:991px){
    .ticket-summary-header{
        align-items:flex-start;
        flex-direction:column;
    }

    .ticket-kpi-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .ticket-board-grid{
        grid-template-columns:minmax(0,1fr);
    }

    .ticket-board-grid > .ticket-panel{
        min-width:0;
    }
}

@media(max-width:767px){
    .ticket-status-layout{
        display:flex;
        flex-direction:column;
        align-items:center;
        min-height:0;
        padding:18px;
    }

    .ticket-status-list{
        width:100%;
    }

    .ticket-employee-bars{
        padding:18px;
    }

    .ticket-status-item,
    .ticket-employee-bar-row{
        grid-template-columns:minmax(90px,1fr) minmax(70px,1.5fr) 38px;
        gap:8px;
    }
}

@media(max-width:576px){
    .ticket-summary-page{padding:14px;}
    .ticket-kpi-grid,.ticket-board-grid{grid-template-columns:1fr;}
    .ticket-filter,.ticket-date-input,.ticket-refresh-btn,.ticket-summary-inline-filter{width:100%;}
    .ticket-panel-head{align-items:flex-start;padding:14px;}
    .ticket-panel-title{font-size:16px;}
    .ticket-status-layout,.ticket-employee-bars{padding:14px;}
    .ticket-donut{width:140px;height:140px;}
    .ticket-donut-inner{width:92px;height:92px;}
    .ticket-donut-total{font-size:25px;}
    .ticket-status-item,.ticket-employee-bar-row{font-size:12px;}
}
</style>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="ticket-summary-page">
            <div class="ticket-summary-header">
                <div>
                    <h1 class="ticket-summary-title">Lead Summary Report</h1>
                    <div class="ticket-summary-subtitle">Monthly lead status, employee load, and conversion details</div>
                </div>

                <div class="ticket-filter">
                    <span class="ticket-filter-label">Period</span>
                    <div class="ticket-date-field">
                        <i class="fa fa-calendar"></i>
                        <input class="datepickerMY ticket-date-input" id="month_year" type="text" placeholder="MM-YYYY" readonly>
                    </div>
                    <button type="button" class="ticket-refresh-btn" id="lead_report_refresh">
                        <i class="fa fa-refresh"></i> View
                    </button>
                </div>
            </div>

            <div class="ticket-kpi-grid">

    <!-- Total Leads -->
                <div class="ticket-kpi-card blue">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Total Leads</div>
            <div class="ticket-kpi-icon">
                <i class="fa fa-users"></i>
                    </div>
        </div>

        <div class="ticket-kpi-value">
            <a href="<?php echo base_url(); ?>leads/lead_report" id="total_leads_link">
                <span id="total_leads">0</span>
            </a>
        </div>
                </div>

    <!-- Active Leads -->
                <div class="ticket-kpi-card green">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Active Leads</div>
            <div class="ticket-kpi-icon">
                <i class="fa fa-folder-open"></i>
                    </div>
        </div>

        <div class="ticket-kpi-value">
            <a href="<?php echo base_url(); ?>leads/lead_report?status=Active" id="active_leads_link">
                <span id="active_leads">0</span>
            </a>
        </div>
                </div>

                <div class="ticket-kpi-card purple">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Approved Leads</div>
            <div class="ticket-kpi-icon">
                <i class="fa fa-check-circle"></i>
                    </div>
        </div>

        <!-- <div class="ticket-kpi-value">
            <a href="<?php echo base_url(); ?>leads/lead_report?status=Approved" id="Approval Requested_leads_link">
                <span id="approved_leads">0</span>
            </a>
        </div> -->
        <div class="ticket-kpi-value">
    <!-- Added by Anjali 29/06/26: apply the selected month to the Approved count link -->
    <a href="<?php echo base_url(); ?>leads/lead_report?status=Approval%20Requested" id="approved_leads_link">
        <span id="approved_leads">0</span>
    </a>
</div>
                </div>

    <!-- Converted Leads -->
                <div class="ticket-kpi-card orange">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Converted Leads</div>
            <div class="ticket-kpi-icon">
                <i class="fa fa-line-chart"></i>
                    </div>
        </div>

        <div class="ticket-kpi-value">
            <!-- Added by Anjali 29/06/26: converted leads use Approved report status -->
            <a href="<?php echo base_url(); ?>leads/lead_report?status=Approved" id="converted_leads_link">
                <span id="converted_leads">0</span>
            </a>
        </div>
                </div>

    <!-- Deactivated Leads -->
                <div class="ticket-kpi-card red">
                <div class="ticket-kpi-top">
                    <div class="ticket-kpi-label">Deactivated Leads</div>
                    <div class="ticket-kpi-icon">
                        <i class="fa fa-ban"></i>
                    </div>
                </div>

        <div class="ticket-kpi-value">
            <a href="<?php echo base_url(); ?>leads/lead_report?status=Deactivated" id="deactivated_leads_link">
                <span id="deactivated_leads">0</span>
            </a>
            </div>
    </div>

            </div>

            <div class="ticket-board-grid">
                <div class="ticket-panel">
                    <div class="ticket-panel-head">
                        <div>
                            <div class="ticket-panel-title">Lead Status Distribution</div>
                            <div class="ticket-panel-subtitle">Active vs approved vs converted vs deactivated</div>
                        </div>
                    </div>
                    <div class="ticket-panel-body">
                        <div class="ticket-status-layout">
                            <div class="ticket-donut" id="lead_status_chart">
                                <div class="ticket-donut-inner">
                                    <span class="ticket-donut-total" id="lead_donut_total">0</span>
                                    Total
                                </div>
                            </div>
                            <div class="ticket-status-list">
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-open"></i>Active</span>
                                    <div class="ticket-track"><div class="ticket-fill status-open" id="active_lead_fill"></div></div>
                                    <strong id="active_lead_percent">0%</strong>
                                </div>
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-resolved"></i>Approved</span>
                                    <div class="ticket-track"><div class="ticket-fill status-resolved" id="approved_lead_fill"></div></div>
                                    <strong id="approved_lead_percent">0%</strong>
                                </div>
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-closed"></i>Converted</span>
                                    <div class="ticket-track"><div class="ticket-fill status-closed" id="converted_lead_fill"></div></div>
                                    <strong id="converted_lead_percent">0%</strong>
                                </div>
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-deactivated"></i>Deactivated</span>
                                    <div class="ticket-track"><div class="ticket-fill status-deactivated" id="deactivated_lead_fill"></div></div>
                                    <strong id="deactivated_lead_percent">0%</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ticket-panel">
                    <div class="ticket-panel-head">
                        <div>
                            <div class="ticket-panel-title">Employee Wise Leads</div>
                            <div class="ticket-panel-subtitle">Top employee workload</div>
                        </div>
                    </div>
                    <div class="ticket-panel-body">
                        <div class="ticket-employee-bars" id="emp_bars">
                            <div class="ticket-empty">No data found</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ticket-panel">
                <div class="ticket-panel-head">
                    <div>
                        <div class="ticket-panel-title">Employee Lead Summary</div>
                    </div>

                    <div class="ticket-summary-filter-group">
                        <!-- <div class="ticket-summary-inline-filter">
                            <i class="fa fa-calendar"></i>
                            <input type="text" class="datepickerD" id="summary_from_date" placeholder="Start date" readonly>
                        </div>

                        <div class="ticket-summary-inline-filter">
                            <i class="fa fa-calendar"></i>
                            <input type="text" class="datepickerD" id="summary_to_date" placeholder="End date" readonly>
                        </div> -->

                        <div class="ticket-summary-inline-filter search">
                            <i class="fa fa-search"></i>
                            <input type="text" id="employee_summary_filter" placeholder="Search employee name">
                        </div>
                    </div>
                </div>

                <div class="ticket-table-wrap">
                    <table class="ticket-data-table">
                        <thead>
                            <tr>
                                <th>Sr.no</th>
                                <th>Employee</th>
                                <th>Total</th>
                                <th>Active</th>
                                <th>Approved</th>
                                <th>Converted</th>
                                <th>Deactivated</th>
                            </tr>
                        </thead>
                        <tbody id="employee_lead_summary">
                            <tr><td colspan="5" class="ticket-empty">Loading summary...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
window.addEventListener('load', function(){
    var today = new Date();
    var defaultMonth = ('0' + (today.getMonth() + 1)).slice(-2) + '-' + today.getFullYear();

    $('#month_year').val(defaultMonth);

    if($.fn.datepicker){
        $('.datepickerMY').datepicker({
            format:'mm-yyyy',
            autoclose:true,
            todayHighlight:true,
            viewMode:'months',
            minViewMode:'months'
        }).on('changeDate', function(){
            load_lead_summary_report();
        });

        $('.datepickerD').datepicker({
            format:'dd-mm-yyyy',
            autoclose:true,
            todayHighlight:true
        }).on('changeDate', function(){

            if(
                $('#summary_from_date').val() != '' ||
                $('#summary_to_date').val() != ''
            ){
                $('#month_year').val('');
            }

            load_lead_summary_report();
        });
    }

    // $('#lead_report_refresh').on('click', function(){
    //     load_lead_summary_report();
    // });

    $('#lead_report_refresh').on('click', function(){

        var today = new Date();

        var currentMonth =
            ('0' + (today.getMonth() + 1)).slice(-2)
            + '-' +
            today.getFullYear();

        $('#month_year').val(currentMonth);

        $('#summary_from_date').val('');
        $('#summary_to_date').val('');

        load_lead_summary_report();
    });

    $('#employee_summary_filter').on('keyup', filter_employee_summary_rows);

    load_lead_summary_report();
});

function lead_number(value){
    var number = parseInt(value, 10);
    return isNaN(number) ? 0 : number;
}

// Added by Anjali 29/06/26
function lead_report_url(empId, status, employeeName){
    var params = [];
    var month = $('#month_year').val() || '';

    // Added by Anjali 29/06/26
    if(empId){
        params.push('emp=' + encodeURIComponent(btoa(String(empId))));
    }

    if(employeeName){
        params.push('summary_employee_name=' + encodeURIComponent(employeeName));
    }

    // Added by Anjali 29/06/26: an explicit blank status shows the Total list.
    if(status === 'Total'){
        params.push('status=');
    } else if(status){
        params.push('status=' + encodeURIComponent(status));
    }

    if(month){
        params.push('lead_month_year=' + encodeURIComponent(month));
    }

    return base_url + 'leads/lead_report' + (params.length ? '?' + params.join('&') : '');
}

function lead_report_count_link(empId, employeeName, status, value){
    var number = lead_number(value);

    if(!empId){
        return number;
    }

    return '<a href="' + lead_report_url(empId, status, employeeName) + '">' + number + '</a>';
}

function lead_percent(value, total){
    if(!total){
        return 0;
    }

    return Math.round((value / total) * 100);
}

function lead_html_escape(value){
    return $('<div/>').text(value || '').html();
}

function update_lead_charts(summary){
    var total = lead_number(summary.total_leads);
    var approved = lead_number(summary.approved_leads);
    var converted = lead_number(summary.converted_leads);
    var deactivated = lead_number(summary.deactivated_leads);
    //var active = Math.max(total - approved - converted - deactivated, 0);
    var active = lead_number(summary.active_leads);
    var activeDeg = total ? (active / total) * 360 : 0;
    var approvedDeg = total ? (approved / total) * 360 : 0;
    var convertedDeg = total ? (converted / total) * 360 : 0;
    var deactivatedDeg = total ? (deactivated / total) * 360 : 0;                           
    var activePercent = lead_percent(active, total);
    var approvedPercent = lead_percent(approved, total);
    var convertedPercent = lead_percent(converted, total);

    $('#total_leads, #lead_donut_total').text(total);
    // $('#active_leads').text(active);
    $('#active_leads').text(active);
    $('#approved_leads').text(approved);
    $('#converted_leads').text(converted);
    // $('#deactivated_leads').text(summary.deactivated_leads);
    var deactivated = lead_number(summary.deactivated_leads);

$('#deactivated_leads').text(deactivated);

    $('#active_lead_fill').css('width', activePercent + '%');
    // Added by Anjali 29/06/26: display the calculated Active lead percentage.
    $('#active_lead_percent').text(activePercent + '%');
    $('#approved_lead_fill').css('width', approvedPercent + '%');
    $('#converted_lead_fill').css('width', convertedPercent + '%');
//     $('#deactivated_lead_fill').css(
//     'width',
//     lead_percent(summary.deactivated_leads, total) + '%'
// );
//     $('#deactivated_lead_percent').text(lead_percent(summary.deactivated_leads, total) + '%');

var deactivatedPercent = lead_percent(deactivated, total);

$('#deactivated_lead_fill').css('width', deactivatedPercent + '%');
$('#deactivated_lead_percent').text(deactivatedPercent + '%');

    $('#approved_lead_percent').text(approvedPercent + '%');
    
    $('#converted_lead_percent').text(convertedPercent + '%');

    $('#lead_status_chart').css(
        'background',
        'conic-gradient(#0f9f6e 0deg '+activeDeg+'deg, #7c3aed '+activeDeg+'deg '+(activeDeg + approvedDeg)+'deg, #f59e0b '+(activeDeg + approvedDeg)+'deg '+(activeDeg + approvedDeg + convertedDeg)+'deg, #ef4444 '+(activeDeg + approvedDeg + convertedDeg)+'deg 360deg)'
    );

            // added by anjali 26-06-26
        // Added by Anjali 29/06/26: filter every KPI lead list by the selected month.
        $('#total_leads_link').attr('href', lead_report_url('', 'Total', ''));
        $('#active_leads_link').attr('href', lead_report_url('', 'Active', ''));
        $('#approved_leads_link').attr('href', lead_report_url('', 'Approval Requested', ''));
        $('#converted_leads_link').attr('href', lead_report_url('', 'Approved', ''));
        $('#deactivated_leads_link').attr('href', lead_report_url('', 'Deactivated', ''));
}

function update_employee_bars(employeeSummary){
    var html = '';
    var maxTotal = 0;

    if(!employeeSummary || !employeeSummary.length){
        $('#emp_bars').html('<div class="ticket-empty">No data found</div>');
        return;
    }

    $.each(employeeSummary, function(index, emp){
        maxTotal = Math.max(maxTotal, lead_number(emp.total_leads));
    });

    $.each(employeeSummary, function(index, emp){
        var total = lead_number(emp.total_leads);
        var width = maxTotal ? Math.max(4, Math.round((total / maxTotal) * 100)) : 0;
        var name = lead_html_escape(emp.employee_name || emp.emp_name || 'N/A');

        html += '<div class="ticket-employee-bar-row">';
        html += '<span class="employee-bar-name" title="'+name+'">'+name+'</span>';
        html += '<div class="ticket-track"><div class="ticket-fill status-open" style="width:'+width+'%"></div></div>';
        html += '<strong>'+total+'</strong>';
        html += '</div>';
    });

    $('#emp_bars').html(html);
}

// function update_employee_summary_table(employeeSummary){
//     var html = '';

//     if(!employeeSummary || !employeeSummary.length){
//         $('#employee_lead_summary').html('<tr><td colspan="6" class="ticket-empty">No Data Found</td></tr>');
//         return;
//     }

//     $.each(employeeSummary, function(index, emp){
//         html += '<tr>';
//         html += '<td>'+(index + 1)+'</td>';
//         html += '<td>'+lead_html_escape(emp.employee_name || emp.emp_name || 'N/A')+'</td>';
//         html += '<td>'+lead_number(emp.total_leads)+'</td>';
//         html += '<td>'+lead_number(emp.active_leads)+'</td>';
//         html += '<td>'+lead_number(emp.approved_leads)+'</td>';
//         html += '<td>'+lead_number(emp.converted_leads)+'</td>';
//         html += '<td>'+lead_number(emp.deactivated_leads)+'</td>';
//         html += '</tr>';
//     });

//     $('#employee_lead_summary').html(html);
// }
// changes done by anjali dhane 26/06/26

function update_employee_summary_table(employeeSummary){
    var html = '';

    if(!employeeSummary || !employeeSummary.length){
        $('#employee_lead_summary').html('<tr><td colspan="7" class="ticket-empty">No Data Found</td></tr>');
        return;
    }

    // Added by Anjali 29/06/26
    $.each(employeeSummary, function(index, emp){

        var emp_id = emp.employee_id || emp.user_id || emp.emp_id || '';
	var emp_name = emp.employee_name || emp.emp_name || '';

        html += '<tr>';
        html += '<td>'+(index + 1)+'</td>';
        html += '<td>'+lead_html_escape(emp_name || 'N/A')+'</td>';
        html += '<td>'+lead_report_count_link(emp_id, emp_name, 'Total', emp.total_leads)+'</td>';
        html += '<td>'+lead_report_count_link(emp_id, emp_name, 'Active', emp.active_leads)+'</td>';
        html += '<td>'+lead_report_count_link(emp_id, emp_name, 'Approval Requested', emp.approved_leads)+'</td>';
        // Added by Anjali 29/06/26: converted leads use Approved report status
        html += '<td>'+lead_report_count_link(emp_id, emp_name, 'Approved', emp.converted_leads)+'</td>';
        html += '<td>'+lead_report_count_link(emp_id, emp_name, 'Deactivated', emp.deactivated_leads)+'</td>';
        html += '</tr>';
    });

    $('#employee_lead_summary').html(html);
}
function filter_employee_summary_rows(){
    var query = ($('#employee_summary_filter').val() || '').toLowerCase().trim();

    $('#employee_lead_summary tr').each(function(){
        var row = $(this);
        var cells = row.find('td');

        if(cells.length <= 1){
            return;
        }

        var employeeName = cells.eq(1).text().toLowerCase();
        row.toggle(!query || employeeName.indexOf(query) !== -1);
    });
}

function load_lead_summary_report(){
    $('.loader').fadeIn();

    $.ajax({
        url:"<?php echo base_url(get_module().'/leads/get_employee_summary'); ?>",
        type:'POST',
        data:{
            month_year:$('#month_year').val(),
            start_date:$('#summary_from_date').val(),
            end_date:$('#summary_to_date').val()
        },
        dataType:'json',
        success:function(response){
            var summary = response.kpi || {};
            var employeeSummary = response.summary || [];

            update_lead_charts(summary);
            update_employee_bars(employeeSummary);
            update_employee_summary_table(employeeSummary);
            filter_employee_summary_rows();
            $('.loader').fadeOut();
        },

        
        error:function(){
            $('#employee_lead_summary').html('<tr><td colspan="6" class="ticket-empty">Unable to load summary</td></tr>');
            update_lead_charts({});
            update_employee_bars([]);
            $('.loader').fadeOut();
        }
    });
}
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
