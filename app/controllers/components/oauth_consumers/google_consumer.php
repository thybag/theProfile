<?php
class GoogleConsumer extends AbstractConsumer {
    public function __construct() {
        parent::__construct(GOOG_KEY, GOOG_SECRET);
    }
}