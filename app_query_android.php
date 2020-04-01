<?php
include "config.php";
include "function.php";
$func=$_POST['func'];
$lang=$_POST['lang'];
$id_device=$_POST['id_device'];

/************Type Field****************
 * 0-Text
 * 1-Number
 * 2-Select
 * 3-photo
 * 4-address
 * 5-password
 * ***********************************/

Class App{
    public $list_data=array();
}

Class Contacts{
    public $id;
    public $name;
    public $address;
    public $phone;
    public $avatar;
    public $sex;
    public $type;
}

Class Item_value{
    public $id='';
    public $icon='';
    public $key='';
    public $value='';
    public $value_data='';
    public $value_lang='0';
    public $link='';
    public $type='';
    public $tip='';
    public $btn_del='0';
}

Class Contact_view{
    public $contact='';
    public $arr_value=array();
}

Class Error_Field{
    public $key;
    public $msg;
    public $type;
}

$app_contacts=new App();

$lang_key='';
$os='';
$id_device='';

if(isset($_POST['lang'])){ $lang_key=$_POST['lang'];}
if(isset($_POST['os'])){ $os=$_POST['os'];}
if(isset($_POST['id_device'])){ $id_device=$_POST['id_device'];}

if($func=='list_country'){
    $query_country=mysql_query("SELECT a.`id`,a.`name`,a.`key` FROM carrotsy_virtuallover.`app_my_girl_country` as a INNER JOIN carrotsy_contacts.`country` as b ON b.key = a.key");
    while($item_country=mysql_fetch_array($query_country)){
        $item=new Item_value();
        $item->id=$item_country['id'];
        $item->value=$item_country['name'];
        $item->key=$item_country['key'];
        $item->icon='https://carrotstore.com/thumb.php?src=https://carrotstore.com/app_mygirl/img/'.$item_country['key'].'.png&size=50&trim=1';
        array_push($app_contacts->list_data,$item);
    }
}

if($func=='download_lang'){
    $query_value_lang=mysql_query("SELECT * FROM `lang_value` WHERE `id_country` = '$lang_key' LIMIT 1");
    $data_val=mysql_fetch_array($query_value_lang);
    $data_display=json_decode($data_val['value']);
    foreach($data_display as $k=>$v){
        $app_contacts->{$k}=$v;
    }
}


if($func=="get_list_contacts"){
    $search=$_POST['search'];
    $arr_contacts=array();
    if($search==''){
        $query_list_contact=mysql_query("SELECT `name`,`sdt`,`address`,`sex`,`status`,`id_device` FROM  carrotsy_virtuallover.app_my_girl_user_$lang_key WHERE `address` != '' AND `sdt` != '' AND `status`='0' ORDER BY RAND() LIMIT 20");
    }else{
        $query_list_contact=mysql_query("SELECT `name`,`sdt`,`address`,`sex`,`status`,`id_device`  FROM  carrotsy_virtuallover.app_my_girl_user_$lang_key WHERE ((MATCH (`sdt`) AGAINST ('$search')) OR `name` LIKE '%$search%')  AND `sdt` != '' AND `status` = '0' LIMIT 60");
    }
    While($row_contacts=mysql_fetch_array($query_list_contact)){
        $contacts_item=new Contacts();
        $contacts_item->id=$row_contacts['id_device'];
        $contacts_item->name=$row_contacts['name'];
        $contacts_item->address=$row_contacts['address'];
        $contacts_item->phone=$row_contacts['sdt'];
        $contacts_item->sex=$row_contacts['sex'];
        if(does_url_exists('https://carrotstore.com/app_mygirl/app_my_girl_'.$lang_key.'_user/'.$contacts_item->id.'.png')) {
            $contacts_item->avatar = "https://carrotstore.com/img.php?url=app_mygirl/app_my_girl_" . $lang_key . "_user/" . $contacts_item->id . ".png&size=60";
        }else{
            $contacts_item->avatar='';
        }
        array_push($arr_contacts,$contacts_item);
    }
    mysql_free_result($query_list_contact);
    echo json_encode($arr_contacts);
    exit;

}


