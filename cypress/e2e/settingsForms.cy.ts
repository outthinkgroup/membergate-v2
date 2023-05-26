import { TestBaseSettings } from "cypress/support/SettingConfigs"
export {}

describe("Form Settings work",()=>{
	beforeEach(()=>{
		cy.setMembergateSettings(TestBaseSettings)
		cy.adminLogin()
		cy.visit("http://consciousgrowthpartners.local/wp-admin/admin.php?page=membergate-settings")
		cy.get("[data-test-id='forms']").click()
	})
	it("Primary Form Settings work",()=>{
		cy.get("header h3").should("contain.text","Login and Register Settings")
		cy.get("[data-test-id='primary']").find("header button").click()
		cy.get("[data-dialog-el='Primary Form']").should("exist")
		//can open field editor by clicking on preview field
		cy.get('[data-test-id="builder"] [data-test-id="name"]').first().click()
		cy.get('[data-test-id="builder"] aside [data-test-id="Label-wasdf23"] input').should("exist")
		//editing field label works
		cy.get('[data-test-id="builder"] aside [data-test-id="Label-wasdf23"] input').click().click().clear().type("Test Name")
		cy.get('[data-dialog-el="Primary Form"] [data-test-id="form-builder-preview"] button[data-test-id="name"]').find('label').should('contain.text','Test Name')
		cy.get('[data-test-id="builder"] aside [data-test-id="done-name"]').click()
		//only one name can be added
		cy.get('[data-test-id="add-field-NAME"]').first().click()
		cy.get('[data-dialog-el="Primary Form"] [data-test-id="form-builder-preview"] button[data-test-id="name"]').should("have.length", 1)
		//can edit inline elements with content editable
		cy.get('[data-dialog-el="Primary Form"] [data-test-id="submit-btn-field"]').trigger("focus",{force:true})
		cy.get('[data-dialog-el="Primary Form"] [data-test-id="submit-btn-edit-btn"]').trigger("mouseover",{force:true})
		cy.get('[data-dialog-el="Primary Form"] [data-test-id="submit-btn-edit-btn"]').trigger("click",{force:true})
		cy.get('[data-dialog-el="Primary Form"] [data-test-id="submit-btn-field"]').trigger("click",{force:true}).type("test submit",{force:true})
		cy.get('[data-dialog-el="Primary Form"] [data-test-id="submit-btn-field"]').should("have.text","test submit")
		cy.get('[data-dialog-el="Primary Form"] [data-test-id="submit-btn-edit-btn"]').trigger("click",{force:true})
		//can save
		cy.get('[data-dialog-el="Primary Form"] header button').contains('done').click()
		cy.get('form button').contains('Save').click()
		//edits render
		cy.visit("http://consciousgrowthpartners.local/2023/04/28/hello-world/")
		cy.reload()//no idea
		const form = cy.get('.membergate-form__form')
		form.contains("Test Name").should("exist")
		form.get("button").contains("test submit").should("exist")
	})
	it.only("tests secondary form",()=>{
		cy.get("header h3").should("contain.text","Login and Register Settings")
		cy.get("[data-test-id='secondary']").find("header button").click()
		cy.get("h2").contains("Secondary Form").should("be.visible")

		cy.get( '[data-test-id="daily_newsletter"]' ).click()
		cy.get('[data-test-id="builder"] aside input').should("exist")
		cy.get('[data-dialog-el="Secondary Form"] [data-test-id="builder"] aside [data-test-id="delete-checkbox"]').click()
		// can add, edit, and delete custom fields
		cy.get( '[data-test-id="daily_newsletter"]' ).should("not.exist")
		cy.get('[data-dialog-el="Secondary Form"] [data-test-id="add-field-TEXT"]').click()
		cy.get('[data-dialog-el="Secondary Form"] [data-test-id="text"]').should("exist").click()
		cy.get('[data-dialog-el="Secondary Form"] [data-test-id="builder"] aside input').first().click().clear().type("Test Text Field")
		cy.get('[data-dialog-el="Secondary Form"] [data-test-id="builder"] aside label').contains("Name").next().click().clear().type("TestName")
		cy.get('[data-dialog-el="Secondary Form"] [data-test-id="form-builder-preview"] [name="TestName"]').should("exist")
		// can disable secondary form
		cy.get(' [data-test-id="enable-secondary-form"]').uncheck({force:true})
		cy.get('[data-dialog-el="Secondary Form"] header button').click()//close dialog
		cy.get('form button').contains('Save').click()//saves
		//tests changes in render form
		cy.visit("http://consciousgrowthpartners.local/2023/04/28/hello-world/")
		cy.reload()//no idea
		cy.get("[data-current-form='PrimaryForm']").should("not.exist")
	})
})
