<?php
namespace core;

use core\exceptions\BaseException;
use core\exceptions\NotValidEmailException;
use core\exceptions\NotValidPasswordException;
use core\exceptions\NotValidFileException;
use core\exceptions\NotValidDbException;
class User
{
    use View;

    //login page action
    public function login()
    {
        if (!App::is_guest()) {
            App::redirect();
        }

        $errors = [];
        $email = '';
        $password = '';
        $mssg=(isset($_SESSION['mssg'])) ? $_SESSION['mssg'] : '';
        if (isset($_POST['login'])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
        
            try {
        
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $user = \core\Validation::loginValidation($email, $password);
                
                if (!empty($user)) {
                    $_SESSION['email'] = $user->email;
                    $_SESSION['status'] = $user->status;
                    App::login_user($user->id);
                }
                header("Location:index.php?r=site/addressbook");
            } catch (\core\exceptions\BaseException $e) {
                switch ($e->getCode()) {
                    case \core\exceptions\NotValidEmailException::CODE_EMAIL_FORMAT:
                        $errors['email_confirm'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\NotValidPasswordException::CODE_PWD_DEFAULT:
                        $errors['wrong_pass'] = $e->getCustomMessage();
                        break;
                    default:
                        $errors['empty'] = $e->getCustomMessage('please fill empty fields');
                }
            } catch (BaseException $e) {
                $errors['empty'] = $e->getMessage();
            }
        }

       $this->render_page('user/login',['errors'=>$errors,'email'=>$email,'password'=>$password,'mssg'=>$mssg]);
    }

    //user registration action
    public function register(){
        $errors = [];
        $fname = '';
        $lname = '';
        $email = '';
        $password = '';
        $pwdconfirm = '';

        if (isset($_POST['register'])) {
            try {
        
                $fname = \core\Validation::checkData(trim($_POST["fname"]));
                $lname = \core\Validation::checkData(trim($_POST["lname"]));
                $email = \core\Validation::checkData(trim($_POST["email"]));
                $access = \core\Validation::checkData(trim($_POST["select"]));
                $password = \core\Validation::checkData(trim($_POST["password"]));
                $pwdconfirm = \core\Validation::checkData(trim($_POST["password_confirm"]));
        
                //SEND VARIABLES TO A VALIDATION FUNCTION
                $email = \core\Validation::checkEmail($email);
        
                $hash = \core\Validation::checkPwd($password, $pwdconfirm);
        
                //IF VALIDATION PASS
                $user = new \core\models\Members();
                $user->setAttr(['first_name' => $fname, 'last_name' => $lname, 'email' => $email, 'password' => $hash, 'status' => $access]);
                $user->save();

                    if ($user->save()) {
                        $_SESSION['email'] = $user->email;
                        $_SESSION['status'] = $user->status;
                        App::login_user($user->id);
                    }
                    
            } catch (BaseException $e) {
                switch ($e->getCode()) {
                    case \core\exceptions\NotValidDbException::CODE_DB_DEFAULT:
                        $errors['empty_fields'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\NotValidEmailException::CODE_EMAIL_EXIST:
                        $errors['email_used'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\NotValidPasswordException::CODE_PWD_FORMAT:
                        $errors['pass_str'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\NotValidPasswordException::CODE_PWD_EXIST:
                        $errors['pass_conf'] = $e->getCustomMessage();
                        break;
                    default:
                        $errors['empty'] = $e->getMessage();
                }
            }
        }
        $this->render_page('user/register',['errors'=>$errors,'fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$password,'pwdconfirm'=>$pwdconfirm]);

    }

    //forgot password page action
    public function forgot()
    {
        $errors = [];
        $mssg = '';
        if (isset($_POST['reset'])) {
            try {
                $user =  \core\Validation::resetPwd($_POST['email']);
                $user->remember_token = \core\Validation::tokenGenerator();
                $user->save();

                $to = $user->email;
                $subject = 'Password update request';
                $content = 'Dear '.$user->first_name.'<br> To reset your password please visit the following link: <a href="http://addressbook.com/index.php?r=user/resetpwd&t='.$user->remember_token.'"></a><br>Regards,<br>Trips.dev ';
                mail($to, $subject, $content);

                $mssg='You successfuly started change password procces. Please check your email';
            } catch (BaseException $e) {
                switch ($e->getCode()) {
                    case \core\exceptions\NotValidEmailException::CODE_DB_DEFAULT:
                        $errors['empty_fields'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\NotValidEmailException::CODE_EMAIL_FORMAT:
                        $errors['email_format'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\NotValidPasswordException::CODE_EMAIL_EXIST:
                        $errors['email_exist'] = $e->getCustomMessage();
                        break;
                    default:
                        $errors['empty'] = $e->getMessage();
                }
            }
        }
        $this->render_page('user/forgot', ['errors'=>$errors,'mssg'=>$mssg]);
    }


    //reset password page action
    public function resetpwd()
    {
        if (!isset($_GET['t'])) {
            App::redirect(['r'=>'user/login']);
        }

        $user = \core\models\Members::selectByAttributes($filter = '*', ['remember_token' => $_GET['t']], false, true);
        if (!$user) {
            App::redirect(['r'=>'user/login']);
        }
       
        $errors = [];
        $newpassword = '';
        $newpassword_confirm = '';
        if (isset($_POST['change'])) {
            try {
                $newpassword =\core\Validation::checkData($_POST['newpassword']);
                $newpassword_confirm = \core\Validation::checkData($_POST['newpassword_confirm']);

                $password = \core\Validation::checkPwd($newpassword, $newpassword_confirm);
                $user->password = $password;
                $user->remember_token = null;
                if(!$user->save()){
                    throw new BaseException('Password is not changed. Please try again.');
                }
                
                $_SESSION['mssg'] = 'You are successfuly change your password. Please login in with new credentials.';
                App::redirect(['r'=>'user/login']);
            } catch (BaseException $e) {
                switch ($e->getCode()) {
                    case \core\exceptions\NotValidDbException::CODE_DB_DEFAULT:
                        $errors['empty_fields'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\ NotValidPasswordException::CODE_PWD_FORMAT:
                        $errors['pass_str'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\ NotValidPasswordException::CODE_PWD_EXIST:
                        $errors['pass_conf'] = $e->getCustomMessage();
                        break;
                    default:
                        $errors['empty'] = $e->getMessage();
                }
            }
        }

        $this->render_page('user/resetpwd', ['errors'=>$errors,'newpassword'=>$newpassword,'newpassword_confirm'=>$newpassword_confirm]);
    }



    //logout page action
    public function logout()
    {
        if (App::is_guest()) {
            App::redirect(['r'=>'user/login']);
        }

        App::logout_user();
    }
}