if($func=='view_contact'){
    $id_user_device=$_POST['id_user_device'];
    $is_view_account_login=$_POST['is_view_account_login'];

    $contact_view=new Contact_view();

    if($is_view_account_login=='0') {
        $query_contact = mysql_query("SELECT * FROM  carrotsy_virtuallover.app_my_girl_user_$lang WHERE `id_device` = '$id_user_device' ");
    }else{
        $user_phone=$_POST['user_phone'];
        $user_pass=$_POST['user_pass'];
        $query_contact = mysql_query("SELECT * FROM  carrotsy_virtuallover.app_my_girl_user_$lang WHERE `sdt` = '$user_phone' AND `password`='$user_pass' ");
    }

    $contacts_item=new Contacts();
    if(mysql_num_rows($query_contact)>0){
        $contacts=mysql_fetch_array($query_contact);

        $contacts_item->type='1';
        $contacts_item->id=$contacts['id_device'];
        $contacts_item->name=$contacts['name'];
        $contacts_item->address=$contacts['address'];
        $contacts_item->phone=$contacts['sdt'];
        $contacts_item->sex=$contacts['sex'];

        if(does_url_exists('https://carrotstore.com/app_mygirl/app_my_girl_'.$lang.'_user/'.$contacts_item->id.'.png')) {
            $contacts_item->avatar = "https://carrotstore.com/img.php?url=app_mygirl/app_my_girl_".$lang."_user/".$contacts_item->id.".png&size=60";
        }else{
            if($contacts['avatar_url']!=''){
                $contacts_item->avatar=$contacts['avatar_url'];
            }else{
                $contacts_item->avatar="";
            }
        }

        //Tên
        $value_item=new Item_value();
        if($contacts['sex']=='1'){
            $value_item->icon=$urls.'/image/girl.png';
        }else{
            $value_item->icon=$urls.'/image/boy.png';
        }
        $value_item->key='account_name';
        $value_item->value=$contacts['name'];
        array_push($contact_view->arr_value,$value_item);

        //Gọ điện
        $value_item=new Item_value();
        if($contacts['sex']=='1'){
            $value_item->icon=$urls.'/image/call_girl.png';
        }else{
            $value_item->icon=$urls.'/image/call_boy.png';
        }
        $value_item->key='phone';
        $value_item->value=$contacts['sdt'];
        $value_item->link='tel://'.$contacts['sdt'];
        array_push($contact_view->arr_value,$value_item);

        //Nhắn tin - sms
        $value_item=new Item_value();
        $value_item->icon=$urls.'/image/sms.png';
        $value_item->key='sms';
        $value_item->value='sms_value';
        $value_item->value_lang='1';
        $value_item->link='sms://'.$contacts['sdt'];
        array_push($contact_view->arr_value,$value_item);

        //Địa chỉ - bản đồ
        if($contacts['address']!=''){
            $value_item=new Item_value();
            $value_item->icon=$urls.'/image/maps.png';
            $value_item->key='address';
            $value_item->value=$contacts['address'];
            $value_item->link='https://www.google.com/maps?q='.$contacts['address'];
            array_push($contact_view->arr_value,$value_item);
        }

        //Giới tính
        $value_item=new Item_value();
        $value_item->key='sex';
        if($contacts['sex']=='0'){
            $value_item->icon=$urls.'/image/sex_boy.png';
            $value_item->value='sex_boy';
        }else{
            $value_item->icon=$urls.'/image/sex_girl.png';
            $value_item->value='sex_girl';
        }
        $value_item->value_lang='1';
        array_push($contact_view->arr_value,$value_item);

        //Hiện các trường bổ sung
        //Kiểm tra tồn tại
        $query_check_field=mysql_query("SELECT * FROM `user_field_data` WHERE `id_device` = '$id_user_device' LIMIT 1");
        if(mysql_num_rows($query_check_field)>0){
            $data_user=mysql_fetch_array($query_check_field);
            $data_field=json_decode($data_user['data']);
            foreach($data_field as $i_key=>$i_val){
                $query_get_field=mysql_query("SELECT * FROM `field_contacts` WHERE `name`='$i_key' LIMIT 1");
                if(mysql_num_rows($query_get_field)>0){
                    $data_item_field=mysql_fetch_array($query_get_field);
                    $value_item=new Item_value();
                    $value_item->icon=$urls.'/field_icon/'.$data_item_field['id'].'.png';
                    $value_item->key=$i_key;
                    $value_item->value=$i_val;
                    if($data_item_field['link']!=''){
                        $value_item->link=$data_item_field['link'].''.$i_val;
                    }
                    array_push($contact_view->arr_value,$value_item);
                }
                mysql_free_result($query_get_field);
            }
        }

        //ứng dụng đếm cừu
        $query_app_sheep=mysql_query("SELECT * FROM carrotsy_sheep.scores WHERE `id_user` = '$id_user_device' LIMIT 1");
        if(mysql_num_rows($query_app_sheep)>0){
            $data_app_sheep=mysql_fetch_array($query_app_sheep);
            $value_item=new Item_value();
            $value_item->icon=$urls.'/image/sheep.png';
            $value_item->key='account_app_active';
            $value_item->value='Counting sheep - go to bed (scores:'.$data_app_sheep['scores'].')';
            if($os=='android'){
                $value_item->link='https://play.google.com/store/apps/details?id=com.kurotsmile.demcuu3d';
            }else{
                $value_item->link='https://itunes.apple.com/us/app/id1409909203';
            }
            array_push($contact_view->arr_value,$value_item);
        }
        mysql_free_result($query_app_sheep);

        //Trạng thái tài khoản
        $value_item=new Item_value();
        $value_item->icon=$urls.'/image/status.png';
        $value_item->key='account_status';
        if($contacts['status']=='0'){
            $value_item->value='account_statu_1';
        }else{
            $value_item->value='account_statu_2';
        }
        $value_item->value_lang='1';
        array_push($contact_view->arr_value,$value_item);
    }else{
        $contacts_item->id=$id_device;
        $contacts_item->type='0';
    }

    $contact_view->contact=$contacts_item;

    mysql_free_result($query_contact);
    echo json_encode($contact_view);
    exit;
}

