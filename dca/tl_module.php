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
 * Table tl_module
 */

// Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['audiomax'] = '{title_legend},name,headline,type;{audiomax_legend},audiomax_playlist,audiomax_tpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

// Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['audiomax_playlist'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['audiomax_playlist'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'select',
    'options_callback'        => array('AudiomaxPlaylist', 'getPlaylistsForDropdown'),
    'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'includeBlankOption' => true, 'tl_class' => 'w50'),
    'sql'                     => "int(10) unsigned NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['audiomax_tpl'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['audiomax_tpl'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('tl_module_audiomax', 'getAudiomaxTemplates'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

class tl_module_audiomax extends Contao\Backend
{
    public function getAudiomaxTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('audiomax_');
    }
}