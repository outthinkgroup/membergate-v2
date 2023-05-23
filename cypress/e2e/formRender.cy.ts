export { };
import {DefaultFormSettings} from "../support/SettingConfigs"
describe("Login Form Render Output based on different settings", () => {
	before(() => {
		cy.setMembergateSettings({
			reset_non_essential: {},
			post_types: {
				post: {
					protected: 'true',
					slug: "post",
					name: "Post",
				},
			},
			protected_content: {
				protect_method: "override_content",
				show_modal: 'true',
			}
		});
	});
	beforeEach(() => {
		cy.visit("http://consciousgrowthpartners.local/");
	});

	it("it renders alt link if set", ()=>{
		cy.get("h2 a").first().click();
		const form = cy.get(".membergate-modal__layer form")
		form.get("[data-action='switch-form']").should("be.visible")
	})

	// Maybe brittle if it breaks try adding a setMembergateSettings to reset_non_essential
	it("can switch out forms for register form",()=>{
		cy.get("h2 a").first().click();
		let altButton = cy.get(".membergate-modal__layer [data-action=switch-form]")
		altButton.click();	
		cy.get(".membergate-modal__layer h3").should("have.text", "Register to get access to VIP Content")	
		altButton = cy.get(".membergate-modal__layer [data-action=switch-form]")
		altButton.click()
		cy.get(".membergate-modal__layer h3").should("have.text", "This Content is for Subscribers only")	
	})

	
	// Maybe brittle if it breaks try adding a setMembergateSettings to reset_non_essential
	//TODO: create a mock ESPClient for testing
	//TODO: test registering, and login

	it("it doesnt render alt link if disabled",()=>{
		const notEnabledSettings = {...DefaultFormSettings}
		delete notEnabledSettings.SecondaryForm.isEnabled 
		cy.setMembergateSettings({forms:{
			...notEnabledSettings,
		}})
		cy.get("h2 a").first().click();
		const form = cy.get(".membergate-modal__layer form")
		form.get("[data-action='switch-form']").should("not.exist")
	})

});
