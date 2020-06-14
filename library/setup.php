<?php

function nextlevel_scripts()
{
  wp_deregister_script('jquery');
  wp_deregister_script('jquery-migrate');
  wp_enqueue_script('nextlevel-scripts', nextlevel_get_local('/main.js'));
  wp_enqueue_style('nextlevel-styles', nextlevel_get_local('/app.css'));
  wp_enqueue_style('nextlevel-blockstyles', nextlevel_get_local('custom-blocks.css'));
}
add_action('wp_enqueue_scripts', 'nextlevel_scripts');

function nextlevel_menus()
{
  register_nav_menus(
    array(
      'main-menu' => __('Main Menu'),
      'sidebar-menu' => __('Sidebar Menu'),
      'location-menu' => __('Location Menu')
    )
  );
}
add_action('init', 'nextlevel_menus');
