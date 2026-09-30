<style>
/* body{
    background:#f4f7fb;
} */

.ticket-summary-page{
    padding:22px;
}

.ticket-summary-header{
    background:#ffffff;
    border:1px solid #e6ebf2;
    border-radius:8px;
    padding:18px 20px;
    margin-bottom:18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    box-shadow:0 6px 18px rgba(31,45,61,.06);
}

.ticket-summary-title{
    margin:0;
    color:#233043;
    font-size:22px;
    font-weight:700;
}

.ticket-summary-subtitle{
    margin-top:4px;
    color:#7b8794;
    font-size:13px;
}

.ticket-filter{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}

.ticket-filter-label{
    color:#667085;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
}

.ticket-date-field{
    position:relative;
}

.ticket-date-field i{
    position:absolute;
    left:12px;
    top:50%;
    transform:translateY(-50%);
    color:#0ea5a4;
}

.ticket-date-input{
    width:150px;
    height:38px;
    border:1px solid #d9e2ec;
    border-radius:6px;
    color:#243447;
    padding:8px 12px 8px 36px;
    background:#ffffff;
}

.ticket-refresh-btn{
    height:38px;
    border:0;
    border-radius:6px;
    color:#ffffff;
    background:#2563eb;
    padding:0 14px;
    font-weight:600;
}

.ticket-kpi-grid{
    display:grid;
    grid-template-columns:repeat(6,minmax(160px,1fr));
    gap:12px;
    margin-bottom:18px;
}
.ticket-kpi-card{
    min-height:110px;
    padding:15px;
}
.ticket-kpi-value{
    font-size:32px;
}
.ticket-kpi-card{
    background:#ffffff;
    border:1px solid #e6ebf2;
    border-radius:8px;
    padding:18px;
    min-height:128px;
    box-shadow:0 6px 18px rgba(31,45,61,.06);
}

.ticket-kpi-card.blue{
    border-top:4px solid #2563eb;
}

.ticket-kpi-card.green{
    border-top:4px solid #0f9f6e;
}

.ticket-kpi-card.purple{
    border-top:4px solid #7c3aed;
}

.ticket-kpi-card.orange{
    border-top:4px solid #f59e0b;
}

.ticket-kpi-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
}

.ticket-kpi-label{
    color:#667085;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
}

.ticket-kpi-icon{
    width:42px;
    height:42px;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
}

.blue .ticket-kpi-icon{
    color:#2563eb;
    background:#eff6ff;
}

.green .ticket-kpi-icon{
    color:#0f9f6e;
    background:#ecfdf5;
}

.purple .ticket-kpi-icon{
    color:#7c3aed;
    background:#f5f3ff;
}

.orange .ticket-kpi-icon{
    color:#f59e0b;
    background:#fffbeb;
}

.ticket-kpi-value{
    margin-top:16px;
    color:#182230;
    font-size:38px;
    line-height:1;
    font-weight:700;
}

/* Anjali added clickable ticket summary counts 02-07-2026 */
.ticket-kpi-value a{
    color:inherit;
    text-decoration:none;
    cursor:pointer;
}

.ticket-kpi-value a:hover,
.ticket-kpi-value a:focus{
    color:#2563eb;
    text-decoration:underline;
}

.ticket-board-grid{
    display:grid;
    grid-template-columns:minmax(0, .9fr) minmax(0, 1.1fr);
    gap:16px;
    margin-bottom:18px;
}

.ticket-board-grid > *{
    min-width:0;
}

.ticket-panel{
    background:#ffffff;
    border:1px solid #e6ebf2;
    border-radius:8px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(31,45,61,.06);
    margin-bottom:18px;
}

.ticket-panel-head{
    padding:16px 18px;
    border-bottom:1px solid #edf1f6;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
}

.ticket-panel-title{
    color:#233043;
    font-size:17px;
    font-weight:700;
}

.ticket-panel-subtitle{
    color:#8a95a3;
    font-size:12px;
    margin-top:3px;
}

.ticket-summary-filter-group{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    justify-content:flex-end;
}

.ticket-panel-head .ticket-summary-inline-filter{
    min-width:140px;
}

.ticket-summary-inline-filter.search{
    min-width:220px;
}

.ticket-summary-inline-filter{
    position:relative;
}

.ticket-summary-inline-filter i{
    position:absolute;
    left:12px;
    top:50%;
    transform:translateY(-50%);
    color:#98a2b3;
}

.ticket-summary-inline-filter input{
    width:100%;
    height:36px;
    border:1px solid #d0d5dd;
    border-radius:6px;
    padding:8px 12px 8px 36px;
    font-size:13px;
    color:#344054;
    box-sizing:border-box;
}

.ticket-summary-inline-filter.search{
    min-width:240px;
}

.ticket-status-layout{
    display:grid;
    grid-template-columns:140px minmax(0, 1fr);
    align-items:center;
    gap:12px;
    min-height:240px;
    padding:24px 18px;
    box-sizing:border-box;
}

