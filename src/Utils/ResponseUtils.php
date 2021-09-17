<?php 

namespace App\Utils;

use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseUtils {

    /** @var JsonResponse $response */
    private $response;


    /**
     * $message param is the source.id of the message to translate
     * $params is an array of optional parameters required for translation:
     * - array('%name%' => $name)
     *
     * @param array $results
     * @param int $status
     * @param string $TargetLanguageCode
     * @param string $id_account
     * @param string $SourceLanguageCode
     * @return JsonResponse
     */
    public function getResponse($results = [], $status = 200) {

        $this->response = new JsonResponse();

        $this->response->headers->set('Access-Control-Allow-Origin', '*');
        $this->response->setStatusCode($status);
        $this->response->setData($results);

        return $this->response;
    }

    /**
     * This method check if there are results and return correct json response
     *
     * @param array $results
     * @param string $message
     * @param int $status
     * @param array $params
     * @return JsonResponse
     */
    public function getListResponse($results = [], $message = '', $status = 200, $params = []) {

        $this->response->setStatusCode($status);
        $this->response->headers->set("Access-Control-Expose-Headers", "CURRENT-PAGE, TOTAL-PAGES, TOTAL-ITEMS");

        if (is_null($results) || count($results) == 0 || !isset($results['list'])) {
            $results['list'] = array();
            $results['current_page'] = 0;
            $results['total_pages'] = 0;
            $results['total_items'] = 0;
        }

        $this->response->headers->set('Access-Control-Allow-Origin', '*');
        $this->response->headers->set("CURRENT-PAGE", $results['current_page']);
        $this->response->headers->set("TOTAL-PAGES", $results['total_pages']);
        $this->response->headers->set("TOTAL-ITEMS", $results['total_items']);


        $this->response->setData(array(
            "status" => $status,
            "message" => $message,
            "results" => $results['list']
        ));

        return $this->response;
    }

    /**
     * @param $totalItems
     * @param string $message
     * @param int $status
     * @param array $params
     * @return JsonResponse
     */
    public function getHeadResponseTotalItems($totalItems, $message = '', $status = 200, $params = array()) {

        $this->response->setStatusCode($status);
        $this->response->headers->set("Access-Control-Expose-Headers", "TOTAL-ITEMS");
        $this->response->headers->set('Access-Control-Allow-Origin', '*');
        $this->response->headers->set("TOTAL-ITEMS", $totalItems);

        return $this->response;
    }

}