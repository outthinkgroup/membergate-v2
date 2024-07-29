import type { ConditionRuleT, ProtectMethodT, RuleSet } from "../../assets/lib/RuleEditor/ruleTypes";

export function copyObj(obj:Record<string,unknown>){
	return JSON.parse(JSON.stringify(obj))
}

export type ConfigType = {
	config:{
		id:number;	
    rules: RuleSet
		condition: ConditionRuleT;
		protectMethod: ProtectMethodT;
	};
	routes:{
		url:string,
		expectedUrl:string,
	}[];
}

export function runProtectRuleConfig(config:ConfigType, configpath:string){
	cy.exec(`cypress/scripts/load_protect_rule_settings.sh ${configpath}`)
	config.routes.forEach(route=>{
		cy.visit(route.url)
		cy.url().should('include', route.expectedUrl)
	})
}
