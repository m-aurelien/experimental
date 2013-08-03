<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Aurelien
 * Date: 22/07/13
 * Time: 19:45
 * To change this template use File | Settings | File Templates.
 */

namespace Library\Mail;

/**
 * Mail sender
 *
 * @package Library\Mail
 * @author Aurelien Mecheri
 */
class Mail {
    /**
     * @access private
     * @var array $_from
     */
    private $_from = array();
    /**
     * @access private
     * @var string $_replyTo
     */
    private $_replyTo;
    /**
     * @access private
     * @var array $_to
     */
    private $_to = array();
    /**
     * @access private
     * @var array $_cc
     */
    private $_cc = array();
    /**
     * @access private
     * @var array $_bcc
     */
    private $_bcc = array();
    /**
     * @access private
     * @var string $_subject
     */
    private $_subject;
    /**
     * @access private
     * @var string $_content
     */
    private $_content;

    /**
     * Setter $_from
     *
     * @param string $from
     */
    public function setFrom($from){
        $this->_from = $from;
    }

    /**
     * Getter $_from
     *
     * @return array $_from
     */
    public function from(){
        return $this->_from;
    }

    /**
     * Setter $_replyTo
     *
     * @param string $replyTo
     */
    public function setReplyTo($replyTo){
        $this->_replyTo = $replyTo;
    }

    /**
     * Getter $_replyTo
     *
     * @return string $_replyTo
     */
    public function replyTo(){
        return $this->_replyTo;
    }

    /**
     * Setter $_to
     *
     * @param array $to
     */
    public function setTo(array $to){
        $this->_to = $to;
    }

    /**
     * Adder $_to
     *
     * @param string $to
     */
    public function addTo($to){
        $this->_to[] = $to;
    }

    /**
     * Getter $_to
     *
     * @return array $_to
     */
    public function to(){
        return $this->_to;
    }

    /**
     * Return attribute $_to to string
     *
     * @return string $toFormat
     */
    public function toFormat(){
        $toFormat = '';
        foreach ($this->to() as $to) {
            $toFormat .= $to.', ';
        }
        return $toFormat;
    }

    /**
     * Setter $_cc
     *
     * @param array $cc
     */
    public function setCc(array $cc){
        $this->_cc = $cc;
    }

    /**
     * Adder $_cc
     *
     * @param string $cc
     */
    public function addCc($cc){
        $this->_cc[] = $cc;
    }

    /**
     * Getter $_cc
     *
     * @return array $_cc
     */
    public function cc(){
        return $this->_cc;
    }

    /**
     * Return attribute $_cc to string
     *
     * @return string $ccFormat
     */
    public function ccFormat(){
        $ccFormat = '';
        foreach ($this->cc() as $cc) {
            $ccFormat .= $cc.', ';
        }
        return $ccFormat;
    }

    /**
     * Setter $_bcc
     *
     * @param array $bcc
     */
    public function setBcc(array $bcc){
        $this->_bcc = $bcc;
    }

    /**
     * Adder $_bcc
     *
     * @param string $bcc
     */
    public function addBcc($bcc){
        $this->_bcc[] = $bcc;
    }

    /**
     * Getter $_bcc
     *
     * @return array $_bcc
     */
    public function bcc(){
        return $this->_bcc;
    }

    /**
     * Return attribute $_cc to string
     *
     * @return string $bccFormat
     */
    public function bccFormat(){
        $bccFormat = '';
        foreach ($this->bcc() as $bcc) {
            $bccFormat .= $bcc.', ';
        }
        return $bccFormat;
    }

    /**
     * Setter $_subject
     * @param string $subject
     */
    public function setSubject($subject){
        $this->_subject = $subject;
    }

    /**
     * Getter $_subject
     *
     * @return string $_subject
     */
    public function subject(){
        return $this->_subject;
    }

    /**
     * Setter $_content
     *
     * @param $content
     */
    public function setContent($content){
        $this->_content = $content;
    }

    /**
     * Getter $_content
     *
     * @return string $_content
     */
    public function content(){
        return $this->_content;
    }

    /**
     * Construct the header
     *
     * @return string $header
     */
    public  function header(){
        $header = '';
        if($this->from())       $header .=  'From: '        .$this->from()          ."\r\n";
        if($this->replyTo())    $header .=  'Reply-To: '    .$this->replyTo()       ."\r\n";
        if($this->ccFormat())   $header .=  'Cc: '          .$this->ccFormat()      ."\r\n";
        if($this->bccFormat())  $header .=  'Bcc: '         .$this->bccFormat()     ."\r\n";

        $header .= 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $header .= 'X-Mailer: PHP/'.phpversion();
        return $header;
    }

    /**
     * Send mail
     *
     * @return bool true si le mail est envoyé
     */
    public function send(){
        return mail($this->toFormat(), $this->subject(), $this->content(), $this->header());
    }

}