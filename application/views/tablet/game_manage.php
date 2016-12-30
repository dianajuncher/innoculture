<div id="manage" class="wrapper" data-game-id="<?=$game->id?>" data-round="<?=($section=='points' ? $round : '')?>" style="font-size: 200%">
	<div class="game-list-link">
		<a href="<?=game_list_url()?>">&laquo; Mine spil</a>
	</div>
	<h2>Spilstyring</h2>
<!--	<p>Spilstatus: <?=($game->finished ? 'Afsluttet' : 'I gang')?></p>
	<p>
		Intro:<br/>
		<a href="<?=game_manage_keywords_url(0)?>">Se stikord</a>
	</p>
	-->
	<p>Runde: <?=$game->round?><br/>
<!--		<a href="<?=game_manage_keywords_url($game->round)?>">Se stikord</a><br />-->
		<a href="<?=game_manage_chips_url($game->round)?>">Placer jetoner</a>
	</p>
	<? if($game->round<4 && $game->round_status==1): ?>
		<p><a class="close-round">Luk runde <?=$game->round?></a></p>
	<? endif; ?>
	<? if($game->round_status==2): ?>
		<p>Runden er lukket. 
			<?if($game->round<3): ?>
				<a class="open-round"> Åben runde <?=($game->round)+1?></a>
			<? endif; ?>
		</p>
	<? endif;?>
	
	<p>Wisdom of crowds:<br />
			<a href="<?=game_manage_woc_url()?>">Placer jetoner</a>
	</p>
		

	
<!--
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
-->
</div>
