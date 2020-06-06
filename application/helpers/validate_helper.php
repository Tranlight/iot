<?php

class VALIDATE
{
    const TOKEN_VALID = 1;
    const TOKEN_INVALID = 0;
    const TOKEN_EXPIRED = -1;

    public static function validateTimestamp($token)
    {
        $CI =& get_instance();
        $token = self::validateToken($token);
        if ($token != false && (now() - $token->timestamp < ($CI->config->item('token_timeout') * 60))) {
            return $token;
        }
        return false;
    }

    public static function validateToken($token)
    {
        $CI =& get_instance();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $CI->load->database();

        $CI->db->from('token');
        $CI->db->where('value', $token);
        $token = $CI->db->get();
        if($token) {
            $token = $token->row();

            if ((time() - strtotime($token->generated_date) < ($CI->config->item('token_timeout') * 60))) {

                return self::TOKEN_VALID;
            }

            return self::TOKEN_EXPIRED;
        }

        return self::TOKEN_INVALID;
    }

    public static function generateToken($user_id, $data)
    {
        $CI             =& get_instance();

        $CI->load->database();
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $token          = JWT::encode($data, $CI->config->item('jwt_key'));
        $generated_date = new DateTime();
        $data           = array(
            'user_id'           => $user_id,
            'value'             => $token,
            'generated_date'    => $generated_date->format('Y-m-d H:i:s'),
        );

        if($CI->db->insert('token', $data)) {
            return $token;
        }
        return $CI->db->error();
    }

}