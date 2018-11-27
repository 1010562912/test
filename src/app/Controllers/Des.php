<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controllers;

use Server\CoreBase\Controller;

/**
 * Description of Des
 *
 * @author yuchangwei
 */
class Des extends Controller {

    public function http_getkey() {
        $param = $this->http_input->getAllPostGet();
        var_dump($param);

        $data = $this->des_ecb_encrypt($param['key'],'213456');
        $res[2] = $this->des_ecb_decrypt($data,'213456');
        $res[1] = $data;
        $this->http_output->setHeader('Content-type', 'text/json');
        $this->http_output->end(json_encode($res));
    }

    /*     * des-ecb加密 
     * @param string  $data 要被加密的数据
     * @param string  $key 加密密钥(64位的字符串)
     */

    function des_ecb_encrypt($data, $key) {
        return openssl_encrypt($data, 'des-ecb', $key);
    }

    /* des-ecb解密
     * @param string  $data 加密数据
     * @param string  $key 加密密钥
     */
    function des_ecb_decrypt($data, $key) {
        return openssl_decrypt($data, 'des-ecb', $key);
    }

    public function getSKey($msg) {
        if (!$msg) {
            var_dump('请输入参数值');
        }
        /* 打开加密算法和模式 */
        $td = mcrypt_module_open('des', '', 'ecb', '');
        /* 创建初始向量，并且检测密钥长度。 Windows 平台请使用 MCRYPT_RAND。 */
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
        $ks = mcrypt_enc_get_key_size($td);
        /* 创建密钥 */
        $key = substr(md5($msg), 0, $ks);
        /* 并且关闭模块 */
        mcrypt_module_close($td);
        return $key;
    }

    /**
      26      *
      27      * 加密函数
      28      * 算法：des
      29      * 加密模式：ecb
      30      * 补齐方法：PKCS5
      31      *
      32      * @param unknown_type $input
      33 */
    public function encryptDesEcbPKCS5($input, $key) {
        $size = mcrypt_get_block_size('des', 'ecb');
        $input = $this->pkcs5_pad($input, $size);
        $td = mcrypt_module_open('des', '', 'ecb', '');
        //获取密钥的最大长度
        $ks = mcrypt_enc_get_key_size($td);
        $key = substr($key, 0, $ks);
        //加密向量值
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        //$iv =0;
        $tmp = mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $data;
    }

    /**
      53      * 解密函数
      54      * 算法：des
      55      * 加密模式：ecb
      56      * 补齐方法：PKCS5
      57      * @param unknown_type $input
      58 */
    public function decryptDesEcbPKCS5($input, $key) {
        $size = mcrypt_get_block_size('des', 'ecb');
        $td = mcrypt_module_open('des', '', 'ecb', '');
        /* 获取密钥的最大长度 */
        $ks = mcrypt_enc_get_key_size($td);
        $key = substr($key, 0, $ks);
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $data = mdecrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = $this->pkcs5_unpad($data, $size);
        return $data;
    }

    private function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    private function pkcs5_unpad($text) {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
            return false;
        return substr($text, 0, -1 * $pad);
    }

}
