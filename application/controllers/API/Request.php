<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {

	public function ()
	{
		
		$this->load->view('welcome_message');
	}
}
