<script lang="ts">
  import {computePosition,flip,shift, offset, arrow} from "@floating-ui/dom"
  import { onDestroy, onMount } from "svelte";
  
  let tooltipVisible = false
  
  let trigger:HTMLButtonElement;
  let tooltip:HTMLDivElement;
  let arrowEl:HTMLDivElement;

  function handleClickOutside(e){
    if(tooltipVisible && e.target != trigger && e.target != tooltip && e.target != arrowEl){
      tooltipVisible = false
    }
  }

  onMount(()=>{
    //positioning the tooltip
    computePosition(trigger, tooltip,{
      placement:'top',
      middleware:[offset(10),flip(),shift(),arrow({element:arrowEl})]
    }).then(({x,y, placement, middlewareData})=>{
      Object.assign(tooltip.style, {
        left:`${x}px`,
        top:`${y}px`,
      })

      const {x:arrowX, y:arrowY} = middlewareData.arrow
      const staticSide = {
        top:'bottom',
        right:'left',
        bottom:'top',
        left:'right',
      }[placement.split('-')[0]]

      Object.assign(arrowEl.style, {
        left: arrowX != null ? `${arrowX}px` :'',
        top: arrowY != null ? `${arrowY}px` :'',
        righ:'',
        bottom:'',
        [staticSide]: '-4px',
      })
    })

    //listen to clicks outside of tooltip and button
    document.body.addEventListener('click', handleClickOutside)
  })

  onDestroy(()=>{
    document.body.removeEventListener('click', handleClickOutside)
  })
</script>


<button 
  bind:this={trigger} 
  on:click={()=>tooltipVisible = !tooltipVisible}
  class="w-6 h-6 flex items-center justify-center rounded-full bg-cyan-900 text-cyan-100">
  ?
</button>

<div
  role="tooltip"
  bind:this={tooltip}
  class={ `bg-cyan-900 border border-cyan-100 text-cyan-100 font-bold p-1 rounded text-sm w-48 text-center shadow-md
    absolute top-0 left-0 ${tooltipVisible ? '' : 'opacity-0 pointer-events-none'}` } 
>
  <slot></slot>
  <div bind:this={arrowEl} 
    class="absolute bg-cyan-900 w-2 h-2 border-b border-r border-cyan-100 rotate-45"
  ></div>
</div>

<style>
  button:hover + [role="tooltip"]{
    opacity:1;
    pointer-events:auto;
  }
</style>
