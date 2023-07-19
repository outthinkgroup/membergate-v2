import { jsonAjax } from "../../api/utils"
import {get, writable} from "svelte/store"
import type { ParameterOptionsT, RuleValueOptionsStoreT } from "./ruleTypes"

export const ParamValues = createParamValueStore(
window.membergate.initialParameterValueStore
)

function createParamValueStore(initial:RuleValueOptionsStoreT){
	const {subscribe, update} = writable<RuleValueOptionsStoreT>(initial)

	return {
		subscribe,
		async load(param:ParameterOptionsT){
			const $store = get(ParamValues)
			if(Object.hasOwn($store, param)){
				return $store[param]
			}
			const res = await jsonAjax('rule_editor__load_param_value', {param}) as RuleValueOptionsStoreT
			console.log(res)
			update(s=> {
				s[param] = res[param]
				return s
			})
			return res[param]
		}
	}
}
