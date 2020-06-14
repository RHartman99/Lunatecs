<?php

/**
 * Template Name: Sitemap
 * Pages Covered: Sitemap
 */

get_header();
$context = Timber::context();
$context['post'] = new Timber\Post();
$context['sitemap'] = wp_list_pages(array(
  'exclude' => $post->ID,
  'title_li' => '',
  'echo' => false
));
Timber::render('sitemap.twig', $context);
get_footer();
