<script lang="ts">
  import { currentLocation } from "../../locationStore";
  import { formSettings } from "../../store";
  import LabelInput from "../form/LabelInput.svelte";
  console.log($currentLocation);
</script>

{#if $currentLocation == "form-settings"}
  <div class="shadow bg-white p-6">
    <h3 class="text-xl font-medium text-cyan-600 mb-6">Signup Form Settings</h3>
    <form on:submit|preventDefault={() => formSettings.save()}>
      <div class="flex flex-col gap-3 items-start">
        <LabelInput
          name="form-title"
          label="Default Form Title"
          value={$formSettings.form_title}
          on:inputChange={(e) =>
            formSettings.updateSetting("form_title", e.detail.value)}
        />
        <div class="w-full">
          <LabelInput
            name="form-details"
            label="Default Form Details"
            value={$formSettings.form_details}
            on:inputChange={(e) =>
              formSettings.updateSetting("form_details", e.detail.value)}
          />
          <p>Some text to explain why and what the user needs to do.</p>
        </div>

        <LabelInput
          name="form-button-label"
          label="Default Form Button Label"
          value={$formSettings.form_button_label}
          on:inputChange={(e) =>
            formSettings.updateSetting("form_button_label", e.detail.value)}
        />

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
