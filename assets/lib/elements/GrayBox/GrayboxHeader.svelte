<header>
	<div class="flex justify-between items-center mb-2">
		<h2 class="text-slate-500 text-lg font-bold mb-1">
			<slot name="header" />
		</h2>
		<slot name="action"/>	
	</div>
	<p class="text-slate-900 text-xs tracking-wide">
		<slot name="description"/>
	</p>
</header>
