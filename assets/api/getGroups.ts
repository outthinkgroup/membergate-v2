import {ajax} from "./utils"

/**
	* Gets all available lists / groups for the emsp
	*/
export default async function getGroups(list){
	const res = await ajax('get_groups', {
		list
	})
	return res
}


