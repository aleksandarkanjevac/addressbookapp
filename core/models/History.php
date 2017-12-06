<?php

namespace core\models;

class History implements ModelDbInterface{

    use ModelTrait;

    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $table_name
     */
    public $table_name;

    /**
     * @var int $contact_id
     */
    public $contact_id;

    /**
     * @var int $contact_type
     */
    public $contact_type;

    /**
     * @var string $old_record BLOB string
     */
    public $old_record;

    /**
     * @var string $new_record BLOB string
     */
    public $new_record;

    /**
     * @var int $user_id
     */
    public $user_id;

    /**
     * @var string $created_at DATE and TIME string
     */
    public $created_at;

    public function __construct() {
        
    }

    public static function table() {
        return 'history';
    }

}
