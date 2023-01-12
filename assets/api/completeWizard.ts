import {ajax} from "./utils"

/**
	* Gets all available lists / groups for the emsp
	*/
export default async function completeWizard(){
	const res = await ajax('complete_setup', {})
	return res
}


