<?php

/* AUTH CONTROLLER */
    function login_url() {
        return base_url('login');
    }
    function logout_url() {
        return base_url('logout');
    }
	function account_url() {
		return base_url('account');
	}


/* LANGUAGE CONTROLLER */
	function switch_language_url($language) {
		return base_url('language/'.$language);
	}
	

/* GAME CONTROLLER */
	function home_url() {
		return base_url('home');
	}
	
	function preparation_url() {
		return base_url('preparation');
	}

	function overview_url() {
		return base_url('overview');		
	}
	function place_chips_url($round) {
		return base_url('place_chips/'.$round);
	}
	function keywords_url($part) {
		return base_url('keywords/'.$part);
	}

	function presentation_url($page=NULL) {
		return base_url('presentation');	
	}
	function timer_url() {
		return base_url('timer');
	}
	function result_url() {
		return base_url('result');
	}
	function leaderboard_url() {
		return base_url('leaderboard');
	}

?>