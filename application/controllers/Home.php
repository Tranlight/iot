<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function chart() {
		$this->load->model('data_model', 'data');
		$data = $this->data->get_by_current_hours(24, 60);
		$mapping = ['0' => 'Humidity', '1' => 'Temperature', '4' => 'Gas'];
		$keys = [];
		foreach ($data as $index => $value) {
			$date_push = new DateTime($value->date_push);
			$keys[$mapping[$value->key]][$date_push->format("m-d H:i")] = (float) $value->value;
		}

		unset($data);
		$this->load->view('chart_message', array('keys' => $keys));
	}

	public function admin() {
		$out = shell_exec('sh run.sh');
		echo $out;
	}
}
