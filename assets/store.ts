import { derived, readable, get, writable } from "svelte/store";
import savePostTypes from "./api/savePostTypes";
import saveListSettings from "./api/saveSettings";
import saveFormSettings from "./api/saveFormSettings";
import saveBlockedContent from "./api/saveBlockedContent";

export const completedSetup = writable(window.membergate.completedSetup);


export const groups = writable(
  window.membergate.settings.emailService.groups ?? []
);
export const lists = writable(
  window.membergate.settings.emailService.lists ?? []
);

export const pageList = window.membergate.pageList;

export const listsForSelectList = derived(lists, ($lists) => {
  return $lists.reduce(
    (lists: Record<string, string>, list: Record<string, any>) => {
      lists[list.id] = list.name;
      return lists;
    },
    {}
  );
});

export const groupsForSelectList = derived(groups, ($groups):Record<string,string> => {
  if (!$groups.length) return {};
	//used if there is groups with in groups
	if(Object.hasOwn($groups[0],'parentGroupName')){
		return $groups.reduce((groups, group) => {
			if (!Object.hasOwn(groups, group.parentGroupName)) {
				groups[group.parentGroupName] = [];
			}
			groups[group.parentGroupName].push({ id: group.id, name: group.name });
			return groups;
		}, {});
	}
	//flat group list
  return $groups.reduce((groups, group) => {
		groups[group.id]=group.name
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
      const res = await saveListSettings({ providerName: updatedProvider });
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
      const res = await saveListSettings({ apikey: updatedApikey });
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
      const res = await saveListSettings({ list_id: updatedListId });
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
      const res = await saveListSettings({ group_id: updatedGroupId });
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
    async save(slug: string, isProtected: "false"|"true") {
      update((postTypes) => {
        const value: "true" | "false" = isProtected; 
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
  const { subscribe, update } = writable(
    window.membergate.settings.formSettings
  );
  return {
    subscribe,
    async save() {
      let p: Record<string, any> = get(formSettings)
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
      let p: Record<string, string> = get(blockedContent);
      const res = await saveBlockedContent(p);
      return res;
    },
    updateSetting: (key: string, value: string) => {
      update((blockedContent) => {
        blockedContent[key] = value;
        return blockedContent;
      });
    },
  };
}
export const blockedContent = createBlockedContentStore();

