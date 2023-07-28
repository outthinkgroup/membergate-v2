<script lang="ts">
	import type { ConditionRuleT } from "./ruleTypes";
	import { conditionOperatorOptions, conditionParamOptions } from "./ruleTypes";
	export let condition: ConditionRuleT;
</script>

<div class="flex gap-2 flex-1 w-full ">
	<select
		bind:value={condition.parameter}
		class="w-full max-w-[25%] border border-slate-300"
	>
		{#each Object.entries(conditionParamOptions) as [value, label]}
			<option {value}>{label}</option>
		{/each}
	</select>

	<input bind:value={condition.key} class="w-full flex-1  border border-slate-300 px-2"
	placeholder="{conditionParamOptions[condition.parameter]} Name" />

	<select
		class="w-full max-w-[25%] border border-slate-300"
		bind:value={condition.operator}
	>
	{#each Object.entries(conditionOperatorOptions) as [value, label]}
		<option value={value}>{label}</option>
	{/each}
	</select>

	{#if condition.operator == "notequal"}
		<input 
		bind:value={condition.value} 
		class="w-full flex-1  border border-slate-300 px-2" 
		placeholder="{conditionParamOptions[condition.parameter]} Value" />
	{/if}

</div>
