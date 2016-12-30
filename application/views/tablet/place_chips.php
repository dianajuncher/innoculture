<div id="chips" class="wrapper" data-game-id="<?=$game->id?>" data-round="<?=$round?>" data-role="page" data-status="<?=$status?>">
	<div class="title">
		Gruppernes valg - runde <?=$round?>
	</div>

	<div class="group-container">
		<? for($i=1;$i<=sizeof($groups);$i++): ?>
			<div class="group <?=($i==1 ? 'selected' : '')?>" data-group-number="<?=$i?>"><?=$i?></div>
		<? endfor; ?>
	</div>
				
	<? foreach($groups as $group): ?>
		<div class="area-container area-container-<?=$group->number?> <?=($group->number==1 ? 'selected' : '')?>">
			<? foreach($group->areas as $area): ?>
				<div class="flip <?=($area->chips>0 ? 'flipped' : '')?> <?($area->status ? ' flipped locked' : '')?>">
					<div class="front">
						<div class="area-front" style="background-image: url('<?=base_url()?>public/images/areas/<?=$area->id?>_front_dk.png')"> </div>
					</div>
					<div class="back">
						<div class="area-back area-<?=$area->id?>" style="background-image: url('<?=base_url()?>public/images/areas/<?=$area->id?>_back_dk.png')">
							<? foreach($area->focuses as $focus): ?>
								<div class="focus focus-<?=$focus->number?><?=($focus->chips==1 ? ' one-chip' : '')?><?=($focus->chips==2 ? ' two-chips' : '')?>" data-game-id="<?=$game->id?>" data-group-number="<?=$group->number?>" data-area-id="<?=$area->id?>" data-focus-id="<?=$focus->id?>">
									<span><?=$focus->chips?></span>
								</div>
							<? endforeach; ?>
						</div>
					</div>
				</div>
			<? endforeach; ?>
		</div>
	<? endforeach; ?>
	
	<div class="free-chips">
		<? foreach($groups as $group): ?>
			<div class="chips chips-<?=$group->number?> <?=($group->number==1 ? 'selected' : '')?>"><span><?=$group->free_chips?></span></div>
		<? endforeach; ?>
		<div class="text">Jetoner tilbage</div>
	</div>
	<div class="free-chips-popup">
		<? foreach($groups as $group): ?>
			<div class="chips-<?=$group->number?>">Gruppe <?=$group->number?>: <span><?=$group->free_chips?><span></div>
		<? endforeach; ?>
	</div>
	
	<div class="close-round <?=($status=='closed' ? 'closed' : '')?>" data-status="<?=$status?>">
		<div class="icon"><i class="fa fa-check"></i></div>
		<div class="text">Luk runden</div>		
	</div>	
	<div class="close-round-popup">
		<div class="header">Luk runden</div>
		<div class="chips">Advarsel: en eller flere grupper har ikke placeret alle deres jetoner.</div>
		<div class="warning">Tryk OK for at lukke runden og beregne gruppernes point. Bemærk at runden ikke kan åbnes igen.</div>
		<div class="ok">OK</div><div class="cancel">ANNULLER</div>
	</div>	
</div>
