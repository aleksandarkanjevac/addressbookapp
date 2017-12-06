<?php


namespace core\models;


class Contact implements ModelDbInterface{
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
     * @var string $contact_img
     */
    public $contact_img;
    /**
     * @var string $created_at DATE and TIME string
     */
    public $created_at;
    /**
     * @var int $created_by Member id
     */
    public $created_by;
    /**
     * @var int $status
     */
    public $status;

    public function __construct() {

    }

    public static function table() {
        return 'contact';
    }

    public function getFullName() {
        return "{$this->first_name} {$this->last_name}";
    }

    public static function getAllowedContacts($status, $options, $asModel) {
        $conn = \core\Db::getConn();
        try {


            $sql = 'SELECT * FROM ' . self::table() . ' WHERE status <= :status';
            if (array_key_exists('orderBy', $options) && is_array($options['orderBy'])) {
                $orderBy = implode(', ', $options['orderBy']);
                $sql .= " ORDER BY {$orderBy}";
            }

            if (array_key_exists('pagination', $options) && array_key_exists('page', $options['pagination']) && array_key_exists('limit', $options['pagination'])) {
                $start = $options['pagination']['page'] * $options['pagination']['limit'];
                $sql .= " LIMIT {$start}, {$options['pagination']['limit']}";
            }

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':status', $status);
            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();

            if (!$rows) {
                return [];
            }

            if (!$asModel) {
                return $rows;
            }


            $className = get_called_class();
            $models = [];
            foreach ($rows as $row) {
                $model = new $className;
                foreach ($row as $attr => $val) {
                    if (property_exists($model, $attr)) {
                        $model->{$attr} = $val;
                    }
                }
                $models[] = $model;
            }



            return $models;
        } catch (\PDOException $e) {
            // todo throw some our custom exception instead
            throw new \Exception("Error: {$e->getMessage()}");
        }
    }
}
