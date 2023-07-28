export const parameterOptions = {
	post_type: "Post Type",

	//Taxonomy
	category: "Category",
	tag:"Tag",

	// Individuals
	post: "Post",
	page: "Page",
	// Meta
	page_template: "Page Template",
	
	// USER
	user_role: "User Role",
};

export const operators = {
	is:"is equal to",
	not:"is not equal to",
}
export const conditionParamOptions = {
	"cookie":"Cookie",
	"urlparam":"Url Parameter"
}
export const conditionOperatorOptions={
	"notset": "Is Not Set",
	"notequal":"Does Not Equal",
}
export const protectMethodOptions = {
	redirect:"Redirect To",
}


export type ParameterOptionsT = keyof typeof parameterOptions;
export type OperatorsOptionsT = keyof typeof operators;

export type RuleValueOptionStoreT = Partial<Record<ParameterOptionsT, Record<string,string>>>

export type RuleT = {
	parameter:ParameterOptionsT;
	operator: OperatorsOptionsT;
	value:string;
}

export type RuleGroup = RuleT[]
export type RuleSet = RuleGroup[]

export type ConditionRuleT = {
	parameter:ConditionParamOptionsT;
	key:string;
	operator:ConditionOperatorOptionsT;
	value?:string;
}

export type ConditionParamOptionsT = keyof typeof conditionParamOptions;
export type ConditionOperatorOptionsT = keyof typeof conditionOperatorOptions;

export type ProtectMethodT = {
	method:keyof typeof protectMethodOptions;
	value:string;
}
