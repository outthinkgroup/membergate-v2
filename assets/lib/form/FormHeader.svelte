<script lang="ts">
	import LoadingCircle from "../LoadingCircle.svelte";

	export let isLoading = false;
</script>
	<header class="flex justify-between items-center mb-2">
		<h3 class="text-xl font-medium text-cyan-600 ">
			<slot></slot>
		</h3>
		{#if isLoading}
			<LoadingCircle />
		{/if}
	</header>

