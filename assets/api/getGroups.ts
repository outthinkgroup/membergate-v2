import { ajax } from "./utils";

/**
 * Gets all available lists / groups for the emsp
 */
export default async function getGroups() {
  const res = await ajax("get_groups", {});
  return res;
}
