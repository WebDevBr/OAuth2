<?php

namespace WebDevBr\OAuth2;

use Symfony\Component\HttpFoundation\Request as Req;

class Request
{
    public function __construct()
    {
        $this->request = new Req(
            array_merge($_GET, $_POST),
            array_merge($_GET, $_POST),
            array(),
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
    }

    public function client()
    {
        $data['client_id'] = $this->request->query->get('client_id');
        $data['secret'] = $this->request->query->get('client_secret');

        if (!$data['client_id']) {
            throw new \Exception("'client_id' is required in URL");
        }

        if (!$data['secret']) {
            throw new \Exception("'client_secret' is required in URL");
        }

        return $data;
    }

    public function authorization()
    {
        $data['token'] = $this->request->query->get('token');
        $data['redirect_url'] = $this->request->query->get('redirect_url');

        if (!$data['token']) {
            throw new \Exception("'token' is required in URL");
        }

        if (!$data['redirect_url']) {
            throw new \Exception("'redirect_url' is required in URL");
        }

        return $data;
    }

    public function token()
    {
        //php7: $token = getallheaders()['Authorization'] ?? null;
        $token = null;
        if (!empty(getallheaders()['Authorization'])) {
            $token = getallheaders()['Authorization'];
        }

        if (!$token) {
            $token = $this->request->query->get('token');
        }

        if (!$token) {
            throw new \Exception("'token' is required in URL or header Authorization");
        }

        return $token;

    }
}
