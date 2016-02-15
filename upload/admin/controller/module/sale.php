<?php

class ControllerModuleSale extends Controller{

	public function index()
	{
		$dt['name'] = 'a';
		$this->response->setOutput($this->load->view('module/a.tpl', $dt));
	}
}