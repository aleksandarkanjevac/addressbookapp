<?php


namespace core\models;

class ContactViews implements ModelDbInterface {

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
     * @var int $user_id
     */
    public $user_id;
    
    /**
     * @var string $start_time DATE and TIME string
     */
    public $start_time;
    
    public function __construct() {

    }

    public static function table() {
        return 'contact_views';
    }

    
}
