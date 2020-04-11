<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class MY_Controller extends REST_Controller {
 
    function __construct()
    {
        parent::__construct();
        $this->load->helper(['jwt', 'validate']);
        $this->check_token();   
    }

    private function check_token() {
    	$headers = $this->input->request_headers();
        $this->lang->load('message', 'english');

        $response = array(
            'message' => ''
        );

        if (array_key_exists('Author', $headers) && !empty($headers['Author'])) {
            $token_validate          = VALIDATE::validateToken($headers['Author']);
            
            if($token_validate == VALIDATE::TOKEN_VALID) {

                return;
            } elseif($token_validate == VALIDATE::TOKEN_EXPIRED) {

                $response['message'] = $this->lang->line('token_expired');
            }
        } else {
            $response['message']     = $this->lang->line('unauthorize');
        }
        $this->response($response, REST_Controller::HTTP_UNAUTHORIZED, FALSE);
    }
}