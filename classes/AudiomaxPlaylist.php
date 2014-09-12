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
 * Namespace
 */
namespace audiomax;


/**
 * Class AudiomaxPlaylist
 *
 * @copyright  pluspunkt coding 2014
 * @author     Christoph Erdmann
 * @package    Devtools
 */
class AudiomaxPlaylist extends \BackendModule
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = '';


    /**
     * Generate the module
     */
    protected function compile()
    {

    }

    /**
     * Get all playlists and return them as array
     * @return array
     */
    public function getPlaylistsForDropdown()
    {
        $arrPlaylists = array();
        $objPlaylists = $this->Database->execute("SELECT id, title FROM tl_audiomax_playlist ORDER BY title");

        while ($objPlaylists->next())
        {
            $arrPlaylists[$objPlaylists->id] = $objPlaylists->title . ' (ID ' . $objPlaylists->id . ')';
        }

        return $arrPlaylists;
    }
}
