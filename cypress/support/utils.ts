export function copyObj(obj:Record<string,unknown>){
	return JSON.parse(JSON.stringify(obj))
}
