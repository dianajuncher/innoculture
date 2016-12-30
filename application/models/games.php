<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


class Games extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

// GAME CMS
	function get_game_by_id($game_id) {
		$this->db->from('games');
		$this->db->where('id',$game_id);
		return $this->db->get()->row();
	}
	function get_games_of_user($userid) {
		$this->db->from('games');
		$this->db->where('user_id',$userid);
		$this->db->order_by('created','desc');
		$games = $this->db->get()->result();
		foreach($games as $game) {
			if($game->company_id) {
				$game->company_name = $this->companies->get_company_name($game->company_id);
			}
		}
		return $games;
	}
	
	function create_new_game() {
		$date = date('Y-m-d H:i:s');
		$user_id = $this->session->userdata['userid'];
		$game = array(
			'user_id' => $user_id,
			'name' => '',
			'groups' => 0,
			'company_id' => '',
			'created' => $date,
			'language' => 'da'
		);
		$this->db->insert('games',$game);
	}
	function update_new_game($game_id,$data) {
		$this->db->where('id',$game_id);
		$this->db->update('games',$data);
	}
	function start_new_game($game_id) {
		$date = date('Y-m-d H:i:s');
		$data = array(
			'created' => $date,
			'started' => 1,
			'intro' => 1,
			'round' => 1,
			'round_status' => 0			
		);
		$this->db->where('id',$game_id);
		$this->db->update('games',$data);
		
		$game_obj = $this->get_game_by_id($game_id);		
		$groups = array();
		for($i=1;$i<=$game_obj->groups;$i++) {
			$groups[] = array(
				'game_id' => $game_id,
				'number' => $i
			);
		}
		$this->db->insert_batch('games_groups',$groups);
		
		$chips = array();
		for($i=1;$i<=$game_obj->groups;$i++) {
			for($j=1;$j<=6;$j++) {
				$chips[] = array(
					'game_id' => $game_id,
					'group_number' => $i,
					'round' => 1
				);
			}
		}
		$this->db->insert_batch('games_groups_chips',$chips);			
	}
	function delete_game($game_id) {
		$this->db->where('id',$game_id);
		$this->db->where('started',0);
		$this->db->delete('games');
	}

	
/* ROUNDS */
	function next_round($game_id,$prev_round) {
		$game_obj = $this->get_game_by_id($game_id);
		
		if($prev_round==$game_obj->round) {
			$next_round = $prev_round + 1;
			
			if($next_round==2 || $next_round==3) {
				$chips = array();				
				for($i=1;$i<=$game_obj->groups;$i++) {
					$prev_chips = $this->games->get_chips_of_group($game_id,$i,$prev_round);
					foreach($prev_chips as $prev_chip) {
						$area_id = $prev_chip->area_id;
						$focus_id = $prev_chip->focus_id;
						$chips[] = array(
							'game_id' => $game_id,
							'group_number' => $i,
							'round' => $next_round,
							'area_id' => $area_id,
							'focus_id' => $focus_id
						);
					}
					for($j=1;$j<=6;$j++) {
						$chips[] = array(
							'game_id' => $game_id,
							'group_number' => $i,
							'round' => $next_round,
							'area_id' => NULL,
							'focus_id' => NULL
						);
					}
				}
				$this->db->insert_batch('games_groups_chips',$chips);				
			}
			
			$round = array(
				'round' => $next_round
			);
			$this->db->where('id',$game_id);
			$this->db->update('games',$round);
		}
	}
	
	function close_round($game_id) {
		$game_obj = $this->get_game_by_id($game_id);
		$data = array(
			'round_status' => 2
		);
		$this->db->where('id',$game_id);
		$this->db->update('games',$data);		
	}
	
	function open_round($game_id) {
		$game_obj = $this->get_game_by_id($game_id);
		$round = $game_obj->round + 1;
		$data = array(
			'round' => $round,
			'round_status' => 0
		);
		$this->db->where('id',$game_id);
		$this->db->update('games',$data);		
		
		$chips = array();
		for($i=1;$i<=$game_obj->groups;$i++) {
			for($j=1;$j<=6;$j++) {
				$chips[] = array(
					'game_id' => $game_id,
					'group_number' => $i,
					'round' => $round
				);
			}
		}
		$this->db->insert_batch('games_groups_chips',$chips);		
	}


	
/* GROUPS, CHIPS, POINTS */
	function get_groups_with_chips($game_id,$round) {
		$this->db->from('games_groups');
		$this->db->where('game_id',$game_id);
		$groups = $this->db->get()->result();

		foreach($groups as $group) {
			if($round < 4) {
				$group->free_chips = $this->count_free_chips($game_id,$group->number,$round);
			}
			$group->areas = $this->gameboard->get_areas();
			foreach($group->areas as $area) {
				$area->chips = $this->count_chips_in_area($game_id,$group->number,$area->id,$round);
				$area->status = $this->area_status($game_id,$group->number,$area->id);
				foreach($area->focuses as $focus) {
					$focus->chips = $this->count_chips_in_focus($game_id,$group->number,$focus->id,$round);
				}
			}
		}
		return $groups;
	}
	function count_free_chips($game_id,$group_number,$round) {
		$this->db->from('games_groups_chips');
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('round',$round);		
		$this->db->where('area_id IS NULL');
		$this->db->where('focus_id IS NULL');
		return $this->db->count_all_results();;
	}
	function count_chips_in_area($game_id,$group_number,$area_id,$round) {
		$this->db->from('games_groups_chips');
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('round',$round);					
		$this->db->where('area_id',$area_id);
		return $this->db->count_all_results();				
	}
	function count_chips_in_focus($game_id,$group_number,$focus_id,$round) {
		$this->db->from('games_groups_chips');
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('round',$round);		
		$this->db->where('focus_id',$focus_id);
		return $this->db->count_all_results();
	}
	
	function area_status($game_id,$group_number,$area_id) {
		$this->db->from('games_groups_chips');
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('area_id',$area_id);
		$chips = $this->db->count_all_results();
		if($chips > 0) return true;
		return false;
	}



