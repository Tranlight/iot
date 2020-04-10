<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['jwt_key'] = 'AUTH_SECRET_123';

/*Generated token will expire in 1 minute for sample code
* Increase this value as per requirement for production
*/
$config['token_timeout'] = 1;