import {ajax} from "./utils"

/**
	* Gets all available lists / groups for the emsp
	*/
export default async function saveSettings(settings:{apiKey:string, providerName:string, list:string, group:string}){
	const res = await ajax('save_general_settings', settings)
	return res
}

