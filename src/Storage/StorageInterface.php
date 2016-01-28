<?php

namespace WebDevBr\OAuth2\Storage;

interface StorageInterface
{
    public function get($id);
    public function insert(\stdClass $data);
    public function remove($id);
}
