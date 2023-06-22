import { get } from "svelte/store";
import {
  apikey,
  groups,
  lists,
  provider,
  selectedGroup,
  selectedList,
} from "../store";
// import {} from "../api"
//
export function selectValue(e: Event) {
  return [...e.target.childNodes].find((el) => el.selected).value;
}

export async function updateProvider(value) {
  let oldVal = get(provider)

  if (value !== oldVal) {
    await provider.save(value);
    // apikey.set("") // this is too inconvienient if this happens on accident
    selectedGroup.clear();
    selectedList.clear();
  }
}

export async function updateApiKey(value) {
  let oldKey = get(apikey)
  if (oldKey !== value) {
    await apikey.save(value);
    selectedGroup.clear();
    selectedList.clear();
  }
  return 1;
}

export async function updateList(value) {
  let oldList = get(selectedList)
  if (oldList !== value) {
    await selectedList.save(value);
    selectedGroup.clear();
  }
}

export async function updateGroup(value) {
  let oldGroup = get(selectedGroup)
  if (oldGroup !== value) {
    await selectedGroup.save(value);
  }
}
