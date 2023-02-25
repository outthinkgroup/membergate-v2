<script lang="ts">
  import type {
    AddableFieldTypeUnion,
    EditorStatesUnion,
    FieldType,
  } from "assets/types";
  import { onMount } from "svelte";
  import { formSettings as FormSettingsStore } from "../../store";
  import EditFieldInput from "./EditFieldInput.svelte";
  import EditorStateTitle from "./EditorStateTitle.svelte";
  import FormPreview from "./FormPreview.svelte";
  import {
    fieldKinds,
    genId,
    getCheckboxFieldsFor,
    getEmailFieldsFor,
    getNameFieldsFor,
    getTextFieldsFor,
  } from "./utils";

  export let isPrimary: boolean;
  export let title: string;
  export let formSettings: any;
  let dialogEl: HTMLDialogElement;
  export const showEditor = () => {
    dialogEl.showModal();
  };

  onMount(() => {
    dialogEl = document.querySelector(`[data-dialog-el="${title}"]`);
  });

  function finishEditing() {
    dialogEl.close();
    const key = isPrimary ? "PrimaryForm" : "SecondaryForm";
    FormSettingsStore.updateSetting(key, formSettings);
  }

  let editorState: EditorStatesUnion = "DEFAULT";

  function addFieldFor(fieldType: {
    kind: AddableFieldTypeUnion;
    onlyOne: boolean;
  }) {
    if (
      fieldType.onlyOne &&
      formSettings.fields.find(
        (field) => field.type == fieldType.kind.toLowerCase()
      )
    ) {
      window.alert("Only one of these can be added to the form");
      return;
    }
    const newField: FieldType = {
      type: fieldType.kind as AddableFieldTypeUnion,
      name: fieldType.kind.toLowerCase(),
      id: genId(),
      label: fieldType.kind.toLowerCase(),
    };
    if (fieldType.kind != "CHECKBOX") {
      newField.isRequired = false;
    }
    formSettings.fields.push(newField);
    formSettings = formSettings;
  }

  function deleteField() {
    formSettings.fields = formSettings.fields.filter(
      (field) => field.id != editingFieldID
    );
    formSettings = formSettings;
    editorState = "DEFAULT";
  }

  let editingFieldID: undefined | string = undefined;

  function editField(id: string) {
    editingFieldID = id;
    const field = formSettings.fields.find((field) => field.id == id);
    if (!field) return;
    switch (field.type) {
      case "EMAIL":
        editorState = "EDIT_EMAIL";
        break;
      case "NAME":
        editorState = "EDIT_NAME";
        break;
      case "TEXT":
        editorState = "EDIT_TEXT";
        break;
      case "CHECKBOX":
        editorState = "EDIT_CHECKBOX";
        break;
      default:
        break;
    }
  }

  function doneEditField() {
    editorState = "DEFAULT";
    editingFieldID = undefined;
  }
</script>

<dialog
  data-dialog-el={title}
  class="border-slate-200 border p-0 bg-slate-50 w-[85vw] h-[75vh] mx-auto overflow-y-auto rounded-lg max-w-[950px]"
>
  <div class="flex flex-col h-full">
    <header class="p-4 border-b border-slate-200">
      <div class="flex justify-between items-center mb-3 ">
        <h2 class="text-3xl text-cyan-800">{title}</h2>
        <button
          class="bg-slate-200 p-2 rounded hover:bg-slate-300"
          on:click={finishEditing}>done</button
        >
      </div>
      <div>
        <p class="text-sm uppercase text-slate-500 tracking-wide mb-1">
          Action
        </p>
        <select
          class="bg-slate-100 border-0 text-md text-cyan-600 font-bold p-2 pr-8 rounded-md"
          bind:value={formSettings.action}
        >
          <option value="LOGIN">Login</option>
          <option value="REGISTER">Register and Login</option>
        </select>
      </div>
    </header>

    <!-- Builder's Body -->
    <div class="flex h-full">
      <aside class="border-r border-slate-200 w-full max-w-[275px] h-full">
        <header class="p-4 py-3 border-b border-slate-200">
          <h3 class="text-lg text-slate-900">
            <EditorStateTitle {editorState} />
          </h3>
        </header>

        {#if editorState == "DEFAULT"}
          {#each fieldKinds(isPrimary) as field}
            <button
              class="h-10 font-bold text-slate-500 capitalize text-left py-3 px-4 border-b border-slate-200 hover:bg-slate-100
hover:text-cyan-600 w-full"
              on:click={() => {
                addFieldFor(field);
              }}
            >
              {field.kind.toLowerCase()} Field
            </button>
          {/each}
        {:else if editorState == "EDIT_EMAIL"}
          {#each getEmailFieldsFor(editingFieldID, formSettings) as field, index}
            <EditFieldInput bind:field bind:editingFieldID bind:formSettings />
            <button on:click={doneEditField}>Done</button>
          {/each}
        {:else if editorState == "EDIT_NAME"}
          {#each getNameFieldsFor(editingFieldID, formSettings) as field}
            <EditFieldInput bind:field bind:editingFieldID bind:formSettings />
          {/each}
          <button on:click={deleteField}>Delete</button>
          <button on:click={doneEditField}>Done</button>
        {:else if editorState == "EDIT_CHECKBOX"}
          {#each getCheckboxFieldsFor(editingFieldID, formSettings) as field}
            <EditFieldInput bind:field bind:editingFieldID bind:formSettings />
          {/each}
          <button on:click={deleteField}>Delete</button>
          <button on:click={doneEditField}>Done</button>
        {:else if editorState == "EDIT_TEXT"}
          {#each getTextFieldsFor(editingFieldID, formSettings) as field}
            <EditFieldInput bind:field bind:editingFieldID bind:formSettings />
          {/each}
          <button on:click={deleteField}>Delete</button>
          <button on:click={doneEditField}>Done</button>
        {/if}
      </aside>
      <FormPreview
        {editingFieldID}
        {formSettings}
        {editField}
        {title}
        bind:editorState
      />
    </div>
  </div>
</dialog>
