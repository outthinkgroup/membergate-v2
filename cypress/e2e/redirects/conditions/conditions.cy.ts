export {}
describe("Rule Condition works", ()=>{
	it("will watch for cookie to apply rules",()=>{
		const configpath = "cypress/fixtures/cookie_condition.json"
		cy.exec(`cypress/scripts/load_protect_rule_settings.sh ${configpath}`)

		const redirectUrl = "http://consciousgrowthpartners.local/redirect/";
		const protectedUrl = "http://consciousgrowthpartners.local/2023/04/28/hello-world/";

		cy.removeMemberCookie();
		cy.visit(protectedUrl)
		cy.url().should("eq", redirectUrl)

		cy.setMembergateCookie()
		cy.visit(protectedUrl)
		cy.url().should("eq", protectedUrl)
	});
	// it("will watch for url_parameter to apply rules",()=>{
	//
	// });
})
