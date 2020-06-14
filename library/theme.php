<?php

function nextlevel_get_local($asset = '')
{
  return get_stylesheet_directory_uri() . '/dist' . '/' . $asset;
}

function nextlevel_get_cloud($asset = '')
{
  return 'https://res.cloudinary.com/nextlevel/image/fetch/f_auto,q_auto/' . nextlevel_get_local($asset);
}

function nextlevel_check_domain($haystack, $needles)
{
  foreach ($needles as $needle) {
    if (($res = stripos($haystack, $needle)) !== false) {
      return $res;
    }
  }
  return false;
}

function nextlevel_get_asset($asset = '')
{
  $whitelist = array(
    '.local',
    '.test',
  );

  if (is_admin()) {
    $current_url = $_SERVER['HTTP_REFERER'];
  } else {
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request));
  }

  if (nextlevel_check_domain($current_url, $whitelist)) {
    return nextlevel_get_local($asset);
  } else {
    return nextlevel_get_cloud($asset);
  }
}

function nextlevel_clean_iframe($iframe = '')
{
  $iframe = str_replace('<script src="https://player.vimeo.com/api/player.js"></script>', '', $iframe);
  $iframe = str_replace('" style', '&playsinline=0" style', $iframe);
  $iframe = str_replace('<iframe src="', '<iframe class="lazy" data-src="', $iframe);
  return $iframe;
}
/*
  Author:       Ryan Hartman   
  Date:         6/3/20
  Description:  Recursively finds the closest filled custom field on a page's family tree.
                E.g: Medical-Malpractice/Birth-Injury will inherit Medical-Malpractice's custom field if
                it does not have its own field set.
                Always call this after instantiating the Timber::Post object, since this relies on
                WordPress's querying.
                For instance, you cannot call this from timber.php to add to context, call it from
                the specific page template file, such as page.php.
*/
if (!function_exists('get_inherited_field')) {
  
  function get_inherited_field($field, $post_id = -1)
  {
    if ($post_id == -1)
      $post_id = get_the_ID();

    $value = get_field($field, $post_id);
    if (!$value || $value == '')
      if (get_post($post_id)->post_parent)
        return get_inherited_field($field, wp_get_post_parent_id($post_id));

    return $value;
  }
}

