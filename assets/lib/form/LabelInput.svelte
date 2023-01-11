<script lang="ts">
  import { createEventDispatcher } from "svelte";
  const dispatch = createEventDispatcher();
  export let type = "text";
  export let name = "";
  export let id = name ? name : "";
  export let label = "";
  export let value = "";
	export let event = "change"

	
  $: value,
		event == "change" && dispatch("inputChange", {
				value,
			});
</script>

<label for={id} class="flex flex-col gap-3">
  <span class="text-md font-bold text-slate-700">{label}</span>
  <input
    {type}
    value={value}
    on:input={(e) => {
      //@ts-ignore
      value = e.target.value;
    }}
		on:blur={()=>{
			if(event == "blur"){
				dispatch("inputChange", {value})
			}
		}}
    {name}
    class="min-w-[200px] bg-slate-50 py-2 px-3 font-medium text-cyan-900 border-slate-200 focus:border-cyan-400"
  />
</label>
