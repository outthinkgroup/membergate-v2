
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
