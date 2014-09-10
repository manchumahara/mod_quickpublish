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

class ModQuickPublishHelper{
    /**
     *
     */
    public static function getAjax(){

        //echo 'I am here';
        //die();

        $language = JFactory::getLanguage();
        $language->load('mod_quickpublish', JPATH_ADMINISTRATOR, 'en-GB', true);
        $language->load('mod_quickpublish', JPATH_ADMINISTRATOR, null, true);

        jimport( 'joomla.session.session' );
        jimport( 'joomla.application.module.helper' );

        require_once JPATH_ADMINISTRATOR.'/components/com_content/models/article.php';


        $app 		= JFactory::getApplication();
        $tk 		= $app->input->getCmd('tk');
        $modid      = intval($app->input->getCmd('modid'));

        $title              = $app->input->getString('title');
        $articletext        = $app->input->getHtml('articletext');
        $state              = $app->input->getInt('state');
        $catid              = $app->input->getInt('catid');
        $tags               = json_decode($app->input->getString('tags'));

        $metakey            = $app->input->getString('metakey');
        $metadesc           = $app->input->getString('metadesc');

        //var_dump($tags);
        
        if(!($modid  > 1)){
            $res['error'] = JText::_('MOD_QUICKPUBLISH_MOD_ID_MISSING');
            echo json_encode($res);
            die();
        }

        if(empty($title) || empty($articletext) ){
            $res['error'] = JText::_('MOD_QUICKPUBLISH_TITLE_DESC_MISSING');
            echo json_encode($res);
            die();
        }

        $session = JFactory::getSession();

        if($session->hasToken($tk)){


            //$module = &JModuleHelper::getModule( 'univcurconverter');
            //$params = new JRegistry($module->params);
            /*
            $module     = JTable::getInstance('module', 'JTable', array());
            $module->id = $modid;
            $module->load();
            $params  = new JObject();
            if(is_object($module)){
                $params              = new JRegistry( $module->params );
            }
            */

            $data = array
                (
                    'id'                => 0,
                    'title'             => $title,
                    'alias'             => '',
                    'articletext'       => $articletext,
                    'state'             => $state,
                    'catid'             => $catid,
                    'access'            => '1',

                    'language'          => '*',
                    'rules'             => array
                                                (
                                                    'core.delete'       => array('6' => 1 ),
                                                    'core.edit'         => array('6' => 1,'4' => 1),
                                                    'core.edit.state'   => array('6' => 1, '5' => 1)
                                                ),

                    'tags'              => $tags,
                    'metakey'           => $metakey,
                    'metadesc'          => $metadesc

                );

            $contentmodel = new ContentModelArticle;
            $return = $contentmodel->save($data);

            //print_r($contentmodel->getState('article.id'));

            if($return === TRUE){
                $res['data'] = $contentmodel->getState('article.id');
                echo json_encode($res);
            }
            else{
                $res['error']  = JText::_('MOD_QUICKPUBLISH_FAILETOCREATE');
                echo json_encode($res);
            }

            die();

        } else {
            $res['error'] = JText::_('MOD_QUICKPUBLISH_AJAX_TOKEN');
            echo json_encode($res);
            die();
        }

        die();

    } // end of function Rate

    public  static  function getUserGroups() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('a.id AS value, a.title AS text, COUNT(DISTINCT b.id) AS level, a.parent_id')
            ->from('#__usergroups AS a')
            ->join('LEFT', $db->quoteName('#__usergroups') . ' AS b ON a.lft > b.lft AND a.rgt < b.rgt')
            ->group('a.id, a.title, a.lft, a.rgt, a.parent_id')
            ->order('a.lft ASC');
        $db->setQuery($query);
        $options = $db->loadObjectList();
        return $options;
    }
}

/*
Array
(
    [id] => 0
    [title] => Mr. Manchu
    [alias] =>
    [version_note] =>
    [articletext] =>
I am a funny guy


    [state] => 1
    [catid] => 9
    [created] =>
    [created_by] =>
    [created_by_alias] =>
    [modified] =>
    [modified_by] =>
    [publish_up] =>
    [publish_down] =>
    [version] =>
    [metakey] =>
    [metadesc] =>
    [access] => 1
    [hits] =>
    [language] => *
    [featured] => 0
    [rules] => Array
        (
            [core.delete] => Array
                (
                    [6] => 1
                )

            [core.edit] => Array
                (
                    [6] => 1
                    [4] => 1
                )

            [core.edit.state] => Array
                (
                    [6] => 1
                    [5] => 1
                )

        )

    [attribs] => Array
        (
            [show_title] =>
            [link_titles] =>
            [show_tags] =>
            [show_intro] =>
            [info_block_position] =>
            [show_category] =>
            [link_category] =>
            [show_parent_category] =>
            [link_parent_category] =>
            [show_author] =>
            [link_author] =>
            [show_create_date] =>
            [show_modify_date] =>
            [show_publish_date] =>
            [show_item_navigation] =>
            [show_icons] =>
            [show_print_icon] =>
            [show_email_icon] =>
            [show_vote] =>
            [show_hits] =>
            [show_noauth] =>
            [urls_position] =>
            [alternative_readmore] =>
            [article_layout] =>
            [show_publishing_options] =>
            [show_article_options] =>
            [show_urls_images_backend] =>
            [show_urls_images_frontend] =>
        )

    [xreference] =>
    [images] => Array
        (
            [image_intro] =>
            [float_intro] =>
            [image_intro_alt] =>
            [image_intro_caption] =>
            [image_fulltext] =>
            [float_fulltext] =>
            [image_fulltext_alt] =>
            [image_fulltext_caption] =>
        )

    [urls] => Array
        (
            [urla] =>
            [urlatext] =>
            [targeta] =>
            [urlb] =>
            [urlbtext] =>
            [targetb] =>
            [urlc] =>
            [urlctext] =>
            [targetc] =>
        )

    [metadata] => Array
        (
            [robots] =>
            [author] =>
            [rights] =>
            [xreference] =>
        )

    [tags] =>
)
*/