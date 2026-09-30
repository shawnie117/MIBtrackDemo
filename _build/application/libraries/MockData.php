<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DEMO BUILD RIG - Mock data source
 * -------------------------------------------------------------------------
 * One public method per backend API method name. Api.php dispatches to these
 * by name, so the contract is: method name must match the Java endpoint name
 * exactly, and the returned array must match the shape the views read.
 *
 * Positional params arrive exactly as production sends them:
 *   $p['one'], $p['two'], $p['three'] ... $p['seventynine']
 * Meaning varies per method, mirroring AaGeneralClassForPost.
 *
 * ALL DATA IS SYNTHETIC. No real customer records, no live keys.
 */
class MockData
{
    // Demo tenant identity, mirrors a single vendor company/branch.
    const DEMO_USER_ID    = '9001';
    const DEMO_EMP_ID     = '5001';
    const DEMO_BRANCH_ID  = '104';
    const DEMO_COMPANY_ID = '175';

    // ---------------------------------------------------------------------
    // Store access
    // ---------------------------------------------------------------------

    /**
     * Load a seed table. Writes made during a demo session live in the
     * session-scoped overlay so each trainee gets an isolated sandbox.
     */
    protected function table($name)
    {
        require_once APPPATH . 'libraries/MockSeed.php';
        return MockSeed::table($name);
    }

    protected function p($params, $key, $default = NULL)
    {
        return isset($params[$key]) && $params[$key] !== '' ? $params[$key] : $default;
    }

    // =====================================================================
    // AUTH
    // =====================================================================

    /**
     * Login. Production returns one row describing the outcome.
     * Login::index() branches on login_result / customer_subscription_status
     * / two_step_verify_status, so all three must be present.
     */
    public function getLoginDetails($p)
    {
        $username = strtolower(trim((string) $this->p($p, 'one', '')));
        $password = (string) $this->p($p, 'two', '');

        $accounts = MockSeed::accounts();

        foreach ($accounts as $acct) {
            if (strtolower($acct['username']) === $username && $acct['password'] === $password) {
                return array($this->loginRow($acct));
            }
        }

        // Wrong credentials: production returns a Failed row with a message,
        // which Login::index() surfaces as a flash error. Preserve that.
        return array(array(
            'login_result'                 => 'Failed',
            'login_msg'                    => 'Invalid Username-Password',
            'customer_subscription_status'  => 'Active',
            'two_step_verify_status'        => 'Verified',
        ));
    }

    protected function loginRow($acct)
    {
        return array(
            'login_result'                 => 'Success',
            'login_msg'                    => 'Login Successful',
            'customer_subscription_status' => 'Active',
            'two_step_verify_status'       => 'Verified',

            'user_id'            => $acct['user_id'],
            'user_permission_id' => $acct['permission_id'],
            'user_person_name'   => $acct['person_name'],
            'user_emp_id'        => $acct['emp_id'],
            'user_branch_id'     => self::DEMO_BRANCH_ID,
            'user_company_id'    => self::DEMO_COMPANY_ID,
            'user_cust_id'       => '',
            'user_type'          => 'vendor',
            'user_mob'           => $acct['mobile'],
            'user_emailid'       => $acct['email'],
            'branch_name'        => 'Kharghar (Head Office)',
            'user_branch_name'   => 'Kharghar (Head Office)',
            'company_name'       => 'Demo Systems Pvt Ltd',
            'user_image'         => base_url('assets/images/default_user.png'),
            'user_designation'   => $acct['designation'],
            'emp_name'           => $acct['person_name'],
        );
    }

    /**
     * Api::checkUserActiveStatus() polls this every 60s in production and
     * force-logs-out on active !== 1. Keep the demo user always active.
     */
    public function getcheckUserActiveStatus($p)
    {
        return array('active' => 1);
    }

    // =====================================================================
    // APP SHELL
    // =====================================================================

