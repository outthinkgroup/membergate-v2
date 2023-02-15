import {apikey, groups, lists, provider, selectedGroup, selectedList} from "../store"
// import {} from "../api"
export function selectValue(e:Event){
	return [...e.target.childNodes].find(el=>el.selected).value
}

export async function updateProvider(value){
	let oldVal;

	provider.subscribe((val)=>oldVal = val)

	if(value !== oldVal){
		await provider.save(value)
		// apikey.set("") // this is too inconvienient if this happens on accident
		selectedGroup.clear()
		selectedList.clear()
	}
}

export async function updateApiKey(value){
	let oldKey;
	apikey.subscribe((val)=> oldKey = val)

	if(oldKey !== value){
		await apikey.save(value)
		selectedGroup.clear()
		selectedList.clear()
	}

	return 1;
}
	
export function updateList(value){
	let oldList;
	selectedList.subscribe((val)=> oldList = val)

	if(oldList !== value){
		selectedList.save(value)
		selectedGroup.clear()
	}
}
export function updateGroup(value){
	let oldGroup;
	selectedGroup.subscribe((val)=> oldGroup = val)

	if(oldGroup !== value){
		selectedGroup.save(value)
	}
}
