<?php
/**
 * Created by Aurelien
 * Date: 09/08/13
 * Time: 12:29
 */

namespace Library\Helper;

/**
 * Cron
 * @package Library\Helper
 * @author Aurelien Mecheri
 */
class Cron {
    /**
     * Const BEGIN
     */
    const BEGIN = "# --- The following lines are handled automatically via a PHP script ---";
    /**
     * Const BEGIN_NEXT
     */
    const BEGIN_NEXT = "# --- Please do not edit manually ---";
    /**
     * Const END
     */
    const END = "# --- The following lines are not handled automatically ---";

    /**
     * Const SECTION_NOT_FOUND
     */
    const SECTION_NOT_FOUND = 0;
    /**
     * Const SECTION_OPEN
     */
    const SECTION_OPEN = 1;
    /**
     * Const SECTION_CLOSE
     */
    const SECTION_CLOSE = 2;

    /**
     * @access private
     * @var array $_oldCrontab
     */
    private $_oldCrontab = array();
    /**
     * @access private
     * @var array $_newCrontab
     */
    private $_newCrontab = array();
    /**
     * @access private
     * @var array $_oldToAdd
     */
    private $_oldToAdd = array();
    /**
     * @access private
     * @var array $_toAdd
     */
    private $_toAdd = array();
    /**
     * @access private
     * @var array $_toRemove
     */
    private $_toRemove = array();

    /**
     * @access private
     * Add section to the new crontab
     */
    private function _addSection(){
        $this->_newCrontab[] = self::BEGIN;
        $this->_newCrontab[] = self::BEGIN_NEXT;
        $toAdd = array_merge($this->_oldToAdd, $this->_toAdd);
        foreach ($toAdd as $key => $script){
            $this->_newCrontab[] = '# '.(++$key).' : '.$script[1];
            $this->_newCrontab[] = $script[2].' '.$script[3].' '.$script[4].' '.$script[5].' '.$script[6].' '.$script[0];
        }
        $this->_newCrontab[] = self::END;
    }

    /**
     * Getter Comment of explode line
     *
     * @param array $line
     * @return string
     */
    private function _getCommentOfExplodeLine(array $line){
        array_shift($line);
        array_shift($line);
        array_shift($line);
        return implode(' ', $line);
    }

    /**
     * Getter Command of explode line
     *
     * @param array $line
     * @return string
     */
    private function _getCommandOfExplodeLine(array $line){
        array_shift($line);
        array_shift($line);
        array_shift($line);
        array_shift($line);
        array_shift($line);
        return implode(' ', $line);
    }

    /**
     * Add script to crontab
     *
     * @param string $sCommand
     * @param string $sComment
     * @param string $sMinute
     * @param string $sHour
     * @param string $sDayOfTheMonth
     * @param string $sMonth
     * @param string $sDayOfTheWeek
     */
    public function addScript($sCommand, $sComment = 'No Comment', $sMinute = '*', $sHour = '*', $sDayOfTheMonth = '*', $sMonth = '*', $sDayOfTheWeek = '*'){
        $this->_toAdd[] = array($sCommand, $sComment, $sMinute, $sHour, $sDayOfTheMonth, $sMonth, $sDayOfTheWeek);
    }

    /**
     * Remove script form crontab by id
     *
     * @param int $id
     */
    public function removeScript($id){
        $this->_toRemove[$id] = $id;
    }

    /**
     * Save changes of crontab
     *
     * @param bool $eraseSection
     */
    public function save($eraseSection = false){
        $sectionStatus = self::SECTION_NOT_FOUND;
        $ignoreNext = false;

        exec('crontab -l', $this->_oldCrontab);

        foreach($this->_oldCrontab as $key => $line){
            if($ignoreNext){
                $ignoreNext = false;
            }elseif($sectionStatus == self::SECTION_OPEN){
                if ($line == self::END){
                    $this->_addSection();
                    $sectionStatus = self::SECTION_CLOSE;
                }elseif(!$eraseSection){
                    $word = explode(' ', $line);
                    if(!array_key_exists($word[1], $this->_toRemove)){
                        $comment = $this->_getCommentOfExplodeLine($word);
                        $next = explode(' ', $this->_oldCrontab[$key+1]);
                        $command = $this->_getCommandOfExplodeLine($next);
                        $this->_oldToAdd[] = array($command, $comment, $next[0], $next[1], $next[2], $next[3], $next[4]);
                    }
                    $ignoreNext = true;
                }else{
                    $ignoreNext = true;
                }
            }elseif($sectionStatus == self::SECTION_NOT_FOUND && $line == self::BEGIN){
                $sectionStatus = self::SECTION_OPEN;
                $ignoreNext = true;
            }else{
                $this->_newCrontab[] = $line;
            }
        }

        if ($sectionStatus == self::SECTION_NOT_FOUND){
            $this->_addSection();
        }

        $f = fopen(SERVER_ROOT.'/tmpCronTab', 'w');
        fwrite($f, implode("\n", $this->_newCrontab));
        fclose($f);

        exec('crontab '.SERVER_ROOT.'/tmpCronTab');

        unlink(SERVER_ROOT.'/tmpCronTab');
    }
}