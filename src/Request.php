<?php

namespace WebDevBr\OAuth2;

use Symfony\Component\HttpFoundation\Request as Req;

class Request
{
    public function __construct()
    {
        $this->request = Req::createFromGlobals();
    }

    public function client()
    {
        $data['client_id'] = $this->request->query->get('client_id');
        $data['secret'] = $this->request->query->get('secret');

        if (!$data['client_id']) {
            throw new \Exception("'client_id' is required in URL");
        }

        if (!$data['secret']) {
            throw new \Exception("'secret' is required in URL");
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
        $token = $this->request->headers->get('Authorization');

        if (!$token) {
            $token = $this->request->query->get('token');
        }

        if (!$token) {
            throw new \Exception("'token' is required in URL or header Authorization");
        }

        return $token;

    }
}
