<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

	public function __construct() {
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
			$data['section'] = '';
			$this->data = $data;			
		} else {
			redirect(login_url());
		}
	}
	
/* CMS */
	public function home() {
		$data = $this->data;
		$data['section'] = 'home';			
		$data['games'] = $this->games->get_games_of_user($data['userid']);
		$data['companies'] = $this->companies->get_companies();
		add_js_file('games.js');
		wrap_cms_view('home',$data);
	}
	
	public function preparation() {
		$data = $this->data;
		
		if(isset($_POST['game-id'])) {
			$game_id = $this->input->post('game-id');	
			$this->session->set_userdata('game_id',$game_id);
			$data['game_id'] = $game_id;
		}
		if($data['game_id'] == 0) {
			redirect(home());
		}
		
		$data['section'] = 'preparation';
		$data['game'] = $this->games->get_game_by_id($data['game_id']);
		wrap_cms_view('preparation',$data);
	}


/* TABLET */
	public function overview() {
		$data = $this->data;

		if(isset($_POST['game-id'])) {
			$game_id = $this->input->post('game-id');	
			$this->session->set_userdata('game_id',$game_id);
			$data['game_id'] = $game_id;
		}
		if($data['game_id'] == 0) {
			redirect(home());
		}
			
		$data['game'] = $this->games->get_game_by_id($data['game_id']);
		$data['section'] = 'overview';
		add_js_file('tablet.js');
		wrap_tablet_view('overview',$data);
	}
	
	public function place_chips($round) {
		$data = $this->data;
				
		if($data['game_id'] == 0) {
			redirect(home());
		}
		
		$game_obj = $this->games->get_game_by_id($data['game_id']);
		$data['game'] = $game_obj;	
		$data['section'] = 'chips';
		$data['round'] = $round;
		if($round==$game_obj->round) {
			$data['status'] = 'open';
		} else {
			$data['status'] = 'closed';
		}
		$data['groups'] = $this->games->get_groups_with_chips($game_obj->id,$round);
		add_js_file('jquery.flip.min.js');
		add_js_file('tappy.js');
		
		if($round == 1 || $round == 2 || $round == 3) {
			add_js_file('place_chips.js');
			wrap_tablet_view('place_chips',$data);
		} else if($round ==4) {
			add_js_file('place_chips_woc.js');
			wrap_tablet_view('place_chips_woc',$data);
		} else {
			redirect(overview_url());
		}
	}
	
	public function keywords($part) {
		$data = $this->data;
				
		if($data['game_id'] == 0) {
			redirect(home());
		}
		
		$game_obj = $this->games->get_game_by_id($data['game_id']);
		$data['game'] = $game_obj;	
		$data['section'] = 'keywords';
		$data['part'] = $part;
		wrap_tablet_view('keywords',$data);
	}
	
	
/* PROJECTOR */
	public function presentation() {
		$data = $this->data;

		if(isset($_POST['game-id'])) {
			$game_id = $this->input->post('game-id');	
			$this->session->set_userdata('game_id',$game_id);
			$data['game_id'] = $game_id;
		}
		if($data['game_id'] == 0) {
			redirect(home());
		}
	
		$data['game'] = $this->games->get_game_by_id($data['game_id']);
		$data['section'] = 'presentation';
		wrap_projector_view('presentation',$data);
	}
	
	public function result() {
		$data = $this->data;
		$game_obj = $this->games->get_game_by_id($data['game_id']);
		$data['game'] = $game_obj;
		$data['groups'] = $this->games->get_points_of_groups($game_obj->id);
		$data['max_points'] = $this->games->get_max_points_of_groups($game_obj->id);
		$data['areas'] = $this->gameboard->get_areas_with_points($game_obj->id,$game_obj->company_id,2);
		$data['section'] = 'round_result';
		add_js_file('jquery.animate-shadow.js');
		add_js_file('result.js');
		add_js_file('tappy.js');			
		wrap_projector_view('result',$data);
	}
	
	public function timer() {
		$data = $this->data;
		$data['section'] = 'timer';
		add_js_file('jquery.rotate.js');
		add_js_file('timer.js');
		wrap_projector_view('timer',$data);
	}
	
	public function leaderboard() {
		$data = $this->data;
		$data['game'] = $this->games->get_game_by_id($data['game_id']);
		$data['groups'] = $this->games->get_points_of_groups($data['game']->id);
		$data['max_points'] = $this->games->get_max_points_of_groups($data['game']->id);
		$data['section'] = 'leaderboard';
		add_js_file('leaderboard.js');
		wrap_projector_view('leaderboard',$data);
	}
	
	
	public function game_present($part=null) {
		$data = $this->data;
		
		if(isset($_POST['game-id'])) {
			$game_id = $this->input->post('game-id');	
			$this->session->set_userdata('game_id',$game_id);
			$data['game_id'] = $game_id;
		}
		if($data['game_id'] == 0) {
			redirect(home());
		}
			
		$game_obj = $this->games->get_game_by_id($data['game_id']);
			
		// TEMPORARY
		$data['game'] = $game_obj;
		$data['groups'] = $this->games->get_points_of_groups($game_obj->id);
		$data['max_points'] = $this->games->get_max_points_of_groups($game_obj->id);
		$round = $game_obj->round;
		$data['areas'] = $this->gameboard->get_areas_with_points($game_obj->id,$game_obj->company_id,$round);
		$data['section'] = 'round_result';
		add_js_file('jquery.animate-shadow.js');
		add_js_file('game_round_result.js');
		add_js_file('tappy.js');			
		wrap_tablet_view('game_round_result',$data);
	}	
}
