<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Displays options as a list of check boxes.
 * Multiselect may be forced to be true.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @see         JFormFieldCheckbox
 * @since       11.1
 */
class JFormFieldAnswers extends JFormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  11.1
     */
    protected $type = 'Answers';

    /**
     * Flag to tell the field to always be in multiple values mode.
     *
     * @var    boolean
     * @since  11.1
     */
    protected $forceMultiple = true;

    /**
     * The comma seprated list of checked checkboxes value.
     *
     * @var    mixed
     * @since  3.2
     */
    public $checkedOptions;

    /**
     * Method to get certain otherwise inaccessible properties from the form field object.
     *
     * @param   string $name The property name for which to the the value.
     *
     * @return  mixed  The property value or null.
     *
     * @since   3.2
     */
    public function __get($name)
    {
        switch ($name) {
            case 'forceMultiple':
            case 'checkedOptions':
                return $this->$name;
        }

        return parent::__get($name);
    }

    /**
     * Method to set certain otherwise inaccessible properties of the form field object.
     *
     * @param   string $name The property name for which to the the value.
     * @param   mixed $value The value of the property.
     *
     * @return  void
     *
     * @since   3.2
     */
    public function __set($name, $value)
    {
        switch ($name) {
            case 'checkedOptions':
                $this->checkedOptions = (string)$value;
                break;

            default:
                parent::__set($name, $value);
        }
    }

    /**
     * Method to attach a JForm object to the field.
     *
     * @param   SimpleXMLElement $element The SimpleXMLElement object representing the <field /> tag for the form field object.
     * @param   mixed $value The form field value to validate.
     * @param   string $group The field name group control value. This acts as as an array container for the field.
     *                                      For example if the field has name="foo" and the group value is set to "bar" then the
     *                                      full field name would end up being "bar[foo]".
     *
     * @return  boolean  True on success.
     *
     * @see     JFormField::setup()
     * @since   3.2
     */
    public function setup(SimpleXMLElement $element, $value, $group = null)
    {
        $return = parent::setup($element, $value, $group);

        if ($return) {
            $this->checkedOptions = (string)$this->element['checked'];
        }

        return $return;
    }

    /**
     * Method to get the field input markup for check boxes.
     *
     * @return  string  The field input markup.
     *
     * @since   11.1
     */
    protected function getInput()
    {
        $html = array();

        // Initialize some field attributes.
        $class = !empty($this->class) ? ' class="checkboxes ' . $this->class . '"' : ' class="checkboxes"';
        $checkedOptions = explode(',', (string)$this->checkedOptions);
        $required = $this->required ? ' required aria-required="true"' : '';
        $autofocus = $this->autofocus ? ' autofocus' : '';

        // Including fallback code for HTML5 non supported browsers.
        JHtml::_('jquery.framework');
        JHtml::_('script', 'system/html5fallback.js', false, true);

        // Start the checkbox field output.
        $html[] = '<fieldset id="' . $this->id . '"' . $class . $required . $autofocus . '>';

        $html[] = '<a href="#" id="add-answer-' . $this->element['id'] . '">' . JText::_('COM_POLLS_ADD_ANSWER') . '</a><div class="clearfix"></div>';

        // Build the checkbox field output.
        $html[] = '<ul id="box-answer-' . $this->element['id'] . '" style="margin: 0; float: left; width: 100%">';

        $titleAnswer = JText::_('COM_POLLS_ANSWER_TITLE');
        $orderAnswer = JText::_('COM_POLLS_ANSWER_ORDER');
        $deleteAnswer = JText::_('COM_POLLS_ANSWER_DELETE');

        foreach ($this->getOptions() as $i => $option) {
            $html[] = '<li style="float: left; width: 100%; padding: 5px; border: 1px solid #15497c">';

            $html[] = '<label>' . $titleAnswer . '</label>';
            $html[] = '<input type="text" name="' . $this->element['name'] . '[]" style="width: 97%;" value="' . $option->title . '">';

            $html[] = '<label>' . $orderAnswer . '</label>';
            $html[] = '<input type="text" name="' . $this->element['name'] . '_order[]" style="width: 15%;" value="' . $option->order . '">';

            $html[] = '<input type="hidden" name="polls_answer_id[]" value="' . $option->polls_answer_id . '">';
            $html[] = '<a href="#" class="delete-answer icon-cancel" style="float: right; margin-right: 43px; text-decoration: none; color: #900">' . $deleteAnswer . '</a>';

            $html[] = '</li>';
        }

        $html[] = '</ul>';

        // End the checkbox field output.
        $html[] = '</fieldset>';

        $doc = JFactory::getDocument();
        $doc->addScriptDeclaration("
            jQuery(function () {
                jQuery('#add-answer-{$this->element['id']}').on('click', function(event){
                    event.preventDefault();
                    jQuery('#box-answer-{$this->element['id']}').append(''+
                        '<li style=\'float: left; width: 100%; padding: 5px; border: 1px solid #15497c\'>'+
                            '<label>{$titleAnswer}</label>'+
                            '<input type=\'text\' name=\'{$this->element['name']}[]\' style=\'width: 97%;\'>'+
                            '<label>{$orderAnswer}</label>'+
                            '<input type=\'text\' name=\'{$this->element['name']}_order[]\' style=\'width: 15%;\'>'+
                            '<input type=\'hidden\' name=\'polls_answer_id[]\' value=\'0\'>'+
                            '<a href=\'#\' class=\'delete-answer icon-cancel\' style=\'float: right; margin-right: 43px; text-decoration: none; color: #900\'>{$deleteAnswer}</a> '+
                        '</li>'+
                    '');
                });
                jQuery('body').on('click', '.delete-answer', function(event){
                    event.preventDefault();
                    jQuery(this).parent().remove();
                });
            });
        ");

        return implode($html);
    }

    /**
     * Method to get the field options.
     *
     * @return  array  The field option objects.
     *
     * @since   11.1
     */
    protected function getOptions()
    {
        $input = JFactory::getApplication()->input;
        $id = $input->getInt('id');

        if ($id) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query->select('*');
            $query->from('#__polls_answers');
            $query->where($db->qn('polls_item_id') . ' = ' . $id);
            $query->order($db->qn('order') . ' ASC');

            $db->setQuery($query);
            $answers = $db->loadObjectList();

            return $answers;
        } else {
            return array();
        }
    }
}