    /**
     * Sidebar menu. Contract read by _parts/header.php:
     *   $header_menu_list[0]['menuList'][] = array(
     *       menu_name, menu_no, menu_status ('A'), submenuList[]
     *   )
     *   submenuList[] = array(
     *       sub_menu_no, sub_menu_menuno, sub_menu_name,
     *       sub_menu_filename ('controller/method'), sub_menu_icon
     *   )
     *
     * header.php highlights the active item by matching sub_menu_filename
     * against "<segment n-1>/<segment n>", so filenames must be real routes.
     */
    public function getMenuDashboardWebDetails($p)
    {
        // Group order mirrors the reference sidebar screenshot:
        // Dashboard (hard-coded in _parts/header.php), Admin, Masters,
        // Customers, Leads, Quotation, COMPLAINT, TICKETS, SEND SMS / Email,
        // Notification, Reports, Inventory, FAQ, Employee. PHP preserves
        // insertion order for string keys, so this array IS the render order.
        $menus = array(
            'Admin' => array(
                array('Branch Report',           'admin/branch_report',                  'icon-home'),
                array('Two Step Verification',   'admin/two_step_verification_report',   'icon-lock'),
                array('Integrations',            'admin/integrations',                   'icon-share'),
                array('My Account',              'admin/my_account',                     'icon-user'),
            ),
            'Masters' => array(
                array('Product Master',          'masters/sale_product_report',          'icon-tag'),
                array('AMC Master',              'masters/amc_report',                   'icon-refresh'),
                array('One Time Service',        'masters/one_time_service_report',      'icon-wrench'),
                array('Reference Master',        'masters/reference_report',             'icon-share'),
                array('Brand Master',            'masters/brand_report',                 'icon-tag'),
                array('Department',              'masters/department_report',             'icon-layers'),
                array('Sub Department',          'masters/sub_department_report',         'icon-layers'),
                array('Designation',             'masters/permission_report',            'icon-badge'),
                array('Education',               'masters/education_report',             'icon-graduation'),
                array('Company Type',            'masters/company_type_report',          'icon-briefcase'),
                array('City Master',             'masters/city_report',                  'icon-map'),
                array('Area Master',             'masters/area_report',                  'icon-map'),
                array('Terms & Conditions',      'masters/terms_n_conditions_report',    'icon-doc'),
                array('Invoice T&C',             'masters/invoice_tc_report',            'icon-doc'),
                array('Invoice Pattern',         'masters/invoice_pattern_report',       'icon-doc'),
                array('Cheque Register',         'masters/cheque_report',                'icon-credit-card'),
                array('FAQ Module',              'masters/faq_module_report',            'icon-question'),
                array('FAQ',                     'masters/faq_report',                   'icon-question'),
            ),
            'Customers' => array(
                array('Customer Report',         'customers/customer_report',            'icon-list'),
                array('Upcoming Services',       'customers/upcoming_service_report',    'icon-calendar'),
                array('Payment Report',          'customers/payment_report',             'icon-wallet'),
                array('Followup Report',         'customers/followup_report',            'icon-bubbles'),
                array('GST Report',              'customers/customer_gst_report',        'icon-doc'),
                array('Month Scheduler',         'customers/month_scheduler',            'icon-calendar'),
            ),
            'Leads' => array(
                array('All Lead Report',         'leads/lead_report',                    'icon-list'),
                array('Lead Summary Report',     'leads/lead_summary_report',            'icon-bar-chart'),
                array('Team Summary',            'leads/team_summary',                   'icon-users'),
            ),
            'Quotation' => array(
                array('Quotation Report',        'reports/quotation_report',             'icon-calculator'),
            ),
            'COMPLAINT' => array(
                array('Complaint Report',        'customers/complaint_report',           'icon-notebook'),
            ),
            'TICKETS' => array(
                array('Ticket Report',           'customers/ticket_report',              'icon-tag'),
                array('Service Ticket Report',   'customers/service_ticket_report',      'icon-wrench'),
                array('Ticket Summary Report',   'customers/ticket_summary_report',      'icon-bar-chart'),
            ),
            'SEND SMS / Email' => array(
                array('Send SMS / Email',        'admin/send_sms_email',                 'icon-speech'),
                array('SMS / Email Report',      'admin/sms_email_report',               'icon-list'),
            ),
            'Notification' => array(
                array('Notification Master',     'masters/notification_report',          'icon-bell'),
            ),
            'Reports' => array(
                array('All Reports',             'reports/all_reports',                  'icon-folder'),
                array('All Sales Report',        'reports/all_sales_report',             'icon-basket'),
                array('Collection Report',       'reports/collection_report',            'icon-wallet'),
                array('Payment Balance Report',  'reports/payment_balance_report',       'icon-wallet'),
                array('Payment Defaulter',       'reports/payment_defaulter_report',     'icon-ban'),
                array('Sales Analysis',          'reports/sales_analysis_report',        'icon-graph'),
                array('Lead Analysis',           'reports/lead_analysis_report',         'icon-graph'),
                array('Complaint Analysis',      'reports/complaint_analysis_report',    'icon-graph'),
                array('Service Analysis',        'reports/service_analysis_report',      'icon-graph'),
                array('Ticket Analysis',         'reports/ticket_analysis_report',       'icon-graph'),
                array('ROI Report',              'reports/roi_report',                   'icon-pie-chart'),
                array('AMC Renewal Reminder',    'reports/amc_renewal_reminder',         'icon-refresh'),
                array('Password Change Track',   'reports/pwd_change_track_report',      'icon-key'),
            ),
            'Inventory' => array(
                array('Inventory Dashboard',     'inv_dashboard/index',                  'icon-speedometer'),
                array('Item Master',             'inventory/item_report',                'icon-tag'),
                array('Brand',                   'inventory/brand_report',               'icon-tag'),
                array('Category',                'inventory/category_report',            'icon-layers'),
                array('Sub Category',            'inventory/sub_category_report',        'icon-layers'),
                array('Unit',                    'inventory/unit_report',                'icon-cube'),
                array('Area',                    'inventory/area_report',                'icon-map'),
                array('Shelf',                   'inventory/shelf_report',               'icon-grid'),
                array('Sub Shelf',               'inventory/sub_shelf_report',           'icon-grid'),
                array('Supplier',                'inventory/supplier_report',            'icon-briefcase'),
                array('Supplier Liability',      'inventory/supplier_liability_report',  'icon-wallet'),
                array('Purchase Order',          'inventory/order_report',               'icon-doc'),
                array('Inward Stock',            'inventory/inward_report',              'icon-download'),
                array('Stock Report',            'inventory/stock_report',               'icon-list'),
                array('Barcode',                 'inventory/barcode_report',             'icon-printer'),
                array('Counter Billing',         'inventory/counter_billing_report',     'icon-calculator'),
                array('Sale Report',             'inventory/sale_report',                'icon-basket'),
                array('Payment',                 'inventory/payment_report',             'icon-wallet'),
            ),
            'FAQ' => array(
                array('FAQ',                     'dashboard/faq',                        'icon-question'),
            ),
            'Employee' => array(
                array('Employee Report',         'admin/employee_report',                'icon-users'),
                array('Employee Attendance',     'admin/emp_attendance_report',          'icon-check'),
                array('Employee Locations',      'admin/emp_location_report',            'icon-map'),
                array('Employee Availability',   'reports/employee_availability_report', 'icon-user-following'),
            ),
            // Below the fold of the reference screenshot, so order here is ours.
            'Teams' => array(
                array('Team Customer Report',    'reports/team_customer_report',         'icon-users'),
                array('Team Lead Report',        'reports/team_lead_report',             'icon-users'),
                array('Team Followup Report',    'reports/team_followup_report',         'icon-users'),
                array('Team Ticket Report',      'reports/team_ticket_report',           'icon-users'),
                array('Team Employee Report',    'reports/team_employee_report',         'icon-users'),
            ),
            'Daily Analysis Report' => array(
                array('Daily Analysis',          'reports/daily_analysis_report',        'icon-clock'),
            ),
        );

        $menuList = array();
        $menuNo   = 1;
        $subNo    = 1;

        foreach ($menus as $menuName => $subs) {
            $submenuList = array();
            foreach ($subs as $s) {
                $submenuList[] = array(
                    'sub_menu_no'       => (string) $subNo,
                    'sub_menu_menuno'   => (string) $menuNo,
                    'sub_menu_name'     => $s[0],
                    'sub_menu_filename' => $s[1],
                    'sub_menu_icon'     => $s[2],
                    'sub_menu_status'   => 'A',
                );
                $subNo++;
            }

            $menuList[] = array(
                'menu_name'   => $menuName,
                'menu_no'     => (string) $menuNo,
                'menu_status' => 'A',
                'submenuList' => $submenuList,
            );
            $menuNo++;
        }

        // The Java endpoint returns all three lists in row 0, and the views
        // read them from there:
        //   _parts/header.php   -> $header_menu_list[0]['menuList']
        //   dashboard.php:1674  -> $header_menu_list[0]['dashboardBlockList']
        //   dashboard.php:1765  -> $header_menu_list[0]['reminderBlockList']
        // Returning only menuList left the dashboard body completely empty,
        // because both of its foreach loops had nothing to iterate.
        return array(array(
            'menuList'           => $menuList,
            'dashboardBlockList' => $this->dashboardBlockList(),
            'reminderBlockList'  => $this->reminderBlockList(),
        ));
    }

    /**
     * Top-of-dashboard quick-action tiles.
     *
     * dashboard.php switches on $block['d_name'] to pick the icon and target
     * route, so these names are a fixed vocabulary - a value it does not
     * recognise renders as a tile with the default icon and a "#" link.
     */
    protected function dashboardBlockList()
    {
        return $this->blockRows(array(
            'NewCustomer',
            'NewTicket',
            'Follow-Up',
            'ComingServices',
            'NewComplaint',
            'MonthScheduler',
        ));
    }

    /**
     * Reminder portlets, in render order.
     *
     * Same deal: dashboard.php gates every portlet on an exact
     * $reminder_name match. "PaymentDefaulterCustomers1" really is the cheque
     * reminder block and "Pending Customers" really does contain a space -
     * both are quirks of the production data, not typos.
     */
    protected function reminderBlockList()
    {
        return $this->blockRows(array(
            'TodaysTeamFollowUps',
            'TodaysMyFollowUps',
            'LeadApprovalRequests',
            'TicketReport',
            'RaisedComplaints',
            'PendingServices',
            'AmcRenewal',
            'PaymentDefaulterCustomers',
            'PaymentDefaulterCustomers1',
            'Pending Customers',
            'BirthdayReminder',
        ));
    }

    protected function blockRows($names)
    {
        $rows = array();
        $i    = 1;
        foreach ($names as $name) {
            $rows[] = array(
                'd_id'          => (string) $i,
                'd_name'        => $name,
                'd_status'      => 'A',
                'assign_status' => 'Y',
            );
            $i++;
        }
        return $rows;
    }

    /**
     * Branch list. Used for the header "Change Branch" switcher, the footer
     * quick panel, and admin/branch_report.
     *
     * Production params: one=user, two=branch, three=company,
     *                    four=status, five=branch_id, six=searchStr
     */
    public function getBranchMasterDetails($p)
    {
        $status    = $this->p($p, 'four');
        $branchId  = $this->p($p, 'five');
        $searchStr = $this->p($p, 'six');

        $rows = $this->table('branches');

        if ($branchId !== NULL) {
            $rows = array_values(array_filter($rows, function ($r) use ($branchId) {
                return (string) $r['branch_id'] === (string) $branchId;
            }));
        }

        if ($status !== NULL && $status !== 'All') {
            $rows = array_values(array_filter($rows, function ($r) use ($status) {
                return $r['branch_status'] === $status;
            }));
        }

        if ($searchStr !== NULL) {
            $needle = strtolower($searchStr);
            $rows = array_values(array_filter($rows, function ($r) use ($needle) {
                return strpos(strtolower($r['branch_name'] . ' ' . $r['branch_contact']
                    . ' ' . $r['branch_contact_person']), $needle) !== FALSE;
            }));
        }

        return $rows;
    }

