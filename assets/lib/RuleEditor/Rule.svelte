<script lang="ts">
	import type { FormEventHandler } from "svelte/elements";
	import type { RuleT } from "./ruleTypes";
	import { operators, parameterOptions } from "./ruleTypes";
	import { ParamValues } from "./rulestore";
	import { onMount } from "svelte";

	export let rule: RuleT;

	let isLoadingParamValues: boolean = false;

	const fetchParamOptions: FormEventHandler<HTMLSelectElement> =
		async function fetchParamOptions(e) {
			// @ts-ignore
			const value = e.target.value;
			console.log({ value });
			isLoadingParamValues = true;
			const res = await ParamValues.load(value);
			isLoadingParamValues = false;
		};
	onMount(() => {
		ParamValues.load(rule.parameter);
		console.log(rule.parameter);
	});
</script>

<div class="flex gap-2 flex-1 w-full">
	<select
		on:change={fetchParamOptions}
		bind:value={rule.parameter}
		class="w-full max-w-[25%] border border-slate-300"
	>
		{#each Object.entries(parameterOptions) as [value, label]}
			<option {value}>{label}</option>
		{/each}
	</select>
	<select
		bind:value={rule.operator}
		class="w-full max-w-[25%] border border-slate-300"
	>
		{#each Object.entries(operators) as [value, label]}
			<option {value}>{label}</option>
		{/each}
	</select>

	{#if !isLoadingParamValues && $ParamValues[rule.parameter] instanceof Object}
		<select
			bind:value={rule.value}
			class="w-full max-w-full flex-1 border border-slate-300"
		>
			{#if rule.parameter == "taxonomy"}
				{#each Object.entries($ParamValues[rule.parameter]) as [taxSlug, tax]}
					<optgroup label={tax.label}>
						{#each Object.entries(tax.terms) as [term_id, term_label]}
							<option value={taxSlug + "::" + term_id}>
								{term_label}
							</option>
						{/each}
					</optgroup>
				{/each}
			{:else}
				{#each Object.entries($ParamValues[rule.parameter]) as [value, label]}
					<option {value}>{label}</option>
				{/each}
			{/if}
		</select>
	{/if}
</div>
