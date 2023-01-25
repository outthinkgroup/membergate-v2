<script lang="ts">
	import saveSettings from "../../api/saveSettings";
	import { currentLocation } from "../../locationStore";
	import LabelInput from "../form/LabelInput.svelte";
	import LabelSelect from "../form/LabelSelect.svelte";
	import EmsListSelect from "../form/EMSListSelect.svelte";
	import EmsGroupSelect from "../form/EMSGroupSelect.svelte";

	import {
		apikey,
		selectedList,
		selectedGroup,
		provider,
	} from "../../store";
	import { updateApiKey, updateProvider } from "../../utils/formUtils";
    import ApiKeyInput from "../form/ApiKeyInput.svelte";

	let { providers } = window.membergate;
</script>

{#if $currentLocation == "email-service-settings"}
<div class="shadow bg-white p-6" >
	<h3 class="text-xl font-medium text-cyan-600 mb-6">Email Service Settings</h3>
	<form
		on:submit|preventDefault={() =>
			saveSettings({
				providerName: $provider,
				apikey: $apikey,
				group_id: $selectedGroup,
				list_id: $selectedList,
			})}
	>
		<div class="flex flex-col gap-3">
			<LabelSelect
				value={$provider}
				on:inputChange={(e) => updateProvider(e.detail.value)}
				options={providers}
				label="Select a Email Marketing Service"
				name="providerName"
			/>
			<ApiKeyInput />
			<EmsListSelect />
			<EmsGroupSelect />
			<div>
				<button
					class="px-4 py-2 rounded bg-cyan-600 text-white font-medium tracking-wide"
				>
					Save
				</button>
			</div>
		</div>
	</form>
</div>
{/if}