    // =====================================================================
    // CATALOGUE  ("01" variants return a jsArray wrapper)
    // =====================================================================
    //
    // The Java API's "01" endpoints wrap their rows in a jsArray key, and
    // callers rely on that. Leads::getProductMasterDetails() does:
    //     $r = call_v_api('getProductMasterDetails01', $p); $r = $r['jsArray'];
    //     ... array_merge($r1, $r2, $r3)
    // so a bare array() here causes "array_merge(): Argument #1 must be of
    // type array, null given". The wrapper is mandatory, not cosmetic.

    public function getProductMasterDetails01($p)
    {
        return array('jsArray' => $this->table('products'));
    }

    public function getBrandMasterDetails($p)
    {
        $out = array();
        $seen = array();
        $id = 2201;
        foreach ($this->table('products') as $product) {
            $name = isset($product['brand_name']) ? trim($product['brand_name']) : '';
            if ($name === '' || isset($seen[strtolower($name)])) continue;
            $seen[strtolower($name)] = TRUE;
            $out[] = array(
                'pdt_brnd_id' => (string) $id++,
                'pdt_brnd_name' => $name,
                'pdt_brnd_status' => 'Active'
            );
        }
        return $out;
    }

    public function getOneTimeServiceMasterDetails01($p)
    {
        return array('jsArray' => $this->table('ots_services'));
    }

    public function getAMCDetails01($p)
    {
        return $this->getAMCDetails($p);
    }

    /**
     * The main product endpoint is also wrapped. Every current vendor caller
     * reads `jsArray`, and the report additionally reads `total_count`.
     * Returning the bare seed array left the Product Master visibly empty
     * even though the same products appeared in form drop-downs through the
     * `01` endpoint.
     */
    public function getProductMasterDetails($p)
    {
        $rows = $this->table('products');
        $status = $this->p($p, 'four');
        $mode = $this->p($p, 'five', 'Report');
        $value = $this->p($p, 'six');

        if ($status !== NULL && $status !== 'All') {
            $rows = $this->whereEquals($rows, 'pm_status', $status);
        }
        if ($mode === 'Detail' && $value !== NULL) {
            $rows = $this->whereEquals($rows, 'pm_id', $value);
        } elseif ($mode === 'Search' && $value !== NULL) {
            $needle = strtolower((string) $value);
            $rows = array_filter($rows, function ($row) use ($needle) {
                return strpos(strtolower(
                    (isset($row['pm_name']) ? $row['pm_name'] : '') . ' ' .
                    (isset($row['pm_model_name']) ? $row['pm_model_name'] : '') . ' ' .
                    (isset($row['pdt_brnd_name']) ? $row['pdt_brnd_name'] : '')
                ), $needle) !== FALSE;
            });
        }

        return $this->paged($rows, $p);
    }

    public function getOneTimeServiceMasterDetails($p)
    {
        return $this->table('ots_services');
    }

    public function getAMCDetails($p)
    {
        $rows = $this->table('amc_services');
        $mode = $this->p($p, 'five', 'Report');
        if ($mode === 'Detail') {
            $rows = $this->whereEquals($rows, 'amc_id', $this->p($p, 'six', ''));
        }
        $status = $this->p($p, 'four');
        if ($status && in_array($status, array('Active','Deactivated'), TRUE)) {
            $rows = $this->whereEquals($rows, 'amc_status', $status);
        }
        $search = strtolower((string) $this->p($p, 'six', ''));
        if ($mode !== 'Detail' && $search !== '') {
            $rows = array_filter($rows, function ($r) use ($search) {
                return strpos(strtolower($r['amc_name'] . ' ' . $r['amc_code']), $search) !== FALSE;
            });
        }
        $rows = array_map(array($this, 'amcRow'), array_values($rows));
        return $this->paged($rows, $p);
    }

    protected function amcRow($row)
    {
        $products = $this->whereEquals($this->table('products'), 'pm_id', $row['product_id']);
        $product = $products ? reset($products) : array('product_id'=>'', 'product_name'=>'');
        $row['product_name'] = $product['product_name'];
        $row['amcDetailDetails'] = $product;
        $row['amcImageList'] = array();
        $row['product_image'] = base_url('assets/images/default_user.png');
        $row['amc_price_gst'] = (string) round((float)$row['amc_price'] * (1 + (float)$row['amc_gst'] / 100), 2);
        $row['amc_corporate_price_gst'] = (string) round((float)$row['amc_corporate_price'] * (1 + (float)$row['amc_gst'] / 100), 2);
        return $row;
    }

    protected function writeFailure($message)
    {
        return array(array('status'=>'Failed', 'id'=>'', 'message'=>$message));
    }

    public function setAMCDetails($p)
    {
        return $this->saveAMC($p);
    }

    public function setModifyAMCDetails($p)
    {
        $mapped = $p;
        $keys = array('five','six','seven','eight','nine','ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen');
        for ($i = 0; $i < count($keys)-1; $i++) $mapped[$keys[$i]] = $this->p($p, $keys[$i+1], '');
        return $this->saveAMC($mapped, $this->p($p, 'five', ''));
    }

    protected function saveAMC($p, $id = NULL)
    {
        require_once APPPATH . 'libraries/MockSeed.php';
        $name = trim((string)$this->p($p, 'five', ''));
        if ($name === '' || strlen($name) > 100) return $this->writeFailure('Enter an AMC name of up to 100 characters.');
        if ($id !== NULL && !$this->whereEquals($this->table('amc_services'), 'amc_id', $id)) return $this->writeFailure('This AMC plan was not found. Open AMC Services and select an existing plan.');
        foreach ($this->table('amc_services') as $existing) {
            if ((string)$existing['amc_id'] !== (string)$id && strcasecmp(trim($existing['amc_name']), $name) === 0) {
                return $this->writeFailure('An AMC with this name already exists. Open AMC Services and edit that plan, or use a different name.');
            }
        }
        $product = $this->p($p, 'thirteen', '');
        if ($product === '' || !$this->whereEquals($this->whereEquals($this->table('products'), 'pm_status', 'Active'), 'pm_id', $product)) {
            return $this->writeFailure('Select an active product. If it is missing, add it in Masters > Products, then return here.');
        }
        $duration = (string)$this->p($p,'six','');
        $visits = (string)$this->p($p,'seven','');
        if (!ctype_digit($duration) || (int)$duration < 1 || (int)$duration > 9999) return $this->writeFailure('Enter a duration in days, for example 365 for one year.');
        if (!ctype_digit($visits) || (int)$visits < 1 || (int)$visits > 999 || (int)$visits > (int)$duration) return $this->writeFailure('Enter a valid number of services between 1 and the duration in days (up to 999).');
        foreach (array('nine','ten') as $key) {
            $price = $this->p($p,$key,'0');
            if (!is_numeric($price) || $price < 0 || $price > 9999999999) return $this->writeFailure('Regular and commercial prices must be zero or a positive amount.');
        }
        $gst = $this->p($p,'eleven','0');
        if (!is_numeric($gst) || $gst < 0 || $gst > 100) return $this->writeFailure('GST must be a percentage between 0 and 100.');
        if ($id === NULL) $id = MockSeed::nextId('amc_services', 'amc_id');
        $row = array(
            'amc_id'=>(string)$id, 'product_id'=>(string)$product,
            'amc_name'=>$name,
            'amc_duration'=>$duration,
            'amc_noofservices'=>$visits, 'no_of_services'=>$visits,
            'amc_sit'=>(string)ceil((int)$duration/(int)$visits), 'amc_price'=>(string)$this->p($p,'nine','0'),
            'product_price'=>(string)$this->p($p,'nine','0'), 'amc_corporate_price'=>(string)$this->p($p,'ten','0'),
            'amc_gst'=>(string)$gst, 'amc_desc'=>$this->p($p,'twelve',''),
            'amc_status'=>'Active','product_status'=>'Active','service_type'=>'AMC'
        );
        $existing = $this->whereEquals($this->table('amc_services'), 'amc_id', $id);
        if (!$existing) {
            $row['amc_code'] = 'AMC-DEMO-'.$id;
            $row['amc_addedbyname'] = 'Demo Admin';
            $row['amc_addeddate_n'] = strtoupper(date('d-M-Y'));
        }
        MockSeed::upsert('amc_services', 'amc_id', $row);
        return array(array('status'=>'Success','amc_id'=>(string)$id,'id'=>(string)$id));
    }

