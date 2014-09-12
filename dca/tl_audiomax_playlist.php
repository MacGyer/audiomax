<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   audiomax
 * @author    Christoph Erdmann
 * @license   CC-BYSA-3.0-DE
 * @copyright pluspunkt coding 2014
 */


/**
 * Table tl_audiomax_playlist
 */
$GLOBALS['TL_DCA']['tl_audiomax_playlist'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
        'switchToEdit'                => true,
        'ctable'                      => 'tl_audiomax_song',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_playlist']['edit'],
				'href'                => 'table=tl_audiomax_song',
				'icon'                => 'edit.gif'
			),
                        'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_playlist']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_playlist']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_playlist']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_playlist']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Select
	'select' => array
	(
		'buttons_callback' => array()
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('protected'),
		'default'                     => '{title_legend},title;{description_legend},description'
	),

	// Subpalettes
	'subpalettes' => array
	(
            
        ),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_playlist']['title'],
			'exclude'                 => true,
                        'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class' => 'w50 clr'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
                'description' => array
                (
                        'label'                  => &$GLOBALS['TL_LANG']['tl_audiomax_playlist']['description'],
                        'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength' => 150),
			'sql'                     => "varchar(150) NOT NULL default ''"
                ),
	)
);

/**
 * Class tl_audiomax_playlist
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @package   audiomax
 * @author    Christoph Erdmann
 * @copyright pluspunkt coding 2014
 */
class tl_audiomax_playlist extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

        /**
	 * Return the edit module wizard
	 * @param \DataContainer
	 * @return string
	 */
//	public function editPlaylist(DataContainer $dc)
//	{
//            print($dc->value);die();
//            return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=audiomax&amp;table=tl_audiomax_song&amp;act=edit&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . REQUEST_TOKEN . '" title="' . sprintf(specialchars($GLOBALS['TL_LANG']['tl_audiomax_playlist']['edit'][1]), $dc->value) . '" style="padding-left:3px" onclick="Backend.openModalIframe({\'width\':765,\'title\':\'' . specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_audiomax_playlist']['edit'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.gif', $GLOBALS['TL_LANG']['tl_audiomax_playlist']['edit'][0], 'style="vertical-align:top"') . '</a>';
//	}
}