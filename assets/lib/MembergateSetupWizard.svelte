<script lang="ts">
	import getLists from "../api/getLists";
	import getGroups from "../api/getGroups";
	import saveSettings from "../api/saveSettings";
	import LabelInput from "./form/LabelInput.svelte";
	import LabelSelect from "./form/LabelSelect.svelte";

	let currentStep = 1;
	//Step one
	const providersList = window.membergate.providers;
	let apiKey = window.membergate.settings.apiKey;
	let providerName = window.membergate.settings.providerName;
	//step two
	let lists: Record<string, string>;
	let selectedList = window.membergate.settings.list;
	//step 3
	let groups = {};
	let selectedGroup = window.membergate.settings.group;

	async function completeStepOne() {
		const res = await getLists(apiKey, providerName);
		console.log("running completeStepOne");
		if (res.errors.length) {
			console.log(res.errors);
		}
		if (res.data.lists && res.data.lists.length) {
			lists = res.data.lists?.reduce(
				(lists: Record<string, string>, list: Record<string, any>) => {
					lists[list.id] = list.name;
					return lists;
				},
				{}
			);
			currentStep = 2;
		}
	}

	async function completeStepTwo() {
		const res = await getGroups(selectedList);
		if (res.errors.length) {
			console.log(res.errors);
		}

		if (res.data && res.data.length) {
		console.log({groupsBefore:res.data})
			groups = res.data?.reduce((groups,group)=>{
				groups[group.id] = group
				return groups	
			},{});
		}

		currentStep = 3;
	}

	async function completeSetup() {
		const res = await saveSettings({
			apiKey,
			providerName,
			list: selectedList,
			group: selectedGroup,
		});
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
					value={providerName}
					on:inputChange={(e) => (providerName = e.detail.value)}
					options={providersList}
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
				<LabelSelect
					name="lists"
					value={selectedList}
					options={lists}
					defaultOption="select a list"
					on:inputChange={(e) => (selectedList = e.detail.value)}
					label="choose a list"
				/>
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
				<LabelSelect
					name="groups"
					value={selectedGroup}
					on:inputChange={(e) => (selectedGroup = e.detail.value)}
					options={groups}
					optionGroupKey="parentGroupName"
					optionLabelKey="name"
					defaultOption="select a group"
					label="choose a group"
				/>
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
