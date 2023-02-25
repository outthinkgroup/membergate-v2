<script lang="ts">
  import { currentLocation } from "../../locationStore";
  import { formSettings } from "../../store";
  import FormHeader from "../form/FormHeader.svelte";
  import FormCard from "./FormCard.svelte";

  let isLoading = false;
  let unSavedChanges = false;
</script>

{#if $currentLocation == "form-settings"}
  <div class="shadow bg-white p-6">
    <FormHeader {isLoading} {unSavedChanges}>Login and Register Settings</FormHeader>
  <div class="mb-4">
    <h3 class="mb-2 font-bold text-cyan-700">Forms</h3>
    <div class="flex gap-4">
      <FormCard formSettings={$formSettings.PrimaryForm} isPrimary={true}/>
      <FormCard formSettings={$formSettings.SecondaryForm} />
    </div>
  </div>
    <form
      on:submit|preventDefault={async () => {
        isLoading = true;
        await formSettings.save();
        isLoading = false;
        unSavedChanges = false;
      }}
    >
      <div class="flex flex-col gap-3 items-start">
        <button
          class="px-4 py-2 rounded bg-cyan-600 text-white font-medium tracking-wide"
        >
          Save
        </button>
        <div />
      </div>
    </form>
  </div>
{/if}
