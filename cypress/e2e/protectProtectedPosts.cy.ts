import { TestBaseSettings } from "cypress/support/SettingConfigs";

export { };

describe("[DEFAULT SETTINGS]:Non Logged in, with modals, on index page", () => {
	before(()=>{
		cy.setMembergateSettings(TestBaseSettings)
	})
	beforeEach(() => {
		cy.visit("http://consciousgrowthpartners.local/");
	});
	it("Is using modal, stops links and show modal instead", () => {
		
		//click the first post on index page
		cy.get("h2 a").first().click();
		cy.url().should("eq", "http://consciousgrowthpartners.local/");
		cy.get(".membergate-modal__layer").should("be.visible");
	});
	it("fillout form be redirected to link clicked", () => {
		cy.get("h2 a").first().click();
		cy.get("[data-current-form='PrimaryForm']").first().click()
		cy.wait(200)// this should not be needed
		cy.get(".membergate-modal__layer input[type='email']")
			.first()
			.type("josh@email.com");
		cy.get(".membergate-modal__layer input[type='text']").first().type("josh");
		cy.get(".membergate-modal__layer form button").click();
		cy.url().should("contain", "hello-world");
		cy.reload();
		cy.url().should("contain", "hello-world");
	});

	it("do cookies work", () => {
		cy.setMembergateCookie();
		cy.get("h2 a").first().click();
		cy.url().should("contain", "hello-world");
	});
});

describe("More Non Logged in Users Flows", () => {
	before(() => {
		cy.setMembergateSettings(TestBaseSettings);
	});
	beforeEach(() => {
		cy.visit("http://consciousgrowthpartners.local/2023/04/28/hello-world/");
	});
	it("Can't See Protected Post", () => {
		const content = cy.get(".entry-content").first();
		content.should("not.contain.text", "Welcome to WordPress.");
	});
	it("is redirected from protected posts if (options allowed)", () => {
		const redirect_page_id = "2"
		 cy.setMembergateSettings({
			protected_content: {
				protect_method: "page_redirect",
				redirect_page:redirect_page_id,
				show_modal: "",
			}
		});
		cy.reload()
		cy.get('body').should('have.class', `page-id-${redirect_page_id}`)
	});
});
