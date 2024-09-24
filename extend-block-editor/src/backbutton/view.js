window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("[data-activate-event='PAGE_LOAD'] .wp-block-membergate-backbutton").forEach((b) =>
    b.addEventListener("click", () => {
      window.history.back();
    }),
  );

  document.querySelectorAll("[data-activate-event='CLICK_PROTECT_LINK'] .wp-block-membergate-backbutton").forEach((b) =>
    b.addEventListener("click", () => {
			b.closest("#membergate_overlay_root").dataset.state = "in_active"
    }),
  );
});
