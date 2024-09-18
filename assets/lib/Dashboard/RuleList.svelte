<script lang="ts">
	import List from "./List.svelte";
	import ListItem from "./ListItem.svelte";
	import type { ListItemT } from "./types";
	type RuleMeta = {
		methodType: string;
		protectType:string;
	};
	export let rules: (ListItemT & RuleMeta)[] = [];
</script>

<div>
	<List>
		{#if rules.length == 0}
			<div class="p-5 text-slate-400 font-medium bg-slate-200 text-center rounded-lg text-lg">
				No rules created yet.
			</div>
		{/if}
		{#each rules as rule}
			<ListItem>
				<div class="flex gap-3 items-center">
					<a class="font-medium capitalize text-sm hover:text-cyan-600 hover:underline hover:cursor-pointer flex-1" href="{rule.link}">{rule.title}</a> 
					<p class="flex-1">{rule?.protectType ?? ""}</p>
					<p>{rule?.methodType ?? ""}</p>

				</div>
				<div class="flex gap-2">
					<a href="{rule.link}">Edit</a>
				</div>
			</ListItem>
		{/each}
	</List>
</div>
