<script lang="ts">
	import getLists from "../api/getLists";
	import getGroups from "../api/getGroups";
	import saveSettings from "../api/saveSettings";
	import {
		completedSetup,
		groups,
		groupsForSelectList,
		lists,
		listsForSelectList,
		apikey,
		provider,
		selectedGroup,
		selectedList,
	} from "../store";
	import LabelInput from "./form/LabelInput.svelte";
	import LabelSelect from "./form/LabelSelect.svelte";
	import EmsListSelect from "./form/EMSListSelect.svelte";
	import EmsGroupSelect from "./form/EMSGroupSelect.svelte";
	import { updateApiKey, updateList, updateProvider } from "../utils/formUtils";

	let currentStep = 1;
	//Step one
	const providersList = window.membergate.providers;
	//step two

	async function completeStepOne() {
		const res = await getLists($apikey, $provider);
		console.log("running completeStepOne");
		if (res.errors.length) {
			console.log(res.errors);
		}
		if (res.data.lists && res.data.lists.length) {
			lists.set(res.data.lists);
			currentStep = 2;
		}
	}

	async function completeStepTwo() {
		const res = await getGroups(selectedList);
		if (res.errors.length) {
			console.log(res.errors);
		}

		if (res.data && res.data.length) {
			console.log({ groupsBefore: res.data });
			groups.set(res.data);
		}

		currentStep = 3;
	}

	async function completeSetup() {
		const res = await saveSettings({
			apiKey: $apikey,
			providerName: $provider,
			list: $selectedList,
			group: $selectedGroup,
		});

		if (res.errors.length) {
			console.log({ errors: res.errors });
			return;
		}

		completedSetup.set(true);
	}
</script>

<h2 class="text-3xl">Setup integrations</h2>
<div class="py-14">
	<h3 class="text-center text-xl text-cyan-600 font-bold">Get Started</h3>
	{#if currentStep == 1}
		<h4 class="text-center text-2xl mb-4">
			Setup your Email Marketing Service
		</h4>
		<form
			class="shadow bg-white p-6"
			on:submit|preventDefault={completeStepOne}
		>
			<div class="flex flex-col gap-3">
				<LabelSelect
					value={$provider}
					on:inputChange={(e) => updateProvider(e.detail.value)}
					options={providersList}
					label="Select a Email Marketing Service"
					name="providerName"
				/>
				<LabelInput
					on:inputChange={(e) => updateApiKey(e.detail.value)}
					event="blur"
					value={$apikey}
					name="api-key"
					type="password"
					label="Your Api Key"
				/>
				<div>
					<button
						class="px-4 py-2 rounded bg-cyan-600 text-white font-medium tracking-wide"
						type="submit"
					>
						Next Step
					</button>
				</div>
			</div>
		</form>
	{/if}

	{#if currentStep == 2}
		<h4 class="text-center text-2xl mb-4">
			Setup the list users will be added to
		</h4>
		<form
			class="shadow bg-white p-6"
			on:submit|preventDefault={completeStepTwo}
		>
			<div class="flex flex-col gap-3">
				<EmsListSelect />
				<div>
					<button
						class="px-4 py-2 rounded bg-cyan-600 text-white font-medium tracking-wide"
					>
						Next Step
					</button>
				</div>
			</div>
		</form>
	{/if}
	{#if currentStep == 3}
		<h4 class="text-center text-2xl mb-4">
			Setup the group users will be added to
		</h4>
		<form class="shadow bg-white p-6" on:submit|preventDefault={completeSetup}>
			<div class="flex flex-col gap-3">
				<EmsGroupSelect/>
				<div>
					<button
						class="px-4 py-2 rounded bg-cyan-600 text-white font-medium tracking-wide"
					>
						Finish
					</button>
				</div>
			</div>
		</form>
	{/if}
</div>
