<div id="game" class="wrapper">

	<h1>Innoculture</h1>	

	<h2><?=$game->name?></h2>
	
	<? if($game->started): ?>
		<p><a href="<?=game_presentation_url('intro')?>">Link to presentation</a></p>
		<p><a href="<?=game_manage_url()?>">Link to tablet version</a></p>
	<? else: ?>
		<p>Information</p>
		<p>Når du starter et spil, kan du ikke redigere i det længere.</p>
	
		<form method="post" action="<?=game_url($game->id)?>">
			<input type="hidden" name="start_game" value="<?=$game->id?>"/>
			<input type="submit" value="Start"/>
		</form>

	<? endif; ?>

</div>