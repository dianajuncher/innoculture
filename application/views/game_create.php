<div id="game-create" class="wrapper">

	<h1><?=lang("page_game_create")?></h1>	

	<form method="post" action="<?=game_create_url()?>">
		<div>
			<label><?=lang("choose_name")?></label>
			<input type="text" name="name" />
		<div>
			<label><?=lang("choose_company")?></label>
			<select name="company_id">
				<? foreach($companies as $company): ?>
					<option value="<?=$company->id?>"><?=$company->name?></option>
				<? endforeach; ?>
			</select>
		</div>
		<div>
			<label><?=lang("choose_groups")?></label>
			<input type="text" name="number_of_groups" value="5"/>
		</div>
		<div>
			<label><?=lang("choose_language")?></label>
			<select name="language">
				<option value="dk">DK</option>
				<option value="en">EN</option>
			</select>
		</div>
		<input type="submit" class="button" value="<?=lang("game_create")?>" />
	</form>

</div>