if($func=='view_contact_edit'){
    $user_phone=$_POST['user_phone'];
    $user_pass=$_POST['user_pass'];

    $contact_view=new Contact_view();
    $query_contact=mysql_query("SELECT `name`,`sdt`,`address`,`sex`,`status` FROM  carrotsy_virtuallover.app_my_girl_user_$lang WHERE `sdt`='$user_phone' AND `password`='$user_pass'");
    if(mysql_num_rows($query_contact)>0){
        $contacts=mysql_fetch_array($query_contact);
    }else{
        $contacts = array('name' => '', 'sdt' => '', 'address' => '', 'sex' => '0', 'status' => '0');
    }

    //Tên
    $value_item=new Item_value();
    $value_item->icon=$urls.'/image/name.png';
    $value_item->key='account_name';
    $value_item->value=$contacts['name'];
    $value_item->tip='account_name_tip';
    $value_item->type='0';
    array_push($contact_view->arr_value,$value_item);

    //số điện thoại
    $value_item=new Item_value();
    $value_item->icon=$urls.'/image/contact_phone.png';
    $value_item->key='phone';
    $value_item->value=$contacts['sdt'];
    $value_item->tip='phone_tip';
    $value_item->type='1';
    array_push($contact_view->arr_value,$value_item);

    //Ảnh đại diện
    $value_item=new Item_value();
    if(does_url_exists("https://carrotstore.com//app_my_girl_".$lang."_user/".$id_device)){
        $value_item->icon="https://carrotstore.com/img.php?url=app_mygirl/app_my_girl_".$lang."_user/".$id_device.".png&size=80";
        $value_item->value="https://carrotstore.com/img.php?url=app_mygirl/app_my_girl_".$lang."_user/".$id_device.".png&size=80";
    }else{
        if($contacts['avatar_url']!='') {
            $value_item->icon = $contacts['avatar_url'];
            $value_item->value = $contacts['avatar_url'];
        }else{
            $value_item->icon = '';
            $value_item->value = '';
        }
    }

    $value_item->key='account_avatar';
    $value_item->tip='account_avatar_tip';
    $value_item->type='3';
    array_push($contact_view->arr_value,$value_item);

    //Địa chỉ - bản đồ
    $value_item=new Item_value();
    $value_item->icon=$urls.'/image/maps.png';
    $value_item->key='address';
    $value_item->value=$contacts['address'];
    $value_item->tip='address_tip';
    $value_item->type='4';
    array_push($contact_view->arr_value,$value_item);

    //Giới tính
    $value_item=new Item_value();
    $value_item->icon=$urls.'/image/sex.png';
    $value_item->key='sex';
    $value_item->value=$contacts['sex'];
    $value_item->tip='sex_tip';
    $value_item->value_data=array('sex_boy','sex_girl');
    $value_item->type='2';
    array_push($contact_view->arr_value,$value_item);

    //Trạng thái tài khoản
    $value_item=new Item_value();
    $value_item->icon=$urls.'/image/status.png';
    $value_item->key='account_status';
    $value_item->value=$contacts['status'];
    $value_item->tip='account_status_tip';
    $value_item->value_data=array('account_statu_1','account_statu_2');
    $value_item->type='2';
    array_push($contact_view->arr_value,$value_item);

    //Hiện các trường bổ sung
    //Kiểm tra tồn tại
    $query_check_field=mysql_query("SELECT * FROM `user_field_data` WHERE `id_device` = '$id_device'  LIMIT 1");
    if(mysql_num_rows($query_check_field)>0){
        $data_user=mysql_fetch_array($query_check_field);
        $data_field=json_decode($data_user['data']);
        foreach($data_field as $i_key=>$i_val){
            $query_get_field=mysql_query("SELECT `id`,`type`,`tip` FROM `field_contacts` WHERE `name`='$i_key' LIMIT 1");
            if(mysql_num_rows($query_get_field)>0){
                $data_item_field=mysql_fetch_array($query_get_field);
                $value_item=new Item_value();
                $value_item->icon=$urls.'/field_icon/'.$data_item_field['id'].'.png';
                $value_item->key=$i_key;
                $value_item->value=$i_val;
                $value_item->type=$data_item_field['type'];
                $value_item->btn_del='1';
                if($data_item_field['tip']!=''){
                    $data_tip=(array)json_decode($data_item_field['tip'],JSON_UNESCAPED_UNICODE);
                    $value_item->tip=$data_tip[$lang];
                }
                array_push($contact_view->arr_value,$value_item);
            }
            mysql_free_result($query_get_field);
        }
    }

    mysql_free_result($query_contact);
    echo json_encode($contact_view);
    exit;
}

