<?php
defined('_JEXEC') or die();

// Load FOF
require_once JPATH_LIBRARIES . DIRECTORY_SEPARATOR . 'fof' . DIRECTORY_SEPARATOR . 'include.php';

FOFDispatcher::getTmpInstance('com_polls')->dispatch();