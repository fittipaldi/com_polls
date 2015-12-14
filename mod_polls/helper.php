<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_banners
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_banners
 *
 * @package     Joomla.Site
 * @subpackage  mod_banners
 * @since       1.5
 */
class ModPollsHelper
{
    /**
     * Retrieve list of banners
     *
     * @param   \Joomla\Registry\Registry &$params module parameters
     *
     * @return  mixed
     */
    public static function &getPoll(&$params)
    {

        $poll_id = 1;

        /** @var  $db JDatabaseDriver */
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->qn('#__polls_items'));
        $query->where('state = 1');
        $query->where($db->qn('polls_item_id') . ' = ' . $poll_id);

        $db->setQuery($query);
        $poll = $db->loadObject();

        if ($poll) {
            $query = $db->getQuery(true);

            $query->select('*');
            $query->from($db->qn('#__polls_answers'));
            $query->where($db->qn('polls_item_id') . ' = ' . $poll_id);

            $db->setQuery($query);
            $poll->answers = $db->loadObjectList();

            return $poll;
        }

        return null;
    }

}
