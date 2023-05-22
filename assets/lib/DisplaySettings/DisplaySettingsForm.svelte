<script lang="ts">
  import { currentLocation, locations } from "../../locationStore";
  import { blockedContent, pageList } from "../../store";
  import FormHeader from "../form/FormHeader.svelte";
  import LabelSelect from "../form/LabelSelect.svelte";
  let isLoading = false;
  let unSavedChanges = false;
	$: $blockedContent, console.log("blockedContent:",$blockedContent)
</script>

{#if $currentLocation == locations.displayBlockedContent.slug}
  <div class="shadow bg-white p-6">
    <FormHeader {isLoading} {unSavedChanges}>
      Blocked Content Display Settings
    </FormHeader>
    <p class="mb-4">
      When and how should non members be shown the sign up form.
    </p>
    <form
      on:submit|preventDefault={async () => {
        isLoading = true;
        await blockedContent.save();
        isLoading = false;
        unSavedChanges = false;
      }}
    >
      <div class="flex flex-col gap-3 items-start">
        <LabelSelect
          name="protect_method"
          label="How should the protected content be hidden"
          value={$blockedContent.protect_method}
          on:inputChange={(e) => {
            blockedContent.updateSetting("protect_method", e.detail.value);
            unSavedChanges = true;
          }}
          options={{
            override_content: "Replace the content with the signup form",
            page_redirect: "Redirect Non Subscribed Members to A set page",
          }}
        />
        {#if $blockedContent.protect_method == "page_redirect"}
          <LabelSelect
            name="redirect_page"
            label="Select a page to redirect to that has the Membergate Signup up form"
            value={$blockedContent.redirect_page}
            on:inputChange={(e) => {
              blockedContent.updateSetting("redirect_page", e.detail.value);
              unSavedChanges = true;
            }}
            options={pageList}
            defaultOption={"select a page"}
          />
        {/if}
        <div class="mb-1">
          <legend class="text-md font-bold text-slate-700 mb-2">
            Should a modal show when a non subscriber clicks a link to protected
            content?
          </legend>
          <label for={"show_modal"}>
            <input
              type="checkbox"
              checked={$blockedContent.show_modal == "true"}
              id="show_modal"
              class=""
              on:change={(e) => {
                blockedContent.updateSetting(
                  "show_modal",
                  //@ts-ignore
                  e.target.checked ? "true" : "false"
                );
                unSavedChanges = true;
              }}
            />
            <span>Yes, show a modal.</span>
          </label>
        </div>

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
