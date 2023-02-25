<script lang="ts">
  import type { EditorStatesUnion, FormSettingsType } from "assets/types";

  export let editorState: EditorStatesUnion;
  export let formSettings: FormSettingsType;
  export let editField: (id: string) => void;
  export let title: string;
  export let editingFieldID: undefined | string = undefined;

  function editContentEditable(name:"heading"|"button"|"description") {
    switch(name){
      case "heading":
        editorState = editorState == "EDIT_HEADING" ? "DEFAULT" : "EDIT_HEADING";
        break;
      case "description":
        editorState = editorState == "EDIT_DESCRIPTION" ? "DEFAULT" : "EDIT_DESCRIPTION";
        break;
      case "button":
        editorState = editorState == "EDIT_BUTTON" ? "DEFAULT" : "EDIT_BUTTON";
        break;
    }
    const el = document.querySelector<HTMLElement>(
      `[data-el="${title}-${name}"]`
    );
    if (editorState != "DEFAULT") {
      setTimeout(() => {
        el.focus();
        window.getSelection().selectAllChildren(el);
      }, 10);
    }
  }
</script>

<div class="mx-auto min-w-[400px] p-10 pt-8">
  <div class="mb-6 ml-[-50px]">
    <span class="relative group pl-[50px] block">
      <h3
        class="mb-3 text-2xl"
        contenteditable={editorState == "EDIT_HEADING"}
        data-el={`${title}-heading`}
        tabindex="-1"
      >
        {formSettings.headingText}
      </h3>
      <button
        class="absolute left-0 top-0 p-2 rounded bg-transparent hover:bg-slate-200 hidden group-hover:block
group-focus-within:block"
        on:click={() => editContentEditable("heading")}
        >{editorState == "EDIT_HEADING" ? "save" : "edit"}</button
      >
    </span>
    <span class="relative group pl-[50px] block">
      <p
        contenteditable={editorState == "EDIT_DESCRIPTION"}
        data-el={`${title}-description`}
        tabindex="-1"
      >
        {formSettings.descriptionText}
      </p>
      <button
        class="absolute left-0 top-0 p-2 rounded bg-transparent hover:bg-slate-200 hidden group-hover:block
group-focus-within:block"
        on:click={() => editContentEditable("description")}>{editorState == "EDIT_DESCRIPTION" ? "save" : "edit"}</button
      >
    </span>
  </div>
  {#each formSettings.fields as field}
    <button
      class={`flex flex-col border gap-2 mb-2 w-full p-1 hover:bg-slate-200 
        ${
          editingFieldID == field.id
            ? " border-cyan-400"
            : " border-transparent"
        }`}
      on:click={() => editField(field.id)}
    >
      <label for="" class="font-bold ">{field.label}</label>
      <input
        class={`bg-white border-slate-200 ${
          field.type == "CHECKBOX" ? "" : "w-full"
        } pointer-events-none`}
        type={field.type == "CHECKBOX" ? "checkbox" : "text"}
        readonly
      />
    </button>
  {/each}
  <div class="ml-[-50px]">
    <span class="relative group pl-[50px] block">
      <div
        data-el={`${title}-button`}
        contenteditable={editorState == "EDIT_BUTTON"}
        tabindex="-1"
        class="p-3 inline-block text-white pointer-events-none font-bold bg-black rounded"
      >
        {formSettings.submit.text}
      </div>
      <button
        class="absolute left-0 top-0 p-2 rounded bg-transparent hover:bg-slate-200 hidden group-hover:block
group-focus-within:block"
        on:click={() => editContentEditable('button')}
      >
        {editorState == "EDIT_BUTTON" ? "save" : "edit"}
      </button>
    </span>
  </div>
</div>
