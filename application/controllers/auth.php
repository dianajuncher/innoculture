<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		if( isset($this->session->userdata['logged_in']) ) {
			$data['is_loggedin'] = true;
			$data['is_active'] = ($this->session->userdata['active'] == 1 ? true : false);
			$data['userid'] = $this->session->userdata['userid'];
			$data['username'] = $this->session->userdata['username'];
			$data['role'] = $this->session->userdata['role'];
			$data['name'] = $this->session->userdata['name'];
			$data['email'] = $this->session->userdata['email'];
			$data['language'] = $this->session->userdata['language'];
			$data['game_id'] = $this->session->userdata['game_id'];
		} else {
			$data['is_loggedin'] = false;
		}
		$data['section'] = '';		
		$this->data = $data;
	}

	public function login() {
		$data = $this->data;
		
		if($data['is_loggedin']) {
			redirect(home_url());
		}
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
				redirect(home_url());
			} else {
				$data = $this->data;
				$data['section'] = 'login';
				$data['username'] = $username;
				$data['password'] = $password;
				wrap_auth_view('login',$data);
			}
		} else {
			$data = $this->data;
			$data['section'] = 'login';
			wrap_auth_view('login',$data);
		}
	}

	public function logout() {
		$this->session->unset_userdata('logged_in');
		redirect(home_url());
	}
	
	public function account() {
		$data = $this->data;
		if($data['is_loggedin']) {
			$data['section'] = 'account';
			wrap_cms_view('account',$data);
		} else {
			redirect(login_url());
		}
	}	
}
