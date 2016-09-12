<div id="woc" class="wrapper" data-game-id="<?=$game->id?>">

	<div class="group-container">
		<? for($i=1;$i<=sizeof($groups);$i++): ?>
			<div class="group <?=($i==1 ? 'selected' : '')?>" data-group-number="<?=$i?>"><?=$i?></div>
		<? endfor; ?>
	</div>
		
	<div style="clear:both"></div>
		
	<? foreach($groups as $group): ?>
		<div class="area-container area-container-<?=$group->number?> <?=($group->number==1 ? 'selected' : '')?>">
			<? foreach($group->areas as $area): ?>
				<div class="flip">
					<div class="front">
						<div class="area-front" style="background-image: url('<?=base_url()?>public/images/areas/<?=$area->id?>_front_dk.png')"> 
							<div class="area area-<?=$area->id?>" data-game-id="<?=$game->id?>" data-group-number="<?=$group->number?>" data-area-id="<?=$area->id?>">
								<span><?=$area->chips?></span>
							</div>
						</div>
					</div>
					<div class="back">
						<div class="area-back" style="background-image: url('<?=base_url()?>public/images/areas/<?=$area->id?>_back_dk.png')">
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
</div>
