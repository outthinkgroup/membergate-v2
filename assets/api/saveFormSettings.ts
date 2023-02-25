import { jsonAjax } from "./utils";

export default async function saveFormSettings(
  settings: Record<string, string>
) {
  const res = await jsonAjax("save_membergate_form_settings", settings);
  return res;
}

