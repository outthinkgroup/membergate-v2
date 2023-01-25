<script lang="ts">
	import { updateApiKey } from "../../utils/formUtils";
	import {apikey} from "../../store";
	import LabelInput from "./LabelInput.svelte";
	let inputError

	function validateAndSetApiKey(e:{detail:{value:string}}){
		const newKey = e.detail.value	
		if(!newKey.length){ 
			updateApiKey(newKey)
			return;
		}

		if(!newKey.includes("-")) {
			//TODO: api key validation for each provider
			inputError = "This doesnt seem like a valid mailchimp apikey"	
			return;
		}
		updateApiKey(newKey)
	}
</script>

<span>
	{#if inputError.length}
		<p class="text-red-500">{inputError}</p>	
	{/if}
	<LabelInput
		on:inputChange={validateAndSetApiKey}
		event="blur"
		value={$apikey}
		name="api-key"
		type="password"
		label="Your Api Key"
	/>
</span>



