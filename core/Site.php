<?php
namespace core;

class Site 
{
    use View;
    //index page action
    public function index()
    {
        if (App::is_guest()) {
            App::redirect(['r'=>'user/login']);
        } else {
            $this->addressbook();//redirect 
        }
    }



    //addressbook page action
    public function addressbook()
    {
        if (!isset($_SESSION['user']) && !isset($_SESSION['status']) ) {
            App::redirect(['r'=>'site/index']);
        }

        $errors = [];
        $rows = '';
        try{
        
        //PAGINATION
        $limit = 10;
        $page = array_key_exists('page',$_GET) ? (int)$_GET['page'] : 0;
        $page = ($page < 0) ? 0 : $page;
        $total = Db::query('SELECT count(id) as total FROM '. \core\models\Contact::table().' WHERE status <='.$_SESSION['status']);
        $total = !empty($total) ? $total['total'] : 0;

        if (($page*$limit) >= $total) {
            $page = 0;
        }
        $pages = ceil(($total/$limit)-1);
        $total_limit = (($page*$limit) + $limit);
        $total_limit = $total_limit > $total ? $total : $total_limit;
        $listing_info = 'Listing '.($page*$limit).' - '.$total_limit.' of '.$total.' contacts';

        $data=\core\models\Contact::selectByAttributes($filter = '*', ['status' => $_SESSION['status']], true, false,['orderBy'=>['first_name ASC', 'last_name ASC'],'pagination'=>['page'=>$page,'limit'=>$limit]]);
        
        if (isset($_POST['query'])) {
            $rows = \core\App::search($_POST['query']);
        }
        }catch (\Exception $e){
            $errors['empty'] = $e->getMessage();
        }
        
        $this->render_page('site/addressbook',['data'=>$data,'page'=>$page,'pages'=>$pages,'listing_info'=>$listing_info,'rows'=>$rows]);
    }

