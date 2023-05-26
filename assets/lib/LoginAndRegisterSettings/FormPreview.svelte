<script lang="ts">
  import type { EditorStatesUnion, FormSettingsType } from "assets/types";
  import { createEventDispatcher } from "svelte";

  export let editorState: EditorStatesUnion;
  export let formSettings: FormSettingsType;
  export let editField: (id: string) => void;
  export let title: string;
  export let isPrimary: boolean;
  export let editingFieldID: undefined | string = undefined;

  const dispatch = createEventDispatcher();

  let formName: "SecondaryForm" | "PrimaryForm";
  $: formName = isPrimary ? "PrimaryForm" : "SecondaryForm";

  function editContentEditable(
    name: "heading" | "button" | "description" | "link"
  ) {
    let formOption:
      | "headingText"
      | "descriptionText"
      | "submit"
      | "altFormLink";
    switch (name) {
      case "heading":
        editorState =
          editorState == "EDIT_HEADING" ? "DEFAULT" : "EDIT_HEADING";
        formOption = "headingText";
        break;
      case "description":
        editorState =
          editorState == "EDIT_DESCRIPTION" ? "DEFAULT" : "EDIT_DESCRIPTION";
        formOption = "descriptionText";
        break;
      case "button":
        editorState = editorState == "EDIT_BUTTON" ? "DEFAULT" : "EDIT_BUTTON";
        formOption = "submit";
        break;
      case "link":
        editorState = editorState == "EDIT_LINK" ? "DEFAULT" : "EDIT_LINK";
        formOption = "altFormLink";
        break;
    }
    const el = document.querySelector<HTMLElement>(
      `[data-el="${formName}-${name}"]`
    );
    if (editorState != "DEFAULT") {
      setTimeout(() => {
        el.focus();
        window.getSelection().selectAllChildren(el);
      }, 0);
    } else {
      const newContent = el.textContent;
      dispatch("contentEdited", {
        content: newContent,
        key: formOption,
      });
    }
  }
</script>

<div data-test-id="form-builder-preview" class="mx-auto min-w-[400px] p-10 pt-8">
  <div class="mb-6 ml-[-50px]">
    <span class="relative group pl-[50px] block">
      <h3
        class="mb-3 text-2xl"
        contenteditable={editorState == "EDIT_HEADING"}
        data-el={`${formName}-heading`}
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
        data-el={`${formName}-description`}
        tabindex="-1"
      >
        {formSettings.descriptionText}
      </p>
      <button
        class="absolute left-0 top-0 p-2 rounded bg-transparent hover:bg-slate-200 hidden group-hover:block
group-focus-within:block"
        on:click={() => editContentEditable("description")}
        >{editorState == "EDIT_DESCRIPTION" ? "save" : "edit"}</button
      >
    </span>
  </div>
  {#each formSettings.fields as field}
    <button
			data-test-id={field.name}
      class={`flex flex-col border gap-2 mb-2 w-full p-1 hover:bg-slate-200 rounded
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
				name={field.name}
        readonly
      />
    </button>
  {/each}
  <div class="ml-[-50px]">
    <span class="relative group pl-[50px] block">
      <div
				data-test-id="submit-btn-field"
        data-el={`${formName}-button`}
        contenteditable={editorState == "EDIT_BUTTON"}
        tabindex="-1"
        class="p-3 inline-block text-white pointer-events-none font-bold bg-black rounded"
      >
        {formSettings.submit.text}
      </div>
      <button
				data-test-id="submit-btn-edit-btn"
        class="absolute left-0 top-0 p-2 rounded bg-transparent hover:bg-slate-200 hidden group-hover:block
group-focus-within:block"
        on:click={() => editContentEditable("button")}
      >
        {editorState == "EDIT_BUTTON" ? "save" : "edit"}
      </button>
    </span>
  </div>
  <div class="ml-[-50px]">
    <span class="relative group pl-[50px] block">
      <div
        data-el={`${formName}-link`}
        contenteditable={editorState == "EDIT_LINK"}
        tabindex="-1"
        class="py-3 inline-block text-cyan-600 underline pointer-events-none font-bold rounded"
      >
        {formSettings.altFormLink.text}
      </div>
      <button
        class="absolute left-0 top-0 p-2 rounded bg-transparent hover:bg-slate-200 hidden group-hover:block
group-focus-within:block"
        on:click={() => editContentEditable("link")}
      >
        {editorState == "EDIT_LINK" ? "save" : "edit"}
      </button>
    </span>
  </div>
</div>
