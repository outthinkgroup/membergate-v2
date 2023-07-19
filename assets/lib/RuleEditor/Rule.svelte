<script lang="ts">
	import type { FormEventHandler } from "svelte/elements";
	import type { Rule } from "./ruleTypes";
	import { operators, parameterOptions } from "./rulegroupOptions";
	import {ParamValues} from "./rulestore"

	export let rule: Rule;

	let isLoadingParamValues:boolean = false

	const fetchParamOptions: FormEventHandler<HTMLSelectElement> =
		async function fetchParamOptions(e) {
			// @ts-ignore
			const value = e.target.value;
			isLoadingParamValues = true
			const res = await ParamValues.load(value)
			isLoadingParamValues = false
			console.log(res)
		};
	
</script>

<div>
	<select on:change={fetchParamOptions} bind:value={rule.parameter}>
		{#each Object.entries(parameterOptions) as [value, label]}
			<option {value}>{label}</option>
		{/each}
	</select>
	<select bind:value={rule.operator}>
		{#each Object.entries(operators) as [value, label]}
			<option {value}>{label}</option>
		{/each}
	</select>

	<select>
		{#if !isLoadingParamValues && ($ParamValues[rule.parameter] instanceof Object)}
			{#each Object.entries($ParamValues[rule.parameter]) as [value, label] }
				<option {value}>{label}</option>
			{/each}
		{/if}
	</select>
</div>
