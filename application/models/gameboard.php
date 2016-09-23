<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


class Gameboard extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_areas() {
		$this->db->from('gameboard_areas');
		$areas = $this->db->get()->result();
		foreach($areas as $area) {
			$area->focuses = $this->gameboard->get_focuses_of_area($area->id);
		}
		return $areas;
	}
	
	function get_areas_with_points($game_id,$company_id,$round) {
		$this->db->from('gameboard_areas');
		$areas = $this->db->get()->result();
		foreach($areas as $area) {		
			$area->focuses = $this->gameboard->get_focuses_of_area($area->id,$company_id,$round);
		}
		return $areas;
	}	
	
	function get_focuses_of_area($area_id,$company_id=NULL,$round=NULL) {
		$this->db->from('gameboard_focuses');
		$this->db->where('area_id',$area_id);
		$this->db->order_by('id','asc');
		$focuses = $this->db->get()->result();
		
		if($company_id && $round) {
			foreach($focuses as $focus) {
				$focus->points = $this->companies->get_points_of_focus($company_id,$focus->id,$round);
			}
		}
		return $focuses;
	}
	

}