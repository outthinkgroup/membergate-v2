import { useSelect, useDispatch } from '@wordpress/data';
import { SnackbarList } from '@wordpress/components';

export default function Notices() {
	const notices = useSelect(
		( select ) =>
			select( 'core/notices' )
				.getNotices()
				.filter( ( notice ) => notice.type === 'snackbar' ),
		[]
	);
	const { removeNotice } = useDispatch( 'core/notices' );
	return (
		<SnackbarList
			className="fixed bottom-20 left-5"
			notices={ notices }
			onRemove={ removeNotice }
		/>
	);
}
