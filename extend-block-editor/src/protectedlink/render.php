<?php


/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

use Membergate\Configuration\ProtectContent;

if (!isset($content)) $content = "";


/**
 * @var ProtectContent $protected_content
 **/
$protected_content = membergate()->get_container()->get(ProtectContent::class);

if ($protected_content->is_protected) {

    $html = new WP_HTML_Tag_Processor($content);
    if ($html->next_tag([
        'className' => 'wp-element-button',
    ])) {
        while ($html->get_tag() != "A") {
            $html->next_tag();
        }

        $rule = $protected_content->get_active_rule();
        if ($rule) {
            [$attr, $val] = $rule->protect_method()->method == "redirect" ? ["href", $protected_content->redirectUrl] : ["data-action", "open-overlay"];
            $html->set_attribute($attr, $val);

            $content = $html->get_updated_html();
        }
    }
}

?>
<div
    <?php echo get_block_wrapper_attributes(); ?> >
    <?= $content; ?>
</div>