.ticket-donut{
    width:136px;
    height:136px;
    border-radius:50%;
    background:conic-gradient(#0f9f6e 0deg, #e5e7eb 0deg);
    display:flex;
    align-items:center;
    justify-content:center;
}

.ticket-donut-inner{
    width:88px;
    height:88px;
    border-radius:50%;
    background:#ffffff;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    color:#667085;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
}

.ticket-donut-total{
    color:#182230;
    font-size:28px;
    line-height:1;
    margin-bottom:5px;
}

.ticket-status-list,
.ticket-employee-bars{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.ticket-employee-bars{
    width:100%;
    max-height:min(300px, 45vh);
    overflow-y:auto;
    overflow-x:hidden;
    -webkit-overflow-scrolling:touch;
    padding-left:15px;
    padding-right:10px;
    scrollbar-gutter:stable;
}

.ticket-employee-bars::-webkit-scrollbar{
    width:6px;
}

.ticket-employee-bars::-webkit-scrollbar-track{
    background:#eef2f7;
    border-radius:999px;
}

.ticket-employee-bars::-webkit-scrollbar-thumb{
    background:#cbd5e1;
    border-radius:999px;
}



    .ticket-status-item,
.ticket-employee-bar-row{
    display:grid;
    grid-template-columns:180px minmax(0, 1fr) 42px;
    align-items:center;
    gap:10px;
    color:#475467;
    font-size:13px;
}

.ticket-status-list{
    width:100%;
}

.ticket-status-item{
    grid-template-columns:95px minmax(100px, 1fr) 38px;
    gap:8px;
}



.ticket-status-dot{
    width:10px;
    height:10px;
    border-radius:50%;
    display:inline-block;
    margin-right:7px;
}

.ticket-track{
    height:8px;
    border-radius:999px;
    background:#eef2f7;
    overflow:hidden;
}

.ticket-fill{
    height:100%;
    border-radius:999px;
    width:0%;
    transition:width .3s ease;
}

.status-open{
    background:#0f9f6e;
}

.status-resolved{
    background:#7c3aed;
}

.status-closed{
    background:#f59e0b;
}

.status-reopened{
    background:#14b8a6;
}

.status-deactivated{
    background:#ef4444;
}

.employee-bar-name{
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
}

/* .ticket-table-wrap{
    overflow:auto;
    max-height:390px;
} */
    /*
    ======================================================
    Changes by Shawn Arakal
    Date: 2026-07-27
    Time: 14:43
    Feature: Employee Ticket Performance Tracking
    ======================================================
    */
    /* Changes by Shawn Arakal - 2026-07-27 18:21: Issue 6 - keep the horizontal scrollbar and add smooth momentum scrolling on touch devices; desktop layout unchanged. */
    .ticket-table-wrap{
    height:390px;
    overflow-y:auto;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}
.ticket-data-table thead th{
    position:sticky;
    top:0;
    z-index:20;
    background:#f8fafc;
}

.ticket-data-table{
    width:100%;
    border-collapse:collapse;
}

.ticket-data-table th{
    background:#f8fafc;
    color:#667085;
    padding:13px 14px;
    text-align:left;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    border-bottom:1px solid #e6ebf2;
    white-space:nowrap;
}

.ticket-data-table td{
    color:#344054;
    padding:13px 14px;
    border-bottom:1px solid #edf1f6;
    vertical-align:middle;
}

.ticket-data-table tbody tr:hover{
    background:#f9fbfd;
}

.ticket-empty{
    padding:34px 15px;
    color:#8a95a3;
    text-align:center;
}

.ticket-status-pill{
    display:inline-block;
    min-width:76px;
    border-radius:999px;
    padding:4px 10px;
    font-size:12px;
    font-weight:700;
    text-align:center;
    background:#eef2f7;
    color:#475467;
}

.ticket-status-pill.open{
    background:#ecfdf5;
    color:#047857;
}

.ticket-status-pill.resolved{
    background:#f5f3ff;
    color:#6d28d9;
}

.ticket-status-pill.closed{
    background:#fffbeb;
    color:#b45309;
}

@media(max-width:991px){
    .ticket-summary-header,
    .ticket-status-layout{
        align-items:flex-start;
        flex-direction:column;
    }

    .ticket-kpi-grid,
    .ticket-board-grid{
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }

    .ticket-status-layout{
        display:flex;
        flex-direction:column;
    }
    /* .ticket-summary-filter-group{
    display:flex;
    align-items:center;
    gap:10px;
} */
}

@media(max-width:767px){
    .ticket-board-grid{
        grid-template-columns:1fr;
    }

    .ticket-employee-bar-row{
        grid-template-columns:minmax(100px, 34%) minmax(90px, 1fr) 30px;
        gap:8px;
    }

    .ticket-employee-bars{
        padding-left:0;
        padding-right:6px;
    }
}

@media(max-width:576px){
    .ticket-summary-page{
        padding:14px;
    }

    .ticket-kpi-grid,
    .ticket-board-grid{
        grid-template-columns:1fr;
    }

    .ticket-filter,
    .ticket-date-input,
    .ticket-refresh-btn,
    .ticket-summary-inline-filter{
        width:100%;
    }

    .ticket-panel-head{
        align-items:flex-start;
    }

    .ticket-employee-bar-row{
        grid-template-columns:minmax(80px, 38%) minmax(70px, 1fr) 26px;
        font-size:12px;
        gap:6px;
    }
    
}


</style>


<div class="page-content-wrapper">
    <div class="page-content">


        <div class="ticket-summary-page">
            <div class="ticket-summary-header">
                <div>
                    <h1 class="ticket-summary-title">Ticket Summary Report</h1>
                    <div class="ticket-summary-subtitle">Monthly ticket status, employee load, and activity details</div>
                </div>

                <div class="ticket-filter">
                    <span class="ticket-filter-label">Period</span>
                    <div class="ticket-date-field">
                        <i class="fa fa-calendar"></i>
                        <input class="datepickerMY ticket-date-input" id="month_year" type="text" placeholder="MM-YYYY" readonly>
                    </div>
                    <button type="button" class="ticket-refresh-btn" id="ticket_report_refresh">
                        <i class="fa fa-refresh"></i> View
                    </button>
                </div>
            </div>

            <div class="ticket-kpi-grid">
                <div class="ticket-kpi-card blue">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Total Tickets</div>
                        <div class="ticket-kpi-icon"><i class="fa fa-ticket"></i></div>
                    </div>
                    <div class="ticket-kpi-value"><a class="ticket-summary-count-link" id="total_tickets" href="<?php echo get_module_path(); ?>customers/ticket_report">0</a></div>
                </div>

                <div class="ticket-kpi-card green">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Open Tickets</div>
                        <div class="ticket-kpi-icon"><i class="fa fa-folder-open"></i></div>
                    </div>
                    <div class="ticket-kpi-value"><a class="ticket-summary-count-link" id="open_tickets" href="<?php echo get_module_path(); ?>customers/ticket_report?status=Open">0</a></div>
                </div>

                <div class="ticket-kpi-card orange">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Reopened Tickets</div>
                        <div class="ticket-kpi-icon"><i class="fa fa-lock"></i></div>
                    </div>
                    <div class="ticket-kpi-value"><a class="ticket-summary-count-link" id="reopened_tickets" href="<?php echo get_module_path(); ?>customers/ticket_report?status=Reopened">0</a></div>
                </div>

                <div class="ticket-kpi-card purple">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Resolved Tickets</div>
                        <div class="ticket-kpi-icon"><i class="fa fa-check-circle"></i></div>
                    </div>
                    <div class="ticket-kpi-value"><a class="ticket-summary-count-link" id="resolved_tickets" href="<?php echo get_module_path(); ?>customers/ticket_report?status=Resolved">0</a></div>
                </div>

                <div class="ticket-kpi-card orange">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Closed Tickets</div>
                        <div class="ticket-kpi-icon"><i class="fa fa-lock"></i></div>
                    </div>
                    <div class="ticket-kpi-value"><a class="ticket-summary-count-link" id="closed_tickets" href="<?php echo get_module_path(); ?>customers/ticket_report?status=Closed">0</a></div>
                </div>
                <div class="ticket-kpi-card blue">
                    <div class="ticket-kpi-top">
                        <div class="ticket-kpi-label">Deactivated Tickets</div>
                        <div class="ticket-kpi-icon"><i class="fa fa-lock"></i></div>
                    </div>
                    <div class="ticket-kpi-value"><a class="ticket-summary-count-link" id="deactivated_tickets" href="<?php echo get_module_path(); ?>customers/ticket_report?status=Deactivated">0</a></div>
                </div>
            </div>

            <?php /* Changes by Shawn Arakal - 28/07/2026 11:02: performance dashboard cards (Average/Fastest/Slowest/Top Performer) removed; dashboard restored to its original layout. Detailed performance now lives in View Stats. */ ?>

            <div class="ticket-board-grid">
                <div class="ticket-panel">
                    <div class="ticket-panel-head">
                        <div>
                            <div class="ticket-panel-title">Ticket Status Distribution</div>
                            <div class="ticket-panel-subtitle">Open vs Re-Opened vs resolved vs closed vs deactivated</div>
                        </div>
                    </div>
                    <div class="ticket-panel-body">
                        <div class="ticket-status-layout">
                            <div class="ticket-donut" id="ticket_status_chart">
                                <div class="ticket-donut-inner">
                                    <span class="ticket-donut-total" id="ticket_donut_total">0</span>
                                    Total
                                </div>
                            </div>
                            <div class="ticket-status-list">
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-open"></i>Open</span>
                                    <div class="ticket-track"><div class="ticket-fill status-open" id="open_ticket_fill"></div></div>
                                    <strong id="open_ticket_percent">0%</strong>
                                </div>
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-reopened"></i>Re-Opened</span>
                                    <div class="ticket-track"><div class="ticket-fill status-reopened" id="reopened_ticket_fill"></div></div>
                                    <strong id="reopened_ticket_percent">0%</strong>
                                </div>
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-resolved"></i>Resolved</span>
                                    <div class="ticket-track"><div class="ticket-fill status-resolved" id="resolved_ticket_fill"></div></div>
                                    <strong id="resolved_ticket_percent">0%</strong>
                                </div>
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-closed"></i>Closed</span>
                                    <div class="ticket-track"><div class="ticket-fill status-closed" id="closed_ticket_fill"></div></div>
                                    <strong id="closed_ticket_percent">0%</strong>
                                </div>
                                <div class="ticket-status-item">
                                    <span><i class="ticket-status-dot status-deactivated"></i>Deactivated</span>
                                    <div class="ticket-track"><div class="ticket-fill status-deactivated" id="deactivated_ticket_fill"></div></div>
                                    <strong id="deactivated_ticket_percent">0%</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ticket-panel">
                    <div class="ticket-panel-head">
                        <div>
                            <div class="ticket-panel-title">Employee Wise Open and Reopened Tickets</div>
                            <div class="ticket-panel-subtitle">Top assignee workload</div>
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
            <div class="ticket-panel-title">Employee Ticket Summary</div>
        </div>
        
        <div class="ticket-summary-filter-group">
            <div class="ticket-summary-inline-filter">
                <i class="fa fa-calendar"></i>
                <input type="text" class="datepickerD" id="summary_from_date" placeholder="Start date" readonly>
            </div>

            <div class="ticket-summary-inline-filter">
                <i class="fa fa-calendar"></i>
                <input type="text" class="datepickerD" id="summary_to_date" placeholder="End date" readonly>
            </div>

            <div class="ticket-summary-inline-filter search">
                <i class="fa fa-search"></i>
                <input type="text" id="employee_summary_filter" placeholder="Search employee name">
            </div>

            <!-- Changes by Shawn Arakal - 2026-07-27 18:21: Issue 7 - Refresh reloads Employee Performance via AJAX (no full page reload). -->
            <button type="button" class="ticket-refresh-btn" id="employee_perf_refresh" title="Reload employee performance data">
                <i class="fa fa-refresh"></i> Refresh
            </button>
        </div>

    </div>
                <div class="ticket-table-wrap">
                    <table class="ticket-data-table">
                        <thead>
                            <tr>
                                <th>Sr.no</th>
                                <th>Employee</th>
                                <th>Total</th>
                                <th>Open</th>
                                <th>Reopened</th>
                                <th>Resolved</th>
                                <th>Closed</th>
                                <th>Deactivated</th>
                                <?php /* Changes by Shawn Arakal - 28/07/2026 11:02: Average/Fastest/Slowest Resolution columns removed - original columns restored. */ ?>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="employee_ticket_summary">
                            <tr><td colspan="6" class="ticket-empty">Loading summary...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<?php
/*
======================================================
Changes by Shawn Arakal
Date: 2026-07-27
Time: 11:13
Feature: Employee Ticket Performance Tracking
======================================================
*/
?>
<div class="modal fade" id="viewStatsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="view_stats_title">Employee Ticket History</h4>
            </div>
            <div class="modal-body">
                <?php
                /*
                ======================================================
                Changes by Shawn Arakal - 28/07/2026 11:02
                Feature: Employee Ticket Performance (View Stats performance page)
                ======================================================
                */
                // View Stats is now the full employee performance page. All values below are
                // loaded on demand (only for the clicked employee) via get_employee_performance_details().
                ?>
                <div class="vs-stat-grid" style="display:grid;grid-template-columns:repeat(3,minmax(120px,1fr));gap:10px;margin-bottom:16px;">
                    <div style="border:1px solid #e6ebf2;border-radius:6px;padding:10px 12px;background:#f8fafc;">
                        <div style="font-size:11px;text-transform:uppercase;color:#667085;font-weight:700;">Average Resolution</div>
                        <div id="vs_avg" style="font-size:18px;color:#182230;font-weight:700;margin-top:4px;">N/A</div>
                    </div>
                    <div style="border:1px solid #e6ebf2;border-radius:6px;padding:10px 12px;background:#f8fafc;">
                        <div style="font-size:11px;text-transform:uppercase;color:#667085;font-weight:700;">Fastest Resolution</div>
                        <div id="vs_fastest" style="font-size:18px;color:#182230;font-weight:700;margin-top:4px;">N/A</div>
                    </div>
                    <div style="border:1px solid #e6ebf2;border-radius:6px;padding:10px 12px;background:#f8fafc;">
                        <div style="font-size:11px;text-transform:uppercase;color:#667085;font-weight:700;">Slowest Resolution</div>
                        <div id="vs_slowest" style="font-size:18px;color:#182230;font-weight:700;margin-top:4px;">N/A</div>
                    </div>
                    <div style="border:1px solid #e6ebf2;border-radius:6px;padding:10px 12px;background:#f8fafc;">
                        <div style="font-size:11px;text-transform:uppercase;color:#667085;font-weight:700;">Closed Tickets</div>
                        <div id="vs_closed" style="font-size:18px;color:#182230;font-weight:700;margin-top:4px;">0</div>
                    </div>
                    <div style="border:1px solid #e6ebf2;border-radius:6px;padding:10px 12px;background:#f8fafc;">
                        <div style="font-size:11px;text-transform:uppercase;color:#667085;font-weight:700;">Resolved Tickets</div>
                        <div id="vs_resolved" style="font-size:18px;color:#182230;font-weight:700;margin-top:4px;">0</div>
                    </div>
                    <div style="border:1px solid #e6ebf2;border-radius:6px;padding:10px 12px;background:#f8fafc;">
                        <div style="font-size:11px;text-transform:uppercase;color:#667085;font-weight:700;">Current Rank</div>
                        <div id="vs_rank" style="font-size:18px;color:#182230;font-weight:700;margin-top:4px;">-</div>
                    </div>
                </div>

                <div style="font-weight:700;color:#233043;margin:10px 0 6px;">Ticket History</div>
                <div class="ticket-table-wrap" style="height:auto;max-height:300px;">
                    <table class="ticket-data-table">
                        <thead>
                            <tr>
                                <th>Ticket Number</th>
                                <th>Assigned Date</th>
                                <th>Closed Date</th>
                                <th>Resolution Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="view_stats_body">
                            <tr><td colspan="5" class="ticket-empty">No tickets found</td></tr>
                        </tbody>
                    </table>
                </div>

                <div style="font-weight:700;color:#233043;margin:16px 0 6px;">Top 3 Slowest Tickets</div>
                <div class="ticket-table-wrap" style="height:auto;max-height:240px;">
                    <table class="ticket-data-table">
                        <thead>
                            <tr>
                                <th>Ticket Number</th>
                                <th>Assigned Date</th>
                                <th>Closed Date</th>
                                <th>Resolution Time</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody id="view_stats_slowest">
                            <tr><td colspan="5" class="ticket-empty">No tickets found</td></tr>
                        </tbody>
                    </table>
                </div>

                <div style="font-weight:700;color:#233043;margin:16px 0 6px;">Top 3 Fastest Tickets</div>
                <div class="ticket-table-wrap" style="height:auto;max-height:240px;">
                    <table class="ticket-data-table">
                        <thead>
                            <tr>
                                <th>Ticket Number</th>
                                <th>Assigned Date</th>
                                <th>Closed Date</th>
                                <th>Resolution Time</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody id="view_stats_fastest">
                            <tr><td colspan="5" class="ticket-empty">No tickets found</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="ticket-perf-explain" style="margin-top:16px;padding:12px 14px;border:1px solid #e6ebf2;border-radius:6px;background:#f8fafc;color:#475467;font-size:12px;line-height:1.7;">
                    <div style="font-weight:700;color:#233043;margin-bottom:6px;">Performance Calculation</div>
                    <div><strong>Average Resolution Time</strong> = Total Resolution Days &divide; Completed Tickets (Closed + Resolved with a measurable duration)</div>
                    <div><strong>Fastest Resolution Time</strong> = Minimum Resolution Days</div>
                    <div><strong>Slowest Resolution Time</strong> = Maximum Resolution Days</div>
                    <div style="margin-top:6px;"><strong>Employee Ranking</strong> (the order of the Employee Ticket Summary table) = best to worst by: 1) lowest Average Resolution Time, 2) highest Completed Tickets (Closed + Resolved), 3) alphabetical if still tied. Employees with no completed tickets appear last.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}
