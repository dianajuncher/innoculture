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
			$this->db->from('gameboard_focuses');
			$this->db->where('area_id',$area->id);
			$this->db->order_by('id','asc');
			$area->focuses = $this->db->get()->result();
		}
		return $areas;
	}
}