<script lang="ts">
	import Rule from "./Rule.svelte";
	import Condition from "./Condition.svelte";
	import { jsonAjax } from "../../utils/api";
	import SaveButton from "../elements/SaveButton.svelte";
	import GrayBox from "../elements/GrayBox.svelte";
	import type { RuleT } from "./ruleTypes";
	import ProtectMethod from "./ProtectMethod.svelte";
	import DevTool from "../DevTool/DevTool.svelte";

	let title =
		window.membergate.title != "Auto Draft" ? window.membergate.title : "";
	let ruleset = window.membergate.Rules.ruleList;
	let condition = window.membergate.Rules.ruleCondition;
	let protectMethod = window.membergate.Rules.protectMethod;
	let overlaySettings = window.membergate.Rules.overlaySettings;

	function addRule(groupIndex: number, ruleIndex: number) {
		const rule: RuleT = {
			parameter: "post_type",
			operator: "is",
			value: "",
		};
		ruleset[groupIndex].splice(ruleIndex + 1, 0, rule);
		ruleset = ruleset;
	}

	function removeRule(groupIndex: number, ruleIndex: number) {
		ruleset[groupIndex].splice(ruleIndex, 1);
		if (ruleset[groupIndex].length == 0) {
			ruleset.splice(groupIndex, 1);
		}
		ruleset = ruleset;
	}

	function addGroup() {
		ruleset.push([{ parameter: "post_type", operator: "is", value: "" }]);
		ruleset = ruleset;
	}

	async function save() {
		// TODO uncomment when we use the custom overlay editor
		//let blocks = window.membergate?.OverlayEditor?.blockObjects;

		const res = await jsonAjax("rule_editor__save_rules", {
			rules: ruleset,
			condition,
			title,
			protectMethod,
			overlaySettings, 
			//@ts-ignore
			// TODO uncomment when we use the custom overlay editor
			//overlayContent:blocks ? window.wp.blocks.serialize(blocks) : window.membergate.OverlayEditor.blocks,
			id: window.membergate.postId,
		});
		if (res.message != "ok") throw new Error("Couldnt Save Rules");
		if (
			res.redirect &&
			res.redirect.length > 1 &&
			window.location.href != res.redirect
		) {
			window.location.href = res.redirect;
		}
	}
</script>

<div class="p-4 max-w-screen-xl mx-auto pt-10 flex flex-col gap-10">
	<header class="flex justify-between items-end gap-4">
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
		<header>
			<h2 class="text-slate-600 text-sm font-bold">Protect</h2>
			<p class="text-slate-900 text-xs tracking-wide">Choose the which content will be <i>protected</i> by this rule.</p>
		</header>
		{#each ruleset as ruleGroup, groupIndex}
			<div class="rule-group bg-white border p-3 flex flex-col gap-3">
				{#each ruleGroup as rule, ruleIndex}
					<div class="flex gap-2 h-12">
						<Rule bind:rule />
						<div class="flex rounded border border-slate-300">
							<button
								class="font-semibold py-1 px-3 hover:bg-blue-100 hover:text-blue-800"
								title="add protect parameter"
								on:click={() => addRule(groupIndex, ruleIndex)}
							>
								&plus;
							</button>
							<button
								class="font-semibold py-1 px-3 hover:bg-red-100 hover:text-red-800"
								title="remove this protect parameter"
								on:click={() => removeRule(groupIndex, ruleIndex)}
							>
								&minus;
							</button>
						</div>
					</div>
				{/each}
			</div>
			<div>
				<button
					class="p-2 px-4 font-bold uppercase rounded hover:bg-slate-50 bg-white border"
					on:click={addGroup}>or</button
				>
			</div>
		{/each}
	</GrayBox>

	<GrayBox>
		<header>
			<h2 class="text-slate-500 text-sm font-bold mb-1">When</h2>
			<p class="text-slate-900 text-xs tracking-wide">Select the condition <i>when</i> the content is protected.</p>
		</header>
		<div class="rule-group bg-white border p-3 flex flex-col gap-3">
			<div class="flex h-12">
				<Condition bind:condition />
			</div>
		</div>
	</GrayBox>

	<GrayBox>
		<header>
			<h2 class="text-slate-500 text-sm font-bold mb-1">By</h2>
			<p class="text-slate-900 text-xs tracking-wide">Choose the method the content is protected <i>by</i>.</p>
		</header>
		<div class="rule-group bg-white border p-3 flex flex-col gap-3">
			<div class="flex h-12">
				<ProtectMethod bind:protectMethod />
			</div>
		</div>
	</GrayBox>
</div>

{#if import.meta.env.DEV}
	<DevTool {ruleset} {condition} {protectMethod} />
{/if}