// POINTS
	function update_chip_points($game_id,$round) {
		$game = $this->games->get_game_by_id($game_id);	
		$groups = $game->groups;
		$focus_points = $this->companies->get_points_of_round($game->company_id,$round);  // array: [focus_id => points]
		for($i=1;$i<=$groups;$i++) {
		 	$chips = $this->games->get_chips_of_group($game_id,$i,$round);
		 	foreach($chips as $chip) {
		 		if($chip->focus_id) {
		 			$points = array(
		 				'points' => $focus_points[$chip->focus_id]
					);
				} else {
			 		$points = array(
			 			'points' => 0
					);
				}
				$this->db->where('game_id',$game_id);
				$this->db->where('group_number',$i);
				$this->db->where('round',$round);
				$this->db->where('focus_id',$chip->focus_id);
				$this->db->update('games_groups_chips',$points);
		 	}
		}
	}
	function get_chips_of_group($game_id,$group_number,$round) {
		$this->db->from('games_groups_chips');
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('round',$round);
		return $this->db->get()->result();
	}
	
	function update_group_points($game_id) {
		$game = $this->games->get_game_by_id($game_id);	
		$groups = $game->groups;
		for($i=1;$i<=$groups;$i++) {
			$points = 0;
			$this->db->select_sum('points');
			$this->db->from('games_groups_chips');
			$this->db->where('game_id',$game_id);
			$this->db->where('group_number',$i);
			$points = $this->db->get()->row();			

			$this->db->where('game_id',$game_id);
			$this->db->where('number',$i);
			$this->db->update('games_groups',$points);
		}
	}
	
	
	
	
	function get_areas_of_group($game_id,$group_number,$area_id) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('area_id',$area_id);
		$this->db->from('games_groups_areas');
		$result = $this->db->get()->row();
		if(empty($result)) {
			return 0;
		} else {
			return $result->round;
		}
	}
	function place_chip($game_id,$group_number,$chip) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('area_id IS NULL');
		$this->db->where('focus_id IS NULL');
		$this->db->where('woc',0);
		$this->db->limit(1);
		$this->db->update('games_groups_chips',$chip);
	}	
	function remove_all_chips($game_id,$group_number,$focus_id,$free_chip) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('focus_id',$focus_id);
		$this->db->where('woc',0);
		$this->db->update('games_groups_chips',$free_chip);
	}
	function place_chip_woc($chip) {
		$this->db->insert('games_groups_chips',$chip);
	}
	function remove_chip_woc($game_id,$group_number,$area_id,$focus_id) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number', $group_number);
		$this->db->where('area_id',$area_id);
		$this->db->where('focus_id',$focus_id);
		$this->db->where('woc',1);
		$this->db->limit(1);		
		$this->db->delete('games_groups_chips');
	}
	
	// POINTS


	function get_points_of_groups_in_area($game_id,$area_id) {
		$this->db->select('group_number, SUM(points) as total');
		$this->db->group_by('group_number');
		$this->db->where('game_id',$game_id);
		$this->db->where('area_id',$area_id);
		$this->db->from('games_groups_chips');
		return $this->db->get()->result();
	}

	function update_areas_of_group($game_id,$group_number,$round) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->from('games_groups_areas');
		$areas = $this->db->get()->result();

		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->delete('games_groups_areas');
				
		$this->db->distinct();
		$this->db->select('area_id');
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->from('games_groups_chips');
		$areas_new = $this->db->get()->result();
		
		$data = array();
		foreach($areas_new as $area) {
			$data[] = array(
				'game_id' => $game_id,
				'group_number' => $group_number,
				'area_id' => $area->area_id,
				'round' => $round
			);
		}
		$this->db->insert_batch('games_groups_areas',$data);

		foreach($areas as $area) {
			$data = array('round' => $area->round);
			$this->db->where('game_id',$game_id);
			$this->db->where('group_number',$group_number);
			$this->db->where('area_id',$area->area_id);
			$this->db->update('games_groups_areas',$data);
		}
	}

	
	function get_points_of_groups($game_id) {
		$this->db->where('game_id',$game_id);
		$this->db->order_by('number','asc');
		$this->db->from('games_groups');
		return $this->db->get()->result();
	}
	function get_max_points_of_groups($game_id) {
		$this->db->where('game_id',$game_id);
		$this->db->order_by('points','desc');
		$this->db->from('games_groups');
		$group = $this->db->get()->row();
		return $group->points;
	}
}