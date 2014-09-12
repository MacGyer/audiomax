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

namespace audiomax;

/**
 * Reads and writes Audiomax songs
 *
 * @package   audiomax
 * @author    Christoph Erdmann <http://www.pluspunkt-coding.de>
 * @copyright pluspunkt coding 2014
 */
class AudiomaxSongModel extends \Model{
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_audiomax_song';
    
    /**
    * Find published songs by their parent ID
    *
    * @param integer $intId      The playlist ID
    * @param integer $intLimit   An optional limit
    * @param array   $arrOptions An optional options array
    *
    * @return \Model\Collection|null A collection of models or null if there are no songs
    */
    public static function findPublishedByPid($intId, $intLimit=0, array $arrOptions=array())
    {
            $time = time();
            $t = static::$strTable;

            $arrColumns = array("$t.pid=? AND ($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1");

            if (!isset($arrOptions['order']))
            {
                    $arrOptions['order'] = "$t.sorting ASC";
            }

            if ($intLimit > 0)
            {
                    $arrOptions['limit'] = $intLimit;
            }

            return static::findBy($arrColumns, $intId, $arrOptions);
    }
}
