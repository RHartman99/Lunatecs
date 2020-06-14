<?php

// Pages Covered: Error Pages

get_header();
$context = Timber::context();
$context['post'] = new Timber\Post();
Timber::render('error.twig', $context);
get_footer();
