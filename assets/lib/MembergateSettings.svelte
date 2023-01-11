<script lang="ts">
	import saveSettings from "../api/saveSettings";

	import LabelInput from "./form/LabelInput.svelte";
	import LabelSelect from "./form/LabelSelect.svelte";
	import EmsListSelect from "./form/EMSListSelect.svelte";
	import EmsGroupSelect from "./form/EMSGroupSelect.svelte";

	import {apikey, selectedList, selectedGroup, provider, groupsForSelectList, listsForSelectList} from "../store";
    import { updateProvider } from "../utils/formUtils";

	let { providers } = window.membergate;

</script>

<h2 class="text-3xl mb-10">Your Settings</h2>
<form class="shadow bg-white p-6" on:submit|preventDefault={()=>saveSettings({providerName:$provider,
apiKey:$apikey,group:$selectedGroup, list:$selectedList })}>
	<div class="flex flex-col gap-3">
		<LabelSelect
			value={$provider}
			on:inputChange={(e) => (updateProvider( e.detail.value))}
			options={providers}
			label="Select a Email Marketing Service"
			name="providerName"
		/>
		<LabelInput
			on:inputChange={(e) => (apikey.set( e.detail.value))}
			value={$apikey}
			name="api-key"
			type="password"
			label="Your Api Key"
		/>
		<EmsListSelect/>
		<EmsGroupSelect/>
		<div>
			<button
				class="px-4 py-2 rounded bg-cyan-600 text-white font-medium tracking-wide"
			>
				Save
			</button>
		</div>
	</div>
</form>
