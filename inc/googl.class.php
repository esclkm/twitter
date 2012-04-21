<?php  

// Для начала проверим существование возможности ;)
if (!function_exists('curl_init')) 
    trigger_error('CURL is not installed');     

/** 
 * GoogleURL 
 *  
 * Небольшой класс для модификации урлов посредством Goo.gl  
 *  
 * @author Bas van Dorst <info@basvandorst.nl> 
 * @version 1.0  
 * @package Google 
 */ 

class GoogleURL { 
     
    /** 
     * Адрес Google URL shortener API 
     * @var string 
     */ 
    private static $_api = "http://goo.gl/api/shorten"; 
     
    /** 
     * Таймаут Curl 
     * @var int 
     */ 
    private static $_curl_timeout = 5; 
     
    /** 
     * URL-regex (http://flanders.co.nz/2009/11/08/a-good-url-regular-expression-repost/) 
     * @var string 
     */ 
    private static $_urlregex = '/(?:(?:ht|f)tp(?:s?)\:\/\/|~\/|\/)?(?:\w+:\w+@)?(?:(?:[-\w]+\.)+(?:com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum|travel|[a-z]{2}))(?::[\d]{1,5})?(?:(?:(?:\/(?:[-\w~!$+|.,=]|%[a-f\d]{2})+)+|\/)+|\?|#)?(?:(?:\?(?:[-\w~!$+|.,*:]|%[a-f\d{2}])+=(?:[-\w~!$+|.,*:=]|%[a-f\d]{2})*)(?:&(?:[-\w~!$+|.,*:]|%[a-f\d{2}])+=(?:[-\w~!$+|.,*:=]|%[a-f\d]{2})*)*)*(?:#(?:[-\w~!$+|.,*:=]|%[a-f\d]{2})*)?/'; 
     
    /** 
     * Замена существующего URL ссылкой, полученной от Goo.gl URL. 
     *  
     * @param string|array $input_url 
     * @return string если успешно, и запрашиваемый URL при провале. 
     */ 
    public static function shortURL($input_url)  
    { 
        /** 
         * Получаем первое значение массива, если $input_url является массивом (результат shortText) 
         */ 
        $url = ( is_array( $input_url ) ) ? $input_url[0] : $input_url; 
         
        /** 
         *  
         */ 
        $post_fields = array(    "security_token" => "null", 
                                             "url"                    => $url 
                                        );   
          
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, self::$_api); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_setopt($ch, CURLOPT_POST, TRUE); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $post_fields ) ); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$_curl_timeout); 
        $output = json_decode( curl_exec($ch) ); // Google возвращает JSON-объект 
        curl_close($ch); 
         
        return (isset( $output->short_url )) ? $output->short_url : $url; 
    } 
     
    /** 
     * Заменяем все  ссылки в text/HTML-document на Goo.gl ссылки 
     *  
     * @param string $input_text 
     * @return array|null 
     */ 
    public static function shortText($input_text)  
    { 
        return preg_replace_callback( 
                    self::$_urlregex,  
                    __CLASS__.'::shortURL',  
                    $input_text 
                ); 
    } 
}
?>