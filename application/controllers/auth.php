<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if( isset($this->session->userdata['logged_in']) ) {
			$data['is_loggedin'] = true;
			$data['name'] = $this->session->userdata['name'];
		} else {
			$data['is_loggedin'] = false;
		}
		$data['section'] = '';		
		$this->data = $data;
	}

	public function login() {
		$data = $this->data;
		
		if(isset($_POST['username']) && isset($_POST['password'])) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$user = $this->user->login($username,$password);
			if($user) {
				$session_data = array(
					'logged_in' => true,
					'userid' => $user->id,
					'username' => $user->username,
					'role' => $user->role,
					'name' => $user->name,
					'email' => $user->email,
					'active' => $user->active,
					'language' => $user->language,
					'game_id' => 0
				);
				$this->session->set_userdata($session_data);
				redirect(game_list_url());
			}
		} else {
			redirect(base_url());		
		}
	}

	public function logout() {
		$this->session->unset_userdata('logged_in');
		redirect(base_url());
	}
}
