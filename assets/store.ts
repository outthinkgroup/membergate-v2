import { derived, readable, writable } from 'svelte/store';

export const completedSetup = writable(window.membergate.completedSetup)

export const groups = writable(window.membergate.settings.emailService.groups)
export const lists = writable(window.membergate.settings.emailService.lists)

export const listsForSelectList = derived(lists, ($lists)=>{
	return $lists.reduce(
				(lists: Record<string, string>, list: Record<string, any>) => {
					lists[list.id] = list.name;
					return lists;
				},
				{}
			);
});

export const groupsForSelectList = derived(groups,($groups)=>{
	return $groups.reduce((groups,group)=>{
		if(!Object.hasOwn(groups, group.parentGroupName)){
			groups[group.parentGroupName]	= [];
		}
		groups[group.parentGroupName].push({id:group.id, name:group.name})
		return groups
	},{});
});

export const provider = writable(window.membergate.settings.emailService.providerName)
export const apikey = writable(window.membergate.settings.emailService.apiKey)
export const selectedList = writable(window.membergate.settings.emailService.listId);
export const selectedGroup = writable(window.membergate.settings.emailService.groupId);


export const postTypes = readable(window.membergate.settings.postTypes)
