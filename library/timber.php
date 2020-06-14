<?php

Timber::$dirname = array('templates');
Timber::$autoescape = false;

class NextLevelSite extends Timber\Site
{
  public function __construct()
  {
    add_filter('timber/context', array($this, 'add_to_context'));
    add_filter('timber/twig', array($this, 'add_to_twig'));
    add_action('after_setup_theme', array($this, 'theme_supports'));
    parent::__construct();
  }

  public function add_to_context($context)
  {
    // $context['main_menu'] = new Timber\Menu('main-menu');
    // $context['sidebar_menu'] = new Timber\Menu('sidebar-menu');
    $context['location_menu'] = new Timber\Menu('location-menu');

    $fieldMenu = get_field_object('main_menu');
    $valueMenu = get_field('main_menu');
    $context['main_menu'] = $fieldMenu['choices'][$valueMenu];
    // Gets Names of Sidebars
    $field1 = get_field_object('sidebar_1');
    $value1 = get_field('sidebar_1');
    $context['label1'] = $field1['choices'][$value1];

    $field2 = get_field_object('sidebar_2');
    $value2 = get_field('sidebar_2');
    $context['label2'] = $field2['choices'][$value2];

    $field3 = get_field_object('sidebar_3');
    $value3 = get_field('sidebar_3');
    $context['label3'] = $field3['choices'][$value3];

    // Old pages will not have values for these
    // Sets null values to defaults
    if ($context['main_menu'] == 'default' || $context['main_menu'] == '') {
      if (get_field('page_language') == 'sp') {
        // Put the name of what you want the default Spanish main menu to be
        $context['main_menu'] = 'Main Menu - Spanish';
      } else {
        $context['main_menu'] = 'Main Menu';
      }
    }
    // Loads main menu
    $context['main_menu'] = new Timber\Menu($context['main_menu']);

    if ($context['label1'] == 'default' || $context['label1'] == '') {
      // Put the name of what you want the default sidebar to be
      if (get_field('page_language') == 'sp') {
        // Put the name of what you want the default Spanish main menu to be
        $context['label1'] = 'Servicios Legales';
      } else {
        $context['label1'] = 'Legal Services';
      }
    }
    // Loads first sidebar
    $context['sidebar_first'] = new Timber\Menu($context['label1']);

    if ($context['label2'] == 'none' || $context['label2'] == '') {
      $context['label2'] = 'none';
    } else {
      // Loads second sidebar
      $context['sidebar_second'] = new Timber\Menu($context['label2']);
    }
    if ($context['label3'] == 'none' || $context['label3'] == '') {
      $context['label3'] = 'none';
    } else {
      // Loads third sidebar
      $context['sidebar_third'] = new Timber\Menu($context['label3']);
    }

    $context['categories'] = get_categories(array(
      'orderby' => 'name',
      'order'   => 'ASC',
      'exclude' => '1',
      'hide_empty' => '1'
    ));

    $context['site_logo'] = nextlevel_get_asset('images/nextlevel.png');
    $context['site_logo_svg'] = nextlevel_get_asset('images/lunatecs.svg');
    $context['cloudinary'] = 'https://res.cloudinary.com/nextlevel/image/fetch/f_auto,q_auto/';
    
    $d = new RecursiveDirectoryIterator(get_stylesheet_directory() . '/dist/images');
    foreach (new RecursiveIteratorIterator($d) as $file) {
      $fn = preg_replace('/\.(jpg|png|gif)$/', '', $file->getFilename());
      $fn = preg_replace('/\-/', '_', $fn);
      $fp = nextlevel_get_asset('images/' . $file->getFilename());
      $context[$fn] = $fp;
    }

    if (class_exists('ACF')) {
      $fields = get_field_objects('option');
      if ($fields) {
        foreach ($fields as $field_name => $field) {
          $context[$field['name']] = $field['value'];
          if ($field['name'] == "firm_number") {
            $clean = preg_replace('/\D+/', '', $field['value']);
            $context['clean_firm_number'] = $clean;
          }
        }
      }
    }

    return $context;
  }

  public function add_to_twig($twig)
  {
    $twig->addExtension(new Twig_Extension_StringLoader());
    $twig->addFunction(new Timber\Twig_Function('nextlevel_get_asset', 'nextlevel_get_asset'));
    return $twig;
  }

  public function theme_supports()
  {
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
  }
}
new NextLevelSite();
