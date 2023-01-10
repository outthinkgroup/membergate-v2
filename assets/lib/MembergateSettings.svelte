<script lang="ts">
	import saveSettings from "../api/saveSettings";

	import LabelInput from "./form/LabelInput.svelte";
	import LabelSelect from "./form/LabelSelect.svelte";

	import {groupsForSelectList, listsForSelectList} from "../store";

	let { providers, settings } = window.membergate;
	let {
		apiKey,
		providerName,
		groupId: selectedGroup,
		listId: selectedList,
	} = settings;

</script>

<h2 class="text-3xl mb-10">Your Settings</h2>
<form class="shadow bg-white p-6" on:submit|preventDefault={()=>saveSettings({providerName, apiKey,group:selectedGroup, list:selectedList })}>
	<div class="flex flex-col gap-3">
		<LabelSelect
			value={providerName}
			on:inputChange={(e) => (providerName = e.detail.value)}
			options={providers}
			label="Select a Email Marketing Service"
			name="providerName"
		/>
		<LabelInput
			on:inputChange={(e) => (apiKey = e.detail.value)}
			value={apiKey}
			name="api-key"
			type="password"
			label="Your Api Key"
		/>
		<LabelSelect
			name="lists"
			value={selectedList}
			on:inputChange={(e) => (selectedList = e.detail.value)}
			options={$listsForSelectList}
			label="choose a list"
		/>
		<LabelSelect
			name="lists"
			on:inputChange={(e) => (selectedGroup = e.detail.value)}
			value={selectedGroup}
			options={$groupsForSelectList}
			label="choose a group"
			optionGroupKey="parentGroupName"
			optionLabelKey="name"
			defaultOption="select a group"

		/>
		<div>
			<button
				class="px-4 py-2 rounded bg-cyan-600 text-white font-medium tracking-wide"
			>
				Save
			</button>
		</div>
	</div>
</form>
