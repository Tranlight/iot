<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Api extends MY_Controller
{
    function __construct() {
        parent::__construct();
    }
    
    public function data_post() {
        $this->load->model('data_model', 'data');

        $key = $this->input->post('key');
        $value = $this->input->post('value');

        $response = array(
            'status' => 0,
        );
        $code  = REST_Controller::HTTP_OK;

        if(!isset($key) || !isset($value) || empty($key) || empty($value) || !is_numeric($value)) {
            $response['status'] = -1;
            $code = REST_Controller::HTTP_BAD_REQUEST;
        } else {
            $data = array(
                'key' => $key, 
                'value' => $value,
            );
            $result = $this->data->insert($data);
            $response['status'] = (int)$result;
        }

        $this->set_response($response, $code);
    }
}