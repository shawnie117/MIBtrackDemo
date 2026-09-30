<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Enquiry";

        $this->load->library('form_validation');

        // Validation Rules
        $this->form_validation->set_rules(
            'customer_name',
            'Customer Name',
            'required|trim|max_length[50]'
        );

        $this->form_validation->set_rules(
            'mobile_no',
            'Mobile Number',
            'required|trim|numeric|min_length[10]|max_length[10]'
        );

        $this->form_validation->set_rules(
            'company_name',
            'Company Name',
            'trim|max_length[200]'
        );

        $this->form_validation->set_rules(
            'nature_of_business',
            'Nature Of Business',
            'trim|max_length[400]'
        );

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view("enquiry", $data);
        }
        else
        {
            $customer_name       = $this->input->post('customer_name', TRUE);
            $mobile_no           = $this->input->post('mobile_no', TRUE);
            $company_name        = $this->input->post('company_name', TRUE);
            $nature_of_business  = $this->input->post('nature_of_business', TRUE);

            /*
            ******************************************************
            HARDCODED VALUES
            ******************************************************
            */

            $params = array(

                "one"   => "19612",   // User ID
                "two"   => "2409",   // Branch ID
                "three" => "361",   // Company ID
                "four"  => $customer_name,
                "five"  => $mobile_no,
                "six"   => $company_name,
                "seven" => $nature_of_business

                // "one"   => "109",   // User ID
                // "two"   => "104",   // Branch ID
                // "three" => "175",   // Company ID
                // "four"  => $customer_name,
                // "five"  => $mobile_no,
                // "six"   => $company_name,
                // "seven" => $nature_of_business


            );

            /*
            ******************************************************
            API
            ******************************************************
            */

            $response = $this->api->call_v_api(
                'setLeadUdyogjaktaDiwas',
                $params
            );

            // Uncomment for debugging
            /*
            echo "<pre>";
            print_r($response);
            die;
            */

            if (
                is_array($response) &&
                !empty($response) &&
                isset($response[0]['status']) &&
                $response[0]['status'] === "Success"
            ) {

                $lead_id = isset($response[0]['id']) ? $response[0]['id'] : '';

                $success_message = "Thank you! Your enquiry has been submitted successfully.";

                // Uncomment if you want to display Lead ID
                // if (!empty($lead_id)) {
                //     $success_message .= " Lead ID: " . $lead_id;
                // }

                $this->session->set_flashdata(
                    'success',
                    $success_message
                );

                redirect("enquiry");

            } else {

                $error_message = "Something went wrong. Please try again.";

                if (
                    is_array($response) &&
                    !empty($response) &&
                    isset($response[0]['message']) &&
                    !empty($response[0]['message'])
                ) {
                    $error_message = $response[0]['message'];
                }

                $this->session->set_flashdata(
                    'error',
                    $error_message
                );

                redirect("enquiry");
            }
        }
    }
}