    public function setDeactivateAMCDetails($p)
    {
        return $this->setAMCStatus($this->p($p, 'five', ''), 'Deactivated');
    }

    public function reactivateAMC($p)
    {
        return $this->setAMCStatus($this->p($p, 'one', ''), 'Active');
    }

    protected function setAMCStatus($id, $status)
    {
        if (!$this->whereEquals($this->table('amc_services'), 'amc_id', $id)) return 'Failed';
        MockSeed::upsert('amc_services', 'amc_id', array('amc_id'=>(string)$id, 'amc_status'=>$status, 'product_status'=>$status));
        return 'Success';
    }

    public function getClientSubscriptionDetails($p)
    {
        $rows = $this->table('amc_subscriptions');
        $customer = $this->p($p, 'four');
        if ($customer !== NULL) $rows = $this->whereEquals($rows, 'customer_id', $customer);
        return array_values($rows);
    }

    public function getClientSubscriptionServiceDetails($p)
    {
        $rows = $this->table('amc_service_visits');
        $customer = $this->p($p, 'four');
        if ($customer !== NULL) $rows = $this->whereEquals($rows, 'customer_id', $customer);
        return array_values($rows);
    }

    public function getClientServiceDetails($p)
    {
        return $this->getClientSubscriptionServiceDetails($p);
    }

    // =====================================================================
    // DASHBOARD LAYOUT PERMISSIONS
    // =====================================================================

    /**
     * dashboard.php reads $dashboard_permission['dashboardBlockList'] and
     * ['reminderBlockList'] to decide which widgets to draw. Returning the
     * full set means the demo dashboard shows everything.
     */
    public function getDashboardPermissionAssignDetails($p)
    {
        $blocks = array(
            'todays_followup', 'my_followup', 'lead_approval', 'raised_complaint',
            'amc_reminder', 'ticket_reminder', 'pending_service', 'birthday_reminder',
            'cheque_reminder', 'sale_balance', 'pending_customer', 'notification',
        );

        $dash = array();
        $rem  = array();
        $i    = 1;
        foreach ($blocks as $b) {
            $row = array(
                'block_id'     => (string) $i,
                'block_name'   => $b,
                'block_status' => 'A',
                'assign_status' => 'Y',
            );
            $dash[] = $row;
            $rem[]  = $row;
            $i++;
        }

        return array(
            'dashboardBlockList' => $dash,
            'reminderBlockList'  => $rem,
        );
    }

    // =====================================================================
    // DASHBOARD REMINDER DATA
    // =====================================================================
    //
    // Every reminder portlet in dashboard.php is gated on
    // !empty($list['jsArray']) and most of them also print
    // $list['total_count'], so each of these returns the paged wrapper the
    // Java "report" endpoints use. Filters below only implement the params
    // the dashboard actually varies; the rest are accepted and ignored.

    /**
     * Wrap rows the way the Java report endpoints do.
     * total_count is the unpaged total, which is what the portlet headers show.
     */
    protected function paged($rows, $params = array())
    {
        $rows = array_values($rows);
        $count = count($rows);
        $limit = (int)$this->p($params, 'limit', 0);
        if ($limit > 0) {
            $page = max(1, (int)$this->p($params, 'offset', 1));
            $rows = array_slice($rows, ($page-1)*$limit, $limit);
        }
        return array(
            'jsArray'     => $rows,
            'total_count' => (string) $count,
        );
    }

    protected function whereEquals($rows, $field, $value)
    {
        return array_filter($rows, function ($r) use ($field, $value) {
            return isset($r[$field]) && (string) $r[$field] === (string) $value;
        });
    }

    /**
     * Follow-ups. Feeds two portlets from one endpoint:
     *   Today's Team Follow Ups - no "four", so every row comes back
     *   Today's My Follow Ups   - "four" = signed-in user id
     */
    public function getFollowupAnalysisDetails($p)
    {
        $rows     = $this->table('followups');
        $assignTo = $this->p($p, 'four');

        if ($assignTo !== NULL) {
            $rows = $this->whereEquals($rows, 'followup_assignto', $assignTo);
        }

        $rows = array_map(function ($row) {
            $defaults = array(
                'followup_assignto_name' => ((string) $this->value($row, 'followup_assignto') === '9002') ? 'Demo Sales' : 'Demo Admin',
                'ticket_id' => '',
                'followup_status' => 'Pending',
                'ticket_added_byname' => 'Demo Admin',
                'followup_nxt_folldate_n' => $this->value($row, 'followup_date_n'),
                'followup_nxt_folltime' => '10:00 AM',
                'followup_sdate_n' => strtoupper(date('d-M-Y')),
            );
            return array_merge($defaults, $row);
        }, array_values($rows));

        return $this->paged($rows);
    }

    public function getRoiReport($p)
    {
        $leadList = array();
        foreach ($this->table('leads') as $index => $lead) {
            $leadList[] = array(
                'emp_name' => $index % 2 ? 'Demo Sales' : 'Demo Admin',
                'lead_name' => $this->value($lead, 'clm_name'),
                'lead_reference_name' => $index % 3 === 0 ? 'Google' : 'Customer Referral',
                'reference_name' => $index % 3 === 0 ? 'Google' : 'Customer Referral',
                'lead_status' => $index % 3 === 0 ? 'Approved' : 'Active',
                'lead_date' => date('Y-m-d', strtotime($this->value($lead, 'clm_sdate_n', 'now'))),
            );
        }
        $employee = array(
            array('emp_name' => 'Demo Admin', 'total_leads' => '5', 'approved_leads' => '2', 'converted_customers' => '1'),
            array('emp_name' => 'Demo Sales', 'total_leads' => '4', 'approved_leads' => '2', 'converted_customers' => '1'),
            array('emp_name' => 'Prajyot', 'total_leads' => '2', 'approved_leads' => '1', 'converted_customers' => '1'),
        );
        $references = array(
            array('reference_name' => 'Google', 'total_leads' => '5', 'approved_leads' => '3', 'converted_customers' => '2'),
            array('reference_name' => 'Customer Referral', 'total_leads' => '4', 'approved_leads' => '2', 'converted_customers' => '1'),
        );
        return array('jsArray' => array(array(
            'lead_list' => $leadList,
            'employee_roi' => $employee,
            'reference_roi' => $references,
        )));
    }

    /**
     * Leads. Dashboard asks for four="FS" (awaiting approval); the lead report
     * page passes no status and gets everything.
     */
    public function getCustomerLeadMasterReportDetails($p)
    {
        $rows   = $this->table('leads');
        $status = $this->p($p, 'four');

        if ($status !== NULL && $status !== '' && $status !== 'All') {
            if ($status === 'Active') {
                // Older cloned records use "Open" for the same live-lead
                // state that the current report calls "Active".
                $rows = array_filter($rows, function ($row) {
                    return in_array($this->value($row, 'clm_status'), array('Active', 'Open'), TRUE);
                });
            } else {
                $rows = $this->whereEquals($rows, 'clm_status', $status);
            }
        }

        return $this->paged($rows);
    }

