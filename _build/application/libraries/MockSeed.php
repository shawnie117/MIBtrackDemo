<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DEMO BUILD RIG - Seed dataset + write overlay
 * -------------------------------------------------------------------------
 * Seed tables are immutable baseline data. Anything a trainee creates or
 * edits during a session lands in an overlay so their sandbox is isolated
 * and resettable, and the baseline is never corrupted.
 *
 * In the exported static build this role is taken over by demo-runtime.js
 * writing to localStorage. Same idea, same table names, so the two stay
 * interchangeable.
 *
 * ALL DATA IS SYNTHETIC.
 */
class MockSeed
{
    protected static $cache = array();

    // ---------------------------------------------------------------------
    // Demo logins
    // ---------------------------------------------------------------------

    public static function accounts()
    {
        return array(
            array(
                'username'      => 'demo',
                'password'      => 'demo123',
                'user_id'       => '9001',
                'emp_id'        => '5001',
                'permission_id' => '1',              // SUPER_ADMIN_ROLE_ID: full menu
                'person_name'   => 'Demo Admin',
                'designation'   => 'Super Admin',
                'mobile'        => '9800000001',
                'email'         => 'demo.admin@example.com',
            ),
            array(
                'username'      => 'sales',
                'password'      => 'demo123',
                'user_id'       => '9002',
                'emp_id'        => '5002',
                'permission_id' => '3',              // SALES_ROLE_ID
                'person_name'   => 'Demo Sales',
                'designation'   => 'Sales Executive',
                'mobile'        => '9800000002',
                'email'         => 'demo.sales@example.com',
            ),
        );
    }

    // ---------------------------------------------------------------------
    // Table access
    // ---------------------------------------------------------------------

    public static function table($name)
    {
        if (isset(self::$cache[$name])) {
            return self::$cache[$name];
        }

        $rows = self::seed($name);
        // Replace only the built-in attendance example for this employee/day.
        // Trainee overlay rows are merged afterwards and are never removed.
        if ($name === 'attendance' && !empty($_SESSION['demo_story']['attendance']['emp_attd_login'])) {
            $storyAttendance=$_SESSION['demo_story']['attendance'];
            $rows=array_values(array_filter($rows,function($row)use($storyAttendance){
                return $row['emp_id']!==$storyAttendance['emp_id'] ||
                    substr($row['emp_attd_login'],0,10)!==substr($storyAttendance['emp_attd_login'],0,10);
            }));
        }

        // Apply this session's overlay: created rows appended, edited rows
        // replaced by primary key, deactivated rows status-flipped.
        $overlay = self::overlay();
        if (isset($overlay[$name])) {
            $rows = self::merge($rows, $overlay[$name]);
        }
        // Separate tour-owned records: normal forms and reports see them,
        // but preparing/replaying a tour never changes the trainee overlay.
        $storyKey = $name === 'tickets' ? 'ticket' : ($name === 'attendance' ? 'attendance' : null);
        if ($storyKey && !empty($_SESSION['demo_story'][$storyKey])) {
            $row = $_SESSION['demo_story'][$storyKey];
            if ($storyKey !== 'attendance' || !empty($row['emp_attd_login'])) {
                $rows = self::merge($rows, array('pk'=>$storyKey==='ticket'?'ticket_id':'emp_attd_id','upsert'=>array($row)));
            }
        }

        self::$cache[$name] = $rows;
        return $rows;
    }

    protected static function merge($rows, $changes)
    {
        $pk = isset($changes['pk']) ? $changes['pk'] : NULL;

        if ($pk !== NULL && !empty($changes['upsert'])) {
            foreach ($changes['upsert'] as $row) {
                $found = FALSE;
                foreach ($rows as $i => $existing) {
                    if (isset($existing[$pk], $row[$pk]) && (string) $existing[$pk] === (string) $row[$pk]) {
                        $rows[$i] = array_merge($existing, $row);
                        $found = TRUE;
                        break;
                    }
                }
                if (!$found) {
                    $rows[] = $row;
                }
            }
        }

        return $rows;
    }

    protected static function overlay()
    {
        if (!isset($_SESSION['demo_overlay']) || !is_array($_SESSION['demo_overlay'])) {
            return array();
        }
        return $_SESSION['demo_overlay'];
    }

    /**
     * Record a create/update against a table for this session only.
     */
    public static function upsert($table, $pk, array $row)
    {
        if (!isset($_SESSION['demo_overlay'])) {
            $_SESSION['demo_overlay'] = array();
        }
        if (!isset($_SESSION['demo_overlay'][$table])) {
            $_SESSION['demo_overlay'][$table] = array('pk' => $pk, 'upsert' => array());
        }
        $_SESSION['demo_overlay'][$table]['upsert'][] = $row;
        unset(self::$cache[$table]);
    }

    public static function reset()
    {
        unset($_SESSION['demo_overlay']);
        unset($_SESSION['demo_story']);
        self::$cache = array();
    }

    public static function clearCache() { self::$cache = array(); }

    /**
     * Next id for a table, so created records get believable sequential ids.
     */
    public static function nextId($table, $pk)
    {
        $max = 0;
        // An attendance slot is reserved before its Login event is visible.
        foreach (isset($_SESSION['demo_story'])?$_SESSION['demo_story']:array() as $reserved) {
            if (is_array($reserved) && isset($reserved[$pk])) $max=max($max,(int)$reserved[$pk]);
        }
        foreach (self::table($table) as $r) {
            if (isset($r[$pk]) && is_numeric($r[$pk]) && (int) $r[$pk] > $max) {
                $max = (int) $r[$pk];
            }
        }
        return (string) ($max + 1);
    }

    // =====================================================================
    // SEED TABLES
    // =====================================================================

    protected static function seed($name)
    {
        $method = 'seed_' . $name;
        if (method_exists(__CLASS__, $method)) {
            return self::$method();
        }
        return array();
    }