window.scrollTo(0, 0);

window.addEventListener('load', function(){
    window.scrollTo(0, 0);
    // Anjali changed default ticket summary to overall count 02-07-2026
    $('#month_year').val('');

    /* Changes by Shawn Arakal - 28/07/2026 17:27 : Phase 1 - default End Date to today's date
       (still editable). Start Date stays empty, so the report loads all tickets up to today
       instead of only the current month. Picking a month or a custom range still overrides this. */
    if (!$('#summary_to_date').val()) {
        var _today_end = new Date();
        $('#summary_to_date').val(
            ('0' + _today_end.getDate()).slice(-2) + '-' +
            ('0' + (_today_end.getMonth() + 1)).slice(-2) + '-' +
            _today_end.getFullYear()
        );
    }

    if($.fn.datepicker){
        $('.datepickerMY').datepicker({
            format:'mm-yyyy',
            autoclose:true,
            todayHighlight:true,
            viewMode:'months',
            minViewMode:'months'
        }).on('changeDate', function(){

            $('#summary_from_date').val('');
            $('#summary_to_date').val('');

            load_ticket_summary_report();
        });

        $('.datepickerD').datepicker({
            format:'dd-mm-yyyy',
            autoclose:true,
            todayHighlight:true
        }).on('changeDate', function(){

            if($('#summary_from_date').val() != '' ||
            $('#summary_to_date').val() != ''){
                $('#month_year').val('');
            }

            load_ticket_summary_report();
        });
    }

    // $('#ticket_report_refresh').on('click', function(){
    //     load_ticket_summary_report();
    // });
    $('#ticket_report_refresh').on('click', function(){
        // Keep the selected month; blank means overall through today.
        load_ticket_summary_report();
    });

    // Changes by Shawn Arakal - 2026-07-27 18:21: Issue 7 - Refresh button reloads Employee
    // Performance (and the summary) via the existing AJAX call; no full page reload.
    $('#employee_perf_refresh').on('click', function(){
        load_ticket_summary_report();
    });

    $('#employee_summary_filter').on('keyup', filter_employee_summary_rows);

	// Keep the active summary period for KPI and employee-summary drill-down links.
    $(document).on('click', '.ticket-summary-count-link, #employee_ticket_summary a', function(event){
        var targetUrl = $(this).attr('href');
        var fromDate = $('#summary_from_date').val();
        var toDate = $('#summary_to_date').val();
        var monthYear = $('#month_year').val();

        if(!fromDate && !toDate && monthYear){
            var monthParts = monthYear.split('-');
            var month = parseInt(monthParts[0], 10);
            var year = parseInt(monthParts[1], 10);

            if(month && year){
                var lastDay = new Date(year, month, 0).getDate();
                fromDate = '01-' + ('0' + month).slice(-2) + '-' + year;
                toDate = ('0' + lastDay).slice(-2) + '-' + ('0' + month).slice(-2) + '-' + year;
            }
        }

		if(!fromDate && !toDate && !monthYear){
			var today = new Date();
			toDate = ('0' + today.getDate()).slice(-2) + '-' +
				('0' + (today.getMonth() + 1)).slice(-2) + '-' + today.getFullYear();
		}

        if(fromDate || toDate){
            event.preventDefault();
            targetUrl += targetUrl.indexOf('?') === -1 ? '?' : '&';
            targetUrl += 'from_date=' + encodeURIComponent(fromDate) + '&to_date=' + encodeURIComponent(toDate);
            window.location.href = targetUrl;
        }
    });

    /*
    ======================================================
    Changes by Shawn Arakal - 28/07/2026 11:02
    Feature: Employee Ticket Performance (View Stats - on demand)
    ======================================================
    */
    // View Stats loads ONLY the clicked employee's performance on demand (no preloaded history)
    // from customers/get_employee_performance_details. The Current Rank comes from the row's
    // position (data-rank), which reflects the server-side best->worst ranking.
    $(document).on('click', '.view-stats-btn', function(){
        var empId = $(this).attr('data-emp-id');
        var empName = $(this).attr('data-emp-name') || 'Employee';
        var rank = $(this).attr('data-rank') || '-';
        var loadingRow = '<tr><td colspan="5" class="ticket-empty">Loading...</td></tr>';

        $('#view_stats_title').text('Employee Performance - ' + empName);
        $('#vs_rank').text(rank);
        $('#vs_avg, #vs_fastest, #vs_slowest').text('N/A');
        $('#vs_closed, #vs_resolved').text('0');
        $('#view_stats_body, #view_stats_slowest, #view_stats_fastest').html(loadingRow);

        if($('#viewStatsModal').modal){
            $('#viewStatsModal').modal('show');
        } else {
            $('#viewStatsModal').show();
        }

        $.ajax({
            url: base_url + 'customers/get_employee_performance_details',
            type: 'POST',
            data: { emp_id: empId, emp_name: empName },
            dataType: 'json',
            success: function(resp){
                if(!resp || resp.status === false){
                    var errRow = '<tr><td colspan="5" class="ticket-empty">Unable to load performance</td></tr>';
                    $('#view_stats_body, #view_stats_slowest, #view_stats_fastest').html(errRow);
                    return;
                }

                var stats = resp.stats || {};
                $('#vs_avg').text(stats.avg_resolution || 'N/A');
                $('#vs_fastest').text(stats.fastest_resolution || 'N/A');
                $('#vs_slowest').text(stats.slowest_resolution || 'N/A');
                $('#vs_closed').text(ticket_number(stats.closed_tickets));
                $('#vs_resolved').text(ticket_number(stats.resolved_tickets));

                $('#view_stats_body').html(build_history_rows(resp.history, false));
                $('#view_stats_slowest').html(build_history_rows(resp.top_slowest, true));
                $('#view_stats_fastest').html(build_history_rows(resp.top_fastest, true));
            },
            error: function(){
                var errRow = '<tr><td colspan="5" class="ticket-empty">Unable to load performance</td></tr>';
                $('#view_stats_body, #view_stats_slowest, #view_stats_fastest').html(errRow);
            }
        });
    });

    load_ticket_summary_report();
});

