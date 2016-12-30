<div id="home" class="wrapper">

	<div class="game-container new-game-container">
		<div class="game-name">
			<div class="title"><?=lang("list_name")?></div>
		</div>
		<div class="game-groups">
			<div class="title"><?=lang("list_groups")?></div>
		</div>
		<div class="game-scenario">
			<div class="title"><?=lang("list_scenario")?></div>
		</div>
		<div class="game-info">
			<div class="title">Info</div>
		</div>
		<div class="game-link game-start">
			<img src="<?=base_url()?>public/images/game_start.png"/>
		</div>
		<div class="new-game-button">
			<img src="<?=base_url()?>public/images/game_new.png"/>
		</div>
	</div>
	
	<? foreach($games as $game): ?>
		<div class="game-container game-container-<?=$game->id?>">
			<div class="game-name">
				<div class="title"><?=lang("list_name")?></div>
				<? if($game->started): ?>
					<div class="content"><?=$game->name?></div>
				<? else: ?>
<!--					<div class="edit"><img src="<?=base_url()?>public/images/icon_edit.png"/></div>
					<div class="save"><img src="<?=base_url()?>public/images/icon_save.png"/></div>			
-->
					<div class="content editable">
						<textarea rows="3" data-game-id="<?=$game->id?>" placeholder="<?=lang("list_name_default")?>"><?=$game->name?></textarea>
					</div>
				<? endif; ?>
			</div>	
			<div class="game-groups">
				<div class="title"><?=lang("list_groups")?></div>
				<? if($game->started): ?>
					<div class="content"><?=$game->groups?></div>	
				<? else: ?>			
					<div class="drop-down-arrow"><img src="<?=base_url()?>public/images/icon_arrow.png"/></div>			
					<div class="content"><span><?=($game->groups==0 ? lang("list_choose") : $game->groups)?></span>
						<div class="groups-drop-down" data-game-id="<?=$game->id?>">
							<? for($i=1;$i<=8;$i++): ?>
								<div><?=$i?></div>
							<? endfor;?>
						</div>
					</div>	
				<? endif;?>
			</div>
			<div class="game-scenario">
				<div class="title"><?=lang("list_scenario")?></div>
				<? if($game->started): ?>
					<div class="content"><?=$game->company_name?></div>	
				<? else: ?>
					<div class="drop-down-arrow"><img src="<?=base_url()?>public/images/icon_arrow.png"/></div>			
					<div class="content"><span><?=($game->company_id==0 ? lang("list_choose") : $game->company_name)?></span>
						<div class="scenarios-drop-down" data-game-id="<?=$game->id?>">
							<? foreach($companies as $company): ?>
								<div data-company-id="<?=$company->id?>"><?=$company->name?></div>
							<? endforeach; ?>
						</div>
					</div>					
				<? endif; ?>
			</div>
			
			<? if($game->started): ?>
				<div class="game-status">
					<div class="title"><?=lang("list_status")?></div>
					<div class="content">
						<? if($game->finished): ?>
							<?=lang("status_finished")?>
						<? else: ?>
							<?=lang("status_running")?>
						<? endif; ?>					
					</div>	
				</div>
				<div class="game-created">
					<div class="title"><?=lang("list_created")?></div>
					<div class="content"><?=date('d.m.y',strtotime($game->created))?></div>	
				</div> 
			<? else: ?>
				<div class="game-info">
					<div class="title">Info</div>
					<div class="content"><?=lang("list_info")?></div>
				</div>
			<? endif; ?>
			
			<? if($game->started): ?>	
				<div class="game-link game-preparation">
					<form method="post" action="<?=preparation_url()?>">
						<input type="hidden" name="game-id" value="<?=$game->id?>" />
						<input class="game-select" type="image" src="<?=base_url()?>public/images/game_resources.png" />
					</form>					
				</div>
				<div class="game-link game-manage">
					<form method="post" action="<?=overview_url()?>">
						<input type="hidden" name="game-id" value="<?=$game->id?>" />
						<input class="game-select" type="image" src="<?=base_url()?>public/images/game_manage.png" />
					</form>
				</div>
				<div class="game-link game-present">
					<form method="post" action="<?=presentation_url()?>">
						<input type="hidden" name="game-id" value="<?=$game->id?>" />
						<input class="game-select" type="image" src="<?=base_url()?>public/images/game_present.png" />
					</form>				
				</div>
			<? else: ?>
				<div class="game-link game-start <?=(strlen($game->name)>0 && $game->groups>0 && $game->company_id>0 ? 'active' : '')?>" data-game-id="<?=$game->id?>">
					<img src="<?=base_url()?>public/images/game_start.png"/>		
				</div>
			<? endif; ?>
		</div>
	<? endforeach;?>	
</div>