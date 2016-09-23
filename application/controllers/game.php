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
			redirect(home_url());
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
			redirect(home_url());
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
			redirect(home_url());	
		}		
	}

	public function game_delete($game_id)
	{
		$data = $this->data;
		if($data['is_loggedin']) {
			$this->games->delete_game($game_id);
			redirect(game_list_url());
		} else {
			redirect(home_url());
		}
	}
	
	public function game_start($game_id) {
		$data = $this->data;
		if($data['is_loggedin']) {
			$this->games->start_game($game_id);
			redirect(game_list_url());
		} else {
			redirect(home_url());
		}
		
	}
			
	public function game_resources($company_id) {
		$data = $this->data;
		if($data['is_loggedin']) {
			$data['company'] = $this->companies->get_company($company_id);
			// $data['resources'] = $this->companies->get_company_resources($company_id);
			wrap_page_view('game_resources',$data);
		} else {
			redirect(home_url());
		}
	}

	public function game_manage($section=NULL,$part=NULL) {
		$data = $this->data;
		if($data['is_loggedin']) {
			if(isset($_POST['game-id'])) {
				$game_id = $this->input->post('game-id');	
				$this->session->set_userdata('game_id',$game_id);
				$data['game_id'] = $game_id;
			} else if ($data['game_id'] == 0) {
				redirect(game_list_url());
			}
			
			$game_obj = $this->games->get_game_by_id($data['game_id']);
			$data['game'] = $game_obj;			
			if($section=='chips' && $part!=NULL) {
				$data['section'] = $section;
				$data['round'] = $part;
				$data['groups'] = $this->games->get_groups_of_game($game_obj->id);
				add_js_file('game_manage_chips.js');
				wrap_tablet_view('game_manage_chips',$data);
			} elseif($section=='keywords' && $part!=NULL) {
				$data['section'] = $section;
				$data['part'] = $part;
				wrap_tablet_view('game_manage_keywords',$data);
			} elseif($section=='woc') {
				$data['section'] = $section;
				$data['groups'] = $this->games->get_groups_of_game($game_obj->id,$woc=1);
				add_js_file('game_manage_woc.js');
				wrap_tablet_view('game_manage_woc',$data);
			} else {
				$data['section'] = 'overview';
				wrap_tablet_view('game_manage',$data);
			}
		} else {
			redirect(home_url());			
		}
	}
	
	public function game_present($part=null) {
		$data = $this->data;
		if($data['is_loggedin']) {
			if(isset($_POST['game-id'])) {
				$game_id = $this->input->post('game-id');	
				$this->session->set_userdata('game_id',$game_id);
				$data['game_id'] = $game_id;
			} else if ($data['game_id'] == 0) {
				redirect(game_list_url());
			}
			$game_obj = $this->games->get_game_by_id($data['game_id']);
			if($game_obj->finished == 0) {
				$data['game'] = $game_obj;
				$data['company'] = $this->companies->get_company($game_obj->company_id);
				if($part) {
					$data['part'] = $part;
					$data['pages'] = $this->companies->get_pages_of_part($game_obj->company_id,$part);
				}
				$data['section'] = 'present';
				wrap_page_view('game_present',$data);
			} else {
				redirect(game_list_url());
			}
		} else {
			redirect(home_url());
		}
	}
	
	
	public function game_round_result() {
		$data = $this->data;
		if($data['is_loggedin']) {
			$game_obj = $this->games->get_game_by_id($data['game_id']);
			$data['game'] = $game_obj;
			$data['groups'] = $this->games->get_points_of_groups($game_obj->id);
			$data['max_points'] = $this->games->get_max_points_of_groups($game_obj->id);
			$data['areas'] = $this->gameboard->get_areas_with_points($game_obj->id,$game_obj->company_id,2);
			$data['section'] = 'round_result';
			add_js_file('jquery.animate-shadow.js');
			add_js_file('game_round_result.js');
			wrap_tablet_view('game_round_result',$data);
		} else {
			redirect(home_url());
		}
	}
	
	public function game_leaderboard() {
		$data = $this->data;
		if($data['is_loggedin']) {
			$data['game'] = $this->games->get_game_by_id($data['game_id']);
			$data['groups'] = $this->games->get_points_of_groups($data['game']->id);
			$data['max_points'] = $this->games->get_max_points_of_groups($data['game']->id);
			$data['section'] = 'leaderboard';
			add_js_file('game_leaderboard.js');
			wrap_page_view('game_leaderboard',$data);
		} else {
			redirect(home_url());
		}
	}

}