function ticket_number(value){
    var number = parseInt(value, 10);
    return isNaN(number) ? 0 : number;
}

function ticket_percent(value, total){
    if(!total){
        return 0;
    }

    return Math.round((value / total) * 100);
}

function ticket_status_class(status){
    var cleanStatus = (status || '').toString().toLowerCase();

    if(cleanStatus.indexOf('open') !== -1){
        return 'open';
    }

    if(cleanStatus.indexOf('resolved') !== -1){
        return 'resolved';
    }
    if(cleanStatus.indexOf('reopen') !== -1){
        return 'reopened';
    }
    if(cleanStatus.indexOf('deactiv') !== -1){
        return 'deactivated';
    }

    if(cleanStatus.indexOf('closed') !== -1 || cleanStatus.indexOf('close') !== -1){
        return 'closed';
    }

    return '';
}

function ticket_html_escape(value){
    return $('<div/>').text(value || '').html();
}

/*
======================================================
Changes by Shawn Arakal - 28/07/2026 11:02
Feature: Employee Ticket Performance (View Stats - on demand)
======================================================
*/
// Builds ticket rows for the View Stats tables. withNotes=true renders a Notes column (Top 3
// slowest/fastest); withNotes=false renders the Status pill (Ticket History).
function build_history_rows(list, withNotes){
    if(!list || !list.length){
        return '<tr><td colspan="5" class="ticket-empty">No tickets found</td></tr>';
    }

    var html = '';
    $.each(list, function(index, ticket){
        html += '<tr>' +
            '<td>' + ticket_html_escape(ticket.ticket_no) + '</td>' +
            '<td>' + ticket_html_escape(ticket.assigned_date) + '</td>' +
            '<td>' + ticket_html_escape(ticket.closed_date ? ticket.closed_date : '-') + '</td>' +
            '<td>' + ticket_html_escape(ticket.resolution) + '</td>';

        if(withNotes){
            html += '<td>' + ticket_html_escape(ticket.notes ? ticket.notes : '-') + '</td>';
        } else {
            html += '<td><span class="ticket-status-pill ' + ticket_status_class(ticket.status) + '">' + ticket_html_escape(ticket.status) + '</span></td>';
        }

        html += '</tr>';
    });

    return html;
}

