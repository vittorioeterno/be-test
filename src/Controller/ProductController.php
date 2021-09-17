<?php

namespace App\Controller;

use App\Service\ProductService;
use App\Utils\IntegerUtils;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use App\Utils\ResponseUtils;
use DateTime;

class ProductController extends AbstractFOSRestController {


    /**
     * Get products list
     *
     * @Rest\Get("/products")
     *
     * @SWG\Response(
     *     response=500,
     *     description="Internal error occurred.",
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Products list returned.",
     * ),
     * @SWG\Tag(name="Product")
     *
     * @param   Request $request
     * @param   ResponseUtils $response
     * @param   ProductService $product_service
     *
     * @return  JsonResponse
     */
    public function getProductsListAction(Request $request, ResponseUtils $response, ProductService $product_service) {
        
        $response_params["data"] = [];

        try {

            $products = $product_service->getProducts();

        
            if (!is_null($products) && !empty($products) && count($products)>0) {
                $i=0;
                foreach ($products as $product) {
                    $response_params["data"][$i]["id"] = intval($product["id"]);
                    $response_params["data"][$i]["name"] = $product["id"];
                    $response_params["data"][$i]["description"] = $product["id"];
                    $response_params["data"][$i]["image"] = ["src"=>$product["image"]["src"]];

                    $i++;
                }
            }

        } catch (\Exception $e) {
            
            $status_code = $e->getCode();
            if ($status_code == 0) 
                $status_code = 500;
            
            return $response->getResponse(["error"=>$e->getMessage()], $status_code);
        }

        return $response->getResponse($response_params, 200);

    }

    /**
     * Get single product
     *
     * @Rest\Get("/products/{id_product}")
     *
     * @SWG\Response(
     *     response=500,
     *     description="Internal error occurred.",
     * ),
     * @SWG\Response(
     *     response=200,
     *     description="Products list returned.",
     * ),
     * @SWG\Tag(name="Product")
     *
     * @param   $id_product
     * @param   Request $request
     * @param   ResponseUtils $response
     *
     * @return  JsonResponse
     */
    public function getProductAction($id_product, Request $request, ResponseUtils $response, ProductService $product_service) {

        if (is_null($id_product) || !IntegerUtils::checkId($id_product)) {
            return $response->getResponse(["error"=>"l'identificativo non è valido"], 400);
        }

        $response_params["data"] = [];

        try {

            $product = $product_service->getProducts($id_product);

            if (!is_null($product)) {
                $i = 0;
                $response_params["data"][$i]["id"] = intval($product["id"]);
                $response_params["data"][$i]["name"] = $product["id"];
                $response_params["data"][$i]["description"] = $product["id"];
                $response_params["data"][$i]["image"] = ["src"=>$product["image"]["src"]];

            }

        } catch (\Exception $e) {
            
            $status_code = $e->getCode();
            if ($status_code == 0) 
                $status_code = 500;
            
            return $response->getResponse(["error"=>$e->getMessage()], $status_code);
        }

        return $response->getResponse($response_params, 200);
        
    }




}