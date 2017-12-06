<?php

namespace core\models;

class ContactData implements ModelDbInterface {
     use ModelTrait;

    /**
     * @var int $id
     */
    public $id;
    /**
     * @var int $contact_id
     */
    public $contact_id;
    /**
     * @var int $type
     */
    public $type;
    /**
     * @var string $data
     */
    public $data;
    /**
     * @var int $status
     */
    public $status;

    public function __construct() {

    }

    public static function table() {
        return 'contact_data';
    }
}
