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
				list?:string,
				group?:string,
			}
    };
  }
}
