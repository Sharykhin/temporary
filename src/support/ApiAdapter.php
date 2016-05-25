<?php

namespace Language\Support;

use Language\Contracts\ApiContract;
use Language\ApiCall;
use Language\Exceptions\ApiException;
use Language\Exceptions\ApiWrongContentException;
use Language\Exceptions\ApiWrongResponseException;

/**
 * It's not a real adapter, I think some sort of wrapper,
 * Class ApiAdapter
 * @package Support
 */
class ApiAdapter implements ApiContract
{
    /** @var ApiCall  */
    private $apiCall;

    /**
     * ApiAdapter constructor.
     * @param ApiCall $apiCall
     * @TODO: use interface instead of specific implementation
     */
    public function __construct(ApiCall $apiCall)
    {
        $this->apiCall = $apiCall;
    }

    public function call($target, $mode, $getParameters, $postParameters)
    {
        $result = $this->apiCall->call($target, $mode, $getParameters, $postParameters);

        // Error during the api call.
        if ($result === false || !isset($result['status'])) {
            throw new ApiException('Error during the api call');
        }
        // Wrong response.
        if ($result['status'] != 'OK') {
            throw new ApiWrongResponseException($result['status'], 'Wrong response: '
                . (!empty($result['error_type']) ? 'Type(' . $result['error_type'] . ') ' : '')
                . (!empty($result['error_code']) ? 'Code(' . $result['error_code'] . ') ' : '')
                . ((string)$result['data']));
        }
        // Wrong content.
        if ($result['data'] === false) {
            throw new ApiWrongContentException($result['data'], 'Wrong content!');
        }

        return $result;
    }
    
    
}