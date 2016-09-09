<div id="home" class="wrapper">

	<? if(isset($this->session->userdata['logged_in'])): ?>
		<p><?=lang("auth_loggedin")?></p>
	<? else: ?>
		<form method="post" action="<?=login_url()?>">
			<input type="text" name="username" placeholder="<?=lang("auth_username")?>" />
			<input type="password" name="password" placeholder="<?=lang("auth_password")?>" />
			<input type="submit" value="<?=lang("auth_login")?>" />
		</form>
	<? endif; ?>

	<p>Blah blah blah</p>





</div>

</body>
</html>