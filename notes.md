# Membergate

## Admin Settings

### List Providers
- [x] Finish List / Group Cache
- [x] bug with Settings list and group dropdown not being set?
- [x] only request from frontend new lists and groups if a dependency changes (api_key / list_id)
	- Create Inputs for each field that can invalidate others
		- [x] ListsSelect
		- [x] GroupsSelect
	- Subscribe to values that directly inpact the options (dependencies)
		- refetch inputs options when dependency change
- [ ] Add MailProvider Specific Form Settings for each provider in the Svelte app.
	- [ ] break up the store.
	- [ ] build component for each provider
	- [ ] add section foreach provider in server rendered settings

### Admin UI
- [ ] Add loading indicators
- [ ] Build Error message system for admin
- [ ] add "congrats" message after setup is complete
	- with instructions on where to update those settings
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
- [ ] implement Beaverbuilder Post Gallery Module ( seperate plugin )

### How to protect content

- [ ] Build Settings in Admin to set protected content
	- [ ] post type list
	- [ ] enable individual optin toggle?
- [ ] Build meta box to signal this post is protected

### How show signup form

- [ ] Build settings for choice of
	- [ ] Redirect to login page
	- [ ] Template Redirect - this option is seo friendly due to we can still output seo meta tags in header;
- [ ] Build Setting for Modal
- [ ] Build Signup form
- [ ] Build Gutenburg block for inline protected content

- [x] Test mailchimp integration 
	 - getting lists
	 - getting groups
	
## Provider Cache

- Need to implement Error Handling
	- Functions that could fail should return a NetworkResponse

