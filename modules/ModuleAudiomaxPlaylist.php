<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   audiomax
 * @author    Christoph Erdmann <info@pluspunkt-coding.de>
 * @license   CC-BYSA-3.0-DE
 * @copyright pluspunkt coding 2014
 */


/**
 * Namespace
 */
namespace audiomax;


/**
 * Class ModuleAudiomaxPlaylist
 *
 * @copyright  pluspunkt coding 2014
 * @author     Christoph Erdmann <info@pluspunkt-coding.de>
 * @package    audiomax
 */
class ModuleAudiomaxPlaylist extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'audiomax_default';
        
        /**
         * Audiomax
         * @var object
         */
        protected $objAudiomax;

        /**
         * generate the module
         * @return string
         */
        public function generate() {
            if (TL_MODE == 'BE')
            {
                $objTemplate = new \BackendTemplate('be_wildcard');

                $objPlaylist = \Database::getInstance()
                            ->prepare('
                                SELECT * FROM tl_audiomax_playlist WHERE id = ? LIMIT 1
                            ')
                            ->execute($this->audiomax_playlist);

                $objTemplate->wildcard = '### AUDIOMAX PLAYLIST ###';
                $objTemplate->title = $objPlaylist->title;
                $objTemplate->id = $this->audiomax_playlist;
                $objTemplate->link = $objPlaylist->title;;
                $objTemplate->href = 'contao/main.php?do=audiomax&amp;table=tl_audiomax_song&amp;id=' . $this->audiomax_playlist;

                return $objTemplate->parse();
            }
				
            return parent::generate();
        }

	/**
	 * Generate the module
	 */
	protected function compile()
	{
            $this->objAudiomax = new \Audiomax();            
            $objSongs = \AudiomaxSongModel::findPublishedByPid($this->audiomax_playlist);
            $objPlaylist = \AudiomaxPlaylistModel::findByPk($this->audiomax_playlist);
            
            // get the Template
            $objTemplate = new \Contao\FrontendTemplate($this->audiomax_tpl);
            
            // compile song files
            $arrFiles = $this->objAudiomax->getFiles($objSongs);
            
            // unique player ID
            $strPlayerId = 'audiomax_'.$this->objAudiomax->createUniqueId(14, 'audiomax_');
            
            // Fill the Template
            $objTemplate->title = $objPlaylist->title;
            $objTemplate->description = $objPlaylist->description;
            $objTemplate->playerId = $strPlayerId;
            $objTemplate->player = $this->objAudiomax->buildPlayerChrome($strPlayerId);
            $objTemplate->playlist = json_encode($arrFiles);
            $this->Template = $objTemplate;
	}
}
