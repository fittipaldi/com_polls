<?php
/**
 * @package        contactus
 * @copyright    Copyright (c)2014 Nicholas K. Dionysopoulos / AkeebaBackup.com
 * @license        GNU General Public License version 2 or later
 */
defined('_JEXEC') or die();

class PollsControllerItem extends FOFController
{

    protected function onBeforeApply()
    {
        return $this->onBeforeSave();
    }

    protected function onBeforeSave()
    {
        $this->input->set('created_on', JFactory::getDate($this->input->getString('created_on'))->toSql());
        $this->input->set('alias', JFilterOutput::stringURLSafe($this->input->getString('alias')));
        return true;
    }

    protected function onAfterApply()
    {
        return $this->onAfterSave();
    }

    protected function onAfterSave()
    {
        if ($id = $this->input->getInt('id')) {

            $answers = $this->input->getString('answers');
            $answers_order = $this->input->getString('answers_order');
            $polls_answer_id = $this->input->getString('polls_answer_id');

            $model = $this->getThisModel()->getTmpInstance('Answers', 'PollsModel');
            $model->setState('polls_item_id', $id);
            $items = $model->getItemList();

            foreach ($answers as $k => $answer) {
                $model->save(array(
                    'title' => $answer,
                    'order' => (int)$answers_order[$k],
                    'created_by' => JFactory::getUser()->id,
                    'polls_item_id' => (int)$id,
                    'polls_answer_id' => (int)$polls_answer_id[$k],
                ));
            }
            foreach ($items as $i => $item) {
                foreach ($polls_answer_id as $answer_id) {
                    if ($item->polls_answer_id == $answer_id) {
                        unset($items[$i]);
                    }
                }
            }
            foreach ($items as $itemDelete) {
                $model->setId((int)$itemDelete->polls_answer_id);
                $model->delete();
            }

        }
        return true;
    }

    protected function onAfterRemove()
    {
        if ($cid = $this->input->getString('cid')) {

            $model = $this->getThisModel()->getTmpInstance('Answers', 'PollsModel');
            foreach ($cid as $id) {
                $model->setState('polls_item_id', $id);
                $items = $model->getItemList();

                foreach ($items as $item) {
                    $model->setId((int)$item->polls_answer_id);
                    $model->delete();
                }
            }

        }
        return true;
    }

}

