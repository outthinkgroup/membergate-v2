<script lang="ts">
	import { createEventDispatcher } from "svelte";
	import { selectValue } from "../../utils/formUtils";
	const dispatch = createEventDispatcher();
	export let name = "";
	export let id = name ? name : "";
	export let label = "";
	export let value = "";
	export let options = {};
	export let defaultOption: undefined | string = undefined;
	export let optionGroupKey: undefined | string = undefined;
	export let optionLabelKey: undefined | string = undefined;

	let useOptionGroups = false;
	
	if ( optionGroupKey && optionLabelKey ) {
		useOptionGroups = true;
		console.log({optionsbefore:options})
		options = Object.keys(options).reduce((optionGroups, key) => {
			const option = options[key];
			if (!Object.hasOwn(optionGroups, option[optionGroupKey])) {
				optionGroups[option[optionGroupKey]] = [];
			}
			optionGroups[option[optionGroupKey]][key] = option[optionLabelKey]

			return optionGroups;
		}, {});
		
		console.log({optionsAfter:options})
}

	
	$: value, dispatch("inputChange", { value });
</script>

<label for={id} class="flex flex-col gap-3">
	<span class="text-md font-bold text-slate-700">{label}</span>
	<select
		class="min-w-[200px] w-full max-w-full bg-slate-50 py-2 px-3 font-medium text-cyan-900 border-slate-200 focus:border-cyan-400"
		{id}
		{name}
		bind:value={value}
	>
		{#if defaultOption}
			<option value="" selected={!value}>{defaultOption}</option>
		{/if}

		{#if useOptionGroups}
			{#each Object.keys(options) as optionGroupName}
				<optgroup label={optionGroupName}>
					{#each Object.keys(options[optionGroupName]) as optionId}
						<option selected={optionId == value} value={optionId}
							>{options[optionGroupName][optionId]}
						</option>
					{/each}
				</optgroup>
			{/each}
		{:else}
			{#each Object.keys(options) as option}
				<option selected={option == value} value={option}
					>{options[option]}</option
				>
			{/each}
		{/if}
	</select>
</label>
