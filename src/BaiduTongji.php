<?php
/**
 * Created by PhpStorm.
 * User: mushan
 * Date: 2016/11/26
 * Time: 12:50
 */

namespace JoseChan\BaiduTongji;

use JoseChan\BaiduTongji\Login;

class BaiduTongji
{
    const API_URL = 'https://openapi.baidu.com/rest/2.0/tongji';

    private $config;


    public function __construct($config = array())
    {
        $this->config = $config;
    }

    public function __get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : false;
    }

    public function __set($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * @param \Redis $redis
     * @throws \Exception
     * @return string
     */
    public function getAccessToken($redis)
    {
        if(!$access_token = $redis->get("bdtj:access_token")){
            if(!$refresh_token = $redis->get("bdtj:refresh_token")){
                $refresh_token = $this->refresh_token;
            }
            $result = curl_post("http://openapi.baidu.com/oauth/2.0/token?grant_type=refresh_token&refresh_token={$refresh_token}&client_id={$this->client_id}&client_secret={$this->client_secret}", []);
            $result = !empty($result) ? json_decode($result, true) : [];
            $access_token = isset($result['access_token']) ? $result['access_token']: "";
            if(!empty($access_token)){
                $redis->set("bdtj:access_token", $access_token);
                $redis->set("bdtj:refresh_token", $result['refresh_token']);
                $redis->expire("bdtj:access_token", $result['expires_in']);
            }
        }

        return $access_token;
    }

    public function getSiteLists($access_token, $is_concise = false)
    {
        $result = $this->request('config/getSiteList?access_token=' . $access_token, null);

        if (empty($result['list'])) {
            throw new \Exception('没有站点');
        }

        $list = $result['list'];

        if ($is_concise) {
            $list = (collect($list))->pluck('domain', 'site_id')->toArray();
        }

        return $list;
    }

    public function getData($params)
    {
        $query = http_build_query($params);
        $result = $this->request("report/getData?{$query}", []);

        return $result['result'];
    }

    private function request($type, $post_data)
    {
        $result = curl_post(self::API_URL . '/' . $type, json_encode($post_data), []);
        $result = json_decode($result, true);

        return $result;
    }
}