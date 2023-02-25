import { derived, readable, writable } from "svelte/store";
import savePostTypes from "./api/savePostTypes";
import saveSettings from "./api/saveSettings";
import saveFormSettings from "./api/saveFormSettings";
import saveBlockedContent from "./api/saveBlockedContent";

export const completedSetup = writable(window.membergate.completedSetup);

export const groups = writable(
	window.membergate.settings.emailService.groups ?? []
);
export const lists = writable(
	window.membergate.settings.emailService.lists ?? []
);

export const pageList = window.membergate.pageList

export const listsForSelectList = derived(lists, ($lists) => {
	return $lists.reduce(
		(lists: Record<string, string>, list: Record<string, any>) => {
			lists[list.id] = list.name;
			return lists;
		},
		{}
	);
});

export const groupsForSelectList = derived(groups, ($groups) => {
	if (!$groups.length) return {};
	return $groups.reduce((groups, group) => {
		if (!Object.hasOwn(groups, group.parentGroupName)) {
			groups[group.parentGroupName] = [];
		}
		groups[group.parentGroupName].push({ id: group.id, name: group.name });
		return groups;
	}, {});
});

function createProviderStore() {
	const { subscribe, set } = writable(
		window.membergate.settings.emailService.providerName
	);
	return {
		subscribe,
		clear: () => set(null),
		save: async (updatedProvider: string) => {
			const res = await saveSettings({ providerName: updatedProvider });
			if (res.errors.length) {
				console.log({ updatedProviderError: res.errors });
				return;
			}
			set(updatedProvider);
		},
	};
}
export const provider = createProviderStore();

//--
function createApikeyStore() {
	const { subscribe, set } = writable(
		window.membergate.settings.emailService.apiKey
	);
	return {
		subscribe,
		clear: () => set(null),
		save: async (updatedApikey: string) => {
			const res = await saveSettings({ apikey: updatedApikey });
			if (res.errors.length) {
				console.log({ updatedApikeyError: res.errors });
				return;
			}
			set(updatedApikey);
		},
	};
}
export const apikey = createApikeyStore();

//--
function createSelectedListStore() {
	const { subscribe, set } = writable(
		window.membergate.settings.emailService.listId
	);
	return {
		subscribe,
		clear: () => set(null),
		save: async (updatedListId: string) => {
			const res = await saveSettings({ list_id: updatedListId });
			if (res.errors.length) {
				console.log({ updatedListIdError: res.errors });
				return;
			}
			set(updatedListId);
		},
	};
}
export const selectedList = createSelectedListStore();

//--
function createSelectedGroupStore() {
	const { subscribe, set } = writable(
		window.membergate.settings.emailService.groupId
	);
	return {
		subscribe,
		clear: () => set(null),
		save: async (updatedGroupId: string) => {
			const res = await saveSettings({ group_id: updatedGroupId });
			if (res.errors.length) {
				console.log({ updatedGroupIdError: res.errors });
				return;
			}
			set(updatedGroupId);
		},
	};
}

export const selectedGroup = createSelectedGroupStore();

function createPostTypeStore() {
	console.log({ postTypes: window.membergate.settings.postTypes });
	const { subscribe, update } = writable(window.membergate.settings.postTypes);
	return {
		subscribe,
		async save(slug: string, isProtected: boolean) {
			update((postTypes) => {
				const value: "true" | "false" = isProtected ? "true" : "false";
				postTypes[slug].protected = value;
				return postTypes;
			});
			const res = await savePostTypes(slug, isProtected);
			return res;
		},
	};
}
export const postTypes = createPostTypeStore();

function createFormSettingsStore() {
	console.log({ postTypes: window.membergate.settings.formSettings });
	const { subscribe, update } = writable(
		// window.membergate.settings.formSettings
	{
		PrimaryForm:{
			headingText:"This Content is for Subscribers only",
			descriptionText: "Please fill in the form below to get access to this content.",
			fields:[
				{
					type:"NAME",
					id:"wasdf23",
					label:"Name",
					name:"name",
					isRequired:true,
				},
				{
					type:"EMAIL",
					id:"asdfase32",
					name:"email",
					label: "Email",
				},
			],
			SecondaryFormLink:{
				show:true,
				text:"Not a member yet?",
			},
			submit:{
				text:"Login",
			},
			action:"LOGIN",
		},
		SecondaryForm:{
			isEnabled:true,
			headingText:"Register to get access to VIP Content",
			descriptionText:"Please fill in the form below to get access to this content.",
			fields:[
				{
					type:"EMAIL",
					name:"email",
					id:"axca3",
					label:"Email",
				},
				{
					type:"NAME",
					id:'23aass3',
					label:"Name",
					name:"name",
					isRequired:true,
				},
				{
					type:"CHECKBOX",
					id:"a233aaa",
					label:"Subscribe to daily newsletter",
					name:"daily_newsletter",
				},
				{
					type:"TEXT",
					id:"oppase3",
					label:"Some text field",
					name:"MERGE_FIELD",
					isRequired:false,
				},
			],
			primaryFormLink:{
				show:true,
				text:"Already a member?",
			},
			submit:{
				text:"Register",
			},
			action:"REGISTER",
		}
	}
	);
	return {
		subscribe,
		async save() {
			let p: Record<string, any>;
			subscribe((fs) => {
				p = fs;
			});
			//TODO: update api method to send json
			const res = await saveFormSettings(p);
			return res;
		},
		updateSetting: (key: string, value: any) => {
			update((formSettings) => {
				formSettings[key] = value;
				return formSettings;
			});
		},
	};
}
export const formSettings = createFormSettingsStore();

function createBlockedContentStore() {
	const { subscribe, update } = writable(
		window.membergate.settings.blockedContent
	);
	return {
		subscribe,
		async save() {
			let p: Record<string, string>;
			subscribe((fs) => {
				p = fs;
			});
			const res = await saveBlockedContent(p);
			return res;
		},
		updateSetting: (key: string, value: string) => {
			update((blockedContent) => {
				blockedContent[key] = value;
				return blockedContent;
			});
		},
	}
}
export const blockedContent = createBlockedContentStore();
