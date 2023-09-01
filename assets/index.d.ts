import type {
  RuleSet,
  ConditionRuleT,
  ProtectMethodT,
  OverlaySettingsT,
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
        blocks: string;
        editorSettings: any;
        blockObjects?: any[];
        overlaySettings: OverlaySettingsT;
      };
    };
    publicMembergate: {
      url: string;
    };
  }
}
