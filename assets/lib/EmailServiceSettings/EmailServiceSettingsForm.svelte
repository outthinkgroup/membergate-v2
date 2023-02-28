<script lang="ts">
  import saveSettings from "../../api/saveSettings";
  import { currentLocation } from "../../locationStore";
  import LabelSelect from "../form/LabelSelect.svelte";
  import EmsListSelect from "../form/EMSListSelect.svelte";
  import EmsGroupSelect from "../form/EMSGroupSelect.svelte";

  import { apikey, selectedList, selectedGroup, provider } from "../../store";
  import { updateProvider } from "../../utils/formUtils";
  import ApiKeyInput from "../form/ApiKeyInput.svelte";
  import FormHeader from "../form/FormHeader.svelte";

  let { providers } = window.membergate;
  let isLoading = false;
</script>

{#if $currentLocation == "email-service-settings"}
  <div class="shadow bg-white p-6">
    <FormHeader {isLoading}>Email Service Settings</FormHeader>
    <form
      on:submit|preventDefault={async () => {
        isLoading = true;
        await saveSettings({
          providerName: $provider,
          apikey: $apikey,
          group_id: $selectedGroup,
          list_id: $selectedList,
        });
        isLoading = false;
      }}
    >
      <div class="flex flex-col gap-3">
        <LabelSelect
          value={$provider}
          on:inputChange={async (e) => {
            isLoading = true;
            await updateProvider(e.detail.value);
            isLoading = false;
          }}
          options={providers}
          label="Select a Email Marketing Service"
          name="providerName"
        />
        <ApiKeyInput
          on:loadingStateChange={(e) => {
            isLoading = e.detail.isLoading;
          }}
        />
        <EmsListSelect
          on:loadingStateChange={(e) => {
            isLoading = e.detail.isLoading;
          }}
        />
        <EmsGroupSelect
          on:loadingStateChange={(e) => {
            isLoading = e.detail.isLoading;
          }}
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
  </div>
{/if}
