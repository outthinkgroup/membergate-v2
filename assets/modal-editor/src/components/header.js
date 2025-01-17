import { __ } from '@wordpress/i18n';

export default function Header({closeAction}) {
	return (
		<div
			className="pl-4 overlay-editor-header sticky top-[-1px] bg-white z-50 flex justify-between items-center border-b "
			role="region"
			aria-label={ __( 'Overlay Editor top bar.', 'membergate' ) }
			tabIndex="-1"
		>
			<h1 className="text-lg">
				{ "Overlay Editor" }
			</h1>
			<button
				className="h-full aspect-square leading-none text-2xl bg-transparent border-0 hover:bg-slate-100 w-12"
				onClick={closeAction}
			>
				&times;
			</button>
		</div>
	);
}
