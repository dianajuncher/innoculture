<div id="timer" class="wrapper">
	<div class="choose-time">
		<div class="selected-time" data-minutes="0">Vælg</div>
		<div class="drop-down-arrow down"><img src="<?=base_url()?>public/images/icon_arrow.png"/></div>	
		<div class="drop-down-arrow up"><img src="<?=base_url()?>public/images/icon_arrow_up.png"/></div>			
		<div class="time-drop-down">
			<div data-minutes="3">3 minutter</div>
			<div data-minutes="5">5 minutter</div>
			<div data-minutes="7">7 minutter</div>
			<div data-minutes="10">10 minutter</div>
			<div data-minutes="15">15 minutter</div>
			<div data-minutes="20">20 minutter</div>
			<div data-minutes="25">25 minutter</div>
			<div data-minutes="30">30 minutter</div>
		</div>
	</div>
	
	<div class="hour-glass">
		<img id="hour-glass-img" src="<?=base_url()?>public/images/hourglass.png"/>
	</div>
	
	<div class="time-bar">
		<div class="time-left"></div>
		<div class="time-progress"></div>
	</div>
</div>