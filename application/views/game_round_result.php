<div id="result" class="wrapper" data-game-id="<?=$game->id?>">

	<div class="result-container">
		<div class="title">Scoring efter runde ??</div>
		<? foreach($groups as $group): ?>
			<div class="group-container group-<?=$group->number?>">
				<div class="score-bar">
					<? for($i=1;$i<=14;$i++) :?>
						<div class="point"></div>
					<? endfor;?>
				</div>
				<div class="group-number"><span><?=$group->number?></span></div>				
			</div>
		<? endforeach;?>
	</div>
	
	<div class="gameboard-container">
		<? foreach($areas as $area): ?>
			<div class="area area-<?=$area->id?>" data-area-id="<?=$area->id?>" style="background-image: url('<?=base_url()?>public/images/areas/<?=$area->id?>_back_dk.png')">
				<? foreach($area->focuses as $focus): ?>
					<div class="focus focus-<?=$focus->number?>" data-focus-id="<?=$focus->id?>">
						<span class="<?=($focus->points==1 ? 'one-point' : '')?><?=($focus->points==2 ? 'two-points' : '')?>">
							<? if($focus->points>0) {
								if($focus->points==2) {
									echo "!!";
								} else {
									echo "!";
								}
							} ?>
						</span>
					</div>
				<? endforeach; ?>
			</div>
		<? endforeach; ?>
		<div class="logo"><img src="<?=base_url()?>public/images/logo_inno.png?>"></div>
	</div>

</div>