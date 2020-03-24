<?php
$lang='vi';
if(isset($_POST['act_company'])){
    $lang=$_POST['lang'];   
}

if(isset($_GET['delete'])){
    $lang=$_GET['lang'];
    $id_delete=$_GET['delete'];
    $query_delete_company=mysql_query("DELETE FROM `company_vi` WHERE `id` = '$id_delete'");
    if(mysql_error()==""){
        echo "Delete company success!!!";
    }
}
?>

<form method="post" class="frm_add">
    <div class="col">
        <label>Ngôn ngữ</label><br />
        <select name="lang">
        <?php
        for($i=0;$i<count($app_contacts->list_lang);$i++){
        ?>
        <option value="<?php echo $app_contacts->list_lang[$i]->key;?>" <?php if($lang==$app_contacts->list_lang[$i]->key){?> selected="true"<?php }?>><?php echo $app_contacts->list_lang[$i]->name;?></option>
        <?php
        }
        ?>
        </select>
    </div>
    <div class="col">
        <input type="submit" name="act_company"  value="Lọc" class="buttonPro blue" />
    </div>
    <div class="col">
        <a href="<?php echo $url;?>?view=company_add" class="buttonPro green"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm công ty</a>
    </div>
</form>

<table>
<tr>
    <th>Biểu tượng</th>
    <th>Tên</th>
    <th>Số điện thoại</th>
    <th>Thiết bị</th>
    <th>Thao tác</th>
</tr>
<?php
$query_list_company=mysql_query("SELECT * FROM `company_$lang` ORDER BY `id` DESC");
while($row_company=mysql_fetch_array($query_list_company)){
    ?>
    <tr>
        <td>
        <?php
        if(file_exists('company_img/'.$lang.'/'.$row_company['id'].'.png')){
            $url_img_company=$url.'/thumb.php?src='.$url.'/company_img/'.$lang.'/'.$row_company['id'].'.png&size=20x20';
        }else{
            $url_img_company=$url.'/thumb.php?src='.$url.'/image/pic_contact.png&size=20x20';
        }
        ?>
        <img src="<?php echo $url_img_company;?>" />
        </td>
        <td><?php echo $row_company['name'];?></td>
        <td><?php echo $row_company['phone'];?></td>
        <td><?php echo $row_company['id_device'];?></td>
        <td>
            <a href="<?php echo $url;?>?view=company_add&update_company=<?php echo $row_company['id'];?>&lang=<?php echo $lang;?>" class="buttonPro yellow small">Cập nhật</a>
            <a href="<?php echo $url;?>?view=company&delete=<?php echo $row_company['id'];?>&lang=<?php echo $lang;?>" class="buttonPro red small">Xóa</a>
        </td>
    </tr>
    <?php
}
?>
</table>