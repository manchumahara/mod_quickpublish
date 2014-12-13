<?php
/*------------------------------------------------------------------------
# mod_quickpublish - Quick Article Publish
# ------------------------------------------------------------------------
# author    Codeboxr
# copyright Copyright (C) 2014 codeboxr.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://codeboxr.com
# Technical Support:  Forum - http://codeboxr.com/product/joomla-quick-publish-admin-module
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

$doc = JFactory::getDocument();
JHtml::_('jquery.framework'); //jquery for joomla 3.0
$doc->addScript(JURI::root()."administrator/modules/mod_quickpublish/assets/mod_quickpublish.js?v=2");

//$comparams = JComponentHelper::getParams('com_content', 'permissions');

//echo '<pre>';
//var_dump($comparams->get('rules'));
//echo '</pre>';
/*
$component = 'com_content';

$db = JFactory::getDbo();
$query = $db->getQuery(true)
    ->select($db->quoteName('rules'))
    ->from($db->quoteName('#__assets'))
    ->where($db->quoteName('name') . ' = ' . $db->quote($component));
$db->setQuery($query);
$defaultrules = $db->loadResult();
*/
//echo '<pre>';
//print_r(json_decode($defaultrules));
//echo '</pre>';
//
//
//$actions = JAccess::getActions('com_content', 'component');
//echo '<pre>';
//print_r($actions);
//echo '</pre>';


/*
$assetRules = JAccess::getAssetRules($assetId);
$groups = ModQuickPublishHelper::getUserGroups();

//var_dump($groups);
echo '<pre>';
print_r($groups);
echo '</pre>';


echo '<pre>';
print_r($assetRules);
echo '</pre>';
*/
?>
<div class="row-striped">


<?php
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');
jimport('joomla.form.form');
$session = JFactory::getSession();
$modid = $module->id;

$defaultparams         = JPath::clean(JPATH_ADMINISTRATOR .'/modules/mod_quickpublish/form/comcontent.xml');
$data                  = '';

if (JFile::exists($defaultparams)){


    JForm::addFormPath(JPath::clean(JPATH_ADMINISTRATOR .'/modules/mod_quickpublish/form'));
    $form = new JForm('quickpublishcomponents');



    $form->loadFile('comcontent', false);

    $form->bind($data);




    $fieldSets = $form->getFieldsets('quickpublishcomponents');
    foreach ($fieldSets as $name => $fieldSet) :

        //var_dump($name);

?>

        <div class="row-fluid">
            <div class="span12">
                <form id="modquickpublish<?php echo $name; ?>" name="modquickpublish<?php echo $name; ?>" action="index.php">
                    <?php
                        foreach ($form->getFieldset($name) as $field) :
                    ?>
                            <div class="control-group">
                                <?php
                                    if(!in_array($field->type, array('Text', 'Textarea') )):
                                ?>
                                <label class="control-label" for="inputEmail">
                                   <?php
                                        echo $field->label
                                   ?>
                                </label>
                                <?php endif ?>
                                <div class="controls">
                                   <?php
                                        echo $field->input;
                                   ?>
                                </div>
                            </div>

                    <?php
                        endforeach;
                        echo JHtml::_('form.token');
                    ?>
                    <button type="submit" id="qpsubmit<?php echo $name; ?>" class="btn btn-primary btn-success">
                        <span class="icon-apply icon-white"></span>
                        Save</button>
                </form>
                <script type="text/javascript">
                    jQuery( document ).ready(function( $ ) {
                        $("#modquickpublish<?php echo $name; ?>").submit(function(e){

                            e.preventDefault();	//STOP default action

                            console.log('form submitted');
                            console.log($("#quickpublishcomponents_tags").val());

                            //var postData = $(this).serializeObject();
                            //console.log(postData);

                            var modid    = '<?php echo $modid;  ?>';
                            var editlink = '<?php echo JURI::root(); ?>administrator/index.php?option=com_content&task=article.edit&id=';

                            var data     = {

                                'tk'            : '<?php echo $session->getToken();?>',
                                'modid'         :  modid,
                                'format'        : 'json',
                                'option'        : 'com_ajax',
                                'module'        : 'quickpublish',
                                'title'         : $("#quickpublishcomponents_title").val(),
                                'articletext'   : $("#quickpublishcomponents_articletext").val(),
                                'state'         : $("#quickpublishcomponents_state").val(),
                                'catid'         : $("#quickpublishcomponents_catid").val(),
                                'tags'          : JSON.stringify($("#quickpublishcomponents_tags").val()),
                                'metakey'       : $("#quickpublishcomponents_metakey").val(),
                                'metadesc'      : $("#quickpublishcomponents_metadesc").val()
                            };

                            $.ajax(
                                {

                                    type: "POST",
                                    data : data,
                                    beforeSend : function(){
                                        $("#qpsubmitcomcontent").attr("disabled","true");
                                    },
                                    success:function(data, textStatus, jqXHR){

                                        result = jQuery.parseJSON(data);

                                        if(result.error){
                                            $("#modquickpublish<?php echo $name; ?>").prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error!</strong> '+result.error+'</div>');
                                            $("#qpsubmitcomcontent").removeAttr("disabled");
                                        }
                                        else{
                                            console.log(result.data);
                                            $("#modquickpublish<?php echo $name; ?>").prepend('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> <strong>Success!</strong> Posted Successfully. <a target="_parent" href="'+editlink+result.data+'">Click here to edit</a></div>');

                                            $("#modquickpublish<?php echo $name; ?>")[0].reset();
                                            $("#qpsubmitcomcontent").removeAttr("disabled");
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown){
                                        //console.log('error occured');
                                        $("#modquickpublish<?php echo $name; ?>").prepend('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button> <strong>Error!</strong> Failed to post.</div>');
                                        $("#qpsubmitcomcontent").removeAttr("disabled");
                                    }
                                });

                        });
                    });
                </script>
            </div>
        </div>

<?php

    endforeach;
}
?>
</div>
