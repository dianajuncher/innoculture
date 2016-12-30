<div id="login" class="wrapper">

	<div class="login-box">
		<div class="logo"><img src="<?=base_url()?>public/images/logo_inno.png"/></div>
		<? if(isset($this->session->userdata['logged_in'])): ?>
			<p><?=lang("auth_loggedin")?></p>
			<form method="post" action="<?=logout_url()?>">	
				<input type="hidden" name="username" value="<?=$username?>" /><br />
				<input type="submit" value="<?=lang("auth_logout")?>" />
			</form>
		<? else: ?>
			<form method="post" action="<?=login_url()?>">
				<input type="text" name="username" placeholder="<?=lang("auth_username")?>" /><br />
				<input type="password" name="password" placeholder="<?=lang("auth_password")?>" /><br />
				<input type="submit" value="<?=lang("auth_login")?>" />
			</form>
		<? endif; ?>
	</div>
</div>
