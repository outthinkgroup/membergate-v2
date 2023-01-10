export { };
declare global {
  interface Window {
    membergate: {
      url: string;
			providers:Record<string, string>[];
			completedSetup:boolean,
			settings:{
				providerName?:string,
				apiKey?: string,
				listId?:string,
				groupId?:string,
				lists?:any[],
				groups:any[],
			}
    };
  }
}
