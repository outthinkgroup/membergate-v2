import type { FormSettingsType } from "./types";

export { };
declare global {
	interface Window {
		membergate: {
			url: string;
			Rules:{
				initialRuleValueOptionStore:RuleValueOptionsStoreT;
			} 
		};
		publicMembergate: {
			url: string;
		};
	}
}
