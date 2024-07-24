window.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".wp-block-membergate-backbutton").forEach((b) =>
    b.addEventListener("click", () => {
      window.history.back();
    }),
  );
});
