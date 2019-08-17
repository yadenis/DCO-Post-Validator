<?php

defined('ABSPATH') or die;

class DCO_PV_Base {

    protected $options = array();
    protected $elements = array();
    protected $post_types = array();

    protected function init_hooks() {
        $this->get_elements();
        $this->get_post_types();
        $this->get_options();
    }

    protected function get_options() {
        $default = array();

        foreach ($this->post_types as $type_id => $type) {
            foreach ($this->elements as $k => $el) {
                $default[$type_id . '_' . $k] = '0';
            }
        }

        $options_from_db = get_option('dco_pv');

        /**
         * Filters the plugin options.
         *
         * @param array  $options         Plugin options.
         * @param array  $options_from_db Plugin options from database.
         * @param array  $default         Default plugin options.
         */
        $this->options = apply_filters('dco_pv_get_options', wp_parse_args($options_from_db, $default), $options_from_db, $default);
    }

    protected function get_elements() {
        $elements = array(
            'title' => __('Title', 'dco-post-validator'),
            'content' => __('Content', 'dco-post-validator'),
            'featured' => __('Featured Image', 'dco-post-validator')
        );

        /**
         * Filters the elements of post for validation.
         *
         * @param array $elements Elements of post for validation.
         */
        $this->elements = apply_filters('dco_pv_get_elements', $elements);
    }

    protected function get_post_types() {
        /**
         * Filters the ignored post types.
         *
         * @param array $ignored_post_types Ignored post types.
         */
        $ignored_post_types = apply_filters('dco_pv_ignored_post_types', array('attachment'));
        $post_types = array_diff_key(get_post_types(array('public' => true), 'objects'), array_flip($ignored_post_types));

        /**
         * Filters the post types for validations.
         *
         * @param array $post_types Post types for validations.
         */
        $this->post_types = apply_filters('dco_pv_get_post_types', $post_types);
    }

}