    protected static function seed_branches()
    {
        return array(
            array(
                'branch_id'             => '104',
                'branch_name'           => 'Kharghar (Head Office)',
                'branch_contact'        => '9800000010',
                'branch_contact_person' => 'Demo Admin',
                'branch_details'        => 'Head office and central service desk',
                'branch_address'        => 'Office No 409, 4th Floor, Sector 10, Kharghar, Navi Mumbai 410210',
                'branch_status'         => 'Active',
                'branch_companyid'      => '175',
            ),
            array(
                'branch_id'             => '105',
                'branch_name'           => 'Pune Branch',
                'branch_contact'        => '9800000011',
                'branch_contact_person' => 'Anjali Deshmukh',
                'branch_details'        => 'Western Pune sales and service',
                'branch_address'        => 'Plot 22, Baner Road, Pune 411045',
                'branch_status'         => 'Active',
                'branch_companyid'      => '175',
            ),
            array(
                'branch_id'             => '106',
                'branch_name'           => 'Nashik Branch',
                'branch_contact'        => '9800000012',
                'branch_contact_person' => 'Rohit Pawar',
                'branch_details'        => 'Nashik regional office',
                'branch_address'        => 'Shop 8, College Road, Nashik 422005',
                'branch_status'         => 'Active',
                'branch_companyid'      => '175',
            ),
            array(
                'branch_id'             => '107',
                'branch_name'           => 'Thane Depot (closed)',
                'branch_contact'        => '9800000013',
                'branch_contact_person' => 'Sunil Kale',
                'branch_details'        => 'Consolidated into Head Office',
                'branch_address'        => 'Unit 3, Wagle Estate, Thane 400604',
                'branch_status'         => 'Deactivated',
                'branch_companyid'      => '175',
            ),
        );
    }

    // ---------------------------------------------------------------------
    // Organisation and shared lookup masters
    // ---------------------------------------------------------------------

    protected static function seed_permissions()
    {
        return array(
            array('permission_id' => '1', 'permission_name' => 'Super Admin', 'permission_status' => 'Active'),
            array('permission_id' => '2', 'permission_name' => 'Admin', 'permission_status' => 'Active'),
            array('permission_id' => '3', 'permission_name' => 'Sales', 'permission_status' => 'Active'),
            array('permission_id' => '4', 'permission_name' => 'Technician', 'permission_status' => 'Active'),
            array('permission_id' => '6', 'permission_name' => 'Employee', 'permission_status' => 'Active'),
        );
    }

    protected static function seed_departments()
    {
        return array(
            array('dept_id' => '201', 'dept_name' => 'Sales', 'dept_status' => 'Active'),
            array('dept_id' => '202', 'dept_name' => 'Service', 'dept_status' => 'Active'),
            array('dept_id' => '203', 'dept_name' => 'Operations', 'dept_status' => 'Active'),
            array('dept_id' => '204', 'dept_name' => 'Accounts', 'dept_status' => 'Active'),
            array('dept_id' => '205', 'dept_name' => 'Servicing', 'dept_status' => 'Active'),
        );
    }

    protected static function seed_subdepartments()
    {
        return array(
            array('sub_dept_id' => '301', 'sub_dept_name' => 'Field Sales', 'sub_dept_deptid' => '201', 'dept_id' => '201', 'dept_name' => 'Sales', 'sub_dept_status' => 'Active'),
            array('sub_dept_id' => '302', 'sub_dept_name' => 'Inside Sales', 'sub_dept_deptid' => '201', 'dept_id' => '201', 'dept_name' => 'Sales', 'sub_dept_status' => 'Active'),
            array('sub_dept_id' => '304', 'sub_dept_name' => 'Maintenance', 'sub_dept_deptid' => '202', 'dept_id' => '202', 'dept_name' => 'Service', 'sub_dept_status' => 'Active'),
            array('sub_dept_id' => '303', 'sub_dept_name' => 'Installation', 'sub_dept_deptid' => '202', 'dept_id' => '202', 'dept_name' => 'Service', 'sub_dept_status' => 'Active'),
            array('sub_dept_id' => '304', 'sub_dept_name' => 'Maintenance', 'sub_dept_deptid' => '202', 'dept_id' => '202', 'dept_name' => 'Service', 'sub_dept_status' => 'Active'),
        );
    }

    protected static function seed_education()
    {
        return array(
            array('edu_id' => '401', 'education_id' => '401', 'edu_name' => 'Graduate', 'education_name' => 'Graduate', 'edu_status' => 'Active'),
            array('edu_id' => '402', 'education_id' => '402', 'edu_name' => 'Diploma', 'education_name' => 'Diploma', 'edu_status' => 'Active'),
            array('edu_id' => '403', 'education_id' => '403', 'edu_name' => 'Technical Certification', 'education_name' => 'Technical Certification', 'edu_status' => 'Active'),
        );
    }

    protected static function seed_references()
    {
        return array(
            array('ref_id' => '501', 'ref_name' => 'Customer Referral', 'ref_contact_per' => 'Demo Contact', 'ref_mobile_no' => '9800000101', 'ref_email' => 'referral@example.com', 'ref_addr' => 'Navi Mumbai', 'ref_details' => 'Existing customer referral', 'ref_status' => 'Active'),
            array('ref_id' => '502', 'ref_name' => 'IndiaMART', 'ref_contact_per' => '', 'ref_mobile_no' => '', 'ref_email' => '', 'ref_addr' => '', 'ref_details' => 'IndiaMART Lead API', 'ref_status' => 'Active'),
            array('ref_id' => '503', 'ref_name' => 'Facebook Lead API', 'ref_contact_per' => '', 'ref_mobile_no' => '', 'ref_email' => '', 'ref_addr' => '', 'ref_details' => 'Facebook / Meta Lead Ads', 'ref_status' => 'Active'),
            array('ref_id' => '504', 'ref_name' => 'Website Enquiry', 'ref_contact_per' => '', 'ref_mobile_no' => '', 'ref_email' => '', 'ref_addr' => '', 'ref_details' => 'Company website enquiry', 'ref_status' => 'Active'),
            array('ref_id' => '505', 'ref_name' => 'Google', 'ref_contact_per' => 'Manoj Vajpayee', 'ref_mobile_no' => '4114554547', 'ref_email' => 'manoj@gmail.com', 'ref_addr' => '', 'ref_details' => 'Google enquiry source', 'ref_status' => 'Active'),
        );
    }

