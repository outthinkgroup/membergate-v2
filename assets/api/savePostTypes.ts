import { ajax } from "./utils";

export default async function savePostTypes(key: string, value: boolean) {
  const res = await ajax("save_protected_post_types", { [key]: value });
  return res;
}
