// / <reference types="cypress" />
// ***********************************************
// This example commands.ts shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
//Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })
//
//
export{}
Cypress.Commands.add("removeMemberCookie", () => {
  cy.clearCookie("membergate_member");
});

Cypress.Commands.add("setMembergateCookie", () => {
  cy.setCookie("membergate_member", "true");
	cy.reload()
});

Cypress.Commands.add("setMembergateSettings", (settings) => {
	settings = JSON.stringify(settings).replace(/"/g, `\\"`).replace(/'/g, `\\'`)
  console.log(cy.exec(`cypress/scripts/membergateSettings "`  + settings + '"'));
});

