<script lang="ts">
	import List from "./List.svelte";
	import ListItem from "./ListItem.svelte";
	import type { ListItemT } from "./types";
	export let overlays: ListItemT[] = [];
</script>

<div>
	<List>
		{#if overlays.length == 0}
			<div class="p-5 text-slate-400 font-medium bg-slate-200 text-center rounded-lg text-lg">
				No overlays created yet.
			</div>
		{/if}
		{#each overlays as overlay}
			<ListItem>
				<div>
					<a class="font-medium capitalize text-sm hover:text-cyan-600 hover:underline hover:cursor-pointer"
					href="{overlay.link}">{overlay.title}</a> 
				</div>
				<div class="flex gap-2">
					<a href="{overlay.link}">Edit</a>
				</div>
			</ListItem>
		{/each}
	</List>
</div>
