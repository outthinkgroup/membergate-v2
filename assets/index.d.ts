export { };
declare global {
	interface Window {
		membergate: {
			url: string;
			providers: Record<string, string>[];
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
				postTypes: {
					name: string;
					isProtected: boolean;
					slug: string;
				}[];
				forms: Record<string, any>;
				blockedContent: Record<string, any>;
			};
		};
	}
}
