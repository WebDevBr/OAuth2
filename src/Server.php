<?php

namespace WebDevBr\OAuth2;

use WebDevBr\OAuth2\Storage\StorageInterface;
use WebDevBr\OAuth2\Errors\UnauthorizedClientException;
use WebDevBr\OAuth2\Errors\UnauthorizedTokenException;

class Server
{
    public function clientAuthorization()
    {
        extract((new Request)->client());

        $client = new Client($client_id, $secret, $this->client_storage);

        if (!$client->validate()) {
            throw new UnauthorizedClientException("Client not found");
        }

        return (new Token)->generate($this->token_storage);
    }

    public function accessAuthorization()
    {
        extract((new Request)->authorization());
        $authorization_token = $this->token_storage->get($token);

        if (!$authorization_token) {
            throw new UnauthorizedTokenException("Token not found");
        }

        $this->token_storage->remove($token);

        $token = (new Token)->generate($this->access_token_storage);

        return $redirect_url.'?token='.$token;
    }

    public function requestIsValid()
    {
        $token = (new Request)->token();

        $token = $this->access_token_storage->get($token);

        if ($token) {
            return true;
        }

        return false;
    }

    public function setClientStorage(StorageInterface $storage)
    {
        $this->client_storage = $storage;
    }

    public function setAccessTokenStorage(StorageInterface $storage)
    {
        $this->access_token_storage = $storage;
    }

    public function setAuthenticationTokenStorage(StorageInterface $storage)
    {
        $this->token_storage = $storage;
    }
}
