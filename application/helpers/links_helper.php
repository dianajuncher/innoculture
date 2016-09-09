<?php

    function login_url()
    {
        return base_url('login');
    }
    
    function logout_url()
    {
        return base_url('logout');
    }

	function switch_language_url($language)
	{
		return base_url('language/'.$language);
	}
	
	function account_url()
	{
		return base_url('account');
	}
    
	function game_list_url()
	{
		return base_url('game_list');
	}
	
	function game_create_url()
	{
		return base_url('game_create');
	}
	
	function game_delete_url($game_id)
	{
		return base_url('game_delete/'.$game_id);
	}
	
	function game_url($game_id)
	{
		return base_url('game/'.$game_id);
	}
	
	function game_resources_url($company_id) {
		return base_url('resources/'.$company_id);
	}
	
	function game_present_url($page)
	{
		return base_url('game_present/'.$page);
	}
	
	function game_manage_url()
	{
		return base_url('game_manage');
	}	
	function game_manage_keywords_url($round)
	{
		return base_url('game_manage/keywords/'.$round);
	}	
	function game_manage_points_url($round)
	{
		return base_url('game_manage/points/'.$round);
	}

?>