    protected static function seed_states()
    {
        return array(
            array('state_id' => '27', 'state_name' => 'Maharashtra', 'state_status' => 'Active'),
            array('state_id' => '24', 'state_name' => 'Gujarat', 'state_status' => 'Active'),
        );
    }

    protected static function seed_districts()
    {
        return array(
            array('dist_id' => '2701', 'district_id' => '2701', 'dist_name' => 'Raigad', 'district_name' => 'Raigad', 'dist_stateid' => '27', 'state_id' => '27', 'dist_status' => 'Active'),
            array('dist_id' => '2702', 'district_id' => '2702', 'dist_name' => 'Pune', 'district_name' => 'Pune', 'dist_stateid' => '27', 'state_id' => '27', 'dist_status' => 'Active'),
            array('dist_id' => '2401', 'district_id' => '2401', 'dist_name' => 'Ahmedabad', 'district_name' => 'Ahmedabad', 'dist_stateid' => '24', 'state_id' => '24', 'dist_status' => 'Active'),
        );
    }

    protected static function seed_cities()
    {
        return array(
            array('city_id' => '270101', 'city_name' => 'Navi Mumbai', 'city_distid' => '2701', 'dist_id' => '2701', 'city_stateid' => '27', 'state_id' => '27', 'city_status' => 'Active'),
            array('city_id' => '270201', 'city_name' => 'Pune', 'city_distid' => '2702', 'dist_id' => '2702', 'city_stateid' => '27', 'state_id' => '27', 'city_status' => 'Active'),
            array('city_id' => '240101', 'city_name' => 'Ahmedabad', 'city_distid' => '2401', 'dist_id' => '2401', 'city_stateid' => '24', 'state_id' => '24', 'city_status' => 'Active'),
        );
    }

    protected static function seed_areas()
    {
        return array(
            array('area_id' => '601', 'area_name' => 'Kharghar', 'area_cityid' => '270101', 'city_id' => '270101', 'area_status' => 'Active'),
            array('area_id' => '602', 'area_name' => 'Vashi', 'area_cityid' => '270101', 'city_id' => '270101', 'area_status' => 'Active'),
            array('area_id' => '603', 'area_name' => 'Baner', 'area_cityid' => '270201', 'city_id' => '270201', 'area_status' => 'Active'),
        );
    }

    protected static function seed_employees()
    {
        return array(
            array('emp_id' => '5001', 'user_id' => '9001', 'user_name' => 'demo', 'emp_name' => 'Demo Admin', 'user_person_name' => 'Demo Admin', 'emp_mob1' => '9800000001', 'emp_mob2' => '', 'emp_emailid' => 'demo.admin@example.com', 'emp_permissionid' => '1', 'permission_name' => 'Super Admin', 'emp_departmentid' => '203', 'dept_name' => 'Operations', 'emp_subdepartmentid' => '', 'sub_dept_name' => '', 'emp_rpt_to' => '', 'emp_rpt_name' => '', 'emp_status' => 'Active', 'emp_location_tracking' => 'No', 'emp_branchid' => '104', 'emp_companyid' => '175'),
            array('emp_id' => '5002', 'user_id' => '9002', 'user_name' => 'sales', 'emp_name' => 'Demo Sales', 'user_person_name' => 'Demo Sales', 'emp_mob1' => '9800000002', 'emp_mob2' => '', 'emp_emailid' => 'demo.sales@example.com', 'emp_permissionid' => '3', 'permission_name' => 'Sales', 'emp_departmentid' => '201', 'dept_name' => 'Sales', 'emp_subdepartmentid' => '301', 'sub_dept_name' => 'Field Sales', 'emp_rpt_to' => '5001', 'emp_rpt_name' => 'Demo Admin', 'emp_status' => 'Active', 'emp_location_tracking' => 'Yes', 'emp_branchid' => '104', 'emp_companyid' => '175'),
            array('emp_id' => '5003', 'user_id' => '9003', 'user_name' => 'technician', 'emp_name' => 'Demo Technician', 'user_person_name' => 'Demo Technician', 'emp_mob1' => '9800000003', 'emp_mob2' => '', 'emp_emailid' => 'demo.technician@example.com', 'emp_permissionid' => '4', 'permission_name' => 'Technician', 'emp_departmentid' => '202', 'dept_name' => 'Service', 'emp_subdepartmentid' => '304', 'sub_dept_name' => 'Maintenance', 'emp_rpt_to' => '5001', 'emp_rpt_name' => 'Demo Admin', 'emp_status' => 'Active', 'emp_location_tracking' => 'Yes', 'emp_branchid' => '104', 'emp_companyid' => '175'),
            array('emp_id' => '5004', 'user_id' => '9004', 'user_name' => 'neha.kulkarni', 'emp_name' => 'Neha Kulkarni', 'user_person_name' => 'Neha Kulkarni', 'emp_mob1' => '9800000004', 'emp_mob2' => '', 'emp_emailid' => 'neha.kulkarni@example.com', 'emp_permissionid' => '4', 'permission_name' => 'Technician', 'emp_departmentid' => '202', 'dept_name' => 'Service', 'emp_subdepartmentid' => '304', 'sub_dept_name' => 'Maintenance', 'emp_rpt_to' => '5001', 'emp_rpt_name' => 'Demo Admin', 'emp_status' => 'Active', 'emp_location_tracking' => 'Yes', 'emp_branchid' => '104', 'emp_companyid' => '175'),
            array('emp_id' => '5005', 'user_id' => '9005', 'user_name' => 'prajyot', 'emp_name' => 'Prajyot', 'user_person_name' => 'Prajyot', 'emp_mob1' => '8546951251', 'emp_mob2' => '', 'emp_emailid' => 'prajyot@example.com', 'emp_permissionid' => '6', 'permission_name' => 'Employee', 'emp_departmentid' => '205', 'dept_name' => 'Servicing', 'emp_subdepartmentid' => '', 'sub_dept_name' => '', 'emp_rpt_to' => '5001', 'emp_rpt_name' => 'Demo Admin', 'emp_status' => 'Active', 'emp_location_tracking' => 'Yes', 'emp_joining_date' => '12-12-2012', 'emp_address' => 'kiran apartment, Shambhu nagar, Mumbai.', 'emp_branchid' => '104', 'emp_companyid' => '175'),
        );
    }

