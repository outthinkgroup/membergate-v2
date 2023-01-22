import {ajax} from "./utils"

export default async function saveBlockedContent(settings:Record<string,string>){
	const res = await ajax('save_blocked_content_settings',settings)
	return res;
}
