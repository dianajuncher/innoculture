<div id="game-list" class="wrapper">


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
				<a href="<?=game_manage_url($game->company_id)?>"><img src="<?=base_url()?>public/images/game_resources.png"/></a>
			</div>
			<div class="game-link game-manage">
				<a href="<?=game_manage_url()?>"><img src="<?=base_url()?>public/images/game_manage.png"/></a>
			</div>
			<div class="game-link game-present">
				<a href="<?=game_present_url(1)?>"><img src="<?=base_url()?>public/images/game_present.png"/></a>
			</div>
		</div>
	<? endforeach;?>	
	
	
<!--
	<table>
	<tr>
		<th><?=lang("list_game")?></th>
		<th><?=lang("list_status")?></th>
		<th><?=lang("list_created")?></th>
		<th><?=lang("list_actions")?></th>
	</tr>
	<? foreach($games as $game): ?>
		<tr>
			<td><?=$game->name?></td>
			<td>
				<? if($game->finished): ?>
					<?=lang("status_finished")?>
				<? elseif($game->started): ?>
					<?=lang("status_running")?>
				<? else: ?>
					<?=lang("status_created")?>
				<? endif; ?>
			<td><?=$game->created?></td>			
			<td>
				<form method="post" action="<?=game_delete_url($game->id)?>">
					<input type="hidden" name="delete" value="<?=$game->id?>"/>
					<input type="submit" class="button_small" value="<?=lang("action_delete")?>"/>	
				<? if(!$game->started): ?>
					  <a class="button_small" href="<?=game_url($game->id)?>"><?=lang("action_start")?></a>
				<? else: ?>
					  <a class="button_small" href="<?=game_url($game->id)?>"><?=lang("action_goto")?></a>
				<? endif; ?>
				</form>
			</td>
		</tr>
	<? endforeach; ?>
	</table>
	
	<div class="button">
		<a href="<?=game_create_url()?>"><?=lang("action_create")?></a>
	</div>

-->



</div>