<?php

class R_Daily_Events_Widget extends WP_Widget{
  /**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops           =   array( 
			'description'       =>  'Displays a random events of each day.',
		);
		parent::__construct( 'r_daily_events_widget', 'Event of the day', $widget_ops );
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
    // outputs the options form on admin
    $default            = [ 'title' => 'Event of the day' ];
    $instance           = wp_parse_args( (array) $instance, $default );

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: </label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
        name="<?php echo $this->get_field_name( 'title' ); ?>"
        value="<?php echo esc_attr( $instance['title'] ); ?>">
    </p>
    <?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
    // processes widget options to be saved
    $instance               = [];
    $instance['title']      = strip_tags($new_instance['title']);
    return $instance;
  }
  
  /**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
    // outputs the content of the widget
    extract( $args );
    extract( $instance );

    $title            = apply_filters( 'widget_title', $title );

    echo $before_widget;
    echo $before_title . $title . $after_title;

    $event_id        = get_transient( 'r_daily_event' );

    if( !$event_id ){
      $event_id      = r_get_random_event();

      set_transient(
        'r_daily_event',
        $event_id,
        DAY_IN_SECONDS
      );
    }

    ?>
    <div class="portfolio-image">
      <a href="<?php echo get_permalink( $event_id ); ?>">
        <?php echo get_the_post_thumbnail( $event_id, 'thumbnail' ); ?>
      </a>
    </div>
    <div class="portfolio-desc center nobottompadding">
      <h3><a href="<?php echo get_permalink( $event_id ); ?>">
        <?php echo get_the_title( $event_id ); ?>
      </a></h3>
    </div>
    <?php

    echo $after_widget;
	}
}