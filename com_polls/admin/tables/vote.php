<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Newsfeed Table class.
 *
 * @since  1.6
 */
class PollsTableVote extends JTable
{
    public $polls_vote_id = 0;

    public function __construct(&$db)
    {
        parent::__construct('#__polls_votes', 'polls_vote_id', $db);
    }

}
