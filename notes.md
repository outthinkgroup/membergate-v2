# Membergate

- [ ] Finish List / Group Cache
	 - Need to abstract the fetching of lists and groups so we can use it in the ListProviderCache class
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

- [x] Test mailchimp integration 
	 - getting lists
	 - getting groups
- [ ] implement Protected Post types
	- using the protected items settings
- [ ] implement Sign up modal
- [ ] implement Gutenburg block for signup modal / protected button.
- [ ] implement Beaverbuilder Post Gallery Module ( seperate plugin )

	
## Provider Cache

- Need to implement Error Handling
	- Functions that could fail should return a NetworkResponse
