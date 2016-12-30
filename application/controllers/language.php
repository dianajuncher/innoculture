<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	function switchLanguage($language = "") {
		$language = ($language != "") ? $language : "danish";
		$this->session->set_userdata('language',$language);
		redirect(home_url());
	}
}