    protected static function seed_attendance()
    {
        return array(
            array(
                'emp_attd_id' => '1', 'emp_id' => '5005', 'emp_name' => 'Prajyot',
                'emp_attd_login' => date('Y-m-d') . ' 09:15:00',
                'emp_attd_logout' => date('Y-m-d') . ' 18:05:00',
                'emp_attd_status' => 'Deactivated',
                'empIn_address' => 'Shambhu Nagar, Mumbai',
                'empOut_address' => 'Shambhu Nagar, Mumbai',
                'emp_attd_login_img' => base_url('assets/images/default_user.png'),
                'emp_attd_logout_img' => base_url('assets/images/default_user.png'),
                'loglongt' => '72.8777', 'loglatt' => '19.0760',
                'outlongt' => '72.8777', 'outlatt' => '19.0760',
            ),
        );
    }

    // ---------------------------------------------------------------------
    // Catalogue
    // ---------------------------------------------------------------------

    protected static function seed_products()
    {
        $rows = array(
            array('CCTV Dome Camera 2MP',      'DOME-2MP',   'Hikvision', 2400,  2100),
            array('CCTV Bullet Camera 5MP',    'BULT-5MP',   'CP Plus',   4200,  3800),
            array('8 Channel DVR',             'DVR-08',     'Hikvision', 6800,  6200),
            array('16 Channel NVR',            'NVR-16',     'Dahua',    12500, 11400),
            array('Biometric Attendance Unit', 'BIO-X100',   'eSSL',      9500,  8700),
            array('Access Control Panel',      'ACP-4D',     'Matrix',   15800, 14500),
            array('Video Door Phone',          'VDP-7IN',    'Godrej',    8900,  8100),
            array('2TB Surveillance HDD',      'HDD-2TB-SV', 'Seagate',   5600,  5100),
            array('Fire Alarm Panel',           'FIRE-4Z',    'Demo Fire', 9800,  9000),
            array('Residential Intercom Unit',  'INT-RES',    'Demo Com',  4200,  3900),
            array('Rat Repellent',              'RAT-REP',    'Black Hit', 1500,  1200),
        );

        $out = array();
        $i = 3001;
        foreach ($rows as $r) {
            $out[] = array(
                'pm_id'                => (string) $i,
                'product_id'           => (string) $i,
                'pm_name'              => $r[0],
                'product_name'         => $r[0],
                'pm_model_name'        => $r[1],
                'brand_name'           => $r[2],
                'pm_regular_price'     => (string) $r[3],
                'pm_commercial_price'  => (string) $r[4],
                'product_price'        => (string) $r[3],
                'pm_status'            => 'Active',
                'product_status'       => 'Active',
                'service_type'         => 'Product',
                'pm_hsn_code'          => '85258900',
                'pm_gst'               => '18',
            );
            $i++;
        }
        return $out;
    }

    protected static function seed_suppliers()
    {
        return array(
            array('supp_id'=>'1101','supp_det_id'=>'2101','supp_name'=>'SecureVision Distributors','supp_det_contact'=>'Rakesh Shah','supp_det_mob1'=>'9819001101','supp_det_address'=>'Turbhe MIDC, Navi Mumbai','supp_status'=>'Active'),
            array('supp_id'=>'1102','supp_det_id'=>'2102','supp_name'=>'DigiSafe Systems','supp_det_contact'=>'Priya Menon','supp_det_mob1'=>'9819001102','supp_det_address'=>'Andheri East, Mumbai','supp_status'=>'Active'),
            array('supp_id'=>'1103','supp_det_id'=>'2103','supp_name'=>'AccessPro India','supp_det_contact'=>'Nitin Patil','supp_det_mob1'=>'9819001103','supp_det_address'=>'Baner, Pune','supp_status'=>'Active'),
        );
    }

    protected static function seed_inventory_items()
    {
        $out=array(); $i=1201;
        foreach (self::seed_products() as $index=>$p) {
            $out[]=array('item_id'=>(string)$i++,'item_name'=>$p['pm_name'],'item_code'=>$p['pm_model_name'],
                'item_price'=>$p['pm_regular_price'],'item_price2'=>$p['pm_commercial_price'],
                'item_status'=>'Active','inv_brand_name'=>$p['brand_name'],'item_gst'=>$p['pm_gst'],
                'item_qty'=>(string)(18+$index*7),'item_unitid'=>'Nos','item_bufferline'=>'10','supp_id'=>'1101');
        }
        return $out;
    }

    protected static function seed_amc_services()
    {
        $rows = array(
            array('CCTV AMC - Basic',              'AMC-CCTV-B', 365,  6000,  7200, 18, 4, '3001'),
            array('CCTV AMC - Comprehensive',      'AMC-CCTV-C', 365, 11000, 13500, 18, 4, '3002'),
            array('Biometric AMC - Annual',        'AMC-BIO-A',  365,  4500,  5600, 18, 3, '3005'),
            array('Access Control AMC',            'AMC-ACC',    365,  8000,  9800, 18, 4, '3006'),
            array('Fire Alarm AMC - Standard',     'AMC-FIRE-S', 365,  9500, 12000, 18, 4, '3009'),
            array('Intercom AMC - Residential',    'AMC-INT-R',  365,  5200,  6500, 18, 2, '3010'),
            array('CCTV Premium 24x7',             'AMC-CCTV-24',365, 18500, 22500, 18, 6, '3001'),
            array('Multi-System Facility AMC',     'AMC-MULTI',  730, 32000, 39000, 18, 8, '3006'),
            array('General Pest Management',       'AMC-GPM',    365,  2000,  1900, 18, 6, '3011'),
        );

        $products = array();
        foreach (self::seed_products() as $product) $products[$product['pm_id']] = $product;
        $out = array();
        $i = 4001;
        foreach ($rows as $r) {
            $out[] = array(
                'amc_id'          => (string) $i,
                'product_id'      => $r[7],
                'amc_name'        => $r[0],
                'product_name'    => $products[$r[7]]['pm_name'],
                'amc_code'        => $r[1],
                'amc_duration'    => (string) $r[2],
                'amc_price'       => (string) $r[3],
                'amc_corporate_price' => (string) $r[4],
                'amc_gst'         => (string) $r[5],
                'amc_desc'        => $r[0] . ' with planned preventive visits and demo support coverage.',
                'product_price'   => (string) $r[3],
                'amc_status'      => 'Active',
                'product_status'  => 'Active',
                'service_type'    => 'AMC',
                'no_of_services'  => (string) $r[6],
                'amc_noofservices'=> (string) $r[6],
                'amc_sit'         => (string) max(1, (int) ceil($r[2] / $r[6])),
                'amc_addedbyname' => 'Demo Admin',
                'amc_addeddate_n' => self::day(-60),
            );
            $i++;
        }
        return $out;
    }

