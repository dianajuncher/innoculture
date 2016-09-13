<div id="leaderboard" class="wrapper">

	<div class="leaderboard-container" data-max-points="<?=$max_points?>">
		<? foreach($groups as $group): ?>
			<div class="group-container">
				<div class="group-number"><span><?=$group->number?></span></div>
				<div class="score-bar-container">
					<div data-points="<?=$group->points?>" class="score-bar"></div>
				</div>
				<div class="group-score <?=($group->points==$max_points ? 'leader' : '')?>"><span><?=$group->points?></span></div>
			</div>
		<? endforeach;?>
	</div>
</div>