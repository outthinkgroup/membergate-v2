import {writable, derived, readable} from "svelte/store"

export const locations = {
	protectePostTypeSettings:{
		tab:"Protected Content",
		slug:"protected-posttype-settings",
		name:"Protected Content Settings",
	},
	formSettings:{
		tab:"Forms",
		slug:"form-settings",
		name:"Login and Register Form Settings",
	},
	displayBlockedContent:{
		tab:"Display",
		slug:"display-blocked-content-settings",
		name:"Display Blocked Content Settings",
	},
	emailServiceSettings:{
		tab:"Email Service",
		slug:"email-service-settings",
		name:"Email Service Settings",
	},
} as const

export const locationKeys = Object.values(locations).map(l=>l.slug)

export const currentLocation = createCurrentLocationStore()

function createCurrentLocationStore(){
	const {subscribe, update, set} = writable(locationKeys[1]); //TODO: change back to index 0
	return {
		subscribe,
		update,
		set,
		navigate: (locationKey: any)=>{
			if (!locationKeys.includes(locationKey)){
				console.log("Not a valid location", locationKey)
			}
			set(locationKey)
		}
	}
}




function camelCase(str:string){
	return str.split("-").map(( peice,index )=>{
		if(index == 0) return peice;
		const cap = peice.charAt(0).toUpperCase();
		return cap + peice.substring(1)
	}).join("")
}