    /**
     * Dates are generated relative to "today" rather than hard-coded, so the
     * dashboard reminders stay populated whenever the demo is run instead of
     * silently going empty once a fixed date drifts into the past.
     *
     * Production "_n" date fields arrive as upper-case d-M-Y (e.g. 31-AUG-2026)
     * and some views feed them straight to strtotime(), which parses that.
     */
    protected static function day($offsetDays = 0)
    {
        return strtoupper(date('d-M-Y', strtotime($offsetDays . ' days')));
    }

    protected static function seed_ots_services()
    {
        $rows = array(
            array('CCTV Installation',        'OTS-INST',  3500),
            array('Camera Repositioning',     'OTS-REPO',  1200),
            array('DVR Configuration',        'OTS-DVRC',  1800),
            array('Cable Laying per 100ft',   'OTS-CABLE',  900),
            array('Emergency Site Visit',     'OTS-VISIT',  750),
        );

        $out = array();
        $i = 4501;
        foreach ($rows as $r) {
            $out[] = array(
                'ots_id'         => (string) $i,
                'product_id'     => (string) $i,
                'ots_name'       => $r[0],
                'product_name'   => $r[0],
                'ots_code'       => $r[1],
                'ots_price'      => (string) $r[2],
                'product_price'  => (string) $r[2],
                'ots_status'     => 'Active',
                'product_status' => 'Active',
                'service_type'   => 'OTS',
            );
            $i++;
        }
        return $out;
    }

    // ---------------------------------------------------------------------
    // Customers / leads
    // ---------------------------------------------------------------------

    protected static function seed_customers()
    {
        $rows = array(
            //  id,   name,                     contact,      email,                          status,     added
            array('6001', 'TechVista Solutions',    '9820011001', 'accounts@techvista.example',    'Active',  -240),
            array('6002', 'GreenLeaf Industries',   '9820011002', 'ops@greenleaf.example',         'Active',  -195),
            array('6003', 'Nova Retail Mart',       '9820011003', 'admin@novaretail.example',      'Active',  -160),
            array('6004', 'Skyline Builders',       '9820011004', 'purchase@skyline.example',      'Active',  -120),
            array('6005', 'Heritage Hotels',        '9820011005', 'it@heritagehotels.example',     'Active',   -84),
            array('6006', 'FreshMart Superstores',  '9820011006', 'support@freshmart.example',     'Pending',   -6),
            array('6007', 'EcoPack Industries',     '9820011007', 'care@ecopack.example',          'Pending',   -3),
            array('6008', 'Bluewave Diagnostics',   '9820011008', 'front@bluewave.example',        'Pending',   -1),
            array('6009', 'Aster Heights Society',  '9820011009', 'office@asterheights.example',    'Active',   -45),
            array('6010', 'Orion Business Park',    '9820011010', 'facility@orionpark.example',     'Active',  -310),
            array('6011', 'Little Steps School',    '9820011011', 'admin@littlesteps.example',      'Active',  -100),
            array('6012', 'Seabreeze Residency',    '9820011012', 'manager@seabreeze.example',      'Active',  -380),
            array('6013', 'Adinath Mhaske',          '4152488895', 'aadinath@gmail.com',              'Active',     0),
        );

        $out = array();
        foreach ($rows as $r) {
            $out[] = array(
                'customer_id'            => $r[0],
                'customer_name'          => $r[1],
                'customer_contact'       => $r[2],
                'customer_contact_email' => $r[3],
                'customer_status'        => $r[4],
                'cust_sdate_n'           => self::day($r[5]),
                'customer_branchid'      => '104',
                'customer_companyid'     => '175',
                'customer_address'       => $r[0] === '6013' ? 'Swastik niwas, khandagale vasti, Mumbai.' : 'Navi Mumbai',
                'cust_landline'          => '',
                'customer_contact_person'=> $r[0] === '6013' ? 'Amol' : '',
                'customer_dist_id'       => '2701',
                'customer_state_id'      => '27',
                'customer_pin'           => '400001',
            );
        }
        return $out;
    }

    protected static function seed_leads()
    {
        $rows = array(
            //  id,   name,                 contact,      added by,           status, added
            array('7001', 'NextGen Software',  '9820022001', 'Demo Sales',      'FS',   -2),
            array('7002', 'Urban Interiors',   '9820022002', 'Demo Sales',      'FS',   -2),
            array('7003', 'Sunrise Pharma',    '9820022003', 'Anjali Deshmukh', 'FS',   -1),
            array('7004', 'Metro Logistics',   '9820022004', 'Rohit Pawar',     'FS',    0),
            array('7005', 'Crystal Waters',    '9820022005', 'Demo Sales',      'Open', -9),
            array('7006', 'Pinnacle Realty',   '9820022006', 'Anjali Deshmukh', 'Open', -14),
            array('7007', 'Aster Heights Society','9820011009','Demo Sales',      'Open',   0),
            array('7008', 'Ambar Patil',           '4515554454','Demo Sales',      'Active', 0),
        );

        $out = array();
        foreach ($rows as $r) {
            $out[] = array(
                'clm_id'          => $r[0],
                'clm_name'        => $r[1],
                'clm_contact'     => $r[2],
                'clm_addedbyname' => $r[3],
                'clm_status'      => $r[4],
                'clm_sdate_n'     => self::day($r[5]),
                'clm_branchid'    => '104',
                'clm_companyid'   => '175',
                'clm_landline'    => '',
                'clm_address'     => '',
            );
        }
        return $out;
    }

