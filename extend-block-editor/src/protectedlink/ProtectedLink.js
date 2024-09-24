import {
  useInnerBlocksProps,
  useBlockProps,
  InnerBlocks,
} from "@wordpress/block-editor";

const BUTTONS_TEMPLATE = [
  ["core/buttons", {}, [["core/button", { text: "Download" }]]],
];

export function Edit() {
  const blockProps = useBlockProps();
  return (
    <div {...blockProps}>
      <InnerBlocks template={BUTTONS_TEMPLATE} templateLock="all" />
    </div>
  );
}

export function Save() {
  const blockProps = useBlockProps.save();
  const { children, ...innerBlocksProps } =
    useInnerBlocksProps.save(blockProps);
  return <div {...innerBlocksProps}>{children}</div>;
}
