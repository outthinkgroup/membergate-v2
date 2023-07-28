<script lang="ts">
	export let content:string
	async function copy(){
		await window.navigator.clipboard.writeText(content)
	}
</script>

<button
	on:click={copy}
	class="py-1 px-3 font-bold text-slate-800 bg-slate-200 hover:bg-white rounded"
>
	Copy Settings
</button>