    //newcontact page action
    public function newcontact()
    {
        if (!isset($_SESSION['user'])) {
            App::redirect(['r'=>'site/index']);
        }
        $errors = [];
        $fname = '';
        $lname = '';
        $email = '';
        $access = '';
        $phone = '';
        $address = '';
        //ADD NEW CONTACT
        if (isset($_POST['addcontact'])) {
        
            try {
                $fname = \core\Validation::checkData(trim($_POST['addName']));
                $lname = \core\Validation::checkData(trim($_POST['addLastName']));
                $email = \core\Validation::checkData(trim($_POST['addEmail']));
                $phone = \core\Validation::checkData(trim($_POST['addPhone']));
                $address = \core\Validation::checkData(trim($_POST['addAddress']));
                
                if (!$access) {
                    $errors['access']='Chose access!'; 
                }
                if (isset($_POST['selectadd'])) {
                    $access = \core\Validation::checkData(trim($_POST['selectadd']));
                }
 
                //img path
                $image = \core\Validation::checkImg(['size' => $_FILES['image']['size'], 'type' => $_FILES['image']['type'], 'name' => $_FILES['image']['name']]);
                $target = "images/" . basename($image);
                move_uploaded_file($_FILES['image']['tmp_name'], $target);  // img is moved to images folder
              
                $image1 = \core\Validation::checkData($image);
        
                $conn = \core\Db::getConn();
                $conn->beginTransaction();
                try {
                    $contact = new \core\models\Contact();
                    $contact->setAttr(['first_name' => $fname, 'last_name' => $lname, 'contact_img' => $image1, 'created_by' => $_SESSION['user'], 'status' => $access]);
                    if (!$contact->save()) {
                        throw new \Exception('Contact is not saved');
                    }
        
                    foreach ([0 => $phone, 1 => $email, 2 => $address] as $type => $value) {
                        $contactData = new \core\models\ContactData();
                        $contactData->setAttr(['contact_id' => $contact->id, 'type' => $type, 'data' => $value, 'status' => $access]);
                        if (!$contactData->save()) {
                            throw new \Exception("ContactData is not saved ({$type} : {$value})");
                        }
                    }
                    $conn->commit();
                } catch (\Exception $e) {
                    $conn->rollBack();
                    echo $e->getMessage();
                }
        
                App::redirect(['r'=>'site/addressbook']);
            } catch (\core\exceptions\BaseException $e) {
                
                switch ($e->getCode()) {
                    case \core\exceptions\NotValidImgException::CODE_IMG_EXIST:
                        $errors['img_size'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\NotValidPasswordException::CODE_IMG_FORMAT:
                        $errors['img_type'] = $e->getCustomMessage();
                        break;
                    case \core\exceptions\NotValidDbException::CODE_DB_DEFAULT:
                        $errors['empty_f'] = $e->getCustomMessage();
                        break;
                    default:
                        $errors['empty'] = $e->getCustomMessage('please fill empty fields');                
                }
             }    
         }
        $this->render_page('site/newcontact',['errors'=>$errors,'fname' => $fname, 'lname' => $lname, 'email' => $email,'phone'=>$phone, 'address'=>$address]);
    }



    //contact page action
    public function contact()
    {
       //UPDATING DATA
        $errors = [];
        $contact_id = array_key_exists('id', $_GET) ? $_GET['id'] : header('Location: addressbook.php');


        if (isset($_POST['update_image'])) {
            try {
                $oldimg = \core\models\Contact::selectByAttributes('contact_img', ['id'=>$contact_id],false,true);
                $image = \core\Validation::checkImg(['size' => $_FILES['image_updt']['size'], 'type' => $_FILES['image_updt']['type'], 'name' => $_FILES['image_updt']['name']]);
                $target = "images/" . basename($image);

                move_uploaded_file($_FILES['image_updt']['tmp_name'], $target);
                unlink('images/'.$oldimg->contact_img);

                $image1 = \core\Validation::checkData($image);
                \core\models\Contact::updateByAttributes(['contact_img' =>$image1], ['id' => $contact_id]);
                
            } catch (BaseException $e) {
                $errors['empty'] = $e->getCustomMessage();
            }
        }

        $contact = \core\models\Contact::findByPk($contact_id);
        $data = \core\models\ContactData::selectByAttributes($filter = '*', ['contact_id' => $contact_id],true,true);

        $this->render_page('site/contact',['contact'=>$contact,'data'=>$data]);
    }
    
    
    //delete contact
    public function delete()
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Bad Request!');
            exit();
        }

        $conn = \core\Db::getConn();
        $conn->beginTransaction();

        try{

        $contact = \core\models\Contact::findByPk($_POST['id']);
        $contactdata = \core\models\ContactData::deleteByAttributes(['contact_id'=>$_POST['id']]);
        unlink('images/'.$contact->contact_img);
        $conn->commit();

        } catch (\Exception $e) {
            $conn->rollBack();
            echo $e->getMessage();
        }
        

        if (!$contact || !$contact->delete()) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Bad Request!');
            exit();
        }
    }
    

    //search contacts
    public function search()
    {
        if (isset($_POST['query'])) {
            $rows = \core\models\Contact::search($_POST['query']);
        
            foreach ($rows as $row) {
                echo "<ul class='list-unstyled'><li class='list'><a class='searchref' href=\"index.php?r=site/contact&id=" . $row['id'] . "\">" . ucwords($row["first_name"]) . " " . ucwords($row["last_name"]) . "</a></li></ul>";
            }
        }
    }
    

    //update contact data
    public function update()
    {
        if (isset($_POST['id']) && isset($_POST['value']) && isset($_POST['cdtype'])) {
            
            \core\models\ContactData::updateByAttributes(['data' => $_POST['value']], ['type' => $_POST['cdtype'], 'contact_id' => $_POST['id']]);
            
        }

    }
    
    
}