    /**
     * Create a lead from the normal Add Lead form.
     *
     * Leads::add_lead() reads $response[0]['status'], ['id'] and ['message'].
     * It treats message === 'MOBILE_EXISTS' as a duplicate (re-renders the form
     * with an inline error), 'LEAD_CREATED' / 'LEAD_REACTIVATED' as success and
     * 'LEAD_ALREADY_EXISTS' as a soft error, then redirects to view_lead with
     * base64(id). All three must therefore be honoured exactly, otherwise the
     * guided tour would claim a save that never happened.
     *
     * Positional params (see Leads::add_lead):
     *   four  lead_name          five  lead_contact       six  lead_addrs
     *   nine  clm_productid      eleven state_id          twelve district_id
     *   thirteen area            fourteen city_id         fifteen pincode
     *   sixteen enquiry details  nineteen reference id    twenty reference name
     *   twentyone ref contact    twentytwo ref address    twentythree ref email
     *   twentysix landline       twentyseven email        twentyeight contact person
     *   thirtytwo priority       thirtythree website      thirtyfour pan
     *   thirtyfive company       thirtysix dob            thirtynine business card
     */
    public function setCustomerLeadMasterDetails($p)
    {
        require_once APPPATH . 'libraries/MockSeed.php';

        $name   = trim((string) $this->p($p, 'four', ''));
        $mobile = trim((string) $this->p($p, 'five', ''));

        if ($name === '') {
            return array(array('status' => 'Failed', 'id' => '', 'message' => 'LEAD_NAME_REQUIRED'));
        }

        // Production rejects a mobile already present on another live lead. The
        // controller shows this inline instead of as a page-level error.
        if ($mobile !== '') {
            foreach ($this->table('leads') as $existing) {
                if (isset($existing['clm_contact'])
                    && (string) $existing['clm_contact'] === $mobile
                    && strtoupper((string) $this->value($existing, 'clm_status')) !== 'DEACTIVATED') {
                    return array(array('status' => 'Failed', 'id' => $existing['clm_id'], 'message' => 'MOBILE_EXISTS'));
                }
            }
        }

        $id  = MockSeed::nextId('leads', 'clm_id');
        $row = $this->leadRow($id, $p);
        MockSeed::upsert('leads', 'clm_id', $row);

        return array(array('status' => 'Success', 'id' => (string) $id, 'message' => 'LEAD_CREATED'));
    }

    /**
     * Edit an existing lead. Same field order as the create call but shifted by
     * one because the controller sends the lead id first.
     */
    public function setModifyCustomerLeadMasterDetails($p)
    {
        require_once APPPATH . 'libraries/MockSeed.php';

        $id = (string) $this->p($p, 'four', '');
        if ($id === '' || !$this->whereEquals($this->table('leads'), 'clm_id', $id)) {
            return array(array('status' => 'Failed', 'id' => '', 'message' => 'LEAD_NOT_FOUND'));
        }

        $shifted = $p;
        $keys = array(
            'four','five','six','seven','eight','nine','ten','eleven','twelve','thirteen','fourteen',
            'fifteen','sixteen','seventeen','eighteen','nineteen','twenty','twentyone','twentytwo',
            'twentythree','twentyfour','twentyfive','twentysix','twentyseven','twentyeight','twentynine',
            'thirty','thirtyone','thirtytwo','thirtythree','thirtyfour','thirtyfive','thirtysix',
            'thirtyseven','thirtyeight','thirtynine','forty',
        );
        for ($i = 0; $i < count($keys) - 1; $i++) {
            $shifted[$keys[$i]] = $this->p($p, $keys[$i + 1], '');
        }

        MockSeed::upsert('leads', 'clm_id', $this->leadRow($id, $shifted));
        return array(array('status' => 'Success', 'id' => $id, 'message' => 'LEAD_UPDATED'));
    }

    /**
     * Lead detail for leads/view_lead. The view touches roughly thirty keys, so
     * every one is present even when the form left it blank - a missing key
     * would raise an undefined-index notice on an otherwise valid record.
     */
    public function getCustomerLeadMasterDetails($p)
    {
        $id = (string) $this->p($p, 'four', '');
        if ($id === '') {
            return array();
        }

        $rows = $this->whereEquals($this->table('leads'), 'clm_id', $id);
        if (!$rows) {
            return array();
        }

        $row = reset($rows);
        return array($this->hydrateLead($row));
    }

    /**
     * Build a full lead row from Add/Edit Lead positional params.
     */
    protected function leadRow($id, $p)
    {
        $stateId = $this->p($p, 'eleven', '');
        $distId  = $this->p($p, 'twelve', '');
        $cityId  = $this->p($p, 'fourteen', '');
        $refId   = $this->p($p, 'nineteen', '');
        $prodId  = $this->p($p, 'nine', '');

        return array(
            'clm_id'              => (string) $id,
            'clm_name'            => (string) $this->p($p, 'four', ''),
            'clm_contact'         => (string) $this->p($p, 'five', ''),
            'clm_address'         => (string) $this->p($p, 'six', ''),
            'clm_amcid'           => (string) $this->p($p, 'seven', ''),
            'clm_ots_id'          => (string) $this->p($p, 'eight', ''),
            'clm_productid'       => (string) $prodId,
            'clm_type_name'       => $prodId !== '' ? $this->lookupName('products', 'pm_id', $prodId, 'pm_name') : '',
            'clm_stateid'         => (string) $stateId,
            'clm_distid'          => (string) $distId,
            'clm_cityid'          => (string) $cityId,
            'clm_state_name'      => $stateId !== '' ? $this->lookupName('states', 'state_id', $stateId, 'state_name') : '',
            'clm_dist_name'       => $distId !== '' ? $this->lookupName('districts', 'dist_id', $distId, 'dist_name') : '',
            'clm_city_name'       => $cityId !== '' ? $this->lookupName('cities', 'city_id', $cityId, 'city_name') : '',
            'clm_area_name'       => (string) $this->p($p, 'thirteen', ''),
            'clm_pincode'         => (string) $this->p($p, 'fifteen', ''),
            'clm_description'     => (string) $this->p($p, 'sixteen', ''),
            'clm_refbyid'         => (string) $refId,
            'ref_name'            => $refId !== '' ? $this->lookupName('references', 'ref_id', $refId, 'ref_name') : '',
            'clm_refby_name'      => (string) $this->p($p, 'twenty', ''),
            'clm_refby_contact'   => (string) $this->p($p, 'twentyone', ''),
            'clm_refby_address'   => (string) $this->p($p, 'twentytwo', ''),
            'clm_refby_emailid'   => (string) $this->p($p, 'twentythree', ''),
            'clm_landline'        => (string) $this->p($p, 'twentysix', ''),
            'clm_contact_emailid' => (string) $this->p($p, 'twentyseven', ''),
            'clm_contact_person'  => (string) $this->p($p, 'twentyeight', ''),
            'clm_priority_level'  => (string) $this->p($p, 'thirtytwo', 'Medium'),
            'clm_website'         => (string) $this->p($p, 'thirtythree', ''),
            'clm_panno'           => (string) $this->p($p, 'thirtyfour', ''),
            'clm_company_name'    => (string) $this->p($p, 'thirtyfive', ''),
            'clm_dob'             => (string) $this->p($p, 'thirtysix', ''),
            'clm_img'             => (string) $this->p($p, 'thirtynine', ''),
            // The working Lead Report defaults to Active, and the real
            // controller presents Active as the live-record state.
            'clm_status'          => 'Active',
            'clm_sdate_n'         => strtoupper(date('d-M-Y')),
            'clm_addedbyname'     => 'Demo Admin',
            'clm_branchid'        => self::DEMO_BRANCH_ID,
            'clm_companyid'       => self::DEMO_COMPANY_ID,
        );
    }

