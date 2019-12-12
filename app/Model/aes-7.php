<?php 
class Aes {
 
    private $hex_iv = ''; # converted JAVA byte code in to HEX and placed it here
 
    private $key; #Same as in JAVA

    public function __construct($key) {
        $this->key = $key;
        //$this->key = hash('sha256', $this->key, true);
    }
 
    /*
    function encrypt($str) {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->hexToStr($this->hex_iv));
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $pad = $block - (strlen($str) % $block);
        $str .= str_repeat(chr($pad), $pad);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encrypted);
    }
    function decrypt($code) {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->hexToStr($this->hex_iv));
        $str = mdecrypt_generic($td, base64_decode($code));
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $this->strippadding($str);
    }*/
 
    public function encrypt($input)
    {
        $data = openssl_encrypt($input, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        //$data = base64_encode($data);
        $data = bin2hex($data);  //普通编码转成16进制
        return $data;
    }
    
    public function decrypt($input)
    {       
        $input = base64_decode($input);
        //$input = hex2bin($input);  //16进制转为普通编码
        $decrypted = openssl_decrypt($input, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        return $decrypted;
    }
 
    /*
      For PKCS7 padding
     */
    private function addpadding($string, $blocksize = 16) {
 
        $len = strlen($string);
 
        $pad = $blocksize - ($len % $blocksize);
 
        $string .= str_repeat(chr($pad), $pad);
 
        return $string;
 
    }
 
    private function strippadding($string) {
 
        $slast = ord(substr($string, -1));
 
        $slastc = chr($slast);
 
        $pcheck = substr($string, -$slast);
 
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
 
            $string = substr($string, 0, strlen($string) - $slast);
 
            return $string;
 
        } else {
 
            return false;
 
        }
 
    }
 
    function hexToStr($hex)
    {
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2)
        {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }
 
}



$obj = new Aes('1234567890123456');
$data = "php从入门到放弃";
echo $eStr = $obj->encrypt($data);  //加密后的密文
echo "<hr>";
echo $obj->decrypt($eStr);
//57902A2EF7897E101E5F7CBCEF98BAC9
//
// str:aabbcc
// key:1234567890123456
// result:
// 8263AB6D6DB5BE41C098B27CBB1D6A39
// 8263AB6D6DB5BE41C098B27CBB1D6A39
