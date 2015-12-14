<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_banners
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="col-xs-12 col-lg-3 col-sm-6">
    <div class="box-enquete box-padrao <?php echo $moduleclass_sfx ?>">
        <h2 class="titulo"><?php echo $module->title ?></h2>

        <p class="pergunta"><?php echo $poll->title ?></p>

        <form action="<?php echo JRoute::_('index.php?option=com_polls&task=save') ?>" method="post">

            <?php foreach ($poll->answers as $k => $answer): ?>
                <div class="radio item<?php echo (($k % 2) == 2) ? 2 : 1 ?>">
                    <label>
                        <input type="radio" name="answer" id="answer-<?php echo $answer->polls_answer_id ?>" value="<?php echo $answer->polls_answer_id ?>">
                        <?php echo $answer->title ?>
                    </label>
                </div>
            <?php endforeach ?>

            <input type="hidden" name="return" value="<?php echo base64_encode(JUri::current()) ?>">
            <input type="submit" class="bt-p" value="Enviar Resposta"/>

        </form>
    </div>
</div>