<?php

// Register and load the widget
function rtf_load_widget() {
  register_widget('rtf_widget');
}

add_action('widgets_init', 'rtf_load_widget');

// Creating the widget 
class rtf_widget extends WP_Widget {

  function __construct() {

    parent::__construct(
            'rtf_widget', __('Readingtime Filter', 'rtf_widget_domain'), array('description' => __('Widget to display posts filtered by the contents of a custom field.', 'rtf_widget_domain'),)
    );
  }

// Creating widget front-end
  public function widget($args, $instance) {

    $title = apply_filters('widget_title', $instance['title']);
    $field = apply_filters('field_title', $instance['field_title']);

// before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if (!empty($title))
      echo $args['before_title'] . $title . $args['after_title'];
    ?>
    <form name="search" action="<?php bloginfo('url'); ?>" method="get">
      <select name="category_name">
        <?php
        $categories = get_categories();
        foreach ($categories as $category) {
          echo '<option value="', $category->slug, '">', $category->name, "</option>\n";
        }
        ?>
      </select>
      <select name="reading_time">
        <?php
        $terms = get_terms(array(
            'taxonomy' => $field,
            'hide_empty' => false,
        ));
        foreach ($terms as $term) {
          echo '<option value="', $term->slug, '">', $term->name, "</option>\n";
        }
        ?>
      </select>
      <input type="submit" value="search" />
    </form>

    <?php
    echo $args['after_widget'];
  }

// Widget Backend 
  public function form($instance) {
    if (isset($instance['title'])) {
      $title = $instance['title'];
    } else {
      $title = __('New title', 'rtf_widget_domain');
    }
    if (isset($instance['field_title'])) {
      $field_title = $instance['field_title'];
    } else {
      $field_title = __('reading_time', 'rtf_widget_domain');
    }
// Widget admin form
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('field_title'); ?>"><?php _e('Custom Taxonomy:'); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id('field_title'); ?>" name="<?php echo $this->get_field_name('field_title'); ?>" type="text" value="<?php echo esc_attr($field_title); ?>" />
    </p>
    <?php
  }

// Updating widget replacing old instances with new
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
    $instance['field_title'] = (!empty($new_instance['field_title']) ) ? strip_tags($new_instance['field_title']) : '';

    return $instance;
  }

}
