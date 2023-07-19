import type {operators, parameterOptions} from "./rulegroupOptions"

export type ParameterOptionsT = keyof typeof parameterOptions;
export type OperatorsOptionsT = keyof typeof operators;

export type RuleValueOptionsStoreT = Partial<Record<ParameterOptionsT, Record<string,string>>>

export type Rule = {
	parameter:ParameterOptionsT;
	operator: OperatorsOptionsT;
	value:string;
}

export type RuleGroup = Rule[]
export type RuleSet = RuleGroup[]
