<script lang="ts">
	import { createEventDispatcher } from "svelte";
	const dispatch = createEventDispatcher();
	export let name = "";
	export let id = name ? name : "";
	export let label = "";
	export let value = "";
	export let options = {};
	export let defaultOption: undefined | string = undefined;
	export let useOptionGroups = false;
	export let debug=false

	$: value, dispatch("inputChange", { value });
	$:{
		if(debug){
			console.log("blocked",{value, options})
		}
	}
</script>

<label for={id} class="flex flex-col gap-3 w-full">
	<span class="text-md font-bold text-slate-700">{label}</span>
	<select
		class="min-w-[200px] w-full max-w-full bg-slate-50 py-2 px-3 font-medium text-cyan-900 border-slate-200 focus:border-cyan-400"
		{id}
		{name}
		bind:value
	>
		{#if defaultOption}
			<option selected={!value} value={''} >{defaultOption}</option>
		{/if}

		{#if useOptionGroups}
			{#each Object.keys(options) as optionGroupName}
				<optgroup label={optionGroupName}>
					{#each options[optionGroupName] as option}
						<option selected={option.id == value} value={option.id}>
							{option.name}
						</option>
					{/each}
				</optgroup>
			{/each}
		{:else}
			{#each Object.keys(options) as option}
				<option selected={Boolean(value && option.toString() == value.toString())} value={option}>
					{options[option]}
				</option>
			{/each}
		{/if}
	</select>
</label>
