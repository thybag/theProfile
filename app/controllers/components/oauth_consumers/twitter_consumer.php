<?php
class TwitterConsumer extends AbstractConsumer {
    public function __construct() {
        parent::__construct( TWIT_KEY , TWIT_SECRET);
    }
}