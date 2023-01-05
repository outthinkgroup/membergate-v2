import {ajax} from "./utils"

/**
	* Gets all available lists / groups for the emsp
	*/
export default async function getLists(apiKey:string, providerName:string){
	const res = await ajax('get_lists', {
		apiKey,
		providerName
	})
	return res
}


