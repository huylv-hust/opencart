<?php
class ControllerModuleTest extends Controller {
	public function index($setting) {
		$this->load->language('module/test');
		$data = array();
			return $this->load->view('default/template/module/test.tpl', $data);
	}
}