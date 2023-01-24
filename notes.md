# Membergate

## MVP
- [x] Create Class for forms
	- [x] Change form rendering class from singleton to a Configuration class
	- [x] Add to all subscribers rendering forms
- [x] split form from additional markup (title, description)
- [x] Create shortcode for just form with option of adding title and description
- [x] Create Page Options for form
- [x] Options for designating redirect page
- [x] Options for setting overriding content or redirect
- [x] Options for form title and description
- [x] Options for Modal on link clicks
- [x] Create Modal Markup
- [x] Make Modal work
- [ ] Error Reporting show USER
- [x] Build Meta Box

- [ ] Create a shortcode Tab
- [ ] Provide a way to only login not register
	-	This should go on form settings
	- Need to add method to EMSProvider interface for just get_subscriber 
		-	Just returns bool

- [ ] Update all ajax calls from form input to use json
	- `json_decode(file_get_contents("php://input"));` works
		-	Not sure why it didnt before

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
	- [ ] Add merge fields if client supports it

### Admin UI
- [ ] Add loading indicators
- [ ] Build Error message system for admin
- [ ] add "congrats" message after setup is complete
	- with instructions on where to update those settings
- [x] Add tabs to admin settings
	- [ ] tab for general list provider
	- [x] tab for setting up a general sign up page
		- [x] section or option for setting up modal
	- [ ] tab for getting shortcodes
	- [x] tab for setting up protected items
		- [x] post types
		- [x] specific urls
- [ ] for each tab above
	- [x] implement a Configuration settings class
	- [ ] implement Ajax Class

## Blocking Content
- [x] implement Protected Post types
	- using the protected items settings
- [ ] implement Beaverbuilder Post Gallery Module ( seperate plugin )

### How to protect content

- [x] Build Settings in Admin to set protected content
	- [x] post type list
	- [x] enable individual optin toggle?
- [x] Build meta box to signal this post is protected

### How show signup form

- [x] Build settings for choice of
	- [x] Redirect to login page
	- [x] Template Redirect - this option is seo friendly due to we can still output seo meta tags in header;
- [x] Build Setting for Modal
- [x] Build Signup form
- [x] Build Gutenburg block for inline protected content

## Merge Fields
- Any fields submitted will be checked against merge field settings if it exists
- will use it if it does.

- [x] Test mailchimp integration 
	 - getting lists
	 - getting groups
	
## Provider Cache

- Need to implement Error Handling
	- Functions that could fail should return a NetworkResponse

