<?php

namespace core\exceptions;

use function array_key_exists;

class BaseException extends \Exception {

    // emails
    const CODE_EMAIL_DEFAULT = 1; // neki generalni exception za emailove
    const CODE_EMAIL_FORMAT = 2; // kad format emaila nije dobar
    const CODE_EMAIL_EXIST = 3; // kad email vec postaji u bazi
    // DB
    const CODE_DB_DEFAULT = 4;
    const CODE_DB_FORMAT = 5;
    const CODE_DB_EXIST = 6;
    // Password
    const CODE_PWD_DEFAULT = 7;
    const CODE_PWD_FORMAT = 8;
    const CODE_PWD_EXIST = 9;
    // Images
    const CODE_IMG_DEFAULT = 10;
    const CODE_IMG_FORMAT = 11;
    const CODE_IMG_EXIST = 12;

    protected static $messages = [
        self::CODE_EMAIL_DEFAULT => 'Please enter your email',
        self::CODE_EMAIL_FORMAT => 'Please enter valid email address.',
        self::CODE_EMAIL_EXIST => 'Email is already used.',
        self::CODE_DB_DEFAULT => 'Please fill all required files',
        self::CODE_DB_FORMAT => 'Db not reponding, please try leater',
        self::CODE_DB_EXIST => 'Db error.Data dont exist',
        self::CODE_PWD_DEFAULT => 'Please enter valid password',
        self::CODE_PWD_FORMAT => 'Password must contain 6 characters.',
        self::CODE_PWD_EXIST => 'Password confirmation error',
        self::CODE_IMG_DEFAULT => 'Image error',
        self::CODE_IMG_FORMAT => 'Image is to large.',
        self::CODE_IMG_EXIST => 'Not valid image format',
    ];

    public function getCustomMessage() {
        if (array_key_exists($this->getCode(), static::$messages)) {
            return static::$messages[$this->getCode()];
        }

        return $this->getMessage();
    }

}
