<div id="home" class="wrapper">

	<? if(isset($this->session->userdata['logged_in'])): ?>
		<p><?=lang("auth_loggedin")?></p>
	<? else: ?>
		<div class="login-box">
			<form method="post" action="<?=login_url()?>">
				<input type="text" name="username" placeholder="<?=lang("auth_username")?>" /><br />
				<input type="password" name="password" placeholder="<?=lang("auth_password")?>" /><br />
				<input type="submit" class="button_small" value="<?=lang("auth_login")?>" />
			</form>
		</div>
	<? endif; ?>
</div>
