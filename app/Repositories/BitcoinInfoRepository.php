<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;


class BitcoinInfoRepository
{

    protected $currency = null;

    public $response = null;

    protected $base_url = 'https://api.coindesk.com/v1/bpi/historical/close.json';

    protected $parameters = [];


    /**
     * this is construct
     *
     * @param String   $currency  something like eg( usd, eur)
     * @author Palash
     */
    function __construct(String $currency)
    {
        $this->currency = $currency;
        $this->setUrlParam('currency', $currency);
    }

     /**
     * set the base url to get data
     *
     * @param String $url
     * @author Palash
     */
    public function setBaseUrl($url)
    {
        $this->base_url = $url;
    }

     /**
     * you can set the parameters using the method that will use when feath data
     *
     * @param String $key that shuld be qnique
     * @param String $value you can pass any string data
     * @author Palash
     * @return this
     */
    public function setUrlParam($key, $value)
    {
        $this->parameters[$key] = $value;
        return $this;
    }

     /**
     * this funciton feath data from api
     *
     * @return $response
     * @author Palash
     */
    public function get()
    {
        $response       = Http::get($this->base_url, $this->parameters);
        $this->response = $response;
        return $this->response;
    }

    /**
     * filter minimum rate from response also return rate
     *
     * @return $minRate
     * @author Palash
     */
    public function getMinRate()
    {
        $resArray     = (array)json_decode($this->response->body());
        $priceList  = (array)$resArray['bpi'];
        asort($priceList);

        return head(array_values($priceList));
    }

    /**
     * filter maximum rate from response also return rate
     *
     * @return $maxRate
     * @author Palash
     */
    public function getMaxRate()
    {
        $resArray     = (array)json_decode($this->response->body());
        $priceList  = (array)$resArray['bpi'];
        arsort($priceList);

        return head(array_values($priceList));
    }

    /**
     * filter current rate from response also return rate
     *
     * @return $currentRate
     * @author Palash
     */
    public function getCurrentRate()
    {
        $resArray     = (array)json_decode($this->response->body());
        $price  = ((array)$resArray['bpi'])[strtoupper($this->currency)];

        return $price;
    }
}
