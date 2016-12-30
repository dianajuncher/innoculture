<nav class="tablet">
	<div class="logo">
		<a href="<?=base_url()?>"><img src="<?=base_url()?>public/images/logo_inno.png"/></a>
	</div>	
	<div class="title"><?=lang("page_overview")?></div>
	<div class="menu">
		<div class="menu-button menu-open"><img src="<?=base_url()?>public/images/menu_open.png" /></div>
		<div class="menu-button menu-close"><img src="<?=base_url()?>public/images/menu_close.png" /></div>				
		<div class="menu-dropdown">
			<a href="<?=home_url()?>"><?=lang("page_home")?></a><br/>
			<a href="<?=account_url()?>"><?=lang("page_account")?></a><br/>
			<a href="<?=logout_url()?>"><?=lang("auth_logout")?></a>
		</div>
	</div>
</nav>	
	
<div id="overview" class="wrapper">
	<div class="col intro">
		<div class="title">Intro</div>
		<div class="link"><a href="<?=keywords_url(0)?>">Stikord</a></div>		
	</div>

	<div class="col round1">
		<div class="title">Runde 1</div>
		<div class="link"><a href="<?=place_chips_url(1)?>">Placer jetoner</a></div>
		<div class="link"><a href="<?=keywords_url(1)?>">Stikord</a></div>
	</div>

	<div class="col round2">
		<div class="title">Runde 2</div>
		<div class="link"><a href="<?=place_chips_url(2)?>">Placer jetoner</a></div>		
		<div class="link"><a href="<?=keywords_url(2)?>">Stikord</a></div>
	</div>

	<div class="col round3">
		<div class="title">Runde 3</div>
		<div class="link"><a href="<?=place_chips_url(3)?>">Placer jetoner</a></div>		
		<div class="link"><a href="<?=keywords_url(3)?>">Stikord</a></div>
	</div>
	<div class="col woc">
		<div class="title">W.O.C.</div>
		<div class="link"><a href="<?=place_chips_url(4)?>">Placer jetoner</a></div>
		<div class="link"><a href="<?=keywords_url(4)?>">Stikord</a></div>
	</div>
	
</div>
