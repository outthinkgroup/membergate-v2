<script lang="ts">
  import { formSettings as FormSettingsStore } from "../../store";
  import ToolTip from "../ToolTip.svelte";
  import FormBuilder from "./FormBuilder.svelte";

  export let isPrimary: boolean = false;
  export let formSettings: any;
  const title = isPrimary ? "Primary Form" : "Secondary Form";

  let action: string;
  $: action = formSettings.action == "LOGIN" ? "Login" : "Register and Login";

  let isEnabled: boolean;
  $: isEnabled = isPrimary
    ? true
    : $FormSettingsStore.PrimaryForm.action == "LOGIN";

  let showEditor: () => void;
</script>

<div
  class="bg-slate-50 border border-slate-200 rounded-md p-2 inline-flex min-w-[225px]"
	data-test-id={isPrimary ? "primary" : "secondary"}
>
  <div class="w-full flex flex-col gap-3 justify-between">
    <header class="flex justify-between items-center gap-6">
      <h4 class="text-cyan-800 text-xl">
        {title}
      </h4>
      {#if isEnabled}
        <button
          class="bg-slate-200 p-2 rounded hover:bg-slate-300"
          title="Edit Form"
          on:click={showEditor}>edit</button
        >
      {:else}
        <ToolTip>Set the Primary forms action to Login to enable</ToolTip>
      {/if}
    </header>

    <div>
      <p
        class="text-xs flex items-center gap-1 uppercase text-slate-500 tracking-wide mb-1"
      >
        Action
        <ToolTip triggerSize="small"
          >When the user submits the form what happens</ToolTip
        >
      </p>
      <div
        class="inline-block p-4 py-1 text-md font-bold text-cyan-600 bg-slate-200 rounded-md"
      >
        {action}
      </div>
    </div>
  </div>
</div>

<FormBuilder bind:showEditor {title} {isPrimary} {formSettings} />