function ticket_first_value(data, keys, defaultValue){
    var i;

    for(i = 0; i < keys.length; i++){
        if(data && data[keys[i]] !== undefined && data[keys[i]] !== null && data[keys[i]] !== ''){
            return data[keys[i]];
        }
    }

    return defaultValue;
}

function update_ticket_charts(summary){
    var total = ticket_number(summary.total_tickets);
    var open = ticket_number(summary.open_tickets);
    var resolved = ticket_number(summary.resolved_tickets);
    var closed = ticket_number(summary.closed_tickets);
    var reopened = ticket_number(summary.reopened_tickets);
    var deactivated = ticket_number(summary.deactivated_tickets);
    var openDeg = total ? (open / total) * 360 : 0;
    var resolvedDeg = total ? (resolved / total) * 360 : 0;
    var openPercent = ticket_percent(open, total);
    var resolvedPercent = ticket_percent(resolved, total);
    var closedPercent = ticket_percent(closed, total);

    var reopenedPercent = ticket_percent(reopened, total);
    var deactivatedPercent = ticket_percent(deactivated, total);

    $('#total_tickets, #ticket_donut_total').text(total);
    $('#open_tickets').text(open);
    $('#reopened_tickets').text(reopened);
    $('#resolved_tickets').text(resolved);
    $('#closed_tickets').text(closed);
    $('#deactivated_tickets').text(deactivated);

    $('#open_ticket_fill').css('width', openPercent + '%');
    $('#resolved_ticket_fill').css('width', resolvedPercent + '%');
    $('#reopened_ticket_fill').css('width', reopenedPercent + '%');
    $('#deactivated_ticket_fill').css('width', deactivatedPercent + '%');
    $('#closed_ticket_fill').css('width', closedPercent + '%');
    $('#open_ticket_percent').text(openPercent + '%');
    $('#resolved_ticket_percent').text(resolvedPercent + '%');
    $('#reopened_ticket_percent').text(reopenedPercent + '%');
    $('#deactivated_ticket_percent').text(deactivatedPercent + '%');
    $('#closed_ticket_percent').text(closedPercent + '%');

    // $('#ticket_status_chart').css(
    //     'background',
    //     'conic-gradient(#0f9f6e 0deg '+openDeg+'deg, #7c3aed '+openDeg+'deg '+(openDeg + resolvedDeg)+'deg, #f59e0b '+(openDeg + resolvedDeg)+'deg 360deg)'
    // );
    var openDeg        = total ? (open / total) * 360 : 0;
    var reopenedDeg    = total ? (reopened / total) * 360 : 0;
    var resolvedDeg    = total ? (resolved / total) * 360 : 0;
    var closedDeg      = total ? (closed / total) * 360 : 0;
    var deactivatedDeg = total ? (deactivated / total) * 360 : 0;

    var p1 = openDeg;
    var p2 = p1 + reopenedDeg;
    var p3 = p2 + resolvedDeg;
    var p4 = p3 + closedDeg;
    var p5 = p4 + deactivatedDeg;

    $('#ticket_status_chart').css(
        'background',
        'conic-gradient(' +
        '#0f9f6e 0deg ' + p1 + 'deg,' +        // Open
        '#14b8a6 ' + p1 + 'deg ' + p2 + 'deg,' + // Reopened
        '#7c3aed ' + p2 + 'deg ' + p3 + 'deg,' + // Resolved
        '#f59e0b ' + p3 + 'deg ' + p4 + 'deg,' + // Closed
        '#ef4444 ' + p4 + 'deg ' + p5 + 'deg' +  // Deactivated
        ')'
    );
}

