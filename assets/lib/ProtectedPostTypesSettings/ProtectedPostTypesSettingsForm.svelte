<script lang="ts">
	import {currentLocation} from "../../locationStore"
	import {postTypes} from "../../store"

	type Checkbox = Event & {
    currentTarget: EventTarget & HTMLInputElement;
		target:EventTarget & HTMLInputElement & {checked:boolean};
	};

	function updatePostType(e:Event, ptype: keyof typeof $postTypes){
		const event = e as Checkbox 
		postTypes.save(ptype, event.target.checked)	
	}
</script>


{#if $currentLocation == "protected-posttype-settings"}
<div class="shadow bg-white p-6" >

	<h3 class="text-xl font-medium text-cyan-600 mb-6">Protected Content Settings</h3>
	<div class="flex flex-col gap-2">
		{#each Object.keys($postTypes) as ptype}
			<div class="">
				<label for={ptype}>
					<input type="checkbox" checked={$postTypes[ptype].protected == "true"} class="" on:change={(e)=>updatePostType(e,ptype)}>
					<span>{$postTypes[ptype].name}</span>
				</label>
			</div>
		{/each}
	</div>
</div>
{/if}
