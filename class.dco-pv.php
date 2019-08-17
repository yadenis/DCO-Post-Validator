<?php
defined('ABSPATH') or die;

class DCO_PV extends DCO_PV_Base {

    public function __construct() {
        add_action('init', array($this, 'init_hooks'));
    }

    public function init_hooks() {
        parent::init_hooks();

        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'), 10, 1);
        add_action('admin_notices', array($this, 'admin_notices'));
    }

    public function admin_scripts($hook) {
        global $post;

        //Activate validation only for new post screen and edit post screen and allow post types
        if (($hook == 'post-new.php' || $hook == 'post.php') && isset($this->post_types[$post->post_type])) {
            wp_enqueue_script('dco-post-validator', DCO_PV__PLUGIN_URL . 'js/dco-post-validator.js', array('jquery'));
            wp_localize_script('dco-post-validator', 'dcopv', $this->get_js_options($post->post_type));
        }
    }

    public function admin_notices() {
        ?>

        <div class="notice notice-error dco-pv-validation-error hidden">
            <p class="dco-pv-featured-error hidden"><?php _e('You need to set Featured Image!', 'dco-post-validator'); ?></p>
            <p class="dco-pv-title-error hidden"><?php _e('You need to set Title!', 'dco-post-validator'); ?></p>
            <p class="dco-pv-content-error hidden"><?php _e('You need to set Content!', 'dco-post-validator'); ?></p>
        </div>

        <?php
    }

    //Convert plugin options for JavaScript
    protected function get_js_options($post_type) {
        $js_options = array();
        foreach ($this->options as $k => $option) {
            if (strpos($k, $post_type . '_') !== false) {
                $k = str_replace($post_type . '_', '', $k);
                $js_options[$k] = $option;
            }
        }

        /**
         * Filters the plugin options for JavaScript.
         *
         * @param array  $js_options Plugin options for JavaScript.
         * @param string $post_type  Post type name.
         * @param array  $options    Plugin options.
         */
        return apply_filters('dco_pv_get_js_options', $js_options, $post_type, $this->options);
    }

}

$GLOBALS['dco_pv'] = new DCO_PV();