function update_employee_bars(employeeSummary){
    var html = '';
    var maxTotal = 0;
    var visibleEmployeeSummary = [];

    if(!employeeSummary || !employeeSummary.length){
        $('#emp_bars').html('<div class="ticket-empty">No data found</div>').scrollTop(0);
        return;
    }

    //visibleEmployeeSummary = employeeSummary.slice(0, 10);
    visibleEmployeeSummary = employeeSummary;

    // employeeSummary.sort(function(a, b){
    //     return parseInt(b.open_tickets || 0) -
    //         parseInt(a.open_tickets || 0);
    // });
    employeeSummary.sort(function(a, b){

        var aPending =
            parseInt(a.open_tickets || 0) +
            parseInt(a.reopened_tickets || 0);

        var bPending =
            parseInt(b.open_tickets || 0) +
            parseInt(b.reopened_tickets || 0);

        return bPending - aPending;
    });

    $.each(visibleEmployeeSummary, function(index, emp){
        // maxTotal = Math.max(maxTotal, ticket_number(emp.total_tickets));
        var pending = ticket_number(emp.open_tickets) +
              ticket_number(emp.reopened_tickets);

        maxTotal = Math.max(maxTotal, pending);
    });

    $.each(visibleEmployeeSummary, function(index, emp){
        // var total = ticket_number(emp.total_tickets);
        // var width = maxTotal ? Math.max(4, Math.round((total / maxTotal) * 100)) : 0;
        var pending = ticket_number(emp.open_tickets) +
              ticket_number(emp.reopened_tickets);

        var width = maxTotal
            ? Math.max(4, Math.round((pending / maxTotal) * 100))
            : 0;
        var name = ticket_html_escape(ticket_first_value(emp, ['employee_name', 'emp_name'], 'N/A'));

        html += '<div class="ticket-employee-bar-row">';
        html += '<span class="employee-bar-name" title="'+name+'">'+name+'</span>';
        html += '<div class="ticket-track"><div class="ticket-fill status-open" style="width:'+width+'%"></div></div>';
        // html += '<strong>'+total+'</strong>';
        html += '<strong>'+pending+'</strong>';
        html += '</div>';
    });

    $('#emp_bars').html(html).scrollTop(0);
}

