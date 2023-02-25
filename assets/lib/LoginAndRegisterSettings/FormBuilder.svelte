<script lang="ts">
  import { formSettings as FormSettingsStore } from "../../store";
  import {
    fieldKinds,
    genId,
    getCheckboxFieldsFor,
    getEmailFieldsFor,
    getNameFieldsFor,
    getTextFieldsFor,
  } from "./utils";
  
  export let isPrimary:boolean
  export let title:string
  export let formSettings:any
  export let dialogEl:HTMLDialogElement
  

  let editorState:
    | "EDIT_TEXT"
    | "DEFAULT"
    | "EDIT_EMAIL"
    | "EDIT_NAME"
    | "EDIT_CHECKBOX"
    | "EDIT_HEADING"
    | "EDIT_BUTTON"
    | "EDIT_DESCRIPTION" = "DEFAULT";

  function deleteField() {
    formSettings.fields = formSettings.fields.filter(
      (field) => field.id != editingFieldID
    );
    formSettings = formSettings;
    editorState = "DEFAULT";
  }

  function doneEditField() {
    editorState = "DEFAULT";
    editingFieldID = undefined;
  }

  let editingFieldID: undefined | string = undefined;

  function editField(id: string) {
    editingFieldID = id;
    const field = formSettings.fields.find((field) => field.id == id);
    if (!field) return;
    switch (field.type) {
      case "email":
        editorState = "EDIT_EMAIL";
        break;
      case "name":
        editorState = "EDIT_NAME";
        break;
      case "text":
        editorState = "EDIT_TEXT";
        break;
      case "checkbox":
        editorState = "EDIT_CHECKBOX";
        break;
      default:
        break;
    }
  }

  function addFieldFor(fieldType: {
    kind: "TEXT" | "NAME" | "CHECKBOX";
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
    const newField: Record<string, any> = {
      type: fieldType.kind.toLowerCase(),
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

  function finishEditing() {
    dialogEl.close();
    const key = isPrimary ? "PrimaryForm" : "SecondaryForm";
    FormSettingsStore.updateSetting(key, formSettings);
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
    <div class="flex h-full">
      <aside class="border-r border-slate-200 w-full max-w-[275px] h-full">
        <header class="h-10 border-b border-slate-200">
          <h3>{editorState}</h3>
        </header>

        {#if editorState == "DEFAULT"}
          {#each fieldKinds(isPrimary) as field}
            <button
              class="h-10 text-left p-3 border-b border-slate-200 hover:bg-slate-200 w-full"
              on:click={() => {
                addFieldFor(field);
              }}
            >
              {field.kind}
            </button>
          {/each}
        {:else if editorState == "EDIT_EMAIL"}
          {#each getEmailFieldsFor(editingFieldID, formSettings) as field}
            <div>
              <label for={`${field.label}-${editingFieldID}`}>
                {field.label}
              </label>
              <input
                id={`${field.label}-${editingFieldID}`}
                name={`${field.label}-${editingFieldID}`}
                on:input={(e) => {
                  const fieldIndex = formSettings.fields.findIndex(
                    (f) => f.id == editingFieldID
                  );
                  formSettings.fields[fieldIndex][field.key] =
                    //@ts-ignore
                    e.target.value;
                  formSettings = formSettings;
                }}
                type="text"
                value={field.value}
              />
            </div>
            <button on:click={doneEditField}>Done</button>
          {/each}
        {:else if editorState == "EDIT_NAME"}
          {#each getNameFieldsFor(editingFieldID, formSettings) as field}
            <div>
              <label for={`${field.label}-${editingFieldID}`}>
                {field.label}
              </label>
              {#if field.type == "checkbox"}
                <input
                  id={`${field.label}-${editingFieldID}`}
                  name={`${field.label}-${editingFieldID}`}
                  on:change={(e) => {
                    const fieldIndex = formSettings.fields.findIndex(
                      (f) => f.id == editingFieldID
                    );
                    formSettings.fields[fieldIndex][field.key] =
                      //@ts-ignore
                      e.target.checked;
                    formSettings = formSettings;
                  }}
                  type="checkbox"
                  checked={Boolean(field.value)}
                />
              {:else}
                <input
                  id={`${field.label}-${editingFieldID}`}
                  name={`${field.label}-${editingFieldID}`}
                  on:input={(e) => {
                    const fieldIndex = formSettings.fields.findIndex(
                      (f) => f.id == editingFieldID
                    );
                    formSettings.fields[fieldIndex][field.key] =
                      //@ts-ignore
                      e.target.value;
                    formSettings = formSettings;
                  }}
                  type="text"
                  value={field.value}
                />
              {/if}
            </div>
          {/each}
          <button on:click={deleteField}>Delete</button>
          <button on:click={doneEditField}>Done</button>
        {:else if editorState == "EDIT_CHECKBOX"}
          {#each getCheckboxFieldsFor(editingFieldID, formSettings) as field}
            <div>
              <label for={`${field.label}-${editingFieldID}`}>
                {field.label}
              </label>
              {#if field.type == "checkbox"}
                <input
                  id={`${field.label}-${editingFieldID}`}
                  name={`${field.label}-${editingFieldID}`}
                  on:change={(e) => {
                    const fieldIndex = formSettings.fields.findIndex(
                      (f) => f.id == editingFieldID
                    );
                    formSettings.fields[fieldIndex][field.key] =
                      //@ts-ignore
                      e.target.checked;
                    formSettings = formSettings;
                  }}
                  type="checkbox"
                  checked={Boolean(field.value)}
                />
              {:else}
                <input
                  id={`${field.label}-${editingFieldID}`}
                  name={`${field.label}-${editingFieldID}`}
                  on:input={(e) => {
                    const fieldIndex = formSettings.fields.findIndex(
                      (f) => f.id == editingFieldID
                    );
                    formSettings.fields[fieldIndex][field.key] =
                      //@ts-ignore
                      e.target.value;
                    formSettings = formSettings;
                  }}
                  type="text"
                  value={field.value}
                />
              {/if}
            </div>
          {/each}
          <button on:click={deleteField}>Delete</button>
          <button on:click={doneEditField}>Done</button>
        {:else if editorState == "EDIT_TEXT"}
          {#each getTextFieldsFor(editingFieldID, formSettings) as field}
            <div>
              <label for={`${field.label}-${editingFieldID}`}>
                {field.label}
              </label>
              {#if field.type == "checkbox"}
                <input
                  id={`${field.label}-${editingFieldID}`}
                  name={`${field.label}-${editingFieldID}`}
                  on:change={(e) => {
                    const fieldIndex = formSettings.fields.findIndex(
                      (f) => f.id == editingFieldID
                    );
                    formSettings.fields[fieldIndex][field.key] =
                      //@ts-ignore
                      e.target.checked;
                    formSettings = formSettings;
                  }}
                  type="checkbox"
                  checked={Boolean(field.value)}
                />
              {:else}
                <input
                  id={`${field.label}-${editingFieldID}`}
                  name={`${field.label}-${editingFieldID}`}
                  on:input={(e) => {
                    const fieldIndex = formSettings.fields.findIndex(
                      (f) => f.id == editingFieldID
                    );
                    formSettings.fields[fieldIndex][field.key] =
                      //@ts-ignore
                      e.target.value;
                    formSettings = formSettings;
                  }}
                  type="text"
                  value={field.value}
                />
              {/if}
            </div>
          {/each}
          <button on:click={deleteField}>Delete</button>
          <button on:click={doneEditField}>Done</button>
        {/if}
      </aside>
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
              on:click={() => {
                editorState =
                  editorState == "EDIT_HEADING" ? "DEFAULT" : "EDIT_HEADING";
                const heading = document.querySelector(
                  `[data-el="${title}-heading"]`
                );
                if (editorState == "EDIT_HEADING") {
                  setTimeout(() => {
                    //@ts-ignore
                    heading.focus();
                    window.getSelection().selectAllChildren(heading);
                  }, 0);
                }
              }}>{editorState == "EDIT_HEADING" ? "save" : "edit"}</button
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
              on:click={() => {
                editorState =
                  editorState == "EDIT_DESCRIPTION"
                    ? "DEFAULT"
                    : "EDIT_DESCRIPTION";
                const heading = document.querySelector(
                  `[data-el="${title}-description"]`
                );
                if (editorState == "EDIT_DESCRIPTION") {
                  setTimeout(() => {
                    //@ts-ignore
                    heading.focus();
                    window.getSelection().selectAllChildren(heading);
                  }, 0);
                }
              }}>{editorState == "EDIT_DESCRIPTION" ? "save" : "edit"}</button
            >
          </span>
        </div>
        {#each formSettings.fields as field}
          <button
            class={`flex flex-col border gap-2 mb-2 w-full p-1 hover:bg-slate-200 
  ${editingFieldID == field.id ? " border-cyan-400" : " border-transparent"}`}
            on:click={() => editField(field.id)}
          >
            <label for="" class="font-bold ">{field.label}</label>
            <input
              class={`bg-white border-slate-200 ${
                field.type == "checkbox" ? "" : "w-full"
              } pointer-events-none`}
              type={field.type == "checkbox" ? "checkbox" : "text"}
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
              on:click={() => {
                editorState =
                  editorState == "EDIT_BUTTON" ? "DEFAULT" : "EDIT_BUTTON";
                const button = document.querySelector(
                  `[data-el="${title}-button"]`
                );
                if (editorState == "EDIT_BUTTON") {
                  setTimeout(() => {
                    //@ts-ignore
                    button.focus();
                    window.getSelection().selectAllChildren(button);
                  }, 0);
                }
              }}
            >
              {editorState == "EDIT_BUTTON" ? "save" : "edit"}
            </button>
          </span>
        </div>
      </div>
    </div>
  </div>
</dialog>
