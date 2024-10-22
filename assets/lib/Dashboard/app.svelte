<script lang="ts">
	import { GrayBox, GrayBoxHeader } from "../elements/GrayBox";
	import OverlayList from "./OverlayList.svelte";
	import RuleList from "./RuleList.svelte";
	import HelpInfo from "./HelpInfo.svelte";
    import { jsonAjax } from "../../utils/api";

	export let urls;
	export let rules;
	export let overlays;
	export let showHelp: boolean;
	export let license:string;

	let isSavingLicense = false;
	async function saveKey(e:SubmitEvent){
		e.preventDefault();
		const data = new FormData(e.currentTarget as HTMLFormElement)
		const key = data.get("license_key").toString();
		isSavingLicense = true
		await jsonAjax("save_license_key", {key})
		isSavingLicense = false;
	}
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
		<GrayBox>
			<GrayBoxHeader>
				<span slot="header">License</span>
				<div slot="action"></div>
				<span slot="description">
					Add your License key to get updates to the plugin.
				</span>
			</GrayBoxHeader>
			<div>
				<form on:submit={saveKey}>
					<input type="password" name="license_key" value={license} id="license_key" />
					<button
						class="text-blue-600 hover:text-blue-900 rounded-md bg-slate-100 hover:bg-slate-200 border border-blue-600
						hover:border-blue-900">Sav{isSavingLicense ? "ing" : "e"}</button>
				</form>
			</div>
		</GrayBox>
	</div>
</main>
