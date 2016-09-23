<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


class Games extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

// GAME ADMINISTRATION
	function get_game_by_id($game_id) {
		$this->db->from('games');
		$this->db->where('id',$game_id);
		return $this->db->get()->row();
	}
		
	function get_games_of_user($userid) {
		$this->db->from('games');
		$this->db->where('user_id',$userid);
		$games = $this->db->get()->result();
		foreach($games as $game) {
			$game->groups = $this->games->count_groups_of_game($game->id);
			$game->company_name = $this->companies->get_company_name($game->company_id);
		}
		return $games;
	}
	
	function create_game($name,$company_id,$number_of_groups,$language) {
		$date = date('d-m-Y H:i:s');
		$user_id = $this->session->userdata['userid'];
		$game = array(
			'company_id' => $company_id,
			'user_id' => $user_id,
			'name' => $name,
			'created' => $date,
			'language' => $language
		);
		$this->db->insert('games',$game);
		$game_id = $this->db->insert_id();
		
		$groups = array();
		for($i=1;$i<=$number_of_groups;$i++) {
			$groups[] = array(
				'game_id' => $game_id,
				'number' => $i
			);
		}
		$this->db->insert_batch('games_groups',$groups);
	}
	
	function delete_game($game_id) {
		$this->db->where('id',$game_id);
		$this->db->delete('games');
		
		$this->db->where('game_id',$game_id);
		$this->db->delete('games_groups');
		
		$this->db->where('game_id',$game_id);
		$this->db->delete('games_groups_chips');
	}

	function start_game($game_id) {
		$data = array(
			'started' => 1,
			'intro' => 1
		);
		$this->db->where('id',$game_id);
		$this->db->update('games',$data);
		
		$this->games->open_round($game_id,1);		
	}
	
	
/* GROUPS, CHIPS, POINTS */
	function get_groups_of_game($game_id,$woc=0) {
		$this->db->where('game_id',$game_id);
		$this->db->from('games_groups');
		$groups = $this->db->get()->result();

		foreach($groups as $group) {
			if($woc==0) {
				$group->free_chips = $this->count_free_chips_of_group($game_id,$group->number);
			}
			$group->areas = $this->gameboard->get_areas();
			foreach($group->areas as $area) {
				$area->chips = $this->count_chips_of_group_in_area($game_id,$group->number,$area->id,$woc);
				if($woc==0) {
					$area->round = $this->get_areas_of_group($game_id,$group->number,$area->id);
				}
				foreach($area->focuses as $focus) {
					$focus->chips = $this->count_chips_of_group_in_focus($game_id,$group->number,$focus->id,$woc);
				}
			}
		}
		return $groups;
	}
	function count_groups_of_game($game_id) {
		$this->db->where('game_id',$game_id);
		$this->db->from('games_groups');
		return $this->db->count_all_results();
	}
	function get_chips_of_group($game_id,$group_number) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('woc',0);
		$this->db->from('games_groups_chips');
		return $this->db->get()->result();
	}
	function count_free_chips_of_group($game_id,$group_number) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('woc',0);		
		$this->db->where('area_id IS NULL');
		$this->db->where('focus_id IS NULL');
		$this->db->from('games_groups_chips');
		return $this->db->count_all_results();;
	}
	function count_chips_of_group_in_area($game_id,$group_number,$area_id,$woc) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('area_id',$area_id);
		$this->db->where('woc',$woc);			
		$this->db->from('games_groups_chips');
		return $this->db->count_all_results();				
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
	function count_chips_of_group_in_focus($game_id,$group_number,$focus_id,$woc) {
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('focus_id',$focus_id);
		$this->db->where('woc',$woc);			
		$this->db->from('games_groups_chips');
		return $this->db->count_all_results();
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
	function update_chip_points($game_id,$group_number,$focus_id,$points) {
		$data = array(
			'points' => $points
		);
		$this->db->where('game_id',$game_id);
		$this->db->where('group_number',$group_number);
		$this->db->where('focus_id',$focus_id);
		$this->db->where('woc',0);
		$this->db->update('games_groups_chips',$data);
	}
	function save_points_of_group($game_id,$group_number,$points) {
		$data = array(
			'points' => $points
		);
		$this->db->where('game_id',$game_id);
		$this->db->where('number',$group_number);
		$this->db->update('games_groups',$data);
	}
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
	function open_round($game_id,$round) {
		$data = array(
			'round'.$round => 1
		);
		$this->db->where('id',$game_id);
		$this->db->update('games',$data);
		
		$number_of_groups = $this->games->count_groups_of_game($game_id);
		$chips = array();
		for($i=1;$i<=$number_of_groups;$i++) {
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
	function close_round($game_id,$round) {
		$data = array(
			'round'.$round => 2
		);
		$this->db->where('id',$game_id);
		$this->db->update('games',$data);
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