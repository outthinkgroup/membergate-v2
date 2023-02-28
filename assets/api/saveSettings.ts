import { ajax } from "./utils";

/**
 * Gets all available lists / groups for the emsp
 */
export default async function saveSettings(settings: {
  apikey?: string;
  providerName?: string;
  list_id?: string;
  group_id?: string;
}) {
  const res = await ajax("save_list_settings", settings);
  return res;
}
