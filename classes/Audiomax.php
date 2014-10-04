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
 * Class Audiomax
 *
 * @copyright  pluspunkt coding 2014
 * @author     Christoph Erdmann
 * @package    audiomax
 */
class Audiomax
{
    /**
     * Builds the minimum needed HTML Markup for Player
     * 
     * @param string $strPlayerId
     * @return string
     */
    public function buildPlayerChrome($strPlayerId)
    {
        $strChrome = '
<div class="player" id="'.$strPlayerId.'">
    <div class="inside">
        <audio></audio>
    </div>
</div>
';
        return $strChrome;
    }
    
    /**
     * Collect all Songs per Playlist and return them as array
     * 
     * @param object $objSongs
     * @return array
     */
    public function getFiles($objSongs)
    {
        $arrFiles = array();
        $i = 0;
        
        if($objSongs === null)
        {
            return;
        }
        
        while($objSongs->next())
        {
            $arrSong = $objSongs->row();
            
            $arrFiles[$i]['protected'] = $arrSong['protected'];
            $arrFiles[$i]['groups'] = $arrSong['groups'];
            $arrFiles[$i]['id'] = $arrSong['id'];
            $arrFiles[$i]['interpreter'] = $arrSong['interpreter'];
            $arrFiles[$i]['title'] = $arrSong['title'];
            $arrFiles[$i]['album'] = $arrSong['album'];
            $arrFiles[$i]['track'] = $arrSong['track'];
            $arrFiles[$i]['files'] = array();
            
            $arrUuids = deserialize($arrSong['file']);
            $objSongFiles = \FilesModel::findMultipleByUuids($arrUuids);

            while($objSongFiles->next())
            {
                $arrSongFile = $objSongFiles->row();
                $objFile = new \Contao\File($arrSongFile['path'], true);

                $arrFiles[$i]['files'][] = array(
                    'file' => $arrSongFile['path'],
                    'type' => $objFile->mime
                );
            }
            $i++;
        }
        
        // sort out protected songs
        $arrFiles = $this->sortOutProtected($arrFiles);
        
        return $arrFiles;
    }
    
    /**
     * Creates a unique string for use with multiple players on one page
     * 
     * @param int $intLength
     * @param string $strPrefix
     * @return string
     */
    public function createUniqueId($intLength = 10, $strPrefix = null)
    {
        return substr(sha1(uniqid($strPrefix, true)), 0, $intLength);
    }
    
    /**
     * Sort out protected songs
     * 
     * @param array $arrSongs
     * @return array
     * 
     */
    public function sortOutProtected($arrSongs = array())
    {
        if(empty($arrSongs))
        {
            return;
        }
        
        $objUser = \FrontendUser::getInstance();
        
        foreach($arrSongs as $k => &$arrSong)
        {
            if($arrSong['protected'])
            {
                if(!FE_USER_LOGGED_IN)
                {
                    unset($arrSongs[$k]);
                }
                else{
                    $arrSongGroups = deserialize($arrSong['groups']);
          
                    if(!isset($arrSongGroups) or empty($arrSongGroups) or !count(array_intersect($arrSongGroups, $objUser->groups)))
                    {
                        unset($arrSongs[$k]);
                    }
                }
            }
        }
        
        $arrSongs = array_values($arrSongs);
        return $arrSongs;
    }
}