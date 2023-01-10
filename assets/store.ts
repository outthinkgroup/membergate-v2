import { derived, writable } from 'svelte/store';

export const completedSetup = writable(window.membergate.completedSetup)

export const groups = writable(window.membergate.settings.groups)
export const lists = writable(window.membergate.settings.lists)

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
		groups[group.id] = group
		return groups	
	},{});
	
});
