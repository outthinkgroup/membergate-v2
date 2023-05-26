import { TestBaseSettings } from "cypress/support/SettingConfigs"

export {}
describe("Email Service Settings work",()=>{
	beforeEach(()=>{
		cy.setMembergateSettings(TestBaseSettings)
		cy.adminLogin()
		cy.visit("http://consciousgrowthpartners.local/wp-admin/admin.php?page=membergate-settings")
	})
	it("//TODO",()=>{
		// TODO
	})
})
