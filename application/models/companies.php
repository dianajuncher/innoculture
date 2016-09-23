<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


class Companies extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_company($company_id) {
		$this->db->where('id',$company_id);
		$this->db->from('companies');
		return $this->db->get()->row();
	}
	function get_company_name($company_id) {
		$this->db->where('id',$company_id);
		$this->db->from('companies');
		$company = $this->db->get()->row();
		return $company->name;
	}
	function get_companies() {
		$this->db->from('companies');
		return $this->db->get()->result();
	}

	function get_pages_of_part($company_id,$part) {
		$this->db->from('companies_pages');
		$this->db->where('company_id',$company_id);
		$this->db->where('part',$part);
		$this->db->order_by('number','asc');
		return $this->db->get()->result();
	}	
	
	function get_points_of_round($company_id,$round) {
		$this->db->from('companies_points');
		$this->db->where('company_id',$company_id);
		$result = $this->db->get()->result();
		$points = array();
		foreach($result as $point)  {
			if($round==1)
				$points[$point->focus_id] = $point->round1;
			elseif($round==2) 
				$points[$point->focus_id] = $point->round2;
			else
				$points[$point->focus_id] = $point->round3;
		}
		return $points;
	}	
	
	function get_points_of_focus($company_id,$focus_id,$round) {
		$this->db->from('companies_points');
		$this->db->where('company_id',$company_id);
		$this->db->where('focus_id',$focus_id);
		$points = $this->db->get()->row();
		if($round==1) return $points->round1;
		if($round==2) return $points->round2;
		if($round==3) return $points->round3;
		return 0;
	}

}