function filter_employee_summary_rows(){
    var query = ($('#employee_summary_filter').val() || '').toLowerCase().trim();

    $('#employee_ticket_summary tr').each(function(){
        var row = $(this);
        var cells = row.find('td');

        if(cells.length <= 1){
            return;
        }

        var employeeName = cells.eq(1).text().toLowerCase();
        var matches = !query || employeeName.indexOf(query) !== -1;
        row.toggle(matches);
    });
}

function build_summary_from_response(dataObj){
    var ticketList = dataObj.ticket_list || dataObj.tickets || [];
    var employeeSummary = dataObj.employee_summary || dataObj.employee_ticket_summary || [];
    // var summary = {
    //     total_tickets: ticket_number(ticket_first_value(dataObj, ['total_tickets', 'total'], 0)),
    //     open_tickets: ticket_number(ticket_first_value(dataObj, ['open_tickets', 'open'], 0)),
    //     reopened_tickets: ticket_number(ticket_first_value(dataObj, ['reopened_tickets', 'reopened'], 0)),
    //     resolved_tickets: ticket_number(ticket_first_value(dataObj, ['resolved_tickets', 'resolved'], 0)),
    //     closed_tickets: ticket_number(ticket_first_value(dataObj, ['closed_tickets', 'closed'], 0)),
        
    //     deactivated_tickets: ticket_number(ticket_first_value(dataObj, ['deactivated_tickets', 'deactivated'], 0))
    // };

    var dashboard = dataObj.dashboard || {};

    var summary = {
        total_tickets: ticket_number(dashboard.total_tickets),
        open_tickets: ticket_number(dashboard.open_tickets),
        reopened_tickets: ticket_number(dashboard.reopened_tickets),
        resolved_tickets: ticket_number(dashboard.resolved_tickets),
        closed_tickets: ticket_number(dashboard.closed_tickets),
        deactivated_tickets: ticket_number(dashboard.deactivated_tickets)
    };

    if(!summary.total_tickets && employeeSummary.length){
        $.each(employeeSummary, function(index, emp){
            summary.total_tickets += ticket_number(ticket_first_value(emp, ['total_tickets', 'total'], 0));
            summary.open_tickets += ticket_number(ticket_first_value(emp, ['open_tickets', 'open'], 0));
            summary.reopened_tickets += ticket_number(ticket_first_value(emp, ['reopened_tickets', 'reopened'], 0));
            summary.resolved_tickets += ticket_number(ticket_first_value(emp, ['resolved_tickets', 'resolved'], 0));
            summary.closed_tickets += ticket_number(ticket_first_value(emp, ['closed_tickets', 'closed'], 0));
            
            summary.deactivated_tickets += ticket_number(ticket_first_value(emp, ['deactivated_tickets', 'deactivated'], 0));
        });
    }

    if(!summary.total_tickets && ticketList.length){
        summary.total_tickets = ticketList.length;

        $.each(ticketList, function(index, ticket){
            var statusClass = ticket_status_class(ticket_first_value(ticket, ['ticket_status', 'status'], ''));

            if(statusClass === 'open'){
                summary.open_tickets++;
            }else if(statusClass === 'resolved'){
                summary.resolved_tickets++;
            }else if(statusClass === 'closed'){
                summary.closed_tickets++;
            }else if(statusClass === 'reopened'){
                summary.reopened_tickets++;
            }else if(statusClass === 'deactivated'){
                summary.deactivated_tickets++;
            }
        });
    }

    return summary;
}

