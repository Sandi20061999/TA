<?php

/**
 *
 * This file is part of mvc-rest-api for PHP.
 *
 */

namespace MVC;

/**
 * Class Controller, a port of MVC
 *
 * @author Mohammad Rahmani <rto1680@gmail.com>
 *
 * @package MVC
 */
class Controller
{

    /**
     * Request Class.
     */
    public $request;

    /**
     * Response Class.
     */
    public $response;

    /**
     *  Construct
     */
    public function __construct()
    {
        $this->request = $GLOBALS['request'];
        $this->response = $GLOBALS['response'];
    }

    /**
     * get Model
     * 
     * @param string $model
     * 
     * @return object
     */
    public function model($model)
    {
        $file = MODELS . ucfirst($model) . '.php';

        // check exists file
        if (file_exists($file)) {
            require_once $file;

            $model = 'Models' . str_replace('/', '', ucwords($model, '/'));
            // check class exists
            if (class_exists($model))
                return new $model;
            else
                throw new Exception(sprintf('{ %s } this model class not found', $model));
        } else {
            throw new Exception(sprintf('{ %s } this model file not found', $file));
        }
    }

    // send response faster
    public function send($status = 200, $msg)
    {
        $this->response->setHeader(sprintf('HTTP/1.1 ' . $status . ' %s', $this->response->getStatusCodeText($status)));
        $this->response->setContent($msg);
    }

    public function base64_encrypt($plain_text, $password, $iv_len = 16)
    {
        $plain_text .= "\x13";
        $n = strlen($plain_text);
        if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
        $i = 0;
        $enc_text = $this->get_rnd_iv($iv_len);
        $iv = substr($password ^ $enc_text, 0, 512);
        while ($i < $n) {
            $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
            $enc_text .= $block;
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }
        $hasil = base64_encode($enc_text);
        return str_replace('+', '@', $hasil);
    }

    public function base64_decrypt($enc_text, $password, $iv_len = 16)
    {
        $enc_text = str_replace('@', '+', $enc_text);
        $enc_text = base64_decode($enc_text);
        $n = strlen($enc_text);
        $i = $iv_len;

        $plain_text = '';
        $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
        while ($i < $n) {
            $block = substr($enc_text, $i, 16);
            $plain_text .= $block ^ pack('H*', md5($iv));
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }
        return preg_replace('/\\x13\\x00*$/', '', $plain_text);
    }

    public function get_rnd_iv($iv_len)
    {
        $iv = '';
        while ($iv_len-- > 0) {
            $iv .= chr(mt_rand() & 0xff);
        }
        return $iv;
    }

    public function decryptToken($token)
    {
        $keyEnchiper = "ab53n51Ku";
        $data = $this->base64_decrypt($token, $keyEnchiper);
        $split = explode(",", $data);
        $EmpCode = $split[0];
        $split2 = explode(":", $EmpCode);
        $EmpCode2 = $split2[1];
        return $EmpCode2;
    }
}
