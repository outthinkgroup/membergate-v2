export async function saveOverlay(content){
	const data = {
		content,
		postId:window.membergate.postId,
		membergate_action:"save_overlay",
	}
	const res = await fetch( window.membergate.url + "?action=membergate_settings",{
      method: "POST",
      credentials: "include",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
	}).then(res=>res.json())
	return res
}
