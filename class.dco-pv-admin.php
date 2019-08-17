<?php
defined('ABSPATH') or die;

class DCO_PV_Admin extends DCO_PV_Base {

    //Magic method for render field
    public function __call($name, $arguments) {
        $name_array = explode('_', $name);
        if (count($name_array) < 2) {
            return false;
        }

        $option_name = $name_array[0] . '_' . $name_array[1];
        ?>
        <input type="hidden" name="dco_pv[<?php echo $option_name; ?>]" value="0">
        <input type="checkbox" name="dco_pv[<?php echo $option_name; ?>]" value="1" <?php checked($this->options[$option_name]) ?> <?php disabled(has_filter('dco_pv_get_options')) ?>>
        <?php
    }

    public function __construct() {
        add_action('init', array($this, 'init_hooks'));
    }

    public function init_hooks() {
        parent::init_hooks();

        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_menu', array($this, 'create_menu'));

        //Additional links on the plugin page
        add_filter('plugin_row_meta', array($this, 'register_plugin_links'), 10, 2);
    }

    public function register_plugin_links($links, $file) {
        if ($file == DCO_PV__PLUGIN_BASENAME) {
            $links[] = '<a href="https://github.com/Denis-co/DCO-Insert-Analytics-Code">' . __('GitHub', 'dco-post-validator') . '</a>';
        }

        return $links;
    }

    public function create_menu() {
        add_options_page(__('DCO Post Validator', 'dco-post-validator'), __('DCO Post Validator', 'dco-post-validator'), 'manage_options', 'dco-post-validator', array($this, 'render'));
    }

    public function register_settings() {
        register_setting('dco_pv', 'dco_pv');

        foreach ($this->post_types as $type_id => $type) {
            add_settings_section(
                    $type_id, $type->label, '', 'dco_pv'
            );

            foreach ($this->elements as $k => $el) {
                $key = $type_id . '_' . $k;
                add_settings_field(
                        $key, $el, array($this, $key . '_render'), 'dco_pv', $type_id
                );
            }
        }
    }

    function render() {
        ?>
        <div class="wrap">
            <h1><?php _e('DCO Post Validator', 'dco-post-validator'); ?></h1>
            <p><?php _e('You can specify required elements for each post type in list below.', 'dco-post-validator'); ?></p>
            <form action="options.php" method="post">
                <?php
                settings_fields('dco_pv');
                do_settings_sections('dco_pv');
                submit_button(null, 'primary', 'submit', true, disabled(has_filter('dco_pv_get_options'), true, false));
                ?>
            </form>
        </div>
        <?php
    }

}

$GLOBALS['dco_pv_admin'] = new DCO_PV_Admin();
