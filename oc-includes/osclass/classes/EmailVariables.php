<?php

/*
 * Osclass - software for creating and publishing online classified advertising platforms
 * Maintained and supported by Mindstellar Community
 * https://github.com/mindstellar/Osclass
 * Copyright (c) 2021.  Mindstellar
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *                     GNU GENERAL PUBLIC LICENSE
 *                        Version 3, 29 June 2007
 *
 *  Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 *  Everyone is permitted to copy and distribute verbatim copies
 *  of this license document, but changing it is not allowed.
 *
 *  You should have received a copy of the GNU Affero General Public
 *  License along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * EmailVariables class
 *
 * @since      3.0
 * @package    Osclass
 * @subpackage classes
 * @author     Osclass
 */
class EmailVariables
{
    private static $instance;
    private $variables;

    public function __construct()
    {
        $this->variables = array();
        $this->init();
    }

    /**
     *  Initialize menu representation.
     */
    public function init()
    {
        $this->variables = array(
            '{USER_NAME}'                      => __('User name'),
            '{USER_EMAIL}'                     => __('User email'),
            '{VALIDATION_LINK}'                => __('Link for account validation.'),
            '{VALIDATION_URL}'                 => __('Url for account validation.'),
            '{ADS}'                            => __('List of listings, used when send alerts'),
            '{UNSUB_LINK}'                     => __('Unsubscribe link.'),
            '{WEB_URL}'                        => __('Site home page url.'),
            '{WEB_LINK}'                       => __('Site home page link.'),
            '{WEB_TITLE}'                      => __('Title of your site'),
            '{CURRENT_DATE}'                   => __('Current date'),
            '{HOUR}'                           => __('Hour'),
            '{IP_ADDRESS}'                     => __('User ip address'),
            '{COMMENT_AUTHOR}'                 => __('Comment author name'),
            '{COMMENT_EMAIL}'                  => __('Comment author email'),
            '{COMMENT_TITLE}'                  => __('Comment title'),
            '{COMMENT_TEXT}'                   => __('Comment text content'),
            '{COMMENT_BODY}'                   => __('Comment body'),
            '{ITEM_URL}'                       => __('Listing url'),
            '{ITEM_EXPIRATION_DATE}'           => __('Item expiration date'),
            '{ITEM_LINK}'                      => __('Listing list'),
            '{ITEM_TITLE}'                     => __('Listing title'),
            '{ITEM_ID}'                        => __('Listing id'),
            '{EDIT_LINK}'                      => __('Link for edit listing'),
            '{EDIT_URL}'                       => __('Url for edit listing'),
            '{DELETE_LINK}'                    => __('Delete listing link'),
            '{DELETE_URL}'                     => __('Delete listing url'),
            '{PASSWORD_LINK}'                  => __('Change user password link'),
            '{PASSWORD_URL}'                   => __('change user password url'),
            '{DATE_TIME}'                      => __('Date time'),
            '{FRIEND_NAME}'                    => __('Name of the friend who wants send'),
            '{FRIEND_EMAIL}'                   => __('Email of the friend who wants send'),
            '{COMMENT}'                        => __('Question about your listing'),
            '{CONTACT_NAME}'                   => __('Contact name'),
            '{USER_PHONE}'                     => __('User phone number'),
            '{ITEM_DESCRIPTION}'               => __('Listing description'),
            '{ITEM_DESCRIPTION_ALL_LANGUAGES}' => __('Listing description in all languages'),
            '{ITEM_PRICE}'                     => __('Listing price'),
            '{ITEM_COUNTRY}'                   => __('Listing country'),
            '{ITEM_REGION}'                    => __('Listing region'),
            '{ITEM_CITY}'                      => __('Listing city'),
            '{SELLER_NAME}'                    => __('Seller name'),
            '{SELLER_EMAIL}'                   => __('Seller email'),
            '{CONTACT_EMAIL}'                  => __('Contact name'),
        );
    }

    /**
     * @return \EmailVariables
     */
    public static function newInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Add new email variable and description
     *
     * @param $key
     * @param $description
     */
    public function add($key, $description)
    {
        $this->variables[$key] = $description;
    }

    /**
     * Remove email variable from the array
     *
     * @param $key
     */
    public function remove($key)
    {
        unset($this->variables[$key]);
    }

