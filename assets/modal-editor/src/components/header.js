import { __ } from '@wordpress/i18n';

export default function Header({closeAction}) {
	return (
		<div
			className="wp-modal-editor-header"
			role="region"
			aria-label={ __( 'Standalone Editor top bar.', 'getdavesbe' ) }
			tabIndex="-1"
		>
			<h1 className="getdavesbe-header__title">
				{ "Modal Editor" }
			</h1>
			<button onClick={closeAction}>&times;</button>
		</div>
	);
}