    // ---------------------------------------------------------------------
    // Dashboard reminders
    // ---------------------------------------------------------------------

    /**
     * Follow-ups feed two portlets: "Today's Team Follow Ups" (everything) and
     * "Today's My Follow Ups" (filtered to the signed-in user via
     * followup_assignto). Rows carry either lead keys or customer keys, never
     * both, because the view picks the link target from whichever is set.
     */
    protected static function seed_followups()
    {
        return array(
            array(
                'followup_id'      => '8001',
                'clm_id'           => '7005',
                'clm_name'         => 'Crystal Waters',
                'clm_contact'      => '9820022005',
                'customer_id'      => '',
                'customer_name'    => '',
                'customer_contact' => '',
                'quotation_id'     => '',
                'followup_type'    => 'Call',
                'followup_date_n'  => self::day(0),
                'followup_assignto' => '9001',
            ),
            array(
                'followup_id'      => '8002',
                'clm_id'           => '7006',
                'clm_name'         => 'Pinnacle Realty',
                'clm_contact'      => '9820022006',
                'customer_id'      => '',
                'customer_name'    => '',
                'customer_contact' => '',
                'quotation_id'     => '',
                'followup_type'    => 'Visit',
                'followup_date_n'  => self::day(0),
                'followup_assignto' => '9002',
            ),
            array(
                'followup_id'      => '8003',
                'clm_id'           => '',
                'clm_name'         => '',
                'clm_contact'      => '',
                'customer_id'      => '6001',
                'customer_name'    => 'TechVista Solutions',
                'customer_contact' => '9820011001',
                'quotation_id'     => '',
                'followup_type'    => 'Call',
                'followup_date_n'  => self::day(0),
                'followup_assignto' => '9001',
            ),
            array(
                'followup_id'      => '8004',
                'clm_id'           => '',
                'clm_name'         => '',
                'clm_contact'      => '',
                'customer_id'      => '6003',
                'customer_name'    => 'Nova Retail Mart',
                'customer_contact' => '9820011003',
                'quotation_id'     => '9501',
                'followup_type'    => 'Quotation',
                'followup_date_n'  => self::day(0),
                'followup_assignto' => '9001',
            ),
            array(
                'followup_id'      => '8005',
                'clm_id'           => '',
                'clm_name'         => '',
                'clm_contact'      => '',
                'customer_id'      => '6004',
                'customer_name'    => 'Skyline Builders',
                'customer_contact' => '9820011004',
                'quotation_id'     => '',
                'followup_type'    => 'Email',
                'followup_date_n'  => self::day(0),
                'followup_assignto' => '9002',
            ),
            array(
                'followup_id'      => '8006',
                'clm_id'           => '',
                'clm_name'         => '',
                'clm_contact'      => '',
                'customer_id'      => '6005',
                'customer_name'    => 'Heritage Hotels',
                'customer_contact' => '9820011005',
                'quotation_id'     => '',
                'followup_type'    => 'Call',
                'followup_date_n'  => self::day(0),
                'followup_assignto' => '9001',
            ),
            array('followup_id'=>'8007','clm_id'=>'7007','clm_name'=>'Aster Heights Society','clm_contact'=>'9820011009','customer_id'=>'','customer_name'=>'','customer_contact'=>'','quotation_id'=>'9502','followup_type'=>'Site Visit','followup_date_n'=>self::day(1),'followup_assignto'=>'9002'),
        );
    }

    /**
     * Tickets cover both the "Open Tickets" reminder (type Ticket/Servicing)
     * and the "Raised Complaints" reminder (type Complaint), since production
     * stores all three in the ticket master.
     */
    protected static function seed_tickets()
    {
        $rows = array(
            //  id,    seq,        title,                              cust, status,  type,        added
            array('9101', 'TKT-1041', 'Printer not working',              '6001', 'Open', 'Ticket',    -4),
            array('9102', 'TKT-1042', 'Camera 3 offline at gate',         '6003', 'Open', 'Servicing', -3),
            array('9103', 'TKT-1043', 'DVR beeping continuously',         '6004', 'Open', 'Ticket',    -2),
            array('9104', 'TKT-1044', 'Biometric not reading thumb',      '6005', 'Open', 'Servicing', -1),
            array('9105', 'TKT-1045', 'Need extra camera quotation',      '6002', 'Open', 'Ticket',     0),
            array('9106', 'TKT-1030', 'Cable rerouting done',             '6002', 'Closed', 'Ticket',  -30),
            array('9108', 'TKT-1047', 'GPM service completed',             '6013', 'Resolved', 'Ticket', -1),
            array('9201', 'CMP-2011', 'POS system error after update',    '6003', 'Open', 'Complaint', -2),
            array('9202', 'CMP-2012', 'Engineer visit delayed',           '6004', 'Open', 'Complaint', -1),
            array('9203', 'CMP-2013', 'Recording gap on Sunday night',    '6001', 'Open', 'Complaint',  0),
            array('9107', 'TKT-1046', 'Visit for service.',                '6013', 'Open', 'Ticket',     0),
        );

        $customers = array();
        foreach (self::seed_customers() as $c) {
            $customers[$c['customer_id']] = $c;
        }

        $out = array();
        $ticketAssignees = array(
            '9101' => array('9003', 'Demo Technician'),
            '9102' => array('9004', 'Neha Kulkarni'),
            '9103' => array('9003', 'Demo Technician'),
            '9104' => array('9004', 'Neha Kulkarni'),
            '9105' => array('9002', 'Demo Sales'),
            '9106' => array('9003', 'Demo Technician'),
            '9107' => array('9005', 'Prajyot'),
            '9108' => array('9005', 'Prajyot'),
        );
        foreach ($rows as $r) {
            $cust = isset($customers[$r[3]]) ? $customers[$r[3]] : array();
            $assignee = isset($ticketAssignees[$r[0]]) ? $ticketAssignees[$r[0]] : array('', '');
            $out[] = array(
                'ticket_id'        => $r[0],
                'ticket_seq_id'    => $r[1],
                'ticket_title'     => $r[2],
                'customer_id'      => $r[3],
                'customer_name'    => isset($cust['customer_name']) ? $cust['customer_name'] : '',
                'customer_contact' => isset($cust['customer_contact']) ? $cust['customer_contact'] : '',
                'clm_name'         => '',
                'ticket_status'    => $r[4],
                'ticket_type'      => $r[5],
                'ticket_assign_to' => $assignee[0],
                'ticket_assign_to_name' => $assignee[1],
                'tkt_sdate_n'      => self::day($r[6]),
                'ticket_date_n'    => self::day($r[6]),
                'clm_id'           => '',
            );
        }
        return $out;
    }

