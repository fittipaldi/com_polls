<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class PollsController extends JControllerLegacy
{
    public function save()
    {
        $input = JFactory::getApplication()->input;
        $model = $this->getModel('Vote', 'PollsModel');
        $return = base64_decode($input->getString('return'));

        $data = array();
        $data['polls_answer_id'] = $input->getInt('answer');
        $data['created_on'] = JFactory::getDate()->toSql();
        $data['created_by'] = JFactory::getUser()->id;

        if ($model->save($data)) {
            $this->setMessage(JText::_('Voto salvo com sucesso!'));
        } else {
            $this->setMessage(JText::_('Erro ao salvar voto!'));
        }

        $this->setRedirect(JRoute::_($return));

    }
}