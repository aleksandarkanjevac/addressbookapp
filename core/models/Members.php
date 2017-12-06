<?php

namespace core\models;

class Members implements ModelDbInterface {

    use ModelTrait;

    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $first_name
     */
    public $first_name;

    /**
     * @var string $last_name
     */
    public $last_name;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var int $status
     */
    public $status;

    /**
     * @var string $created_at DATE and TIME string
     */
    public $created_at;
    /**
     * @var string $remember_token
     */
    public $remember_token;

    public function __construct() {
        
    }

    public static function table() {
        return 'members';
    }

    public function getFullName() {
        return "{$this->first_name} {$this->last_name}";
    }

}
