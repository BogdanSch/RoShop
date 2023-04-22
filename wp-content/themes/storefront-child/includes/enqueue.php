<?php
function storefront_child_enqueue()
{
    wp_enqueue_style('style', get_stylesheet_uri());
}
function enqueue_parent_styles()
{
    wp_enqueue_style('parent-style', get_stylesheet_directory_uri() . '/style.css');
}