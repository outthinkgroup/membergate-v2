import { TestBaseSettings } from "cypress/support/SettingConfigs";

export {}
describe("Form actions subscribe, or check subscriber status", () => {
	before(()=>{
		// PrimaryForm must be Login only
		// SecondaryForm must be enabled
		// Mockserver Must be running
		cy.setMembergateSettings(TestBaseSettings)
	})
	beforeEach(() => {
		cy.visit("http://consciousgrowthpartners.local/2023/04/28/hello-world/");
	});
	it("New Subscribers cant subscribe on login only forms", () => {
		cy.RestartMockServer();
		//click the first post on index page
		const form = cy.get('.membergate-form__form') 
		form.get('[name="name"]').click().type("josh")
		form.get('[name="email"]').first().click().type("josh@outthinkgroup.com")
		form.get("button[name='membergate_form']").click()
		form.should("exist")
		cy.get(".membergate-wrapper .errors").first().should("contain.text","Oh no! You aren’t a member yet!")

		//this is making sure only one form is rendererd to the page.
		//At one point there was a bug where 2 forms were being shown if an error occured
		//this makes sure it doesnt happen again
		cy.get(".membergate-form__form").click().should("be.visible")
	});
	it("Can register with secondary form", () => {
		//click the first post on index page
		cy.get("[data-current-form='PrimaryForm']").first().click()
		const form = cy.get('.membergate-form__form')
		form.get('[name="name"]').click().type("josh")
		form.get('[name="email"]').first().click().type("josh@outthinkgroup.com")
		form.get("button[name='membergate_form']").click()
		form.should("not.exist")
	});
	it("Current Subscribers can log back in",()=>{
		//this test depends on the "Can register with secondary form" 
		//so that the email is already in the mockserver's "DB"
		cy.removeMemberCookie()
		const form = cy.get('.membergate-form__form')
		form.get('[name="name"]').click().type("josh")
		form.get('[name="email"]').first().click().type("josh@outthinkgroup.com")
		form.get("button[name='membergate_form']").click()
		form.should("not.exist")
	})

});
