<?php
namespace xuyang\UrlScanner\Url;

use GuzzleHttp\Client;

class Scanner
{
    protected $urls;
    protected $httpClient;
    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = new Client();
    }

    /**
     * 获取访问这个url的http状态码
     *
     * @param [string] $url
     * @return int
     */
    public function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->get($url);
        return $httpResponse->getStatusCode();
    }

    /**
     * 获取死链
     *
     * @return array
     */
    public function getInvalidUrls()
    {
        $invalidUrls = [];
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }
            
            if ($statusCode >= 400){
                array_push($invalidUrls, ['url' => $url, 'status' => $statusCode]);
            }            
        }

        return $invalidUrls;
    }
}
