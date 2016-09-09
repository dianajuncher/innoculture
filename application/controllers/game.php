<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

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
	
	public function home()
	{
		$data = $this->data;
		$data['section'] = 'home';
		wrap_page_view('home',$data);
	}
	
	public function account()
	{
		$data = $this->data;
		if($data['is_loggedin']) {
			$data['section'] = 'account';
			wrap_page_view('account',$data);
		} else {
			redirect(login_url());
		}
	}
	
	public function game_list()
	{
		$data = $this->data;
		if($data['is_loggedin']) {
			$data['section'] = 'game_list';			
			$data['games'] = $this->games->get_games_of_user($data['userid']);
			wrap_page_view('game_list',$data);
			
		} else {
			redirect(login_url());			
		}
	}
	
	public function game_create()
	{
		$data = $this->data;
		if($data['is_loggedin']) {
			
			if( isset($_POST['name']) && isset($_POST['company_id']) && 
				isset($_POST['number_of_groups']) && isset($_POST['language']) ) {
				$name = $this->input->post('name');		
				$company_id = $this->input->post('company_id');
				$number_of_groups = $this->input->post('number_of_groups');
				$language = $this->input->post('language');
				$this->games->create_game($name,$company_id,$number_of_groups,$language);
				redirect(game_list_url());
			} else {
				$data['section'] = 'game_create';				
				$data['companies'] = $this->companies->get_companies();
				wrap_page_view('game_create',$data);
			}
		} else {
			redirect(login_url());			
		}		
	}

	public function game_delete($game_id)
	{
		$data = $this->data;
		if($data['is_loggedin']) {
			$this->games->delete_game($game_id);
			redirect(game_list_url());
		} else {
			redirect(login_url());			
		}		
	}
		
	public function game($game_id)
	{
		$data = $this->data;
		if($data['is_loggedin']) {
			if( isset($_POST['start_game']) ) {
				$this->games->start_game($this->input->post('start_game'));
				$this->session->set_userdata('started',1);
			}
			$data['game'] = $this->games->get_game_by_id($game_id);
			$this->session->set_userdata('game_id',$game_id);	
			$data['section'] = 'game';					
			wrap_page_view('game',$data);
		} else {
			redirect(login_url());			
		}		
	}
	
	public function game_resources($company_id) {
		$data = $this->data;
		
		
	}
	public function game_present($part) {
		$data = $this->data;

		$game_obj = $this->games->get_game_by_id($data['game_id']);
		if($game_obj->finished == 0) {
			$data['game'] = $game_obj;
			$data['part'] = $part;
			$data['pages'] = $this->companies->get_pages_of_part($game_obj->company_id,$part);	
			wrap_page_view('game_present',$data);
		} else {
			redirect(game_list_url());
		}
	}
	
	public function game_manage($section=NULL,$part=NULL) {
		$data = $this->data;		
		
		$game_obj = $this->games->get_game_by_id($data['game_id']);
		if($game_obj->finished == 0) {
			$data['section'] = $section;
			$data['game'] = $game_obj;
			if($section == 'points') {
				$data['round'] = $part;
				$data['groups'] = $this->games->get_groups_of_game($game_obj->id);
			} elseif($section == 'keywords') {
				$data['part'] = $part;
			} else {
				$data['section'] = 'default';
			}
			add_js_file('game_manage.js');
			wrap_page_view('game_manage',$data);
		} else {
			redirect(game_list_url());
		}
	}
	
	

}
