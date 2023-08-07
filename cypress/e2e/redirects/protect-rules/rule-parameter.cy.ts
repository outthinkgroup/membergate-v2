import { runProtectRuleConfig, type ConfigType } from "cypress/support/utils"
import post_type_config from "../../../fixtures/rule-parameters/post_type.json"	
import post_config from "../../../fixtures/rule-parameters/post.json"	
import page_config from  "../../../fixtures/rule-parameters/page.json"	
import category_config from "../../../fixtures/rule-parameters/category.json"
import tag_config from "../../../fixtures/rule-parameters/tag.json";
import page_template_config from "../../../fixtures/rule-parameters/page_template.json";

describe("All Rule Parameters will protect based on Rule value", ()=>{
	it("Redirects correctly when protect parameter is post_type", ()=>{
		runProtectRuleConfig(post_type_config as ConfigType, "cypress/fixtures/rule-parameters/post_type.json")
	})

	it("Redirects correctly when protect parameter is post", ()=>{
		runProtectRuleConfig(post_config as ConfigType, "cypress/fixtures/rule-parameters/post.json")
	})

	it("Redirects correctly when protect parameter is page", ()=>{
		runProtectRuleConfig(page_config as ConfigType, "cypress/fixtures/rule-parameters/page.json")
	})

	it("Redirects correctly when protect parameter is category", ()=>{
		runProtectRuleConfig(category_config as ConfigType, "cypress/fixtures/rule-parameters/category.json")
	})
	it("Redirects correctly when protect parameter is tag", ()=>{
		runProtectRuleConfig(tag_config as ConfigType, "cypress/fixtures/rule-parameters/tag.json")
	})
	it("Redirects correctly when protect parameter is page_template", ()=>{
		runProtectRuleConfig(page_template_config as ConfigType, "cypress/fixtures/rule-parameters/page_template.json")
	})
})