    protected static function seed_quotations()
    {
        return array(
            array('quote_id'=>'9501','customer_name'=>'Nova Retail Mart','clm_id'=>'','customer_id'=>'6003','clm_name'=>'','clm_contact'=>'','customer_contact'=>'9820011003','quote_cur_ver'=>'2','quote_priority'=>'Medium','quote_remark'=>'DVR upgrade and four cameras','quote_status'=>'Confirmed','quote_date_n'=>self::day(-12)),
            array('quote_id'=>'9502','customer_name'=>'','clm_id'=>'7007','customer_id'=>'','clm_name'=>'Aster Heights Society','clm_contact'=>'9820011009','customer_contact'=>'','quote_cur_ver'=>'1','quote_priority'=>'High','quote_remark'=>'CCTV Premium 24x7 proposal','quote_status'=>'Active','quote_date_n'=>self::day(0)),
            array('quote_id'=>'9503','customer_name'=>'Adinath Mhaske','clm_id'=>'','customer_id'=>'6013','clm_name'=>'','clm_contact'=>'','customer_contact'=>'4152488895','quote_cur_ver'=>'1','quote_priority'=>'High','quote_remark'=>'Quotation for general pest management service','quote_status'=>'Active','quote_date_n'=>self::day(0)),
        );
    }

    protected static function seed_cheques()
    {
        $rows = array(
            array('9301', '6001', 42500, 3),
            array('9302', '6002', 18750, 5),
            array('9303', '6004', 96000, 8),
            array('9304', '6005', 12400, 12),
        );

        $customers = array();
        foreach (self::seed_customers() as $c) {
            $customers[$c['customer_id']] = $c;
        }

        $out = array();
        foreach ($rows as $r) {
            $cust = $customers[$r[1]];
            $out[] = array(
                'cp_id'            => $r[0],
                'customer_id'      => $r[1],
                'customer_name'    => $cust['customer_name'],
                'customer_contact' => $cust['customer_contact'],
                'cp_amount'        => (string) $r[2],
                'cp_chq_date_n'    => self::day($r[3]),
            );
        }
        return $out;
    }

    protected static function seed_balances()
    {
        $rows = array(
            //  id,    cust,   bill no,     balance, next amount, billed, next due
            array('9401', '6001', 'INV-2026-0141', 32500, 15000, -40, 4),
            array('9402', '6002', 'INV-2026-0148',  8900,  8900, -34, 6),
            array('9403', '6003', 'INV-2026-0156', 47600, 20000, -27, 9),
            array('9404', '6004', 'INV-2026-0163', 15200,  7600, -19, 11),
            array('9405', '6005', 'INV-2026-0170', 62800, 30000, -12, 15),
            array('9406', '6013', 'INV-2026-0178',  1000,  1000,   0, 30),
        );

        $customers = array();
        foreach (self::seed_customers() as $c) {
            $customers[$c['customer_id']] = $c;
        }

        $out = array();
        foreach ($rows as $r) {
            $cust = $customers[$r[1]];
            $out[] = array(
                'cbpm_id'              => $r[0],
                'cbpm_custid'          => $r[1],
                'customer_name'        => $cust['customer_name'],
                'customer_contact'     => $cust['customer_contact'],
                'cbpm_billno'          => $r[2],
                'cbpm_balance_amnt'    => (string) $r[3],
                'cbpm_pay_next_amount' => (string) $r[4],
                'cbpm_sdate_n'         => self::day($r[5]),
                'cbpm_pay_next_date'   => self::day($r[6]),
            );
        }
        return $out;
    }

    protected static function seed_amc_reminders()
    {
        $rows = array(
            array('6001', 'CCTV AMC - Comprehensive', 7),
            array('6002', 'CCTV AMC - Basic',        14),
            array('6003', 'Biometric AMC - Annual',  21),
            array('6004', 'Access Control AMC',      28),
            array('6005', 'CCTV AMC - Basic',        40),
        );

        $customers = array();
        foreach (self::seed_customers() as $c) {
            $customers[$c['customer_id']] = $c;
        }

        $out = array();
        $i = 9601;
        foreach ($rows as $r) {
            $cust = $customers[$r[0]];
            $out[] = array(
                'cust_subs_id'        => (string) $i,
                'customer_id'         => $r[0],
                'customer_name'       => $cust['customer_name'],
                'customer_contact'    => $cust['customer_contact'],
                'amc_name'            => $r[1],
                'cust_subs_enddate'   => self::day($r[2]),
                'cust_subs_enddate_n' => self::day($r[2]),
            );
            $i++;
        }
        return $out;
    }

