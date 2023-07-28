<script lang="ts">
	export let action:()=>void;
</script>
<button
	on:click={action}
	class="p-1 px-6 rounded text-lg font-semibold text-slate-800 border shadow-sm shadow-slate-100 border-slate-600"
>
	Save
</button>
