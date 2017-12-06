<?php
namespace core;

class Db {

    private static $conn;

    public static function getConn() {

        if (static::$conn === null) {
            static::$conn = new \PDO('mysql:host=localhost;dbname=addressbook', 'phplay', 'zx');
            static::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            // always disable emulated prepared statement when using the MySQL driver
            static::$conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        }

        return static::$conn;
    }
     /**
     * handle custom query
     */
    public static function query($sql, $fetchAll = false)
    {
        if (empty($sql)) {
           return false;
        }
        $conn = self::getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        if (!$fetchAll) {
            return $stmt->fetch();
        } else {
            return $stmt->fetchAll();
        }
          
    }

}
