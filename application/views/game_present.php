<div id="presentation" class="wrapper">

	<h1>Innoculture</h1>	

	<h2><?=$part?></h2>
	
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





</div>

</body>
</html>