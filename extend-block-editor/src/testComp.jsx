import { PluginSidebar, PluginSidebarMoreMenuItem } from "@wordpress/edit-post";

export function TestComp() {
	return (
		<>
			<PluginSidebarMoreMenuItem target="test-meta-panel">
				hi
			</PluginSidebarMoreMenuItem>

			<PluginSidebar
				isPinnable={true}
				icon={() => (
					<svg
						className="ast-mobile-svg ast-menu2-svg"
						fill="currentColor"
						version="1.1"
						xmlns="http://www.w3.org/2000/svg"
						width="24"
						height="28"
						viewBox="0 0 24 28"
					>
						<path d="M24 21v2c0 0.547-0.453 1-1 1h-22c-0.547 0-1-0.453-1-1v-2c0-0.547 0.453-1 1-1h22c0.547 0 1 0.453 1 1zM24 13v2c0 0.547-0.453 1-1 1h-22c-0.547 0-1-0.453-1-1v-2c0-0.547 0.453-1 1-1h22c0.547 0 1 0.453 1 1zM24 5v2c0 0.547-0.453 1-1 1h-22c-0.547 0-1-0.453-1-1v-2c0-0.547 0.453-1 1-1h22c0.547 0 1 0.453 1 1z"></path>
					</svg>
				)}
				name="test-meta-panel"
				title={"TEST"}
			>
				hi
			</PluginSidebar>
		</>
	);
}
