<script lang="ts">
  import { createEventDispatcher } from "svelte";
  import { updateApiKey } from "../../utils/formUtils";
  import { apikey, provider } from "../../store";
  import LabelInput from "./LabelInput.svelte";
  import LoadingCircle from "../LoadingCircle.svelte";

  const dispatch = createEventDispatcher();

  let inputError: string;
  let isLoading = false;

  $: isLoading,
    dispatch("loadingStateChange", {
      isLoading,
    });
	// Resets apikey if provider changes	
	// THIS IS BUGGY
	// provider.subscribe((provider)=>{
	// 	if(window.membergate.settings.emailService.providerName == provider){
	// 		return
	// 	}
	// 	window.membergate.settings.emailService.providerName = null
	// 	apikey.save("")
	// })

  async function validateAndSetApiKey(e: { detail: { value: string } }) {
    const newKey = e.detail.value;
    if (!newKey.length) {
      updateApiKey(newKey);
      return;
    }

    // if (!newKey.includes("-")) {
    //   //TODO: api key validation for each provider
    //   inputError = "This doesnt seem like a valid mailchimp apikey";
    //   return;
    // }
    inputError = null;
    isLoading = true;
    await updateApiKey(newKey);
    isLoading = false;
  }
</script>

<span>
  <span class="relative">
    <LabelInput
      on:inputChange={validateAndSetApiKey}
      event="blur"
      value={$apikey}
      name="api-key"
      type="password"
      label="Your Api Key"
    />
    {#if isLoading}
      <span class="text-sm text-green-500 absolute right-[1em] top-[60%]">
        <LoadingCircle />
      </span>
    {/if}
  </span>
  <p class="text-red-500">
    {#if inputError}
      {inputError}
    {/if}
  </p>
</span>
