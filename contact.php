<?php

/**
 * Template Name: Contact
 * Pages Covered: Contact Us
 */

get_header();
$context = Timber::context();
$context['post'] = new Timber\Post();
Timber::render('contact.twig', $context);
get_footer();
