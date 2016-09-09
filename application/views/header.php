<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Innoculture</title>

	<? foreach( $this->config->item('default_css') as $css_file): ?>
		<link href="<?=base_url()?>public/css/<?=$css_file?>" rel="stylesheet">
	<? endforeach; ?>
	
	<? foreach( $this->config->item('default_js') as $js_file): ?>
		<script src="<?=base_url()?>public/js/<?=$js_file?>"></script>
	<? endforeach; ?>
</head>
<body>
	<nav>
		<div class="logo">
			<a href="<?=base_url()?>"><img src="<?=base_url()?>public/images/logo_inno.png"/></a>
		</div>
<!--		<? if($section=='home'): ?>
			<div class="language">
				<a href="<?=switch_language_url("danish")?>">DK</a>
				<a href="<?=switch_language_url("english")?>">EN</a>
			</div>

		<? endif; ?>
-->		
		<div class="title">
			<?=($section=='account' ? lang("page_account") : '')?>
			<?=($section=='game_list' ? lang("page_game_list") : '')?>			
		</div>
		<? if($is_loggedin): ?>
			<div class="menu">
				<div class="menu-button menu-open"><img src="<?=base_url()?>public/images/menu_open.png" /></div>
				<div class="menu-button menu-close"><img src="<?=base_url()?>public/images/menu_close.png" /></div>				
				<div class="menu-dropdown">
					<a href="<?=game_list_url()?>"><?=lang("page_game_list")?></a><br/>
					<a href="<?=account_url()?>"><?=lang("page_account")?></a><br/>
					<a href="<?=logout_url()?>"><?=lang("auth_logout")?></a>
				</div>
			</div>
		<? endif; ?>	
	</nav>
</body>
								
 