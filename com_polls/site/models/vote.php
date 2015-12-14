<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Newsfeeds Component Category Model
 *
 * @since  1.5
 */
class PollsModelVote extends JModelLegacy
{
    public function save($data)
    {
        JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'tables' . DIRECTORY_SEPARATOR . 'vote.php');
        $table =& JTable::getInstance('Vote', 'PollsTable');
        if ($data['polls_vote_id']) {
            $table->load((int)$data['polls_vote_id']);
        }
        if (!$table->bind($data)) {
            return false;
        }
        if (!$table->store()) {
            return false;
        }
        if ($table->polls_vote_id) {
            return $table->polls_vote_id;
        } else {
            return false;
        }

    }

}
