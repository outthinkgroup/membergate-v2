import type { FormSettingsType } from "./types";

export {};
declare global {
  interface Window {
    membergate: {
      url: string;
      pageList: Record<number, string>;
      completedSetup: boolean;
      settings: {
        postTypes: Record<
          string,
          { name: string; slug: string; protected: "true" | "false" | false }
        >;
      };
    };
    publicMembergate: {
      url: string;
    };
  }
}
