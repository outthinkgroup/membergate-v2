<script lang="ts">
  import { currentLocation, locations } from "../../locationStore";
  import { blockedContent, pageList } from "../../store";
  import LabelSelect from "../form/LabelSelect.svelte";
</script>

{#if $currentLocation == locations.displayBlockedContent.slug}
  <div class="shadow bg-white p-6">
    <h3 class="text-xl font-medium text-cyan-600 mb-2">
      Blocked Content Display Settings
    </h3>
    <p class="mb-4">
      When and how should non members be shown the sign up form.
    </p>
    <form
      on:submit|preventDefault={() => {
        blockedContent.save();
      }}
    >
      <div class="flex flex-col gap-3 items-start">
        <LabelSelect
          name="protect_method"
          label="How should the protected content be hidden"
          value={"override_content"}
          on:inputChange={(e) => {
            blockedContent.updateSetting("protect_method", e.detail.value);
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
            }}
            options={pageList}
            defaultOption={"select a page"}
          />
        {/if}
        <div class="">
          <legend>
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