if($func=='update_contact'){
    $lang=$_POST['lang'];
    $id_device=$_POST['id_device'];
    $user_phone=$_POST['user_phone'];
    $user_pass=$_POST['user_password'];

    $account_name=$_POST['account_name'];
    $phone=$_POST['phone'];
    $address='';

    $avatar_url='';
    if(isset($_POST['avatar_user'])){
        $avatar_url=$_POST['avatar_user'];
    }

    if(isset($_POST['address'])){
        $address=$_POST['address'];
    }
    $sex=$_POST['sex'];
    $account_status=$_POST['account_status'];

    $error=new Error_Field();

    if($account_name==''||strlen($account_name)<5){
        $error->key='account_name';
        $error->msg='error_name';
        $error->type='0';
        echo json_encode($error);
        exit;
    }

    if($phone==''||strlen($phone)<6){
        $error->key='phone';
        $error->msg='error_phone';
        $error->type='0';
        echo json_encode($error);
        exit;
    }

    $data_field=json_encode($_POST,JSON_UNESCAPED_UNICODE);
    $data_field=addslashes($data_field);

    $query_get_user=mysql_query("SELECT `id_device` FROM carrotsy_virtuallover.app_my_girl_user_$lang WHERE `sdt` = '$user_phone' AND `password`='$user_pass' LIMIT 1");
    if(mysql_num_rows($query_get_user)>0){
        $query_update_user=mysql_query("UPDATE carrotsy_virtuallover.app_my_girl_user_$lang SET `name` = '$account_name',`sdt` = '$phone',`sex`='$sex',`status`='$account_status',`address`='$address',`id_device` = '$id_device' WHERE `sdt` = '$user_phone' AND `password`='$user_pass' LIMIT 1");
        $error->msg='account_update_success';
        $error->type='1';
        mysql_free_result($query_update_user);

        //Kiểm tra tồn tại
        $query_check_field=mysql_query("SELECT * FROM `user_field_data` WHERE `id_device` = '$id_device' LIMIT 1");
        if(mysql_num_rows($query_check_field)>0){
            //Cập nhật trường bổ sung
            $query_update_field=mysql_query("UPDATE `user_field_data` SET `data` = '$data_field' WHERE `id_device` = '$id_device'");
            mysql_free_result($query_update_field);
        }else{
            //Thêm trường bổ sung
            $query_add_field=mysql_query("INSERT INTO `user_field_data` (`id_device`, `data`, `dates`) VALUES ('$id_device', '$data_field', NOW());");
            mysql_free_result($query_add_field);
        }
        mysql_free_result($query_check_field);

    }else{
        $query_add_user=mysql_query("INSERT INTO carrotsy_virtuallover.app_my_girl_user_$lang (`id_device`, `name`,`sdt`,`status`,`sex`,`date_start`,`date_cur`,`address`,`password`) VALUES ('".$id_device."', '$account_name', '$phone', '$account_status','$sex',NOW(),NOW(),'$address','$user_pass');");
        $error->msg='account_add_success';
        $error->type='1';
        mysql_free_result($query_add_user);

        $query_add_log=mysql_query("INSERT INTO `log_contact` (`id_user`, `date`, `lang`) VALUES ('$id_device', NOW(), '$lang');");
        mysql_free_result($query_add_log);

        //Thêm trường bổ sung
        $query_add_field=mysql_query("INSERT INTO `user_field_data` (`id_device`, `data`, `dates`) VALUES ('$id_device', '$data_field', NOW());");
        mysql_free_result($query_add_field);
    }

    $error->{"account_login"}=array($phone,$user_pass,$id_device,$sex);
    mysql_free_result($query_get_user);

    echo json_encode($error);
    exit;
}


