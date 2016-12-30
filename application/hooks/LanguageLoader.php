<?php
class LanguageLoader
{
    function initialize() {
        $ci =& get_instance();
        $ci->load->helper('language');
		
		$language = $ci->session->userdata('language');
        if ($language=="english") {
            $ci->lang->load('dictionary',$ci->session->userdata('language'));
        } else {
            $ci->lang->load('dictionary','danish');
        }
    }
}