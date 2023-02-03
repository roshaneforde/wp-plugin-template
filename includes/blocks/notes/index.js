/**
 * Internal block libraries
 */
const { registerBlockType } = wp.blocks;

/**
 * Custom block components
 */
import Note from './Note';

/**
 * Register Block.
 */
registerBlockType( 'wpclear/notes', {
	title: 'Notes',
	description: 'Display the list of notes.',
	category: 'wpclear-blocks',
	icon: 'media-text',
	keywords: [
		'notes',
	],
	attributes: {
		id: {
			type: 'string',
		},
		align: {
			type: 'string',
			default: 'full',
		}
	},
	// getEditWrapperProps() {
	// 	return {
	// 		'data-align': 'full',
	// 	};
	// },
	edit: ( props ) => {
		const {
			attributes,
			className, 
			setAttributes,
		} = props;

		if ( ! attributes.id ) {
			let id = String.prototype.concat( ...new Set( Math.random().toString( 36 ).substring( 7 ).replace( /[0-9]/g, '' ) ) );

			setAttributes( { id } );
		}

		return (
			<div className={ className + ' wp-block-wpclear-notes-block' } key='notes-block-view'>       
				<div className="wpclear-notes-container">
					{
						wpclear.notes.map( note => {
							return (
								<Note 
									key={ note.id } 
									id={ note.id } 
									title={ note.title } 
									category={ note.category } 
									content={ note.content } 
									pinned={ note.pinned }
								/>
							)
						} )
					}
				</div>
			</div>
		);
	},
	save: () => null,
} );
