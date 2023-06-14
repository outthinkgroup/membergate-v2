import { TestBaseSettings } from "cypress/support/SettingConfigs"

export {}

describe("Protect Posts types and posts set in admin",()=>{
	before(()=>{
		cy.removeMemberCookie()
		cy.setMembergateSettings(TestBaseSettings)
	})
	beforeEach(()=>{
		cy.visit("http://consciousgrowthpartners.local/")
	})
	it("allows un protected pages to be visible",()=>{
		cy.get("nav a[href='http://consciousgrowthpartners.local/sample-page/']").click()
		cy.url().should("contain","sample")
	})
	it("Protects Pages, but not those that have individually set to not protect",()=>{
		cy.setMembergateSettings({
			post_types:{
				page:{
					protected: 'true',
					slug: "page",
					name: "Page",
				}
			}
		})
		cy.setPostMeta("http://consciousgrowthpartners.local/sample-page/","default")//resetting
		cy.get("nav a[href='http://consciousgrowthpartners.local/sample-page/']").click()
		cy.url().should("contain","sample")
		cy.get(".membergate-form__form").should("exist")
		cy.setPostMeta("http://consciousgrowthpartners.local/sample-page/","never")
		cy.reload()
		cy.get(".membergate-form__form").should("not.exist")
		cy.setPostMeta("http://consciousgrowthpartners.local/sample-page/","default")//resetting
	})
	it("Doesnt Protect pages that specifically opted out",()=>{
		cy.setMembergateSettings({
			post_types:{
				page:{
					protected: 'false',
					slug: "page",
					name: "Page",
				}
			}
		})

		cy.setPostMeta("http://consciousgrowthpartners.local/sample-page/","always")
		cy.reload();
		cy.get("nav a[href='http://consciousgrowthpartners.local/sample-page/']").click()
		cy.url().should("contain","sample")
		cy.get(".membergate-form__form").should("exist")

		// testing that posts that are not specifically set will still allow it to be viewed	
		cy.visit("http://consciousgrowthpartners.local/privacy-policy/")
		cy.get(".membergate-form__form").should("not.exist")

		cy.setPostMeta("http://consciousgrowthpartners.local/sample-page/","default") // resetting
	})
})
