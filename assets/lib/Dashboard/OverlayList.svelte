<script lang="ts">
	import List from "./List.svelte";
	import ListItem from "./ListItem.svelte";
	import type { ListItemT } from "./types";
	export let overlays: ListItemT[] = [];


	//DELETE Button
	const _deleteEntity = window.wp.data.dispatch( 'core' ).deleteEntityRecord
	let is_deleting = null;
	async function DeleteEntity(postType:string, id:number){
		is_deleting = id;
		const promise = await _deleteEntity( 'postType', postType, id );
		is_deleting = null;
		overlays = overlays.filter(overlay=>overlay.ID != id)
	}

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
					<a
						href={overlay.link}
						class="text-cyan-600 hover:text-cyan-900 hover:underline"
					>
						Edit
					</a>
					<button class="text-red-600 hover:text-red-900 hover:underline" on:click={()=>DeleteEntity("membergate_overlay", overlay.ID)}>
						Delet{is_deleting===overlay.ID  ? "ing" : "e"}
					</button>
				</div>
			</ListItem>
		{/each}
	</List>
</div>
