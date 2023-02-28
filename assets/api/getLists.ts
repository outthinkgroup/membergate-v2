import { ajax } from "./utils";

/**
 * Gets all available lists / groups for the emsp
 */
export default async function getLists() {
  const res = await ajax("get_lists", {});
  return res;
}
