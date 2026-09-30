<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DEMO BUILD RIG - Mock API
 * -------------------------------------------------------------------------
 * Drop-in replacement for the production Api library.
 *
 * Production flow:  view <- controller <- Api.php --curl--> Java REST --> Oracle
 * Demo flow:        view <- controller <- Api.php <-- MockData (PHP arrays)
 *
 * The public method signatures are IDENTICAL to production so that not a
 * single controller or view needs to change. Every response is shaped exactly
 * like the Java API's JSON, decoded to a PHP array.
 *
 * Any method that is not yet implemented returns an empty array AND is
 * recorded to _build/mock_missing.log. That log is the authoritative
 * remaining-work list - we never have to guess what is left to build.
 */
class Api
{
    /** @var MockData */
    private $data;

    public function __construct()
    {
        require_once APPPATH . 'libraries/MockData.php';
        $this->data = new MockData();
    }

    // =====================================================================
    // Public surface - mirrors production Api.php exactly
    // =====================================================================

    public function call_api($method = NULL, $param = array(), $type = "POST")
    {
        return $this->dispatch($method, $param, 'admin');
    }

    public function call_v_api($method = NULL, $param = array(), $type = "POST")
    {
        return $this->dispatch($method, $param, 'vendor');
    }

    public function call_i_api($method = NULL, $param = array(), $type = "POST")
    {
        return $this->dispatch($method, $param, 'inventory');
    }

    public function call_meta_api($method = NULL, $param = array(), $type = "GET")
    {
        return $this->dispatch($method, $param, 'meta');
    }

    public function upload_v_excel($method = NULL, $param = array(), $type = "POST")
    {
        $this->note('upload_v_excel:' . $method);
        return array(array('result' => 'Success', 'msg' => 'Demo mode: file accepted but not stored.'));
    }

    public function download_v_excel($method = NULL, $param = array(), $type = "POST")
    {
        $this->note('download_v_excel:' . $method);
        return array();
    }

    public function pdf_api($url = NULL, $type = "POST")
    {
        $this->note('pdf_api:' . $url);
        return array();
    }

    public function check_ifsc($ifsc = NULL)
    {
        // Production hits ifsc.razorpay.com. Return a plausible canned bank.
        return json_encode(array(
            'IFSC'    => $ifsc,
            'BANK'    => 'Demo Bank of India',
            'BRANCH'  => 'Kharghar',
            'CITY'    => 'NAVI MUMBAI',
            'DISTRICT'=> 'THANE',
            'STATE'   => 'MAHARASHTRA',
            'ADDRESS' => 'Sector 10, Kharghar, Navi Mumbai 410210',
        ));
    }

    public function check_pin($pin = NULL)
    {
        // Production hits api.postalpincode.in.
        return json_encode(array(array(
            'Message'     => 'Number of pincode(s) found:1',
            'Status'      => 'Success',
            'PostOffice'  => array(array(
                'Name'     => 'Kharghar',
                'District' => 'Thane',
                'State'    => 'Maharashtra',
                'Pincode'  => $pin,
            )),
        )));
    }

    // =====================================================================
    // Dispatch
    // =====================================================================

    /**
     * Route an API method name to its mock implementation.
     *
     * MockData exposes one public method per backend method name. If it
     * exists we call it with the positional params ($param['one'] etc.);
     * otherwise we log the gap and hand back an empty array, which every
     * view already tolerates via its `if (!empty($list))` guards.
     */
    private function dispatch($method, $param, $channel)
    {
        if (empty($method)) {
            return "Method name should not be blank";
        }

        if (method_exists($this->data, $method)) {
            return $this->data->{$method}($param, $channel);
        }

        $this->note($channel . ':' . $method);
        return array();
    }

    /**
     * Record an unimplemented backend method once per name.
     */
    private function note($signature)
    {
        static $seen = array();
        if (isset($seen[$signature])) {
            return;
        }
        $seen[$signature] = TRUE;

        $log = APPPATH . '../mock_missing.log';
        @file_put_contents($log, $signature . "\n", FILE_APPEND);
    }
}
