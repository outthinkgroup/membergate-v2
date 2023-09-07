<script lang="ts">
	export let action:()=>Promise<void>;
	let isLoading = false;
	async function saveAction(){
		isLoading = true	
		await action().catch(e=>console.log(e))
		isLoading=false
	}
</script>
<button
	on:click={saveAction}
	class="p-1 px-6 rounded bg-cyan-600 text-cyan-50 text-lg font-semibold shadow-sm shadow-slate-100 hover:bg-cyan-700
	min-w-[150px]"
>
	Sav{isLoading ? "ing": "e"}
</button>
