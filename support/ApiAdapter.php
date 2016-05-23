<?php

namespace Support;

use Contracts\ApiContract;
use Language\ApiCall;
use Exceptions\ApiException;
use Exceptions\ApiWrongContentException;
use Exceptions\ApiWrongResponseException;

/**
 * It's not a real adapter, I think some sort of wrapper,
 * Class ApiAdapter
 * @package Support
 */
class ApiAdapter implements ApiContract
{
    private static $apiCall;

    /**
     * ApiAdapter constructor.
     * @param ApiCall $apiCall
     * @TODO: use interface instead of specific implementation
     */
    public function __construct(ApiCall $apiCall)
    {
        self::$apiCall = $apiCall;
    }

    public static function call($target, $mode, $getParameters, $postParameters)
    {
        $result = self::$apiCall->call($target, $mode, $getParameters, $postParameters);

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