<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Auth extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(['jwt', 'validate']);
    }

    public function login_post() {
        $this->load->model('user_model', 'user');
        $this->lang->load('message', 'english');

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $response = array(
            'message' => '',
            'token'   => '',
        );
        $code = REST_Controller::HTTP_OK;
            
        if(!isset($username) || !isset($password) || empty($username) || empty($password)) {
            $response['message'] = $this->lang->line('bad_request');
            $code     = REST_Controller::HTTP_BAD_REQUEST;
        } else {
            $username = trim($username);
            $password = trim($password);

            $user     = $this->user->find_by_username($username);
            
            if(!$user) {
                $response['message'] = $this->lang->line('user_not_exist');
                $code    = REST_Controller::HTTP_UNAUTHORIZED;
            } else {
                $encr_password = md5($password);
                if($username == $user->username && $encr_password == $user->password) {
                    $user_id             = $user->id;
                    $response['message'] = $this->lang->line('login_success');
                    $token   = time();
                    $token   = VALIDATE::generateToken($user_id, $response['token']);
                    if(is_array($token)) {
                        $response['message'] = $this->lang->line('token_error');
                        $code                = REST_Controller::HTTP_UNAUTHORIZED;
                    } else {
                        $response['token']   = $token;
                    }
                } else {
                    $response['message'] = $this->lang->line('user_invalid');
                    $code    = REST_Controller::HTTP_UNAUTHORIZED;
                }
            }
        }

        $this->set_response($response, $code);
    }
}