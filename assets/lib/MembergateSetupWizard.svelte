<script lang="ts">
  import getLists from "../api/getLists";
  import getGroups from "../api/getGroups";
  import saveSettings from "../api/saveSettings";
  import completeWizard from "../api/completeWizard";
  import {
    completedSetup,
    groups,
    lists,
    apikey,
    provider,
    selectedList,
  } from "../store";
  import ApiKeyInput from "./form/ApiKeyInput.svelte";
  import LabelSelect from "./form/LabelSelect.svelte";
  import EmsListSelect from "./form/EMSListSelect.svelte";
  import EmsGroupSelect from "./form/EMSGroupSelect.svelte";
  import { updateApiKey, updateProvider } from "../utils/formUtils";

  const providersList = window.membergate.providers;

  let currentStep = 1;
  async function completeStepOne() {
    const res = await saveSettings({
      providerName: $provider,
      apikey: $apikey,
    });
    const listData = await getLists();
    if (listData?.data?.lists) {
      lists.set(listData.data.lists);
    }

    console.log({ res1: res });
    currentStep = 2;
  }

  async function completeStepTwo() {
    const res = await saveSettings({ list_id: $selectedList });
    const groupData = await getGroups();

    if (groupData?.data) {
      groups.set(groupData.data);
    }
    currentStep = 3;
  }

  async function completeSetup() {
    const res = await completeWizard();
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
        <ApiKeyInput />
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
        <EmsGroupSelect />
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
