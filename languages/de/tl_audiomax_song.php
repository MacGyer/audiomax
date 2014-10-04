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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_audiomax_song']['title'] = array('Songtitel', 'Tragen Sie hier den Songtitel ein.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['interpreter'] = array('Interpret', 'Hier können Sie einen Interpreten eintragen.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['album'] = array('Album', 'Hier können Sie einen Albumtitel eintragen.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['track'] = array('Tracknummer', 'Hier können Sie eine Tracknummer eintragen.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['file'] = array('Datei', 'Wählen Sie die Datei/en aus. Sie können mehrere Dateien des gleichen Songs wählen, wenn Sie unterschiedliche Codecs nutzen.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['protected'] = array('Song schützen', 'Song nur bestimmten Frontend-Gruppen anzeigen.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['groups'] = array('Erlaubte Mitgliedergruppen', 'Diese Mitgliedergruppen können den Song sehen.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['published'] = array('Song veröffentlichen', 'Den Song in der Playlist anzeigen.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['start'] = array('Anzeigen ab', 'Den Song erst ab diesem Tag in der Playlist anzeigen.');
$GLOBALS['TL_LANG']['tl_audiomax_song']['stop'] = array('Anzeigen bis', 'Den Song nur bis zu diesem Tag in der Playlist anzeigen.');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_audiomax_song']['general_legend'] = 'Song-Informationen';
$GLOBALS['TL_LANG']['tl_audiomax_song']['files_legend'] = 'Datei-Auswahl';
$GLOBALS['TL_LANG']['tl_audiomax_song']['protected_legend'] = 'Zugriffsschutz';
$GLOBALS['TL_LANG']['tl_audiomax_song']['publish_legend'] = 'Veröffentlichung';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_audiomax_song']['new']    = array('Neuer Song', 'Neuen Song erstellen');
$GLOBALS['TL_LANG']['tl_audiomax_song']['show']   = array('Song-Details', 'Zeige die Details zu Song ID %s');
$GLOBALS['TL_LANG']['tl_audiomax_song']['edit']   = array('Song bearbeiten', 'Bearbeite Song ID %s');
$GLOBALS['TL_LANG']['tl_audiomax_song']['cut']    = array('Song verschieben', 'Verschiebe Song ID %s');
$GLOBALS['TL_LANG']['tl_audiomax_song']['copy']   = array('Song duplizieren', 'Dupliziere Song ID %s');
$GLOBALS['TL_LANG']['tl_audiomax_song']['delete'] = array('Song löschen', 'Lösche Song ID %s');
$GLOBALS['TL_LANG']['tl_audiomax_song']['toggle'] = array('Song veröffentlichen/unveröffentlichen', 'Song ID %s veröffentlichen/unveröffentlichen');
