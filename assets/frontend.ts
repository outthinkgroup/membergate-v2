import "./styles/forms.css";
import "./styles/modal.css";

let template:HTMLTemplateElement;
document.addEventListener("DOMContentLoaded", function () {
  template = document.querySelector<HTMLTemplateElement>(
    "#membergate-modal-template"
  );

	if(template && template.content.querySelector('.errors')){
		const errorEl = template.content.querySelector<HTMLElement>('.errors');
		const {linkHref, linkTitle} = errorEl.dataset
		if(linkHref && linkTitle){
			showModal({linkHref, linkTitle})
		}else{
			showModal({linkHref:"", linkTitle:"Protected Content"})
		}
	}

	const membergateWrapper = document.querySelector('.membergate-parent.in-content-form')
	if(membergateWrapper){
		membergateWrapper.addEventListener('click', handleMembergateClickEvents)
	}
});

document.addEventListener("click", function (e: MouseEvent) {
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
      linkTitle: anchorEl.textContent ?? "Protected Content",
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

function showModal(settings:{linkHref:string, linkTitle:string}) {
  removeModal();
  // if(!template) throw new Error("no template found");
  const replaceTextWithSettings = (el: HTMLElement) =>
    replaceText(settings, el);
  const replaceValueWithSettings = (el: HTMLInputElement) =>
    replaceValue(settings, el);

  let modal = template.content.cloneNode(true) as DocumentFragment;
  modal.children[0].addEventListener("click", handleMembergateClickEvents);
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
    modal.removeEventListener("click", handleMembergateClickEvents);
    document.removeEventListener("keydown", handleEscKey);
    modal.parentElement.removeChild(modal);
  }
}

function handleMembergateClickEvents(e: MouseEvent) {
  console.log("running handleModalClickEvents");
  const target = e.target as HTMLElement;
  const el = target.matches("[data-action]")
    ? target
    : (target.closest("[data-action]") as HTMLElement);
  if (!el) return;
  switch (el.dataset.action) {
    case "close":
      return removeModal();
    case "switch-form":
      return switchForm(el);
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

async function switchForm(el:HTMLElement) {
  const { currentForm } = el.dataset;

  const currentWrapper = el.closest<HTMLElement>(".membergate-wrapper");
	currentWrapper.parentElement.dataset.isLoading='true'
  const res = await fetch(
    `${window.publicMembergate.url}?action=mg_public_endpoint&mg_public_action=fetch_alt_form&current_form=${currentForm}`,
    { method: "POST" }
  ).then((res) => res.text());
	currentWrapper.parentElement.dataset.isLoading='false'
  const parser = new DOMParser();
  const doc = parser.parseFromString(res, "text/html");

	const allReplaceValueEls = Array.from(currentWrapper.querySelectorAll<HTMLInputElement>('[data-replace-value]'))
	const settings = allReplaceValueEls.reduce((settings, el)=>{
		const setting = el.dataset.replaceValue
		const value  =	el.value
		if(setting && value){
			settings[setting] = value
		}
		return settings
	}, {})

	const replaceValueWithSettings = (el:HTMLInputElement)=>replaceValue(settings, el)
  const newForm = doc.querySelector(".membergate-wrapper");
  newForm
    .querySelectorAll("[data-replace-value]")
    .forEach(replaceValueWithSettings);
  currentWrapper.replaceWith(newForm);
}

