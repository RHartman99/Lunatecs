<?php

// Pages Covered: Blog Posts

get_header();
$context = Timber::context();
$context['post'] = new Timber\Post();
Timber::render('single.twig', $context);
get_footer();
