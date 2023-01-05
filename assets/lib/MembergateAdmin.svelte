<script lang="ts">
  import MembergateSetupWizard from "./MembergateSetupWizard.svelte";
	import MembergateSettings from "./MembergateSettings.svelte";

	let completedSetup = window.membergate.completedSetup
</script>

{#if !completedSetup }
	<MembergateSetupWizard/>
{:else}
	<MembergateSettings />
{/if}

