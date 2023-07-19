import { jsonAjax } from "../../utils/api"
import {get, writable} from "svelte/store"
import type { ParameterOptionsT, RuleValueOptionStoreT } from "./ruleTypes"

export const ParamValues = createParamValueStore(
	window.membergate.Rules.initialRuleValueOptionStore
)

function createParamValueStore(initial:RuleValueOptionStoreT){
	const {subscribe, update} = writable<RuleValueOptionStoreT>(initial)

	return {
		subscribe,
		async load(param:ParameterOptionsT){
			const $store = get(ParamValues)
			if(Object.hasOwn($store, param)){
				return $store[param]
			}
			const res = await jsonAjax('rule_editor__load_param_value', {param}) as RuleValueOptionStoreT
			console.log(res)
			update(s=> {
				s[param] = res[param]
				return s
			})
			return res[param]
		}
	}
}
