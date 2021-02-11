import block_icons from '../icons/index';
import './editor.scss';

const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { InspectorControls } = wp.editor;
const { SelectControl } = wp.components;
const { Component } = wp.element;

registerBlockType('udemy/latest-event', {
	title: __('Latest Event', 'event'),
	description: __('Provides a list of the latest events.', 'event'),
	category: 'common',
	icon: block_icons.calendar,
	keywords: [__('Date', 'latest event'), __('Time', 'latest event'), __('load', 'latest event')],
	supports: {
		html: false
	},
	attributes: {
		content: {
			type: 'array',
			source: 'children',
			selector: 'p',
		},
		title: {
			type: 'string',
			selector: 'h2'
		},
		link: {
			type: 'string',
			selector: 'a'
		},
		selectedEvent: {
			type: 'number',
			default: 0,
		},
	},

	edit: class MySelectEvents extends Component {
		static getInitialState(selectedEvent) {
			return {
				events: [],
				selectedEvent: selectedEvent,
				event: {},
			};
		}

		constructor() {
			super(...arguments);
			this.state = this.constructor.getInitialState(
				this.props.attributes.selectedEvent
			);
			// Bind so we can use 'this' inside the method.
			this.getOptions = this.getOptions.bind(this);
			this.getOptions();
		}

		/*
		** Loading Events
		*/

		getOptions() {
			// Extend and wp.api.collections.Events to load a custom event type
			const customEvent = wp.api.collections.Posts.extend({
				url: wpApiSettings.root + "wp/v2/event",

			});
			return new customEvent().fetch({ data: { per_page: 4 } }).then((events) => {
				if (events && 0 !== this.state.selectedEvent) {
					// If we have a selected Event, find that event and add it.
					const event = events.find((item) => {
						return item.id == this.state.selectedEvent;
					});
					this.setState({ event, events });
				} else {
					this.setState({ events });
				}
			});
		}

		render() {
			let options = [{ value: 0, label: __('Select an Event') }];
			let output = __('Loading Events');
			this.props.className += ' loading';
			if (this.state.events.length > 0) {
				const loading = __("We have %d events. Choose one.");
				output = loading.replace("%d", this.state.events.length);
				this.state.events.forEach((event) => {
					options.push({
						value: event.id,
						label: event.title.rendered,
						content: event.content.rendered,
						excerpt: event.excerpt.rendered,
						link: event.link
					});
					// output += event.title.rendered;
				});
			} else {
				output = __('No events found. Please create some first.');
			}
			// Checking if we have anything in the object
			if (this.state.event.hasOwnProperty('title')) {
				output = <div className="event">
					<a href={this.state.event.link}><h2 dangerouslySetInnerHTML={{ __html: this.state.event.title.rendered }}></h2></a>
					<p dangerouslySetInnerHTML={{ __html: this.state.event.excerpt.rendered }}></p>
				</div>;
				this.props.className += ' has-event';
			} else {
				this.props.className += ' no-event';
			}
			return (
				<div className="event">
					{options.map((option) => (
						<div>
							<a href={option["link"]}>
								<h2 dangerouslySetInnerHTML={{ __html: option["label"] }}></h2>
							</a>
							<p dangerouslySetInnerHTML={{ __html: option["excerpt"] }}></p>
						</div>
					))}
				</div>
			);
		}
	},

	save: function (props) {
		const  {events = []} = props.attributes
		const displayEvents = (events) => {
			
			return (
				events.map((event) => {
					return ({
						value: event.id,
						label: event.title.rendered,
						content: event.content.rendered,
						excerpt: event.excerpt.rendered,
						link: event.link
					})
				})
			);
		}

		return (
			<div className="event">
				{events.map((event) => (
					<div>
					<a href={event["link"]}>
						<h2 dangerouslySetInnerHTML={{ __html: event["label"] }}></h2>
					</a>
						<p>{ displayEvents(events)}</p>
        </div>
				))}
        
      </div>
			
		)
  }
});
