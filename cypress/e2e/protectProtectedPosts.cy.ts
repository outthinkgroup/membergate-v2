export { };

describe("Non Logged in, with modals, on index page", () => {
	beforeEach(() => {
		cy.visit("http://consciousgrowthpartners.local/");
	});
	it("Is using modal, stops links and show modal instead", () => {
		cy.setMembergateSettings({
			post_types: {
				post: {
					protected: true,
					slug: "post",
					name: "Post",
				},
			},
		});
		//click the first post on index page
		cy.get("h2 a").first().click();
		cy.url().should("eq", "http://consciousgrowthpartners.local/");
		cy.get(".membergate-modal__layer").should("be.visible");
	});
	it("fillout form be redirected to link clicked", () => {
		cy.get("h2 a").first().click();
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
		cy.setMembergateSettings({
			post_types: {
				post: {
					protected: false,
					slug: "post",
					name: "Post",
				},
			},
		});
		cy.setMembergateCookie();
		cy.get("h2 a").first().click();
		cy.url().should("contain", "hello-world");
	});
});

describe("More Non Logged in Users Flows", () => {
	before(() => {
		cy.setMembergateSettings({
			post_types: {
				post: {
					protected: true,
					slug: "post",
					name: "Post",
				},
			},
		});
	});
	beforeEach(() => {
		cy.visit("http://consciousgrowthpartners.local/2023/04/28/hello-world/");
	});
	it("Can't See Protected Post", () => {
		const content = cy.get(".entry-content").first();
		content.should("not.contain.text", "Welcome to WordPress.");
	});
	it.only("is redirected from protected posts if (options allowed)", () => {
		 cy.setMembergateSettings({
			protected_content: {
				protect_method: "page_redirect",
				redirect_page:"2",
				show_modal: "",
			}
		});
		cy.reload()
		cy.url().should("eq","http://consciousgrowthpartners.local/" )
	});
});
