<?php

namespace Membergate\RenderForm;

class FieldRender {
    private $fields;

    public function __construct($fields) {
        $this->fields = $fields;
    }

    public function build_fields(): array {
        $fields = [];
        foreach ($this->fields as $field) {
            $field_markup = "";
            switch ($field['type']) {
                case "EMAIL":
                    $field_markup = $this->email_field($field);
                    break;
                case "NAME":
                    $field_markup = $this->name_field($field);
                    break;
                case "TEXT":
                    $field_markup = $this->text_field($field);
                    break;
                case "CHECKBOX":
                    $field_markup = $this->checkbox_field($field);
                    break;
                default:
                    break;
            }
            $fields[] = [
                'type' => $field['type'],
                'markup' => $field_markup,
            ];
        }
        return $fields;
    }

    private function email_field($field) {
        ob_start(); ?>
		<label for=<?= $field['id']; ?>><?= $field['label']; ?></label>
        <input type="email" placeholder="<?=$field['placeholder']?>" name="email" id=<?= $field['id']; ?> required />
	<?php
        return ob_get_clean();
    }
    private function name_field($field) {
        ob_start(); ?>
		<label for=<?= $field['id']; ?>><?= $field['label']; ?></label>
		<input id="<?= $field['id']; ?>" type="text" placeholder="<?=$field['placeholder']?>" name="name" <?= $field['isRequired'] ? 'required' : '' ?> />
	<?php
        return ob_get_clean();
    }
    private function text_field($field) {
        ob_start(); ?>
		<label for=<?= $field['id']; ?>><?= $field['label']; ?></label>
		<input id=<?= $field['id']; ?> type="text" name="<?= $field["name"] ?>" placeholder="<?=$field['placeholder']?>" <?= $field['isRequired'] ? 'required' : '' ?> />
	<?php
        return ob_get_clean();
    }
    private function checkbox_field($field) {
        ob_start(); ?>
		<input id=<?= $field['id']; ?> type="checkbox" name=<?= $field["name"] ?> />
		<label for=<?= $field['id']; ?>><?= $field['label']; ?></label>
<?php
        return ob_get_clean();
    }
}
