<script lang="ts">
	import { currentLocation } from "../../locationStore";
	import { postTypes } from "../../store";
	import FormHeader from "../elements/FormHeader.svelte";
	import  Label  from "../elements/label/Label.svelte";
	import Checkbox from "../elements/checkbox/Checkbox.svelte";
    import Button from "../elements/button/Button.svelte";
	let isLoading = false;

	type Checkbox = Event & {
		currentTarget: EventTarget & HTMLInputElement;
		target: EventTarget & HTMLInputElement & { checked: boolean };
	};

	async function updatePostType(e: Event) {
		const event = e as Checkbox;
		isLoading = true;
		await postTypes.save(ptype, event.target.checked ? "true" : "false");
		isLoading = false;
	}
</script>

{#if $currentLocation == "protected-posttype-settings"}
	<div class="shadow bg-white p-6">
		<FormHeader {isLoading}>Protected Content Settings</FormHeader>
		<p class="mb-4">Choose which post types by default will be protected</p>
		<form 
			on:submit|preventDefault={(e) => updatePostType(e)}
			class="flex flex-col gap-2 mb-3">
			{#each Object.keys($postTypes) as ptype}
				<div class="items-top flex space-x-2">
					<Checkbox
						id={ptype}
						type="checkbox"
						checked={$postTypes[ptype].protected == "true"}
						class="data-[state=checked]:bg-cyan-500 data-[state=checked]:border-cyan-500"
					/>
					<div class="grid gap-1.5 leading-none">
						<Label
							for={ptype}
							class="text-sm font-bold leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
						>
							{$postTypes[ptype].name}
						</Label>
					</div>
				</div>
			{/each}
			<div class="py-3"><Button class="w-min" variant="default">Save</Button></div>
		</form>
		<div>
			<p class="text-cyan-800">
				These settings save automatically when they are changed
			</p>
		</div>
	</div>
{/if}
