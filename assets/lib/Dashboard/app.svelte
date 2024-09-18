<script lang="ts">
	import GrayBox from "../elements/GrayBox.svelte";
	import OverlayList from "./OverlayList.svelte";
	import RuleList from "./RuleList.svelte";
	export let urls;
	export let rules;
	export let overlays;
</script>

<main class="py-10 flex flex-col gap-4 sm:flex-row">
	<GrayBox>
		<header>
			<div class="flex justify-between items-center mb-2">
				<h2 class="text-slate-500 text-lg font-bold mb-1">Rules</h2>
				<a
					class="bg-slate-300 text-slate-700 py-1.5 px-3 rounded font-bold hover:bg-slate-400"
					href={urls.newRule}>New Rule</a
				>
			</div>
			<p class="text-slate-900 text-xs tracking-wide">
				Create rules to protect your content define how and how to unlock the
				content.
			</p>
		</header>
		<RuleList {rules} />
	</GrayBox>
	<GrayBox>
		<header>
			<div class="flex justify-between items-center mb-2">
				<h2 class="text-slate-500 text-lg font-bold mb-1">Overlays</h2>
				<a
					class="bg-slate-300 text-slate-700 py-1.5 px-3 rounded font-bold hover:bg-slate-400"
					href={urls.newOverlay}>New Overlay</a
				>
			</div>
			<p class="text-slate-900 text-xs tracking-wide">
				Design and build unique modals that overlay your content and provide a
				way to unlock the protected content.
			</p>
		</header>
		<OverlayList {overlays} />
	</GrayBox>
</main>
