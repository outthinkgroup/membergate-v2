import "./styles/forms.css";
import "./styles/modal.css";

// window.addEventListener('DOMContentLoaded', getUrlProtectStatus);
// async function getUrlProtectStatus(){
// 	const origin = window.location.origin
// 	const linkStore = Array.from( document.querySelectorAll<HTMLAnchorElement>(`a[href^="${origin}"], a[href^="/"`)).reduce((linkStore, a)=>{
// 		const link = a.href
// 		if(!linkStore.has(link)){
// 			linkStore.set(link,[]);
// 		}
// 		linkStore.get(link).push(a)
// 		return linkStore
// 	},new Map())
//
// 	const links = [...linkStore.keys()]
// 	console.log(linkStore,linkStore.size);
// 	const data = await fetch(`${window.publicMembergate.url}`,{
// 		method:"POST",
// 		body:JSON.stringify({links}),
// 	}).then(res=>{
// 		if(res.ok){
// 			return res.json()
// 		}
// 		throw new Error("trouble in fetching protected link status")
// 	})
// 	if(!data.links || !data.links.length) return;
// 	for( let link of data.links){
// 		const elements = linkStore.get(link);
// 		for ( let anchorEl of elements ){
// 			if(!anchorEl) return;
//
// 			anchorEl.dataset.protect = "true"
// 		}
// 	}
// }
//
let template;
document.addEventListener("DOMContentLoaded", function() {
	template = document.querySelector<HTMLTemplateElement>(
		"#membergate-modal-template"
	);
});
document.addEventListener("click", function(e: MouseEvent) {
	if (!template) return;
	if (
		//@ts-ignore
		e.target.matches(
			"a[href*='membergate_protect'], a[href*='membergate_protect'] *"
		)
	) {
		e.preventDefault();
		const el = e.target as HTMLElement;
		const anchorEl =
			el.nodeName == "A"
				? (el as HTMLAnchorElement)
				: el.closest<HTMLAnchorElement>('a[href*="membergate_protect"');
		console.log(anchorEl);
		const settings = {
			linkTitle: anchorEl.title ?? "Protected Content",
			linkHref: anchorEl.href,
		};
		try {
			showModal(settings);
		} catch (e) {
			console.log("ERROR", e);
			// window.location.href = anchorEl.href
		}
	}
});
function showModal(settings) {
	removeModal();
	// if(!template) throw new Error("no template found");
	const replaceTextWithSettings = (el: HTMLElement) =>
		replaceText(settings, el);
	const replaceValueWithSettings = (el: HTMLInputElement) =>
		replaceValue(settings, el);
	let modal = template.content.cloneNode(true) as DocumentFragment;
	modal.children[0].addEventListener("click", handleModalClickEvents);
	document.addEventListener("keydown", handleEscKey);
	modal
		.querySelectorAll("[data-replace-text]")
		.forEach(replaceTextWithSettings);
	modal
		.querySelectorAll("[data-replace-value]")
		.forEach(replaceValueWithSettings);
	document.body.appendChild(modal);
}

function removeModal() {
	const modal = document.querySelector(".membergate-modal__layer");
	if (modal) {
		modal.removeEventListener("click", handleModalClickEvents);
		document.removeEventListener("keydown", handleEscKey);
		modal.parentElement.removeChild(modal);
	}
}

function handleModalClickEvents(e: MouseEvent) {
	console.log("running handleModalClickEvents");
	const target = e.target as HTMLElement;
	const el = target.matches("[data-action]")
		? target
		: (target.closest("[data-action]") as HTMLElement);
	if (!el) return;
	switch (el.dataset.action) {
		case "close":
			return removeModal();
		default:
			console.log("Invalid action");
			break;
	}
}

function handleEscKey(e: KeyboardEvent) {
	console.log(e.key);
	if (e.key == "Escape") {
		removeModal();
	}
}

function replaceText(settings: Record<string, string>, el: HTMLElement) {
	const setting = el.dataset.replaceText;
	el.textContent = settings[setting];
}
function replaceValue(settings: Record<string, string>, el: HTMLInputElement) {
	const setting = el.dataset.replaceValue;
	console.log(setting);
	el.value = settings[setting];
}
