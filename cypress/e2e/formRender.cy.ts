export { };
	import { copyObj } from "cypress/support/utils";
import {DefaultFormSettings, TestBaseSettings} from "../support/SettingConfigs"
describe("Login Form Render Output based on different settings", () => {
	before(() => {
		cy.setMembergateSettings({
			...TestBaseSettings,
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

	it("it doesnt render alt link if disabled",()=>{
		const notEnabledSettings = copyObj(DefaultFormSettings)
		delete notEnabledSettings.SecondaryForm.isEnabled 
		cy.setMembergateSettings({forms:{
			...notEnabledSettings,
		}})
		cy.get("h2 a").first().click();
		const form = cy.get(".membergate-modal__layer form")
		form.get("[data-action='switch-form']").should("not.exist")
	})

	it("renders customized form inputs",()=>{
		const customizedFields = copyObj(DefaultFormSettings)
		customizedFields.SecondaryForm.fields = [//{{{
    {
        "type": "EMAIL",
        "name": "email",
        "id": "axca3",
        "label": "Email"
    },
    {
        "type": "NAME",
        "id": "23aass3",
        "label": "Name",
        "name": "name",
        "isRequired": true
    },
    {
        "type": "CHECKBOX",
        "id": "a233aaa",
        "label": "Test Checkbox Label",
        "name": "test-checkbox-name"
    },
    {
        "type": "TEXT",
        "name": "testname",
        "id": "77b31a44-f959-45ae-898f-9f425a4e9823",
        "label": "Test Label",
        "isRequired": true
    }
];//}}}
		customizedFields.SecondaryForm.submit.text = "TEST BUTTON LABEL"
		cy.setMembergateSettings({forms:customizedFields})
		cy.get("h2 a").first().click();
		cy.get(".membergate-modal__layer [data-action=switch-form]").click()
		const form = cy.get(".membergate-modal__layer form")
		form.get("[name='test-checkbox-name'][type='checkbox']").should('exist')
		form.get("[name='testname'][type='text']").should('exist')
		form.get("button[name='membergate_form']").should("have.text","TEST BUTTON LABEL" )
	})


});
