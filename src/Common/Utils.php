<?php
namespace Membergate\Common\Utils;

function get_request_body () {
    $body = file_get_contents("php://input");
    $body = json_decode($body);
    return $body;
}

