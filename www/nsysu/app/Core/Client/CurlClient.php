<?php
namespace App\Core\Client;

class CurlClient
{
    protected $client;
    protected $baseUrl;
    protected $timeout;
    protected $ssl;

    public function __construct()
    {
        $this->client = curl_init();
    }

    protected function setSSL($bool = true)
    {
        $this->ssl = $bool;
    }

    protected function putParameter($key, $value)
    {
        if (empty($this->parameters)) {
            $this->parameters = [];
        }
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $parameters
     * @return $this
     */
    protected function putParameters($parameters = [])
    {
        foreach ($parameters as $key => $value) {
            $this->putParameter($key, $value);
        }
        return $this;
    }

    /**
     * build http request's set value
     *
     * @return void
     */
    protected function buildOption()
    {
        $option = [];
        if (!empty($this->parameters)):
            $option = http_build_query($this->parameters);
        endif;

        return $option;
    }

    /**
     * send http reauest
     *
     * @param string $method
     * @param string $path
     * @return curl_exec
     */
    protected function request($method, $path)
    {
        curl_setopt($this->client, CURLOPT_URL , $this->baseUrl . $path);
        curl_setopt($this->client, CURLOPT_SSL_VERIFYHOST, $this->ssl);
        curl_setopt($this->client, CURLOPT_SSL_VERIFYPEER, $this->ssl);

        if(strtolower($method) === 'post'):
            curl_setopt($this->client, CURLOPT_CUSTOMREQUEST , 'POST');
            curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->client, CURLOPT_POSTFIELDS, $this->buildOption());
        else:

        endif;

        $response = curl_exec($this->client);

        return $response;
    }
}