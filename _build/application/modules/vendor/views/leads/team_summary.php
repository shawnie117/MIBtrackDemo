<?php 
$role_id = $this->session->userdata('user_role_id');
$teamData = json_encode($team_leads);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <h2 style="text-align: center; margin-bottom: 20px;">Team Summary</h2>
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <div style="display: flex; flex-direction: column; align-items: center; position: relative;" id="teamTree"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const data = <?php echo $teamData; ?>;

    // 🔹 Recursive function to get the total sum of leads under a Team Lead
    function getTotalLeads(team, managerId) {
        let totalLeads = 0;

        if (team[managerId]) {
            team[managerId].forEach(employee => {
                totalLeads += Number(employee.total_leads); // Own leads
                
                // Recursively add leads from subordinates
                totalLeads += getTotalLeads(team, employee.user_id);
            });
        }
        return totalLeads;
    }

    function buildTree(data, parentElement) {
        let ul = $('<ul style="display: flex; flex-direction: column; align-items: center; padding-top: 20px; position: relative;">').appendTo(parentElement);

        data.forEach(team => {
            let teamLead = team.key;
            let employees = team.value;

            let leadLi = $('<li style="list-style-type: none; text-align: center; position: relative; padding: 20px;">').appendTo(ul);

            // 🔹 Calculate total leads including subordinates
            let totalLeads = Object.keys(employees).reduce((sum, managerId) => sum + getTotalLeads(employees, managerId), 0);
            totalLeads += Number(teamLead.total_leads) || 0;

            // 🔹 Team Lead Box with Own & Total Leads
            let leadDiv = $('<div style="display: inline-block; padding: 10px 20px; border: 2px solid #000; border-radius: 10px; background: #fff; font-weight: bold; position: relative;">')
                .html(`${teamLead.user_person_name} <br> (Own Leads: ${teamLead.total_leads} | Total: ${totalLeads})`)
                .appendTo(leadLi);

                let employeeWrapper = $('<div style="display: flex; justify-content: center; align-items: center; position: relative; margin-top: 20px; overflow-x: auto; white-space: nowrap; max-width: 65vw; padding-bottom: 10px; scroll-behavior: auto; cursor: grab;">')
    .appendTo(leadLi);

// Hide the scrollbar
employeeWrapper.css({
    'scrollbar-width': 'none', // Firefox
    '-ms-overflow-style': 'none' // IE/Edge
});
employeeWrapper.append('<style>div::-webkit-scrollbar { display: none; }</style>');

// Enable dragging to scroll
let isDown = false;
let startX;
let scrollLeft;

employeeWrapper.on('mousedown', function(e) {
    isDown = true;
    employeeWrapper.css('cursor', 'grabbing');
    startX = e.pageX - employeeWrapper[0].offsetLeft;
    scrollLeft = employeeWrapper[0].scrollLeft;
});

employeeWrapper.on('mouseleave mouseup', function() {
    isDown = false;
    employeeWrapper.css('cursor', 'grab');
});

employeeWrapper.on('mousemove', function(e) {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - employeeWrapper[0].offsetLeft;
    const walk = (x - startX) * 2; // Adjust speed
    employeeWrapper[0].scrollLeft = scrollLeft - walk;
});

            let employeeUl = $('<ul style="display: flex; justify-content: center; align-items: center; padding-top: 20px; position: relative;">').appendTo(employeeWrapper);

            let employeeKeys = Object.keys(employees);
            let employeeCount = 0;
            employeeKeys.forEach(managerId => {
                employeeCount += employees[managerId].length;
            });

            if (employeeCount > 0) {
                $('<div style="position: absolute; top: -20px; left: 50%; width: 2px; height: 20px; background: #000;"></div>').appendTo(employeeWrapper);
                // $('<div style="position: absolute; top: 0; left: 10%; right: 10%; height: 2px; background: #000;"></div>').appendTo(employeeWrapper);
                let horizontalLine = $('<div style="position: absolute; top: 0; height: 2px; background: #000;"></div>').appendTo(employeeWrapper);

setTimeout(() => {
    let firstChild = employeeUl.children().first();
    let lastChild = employeeUl.children().last();

    if (firstChild.length && lastChild.length) {
        let leftOffset = firstChild.position().left + (firstChild.width() / 2);
        let rightOffset = lastChild.position().left + (lastChild.width() / 2);

        horizontalLine.css({
            left: `${leftOffset+ 12}px`,
            width: `${(rightOffset - leftOffset)+12}px`
        });
    }
}, 100);
            }

            employeeKeys.forEach(managerId => {
                employees[managerId].forEach(employee => {
                    let employeeLi = $('<li style="list-style-type: none; text-align: center; position: relative; padding: 20px;">')
                        .appendTo(employeeUl);

                    $('<div style="position: absolute; top: -20px; left: 50%; width: 2px; height: 20px; background: #000;"></div>').appendTo(employeeLi);

                    // 🔹 Calculate total leads for each employee
                    let employeeTotalLeads = getTotalLeads(employees, employee.user_id);

                    // 🔹 Employee Box with Own & Total Leads
                    let employeeDiv = $('<div style="display: inline-block; padding: 10px 20px; border: 2px solid #000; border-radius: 10px; background: #fff; position: relative;">')
                        // .html(`${employee.user_person_name} <br> (Own: ${employee.total_leads} | Total: ${employeeTotalLeads})`)
                        .html(`${employee.user_person_name} <br> Total Leads: ${employee.total_leads} `)
                        .appendTo(employeeLi);
                });
            });
        });
    }

    $(document).ready(function() {
        buildTree(data, $('#teamTree'));
    });
</script>
