<?php

namespace RPFM\Models;

use RPFM\Utils\SingletonTrait;

/**
 * User Role Model
 *
 * @method static UserRoleModel get_instance()
 */
class UserRoleModel {
    use SingletonTrait;

    const OPTION_NAME = 'rpfm_user_role_settings';

    // TODO: change variable name to be more meaning in db ( when initialize )
    const DEFAULT = [];

    public static function find_all() {
        $default_settings = self::DEFAULT;
        $settings         = get_option( self::OPTION_NAME, [] );
        if ( ! is_array( $settings ) ) {
            return $default_settings;
        }
        return wp_parse_args( $settings, $default_settings );
    }

    public static function update( $settings ) {
        $settings_option = get_option( self::OPTION_NAME );
        if ( ! empty( $settings ) && is_array( $settings ) ) {
            update_option( self::OPTION_NAME, wp_parse_args( $settings, $settings_option ) );
        }
    }

    public static function delete() {
        delete_option( self::OPTION_NAME );
    }
}
