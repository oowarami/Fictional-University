import block_icons from '../icons/index';
import './editor.scss';

const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const {DatePicker,BlockControls, BlockAlignmentToolbar,AlignmentToolbar  } = wp.editor;


registerBlockType('udemy/event', {
	title: __('Event', 'event'),
	description: __('Provides a short summary of an event.', 'event'),
	category: 'common',
	icon: block_icons.event,
	keywords: [__('Date', 'event'), __('Time', 'event'), __('Party', 'event')],
	supports: {
		html: false
	},
	attributes: {
		content: { type: 'array', source: 'children', selector: 'p' },
		textAlignment: { type: 'string' },
		categories: { type: 'object' },
		selectedEvents: { type: 'string' },
		link: { type: 'string', selector: 'a' },
	},

	edit: function ({ attributes, setAttributes }) {

		function save_content(event) {
			// console.log(event.target.value)
			setAttributes({ content: event.target.value })
		}

		function save_date(date) {
			// console.log(date);
			const date_object = new Date(date);
			setAttributes({ date: date });
		};

		function updateCategory(e) {
			setAttributes({
				selectedCategory: e.target.value
			});
		}

		function updatePostsPerPage(e) {
			setAttributes({
				postPerPage: e.target.value
			})
		};

		if (!attributes.categories) {
			wp.apiFetch({
				url: '/wp-json/wp/v2/categories'
			}).then(categories => {
				setAttributes({
					categories: categories
				});
			});
		}

		if (!attributes.categories) {
			return 'Loading...';
		}

		if (attributes.categories && attributes.categories.length === 0) {
			return 'No categories found. Please add some!';
		}

		// console.log(attributes);

		return (
			<div>
				<h3> Other events you might be interested in</h3>
				<label>Category</label>
				<select onChange={updateCategory} value={attributes.selectedCategory}>
					{attributes.categories.map(category => {
						return (
							<option value={category.id} key={category.id}>
								{category.name}
							</option>
						);
					})}
				</select>
				<label>Posts Per Page</label>
				<input type="text" onBlur={updatePostsPerPage} value={attributes.postPerPage}/> 
				<hr/>
				<BlockControls>
					<BlockAlignmentToolbar
						value={attributes.block_alignment}
						onChange={(new_val) => {
							setAttributes({ block_alignment: new_val })
						}} />
					<AlignmentToolbar
						value={attributes.text_alignment}
						onChange={(new_val) => {
							setAttributes({ text_alignment: new_val });
						}} />
				</BlockControls>

				<textarea placeholder='Event Description'
					value={attributes.content}
					onChange={save_content}
					rows='5'
					cols='60' />

				<DatePicker onChange={save_date}
					current_date={typeof attributes.date !== 'undefined'
						? new Date(attributes.date)
						: new Date()} />
			</div>
		);

	},

	save: function ({attributes}) {
		return (
			null,
			<p>{attributes.content}</p>
		);
	}
});
