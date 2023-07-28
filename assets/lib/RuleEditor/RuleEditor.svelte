<script lang="ts">
	import Rule from "./Rule.svelte";
	import Condition from "./Condition.svelte";
	import { jsonAjax } from "../../utils/api";
	import { ParamValues } from "./rulestore";
	import { onMount } from "svelte";
	import SaveButton from "../elements/SaveButton.svelte";
	import GrayBox from "../elements/GrayBox.svelte";
  import type { RuleT } from "./ruleTypes";
	import ProtectMethod from "./ProtectMethod.svelte";

	let title = window.membergate.title != "Auto Draft" ? window.membergate.title : "";
	let ruleset = window.membergate.Rules.ruleList;
	let condition = window.membergate.Rules.ruleCondition;
	let protectMethod = window.membergate.Rules.protectMethod;

	$: ruleset, console.log(ruleset);
	function addRule(groupIndex: number, ruleIndex:number) {
		const rule:RuleT = {
			parameter: "post_type",
			operator: "is",
			value: "",
		};
		ruleset[groupIndex].splice(ruleIndex+1, 0, rule)
		ruleset = ruleset;
	}

	function removeRule(groupIndex:number, ruleIndex:number){
		ruleset[groupIndex].splice(ruleIndex, 1)
		if(ruleset[groupIndex].length == 0){
			ruleset.splice(groupIndex,1)
		}
		ruleset = ruleset
	}

	function addGroup() {
		ruleset.push([{ parameter: "post_type", operator: "is", value: "" }]);
		ruleset = ruleset;
	}

	async function save() {
		const res = await jsonAjax("rule_editor__save_rules", {
			rules: ruleset,
			condition,
			protectMethod,
			title,
			id: window.membergate.postId,
		});
		if (res.message != "ok") throw new Error("Couldnt Save Rules");
		if(res.redirect && res.redirect.length > 1 && window.location.href != res.redirect){
			window.location.href = res.redirect	
		}
	}
	onMount(() => {
		ParamValues.load("page");
	});
</script>

<div class="p-4 max-w-screen-xl mx-auto pt-10 flex flex-col gap-10">
	<header class="flex justify-between items-end gap-4 ">
		<div class="flex-1">
			<h1 class="text-slate-600 text-sm font-bold">Protect Rule</h1>
			<input
				type="text"
				name="rule-title"
				bind:value={title}
				placeholder="Your Rules Title"
				class="w-full max-w-xl text-2xl border-l-transparent border-b-[2px] placeholder-shown:bg-slate-100
				placeholder-shown:border-transparent placeholder-shown:rounded focus:rounded rounded-none border-t-transparent border-r-transparent shadow-none
				appearance-none border-b-slate-200 text-slate-600 p-2 placeholder:text-slate-400 font-bold"
			/>
		</div>
		<div>
			<SaveButton action={save}>Save</SaveButton>
		</div>
	</header>

	<GrayBox>
		<h2 class="text-slate-600 text-sm font-bold">Protect</h2>
		{#each ruleset as ruleGroup, groupIndex}
			<div class="rule-group bg-white border p-3 flex flex-col gap-3">
				{#each ruleGroup as rule, ruleIndex}
					<div class="flex gap-2 h-12">
						<Rule bind:rule />
						<div class="flex rounded border border-slate-300">
							<button class="font-semibold py-1 px-3 hover:bg-red-100 hover:text-red-800" on:click={() => addRule(groupIndex, ruleIndex)}>&plus;</button>
							<button class="font-semibold py-1 px-3 hover:bg-red-100 hover:text-red-800" on:click={() => removeRule(groupIndex, ruleIndex)}>&minus;</button>
						</div>
					</div>
				{/each}
			</div>
			<div>
				<button class="p-2 px-4 font-bold uppercase rounded hover:bg-slate-50 bg-white border" on:click={addGroup}>or</button>
			</div>
		{/each}
	</GrayBox>

	<GrayBox>
		<h2 class="text-slate-600 text-sm font-bold">When</h2>
		<div class="rule-group bg-white border p-3 flex flex-col gap-3"> 
			<div class="flex h-12">
				<Condition bind:condition />
			</div>
		</div>
	</GrayBox>

	<GrayBox>
		<h2 class="text-slate-600 text-sm font-bold">By</h2>
		<div class="rule-group bg-white border p-3 flex flex-col gap-3"> 
			<div class="flex h-12">
				<ProtectMethod bind:protectMethod />
			</div>
		</div>
	</GrayBox>

</div>


<!--
	<h1 class="font-bold tracking-wide">Edit Rule</h1>

	<div class="cookie-options">
		<h3>When User</h3>
		<select>
			<option value="0">does not have</option>
			<option value="1">does have</option>
		</select>
		cookie with name of:<input type="text" />
	</div>
	And
	<div class="rule-set">
		{#each ruleset as ruleGroup, groupIndex}
			<div class="rule-group">
				{#each ruleGroup as rule}
					<Rule bind:rule />
					<button on:click={() => addRule(groupIndex)}>AND</button>
				{/each}
			</div>
			<p>or</p>
		{/each}
		<button on:click={addGroup}>Add Rule Group</button>
	</div>

	<div class="redirect-options">
		<h3>Redirect them to:</h3>
		<select>
			{#if $ParamValues.page}
				{#each Object.entries($ParamValues["page"]) as [value, label]}
					<option {value}>{label}</option>
				{/each}
			{/if}
		</select>
	</div>
	<button on:click={save}>Save</button>
-->
