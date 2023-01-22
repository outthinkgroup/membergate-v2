export { };
declare global {
	interface Window {
		membergate: {
			url: string;
			providers: Record<string, string>[];
			pageList:Record<number,string>;
			completedSetup: boolean;
			settings: {
				emailService:{
					providerName?: string;
					apiKey?: string;
					listId?: string;
					groupId?: string;
					lists?: any[];
					groups: any[];
				};
				postTypes: Record<string,{name:string, slug:string, protected:"true"|"false"|false}>;
				formSettings: Record<string, string>;
				blockedContent: Record<string, any>;
			};
		};
	}
}