if($func=='get_gprs'){
    $location_lat=$_POST['lat'];
    $location_lon=$_POST['lng'];
    $place="https://maps.googleapis.com/maps/api/geocode/json?latlng=$location_lat,$location_lon&sensor=false&key=AIzaSyCcYpVI8I4osXUeqWkPe-nPrakxNnaND5I";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $place);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    $curlData = curl_exec($curl);
    curl_close($curl);

    $place = json_decode($curlData);
    $txt_dc=$place->results[0]->formatted_address;
    $txt_address=str_replace('Unnamed Road,','',$txt_dc);
    echo $txt_address;
    exit;
}


if($func=='get_list_field'){
    $lang=$_POST['lang'];
    $contact_view=new Contact_view();
    $contact_view->arr_value=array();
    $query_get_list_field=mysql_query("SELECT * FROM `field_contacts`");
    while($row_field=mysql_fetch_array($query_get_list_field)){
        $item_field=new Item_value();
        $item_field->id=$row_field['id'];
        $item_field->key=$row_field['name'];
        $item_field->type=$row_field['type'];
        $item_field->icon=$urls.'/field_icon/'.$item_field->id.'.png';
        if($row_field['tip']!=''){
            $data_tip=(array)json_decode($row_field['tip'],JSON_UNESCAPED_UNICODE);;
            $item_field->tip=$data_tip[$lang];
        }
        $item_field->btn_del='1';
        array_push($contact_view->arr_value,$item_field);
    }
    mysql_query($query_get_list_field);
    echo json_encode($contact_view);
    exit;
}

if($func=='list_ads'){
    $query_list_ads=mysql_query("SELECT `id`,`name`,`android` FROM carrotsy_virtuallover.`app_my_girl_ads` WHERE `android` != ''  ORDER BY RAND() LIMIT 10");
    while($row_ads=mysql_fetch_array($query_list_ads)){
        $item=new Item_value();
        $item->id="https://carrotstore.com/thumb.php?src=https://carrotstore.com/app_mygirl/obj_ads/icon_".$row_ads['id'].".png&size=80";
        $item->{"name"}=$row_ads['name'];
        $item->{"url"}=$row_ads['android'];
        array_push($app_contacts->list_data,$item);
    }
}

if($func=='check_connection'){
    echo '1';
}


