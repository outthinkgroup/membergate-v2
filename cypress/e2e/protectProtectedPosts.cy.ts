describe('Non Logged in, with modals, on index page', () => {
	beforeEach(()=>{
		cy.visit('http://consciousgrowthpartners.local/')
	})
  it('Is using modal stops links', () => {
		//click the first post on index page
		cy.get('h2 a').first().click()
		cy.url().should('eq', 'http://consciousgrowthpartners.local/')
		cy.get('.membergate-modal__layer').should('be.visible')
  })
  it('fillout form be redirected to link clicked', () => {
		cy.get('h2 a').first().click()
		cy.get(".membergate-modal__layer input[type='email']").first().type('josh@email.com')
		cy.get(".membergate-modal__layer input[type='text']").first().type('josh')
		cy.get(".membergate-modal__layer form button").click()
		cy.url().should('contain', 'hello-world')
		cy.reload()
		cy.url().should('contain', 'hello-world')
  })

	it('do cookies work',()=>{
		// cy.setMemberCookie()
		cy.setMembergateSettings()
		cy.setMembergateCookie();
		cy.get('h2 a').first().click()
		cy.url().should('contain', 'hello-world')
	})

	it('switches alt form [setting is available]',()=>{
		//TODO:	cy.setMembergateSetting('altFormEnabled')
		// cy.setUpModal()	
	})
})
