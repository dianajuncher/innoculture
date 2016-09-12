<div id="manage" class="wrapper" data-game-id="<?=$game->id?>" data-round="<?=($section=='points' ? $round : '')?>">

	<p>Spilstatus: <?=($game->finished ? 'Afsluttet' : 'I gang')?></p>
	<p>
		Intro:<br/>
		<a class="button" href="<?=game_manage_keywords_url(0)?>">Stikord</a>
	</p>
	<p>
		Runde 1<br/>
		<? if($game->round1==1): ?>
			<a class="button" href="<?=game_manage_keywords_url(1)?>">Stikord</a>
			<a class="button" href="<?=game_manage_chips_url(1)?>">Point</a>
		<? else: ?>
			<p>Runden er lukket</p>
		<? endif; ?>
	</p>
	<p>
		Runde 2<br/>
		<? if($game->round2==1): ?>
			<a class="button" href="<?=game_manage_keywords_url(2)?>">Stikord</a>
			<a class="button" href="<?=game_manage_chips_url(2)?>">Point</a>
		<? else: ?>
			<p>Runden er lukket</p>
		<? endif; ?>
	</p>
	<p>
		Runde 3<br/>
			<? if($game->round3==1): ?>
		<a class="button" href="<?=game_manage_keywords_url(3)?>">Stikord</a>
			<a class="button" href="<?=game_manage_chips_url(3)?>">Point</a>
		<? else: ?>
			<p>Runden er lukket</p>
		<? endif; ?>
	</p>
	<p>
		Wisdom of Crowds
		<a class="button" href="<?=game_manage_woc_url()?>">Jetoner</a>
	</p>
	<p>
		Afslutning
	</p>
</div>