if($func=='check_login') {
    $user_phone = $_POST['user_phone'];
    $query_user_login=mysql_query("SELECT `id_device`,`name`,`password`,`sex`,`avatar_url` FROM carrotsy_virtuallover.`app_my_girl_user_$lang` WHERE `sdt`='$user_phone' AND `password`!=''  LIMIT 1");
    if(mysql_num_rows($query_user_login)){
        $data_user_login=mysql_fetch_array($query_user_login);
        $app_contacts->{"status"}="ready_account";
        $app_contacts->{"name"}=$data_user_login['name'];
        $app_contacts->{"password"}=$data_user_login['password'];
        if(does_url_exists('https://carrotstore.com/app_mygirl/app_my_girl_'.$lang.'_user/'.$data_user_login['id_device'].'.png')) {
            $app_contacts->{"avatar"} = "https://carrotstore.com/img.php?url=app_mygirl/app_my_girl_".$lang."_user/" . $data_user_login['id_device'] . ".png&size=60";
        }else{
            if($data_user_login['avatar_url']!=""){
                $app_contacts->{"avatar"} = $data_user_login['avatar_url'];
            }else {
                $app_contacts->{"avatar"} = '';
            }
        }
        $app_contacts->{"id_device"}=$data_user_login['id_device'];
        $app_contacts->{"user_sex"}=$data_user_login['sex'];
    }else{
        $app_contacts->{"status"}="no_account";
        $app_contacts->list_data=array();
        //Tên
        $value_item=new Item_value();
        $value_item->icon=$urls.'/image/name.png';
        $value_item->key='account_name';
        $value_item->value='';
        $value_item->tip='account_name_tip';
        $value_item->type='0';
        array_push($app_contacts->list_data,$value_item);

        //số điện thoại
        $value_item=new Item_value();
        $value_item->icon=$urls.'/image/contact_phone.png';
        $value_item->key='phone';
        $value_item->value=$user_phone;
        $value_item->tip='phone_tip';
        $value_item->type='1';
        array_push($app_contacts->list_data,$value_item);


        //Ảnh đại diện
        $value_item=new Item_value();
        $value_item->icon = '';
        $value_item->value = '';
        $value_item->key='account_avatar';
        $value_item->tip='account_avatar_tip';
        $value_item->type='3';
        array_push($app_contacts->list_data,$value_item);


        //Địa chỉ - bản đồ
        $value_item=new Item_value();
        $value_item->icon=$urls.'/image/maps.png';
        $value_item->key='address';
        $value_item->value='';
        $value_item->tip='address_tip';
        $value_item->type='4';
        array_push($app_contacts->list_data,$value_item);

        //Giới tính
        $value_item=new Item_value();
        $value_item->icon=$urls.'/image/sex.png';
        $value_item->key='sex';
        $value_item->value='0';
        $value_item->tip='sex_tip';
        $value_item->value_data=array('sex_boy','sex_girl');
        $value_item->type='2';
        array_push($app_contacts->list_data,$value_item);

        //Trạng thái tài khoản
        $value_item=new Item_value();
        $value_item->icon=$urls.'/image/status.png';
        $value_item->key='account_status';
        $value_item->value='0';
        $value_item->tip='account_status_tip';
        $value_item->value_data=array('account_statu_1','account_statu_2');
        $value_item->type='2';
        array_push($app_contacts->list_data,$value_item);
    }
}

if($func=='backup_contact'){
    $backup_data=$_POST['backup_data'];
    $backup_length=$_POST['backup_length'];
    $title_backup=" (".$backup_length." Contact )  ".date("Y-m-d H:i:s");
    $query_add_backup=mysql_query("INSERT INTO `backup_contact_$lang` (`id`,`id_user`, `data`, `date`, `comment`) VALUES ('".uniqid().uniqid()."','$id_device', '$backup_data', NOW(), '$title_backup');");
}

if($func=='list_backup'){
    $query_list_backup=mysql_query("SELECT * FROM `backup_contact_$lang` WHERE `id_user` = '$id_device'");
    while ($row_backup=mysql_fetch_array($query_list_backup)){
        $backup_item=new Item_value();
        $backup_item->value_data=$row_backup['data'];
        $backup_item->key=$row_backup['date'];
        $backup_item->tip=$row_backup['comment'];
        $backup_item->id=$row_backup['id'];
        array_push($app_contacts->list_data,$backup_item);
    }
}

if($func=='delete_backup'){
    $id_backup=$_POST['id_backup'];
    $query_delete_backup=mysql_query("DELETE FROM `backup_contact_$lang` WHERE `id` = '$id_backup'");
}

echo json_encode($app_contacts);
mysql_close($link);

?>