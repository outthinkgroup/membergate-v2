<script lang="ts">
	import LabelSelect from "./LabelSelect.svelte";
	import { updateGroup } from "../../utils/formUtils";
	import getGroups from "../../api/getGroups";
	import {
		apikey,
		selectedGroup,
		listsForSelectList,
		groupsForSelectList,
		groups,
		selectedList,
		provider,
	} from "../../store";

	let isLoadng = false;

	async function fetchAndSetGroups(listId:string) {
		const res = await getGroups(listId);
		if (res.errors.length) {
			console.log(res.errors);
			return;
		}

		if (res.data && res.data.length) {
		console.log({data:res.data})
			groups.set(res.data);
		}
	}

	// Refectch options when dependency changes
	provider.subscribe(async function (provider) {
		//dont when initially set
		if (provider === window.membergate.settings.emailService.providerName) return;
		window.membergate.settings.emailService.providerName = null //only needed for stopping running on initial set
		if (!provider.length || !$listsForSelectList.length) {
			groups.set([]);
			return
		}
		if($selectedList.length){
			isLoadng = true;
			await fetchAndSetGroups($selectedList);
			isLoadng = false;
		}
	});
	apikey.subscribe(async function (apikey) {
		//dont when initially set
		if (apikey === window.membergate.settings.emailService.apiKey) return;
		window.membergate.settings.emailService.apiKey = null //only needed for stopping running on initial set
		if (!apikey.length ) {
			groups.set([]);
			return;
		}
		isLoadng = true;
		await fetchAndSetGroups($selectedList);
		isLoadng = false;
	});
	selectedList.subscribe(async function (selectedList) {
		//dont when initially set
		if (selectedList === window.membergate.settings.emailService.listId){
			return;
		} 
		window.membergate.settings.emailService.listId = null //only needed for stopping running on initial set
		if (!selectedList.length ) {
			groups.set([]);
			return;
		}
		isLoadng = true;
		await fetchAndSetGroups(selectedList);
		isLoadng = false;
	});
</script>

<LabelSelect
	name="groups"
	value={$selectedGroup}
	on:inputChange={(e) => updateGroup(e.detail.value)}
	options={$groupsForSelectList}
	useOptionGroups={true}
	defaultOption="select a group"
	label="choose a group"
/>

{#if isLoadng}
	loading...
{/if}
