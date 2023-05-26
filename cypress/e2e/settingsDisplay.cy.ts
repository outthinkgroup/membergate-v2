import { TestBaseSettings } from "cypress/support/SettingConfigs"

export {}
describe("Display Settings 🔆",()=>{
	before(()=>{
		cy.setMembergateSettings(TestBaseSettings)
	})
	beforeEach(()=>{
		cy.adminLogin()
		cy.visit("http://consciousgrowthpartners.local/wp-admin/admin.php?page=membergate-settings")
		cy.get("[data-test-id='display']").click()
	})
	it("Form Display Settings work and stuff",()=>{
		//tests redirect page
		cy.get("[data-test-id='display'] [name='protect_method']").select("page_redirect")
		cy.get("[data-test-id='display'] [name='redirect_page']").select("2")
		cy.get("[data-test-id='save-display']").click()
		cy.visit("http://consciousgrowthpartners.local/2023/04/28/hello-world/")
		cy.reload()
		cy.url().should("contain", "sample-page")
		//tests override content	
		cy.visit("http://consciousgrowthpartners.local/wp-admin/admin.php?page=membergate-settings")
		cy.get("[data-test-id='display']").click()
		cy.get("[data-test-id='display'] [name='protect_method']").select("override_content")
		cy.get("[data-test-id='save-display']").click()
		cy.visit("http://consciousgrowthpartners.local/2023/04/28/hello-world/")
		cy.visit("http://consciousgrowthpartners.local/2023/04/28/hello-world/")
		cy.document().title().should("contain","Hello")

		//tests no modal
		cy.visit("http://consciousgrowthpartners.local/wp-admin/admin.php?page=membergate-settings")
		cy.get("[data-test-id='display']").click()
		cy.get("#show_modal").uncheck()
		cy.get("[data-test-id='save-display']").click()
		cy.visit("http://consciousgrowthpartners.local/?no-cache")
		cy.reload()
		cy.get("h2 a").first().click()
		cy.document().title().should("contain","Hello")

		//tests modal 
		cy.visit("http://consciousgrowthpartners.local/wp-admin/admin.php?page=membergate-settings")
		cy.get("[data-test-id='display']").click()
		cy.get("#show_modal").check()
		cy.get("[data-test-id='save-display']").click()
		cy.visit("http://consciousgrowthpartners.local/?no-cache")
		cy.reload()
		cy.get("h2 a").first().click()
		cy.document().title().should("not.contain","Hello")// means the url wasnt changed and the modal was popped

	})

})
