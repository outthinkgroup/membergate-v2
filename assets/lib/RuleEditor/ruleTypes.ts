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

export type ParameterOptionsT = keyof typeof parameterOptions;
export type OperatorsOptionsT = keyof typeof operators;

export type RuleValueOptionStoreT = Partial<Record<ParameterOptionsT, Record<string,string>>>

export type Rule = {
	parameter:ParameterOptionsT;
	operator: OperatorsOptionsT;
	value:string;
}

export type RuleGroup = Rule[]
export type RuleSet = RuleGroup[]