    /**
     *
     * @param $email
     *
     * @return bool|mixed
     */
    public function getVariables($email)
    {
        $array     = array();
        $variables = array(
            'email_alert_validation'                  => array(
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{VALIDATION_LINK}'
            ),
            'alert_email_hourly'                      => array(
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{ADS}',
                '{UNSUB_LINK}'
            ),
            'alert_email_daily'                       => array(
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{ADS}',
                '{UNSUB_LINK}'
            ),
            'alert_email_weekly'                      => array(
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{ADS}',
                '{UNSUB_LINK}'
            ),
            'alert_email_instant'                     => array(
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{ADS}',
                '{UNSUB_LINK}'
            ),
            'email_comment_validated'                 => array(
                '{COMMENT_AUTHOR}',
                '{COMMENT_EMAIL}',
                '{COMMENT_TITLE}',
                '{COMMENT_BODY}',
                '{ITEM_URL}',
                '{ITEM_LINK}',
                '{ITEM_TITLE}'
            ),
            'email_new_item_non_register_user'        => array(
                '{ITEM_ID}',
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{ITEM_TITLE}',
                '{ITEM_URL}',
                '{ITEM_LINK}',
                '{EDIT_LINK}',
                '{EDIT_URL}',
                '{DELETE_LINK}',
                '{DELETE_URL}'
            ),
            'email_user_forgot_password'              => array(
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{PASSWORD_LINK}',
                '{PASSWORD_URL}',
                '{DATE_TIME}'
            ),
            'email_user_registration'                 => array(
                '{USER_NAME}',
                '{USER_EMAIL}'
            ),
            'email_new_email'                         => array(
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{VALIDATION_LINK}',
                '{VALIDATION_URL}'
            ),
            'email_user_validation'                   => array(
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{VALIDATION_LINK}',
                '{VALIDATION_URL}'
            ),
            'email_send_friend'                       => array(
                '{FRIEND_NAME}',
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{FRIEND_EMAIL}',
                '{ITEM_TITLE}',
                '{COMMENT}',
                '{ITEM_URL}',
                '{ITEM_LINK}'
            ),
            'email_item_inquiry'                      => array(
                '{CONTACT_NAME}',
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{USER_PHONE}',
                '{ITEM_TITLE}',
                '{ITEM_URL}',
                '{ITEM_LINK}',
                '{COMMENT}'
            ),
            'email_new_comment_admin'                 => array(
                '{COMMENT_AUTHOR}',
                '{COMMENT_EMAIL}',
                '{COMMENT_TITLE}',
                '{COMMENT_TEXT}',
                '{ITEM_TITLE}',
                '{ITEM_ID}',
                '{ITEM_URL}',
                '{ITEM_LINK}'
            ),
            'email_item_validation'                   => array(
                '{ITEM_DESCRIPTION_ALL_LANGUAGES}',
                '{ITEM_DESCRIPTION}',
                '{ITEM_COUNTRY}',
                '{ITEM_PRICE}',
                '{ITEM_REGION}',
                '{ITEM_CITY}',
                '{ITEM_ID}',
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{ITEM_TITLE}',
                '{ITEM_URL}',
                '{ITEM_LINK}',
                '{VALIDATION_LINK}',
                '{VALIDATION_URL}'
            ),
            'email_admin_new_item'                    => array(
                '{EDIT_LINK}',
                '{EDIT_URL}',
                '{ITEM_DESCRIPTION_ALL_LANGUAGES}',
                '{ITEM_DESCRIPTION}',
                '{ITEM_COUNTRY}',
                '{ITEM_PRICE}',
                '{ITEM_REGION}',
                '{ITEM_CITY}',
                '{ITEM_ID}',
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{ITEM_TITLE}',
                '{ITEM_URL}',
                '{ITEM_LINK}',
                '{VALIDATION_LINK}',
                '{VALIDATION_URL}'
            ),
            'email_item_validation_non_register_user' => array(
                '{ITEM_DESCRIPTION_ALL_LANGUAGES}',
                '{ITEM_DESCRIPTION}',
                '{ITEM_COUNTRY}',
                '{ITEM_PRICE}',
                '{ITEM_REGION}',
                '{ITEM_CITY}',
                '{ITEM_ID}',
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{ITEM_TITLE}',
                '{ITEM_URL}',
                '{ITEM_LINK}',
                '{VALIDATION_LINK}',
                '{VALIDATION_URL}',
                '{EDIT_LINK}',
                '{EDIT_URL}',
                '{DELETE_LINK}',
                '{DELETE_URL}'
            ),
            'email_admin_new_user'                    => array(
                '{USER_NAME}',
                '{USER_EMAIL}'
            ),
            'email_contact_user'                      => array(
                '{CONTACT_NAME}',
                '{USER_NAME}',
                '{USER_EMAIL}',
                '{USER_PHONE}',
                '{COMMENT}'
            ),
            'email_new_comment_user'                  => array(
                '{COMMENT_AUTHOR}',
                '{COMMENT_EMAIL}',
                '{COMMENT_TITLE}',
                '{COMMENT_TEXT}',
                '{ITEM_TITLE}',
                '{ITEM_ID}',
                '{ITEM_URL}',
                '{ITEM_LINK}',
                '{SELLER_NAME}',
                '{SELLER_EMAIL}'
            ),
            'email_new_admin'                         => array(
                '{ADMIN_NAME}',
                '{USERNAME}',
                '{PASSWORD}',
                '{WEB_ADMIN_LINK}'
            ),
            'email_warn_expiration'                   => array(
                '{USER_NAME}',
                '{ITEM_TITLE}',
                '{ITEM_ID}',
                '{ITEM_EXPIRATION_DATE}',
                '{ITEM_URL}',
                '{ITEM_LINK}',
                '{SELLER_NAME}',
                '{SELLER_EMAIL}',
                '{CONTACT_NAME}',
                '{CONTACT_EMAIL}'
            )
        );

        if (isset($email['s_internal_name']) && isset($variables[$email['s_internal_name']])) {
            foreach ($variables[$email['s_internal_name']] as $word) {
                $array[$word] = $this->variables[$word];
            }
        }

        return osc_apply_filter('email_legend_words', $array, @$email['s_internal_name']);
    }

    /*
     * Empty the variables array
     */
    public function clear_menu()
    {
        $this->variables = array();
    }
}
