<script lang="ts">
	import { GrayBox, GrayBoxHeader } from "../elements/GrayBox";
	import OverlayList from "./OverlayList.svelte";
	import RuleList from "./RuleList.svelte";
	import HelpInfo from "./HelpInfo.svelte";

	export let urls;
	export let rules;
	export let overlays;
	export let showHelp: boolean;
</script>

<main class="">
	{#if showHelp}
		<HelpInfo showActions={true} />
	{/if}

	<div class="py-10 flex flex-col gap-4 sm:flex-row">
		<GrayBox>
			<GrayBoxHeader>
				<span slot="header">Rules</span>
				<div slot="action">
					<a
						class="bg-slate-300 text-slate-700 py-1.5 px-3 rounded font-bold hover:bg-slate-400"
						href={urls.newRule}
					>
						New Rule
					</a>
				</div>
				<span slot="description">
					Create rules to protect your content define how and how to unlock the
					content.
				</span>
			</GrayBoxHeader>
			<RuleList {rules} />
		</GrayBox>
		<GrayBox>
			<GrayBoxHeader>
				<span slot="header">Overlays</span>
				<div slot="action">
					<a
						class="bg-slate-300 text-slate-700 py-1.5 px-3 rounded font-bold hover:bg-slate-400"
						href={urls.newOverlay}
					>
						New Overlay
					</a>
				</div>
				<span slot="description">
					Design and build unique modals that overlay your content and provide a
					way to unlock the protected content.
				</span>
			</GrayBoxHeader>
			<OverlayList {overlays} />
		</GrayBox>
	</div>
</main>
