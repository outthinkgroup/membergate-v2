import { asUrlParams } from "../utils/utils";

export async function ajax(action: string, data: Record<string, any>) {
  const res = await fetch(window.membergate.url, {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: asUrlParams({
      action: "mg_admin_endpoint",
      mg_action: action,
      ...data,
    }),
  }).then((res) => res.json());
  return res;
}

export async function jsonAjax(action: string, data: Record<string, any>) {
	data.membergate_action = action
  const res = await fetch(
    `${window.membergate.url}?action=membergate_settings`,
    {
      method: "POST",
      credentials: "include",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    }
  ).then((res) => res.json());
  return res;
}
