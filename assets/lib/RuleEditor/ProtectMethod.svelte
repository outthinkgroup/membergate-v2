<script lang="ts">
	import { onMount } from "svelte";
	import type { ProtectMethodT } from "./ruleTypes";
	import { protectMethodOptions } from "./ruleTypes";
	import { ParamValues } from "./rulestore";
	export let protectMethod: ProtectMethodT;
	onMount(() => {
		ParamValues.load("page");
	});
	const overlays = window.membergate.OverlayEditor.overlays
</script>

<div class="flex gap-2 flex-1 w-full">
	<select
		bind:value={protectMethod.method}
		class="w-full max-w-[25%] border border-slate-300"
	>
		{#each Object.entries(protectMethodOptions) as [value, label]}
			<option {value}>{label}</option>
		{/each}
	</select>

	{#if $ParamValues.page && protectMethod.method == "redirect"}
		<select
			class="w-full max-w-full flex-1 border border-slate-300"
			bind:value={protectMethod.value}
		>
			{#each Object.entries($ParamValues.page) as [value, label]}
				<option {value}>{label}</option>
			{/each}
		</select>
	{/if}
	{#if overlays.length && protectMethod.method == "overlay"}
		<select
			class="w-full max-w-full flex-1 border border-slate-300"
			bind:value={protectMethod.value}
		>
			{#each overlays as overlay}
				<option value={overlay.id}>{overlay.title}</option>
			{/each}
		</select>
	{/if}
</div>
