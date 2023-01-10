# Membergate

## Admin Settings

### List Providers
- [x] Finish List / Group Cache
- [ ] bug with Settings list and group dropdown not being set?
- [ ] only request from frontend new lists and groups if a dependency changes (api_key / list_id)

### Admin UI
- [ ] Add tabs to admin settings
	- [ ] tab for general list provider
	- [ ] tab for setting up a general sign up page
		- [ ] section or option for setting up modal
	- [ ] tab for getting shortcodes
	- [ ] tab for setting up protected items
		- [ ] post types
		- [ ] specific urls
- [ ] for each tab above
	- [ ] implement a Configuration settings class
	- [ ] implement Ajax Class

## Blocking Content
- [ ] implement Protected Post types
	- using the protected items settings
- [ ] implement Sign up modal
- [ ] implement Gutenburg block for signup modal / protected button.
- [ ] implement Beaverbuilder Post Gallery Module ( seperate plugin )

- [x] Test mailchimp integration 
	 - getting lists
	 - getting groups
	
## Provider Cache

- Need to implement Error Handling
	- Functions that could fail should return a NetworkResponse
