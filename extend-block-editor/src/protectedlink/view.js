//create an object for us to add stuff to
window.publicMembergate.protectedLink = {};

createSignals();

window.addEventListener("DOMContentLoaded", () => {

	document
		.querySelectorAll(
			".wp-block-membergate-protectedlink [data-action='open-overlay']",
		)
		.forEach((b) =>
			b.addEventListener("click", (e) => {
				e.preventDefault();
				// for extensions
				const link = e.target.getAttribute("href");
				window.publicMembergate.protectedLink.updateIntendedLink(link);
				document.querySelector("#membergate_overlay_root").dataset.state =
					"active";
			}),
		);
});

function createSignals() {
	let listeners = [];
	window.publicMembergate.protectedLink.subscribe = function(cb) {
		listeners.push(cb);
	};

	window.publicMembergate.protectedLink.updateIntendedLink = function(link) {
		for (let listener of listeners) {
			listener(link);
		}
	};
}
