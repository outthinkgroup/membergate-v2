import { derived, readable, writable } from 'svelte/store';
import saveSettings from './api/saveSettings';

export const completedSetup = writable(window.membergate.completedSetup)

export const groups = writable(window.membergate.settings.emailService.groups ?? [])
export const lists = writable(window.membergate.settings.emailService.lists ?? [])

export const listsForSelectList = derived(lists, ($lists)=> {
	return $lists.reduce(
				(lists: Record<string, string>, list: Record<string, any>) => {
					lists[list.id] = list.name;
					return lists;
				},
				{}
			);
});

export const groupsForSelectList = derived(groups,($groups)=>{
	if (!$groups.length) return {}
	return $groups.reduce((groups,group)=>{
		if(!Object.hasOwn(groups, group.parentGroupName)){
			groups[group.parentGroupName]	= [];
		}
		groups[group.parentGroupName].push({id:group.id, name:group.name})
		return groups
	},{});
});

function createProviderStore(){
	const {subscribe, set} = writable(window.membergate.settings.emailService.providerName)
	return {
		subscribe,
		clear:()=>set(null),
		save:async (updatedProvider:string)=>{
			const res = await saveSettings({providerName:updatedProvider})	
			if (res.errors.length){
				console.log({updatedProviderError:res.errors})
				return;
			}
			set(updatedProvider)
		},
	}
}
export const provider = createProviderStore()

//--
function createApikeyStore(){
	const {subscribe, set} = writable(window.membergate.settings.emailService.apiKey)
	return {
		subscribe,
		clear:()=>set(null),
		save:async (updatedApikey:string)=>{
			const res = await saveSettings({apikey:updatedApikey})	
			if (res.errors.length){
				console.log({updatedApikeyError:res.errors})
				return;
			}
			set(updatedApikey)
		},
	}
}
export const apikey = createApikeyStore();

//--
function createSelectedListStore(){
	const {subscribe, set} = writable(window.membergate.settings.emailService.listId)
	return {
		subscribe,
		clear:()=>set(null),
		save:async (updatedListId:string)=>{
			const res = await saveSettings({list_id:updatedListId})	
			if (res.errors.length){
				console.log({updatedListIdError:res.errors})
				return;
			}
			set(updatedListId)
		},
	}
}
export const selectedList = createSelectedListStore()

//--
function createSelectedGroupStore(){
	const {subscribe, set} = writable(window.membergate.settings.emailService.groupId)
	return {
		subscribe,
		clear:()=>set(null),
		save:async (updatedGroupId:string)=>{
			const res = await saveSettings({group_id:updatedGroupId})	
			if (res.errors.length){
				console.log({updatedGroupIdError:res.errors})
				return;
			}
			set(updatedGroupId)
		},
	}
}

export const selectedGroup = createSelectedGroupStore()



export const postTypes = readable(window.membergate.settings.postTypes)
