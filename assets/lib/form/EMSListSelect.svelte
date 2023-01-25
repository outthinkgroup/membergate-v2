<script lang="ts">
	import LabelSelect from "./LabelSelect.svelte";
	import {updateList} from "../../utils/formUtils"
	import getLists from "../../api/getLists";
	import {apikey, selectedList, listsForSelectList, lists, provider} from "../../store"

	let isLoadng = false
	
	async function fetchAndSetLists(apikey:string, provider:string){
		const listData = await getLists()
		if (listData.errors.length) {
			console.log(listData.errors);
		}
		if (listData.data.lists && listData.data.lists.length) {
			lists.set(listData.data.lists);
		}
	}

	// Refectch options when dependency changes
	provider.subscribe( async function(provider){
		//dont when initially set
		if(provider === window.membergate.settings.emailService.providerName) return;

		window.membergate.settings.emailService.providerName = null //only needed for stopping running on initial set
		if(!provider.length) {
			lists.set([])
			return;
		}
		isLoadng = true
		await fetchAndSetLists($apikey, provider)
		isLoadng = false
	});
	apikey.subscribe( async function(apikey){
		//dont when initially set
		if(apikey === window.membergate.settings.emailService.apiKey) return;
		window.membergate.settings.emailService.apiKey = null //only needed for stopping running on initial set
		if(!apikey.length) {
			lists.set([])
			return;
		}
		isLoadng = true
		await fetchAndSetLists(apikey, $provider)
		isLoadng = false
		
	});

</script>

<LabelSelect
	name="lists"
	value={$selectedList}
	options={$listsForSelectList}
	defaultOption="select a list"
	on:inputChange={(e) => (updateList(e.detail.value))}
	label="choose a list"
/>
{#if isLoadng}
	loading...
{/if}

