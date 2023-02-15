<script lang="ts">
	import LoadingCircle from "../LoadingCircle.svelte";

	export let isLoading = false;
	export let unSavedChanges = false;
</script>
	<header class="flex justify-between items-center mb-2">
		<h3 class="text-xl font-medium text-cyan-600 ">
			<slot></slot>
		</h3>
		{#if unSavedChanges && !isLoading }
			<span class="font-medium text-gray-600 inline-block rounded-sm bg-gray-100 p-1 text-xs">Unsaved Changes</span>
		{/if}
		{#if isLoading}
			<LoadingCircle />
		{/if}
	</header>

