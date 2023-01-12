<script lang="ts">
	import {currentLocation} from "../../locationStore"
	import {postTypes} from "../../store"
</script>

{#if $currentLocation == "protected-posttype-settings"}
<div class="shadow bg-white p-6" >

	<h3 class="text-xl font-medium text-cyan-600 mb-6">Protected Content Settings</h3>
	<div>
		
	</div>
</div>
{/if}
