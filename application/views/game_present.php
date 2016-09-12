<div id="presentation" class="wrapper">

	<h2>Scenario: <?=$company->name?></h2>	

	<p>Presentation: intro, round 1, round 2, round 3, afslutning + wisdom of crowds</p>
	
	<p><a class="button" href="<?=game_leaderboard_url()?>">Leaderboard</a></p>
	
	
<!--
	<div class="pages-container">
		<? foreach($pages as $page): ?>
			<div class="page-wrap" id="page-<?=$page->number?>" <?=($page->number==1 ? '' : 'style="display:none;"')?>>
				<div class="page-content"><?=$page->content_dk?></div>
				<? if($page->number>1): ?>
					<div class="prev-button" data-page="<?=$page->number?>" data-new-page="<?=($page->number-1)?>"><<</div>
				<? endif; ?>
				<? if($page->number<sizeof($pages)): ?>
					<div class="next-button" data-page="<?=$page->number?>" data-new-page="<?=($page->number+1)?>">>></div>
				<? endif; ?>
			</div>
		<? endforeach; ?>
	</div>
-->




</div>

</body>
</html>