<?php


namespace core\models;

class Login implements ModelDbInterface{
    use ModelTrait;
    
    /**
     * @var int $id
     */
    public $id;
    
    /**
     * @var int $user_id
     */
    public $user_id;
    
     /**
     * @var string $loged_at DATE and TIME string
     */
    public $loged_at;
    
     /**
     * @var string $logout_at DATE and TIME string
     */
    public $logout_at;
    
    public function __construct() {

    }

    public static function table() {
        return 'login';
    }
}
