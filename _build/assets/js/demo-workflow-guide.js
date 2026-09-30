(function () {
    'use strict';

    var vendorMarker = '/vendor/';
    var markerIndex = window.location.pathname.toLowerCase().indexOf(vendorMarker);
    if (markerIndex === -1) return;

    var vendorRoot = window.location.origin + window.location.pathname.substring(0, markerIndex) + vendorMarker;
    var route = window.location.pathname.substring(markerIndex + vendorMarker.length).replace(/^\/+|\/+$/g, '').toLowerCase();
    var page = document.querySelector('.page-content, .page-content-wrapper, .content-wrapper') || document.body;

    function targetUrl(path) {
        return vendorRoot + String(path || '').replace(/^\//, '');
    }

    function action(label, path, secondary) {
        return { label: label, path: path, secondary: !!secondary };
    }

    var emptyStateRules = [
        { match: /^admin\/employee_report/, noun: 'employee', add: action('Add Employee', 'admin/add_employee'), reason: 'Employees must exist before leads, tickets, reminders or follow-ups can be assigned.' },
        { match: /^admin\/branch_report/, noun: 'branch', add: action('Add Branch', 'admin/add_branch'), reason: 'A branch is required to organise employees and business records.' },
        { match: /^leads\/(lead_report|lead_summary_report|team_summary)/, noun: 'lead', add: action('Add Lead', 'leads/add_lead'), reason: 'Create a lead before recording follow-ups, transfers, approvals or conversion.' },
        { match: /^customers\/customer_report/, noun: 'customer', add: action('Add Customer', 'customers/add_customer'), reason: 'Customers are required before services, payments, tickets and complaints can be recorded.' },
        { match: /^customers\/(ticket_report|ticket_summary_report)/, noun: 'ticket', add: action('Add Ticket', 'customers/add_ticket'), reason: 'Create a customer first if none is available, then raise and assign the ticket.' },
        { match: /^customers\/service_ticket_report/, noun: 'service ticket', add: action('Add Service Ticket', 'customers/add_service_ticket'), reason: 'A customer with a service is required before a service ticket can be scheduled.' },
        { match: /^customers\/complaint_report/, noun: 'complaint', add: action('Add Complaint', 'customers/add_complaint_admin'), reason: 'A customer is required before a complaint can be recorded and assigned.' },
        { match: /^customers\/(followup_report|month_scheduler)/, noun: 'follow-up', add: action('Open Customers', 'customers/customer_report'), reason: 'Open a customer and add a follow-up to place work on the scheduler.' },
        { match: /^customers\/payment_report/, noun: 'payment', add: action('Add Customer Payment', 'customers/add_customer_payment'), reason: 'A customer and bill must exist before a payment can be recorded.' },
        { match: /^reports\/quotation_report/, noun: 'quotation', add: action('Add Quotation', 'reports/add_quotation'), reason: 'A customer or lead and at least one product/service are needed for a quotation.' },
        { match: /^reports\/(my_followup_report|team_followup_report)/, noun: 'follow-up', add: action('Open Leads', 'leads/lead_report'), reason: 'Open a lead or customer first, then add and assign its follow-up.' },
        { match: /^inventory\/supplier_report/, noun: 'supplier', add: action('Add Supplier', 'inventory/add_supplier'), reason: 'Suppliers are required before purchase orders, inward stock or supplier payments.' },
        { match: /^inventory\/(item_report|detail_item_report|stock_report)/, noun: 'inventory item', add: action('Add Item', 'inventory/add_item'), reason: 'Add an item and its category, brand and unit before receiving or selling stock.' },
        { match: /^inventory\/order_report/, noun: 'purchase order', add: action('Add Order', 'inventory/add_order'), reason: 'A supplier and inventory items are required before a purchase order can be created.' },
        { match: /^inventory\/inward_report/, noun: 'inward entry', add: action('Add Inward Entry', 'inventory/add_inward'), reason: 'Create a purchase order first, then receive its stock through an inward entry.' },
        { match: /^inventory\/payment_report/, noun: 'supplier payment', add: action('Add Supplier Payment', 'inventory/add_payment'), reason: 'A supplier liability or purchase bill is required before recording payment.' },
        { match: /^inventory\/brand_report/, noun: 'inventory brand', add: action('Add Brand', 'inventory/add_brand'), reason: 'Brands are used while creating inventory items.' },
        { match: /^inventory\/category_report/, noun: 'inventory category', add: action('Add Category', 'inventory/add_category'), reason: 'Categories are used while creating inventory items.' },
        { match: /^inventory\/unit_report/, noun: 'inventory unit', add: action('Add Unit', 'inventory/add_unit'), reason: 'A unit of measure is required while creating inventory items.' },
        { match: /^inventory\/area_report/, noun: 'inventory area', add: action('Add Area', 'inventory/add_area'), reason: 'Areas and shelves identify where stock is stored.' },
        { match: /^inventory\/shelf_report/, noun: 'inventory shelf', add: action('Add Shelf', 'inventory/add_shelf'), reason: 'Create a storage area first, then add its shelves.' },
        { match: /^masters\/permission_report/, noun: 'designation/permission', add: action('Add Designation', 'masters/add_permission'), reason: 'A designation controls employee access and menu permissions.' },
        { match: /^masters\/department_report/, noun: 'department', add: action('Add Department', 'masters/add_department'), reason: 'A department is required before employees and sub-departments can be organised.' },
        { match: /^masters\/sub_department_report/, noun: 'sub-department', add: action('Add Sub-department', 'masters/add_sub_department'), reason: 'Create its parent department before adding a sub-department.' },
        { match: /^masters\/education_report/, noun: 'education option', add: action('Add Education', 'masters/add_education'), reason: 'Education options can then be selected in employee profiles.' },
        { match: /^masters\/reference_report/, noun: 'reference source', add: action('Add Reference', 'masters/add_reference'), reason: 'Reference sources explain where leads and customers came from.' },
        { match: /^masters\/sale_product_report/, noun: 'sale product', add: action('Add Sale Product', 'masters/add_sale_product'), reason: 'Products are required for enquiries, quotations and customer services.' },
        { match: /^masters\/one_time_service_report/, noun: 'one-time service', add: action('Add Service', 'masters/add_one_time_service'), reason: 'Services are required before they can be quoted or attached to customers.' },
        { match: /^masters\/amc_report/, noun: 'AMC service', add: action('Add AMC', 'masters/add_amc'), reason: 'AMC definitions are required before annual service subscriptions can be sold.' },
        { match: /^masters\/city_report/, noun: 'city', add: action('Add City', 'masters/add_city'), reason: 'Create the state and district first, then add the city.' },
        { match: /^masters\/area_report/, noun: 'area', add: action('Add Area', 'masters/add_area'), reason: 'Create the city first, then add its service area.' },
        { match: /^masters\/faq_report/, noun: 'FAQ', add: action('Add FAQ', 'masters/add_faq'), reason: 'Add answers for common user questions and assign them to the appropriate module.' },
        { match: /^masters\/faq_module_report/, noun: 'FAQ module', add: action('Add FAQ Module', 'masters/add_faq_module'), reason: 'FAQ modules group help content by part of the application.' },
        { match: /^masters\/terms_n_conditions_report/, noun: 'terms and conditions template', add: action('Add Terms', 'masters/add_terms_n_conditions'), reason: 'Terms templates can then be reused in quotations and invoices.' }
    ];

    var prerequisiteRules = [
        { match: /^admin\/add_employee/, items: [
            { selectors: ['#permission_id'], noun: 'designation', path: 'masters/add_permission', label: 'Add Designation', blocking: true },
            { selectors: ['#department_id'], noun: 'department', path: 'masters/add_department', label: 'Add Department', blocking: true },
            { selectors: ['#emp_rpt_to'], noun: 'reporting employee', path: 'admin/add_employee', label: 'Add Employee', blocking: true }
        ] },
        { match: /^leads\/add_lead/, items: [
            { selectors: ['#lead_productid'], noun: 'product or service', path: 'masters/add_sale_product', label: 'Add Product', blocking: false },
            { selectors: ['#lead_refby'], noun: 'reference source', path: 'masters/add_reference', label: 'Add Reference', blocking: false }
        ] },
        { match: /^customers\/add_(ticket|service_ticket|complaint)/, items: [
            { selectors: ['#customer_id', '#ref_id'], noun: 'customer', path: 'customers/add_customer', label: 'Add Customer', blocking: true },
            { selectors: ['#ticket_assign_to'], noun: 'employee for assignment', path: 'admin/add_employee', label: 'Add Employee', blocking: false }
        ] },
        { match: /^reports\/add_quotation/, items: [
            { selectors: ['#ref_id'], noun: 'customer or lead', path: 'customers/add_customer', label: 'Add Customer', blocking: true }
        ] },
        { match: /^inventory\/add_order/, items: [
            { selectors: ['#p_suplid'], noun: 'supplier', path: 'inventory/add_supplier', label: 'Add Supplier', blocking: true }
        ] },
        { match: /^masters\/add_sub_department/, items: [
            { selectors: ['#department_id', '#dept_id'], noun: 'department', path: 'masters/add_department', label: 'Add Department', blocking: true }
        ] },
        { match: /^inventory\/add_(sub_category|item)/, items: [
            { selectors: ['#p_catid', '#category_id'], noun: 'category', path: 'inventory/add_category', label: 'Add Category', blocking: true }
        ] },
        { match: /^inventory\/add_(shelf|sub_shelf)/, items: [
            { selectors: ['#p_areaid', '#area_id', '#p_shelfid', '#shelf_id'], noun: 'parent storage location', path: 'inventory/add_area', label: 'Add Storage Area', blocking: true }
        ] }
    ];

    function matchingEmptyRule() {
        for (var i = 0; i < emptyStateRules.length; i++) {
            if (emptyStateRules[i].match.test(route)) return emptyStateRules[i];
        }
        return null;
    }

    function matchingPrerequisiteRule() {
        for (var i = 0; i < prerequisiteRules.length; i++) {
            if (prerequisiteRules[i].match.test(route)) return prerequisiteRules[i];
        }
        return null;
    }

    function firstExisting(selectors) {
        for (var i = 0; i < selectors.length; i++) {
            var element = document.querySelector(selectors[i]);
            if (element) return element;
        }
        return null;
    }

    function hasSelectableValue(select) {
        if (!select || !select.options) return true;
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (!option.disabled && String(option.value || '').trim() !== '') return true;
        }
        return false;
    }

    function missingPrerequisites() {
        var rule = matchingPrerequisiteRule();
        if (!rule) return [];
        var missing = [];
        for (var i = 0; i < rule.items.length; i++) {
            var item = rule.items[i];
            var select = firstExisting(item.selectors);
            if (select && !hasSelectableValue(select)) missing.push(item);
        }
        return missing;
    }

    function buttonHtml(item, secondary) {
        var css = secondary ? 'btn btn-default' : 'btn btn-warning';
        return '<a class="' + css + '" href="' + targetUrl(item.path) + '"><i class="fa fa-arrow-circle-right"></i> ' + item.label + '</a>';
    }

    function panelHtml(id, title, message, actions, danger, steps) {
        var buttons = '';
        for (var i = 0; i < actions.length; i++) buttons += buttonHtml(actions[i], actions[i].secondary);
        var stepHtml = '';
        if (steps && steps.length) {
            stepHtml = '<ol>';
            for (var s = 0; s < steps.length; s++) stepHtml += '<li>' + steps[s] + '</li>';
            stepHtml += '</ol>';
        }
        return '<div id="' + id + '" class="demo-workflow-guide' + (danger ? ' demo-workflow-danger' : '') + '" role="alert">' +
            '<div class="demo-workflow-guide-icon"><i class="fa ' + (danger ? 'fa-exclamation' : 'fa-info') + '"></i></div>' +
            '<div class="demo-workflow-guide-content"><h4>' + title + '</h4><p>' + message + '</p>' + stepHtml +
            '<div class="demo-workflow-actions">' + buttons + '</div></div></div>';
    }

    function insertAtTop(html) {
        var anchor = page.querySelector('.page-content-body, .page-bar, .portlet, .box') || page.firstElementChild;
        if (anchor) anchor.insertAdjacentHTML('beforebegin', html);
        else page.insertAdjacentHTML('afterbegin', html);
    }

    function renderPrerequisites(scrollIntoView) {
        var existing = document.getElementById('demo-workflow-prerequisites');
        var missing = missingPrerequisites();
        if (!missing.length) {
            if (existing) existing.parentNode.removeChild(existing);
            return false;
        }

        var actions = [];
        var steps = [];
        var blocking = false;
        var stateKeyParts = [];
        for (var i = 0; i < missing.length; i++) {
            actions.push(action(missing[i].label, missing[i].path, i > 0));
            steps.push('Add an active ' + missing[i].noun + '.');
            stateKeyParts.push(missing[i].noun);
            if (missing[i].blocking) blocking = true;
        }
        steps.push('Return to this page and complete the current procedure.');
        var message = blocking
            ? 'This form cannot be completed because required setup data is missing.'
            : 'This optional setup is currently missing. Add it first if it is needed for this record.';
        var stateKey = stateKeyParts.join('|');
        if (existing && existing.getAttribute('data-workflow-key') === stateKey) return blocking;
        var html = panelHtml('demo-workflow-prerequisites', 'Complete the required setup first', message, actions, blocking, steps);
        if (existing) existing.outerHTML = html;
        else insertAtTop(html);

        var rendered = document.getElementById('demo-workflow-prerequisites');
        if (rendered) rendered.setAttribute('data-workflow-key', stateKey);
        if (scrollIntoView && rendered) rendered.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return blocking;
    }

    function reportIsEmpty() {
        var pageText = (page.textContent || '').replace(/\s+/g, ' ');
        if (/\(\s*total\s*[-:]\s*0\s*\)/i.test(pageText)) return true;

        var explicit = page.querySelector('.dataTables_empty, .no-records, .no-data, [class*="empty-state"]');
        if (explicit && /no\s+(record|data|result|entry)|nothing\s+found/i.test(explicit.textContent || '')) return true;

        var candidates = page.querySelectorAll('#table_list, #tbl_data, #report_list, #ajax_table, .table-responsive');
        for (var i = 0; i < candidates.length; i++) {
            var text = (candidates[i].textContent || '').replace(/\s+/g, ' ').trim();
            if (/no\s+(record|records|data|result|results|entry|entries)\s*(found|available)?/i.test(text)) return true;
        }
        return false;
    }

    function renderEmptyState() {
        var rule = matchingEmptyRule();
        var existing = document.getElementById('demo-workflow-empty');
        if (!rule || !reportIsEmpty()) {
            if (existing) existing.parentNode.removeChild(existing);
            return;
        }
        if (existing) return;
        var message = 'No ' + rule.noun + ' record is available for the current filters. ' + rule.reason;
        var html = panelHtml('demo-workflow-empty', 'No ' + rule.noun + ' found', message, [rule.add], false, [
            'Use the button below to create the missing record or complete its prerequisite.',
            'Save it successfully.',
            'Return to this report and check again.'
        ]);
        insertAtTop(html);
    }

    function enhanceServerErrors() {
        var alerts = document.querySelectorAll('.alert-danger, .alert-warning');
        var rule = matchingEmptyRule();
        for (var i = 0; i < alerts.length; i++) {
            var alertBox = alerts[i];
            if (alertBox.getAttribute('data-demo-workflow-enhanced') === '1') continue;
            var text = (alertBox.textContent || '').replace(/\s+/g, ' ').trim();
            if (!text || !/not\s+found|not\s+available|does\s+not\s+exist|unable|failed|error|select|required/i.test(text)) continue;
            var fallback = rule ? rule.add : action('Return to Dashboard', 'dashboard');
            alertBox.insertAdjacentHTML('beforeend', '<a class="btn btn-danger btn-sm demo-workflow-inline-action" href="' + targetUrl(fallback.path) + '"><i class="fa fa-arrow-circle-right"></i> ' + fallback.label + '</a>');
            alertBox.setAttribute('data-demo-workflow-enhanced', '1');
        }
    }

    function improveConfirmationMessages() {
        var deactivate = document.querySelector('#confirm-deactivate');
        if (deactivate) {
            var title = deactivate.querySelector('.modal-title');
            var body = deactivate.querySelector('.modal-body p');
            var submit = deactivate.querySelector('.btn-ok');
            if (title) title.innerHTML = '<i class="font-bold icon-ban"></i>&nbsp; Confirm Deactivation';
            if (body) body.textContent = 'This record will no longer be available for new transactions. Existing history will remain, and the record can be reactivated later. Do you want to continue?';
            if (submit) submit.textContent = 'Deactivate';
        }
        var submitModal = document.querySelector('#confirm-submit .modal-body p');
        if (submitModal) submitModal.textContent = 'Please confirm that the entered details are correct. The record will be added to the next step of the workflow.';
    }

    function guardForms() {
        var forms = document.querySelectorAll('form');
        for (var i = 0; i < forms.length; i++) {
            forms[i].addEventListener('submit', function (event) {
                if (renderPrerequisites(true)) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                }
            }, true);
        }
    }

    function refreshGuidance() {
        renderPrerequisites(false);
        renderEmptyState();
        enhanceServerErrors();
    }

    improveConfirmationMessages();
    guardForms();
    window.setTimeout(refreshGuidance, 900);

    var refreshTimer = null;
    var observer = new MutationObserver(function () {
        window.clearTimeout(refreshTimer);
        refreshTimer = window.setTimeout(refreshGuidance, 250);
    });
    observer.observe(page, { childList: true, subtree: true });
}());
