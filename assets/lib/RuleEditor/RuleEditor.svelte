<script lang="ts">
	import _ruleset from "./ruleset.json";
	import type {RuleSet} from "./ruleTypes"
	import Rule from "./Rule.svelte"

	let ruleset = _ruleset as RuleSet

	function addRule(groupIndex:number){
		ruleset[groupIndex].push({parameter:'post_type',operator:'is', value:""})
		ruleset=ruleset
	}
	function addGroup(){
		ruleset.push([{parameter:'post_type',operator:'is', value:""}])
		ruleset = ruleset
	}
</script>

<div class="p-4">
	<h1 class="font-bold tracking-wide">Edit Rule</h1>

	<div class="rule-set">
		{#each ruleset as ruleGroup, groupIndex}
			<div class="rule-group">
				{#each ruleGroup as rule}
					<Rule bind:rule />	
					<button on:click={()=>addRule(groupIndex)}>AND</button>
				{/each}
			</div>
			<p>or</p>
		{/each}
		<button on:click={addGroup}>Add Rule Group</button>
	</div>
</div>
