<?php

if (class_exists('ACF')) {
  function hook_header_codes()
  {
    if (have_rows('schema_codes')) :
      while (have_rows('schema_codes')) : the_row();
        echo get_sub_field('single_schema');
      endwhile;
    endif;
  }

  function global_hook_header_codes()
  {
    if (is_archive() || is_home() || is_page('blog')) {
      if (have_rows('global_schema_schema_codes', get_option('page_for_posts'))) {
        while (have_rows('global_schema_schema_codes', get_option('page_for_posts'))) : the_row();
          echo get_sub_field('single_schema');
        endwhile;
      }
    } else {
      if (have_rows('global_schema_schema_codes', 'option')) :
        while (have_rows('global_schema_schema_codes', 'option')) : the_row();
          echo get_sub_field('single_schema');
        endwhile;
      endif;
    }
  }

  add_action('wp_head', 'hook_header_codes');
  add_action('wp_head', 'global_hook_header_codes');

  if (function_exists('acf_add_options_page')) {
    $lunatecs = acf_add_options_page(array(
      'page_title' => 'Lunatecs',
      'menu_title' => 'Lunatecs',
      'menu_slug' => 'lunatecs',
      'capability' => 'edit_posts',
      'icon_url' => nextlevel_get_asset('/images/lunatecs.png'),
      'redirect' => false,
      'show_in_graphql' => true,
      'graphql_single_name' => 'lunatecs',
      'graphql_plural_name' => 'lunatecs',
    ));

    acf_add_options_sub_page(array(
      'page_title'   => 'Social Media',
      'menu_title'   => 'Social Media',
      'parent_slug'   => $lunatecs['menu_slug'],
    ));

    acf_add_options_sub_page(array(
      'page_title'   => 'Contact Info',
      'menu_title'   => 'Contact Info',
      'parent_slug'   => $lunatecs['menu_slug'],
    ));

    acf_add_options_sub_page(array(
      'page_title'   => 'Front Hero',
      'menu_title'   => 'Front Hero',
      'parent_slug'   => $lunatecs['menu_slug'],
    ));

    acf_add_options_sub_page(array(
      'page_title'   => 'Overview',
      'menu_title'   => 'Overview',
      'parent_slug'   => $lunatecs['menu_slug'],
    ));

    acf_add_options_sub_page(array(
      'page_title'   => 'Sponsors',
      'menu_title'   => 'Sponsors',
      'parent_slug'   => $lunatecs['menu_slug'],
    ));
    acf_add_options_sub_page(array(
      'page_title'   => 'Interested Banner',
      'menu_title'   => 'Interested Banner',
      'parent_slug'   => $lunatecs['menu_slug'],
    ));
  }

  function nextlevel_acf_blocks()
  {
    if (function_exists('acf_register_block')) {
      acf_register_block(array(
        'name'            => '',
        'title'           => __(''),
        'description'     => __(''),
        'render_callback' => '',
        'icon'            => 'admin-site-alt2',
      ));
    }
  }
  add_action('acf/init', 'nextlevel_acf_blocks');

  function nextlevel_block_editor_style()
  {
    if (is_admin()) {
      wp_enqueue_style(
        'custom-block',
        get_template_directory_uri() . '/dist/custom-blocks.css'
      );
    }
  }
  add_action('enqueue_block_assets', 'nextlevel_block_editor_style');

  function featured_news_callback($block, $content = '', $is_preview = false)
  {
    $context = Timber::context();
    $context['block'] = $block;
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;
    Timber::render('blocks/BLOCK-NAME.twig', $context);
  }

  // Sidebar ACF select
  if (function_exists('acf_add_local_field_group')) :

    $menus = wp_get_nav_menus();
    $menuNames = [];
    $menuNames[0] = 'default';
    for ($i = 0; $i < count($menus); $i++) {
      $menuNames[$i + 1] = $menus[$i]->name;
    }
    $secondaryMenuNames = $menuNames;
    $secondaryMenuNames[0] = 'none';

    acf_add_local_field_group(array(
      'key' => 'group_5e3ada1e20ddd',
      'title' => 'Sidebars',
      'fields' => array(
        array(
          'key' => 'field_5e3ada32b37f7',
          'label' => 'Sidebar 1',
          'name' => 'sidebar_1',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => $menuNames,
          'default_value' => array(
            0 => 'default',
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
        array(
          'key' => 'field_5e3b04becc481',
          'label' => 'Sidebar 2',
          'name' => 'sidebar_2',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => $secondaryMenuNames,
          'default_value' => array(
            0 => 'none',
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
        array(
          'key' => 'field_5e67e359a9e61',
          'label' => 'Sidebar 3',
          'name' => 'sidebar_3',
          'type' => 'select',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => $secondaryMenuNames,
          'default_value' => array(
            0 => 'none',
          ),
          'allow_null' => 0,
          'multiple' => 0,
          'ui' => 0,
          'return_format' => 'value',
          'ajax' => 0,
          'placeholder' => '',
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'side',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    ));

    acf_add_local_field_group(array(
      'key' => 'group_5dc072e1026a9',
      'title' => 'Page Language',
      'fields' => array(
        array(
          'key' => 'field_5dc072e6061ca',
          'label' => 'Page Language',
          'name' => 'page_language',
          'type' => 'radio',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'en' => 'English',
            'sp' => 'Spanish',
          ),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => '',
          'layout' => 'vertical',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
          ),
        ),
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'post',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'side',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    ));

  endif;
}
