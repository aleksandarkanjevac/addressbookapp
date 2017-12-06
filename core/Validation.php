<?php
namespace core;

use core\exceptions\NotValidEmailException;
use core\exceptions\NotValidPasswordException;
use core\exceptions\NotValidImgException;
use core\exceptions\NotValidDbException;

class Validation
{
    //validation and cleaning data
    public static function checkData($data, $allowEmpty = false)
    {
        
        if (!$allowEmpty && empty($data)) {
            throw new NotValidDbException('', NotValidDbException::CODE_DB_DEFAULT);
        }
        
            $data = strtolower(htmlspecialchars(trim($data)));
               
            return $data;
    }
    
    //pwd validation, pwd length & pwd match
    public static function checkPwd($password1, $password2)
    {
       
        if (strlen($password1) < 6) {
            throw new NotValidPasswordException('', NotValidPasswordException::CODE_PWD_FORMAT);
        }
        
        if ($password1 !== $password2) {
            throw new NotValidPasswordException('', NotValidPasswordException::CODE_PWD_EXIST);
        }
        
        return password_hash($password1, PASSWORD_DEFAULT);
    }
        
    //Check if email exist in db
    public static function checkEmail($email)
    {
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new NotValidEmailException('', NotValidEmailException::CODE_EMAIL_FORMAT);
        }

        $check = \core\models\Members::selectByAttributes($filter = 'email', ['email' => $email], false, false);
       
        if (!empty($check)) {
            throw new NotValidEmailException('', NotValidEmailException::CODE_EMAIL_EXIST);
        } else {
            return $email;
        }
    }

    public static function loginValidation($email, $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new NotValidEmailException('', NotValidEmailException::CODE_EMAIL_FORMAT);
        }

        $check = \core\models\Members::selectByAttributes($filter = '*', ['email' => $email], false, true);

        if (empty($check)) {
             throw new NotValidEmailException('', NotValidEmailException::CODE_EMAIL_FORMAT);
        }
 
        if (!password_verify($password, $check->password)) {
             throw new \core\exceptions\NotValidPasswordException('',NotValidPasswordException::CODE_PWD_DEFAULT);
        }
        
        return $check;
    }

    public static function resetPwd($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new NotValidEmailException('', NotValidEmailException::CODE_EMAIL_FORMAT);
        }

        $check = \core\models\Members::selectByAttributes($filter = '*', ['email' => $email], false, true);
       
        if (empty($check)) {
            throw new NotValidEmailException('', NotValidEmailException::CODE_EMAIL_FORMAT);
        } else {
            return $check;
        }

    }



    public static function checkImg(array $img_datas) {
        
        $maxsize = 2097152;
        $acceptable = array(
            'image/jpeg',
            'image/jpg',
            'image/gif',
            'image/png'
            );

        if (empty($img_datas)|| ($img_datas['size'] == 0)) {
            throw new NotValidDbException('', NotValidDbException::CODE_DB_DEFAULT);
        }
        
        if (( $img_datas['size'] >= $maxsize)) {
            throw new NotValidImgException('', NotValidImgException::CODE_IMG_FORMAT);
        }
        
        if (!in_array($img_datas['type'], $acceptable) && (!empty($img_datas['type']))) {
            throw new NotValidImgException('', NotValidImgException::CODE_IMG_EXIST);
        }
        
        return $img_datas['name'];
    }
    
    //generate remember token
    public static function tokenGenerator()
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ', ceil(64/strlen($x)))), 1, 64);
    }
}
