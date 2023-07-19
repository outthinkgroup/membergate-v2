<?php

namespace Membergate\Common;

if (!defined('ABSPATH')) {
    exit;
}

class JsonResponse extends \WP_HTTP_Response {
    public function send() {
        status_header($this->status);
        $this->send_headers($this->headers);
        echo json_encode($this->jsonSerialize());
    }

    /**
     * Sends an HTTP header.
     *
     * @since 4.4.0
     *
     * @param string $key Header key.
     * @param string $value Header value.
     */
    public function send_header($key, $value) {
        /*
         * Sanitize as per RFC2616 (Section 4.2):
         *
         * Any LWS that occurs between field-content MAY be replaced with a
         * single SP before interpreting the field value or forwarding the
         * message downstream.
         */
        $value = preg_replace('/\s+/', ' ', $value);
        header(sprintf('%s: %s', $key, $value));
    }

    /**
     * Sends multiple HTTP headers.
     *
     * @since 4.4.0
     *
     * @param array $headers Map of header name to header value.
     */
    public function send_headers($headers) {
        foreach ($headers as $key => $value) {
            $this->send_header($key, $value);
        }
    }
}
