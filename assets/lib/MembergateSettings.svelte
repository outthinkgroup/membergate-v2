<script lang="ts">
  import { locations, currentLocation } from "../locationStore";
  import DisplaySettingsForm from "./DisplaySettings/DisplaySettingsForm.svelte";
  import EmailServiceSettingsForm from "./EmailServiceSettings/EmailServiceSettingsForm.svelte";
  import LoginAndRegisterSettingsForm from "./LoginAndRegisterSettings/LoginAndRegisterSettingsForm.svelte";
  import ProtectectedPostTypeSettingsForm from "./ProtectedPostTypesSettings/ProtectedPostTypesSettingsForm.svelte";
  console.log({ locations });
  $: isCurrentLocation = function isCurrentLocation(location: string) {
    return $currentLocation == location;
  };
</script>

<h2 class="text-3xl mb-10">Your Settings</h2>
<div>
  <header
    class="bg-gray-200 overflow-hidden rounded-t-md border-b-gray-200 border-b shadow"
  >
    <ul class="flex h-14 gap-[1px] ">
      <li class="w-full flex-1 m-0">
        <button
          class={`w-full bg-white h-full hover:bg-gray-100 font-bold
					${
            isCurrentLocation(locations.protectePostTypeSettings.slug)
              ? "text-cyan-600 font-extrabold"
              : ""
          }`}
          on:click={() =>
            currentLocation.navigate(locations.protectePostTypeSettings.slug)}
        >
          {locations.protectePostTypeSettings.tab}
        </button>
      </li>
      <li class="w-full flex-1 m-0">
        <button
          class={`w-full bg-white h-full hover:bg-gray-100 font-bold ${
            isCurrentLocation(locations.formSettings.slug)
              ? "text-cyan-600 font-extrabold"
              : ""
          }`}
          on:click={() => currentLocation.navigate(locations.formSettings.slug)}
        >
          {locations.formSettings.tab}
        </button>
      </li>
      <li class="w-full flex-1 m-0">
        <button
          class={`w-full bg-white h-full hover:bg-gray-100 font-bold
					${
            isCurrentLocation(locations.displayBlockedContent.slug)
              ? "text-cyan-600 font-extrabold"
              : ""
          }`}
          on:click={() =>
            currentLocation.navigate(locations.displayBlockedContent.slug)}
        >
          {locations.displayBlockedContent.tab}
        </button>
      </li>
      <li class="w-full flex-1 m-0">
        <button
          class={`w-full bg-white h-full hover:bg-gray-100 font-bold
					${
            isCurrentLocation(locations.emailServiceSettings.slug)
              ? "text-cyan-600 font-extrabold"
              : ""
          }`}
          on:click={() => {
            currentLocation.navigate(locations.emailServiceSettings.slug);
          }}
        >
          {locations.emailServiceSettings.tab}
        </button>
      </li>
    </ul>
  </header>
  <ProtectectedPostTypeSettingsForm />
  <DisplaySettingsForm />
  <LoginAndRegisterSettingsForm />
  <EmailServiceSettingsForm />
</div>