function load_ticket_summary_report(){
    console.log('Calling report');
    console.log($('#month_year').val());
    console.log($('#summary_from_date').val());
    console.log($('#summary_to_date').val());
    $('.loader').fadeIn();

    $.ajax({
        url:base_url + 'customers/get_ticket_summary_report',
        type:'POST',
        data:{
            month_year:$('#month_year').val(),
            from_date:$('#summary_from_date').val(),
            to_date:$('#summary_to_date').val()
        },
        dataType:'json',
        success:function(response){
            var result = response.result || {};
            var dataObj = response.data || result || {};

            if(!response.data && result.jsArray && result.jsArray.length){
                dataObj = result.jsArray[0] || {};
            }

            $('#employee_ticket_summary').html(response.employee_html || '<tr><td colspan="6" class="ticket-empty">No Data Found</td></tr>');

            update_ticket_charts(build_summary_from_response(dataObj));
            update_employee_bars(dataObj.employee_summary || dataObj.employee_ticket_summary || []);
			$('#employee_ticket_summary').closest('.ticket-table-wrap').scrollTop(0);
            filter_employee_summary_rows();
            // Changes by Shawn Arakal - 28/07/2026 11:02: performance cards removed; nothing to render at page load.
            $('.loader').fadeOut();
        },
        error:function(){
            $('#employee_ticket_summary').html('<tr><td colspan="6" class="ticket-empty">Unable to load summary</td></tr>');
            update_ticket_charts({});
            update_employee_bars([]);
            $('.loader').fadeOut();
        }
    });
}

/*
======================================================
Changes by Shawn Arakal - 28/07/2026 11:02
Feature: Employee Ticket Performance (final architecture)
======================================================
*/
// render_ticket_performance() and the preloaded ticketEmployeePerformance map were removed.
// Performance is no longer shown on the dashboard/table; it loads on demand in View Stats.

</script>
