<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
    

    public function successResponse($result, $message, $code = 200, $paginate = false)
    {
        $requestPath = str_replace('api/','',request()->getPathInfo());
        if($requestPath!='/consent/get' && $requestPath!='/consent/update' ) {
            // Solution Sanitization
           // $result = $this->sanitizeResponse($result, $paginate);
        }
        $this->result = $result;
        if ($paginate) {
            $this->result = $this->paginate($result);
        }

        $response = [
            'success' => true,
            'code'    => $code,
            'message' => $message,
            'data'   => $this->result
        ];

        //$this->logFile($response);


        return response()->json($response, 200);
    }

    protected function sanitizeResponse($result, $paginate = false)
    {
        $input = $result;
        if (!$paginate) {

            if (is_object($input)) {
                if (method_exists($input, 'collect')) {
                    $input = json_decode($input, true);
                } else {
                    if (property_exists('collection', $input)) {
                        $input = json_decode($input->collection, true);
                    } else {
                        $input = json_decode(json_encode($input), true);
                    }
                }
            }
			
			if(isset($input["is_data_sanitization"]) && $input["is_data_sanitization"] == 1){
                return $input;
            }

            return $this->stripTagsDeep($input);
        } else {
            if (is_object($input)) {
                if (method_exists($input, 'collect')) {
                    $input = json_decode($input, true);
                } else {
                    if (property_exists('collection', $input)) {
                        $input = json_decode($input->collection, true);
                    } else {
                        if (method_exists($input, 'items')) {
                            $input = $input->items();
                        } else {
                            $input = (array)$input;
                        }
                    }
                }
            }
            $paginatedOutput = $this->stripTagsDeep($input);
            $currentPage = $result->currentPage();
            $perPage = $result->perPage();
            $options = array();
            $total = $result->total();
            $result = $paginatedOutput;
            $result = $result instanceof Collection ? $result : Collection::make($result);
            return  new LengthAwarePaginator($result, $total, $perPage, $currentPage, $options);
        }
    }

    private function stripTagsDeep($value)
    {
        if (is_array($value)) {
            array_walk_recursive($value, function (&$value) {
                if (!is_array($value) && is_string($value)) {
                    $value = strip_tags($value);
                }
            });
        } else {
            $value = strip_tags($value);
        }
        return $value;
    }

   
    public function paginate($data = [])
    {

        if ($data != null) {


            $data->currentPage() ?: (Paginator::resolveCurrentPage() ?: 1);
            $data instanceof Collection ? $data : Collection::make($data);

            $items = array_values($data->items());


            $paginationArray = array('list' => $items, 'pagination' => []);
            $paginationArray['pagination']['total'] = $data->total();
            $paginationArray['pagination']['current'] = $data->currentPage();
            $paginationArray['pagination']['first'] = 1;
            $paginationArray['pagination']['last'] = $data->lastPage();

            if ($data->hasMorePages()) {
                if ($data->currentPage() == 1) {
                    $paginationArray['pagination']['previous'] = 0;
                } else {
                    $paginationArray['pagination']['previous'] = $data->currentPage() - 1;
                }
                $paginationArray['pagination']['next'] = $data->currentPage() + 1;
            } else {
                $paginationArray['pagination']['previous'] = $data->currentPage() - 1;
                $paginationArray['pagination']['next'] =  $data->lastPage();
            }
            if ($data->lastPage() > 1) {
                $paginationArray['pagination']['pages'] = range(1, $data->lastPage());
            } else {
                $paginationArray['pagination']['pages'] = [1];
            }
            $paginationArray['pagination']['from'] = $data->firstItem();
            $paginationArray['pagination']['to'] = $data->lastItem();
            return $this->result = $paginationArray;
        }
    }
	
    public function errorResponse($error, $errorMessages = [], $code = 203)
    {

        $response = [
            'success' => false,
            'code'    => $code,
            'message' => $error,
            'data'    => []
        ];


        return response()->json($response, $code);
    }
}