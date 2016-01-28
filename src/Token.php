<?php

namespace WebDevBr\OAuth2;

use WebDevBr\OAuth2\Storage\StorageInterface;

class Token
{
    public function generate(StorageInterface $storage)
    {
        $this->storage = $storage;

        $token = $this->create();
        $save_ok = $this->persist($token, $storage);

        if (!is_bool($save_ok)) {
            throw new \Exception("Token storage must return a bolean value");
        }

        if (!$save_ok) {
            $token = $this->generate($storage);
        }

        return $token;
    }

    protected function create()
    {
        return hash('sha256', microtime());
    }

    protected function persist($token)
    {
        $data = new \stdClass();
        $data->token = $token;

        return $this->storage->insert($data);
    }
}
