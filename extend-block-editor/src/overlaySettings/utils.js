export function updateCSSVars(settings) {
  const blocks = document.querySelector(".block-editor-block-list__layout");
  if (!blocks) return;
	blocks.style.setProperty(`--membergate-overlay-maxWidth`, settings.maxWidth );
	blocks.style.setProperty(`--membergate-overlay-position`, settings.position);
}
