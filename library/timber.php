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
    $context['main_menu'] = new Timber\Menu('main-menu');
    $context['sidebar_menu'] = new Timber\Menu('sidebar-menu');


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
