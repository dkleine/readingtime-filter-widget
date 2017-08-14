<?php

// Add reading_time taxonomy
function rtf_create_readme() {
  register_taxonomy('reading_time', 'post', array(
      'label' => __('reading_time', 'textdomain'),
      'rewrite' => array('slug' => 'reading_time'),
      'hierarchical' => true,
  ));
}

add_action('init', 'rtf_create_readme', 0);

// Calculate the number of words for a post and add this to a custom field
function rtf_publish_post($post_id) {
  $content = apply_filters('the_content', get_post_field('post_content', $post_id));
  $num_words = str_word_count(strip_tags($content));

  $m = floor($num_words / 200);
  $s = floor($num_words % 200 / (200 / 60));
  if ($s >= 30) {
    $m = ($m + 1);
  }
  if ($m > 1) {
    $est = $m . ' min' . ($m == 1 ? '' : 's');
  } else {
    $est = '<1 min';
  }
  wp_set_object_terms($post_id, $est, 'reading_time');
}

add_action('save_post', 'rtf_publish_post');
