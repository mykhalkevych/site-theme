<?php

/*** Child Theme Function  ***/

function sparks_mikado_child_theme_enqueue_scripts() {

    $parent_style = 'sparks_mikado_default_style';
    wp_enqueue_style('sparks_mikado_icons', get_stylesheet_directory_uri() . '../assets/fonts/custom_icon.css', array($parent_style));
    wp_enqueue_style('sparks_mikado_child_style', get_stylesheet_directory_uri() . '/style.css', array($parent_style, 'sparks_mikado_modules', 'sparks_mikado_style_dynamic'));
}

add_action('wp_enqueue_scripts', 'sparks_mikado_child_theme_enqueue_scripts');

if (!function_exists('sparks_mikado_get_logo')) {
    /**
     * Loads logo HTML
     *
     * @param $slug
     */
    function sparks_mikado_get_logo($slug = '') {
        $id = sparks_mikado_get_page_id();

        if ($slug == 'sticky') {
            $logo_image = sparks_mikado_get_meta_field_intersect('logo_image_sticky', $id);
        } else {
            $logo_image = sparks_mikado_get_meta_field_intersect('logo_image', $id);
        }

        $logo_image_dark = sparks_mikado_get_meta_field_intersect('logo_image_dark', $id);
        $logo_image_light = sparks_mikado_get_meta_field_intersect('logo_image_light', $id);


        //get logo image dimensions and set style attribute for image link.
        $logo_dimensions = sparks_mikado_get_image_dimensions($logo_image);

        $logo_styles = '';
        $logo_dimensions_attr = array();
        if (is_array($logo_dimensions) && array_key_exists('height', $logo_dimensions)) {
            $logo_height = $logo_dimensions['height'];
            $logo_styles = 'height: ' . intval($logo_height) . 'px;'; //divided with 2 because of retina screens

            if (!empty($logo_dimensions['height']) && $logo_dimensions['width']) {
                $logo_dimensions_attr['height'] = $logo_dimensions['height'];
                $logo_dimensions_attr['width'] = $logo_dimensions['width'];
            }
        }

        $params = array(
            'logo_image' => $logo_image,
            'logo_image_dark' => $logo_image_dark,
            'logo_image_light' => $logo_image_light,
            'logo_styles' => $logo_styles,
            'logo_dimensions_attr' => $logo_dimensions_attr
        );

        sparks_mikado_get_module_template_part('templates/parts/logo', 'header', $slug, $params);
    }
}