    /**
     * Twelve synthetic contracts deliberately cover the states a presenter
     * needs to explain: active, due soon, expired, draft, paused and renewed.
     * All dates float with today so the same story keeps working next month.
     */
    protected static function seed_amc_subscriptions()
    {
        $rows = array(
            array('6001','4002',-350,  15,'Due Soon',  'Paid',    3),
            array('6002','4001', -90, 275,'Active',    'Paid',    1),
            array('6003','4003',-390, -25,'Expired',   'Paid',    3),
            array('6004','4004', -30, 335,'Active',    'Partial', 1),
            array('6005','4005',-200, 165,'Active',    'Paid',    2),
            array('6006','4006',   0, 365,'Draft',     'Pending', 0),
            array('6007','4001', -60, 305,'Paused',    'Pending', 1),
            array('6008','4003',-365,   0,'Due Today', 'Partial', 3),
            array('6009','4007',  -7, 358,'Active',    'Paid',    0),
            array('6010','4008',-720,  10,'Renewed',   'Paid',    8),
            array('6011','4005', -20, 345,'Active',    'Pending', 0),
            array('6012','4002',-400, -35,'Expired',   'Overdue', 4),
            array('6013','4009',   0, 365,'Active',    'Partial', 0),
        );
        $customers = array();
        foreach (self::seed_customers() as $c) $customers[$c['customer_id']] = $c;
        $plans = array();
        foreach (self::seed_amc_services() as $a) $plans[$a['amc_id']] = $a;
        $out = array(); $i = 9801;
        foreach ($rows as $r) {
            $c = $customers[$r[0]]; $a = $plans[$r[1]];
            $out[] = array(
                'cust_subs_id'=>(string)$i++, 'customer_id'=>$r[0],
                'customer_name'=>$c['customer_name'], 'customer_contact'=>$c['customer_contact'],
                'amc_id'=>$r[1], 'amc_name'=>$a['amc_name'],
                'cust_subs_startdate'=>self::day($r[2]), 'cust_subs_startdate_n'=>self::day($r[2]),
                'cust_subs_enddate'=>self::day($r[3]), 'cust_subs_enddate_n'=>self::day($r[3]),
                'cust_subs_status'=>$r[4], 'payment_status'=>$r[5],
                'services_completed'=>(string)$r[6], 'services_total'=>$a['no_of_services'],
                'contract_value'=>$a['amc_price'],
            );
        }
        return $out;
    }

    protected static function seed_amc_service_visits()
    {
        $out = array(); $i = 9901;
        foreach (self::seed_amc_subscriptions() as $index => $s) {
            $offset = ($index % 5) - 2;
            $completed = $index % 4 === 0 && $s['customer_id'] !== '6013';
            $out[] = array(
                'cust_serv_id'=>(string)$i++, 'cust_subs_id'=>$s['cust_subs_id'],
                'customer_id'=>$s['customer_id'], 'customer_name'=>$s['customer_name'],
                'customer_contact'=>$s['customer_contact'],
                'cust_serv_type_name'=>$s['amc_name'] . ' preventive visit',
                'cust_serv_date_n'=>self::day($offset),
                'cust_subs_startdate_n'=>$s['cust_subs_startdate_n'],
                'cust_subs_enddate_n'=>$s['cust_subs_enddate_n'],
                'cust_serv_status'=>$completed ? 'Completed' : ($offset < 0 ? 'Pending' : 'Upcoming'),
                'cust_serv_done_status'=>$completed ? 'Close' : 'Open',
                'cust_serv_doneondate_n'=>$completed ? self::day($offset) : '',
                'ticket_id'=>'',
                'cust_serv_type'=>'AMC Service',
                'cust_serv_sdate_n'=>self::day($offset),
                'cust_serv_assigned_to'=>'Demo Technician',
                'cust_serv_assigned_on'=>self::day($offset - 2),
                'cust_serv_resolved_on'=>$completed ? self::day($offset) : '',
            );
        }
        return $out;
    }

    protected static function seed_pending_services()
    {
        $rows = array(
            array('6001', 'Quarterly Preventive Maintenance', -3),
            array('6002', 'Camera Lens Cleaning',             -1),
            array('6003', 'DVR Health Check',                  0),
            array('6004', 'Biometric Firmware Update',         1),
            array('6005', 'Half Yearly Site Audit',            2),
            array('6013', 'General Pest Management',            0),
        );

        $customers = array();
        foreach (self::seed_customers() as $c) {
            $customers[$c['customer_id']] = $c;
        }

        $out = array();
        $i = 9701;
        foreach ($rows as $r) {
            $cust = $customers[$r[0]];
            $out[] = array(
                'cust_serv_id'        => (string) $i,
                'customer_id'         => $r[0],
                'customer_name'       => $cust['customer_name'],
                'customer_contact'    => $cust['customer_contact'],
                'cust_serv_type_name' => $r[1],
                'cust_serv_date_n'    => self::day($r[2]),
                'cust_serv_status'    => 'Pending',
            );
            $i++;
        }
        return $out;
    }

    /**
     * The controller only keeps rows whose birthday_type is already set, so
     * seed exactly the Today / Tomorrow rows the reminder is meant to show.
     */
    protected static function seed_birthdays()
    {
        return array(
            array(
                'ref_id'        => '5002',
                'name'          => 'Amit Deshmukh',
                'contact'       => '9800000021',
                'dob'           => date('d-M-Y', strtotime('-32 years')),
                'birthday_type' => 'Today',
                'person_type'   => 'Employee',
            ),
            array(
                'ref_id'        => '6002',
                'name'          => 'GreenLeaf Industries',
                'contact'       => '9820011002',
                'dob'           => date('d-M-Y', strtotime('-41 years')),
                'birthday_type' => 'Today',
                'person_type'   => 'Customer',
            ),
            array(
                'ref_id'        => '5003',
                'name'          => 'Sneha Patil',
                'contact'       => '9800000022',
                'dob'           => date('d-M-Y', strtotime('-29 years +1 day')),
                'birthday_type' => 'Tomorrow',
                'person_type'   => 'Employee',
            ),
        );
    }

    protected static function seed_notifications()
    {
        return array(
            array(
                'noti_id'      => '9801',
                'noti_title'   => 'Demo environment: all data is synthetic.',
                'noti_details' => 'Nothing you change here touches a live system.',
                'noti_sdate_n' => self::day(-1),
                'noti_status'  => 'A',
            ),
            array(
                'noti_id'      => '9802',
                'noti_title'   => 'Scheduled maintenance this Sunday 02:00-04:00 IST.',
                'noti_details' => 'Reports may be briefly unavailable.',
                'noti_sdate_n' => self::day(0),
                'noti_status'  => 'A',
            ),
        );
    }
}
