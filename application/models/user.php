<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


class User extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function login($username,$password) {
		$this->db->from('users');
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$user = $this->db->get()->row();
		if(!empty($user)) {
			$date = date('Y-m-d H:i:s');
			$data = array (
				'last_login' => $date
			);
			$this->db->where('id',$user->id);
			$this->db->update('users',$data);
			
			return $user;
		} else {
			return false;
		}
	}
}