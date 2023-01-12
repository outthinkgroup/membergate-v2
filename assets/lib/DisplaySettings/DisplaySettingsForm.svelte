<script lang="ts">
    import { currentLocation, locations } from "../../locationStore";
</script>

{#if $currentLocation ==  locations.displayBlockedContent.slug}
	<h3>How to display blocked content</h3>
{/if}
