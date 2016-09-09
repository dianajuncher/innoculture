<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if( !$this->input->is_ajax_request() ) {
            exit();
		} elseif( isset($this->session->userdata['logged_in']) ) {
			$data['is_loggedin'] = true;
			$data['userid'] = $this->session->userdata['userid'];
			$data['role'] = $this->session->userdata['role'];
			$data['language'] = $this->session->userdata['language'];
			$data['game_id'] = $this->session->userdata['game_id'];
        } else {
            redirect(login_url());
        }
    }
    
	function place_chip()
	{
		$game_id = $this->input->post('game_id');
		$group_number = $this->input->post('group_number');
		$area_id = $this->input->post('area_id');
		$focus_id = $this->input->post('focus_id');
		$chip = array(
			'area_id' => $area_id,
			'focus_id' => $focus_id
		);
		$this->games->place_chip($game_id,$group_number,$chip);
		$response = array('status'=>'ok');
		echo json_encode($response);
	}
	function remove_chips()
	{
		$game_id = $this->input->post('game_id');
		$group_number = $this->input->post('group_number');
		$focus_id = $this->input->post('focus_id');
		$free_chip = array(
			'area_id' => NULL,
			'focus_id' => NULL
		);
		$this->games->remove_chips($game_id,$group_number,$focus_id,$free_chip);
		$response = array('status'=>'ok');
		echo json_encode($response);
	}
	
	function calculate_points()
	{
		$game_id = $this->input->post('game_id');
		$round = $this->input->post('round');

		$game = $this->games->get_game_by_id($game_id);

		$points_of_focuses = $this->companies->get_points_of_round($game->company_id,$round);  // array of focus_id => points
		$number_of_groups = $this->games->count_groups_of_game($game_id);

		for($i=1;$i<=$number_of_groups;$i++) {
		 	$points = 0;
		 	$chips = $this->games->get_chips_of_group($game_id,$i);
		 	foreach($chips as $chip) {
		 		if($chip->focus_id) {
		 			$points = $points + $points_of_focuses[$chip->focus_id];
		 		}
		 	}
		 	$this->games->save_points_of_group($game_id,$i,$points);
			$this->games->update_areas_of_group($game_id,$i,$round);
		}
		$this->games->close_round($game_id,$round);
		if($round<3) $this->games->open_round($game_id,$round+1);
		
		$response = array('status'=>'ok');
		echo json_encode($response);
	}
    

}