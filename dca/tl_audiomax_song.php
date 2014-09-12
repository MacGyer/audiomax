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
 * Table tl_audiomax_song
 */
$GLOBALS['TL_DCA']['tl_audiomax_song'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
                'ptable'                      => 'tl_audiomax_playlist',
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
                                'pid' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'panelLayout'             => 'filter;sort,search,limit',
			'headerFields'            => array('title', 'tstamp'),
                        'child_record_callback'   => array('tl_audiomax_song', 'listSongs')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_song']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_song']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_song']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
                        'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_song']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_audiomax_song', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_audiomax_song']['show'],
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
		'default'                     => '{general_legend},title,interpreter,album,track;{files_legend},file;{publish_legend},published,start,stop'
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
        'pid' => array
		(
			'foreignKey'              => 'tl_audiomax_playlist.id',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
        'sorting' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['MSC']['sorting'],
			'sorting'                 => true,
			'flag'                    => 2,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_song']['title'],
			'exclude'                 => true,
                        'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class' => 'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
                'interpreter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_song']['interpreter'],
			'exclude'                 => true,
                        'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class' => 'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
                'album' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_song']['album'],
			'exclude'                 => true,
                        'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class' => 'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
                'track' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_song']['track'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class' => 'w50', 'maxlength' => 10),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
                'file' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_song']['file'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('mandatory' => true, 'multiple'=>true, 'fieldType'=>'checkbox', 'filesOnly'=>true, 'extensions'=>'mp3,ogg,wav'),
			'sql'                     => "blob NOT NULL"
		),
		'published' => array
		(
			'exclude'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_song']['published'],
			'inputType'               => 'checkbox',
                        'filter'                  => true,
			'eval'                    => array('doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_song']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_audiomax_song']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		)
	)
);

/**
 * Class tl_audiomax_song
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @package   audiomax
 * @author    Christoph Erdmann
 * @copyright pluspunkt coding 2014
 */
class tl_audiomax_song extends Backend
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
	 * Add the type of input field
	 * @param array
	 * @return string
	 */
	public function listSongs($arrRow)
	{
		$key = $arrRow['published'] ? 'published' : 'unpublished';
		$date = Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['tstamp']);

		return '
<div class="cte_type ' . $key . '">' . $date . '</div>
<div class="limit_height' . (!$GLOBALS['TL_CONFIG']['doNotCollapse'] ? ' h52' : '') . '">
<strong>'.$GLOBALS['TL_LANG']['tl_audiomax_song']['title'][0].': </strong>'.$arrRow['title'].'<br>
'.((!empty($arrRow['interpreter'])) ? '<strong>'.$GLOBALS['TL_LANG']['tl_audiomax_song']['interpreter'][0].': </strong>'.$arrRow['interpreter'].'<br>' : '').'
'.((!empty($arrRow['album'])) ? '<strong>'.$GLOBALS['TL_LANG']['tl_audiomax_song']['album'][0].': </strong>'.$arrRow['album'].'<br>' : '').'
'.((!empty($arrRow['track'])) ? '<strong>'.$GLOBALS['TL_LANG']['tl_audiomax_song']['track'][0].': </strong>'.$arrRow['track'].'<br>' : '').'
</div>' . "\n";
	}
        
        /**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_audiomax_song::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}
    
    /**
	 * Disable/enable a user group
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_audiomax_song::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish Song ID "'.$intId.'"', __METHOD__, TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$objVersions = new Versions('tl_audiomax_song', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_audiomax_song']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_audiomax_song']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, $this);
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_audiomax_song SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$objVersions->create();
		$this->log('A new version of record "tl_audiomax_song.id='.$intId.'" has been created'.$this->getParentEntries('tl_faq', $intId), __METHOD__, TL_GENERAL);
	}
}