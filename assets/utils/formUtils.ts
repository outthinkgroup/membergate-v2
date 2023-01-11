import {apikey, groups, lists, provider, selectedGroup, selectedList} from "../store"
// import {} from "../api"
export function selectValue(e:Event){
	return [...e.target.childNodes].find(el=>el.selected).value
}

export function updateProvider(value){
	let oldVal;

	provider.subscribe((val)=>oldVal = val)

	if(value !== oldVal){
		provider.set(value)
		// apikey.set("") // this is too inconvienient if this happens on accident
		selectedGroup.set("")
		selectedList.set("")
	}
}

export function updateApiKey(value){
	let oldKey;
	apikey.subscribe((val)=> oldKey = val)

	if(oldKey !== value){
		apikey.set(value)
		selectedGroup.set("")
		selectedList.set("")
	}
}
	
export function updateList(value){
	let oldList;
	selectedList.subscribe((val)=> oldList = val)

	if(oldList !== value){
		selectedList.set(value)
		selectedGroup.set("")
	}
}
export function updateGroup(value){
	let oldGroup;
	selectedGroup.subscribe((val)=> oldGroup = val)

	if(oldGroup !== value){
		selectedGroup.set(value)
	}
}
