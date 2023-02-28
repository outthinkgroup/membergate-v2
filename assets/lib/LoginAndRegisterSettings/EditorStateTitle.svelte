<script lang="ts">
  import type { EditorStatesUnion } from "assets/types";
  export let editorState: EditorStatesUnion;
  const titles: Record<EditorStatesUnion, string> = {
    DEFAULT: "Add Fields",
    EDIT_BUTTON: "Editing Button",
    EDIT_NAME: "Editing Name",
    EDIT_DESCRIPTION: "Editing form description",
    EDIT_TEXT: "Editing a text field",
    EDIT_EMAIL: "Editing a Email field",
    EDIT_HEADING: "Editing Form Heading",
    EDIT_CHECKBOX: "Editing a Checkbox field",
  };
  let editorStateTitle: string;
  $: editorStateTitle = titles[editorState];
</script>

<span>{editorStateTitle}</span>
