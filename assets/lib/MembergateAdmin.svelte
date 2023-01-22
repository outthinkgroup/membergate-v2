<script lang="ts">
	import MembergateSetupWizard from "./MembergateSetupWizard.svelte";
	import MembergateSettings from "./MembergateSettings.svelte";
	import {completedSetup} from "../store"
</script>

{#if !$completedSetup }
	<MembergateSetupWizard/>
{:else}
	<MembergateSettings />
{/if}

