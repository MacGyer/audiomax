<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Audiomax
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'audiomax',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'audiomax\AudiomaxPlaylist'        => 'system/modules/audiomax/classes/AudiomaxPlaylist.php',
	'audiomax\AudiomaxSong'            => 'system/modules/audiomax/classes/AudiomaxSong.php',
	'audiomax\Audiomax'                => 'system/modules/audiomax/classes/Audiomax.php',

	// Modules
	'audiomax\ModuleAudiomaxPlaylist'  => 'system/modules/audiomax/modules/ModuleAudiomaxPlaylist.php',

	// Models
	'audiomax\AudiomaxPlaylistModel'   => 'system/modules/audiomax/models/AudiomaxPlaylistModel.php',
	'audiomax\AudiomaxSongModel'       => 'system/modules/audiomax/models/AudiomaxSongModel.php',

	// _bak
	'audiomax\ContentAudiomaxPlaylist' => 'system/modules/audiomax/_bak/elements/ContentAudiomaxPlaylist.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'audiomax_default' => 'system/modules/audiomax/templates',
));
