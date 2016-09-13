<div id="game-list" class="wrapper">

	<div class="new-game-container">
		
	</div>

	<? foreach($games as $game): ?>
		<div class="game-container">
			<div class="game-name">
				<div class="title"><?=lang("list_name")?></div>
				<div class="content"><?=$game->name?></div>	
			</div>	
			<div class="game-groups">
				<div class="title"><?=lang("list_groups")?></div>
				<div class="content"><?=$game->groups?></div>	
			</div>
			<div class="game-scenario">
				<div class="title"><?=lang("list_scenario")?></div>
				<div class="content"><?=$game->company_name?></div>	
			</div>
			<div class="game-status">
				<div class="title"><?=lang("list_status")?></div>
				<div class="content">
					<? if($game->finished): ?>
						<?=lang("status_finished")?>
					<? elseif($game->started): ?>
						<?=lang("status_running")?>
					<? else: ?>
						<?=lang("status_created")?>
					<? endif; ?>					
				</div>	
			</div>
			<div class="game-created">
				<div class="title"><?=lang("list_created")?></div>
				<div class="content"><?=date('d.m.y',strtotime($game->created))?></div>	
			</div> 
			<div class="game-link game-ressources">
				<a href="<?=game_resources_url($game->company_id)?>"><img src="<?=base_url()?>public/images/game_resources.png"/></a>
			</div>
			<div class="game-link game-manage">
				<form method="post" action="<?=game_manage_url()?>">
					<input type="hidden" name="game-id" value="<?=$game->id?>" />
					<input class="game-select" type="image" src="<?=base_url()?>public/images/game_manage.png" />
				</form>
			</div>
			<div class="game-link game-present">
				<form method="post" action="<?=game_present_url()?>">
					<input type="hidden" name="game-id" value="<?=$game->id?>" />
					<input class="game-select" type="image" src="<?=base_url()?>public/images/game_present.png" />
				</form>				
			</div>
		</div>
	<? endforeach;?>	
</div>