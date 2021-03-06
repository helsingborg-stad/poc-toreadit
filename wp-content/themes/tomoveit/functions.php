<?php

/**
 * Initiate object.
 */
$ec_theme = new EC_Theme;

/**
 * Class EC_Theme
 */
class EC_Theme {
    public $text_domain;

    /**
     * Theme constructor.
     */
    public function __construct(){
        $this->text_domain = 'toreadit_theme';
        // Add actions:
        add_action('wp_enqueue_scripts', [&$this, 'load_plugin_scripts']);
        add_action('output_spritemaps', [&$this, 'output_plugin_spritemap']);
        add_action('init', [&$this, 'register_post_types']);

        /* if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Goals',
                'menu_title' => 'Goal',
            ]);
        } */
    }

    public function load_plugin_scripts() {
        wp_enqueue_script('theme', get_template_directory_uri() . '/dist/bundle.js', [], null, true);
    }

    public function output_plugin_spritemap() {
        include_once('dist/spritemap.svg');
    }


    public function register_post_types(){
        $taxonomies = [];

        foreach ($taxonomies as $name => $values) {
            register_taxonomy($name, $values['post_types'], $values['options']);
        }

        $post_types = [
            'activities' => [
                'labels' => [
                    'name'               => _x('Aktiviteter', 'post type general name', $this->text_domain),
                    'singular_name'      => _x('Aktivitet', 'post type singular name', $this->text_domain),
                    'menu_name'          => _x('Aktiviteter', 'admin menu', $this->text_domain),
                    'name_admin_bar'     => _x('Aktivitet', 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Lägg till', 'aktivitet', $this->text_domain),
                    'add_new_item'       => __('Lägg till aktivitet', $this->text_domain),
                    'new_item'           => __('Ny aktivitet', $this->text_domain),
                    'edit_item'          => __('Redigera aktivitet', $this->text_domain),
                    'view_item'          => __('Visa aktivitet', $this->text_domain),
                    'all_items'          => __('Alla aktiviteter', $this->text_domain),
                    'search_items'       => __('Sök aktivitet', $this->text_domain),
                    'parent_item_colon'  => __('Förälder:', $this->text_domain),
                    'not_found'          => __('Inga aktiviteter hittades.', $this->text_domain),
                    'not_found_in_trash' => __('Inga aktiviteter hittades i papperskorgen.', $this->text_domain)
                ],
                'public'                 => false,
                'publicly_queryable'     => true,
                'show_ui'                => true,
                'show_in_menu'           => true,
                'query_var'              => true,
                'has_archive'            => false,
                'hierarchical'           => false,
                'menu_position'          => null,
                'menu_icon'              => 'dashicons-hammer',
                'supports'               => [ 'title', 'editor', 'thumbnail' ],
            ],
            'review_visitor' => [
                'labels' => [
                    'name'               => _x('Recension / Besök', 'post type general name', $this->text_domain),
                    'singular_name'      => _x('Recension / Besök', 'post type singular name', $this->text_domain),
                    'menu_name'          => _x('Recension / Besök', 'admin menu', $this->text_domain),
                    'name_admin_bar'     => _x('Recension / Besök', 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Lägg till', 'recension / besök', $this->text_domain),
                    'add_new_item'       => __('Lägg till recension / besök', $this->text_domain),
                    'new_item'           => __('Ny recension / besök', $this->text_domain),
                    'edit_item'          => __('Redigera recension / besök', $this->text_domain),
                    'view_item'          => __('Visa recension / besök', $this->text_domain),
                    'all_items'          => __('Alla recension / besök', $this->text_domain),
                    'search_items'       => __('Sök recension / besök', $this->text_domain),
                    'parent_item_colon'  => __('Förälder:', $this->text_domain),
                    'not_found'          => __('Inga recension / besök hittades.', $this->text_domain),
                    'not_found_in_trash' => __('Inga recension / besök hittades i papperskorgen.', $this->text_domain)
                ],
                'public'                 => false,
                'publicly_queryable'     => true,
                'show_ui'                => true,
                'show_in_menu'           => true,
                'query_var'              => true,
                'has_archive'            => false,
                'hierarchical'           => false,
                'menu_position'          => null,
                'menu_icon'              => 'dashicons-admin-multisite',
                'supports'               => [ 'title', 'editor', 'thumbnail' ],
            ],
            'students' => [
                'labels' => [
                    'name'               => _x('Elever', 'post type general name', $this->text_domain),
                    'singular_name'      => _x('Elev', 'post type singular name', $this->text_domain),
                    'menu_name'          => _x('Elever', 'admin menu', $this->text_domain),
                    'name_admin_bar'     => _x('Elev', 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Lägg till', 'elev', $this->text_domain),
                    'add_new_item'       => __('Lägg till elev', $this->text_domain),
                    'new_item'           => __('Ny elev', $this->text_domain),
                    'edit_item'          => __('Redigera elev', $this->text_domain),
                    'view_item'          => __('Visa elev', $this->text_domain),
                    'all_items'          => __('Alla elever', $this->text_domain),
                    'search_items'       => __('Sök elev', $this->text_domain),
                    'parent_item_colon'  => __('Förälder:', $this->text_domain),
                    'not_found'          => __('Inga elever hittades.', $this->text_domain),
                    'not_found_in_trash' => __('Inga elever hittades i papperskorgen.', $this->text_domain)
                ],
                'public'                 => false,
                'publicly_queryable'     => true,
                'show_ui'                => true,
                'show_in_menu'           => true,
                'query_var'              => true,
                'has_archive'            => false,
                'hierarchical'           => false,
                'menu_position'          => null,
                'menu_icon'              => 'dashicons-universal-access',
                'supports'               => [ 'title', 'editor', 'thumbnail' ],
            ],
            'texts' => [
                'labels' => [
                    'name'               => _x('Texter', 'post type general name', $this->text_domain),
                    'singular_name'      => _x('Texter', 'post type singular name', $this->text_domain),
                    'menu_name'          => _x('Texter', 'admin menu', $this->text_domain),
                    'name_admin_bar'     => _x('Texter', 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Lägg till', 'text', $this->text_domain),
                    'add_new_item'       => __('Lägg till text', $this->text_domain),
                    'new_item'           => __('Ny text', $this->text_domain),
                    'edit_item'          => __('Redigera text', $this->text_domain),
                    'view_item'          => __('Visa texter', $this->text_domain),
                    'all_items'          => __('Alla texter', $this->text_domain),
                    'search_items'       => __('Sök texter', $this->text_domain),
                    'parent_item_colon'  => __('Förälder:', $this->text_domain),
                    'not_found'          => __('Inga texter hittades.', $this->text_domain),
                    'not_found_in_trash' => __('Inga texter hittades i papperskorgen.', $this->text_domain)
                ],
                'public'                 => false,
                'publicly_queryable'     => true,
                'show_ui'                => true,
                'show_in_menu'           => true,
                'query_var'              => true,
                'has_archive'            => false,
                'hierarchical'           => false,
                'menu_position'          => null,
                'menu_icon'              => 'dashicons-editor-aligncenter',
                'supports'               => [ 'title', 'editor', 'thumbnail' ],
            ],
        ];

        foreach ($post_types as $name => $options){
            register_post_type($name, $options);
        }
    }
}
