<?php
$id_company='';
$icon_company='';
$name_company='';
$phone_company='';
$id_device='';

$lang='vi';
$func='add';

function isset_file($file) {
    return (isset($file) && $file['error'] != UPLOAD_ERR_NO_FILE);
}

if(isset($_GET['update_company'])){
    $id_company=$_GET['update_company'];
    $query_get_company=mysql_query("SELECT * FROM `company_$lang` WHERE `id` = '$id_company' LIMIT 1");
    $arr_data=mysql_fetch_array($query_get_company);
    $name_company=$arr_data['name'];
    $phone_company=$arr_data['phone'];
    $id_device=$arr_data['id_device'];
    $func='update';
    if(file_exists('company_img/'.$lang.'/'.$id_company.'.png')){
        $icon_company='<img src="company_img/'.$lang.'/'.$id_company.'.png"/>';
    }
}

if(isset($_POST['act_company'])){
    $name_company=$_POST['name_company'];
    $phone_company=$_POST['phone_company'];
    $func=$_POST['func'];
    $id_device=$_POST['id_device'];
    $lang=$_POST['lang'];
    
    if($func=='add'){
        $query_add=mysql_query("INSERT INTO `company_$lang` (`name`, `phone`, `id_device`) VALUES ('$name_company', '$phone_company', '$id_device');");
        $id_new=mysql_insert_id();
        echo 'Thêm mới thành công!';
    }else{
        $id_company=$_POST['id_company'];
        $id_new=$id_company;
        $query_uopdate=mysql_query("UPDATE `company_$lang` SET `name` = '$name_company', `phone` = '$phone_company', `id_device` = '$id_device' WHERE `id` = '$id_company' LIMIT 1;");
        echo 'Cập nhật thành công!';
    }
    
    if(isset_file($_FILES["icon_company"])) {
        $target_file = "company_img/$lang/".$id_new.".png";
        if (move_uploaded_file($_FILES["icon_company"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["icon_company"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<form class="frm_add" style="width: 500px;" method="Post" enctype="multipart/form-data">
    <div style="width: 100%;float: left;padding: 4px;font-weight: bold;">Thêm mới công ty</div>
    <table>
        <tr>
            <td>Ảnh đại diện</td>
            <td>
            <input type="file" name="icon_company" /><br />
            <?php 
            if($icon_company!=""){
                echo $icon_company;
            }
            ?>
            </td>
        </tr>
    
        <tr>
            <td>Tên công ty</td>
            <td><input type="text" name="name_company" value="<?php echo $name_company;?>" /></td>
        </tr>
        
        <tr>
            <td>Số điện thoại</td>
            <td><input type="text" name="phone_company" value="<?php echo $phone_company;?>" /></td>
        </tr>
        
        <tr>
            <td>Người đăng (id device)</td>
            <td><input type="text" name="id_device" value="<?php echo $id_device;?>" /></td>
        </tr>
        
        <tr>
            <td>Ngôn ngữ</td>
            <td>
                <select name="lang">
                <?php for($i=0;$i<count($app_contacts->list_lang);$i++){?>
                    <option value="<?php echo $app_contacts->list_lang[$i]->key;?>" <?php if($lang==$app_contacts->list_lang[$i]->key){?>selected="true"<?php }?>><?php echo $app_contacts->list_lang[$i]->name;?></option>
                <?php }?>
                </select>
            </td>
        </tr>
        
        <tr>
            <td>&nbsp;
                <input type="hidden" name="func" value="<?php echo $func;?>" />
            </td>
            <td>
                <?php 
                if($func=='add'){
                ?>
                <input class="buttonPro Green" value="Thêm mới" type="submit"  name="act_company" />
                <?php }else{?>
                <input type="hidden" name="id_company" value="<?php echo $id_company;?>"/>
                <input class="buttonPro Green" value="Cập nhật" type="submit"  name="act_company" />
                <?php }?>
            </td>
        </tr>
    </table>
</form>