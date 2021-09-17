<?php

namespace App\Service;

use App\Schema\Service;
use App\Utils\CurlUtils;

class ProductService extends Service {

    private $url_domain;

    public $addition_data = [];
    public $header = [];

    /**
     * ProductService constructor.
     * 
     * @param $url_domain
     */
    public function __construct($url_domain) {
        $this->url_domain = $url_domain;

        $addition_data = array(
            CURLOPT_VERBOSE => 1,
        );
    }


    public function getProducts ($id=null) {
        try {
            $url = $this->url_domain."/products";
            if (!is_null($id)) {
                $url .= "?categoryId=".$id;
            }

            $response_curl = CurlUtils::execCompleteGetCurl($url,$this->header,$this->addition_data);

            if (!is_null($response_curl)) {

                $message='';
                $respons_array = json_decode($response_curl["result"], true);
                if(is_array($respons_array)) { 

                    if (isset($respons_array["message"])) {
                        $message = $respons_array["message"];
                    }

                    if (isset($respons_array["error"])) {
                        $message = $respons_array["error"];
                    }
                }

                return $respons_array;

            }

            return null;

        }catch (\Exception $e) {
            throw $e;
        }
    }

}