    /**
     * Fill in every key leads/view_lead reads, without overwriting real values.
     */
    protected function hydrateLead($row)
    {
        $defaults = array(
            'clm_address' => '', 'clm_description' => '', 'clm_priority_level' => 'Medium',
            'clm_company_name' => '', 'clm_contact_person' => '', 'clm_contact_emailid' => '',
            'clm_landline' => '', 'clm_website' => '', 'clm_panno' => '', 'clm_dob' => '',
            'clm_pincode' => '', 'clm_state_name' => '', 'clm_dist_name' => '', 'clm_city_name' => '',
            'clm_area_name' => '', 'clm_type_name' => '', 'clm_productid' => '', 'clm_amcid' => '',
            'clm_ots_id' => '', 'clm_img' => '', 'clm_refby_name' => '', 'clm_refby_contact' => '',
            'clm_refby_emailid' => '', 'clm_refby_address' => '', 'ref_name' => '',
            'clm_addedbyname' => 'Demo Admin', 'clm_status' => 'Open',
            'future_conversion' => '', 'branch_details' => '',
        );
        foreach ($defaults as $key => $value) {
            if (!isset($row[$key])) {
                $row[$key] = $value;
            }
        }

        // The view loops these; an absent key would break the detail tabs.
        $row['actvDeactvList'] = array();
        $row['contactList']    = array();
        $row['ticketList']     = array();
        $row['transferList']   = array();

        return $row;
    }

    protected function value($row, $key, $default = '')
    {
        return isset($row[$key]) ? $row[$key] : $default;
    }

    public function getQuotationReportDetails($p)
    {
        $rows=$this->table('quotations'); $priority=$this->p($p,'four'); $status=$this->p($p,'five'); $type=$this->p($p,'six');
        if($priority && $priority!=='All') $rows=$this->whereEquals($rows,'quote_priority',$priority);
        if($status && $status!=='All') $rows=$this->whereEquals($rows,'quote_status',$status);
        if($type==='Lead') $rows=array_filter($rows,function($r){return !empty($r['clm_id']);});
        if($type==='Customer') $rows=array_filter($rows,function($r){return !empty($r['customer_id']);});
        return $this->paged($rows);
    }

    /**
     * Customers. Dashboard asks for four="Pending" to fill the pending
     * approvals reminder.
     */
    public function getCustomerMasterReportDetails($p)
    {
        $rows   = $this->table('customers');
        $status = $this->p($p, 'four');

        if ($status !== NULL && $status !== 'All') {
            $rows = $this->whereEquals($rows, 'customer_status', $status);
        }

        return $this->paged($rows);
    }

    /**
     * Complaints live in the ticket master under ticket_type "Complaint".
     * Dashboard passes five="Open".
     */
    public function getComplaintAnalysisDetails($p)
    {
        $rows   = $this->whereEquals($this->table('tickets'), 'ticket_type', 'Complaint');
        $status = $this->p($p, 'five');

        if ($status !== NULL && $status !== 'All') {
            $rows = $this->whereEquals($rows, 'ticket_status', $status);
        }

        return $this->paged($rows);
    }

    /**
     * Tickets. Dashboard passes five="Open" and nine="Ticket,Servicing".
     * With no type filter, complaints are excluded so this endpoint never
     * double-reports the rows the complaint reminder already shows.
     */
    public function getTicketMasterReportDetails($p)
    {
        $rows   = $this->table('tickets');
        $status = $this->p($p, 'five');
        $types  = $this->p($p, 'nine');

        $allowed = $types !== NULL
            ? array_map('trim', explode(',', $types))
            : array('Ticket', 'Servicing');

        $rows = array_filter($rows, function ($r) use ($allowed) {
            return isset($r['ticket_type']) && in_array($r['ticket_type'], $allowed, TRUE);
        });

        if ($status !== NULL && $status !== 'All') {
            $rows = $this->whereEquals($rows, 'ticket_status', $status);
        }

        return $this->paged($rows);
    }

    public function getTicketMasterDetails($p)
    {
        $id = $this->p($p, 'four');
        $rows = array_values($this->whereEquals($this->table('tickets'), 'ticket_id', $id));
        return array_map(function ($row) {
            if (!empty($row['story_owned'])) return $row;
            $row['ticket_desc'] = $row['ticket_id'] === '9107'
                ? 'Provide the GPM service properly.' : 'General pest management service completed.';
            $row['ticket_priority'] = 'High';
            $row['ticket_time'] = '10:00 AM';
            $row['tkt_reopened_date_n'] = '';
            $row['ticket_added_by'] = self::DEMO_USER_ID;
            $row['ticket_added_byname'] = 'Demo Admin';
            $row['user_id'] = self::DEMO_USER_ID;
            $row['customer_address'] = 'Swastik niwas, khandagale vasti, Mumbai.';
            $row['ticketReviewList'] = array();
            $row['ticket_detailList'] = array();
            $row['subscriptionList'] = array();
            if ($row['ticket_id'] === '9108') {
                $row['tkt_resolved_by'] = '9005';
                $row['tkt_resolved_date_n'] = $row['ticket_date_n'];
                $row['ticketReviewList'] = array(array(
                    'trm_name' => 'Service done',
                    'trm_desc' => 'General pest management service completed.',
                    'user_person_name' => 'Prajyot',
                    'trm_sdate_n' => $row['ticket_date_n'],
                    'trm_status' => 'Resolved',
                    'trm_img_path' => '',
                    'trm_sign_img_path' => '',
                ));
            }
            return $row;
        }, $rows);
    }

    public function getChequeReminderDetails($p)
    {
        return $this->paged($this->table('cheques'));
    }

    public function getSaleBalanceDetails($p)
    {
        $rows = array_map(function ($row) {
            $balance = (float) $this->value($row, 'cbpm_balance_amnt', 0);
            $total = (float) $this->value($row, 'cbpm_total_amnt', $balance + 1000);
            $received = (float) $this->value($row, 'cbpm_received_amnt', max(0, $total - $balance));
            return array_merge(array(
                'cbpd_product_type' => 'AMC / Service',
                'cbpm_total_amnt' => (string) $total,
                'cbpm_received_amnt' => (string) $received,
            ), $row);
        }, array_values($this->table('balances')));

        $result = $this->paged($rows, $p);
        $result['total_amount'] = (string) array_sum(array_map(function ($row) {
            return (float) $row['cbpm_total_amnt'];
        }, $rows));
        $result['received_Amount'] = (string) array_sum(array_map(function ($row) {
            return (float) $row['cbpm_received_amnt'];
        }, $rows));
        $result['balanced_Amount'] = (string) array_sum(array_map(function ($row) {
            return (float) $row['cbpm_balance_amnt'];
        }, $rows));
        return $result;
    }

    public function getCollectionDetails($p)
    {
        // The demo does not simulate posted receipts, but this endpoint must
        // preserve the production response envelope used by Daily Analysis.
        return array('jsArray' => array(), 'total_count' => '0', 'total_amount' => '0');
    }

    public function getAMCReminderDetails($p)
    {
        $rows = $this->table('amc_subscriptions');
        return $this->paged($rows);
    }

    /** Rows used by the three-table Service Analysis report. */
    public function getServiceAnalysisDetails($p)
    {
        $rows = array_filter($this->table('tickets'), function ($row) {
            return isset($row['ticket_type']) && $row['ticket_type'] === 'Servicing';
        });
        $rows = array_map(function ($row) {
            $row['clm_id'] = isset($row['clm_id']) ? $row['clm_id'] : '';
            $row['ticket_assign_to'] = isset($row['ticket_assign_to'])
                ? $row['ticket_assign_to'] : 'Demo Technician';
            return $row;
        }, $rows);
        return $this->paged($rows, $p);
    }

    public function getServicePendingAnalysisDetails($p)
    {
        $rows = $this->table('amc_service_visits');
        $wanted = $this->p($p, 'eleven');
        if ($wanted === 'Completed') {
            $rows = $this->whereEquals($rows, 'cust_serv_status', 'Completed');
        } elseif ($this->p($p, 'ten') !== NULL) {
            $rows = array_filter($rows, function ($row) {
                return !isset($row['cust_serv_status']) || $row['cust_serv_status'] !== 'Completed';
            });
        }
        return $this->paged($rows, $p);
    }

    /**
     * Dashboard::getBirthdayReminder() re-maps these rows and keeps only the
     * ones that already carry a birthday_type, so the seed supplies it.
     */
    public function getBirthdayReminderReport($p)
    {
        return $this->paged($this->table('birthdays'));
    }

