export {}
describe("Rule Condition works", ()=>{
	it("will watch for cookie to apply rules",()=>{
		const configpath = "cypress/fixtures/cookie_condition.json"
		cy.exec(`cypress/scripts/load_protect_rule_settings.sh ${configpath}`)

		const protectedUrl = "https://membergate.test/let-me-in/";
		const  redirectUrl = "https://membergate.test/sample-page/";

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
