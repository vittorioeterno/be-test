<?php

namespace App\Controller;

use App\Entity\Product;
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
     * Get products list add param ?categoryId= to filter results
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
      
        $category_id = $request->query->get("categoryId");
        if (!is_null($category_id) && !IntegerUtils::checkId($category_id)) {
            return $response->getResponse(["error"=>"l'identificativo non è valido"], 400);
        }

        $response_params["data"] = [];

        try {

            $products = $product_service->getProducts($category_id);

        
            if (!is_null($products) && !empty($products) && count($products)>0) {
                $i=0;
                /** @var Product $product */
                foreach ($products as $product) {
                    $response_params["data"][$i]["id"] = intval($product->getId());
                    $response_params["data"][$i]["name"] = $product->getName();
                    $response_params["data"][$i]["description"] = $product->getDescription();
                    $response_params["data"][$i]["image"] = ["src"=>$product->getImageSrc()];

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


}