    /**
     * Scrolling notification banner. The controller returns
     * $response['jsArray'], so the wrapper is required here too.
     */
    public function getNotificationDetails($p)
    {
        return $this->paged($this->table('notifications'));
    }

    /**
     * WhatsApp credit badge. Returned as-is and iterated directly by the
     * view, so this is a bare list of rows, not a paged wrapper.
     */
    public function getWhatsAppCount($p)
    {
        return array(
            array('user_wp_credit_count' => '1240'),
        );
    }

    // =====================================================================
    // SHARED LOOKUPS AND ORGANISATION
    // =====================================================================

    public function getPermissionMasterDetails($p)
    {
        return $this->filterLookup($this->table('permissions'), 'permission_id', $this->p($p, 'six'), 'permission_status', $this->p($p, 'four'));
    }

    public function getDepartmentMasterDetails($p)
    {
        return $this->filterLookup($this->table('departments'), 'dept_id', $this->p($p, 'six'), 'dept_status', $this->p($p, 'four'));
    }

    public function getSubdepartmentDetails($p)
    {
        return $this->filterLookup($this->table('subdepartments'), 'sub_dept_id', $this->p($p, 'six'), 'sub_dept_status', $this->p($p, 'four'));
    }

    public function getSubdepartmentDeptIdDetails($p)
    {
        $rows = $this->table('subdepartments');
        $deptId = $this->p($p, 'four');
        if ($deptId !== NULL) {
            $rows = $this->whereEquals($rows, 'sub_dept_deptid', $deptId);
        }
        return array_values($rows);
    }

    public function getEducationDetails($p)
    {
        return $this->filterLookup($this->table('education'), 'edu_id', $this->p($p, 'six'), 'edu_status', $this->p($p, 'four'));
    }

    public function getReferenceByDetails($p)
    {
        $rows = $this->filterLookup($this->table('references'), 'ref_id', $this->p($p, 'five'), 'ref_status', $this->p($p, 'four'));
        return $this->paged($rows);
    }

    public function getStateDetails($p)
    {
        return $this->filterLookup($this->table('states'), 'state_id', $this->p($p, 'six'), 'state_status', $this->p($p, 'four'));
    }

    public function getDistrictStateIdDetails($p)
    {
        $rows = $this->table('districts');
        $stateId = $this->p($p, 'four');
        if ($stateId !== NULL) {
            $rows = $this->whereEquals($rows, 'state_id', $stateId);
        }
        return array_values($rows);
    }

    public function getCityDistrictIdDetails($p)
    {
        $rows = $this->table('cities');
        $stateId = $this->p($p, 'four');
        $distId = $this->p($p, 'five');
        if ($stateId !== NULL) {
            $rows = $this->whereEquals($rows, 'state_id', $stateId);
        }
        if ($distId !== NULL) {
            $rows = $this->whereEquals($rows, 'dist_id', $distId);
        }
        return $this->paged($rows);
    }

    public function getAreaDetails($p)
    {
        return $this->filterLookup($this->table('areas'), 'area_id', $this->p($p, 'five'), 'area_status', $this->p($p, 'four'));
    }

    public function getAreaCityIdDetails($p)
    {
        $rows = $this->table('areas');
        $cityId = $this->p($p, 'six');
        if ($cityId !== NULL) {
            $rows = $this->whereEquals($rows, 'city_id', $cityId);
        }
        return $this->paged($rows);
    }

    public function getCustomerMasterReportDetails01($p)
    {
        return $this->getCustomerMasterReportDetails($p);
    }

    public function getCustomerMasterDetails($p)
    {
        $rows = $this->table('customers');
        $id = $this->p($p, 'four');
        if ($id !== NULL) {
            $rows = $this->whereEquals($rows, 'customer_id', $id);
            $rows = array_map(function ($row) use ($id) {
                // The customer detail view reads the legacy cust_status name.
                // Seed rows use customer_status; without this alias, an active
                // demo customer loses Add Follow-up and Make Payment actions.
                if (!isset($row['cust_status']) && isset($row['customer_status'])) {
                    $row['cust_status'] = $row['customer_status'];
                }
                $bills = $this->whereEquals($this->table('balances'), 'cbpm_custid', $id);
                $row['billPaymentList'] = array_map(function ($bill) {
                    $amount = isset($bill['cbpm_balance_amnt']) ? (float) $bill['cbpm_balance_amnt'] : 0;
                    $bill['cbpm_amount_nogst'] = isset($bill['cbpm_amount_nogst']) ? $bill['cbpm_amount_nogst'] : (string) ($amount + 1000);
                    $bill['cbpm_total_amnt'] = isset($bill['cbpm_total_amnt']) ? $bill['cbpm_total_amnt'] : $bill['cbpm_amount_nogst'];
                    $bill['cbpm_received_amnt'] = isset($bill['cbpm_received_amnt']) ? $bill['cbpm_received_amnt'] : '1000';
                    $bill['cbpm_adjustmentamnt'] = isset($bill['cbpm_adjustmentamnt']) ? $bill['cbpm_adjustmentamnt'] : '0';
                    $bill['cbpm_gsttype'] = isset($bill['cbpm_gsttype']) ? $bill['cbpm_gsttype'] : 'With GST';
                    $bill['gstAmount'] = isset($bill['gstAmount']) ? $bill['gstAmount'] : '0';
                    $bill['paymentHistoryList'] = isset($bill['paymentHistoryList']) ? $bill['paymentHistoryList'] : array();
                    // A few legacy views still read the database column using
                    // its original uppercase alias.
                    $bill['CBPM_ID'] = isset($bill['CBPM_ID']) ? $bill['CBPM_ID'] : (isset($bill['cbpm_id']) ? $bill['cbpm_id'] : '');
                    return $bill;
                }, array_values($bills));
                $subscriptions = $this->whereEquals($this->table('amc_subscriptions'), 'customer_id', $id);
                $row['subscriptionList'] = array_map(function ($subscription) use ($id, $bills) {
                    $subscription['cust_subs_custid'] = isset($subscription['cust_subs_custid']) ? $subscription['cust_subs_custid'] : $id;
                    $subscription['cust_subs_type_name'] = isset($subscription['cust_subs_type_name'])
                        ? $subscription['cust_subs_type_name']
                        : (isset($subscription['amc_name']) ? $subscription['amc_name'] : 'AMC');
                    $firstBill = reset($bills);
                    $subscription['cust_subs_cbpmid'] = isset($subscription['cust_subs_cbpmid'])
                        ? $subscription['cust_subs_cbpmid']
                        : (is_array($firstBill) && isset($firstBill['cbpm_id']) ? $firstBill['cbpm_id'] : '');
                    return $subscription;
                }, array_values($subscriptions));
                // The detail view expects each service visit inside its AMC,
                // not a flat visit row. Keep the tour's Schedule/Cancel controls
                // visible for the seeded customer.
                $visits = array_values($this->whereEquals($this->table('amc_service_visits'), 'customer_id', $id));
                $row['subscriptionServiceList'] = array_map(function ($subscription) use ($visits) {
                    $subscription['cust_subs_type_name'] = $subscription['amc_name'];
                    $subscription['cust_subs_type'] = 'AMC';
                    $subscription['cust_subs_price'] = $subscription['contract_value'];
                    $subscription['cust_subs_noofserv_done'] = $subscription['services_completed'];
                    $subscription['cust_subs_noofserv'] = $subscription['services_total'];
                    $subscription['cust_subs_noofserv_remining'] = (string) max(0, (int) $subscription['services_total'] - (int) $subscription['services_completed']);
                    $subscription['serviceList'] = array_values(array_filter($visits, function ($visit) use ($subscription) {
                        return $visit['cust_subs_id'] === $subscription['cust_subs_id'];
                    }));
                    return $subscription;
                }, array_values($subscriptions));
                $row['ticketList'] = array_values($this->whereEquals($this->table('tickets'), 'customer_id', $id));
                $row['followupList'] = array_values($this->whereEquals($this->table('followups'), 'customer_id', $id));
                $row['complaintList'] = array();
                $row['expireSubsList'] = array();
                $row['installments'] = array();
                $row['actvDeactvList'] = array();
                return $row;
            }, array_values($rows));
        }
        return array_values($rows);
    }

