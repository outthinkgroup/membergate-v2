import { compose } from '@wordpress/compose';
import {SelectControl, ToggleControl, TextControl} from "@wordpress/components";
import { withSelect, withDispatch } from '@wordpress/data';
import { PluginSidebar, PluginSidebarMoreMenuItem } from "@wordpress/edit-post";

const sidebarOptions = [
	{
		value:"setCookie"
	},
]

function TestComp({meta, oldMeta, setMetaFieldValue}) {
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
				<div className="ast-sidebar-container components-panel__body is-opened" id="membergate_settings_metabox">

					<div className="ast-meta-settings-title" >
						<h4>Membergate Settings</h4>
					</div>

					
					<div className="ast-sidebar-layout-meta-wrap components-base-control__field">
						<ToggleControl checked={meta.membergate_should_set_cookie} label="Set Cookie on load?" onChange={(val)=>setMetaFieldValue(val, "membergate_should_set_cookie")} />
						{meta.membergate_should_set_cookie &&
							<>
								<TextControl label="Cookie Name" value={meta.membergate_cookie_name} onChange={(val)=>setMetaFieldValue(val, "membergate_cookie_name")} />
								<TextControl label="Cookie Value" value={meta.membergate_cookie_value} onChange={(val)=>setMetaFieldValue(val, "membergate_cookie_value")} />
							</>
						}
					</div>

				</div>
			</PluginSidebar>
		</>
	);
}

export default compose(
	withSelect( ( select ) => {
		const postMeta = select( 'core/editor' ).getEditedPostAttribute( 'meta' );
		const oldPostMeta = select( 'core/editor' ).getCurrentPostAttribute( 'meta' );
		return {
			meta: { ...oldPostMeta, ...postMeta },
			oldMeta: oldPostMeta,
		};
	} ),
	withDispatch( ( dispatch ) => ( {
		setMetaFieldValue: ( value, field ) => dispatch( 'core/editor' ).editPost(
			{ meta: { [ field ]: value } }
		),
	} ) ),
)( TestComp );
