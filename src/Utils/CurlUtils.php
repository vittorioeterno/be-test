<?php

namespace App\Utils;


class CurlUtils {

    public static function http_build_query_for_curl( $arrays, &$new = array(), $prefix = null ) {

        if ( is_object( $arrays ) ) {
            $arrays = get_object_vars( $arrays );
        }
    
        foreach ( $arrays AS $key => $value ) {
            $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
            if ( is_array( $value ) OR is_object( $value )  ) {
                self::http_build_query_for_curl( $value, $new, $k );
            } else {
                $new[$k] = $value;
            }
        }
    }

    public static function data_encode($data, $keyprefix = "", $keypostfix = "") {
        assert( is_array($data) );
        $vars=null;
        foreach($data as $key=>$value) {
          if(is_array($value)) $vars .= self::data_encode($value, $keyprefix.$key.$keypostfix.urlencode("["), urlencode("]"));
          else $vars .= $keyprefix.$key.$keypostfix."=".urlencode($value)."&";
        }
        return $vars;
      }

    public static function execCompleteCurl($url, $data, $header=array(), $addition_data=array(),$method="POST", $is_async=false) {

        $post_data = [];
        if(is_array($data)) {
            // $post_data = http_build_query($data, '', "&");

            // self::http_build_query_for_curl($data, $post_data);
            // $post_data = urldecode(http_build_query($post_data));

            // $post_data = urldecode(substr(self::data_encode($data), 0, -1));

            $post_data = json_encode($data);
        } else {
            $post_data = $data;
        }

        // var_dump($post_data);

        $defaults = array(
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $post_data
        );
        
        if (
            defined("CURL_VERSION_HTTP2") &&
            (curl_version()["features"] & CURL_VERSION_HTTP2) !== 0
        ) {
            $defaults[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2_0;
        }

        if ($is_async) {
            $defaults[CURLOPT_TIMEOUT_MS] = 200;
            $defaults[CURLOPT_NOSIGNAL] = 1;
        } else {
            $defaults[CURLOPT_TIMEOUT] = 0;
        }

        if($addition_data) {
            $defaults = $addition_data + $defaults;
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, $defaults);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(!$result) {
            //return "CURL FAILED: ".curl_error($ch);
            if (!$is_async) {
                throw new \Exception("CURL FAILED: ".curl_error($ch), 500);
            }
            return null;
        }

        curl_close($ch);

        return [
            "result" => $result,
            "http_code" => $httpcode
        ];
    }


    public static function execCompleteGetCurl($url, $header=array(), $addition_data=array(), $is_async=false) {

        $defaults = array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_URL => $url,
        );

        if (
            defined("CURL_VERSION_HTTP2") &&
            (curl_version()["features"] & CURL_VERSION_HTTP2) !== 0
        ) {
            $defaults[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2_0;
        }

        if ($is_async) {
            $defaults[CURLOPT_TIMEOUT_MS] = 200;
            $defaults[CURLOPT_NOSIGNAL] = 1;
        } else {
            $defaults[CURLOPT_TIMEOUT] = 0;
        }

        if($addition_data) {
            $defaults = $addition_data + $defaults;
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, $defaults);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(!$result) {
            if (!$is_async) {
                throw new \Exception("CURL FAILED: ".curl_error($ch), 500);
            }
            return null;
        }

        curl_close($ch);

        return [
            "result" => $result,
            "http_code" => $httpcode
        ];
    }


}