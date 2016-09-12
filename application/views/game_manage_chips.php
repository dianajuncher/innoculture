<div id="chips" class="wrapper" data-game-id="<?=$game->id?>" data-round="<?=$round?>">

	<div class="group-container">
		<? for($i=1;$i<=sizeof($groups);$i++): ?>
			<div class="group <?=($i==1 ? 'selected' : '')?>" data-group-number="<?=$i?>"><?=$i?></div>
		<? endfor; ?>
	</div>
		
	<div class="chips-container">
		<? foreach($groups as $group): ?>
			<div class="chips chips-<?=$group->number?> <?=($group->number==1 ? 'selected' : '')?>">Jetoner: <span><?=$group->free_chips?></span></div>
		<? endforeach; ?>
	</div>
	<div style="clear:both"></div>
		
	<? foreach($groups as $group): ?>
		<div class="area-container area-container-<?=$group->number?> <?=($group->number==1 ? 'selected' : '')?>">
			<? foreach($group->areas as $area): ?>
				<div class="flip <?=($area->chips>0 ? 'flipped' : '')?> <?=($area->round>0 ? ' flipped locked' : '')?>">
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
	<div class="button calculate-points">Beregn point</div>
</div>
