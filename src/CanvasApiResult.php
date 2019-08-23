<?php

namespace Uncgits\CanvasApi;

/**
 * Represents a set of results from the API, obtained via one or more API calls
 */
class CanvasApiResult
{
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /**
     * The API calls that were made to get this resultset
     *
     * @var array
     */
    private $calls = [];

    /**
     * The overall status of the API resultset
     *
     * @var string
     */
    private $status = '';

    /**
     * Longer message representing the status of the API resultset
     *
     * @var string
     */
    private $message = '';

    /**
     * A collection of Canvas Resources obtained in this resultset
     *
     * @var array
     */
    public $content = [];

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get the API calls that were made to get this resultset
     *
     * @return  array
     */
    public function getCalls()
    {
        return $this->calls;
    }

    /**
     * Get the overall status of the API resultset
     *
     * @return  string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get longer message representing the status of the API resultset
     *
     * @return  string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * Set the API calls that were made to get this resultset
     *
     * @param  array  $calls  The API calls that were made to get this resultset
     *
     * @return  self
     */
    public function setCalls(array $calls)
    {
        // check for single call from call() vs. array of calls from paginate()
        if (isset($calls['request']) && isset($calls['response'])) {
            $calls = [$calls];
        }

        $this->calls = $calls;
        return $this;
    }

    /**
     * Set the overall status of the API resultset
     *
     * @param  string  $status  The overall status of the API resultset
     *
     * @return  self
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Set longer message representing the status of the API resultset
     *
     * @param  string  $message  Longer message representing the status of the API resultset
     *
     * @return  self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function __construct(array $calls)
    {
        // set the calls
        $this->setCalls($calls);
        // parse calls to get results and content
        $this->parseCalls($calls);
    }

    public function parseCalls()
    {
        // parse content
        $failedCalls = [];

        foreach ($this->calls as $call) {
            if ($call['response']['code'] >= 400) {
                $failedCalls[] = $call;
            }

            if (isset($call['response']['body']) && !empty($call['response']['body'])) {
                if (is_object($call['response']['body'])) {
                    $this->content = $call['response']['body'];
                } else {
                    $this->content = array_merge($this->content, $call['response']['body']);
                }
            }
        }

        $this->status = empty($failedCalls) ? 'success' : 'error';
        $this->message = empty($failedCalls) ?
                count($this->calls) . ' call(s) successful.' :
                count($failedCalls) . ' call(s) had errors.';

        return $this;
    }
}