    public function getCompanyMasterDetails($p)
    {
        return array(array(
            'company_id' => self::DEMO_COMPANY_ID,
            'company_name' => 'Demo Systems Pvt Ltd',
            'company_status' => 'Active',
            'company_branchid' => self::DEMO_BRANCH_ID,
        ));
    }

    public function getEmployeeReportDetails($p)
    {
        $rows = $this->table('employees');
        $empId = $this->p($p, 'four');
        $status = $this->p($p, 'five');
        $search = $this->p($p, 'six');
        $permission = $this->p($p, 'seven');
        $department = $this->p($p, 'eight');
        $subDepartment = $this->p($p, 'ten', $this->p($p, 'nine'));

        if ($empId !== NULL) $rows = $this->whereEquals($rows, 'emp_id', $empId);
        if ($status !== NULL && $status !== 'All') $rows = $this->whereEquals($rows, 'emp_status', $status);
        if ($permission !== NULL) $rows = $this->whereEquals($rows, 'emp_permissionid', $permission);
        if ($department !== NULL) $rows = $this->whereEquals($rows, 'emp_departmentid', $department);
        if ($subDepartment !== NULL) $rows = $this->whereEquals($rows, 'emp_subdepartmentid', $subDepartment);
        if ($search !== NULL) {
            $needle = strtolower($search);
            $rows = array_filter($rows, function ($row) use ($needle) {
                return strpos(strtolower($row['emp_name'] . ' ' . $row['emp_mob1'] . ' ' . $row['user_name']), $needle) !== FALSE;
            });
        }
        return $this->paged($rows);
    }

    public function getEmployeeDetails($p)
    {
        $result = $this->getEmployeeReportDetails($p);
        return array_map(function ($row) {
            // Synthetic credentials only; never expose real employee passwords.
            $row['user_pswd'] = 'demo123';
            // No identity documents are bundled with synthetic demo employees.
            $row['emp_image_path'] = isset($row['emp_image_path']) ? $row['emp_image_path'] : '';
            if (empty($row['empKycList'])) {
                $row['empKycList'] = array(array(
                    'emp_kyc_photo1' => '', 'emp_kyc_type1' => '',
                    'emp_addrs_prf_img' => '', 'emp_addrs_prf_type' => '',
                ));
            }
            return $row;
        }, $result['jsArray']);
    }

    public function getEmployeeAttendanceDetails01($p)
    {
        $rows = $this->table('attendance');
        $empId = $this->p($p, 'four');
        if ($empId !== NULL && $empId !== '') {
            $rows = $this->whereEquals($rows, 'emp_id', $empId);
        }
        return array(
            'present_count' => count($rows),
            'absent_count' => 0,
            'jsArray' => array_values($rows),
            'total_count' => count($rows),
        );
    }

    public function getInvSupplierReportDetails($p)
    {
        $rows=$this->table('suppliers');
        $status=$this->p($p,'four'); $id=$this->p($p,'five'); $search=strtolower((string)$this->p($p,'six',''));
        if($status && $status!=='All') $rows=$this->whereEquals($rows,'supp_status',$status);
        if($id!==NULL) $rows=array_filter($rows,function($r)use($id){return (string)$r['supp_id']===(string)$id || (string)$r['supp_det_id']===(string)$id;});
        if($search!=='') $rows=array_filter($rows,function($r)use($search){return strpos(strtolower($r['supp_name'].' '.$r['supp_det_contact'].' '.$r['supp_det_mob1']),$search)!==FALSE;});
        return $this->paged($rows);
    }

    public function getInvSupplierMasterDetails($p)
    {
        $r=$this->getInvSupplierReportDetails($p); return $r['jsArray'];
    }

    public function getInvItemMasterReportDetails($p)
    {
        $rows=$this->table('inventory_items'); $search=strtolower((string)$this->p($p,'five','')); $status=$this->p($p,'six');
        if($status && $status!=='All') $rows=$this->whereEquals($rows,'item_status',$status);
        if($search!=='') $rows=array_filter($rows,function($r)use($search){return strpos(strtolower($r['item_name'].' '.$r['item_code'].' '.$r['inv_brand_name']),$search)!==FALSE;});
        return $this->paged($rows);
    }

    public function getDirectReporting($p)
    {
        return array_values($this->table('employees'));
    }

    public function checkEmployeeMobile($p)
    {
        $mobile = $this->p($p, 'one', '');
        foreach ($this->table('employees') as $employee) {
            if ((string) $employee['emp_mob1'] === (string) $mobile) return 'MOBILE_EXISTS';
        }
        return 'AVAILABLE';
    }

    public function setEmployeeDetails($p)
    {
        $mobile = $this->p($p, 'six', '');
        foreach ($this->table('employees') as $employee) {
            if ((string) $employee['emp_mob1'] === (string) $mobile) return 'MOBILE_EXISTS';
        }

        $permissionId = $this->p($p, 'fourtytwo', '6');
        $departmentId = $this->p($p, 'fourtythree', '203');
        $subDepartmentId = $this->p($p, 'fourtyfour', '');
        $id = MockSeed::nextId('employees', 'emp_id');
        $name = $this->p($p, 'five', 'Demo Employee');

        MockSeed::upsert('employees', 'emp_id', array(
            'emp_id' => $id,
            'user_id' => (string) (9000 + (int) $id),
            'user_name' => 'employee' . $id,
            'emp_name' => $name,
            'user_person_name' => $name,
            'emp_mob1' => $mobile,
            'emp_mob2' => $this->p($p, 'seven', ''),
            'emp_emailid' => $this->p($p, 'eight', ''),
            'emp_permissionid' => $permissionId,
            'permission_name' => $this->lookupName('permissions', 'permission_id', $permissionId, 'permission_name'),
            'emp_departmentid' => $departmentId,
            'dept_name' => $this->lookupName('departments', 'dept_id', $departmentId, 'dept_name'),
            'emp_subdepartmentid' => $subDepartmentId,
            'sub_dept_name' => $this->lookupName('subdepartments', 'sub_dept_id', $subDepartmentId, 'sub_dept_name'),
            'emp_rpt_to' => $this->p($p, 'fourtysix', '5001'),
            'emp_rpt_name' => 'Demo Admin',
            'emp_status' => 'Active',
            'emp_location_tracking' => $this->p($p, 'fiftyfive', 'No'),
            'emp_branchid' => self::DEMO_BRANCH_ID,
            'emp_companyid' => self::DEMO_COMPANY_ID,
        ));
        return 'Success';
    }

    public function getIntegrationDetails($p)
    {
        return array(array(
            'integration_id' => '1',
            'integration_key' => 'INDIAMART',
            'integration_name' => 'IndiaMART',
            'integration_status' => 'Configured',
            'api_key' => 'DEMO-ONLY',
        ));
    }

    public function status($p)
    {
        return array(
            'status' => 'CONNECTED',
            'page_name' => 'MI-BTrack Demo Page',
            'forms_count' => 2,
            'last_sync' => date('d-M-Y H:i'),
        );
    }

    protected function filterLookup($rows, $idField, $id, $statusField, $status)
    {
        if ($id !== NULL) $rows = $this->whereEquals($rows, $idField, $id);
        if ($status !== NULL && $status !== 'All') $rows = $this->whereEquals($rows, $statusField, $status);
        return array_values($rows);
    }

    protected function lookupName($table, $idField, $id, $nameField)
    {
        foreach ($this->table($table) as $row) {
            if (isset($row[$idField]) && (string) $row[$idField] === (string) $id) {
                return isset($row[$nameField]) ? $row[$nameField] : '';
            }
        }
        return '';
    }
}
