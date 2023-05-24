<script lang="ts">
  import { currentLocation } from "../../locationStore";
  import { postTypes } from "../../store";
  import FormHeader from "../form/FormHeader.svelte";
  let isLoading = false;

  type Checkbox = Event & {
    currentTarget: EventTarget & HTMLInputElement;
    target: EventTarget & HTMLInputElement & { checked: boolean };
  };

  async function updatePostType(e: Event, ptype: keyof typeof $postTypes) {
    const event = e as Checkbox;
    isLoading = true;
    await postTypes.save(ptype, event.target.checked);
    isLoading = false;
  }
</script>

{#if $currentLocation == "protected-posttype-settings"}
  <div class="shadow bg-white p-6">
    <FormHeader {isLoading}>Protected Content Settings</FormHeader>
    <p class="mb-4">Choose which post types by default will be protected</p>
    <div class="flex flex-col gap-2">
      {#each Object.keys($postTypes) as ptype}
        <div class="">
          <label for={ptype}>
            <input
              type="checkbox"
              checked={$postTypes[ptype].protected == "true" || $postTypes[ptype].protected == true}
              class=""
              on:change={(e) => updatePostType(e, ptype)}
            />
            <span class="text-md font-bold text-slate-700"
              >{$postTypes[ptype].name}</span
            >
          </label>
        </div>
      {/each}
    </div>
  </div>
{/if}
