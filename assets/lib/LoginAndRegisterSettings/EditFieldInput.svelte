<script lang="ts">
  import type { FormSettingsType } from "assets/types";

  export let field: Record<string, any>;
  export let formSettings: FormSettingsType;
  export let editingFieldID: string;
</script>

<div>
  <label for={`${field.label}-${editingFieldID}`}>
    {field.label}
  </label>
  {#if field.type == "CHECKBOX"}
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
