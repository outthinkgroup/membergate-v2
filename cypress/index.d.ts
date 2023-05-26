export {}
declare global {
  namespace Cypress {
    interface Chainable {
      // login(email: string, password: string): Chainable<void>
      // drag(subject: string, options?: Partial<TypeOptions>): Chainable<Element>
      // dismiss(subject: string, options?: Partial<TypeOptions>): Chainable<Element>
      // visit(originalFn: CommandOriginalFn, url: string, options: Partial<VisitOptions>): Chainable<Element>
      setMembergateCookie(): void;
      removeMemberCookie(): void;
			setMembergateSettings(settings:any):void;
			RestartMockServer():void;
			setPostMeta(id:any,meta:any):void;
			adminLogin():void;
    }

  }
}

