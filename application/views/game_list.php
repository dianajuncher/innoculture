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
				<a class="game-select" href="<?=game_manage_url()?>" data-game-id="<?=$game->id?>"><img src="<?=base_url()?>public/images/game_manage.png"/></a>
			</div>
			<div class="game-link game-present">
				<a class="game-select" href="<?=game_present_url(1)?>" data-game-id="<?=$game->id?>"><img src="<?=base_url()?>public/images/game_present.png"/></a>
			</div>
		</div>
	<? endforeach;?>	
</div>