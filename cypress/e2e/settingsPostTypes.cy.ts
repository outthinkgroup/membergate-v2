import { TestBaseSettings } from "cypress/support/SettingConfigs"

export {}
describe("Post settings in admin work",()=>{

	before(()=>{
		cy.setMembergateSettings(TestBaseSettings)
	})
	beforeEach(()=>{
		cy.adminLogin()
		cy.visit("http://consciousgrowthpartners.local/wp-admin/admin.php?page=membergate-settings")
	})
	it("checking a post type protects post type",()=>{
		cy.get("label[for='page'] input").click()
		cy.wait(200)
		cy.reload()
		cy.get("label[for='page'] input").should("be.checked")
		cy.visit("http://consciousgrowthpartners.local/sample-page/")
		cy.get(".membergate-form__form").should("exist")
	})
})
