<style>
    .roi-dashboard {
        background: #f4f6fb;
    }

    /* KPI */

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e4e9f2;
        border-radius: 10px;
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(44, 62, 107, .08);
        position: relative;
        overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(44, 62, 107, .12);
    }

    .kpi-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 10px 10px 0 0;
    }

    .kpi-card.blue::after {
        background: linear-gradient(90deg, #3da9e8, #6eb5f5);
    }

    .kpi-card.green::after {
        background: linear-gradient(90deg, #26c6b0, #5de8d8);
    }

    .kpi-card.purple::after {
        background: linear-gradient(90deg, #7c6fff, #b09fff);
    }

    .kpi-card.orange::after {
        background: linear-gradient(90deg, #f6a623, #f9c36a);
    }

    .kpi-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .kpi-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: var(--text-mid);
        font-weight: 600;
    }

    .kpi-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: grid;
        place-items: center;
    }

    .kpi-icon svg {
        width: 17px;
        height: 17px;
    }

    .kpi-card.blue .kpi-icon {
        background: #ebf6fd;
        color: #3da9e8;
    }

    .kpi-card.green .kpi-icon {
        background: #e8faf8;
        color: #26c6b0;
    }

    .kpi-card.purple .kpi-icon {
        background: #f0eeff;
        color: #7c6fff;
    }

    .kpi-card.orange .kpi-icon {
        background: #fef7eb;
        color: #f6a623;
    }

    .kpi-foot {
        margin-top: 9px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: var(--text-lo);
    }

    .up {
        color: var(--green);
        font-weight: 600;
    }

    .down {
        color: var(--coral);
        font-weight: 600;
    }


    .kpi-value {
        font-size: 40px;
        font-weight: 00;
    }


    .kpi-trend {
        font-size: 12px;
        margin-top: 6px;
    }



    /* FILTER */

    .filter-bar {
        background: #ffffff;
        border: 1px solid #e4e9f2;
        border-radius: 10px;
        padding: 13px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(44, 62, 107, .08);
    }

    .filter-label-text {
        font-size: 11px;
        letter-spacing: .8px;
        text-transform: uppercase;
        font-weight: 600;
        color: #5a6888;
    }

    .date-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .date-wrap i {
        position: absolute;
        left: 10px;
        font-size: 13px;
        color: #26c6b0;
    }

    .date-input {
        padding: 7px 12px 7px 32px;
        border: 1px solid #e4e9f2;
        border-radius: 7px;
        font-size: 13px;
    }

    .filter-sep {
        width: 1px;
        height: 22px;
        background: #e4e9f2;
    }


    /* PANELS */

    .panel {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
        margin-bottom: 20px;
    }

    .panel-head {
        padding: 16px 18px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .panel-title {
        font-weight: 600;
    }

    .panel-sub {
        font-size: 12px;
        color: #94a3b8;
    }

    .panel-body {
        padding: 20px;
    }

    /* CHART GRID */

    .chart-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }


    /* EMPLOYEE BAR */

    .bar-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .bar-name {
        width: 120px;
        font-size: 13px;
    }

    .bar-track {
        flex: 1;
        height: 8px;
        background: #e5e7eb;
        border-radius: 4px;
    }

    .bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #26c6b0, #3da9e8);
        border-radius: 4px;
    }

    .bar-count {
        width: 30px;
        text-align: right;
        font-weight: 600;
    }


    /* TABLE */

    .tbl-scroll {
        max-height: 280px;
        overflow-y: auto;
    }

    .tbl-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .tbl-scroll::-webkit-scrollbar-thumb {
        background: #e4e9f2;
        border-radius: 2px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: #f8faff;
        font-size: 11px;
        text-transform: uppercase;
        padding: 10px;
    }

    .data-table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .panel-body1 thead {
        position: sticky;
        top: 0;
        text-transform: uppercase;
        letter-spacing: .7px;
        padding: 10px 16px;
        text-align: left;
        border-bottom: 1px solid #e4e9f2;
    }

    /* STATUS BADGE */

    .pill {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .pill.active {
        background: #fff3e0;
        color: #f59e0b;
    }

    .pill.approved {
        background: #e3f2fd;
        color: #2196f3;
    }

    .pill.converted {
        background: #e6fffa;
        color: #26c6b0;
    }

    .chart-empty {
        height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #9aa3bc;
        font-size: 13px;
        gap: 8px;
    }

    .chart-empty i {
        font-size: 28px;
        opacity: .4;
    }

    .donut-wrap {
        display: flex;
        align-items: center;
        gap: 30px;
    }

    .donut-svg {
        width: 150px;
        height: 150px;
    }

    .donut-legend {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .leg-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .leg-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .leg-dot.active {
        background: #26c6b0;
    }

    .leg-dot.approved {
        background: #3da9e8;
    }

    .leg-name {
        font-size: 12px;
        font-weight:bold; 
        color: #5a6888;
    }

    .leg-val {
        font-size: 20px;
        font-weight: 700;
    }

    .leg-pct {
        font-size: 12px;
        font-weight: 600;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(14px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    .kpi-card {
        animation: fadeUp .4s ease both;
    }

    .kpi-card:nth-child(1) {
        animation-delay: .04s
    }

    .kpi-card:nth-child(2) {
        animation-delay: .09s
    }

    .kpi-card:nth-child(3) {
        animation-delay: .14s
    }

    .kpi-card:nth-child(4) {
        animation-delay: .19s
    }

    @media(max-width:1100px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr)
        }
    }
</style>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="roi-dashboard">

            <!-- FILTER -->

            <div class="filter-bar">
                <span class="filter-label-text">PERIOD</span>
                <div class="filter-sep"></div>
                <div class="date-wrap">
                    <i class="fa fa-calendar"></i>
                    <input
                        class="datepickerMY date-input"
                        id="month_year"
                        type="text"
                        placeholder="MM-YYYY">
                </div>
            </div>

            <div class="kpi-grid">

                <div class="kpi-card blue">
                    <div class="kpi-top">
                        <div class="kpi-label">Total Leads</div>
                        <div class="kpi-icon"><i class="fa fa-users"></i></div>
                    </div>
                    <div class="kpi-value" id="total_leads">0</div>
                </div>

                <div class="kpi-card green">
                    <div class="kpi-top">
                        <div class="kpi-label">Approved Leads</div>
                        <div class="kpi-icon"><i class="fa fa-check"></i></div>
                    </div>
                    <div class="kpi-value" id="approved_leads">0</div>
                </div>

                <div class="kpi-card purple">
                    <div class="kpi-top">
                        <div class="kpi-label">Converted</div>
                        <div class="kpi-icon"><i class="fa fa-check-circle"></i></div>
                    </div>
                    <div class="kpi-value" id="converted_customers">0</div>
                </div>

                <div class="kpi-card orange">
                    <div class="kpi-top">
                        <div class="kpi-label">Conversion Rate</div>
                        <div class="kpi-icon"><i class="fa fa-dollar"></i></div>
                    </div>
                    <div class="kpi-value" id="conversion_rate">0%</div>
                </div>

            </div>

            <!-- CHARTS -->

            <div class="chart-row">

                <div class="panel">

                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Lead Status Distribution</div>
                            <div class="panel-sub">Active vs Approved</div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="donut-wrap">

                            <svg class="donut-svg" viewBox="0 0 148 148">

                                <circle cx="74" cy="74" r="54"
                                    fill="none"
                                    stroke="#e4e9f2"
                                    stroke-width="20" />

                                <circle id="d_active"
                                    cx="74" cy="74" r="54"
                                    fill="none"
                                    stroke="#26c6b0"
                                    stroke-width="20"
                                    stroke-dasharray="0 339"
                                    stroke-linecap="round"
                                    transform="rotate(-90 74 74)" />

                                <circle id="d_approved"
                                    cx="74" cy="74" r="54"
                                    fill="none"
                                    stroke="#3da9e8"
                                    stroke-width="20"
                                    stroke-dasharray="0 339"
                                    stroke-linecap="round"
                                    transform="rotate(-90 74 74)" />

                                <text id="d_total"
                                    x="74"
                                    y="69"
                                    text-anchor="middle"
                                    font-size="22"
                                    font-weight="700">0</text>

                                <text
                                    x="74"
                                    y="85"
                                    text-anchor="middle"
                                    font-size="10"
                                    fill="#9aa3bc">Total Leads</text>

                            </svg>


                            <div class="donut-legend">
                                <div class="leg-item">
                                    <div class="leg-dot active"></div>
                                    <div>
                                        <div class="leg-name">Active</div>
                                        <div class="leg-val" id="l_active">0</div>
                                        <div class="leg-pct" id="l_active_pct">0%</div>
                                    </div>
                                </div>
                                <div class="leg-item">
                                    <div class="leg-dot approved"></div>
                                    <div>
                                        <div class="leg-name">Approved</div>
                                        <div class="leg-val" id="l_approved">0</div>
                                        <div class="leg-pct" id="l_approved_pct">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="panel">

                    <div class="panel-head">
                        <div>
                            <div class="panel-title">Employee Performance</div>
                            <div class="panel-sub">Leads handled per employee</div>
                        </div>
                    </div>

                    <div class="panel-body tbl-scroll">
                        <div id="emp_bars"></div>
                    </div>

                </div>

            </div>


            <!-- LEAD TABLE -->

            <div class="panel">

                <div class="panel-head">
                    <div>
                        <div class="panel-title">Lead Activity Log</div>
                        <div class="panel-sub">All leads for selected period</div>
                    </div>
                </div>

                <div class="panel-body1 tbl-scroll">

                    <table class="data-table">

                        <thead>
                            <tr>
                                <th style="padding-left:25px;">#</th>
                                <th>Employee</th>
                                <th>Lead Name</th>
                                <th>Status</th>
                                <th>Reference</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody id="roi_table_body"></tbody>

                    </table>

                </div>

            </div>



            <!-- ROI TABLES -->

            <div class="chart-row">

                <div class="panel">

                    <div class="panel-head">
                        <div class="panel-title">Employee ROI</div>
                    </div>

                    <div class="panel-body1 tbl-scroll">

                        <table class="data-table">

                            <thead>
                                <tr>
                                    <th style="padding-left:25px;">#</th>
                                    <th >Employee</th>
                                    <th>Leads</th>
                                    <th>Approved</th>
                                    <th>Converted</th>
                                </tr>
                            </thead>

                            <tbody id="employee_roi_table"></tbody>

                        </table>

                    </div>

                </div>


                <div class="panel">

                    <div class="panel-head">
                        <div class="panel-title">Reference ROI</div>
                    </div>

                    <div class="panel-body1 tbl-scroll">

                        <table class="data-table">

                            <thead>
                                <tr>
                                    <th style="padding-left:25px;">#</th>
                                    <th >Reference</th>
                                    <th>Leads</th>
                                    <th>Approved</th>
                                    <th>Converted</th>
                                </tr>
                            </thead>

                            <tbody id="reference_roi_table"></tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo get_assets_path(); ?>admin_theme/global/plugins/jquery.min.js"></script>

<script src="<?php echo get_assets_path(); ?>js/charts/core.js"></script>
<script src="<?php echo get_assets_path(); ?>js/charts/charts.js"></script>
<script src="<?php echo get_assets_path(); ?>js/charts/animated.js"></script>



<script>
    $(document).ready(function() {

        $('.datepickerMY').datepicker({
            format: 'mm-yyyy',
            autoclose: true,
            viewMode: "months",
            minViewMode: "months"
        });

        $('.datepickerMY').datepicker("setDate", new Date())
            .on('changeDate', function() {
                load_roi_data($("#month_year").val());
            });

        load_roi_data($("#month_year").val());

    });



    function load_roi_data(month) {

        $.ajax({

            url: base_url + "ajax/get_roi_report",

            type: "POST",

            data: {
                month_year: month
            },

            success: function(response) {

                var data = JSON.parse(response);

                $("#roi_table_body").html(data.list);
                $("#employee_roi_table").html(data.employee_roi);
                $("#reference_roi_table").html(data.reference_roi);

                var api = data.result.jsArray[0];

                var leadList = api.lead_list;
                var empROI = api.employee_roi;


                /* KPI */

                var totalLeads = leadList.length;

                var approved = 0;
                var converted = 0;

                empROI.forEach(function(emp) {

                    approved += parseInt(emp.approved_leads);
                    converted += parseInt(emp.converted_customers);

                });

                $("#total_leads").text(totalLeads);
                $("#approved_leads").text(approved);
                $("#converted_customers").text(converted);

                var rate = 0;

                if (totalLeads > 0) {

                    rate = ((converted / totalLeads) * 100).toFixed(1);

                }

                $("#conversion_rate").text(rate + "%");


                /* STATUS CHART */

                var active = totalLeads - approved;

                if (totalLeads == 0) {

                    $("#statusChart").hide();
                    $("#statusChartEmpty").show();

                } else {

                    $("#statusChart").show();
                    $("#statusChartEmpty").hide();

                    renderStatusChart(active, approved);

                }


                /* EMPLOYEE BARS */

                var empData = [];

                empROI.forEach(function(emp) {

                    empData.push({
                        employee: emp.emp_name,
                        leads: emp.total_leads
                    });

                });

                renderEmployeeBars(empData);

            }

        });

    }


    function renderStatusChart(active, approved) {

        var total = active + approved;

        var circumference = 2 * Math.PI * 54;

        $("#d_total").text(total);

        $("#l_active").text(active);
        $("#l_approved").text(approved);

        if (total > 0) {

            var activePercent = active / total;
            var approvedPercent = approved / total;

            $("#l_active_pct").text((activePercent * 100).toFixed(1) + "%");
            $("#l_approved_pct").text((approvedPercent * 100).toFixed(1) + "%");

            $("#d_active").attr(
                "stroke-dasharray",
                (activePercent * circumference) + " " + circumference
            );

            $("#d_approved").attr(
                "stroke-dasharray",
                (approvedPercent * circumference) + " " + circumference
            );

            $("#d_approved").css(
                "stroke-dashoffset",
                -(activePercent * circumference)
            );

        }

    }



    /* EMPLOYEE BAR CHART */

    function renderEmployeeBars(empData) {

        var max = Math.max(...empData.map(e => e.leads));

        var html = "";

        empData.forEach(function(emp) {

            var percent = (emp.leads / max) * 100;

            html += `

<div class="bar-row">

<div class="bar-name"><span title="${emp.employee}" style="display:inline-block;max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">${emp.employee}</sapn></div>

<div class="bar-track">
<div class="bar-fill" style="width:${percent}%"></div>
</div>

<div class="bar-count">${emp.leads}</div>

</div>

`;

        });

        $("#emp_bars").html(html);

    }
</script>