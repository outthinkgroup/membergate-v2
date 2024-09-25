<script lang="ts">
	import { jsonAjax } from "../../utils/api";
	let canShow = true;
	export let showActions = false;

	function dissmiss() {
		jsonAjax("dissmiss_help", { dissmiss: true });
		canShow = false;
	}
	let isExpanded = false;
</script>

{#if canShow}
	{#if isExpanded}
		<div
			class="my-10 p-3 pt-3 pr-8 bg-white border border-l-[8px] rounded-lg border-cyan-700 relative"
		>
			<header class="flex justify-between mb-4 relative">
				<h2 class="flex-1 text-cyan-900 font-bold text-3xl">
					How to use Membergate
				</h2>
				{#if showActions}
					<div class="flex gap-2 ">
						<button
							on:click={dissmiss}
							class="rounded-full w-4 h-4 text-xs hover:bg-red-600 bg-red-200 text-white absolute top-[0px]
							right-[-20px] font-bold flex justify-center items-center"
							title="Dissmiss"
						>
							x
						</button>
					</div>
				{/if}
			</header>
			<div>
				<div>
					<ol class=" flex flex-col gap-4">
						<li>
							<h3 class="text-xl font-bold text-cyan-700 mb-2">Create Rules</h3>
							<h4 class="text-lg text-cyan-900 mb-1">
								Define What Content is Protected
							</h4>
							<p class="mb-3 text-base">
								Set conditions for which content should be protected. You can
								select entire post-types or have fine grain control and select
								which content is protected based on multiple conditions like
								taxonomy and page template.
							</p>
							<h4 class="text-lg text-cyan-900 mb-1">
								Select when your content needs to be protected
							</h4>
							<p class="text-base mb-3">
								Choose to trigger the rule if the user doesnt have a specific
								cookie set, or maybe if a url parameter is not set.
							</p>
							<h4 class="text-lg text-cyan-900 mb-1">
								Define how should your content be protected
							</h4>
							<p class="text-base">
								You can protect your content by redirecting to a specific page,
								or you can select 'overlay' and build a custom overlay to
								obfuscate the content but allow google to index the content.
							</p>
						</li>
						<li>
							<h3 class="text-xl font-bold text-cyan-700 mb-2">
								Build Overlays
							</h3>
							<p class="text-base">
								Create overlays to protect the content let your users know how
								they can get access to you premium content. This works
								exceptionally well with the Membergate Gravityforms addon
							</p>
						</li>
						<li>
							<h3 class="text-xl font-bold text-cyan-700 mb-2">
								<em>(Optionally)</em> Set up Gravityforms Addon For Membergate
							</h3>
							<p class="text-base">
								This allows you to set the cookie for the specific rule that
								triggered the form, so that after your user subscribes to your
								email newsletter they can get access to the content immediatly
							</p>
						</li>
					</ol>
				</div>
			</div>
		</div>
	{:else}
		<div
			class="my-10 p-3 pt-3 pr-8 bg-white border border-l-[8px] rounded-lg flex justify-between items-center border-cyan-700 relative"
		>
			{#if showActions}
					<button
						on:click={dissmiss}
						class="rounded-full w-4 h-4 text-xs hover:bg-red-600 bg-red-200 text-white absolute top-2 right-2 font-bold flex justify-center items-center"
						title="Dissmiss"
					>
						&times;
					</button>
			{/if}
			<h2 class="text-sm font-semibold ">Need Help With Membergate?</h2>
			<button
				class="text-xs bg-cyan-700 p-2 rounded-sm hover:bg-cyan-800 font-medium text-white"
				on:click={() => (isExpanded = true)}
			>
				Learn how it works
			</button>
		</div>
	{/if}
{/if}

<style>
</style>
