import type {
  RuleSet,
  ConditionRuleT,
  ProtectMethodT,
  OverlaySettingsT,
	OverlayOptionT,
} from "./lib/RuleEditor/ruleTypes";
import type { FormSettingsType } from "./types";

export {};
declare global {
  interface Window {
    membergate: {
      url: string;
      postId: number;
      title: string;
      Rules: {
        initialRuleValueOptionStore: RuleValueOptionsStoreT;
        ruleList: RuleSet;
        ruleCondition: ConditionRuleT;
        protectMethod: ProtectMethodT;
      };
      OverlayEditor: {
				overlays: OverlayOptionT[];
      };
    };
    publicMembergate: {
      url: string;
    };
  }
}
