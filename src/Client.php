<?php

namespace WebDevBr\OAuth2;

use WebDevBr\OAuth2\Storage\StorageInterface;

class Client
{
    public function __construct($client_id, $secret, StorageInterface $storage)
    {
        $this->client = $storage->get($client_id);
        $this->storage = $storage;
        $this->client_id = $client_id;
        $this->secret = $secret;
    }

    public function validate()
    {
        if (!isset($this->client->secret)) {
            throw new \Exception("Client storage must have a secret value");
        }

        return $this->client->secret ==$this->secret;
    }

    public function get()
    {
        return $this->client;
    }

    public function persist()
    {
        $data = new \stdClass();
        $data->client_id = $client_id;
        $data->secret = $secret;

        return $this->storage->insert($data);
    }
}
