<?php
$func='add';
$field_name='';
$field_type='';
$field_link='';
$field_icon='';
$is_lang='';
$is_delete='';
$data_value='';
$tip='';

function isset_file($file) {
    return (isset($file) && $file['error'] != UPLOAD_ERR_NO_FILE);
}


if(isset($_GET['edit'])){
    $func='edit';
    $id_edit=$_GET['edit'];
    $query_field=mysql_query("SELECT * FROM `field_contacts` WHERE `id` = '$id_edit' LIMIT 1");
    $data_field=mysql_fetch_array($query_field);
    $field_name=$data_field['name'];
    $field_type=$data_field['type'];
    $field_link=$data_field['link'];
    $data_value=json_decode($data_field['data_value']);
    $tip=(array)json_decode($data_field['tip']);
    if(file_exists('field_icon/'.$id_edit.'.png')){
        $field_icon='<img src="field_icon/'.$id_edit.'.png"/>';
    }
    mysql_free_result($query_field);
    
}

if(isset($_POST['act'])){
    $func=$_POST['func'];
    $field_name=$_POST['field_name'];
    $field_type=$_POST['field_type'];
    $field_link=$_POST['field_link'];
    $is_lang='0';
    $is_delete='0';
    $data_value=json_encode($_POST['data_value']);
    
    $array_tip=array();
    $tip=$_POST['tip'];
    for($i=0;$i<count($app_contacts->list_lang);$i++){
        $key=$app_contacts->list_lang[$i]->key;
        $array_tip[$key]=$tip[$i];
    }
    $tip=json_encode($array_tip,JSON_UNESCAPED_UNICODE);
    $tip=addslashes($tip);
    if(isset($_POST['is_lang'])){
        $is_lang='1';
    }
    
    if(isset($_POST['is_delete'])){
        $is_delete='1';
    }
    
    if($func=='add'){
        $query_act=mysql_query("INSERT INTO `field_contacts` (`name`, `type`, `name_is_lang`,`link`,`data_value`,`tip`) VALUES ('$field_name', '$field_type', '$is_lang','$field_link','$data_value','$tip');");
        $id_new=mysql_insert_id();
    }else{
        $id_edit=$_POST['id_edit'];
        $query_act=mysql_query("UPDATE `field_contacts` SET `name` = '$field_name', `type` = '$field_type', `name_is_lang` = '$is_lang',`link`='$field_link',`data_value`='$data_value',`tip`='$tip' WHERE `id` = '$id_edit';");
        $id_new=$id_edit;
    }
    
    if(isset_file($_FILES["field_icon"])) {
        $target_file = 'field_icon/'.$id_new.'.png';
        if (move_uploaded_file($_FILES["field_icon"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["field_icon"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    mysql_free_result($query_act);
    echo mysql_error();
    echo 'Add Field Success !!!';
}
?>
<form method="post" class="frm_add" enctype="multipart/form-data">
    <div class="col">
        <label>Tên</label><br />
        <input type="text" value="<?php echo $field_name;?>" name="field_name" />
    </div>
    
    <div class="col">
        <label>Biểu tượng</label><br />
        <input type="file"  name="field_icon" />
        <?php if($field_icon!=''){
           echo '<br/>'.$field_icon; 
        }?>
    </div>
    
    <div class="col">
        <label>Loại</label><br />
        <select name="field_type" onchange="check_data(this);return false;">
            <option value="0" <?php if($field_type=='0'){?> selected="true" <?php } ?> >Nhập dữ liệu chữ</option>
            <option value="1" <?php if($field_type=='1'){?> selected="true" <?php } ?>>Nhập dữ số</option>
            <option value="2" <?php if($field_type=='2'){?> selected="true" <?php } ?>>Chọn lựa dữ liệu</option>
            <option value="3" <?php if($field_type=='3'){?> selected="true" <?php } ?>>Ảnh</option>
            <option value="4" <?php if($field_type=='4'){?> selected="true" <?php } ?>>Địa chỉ</option>
            <option value="5" <?php if($field_type=='5'){?> selected="true" <?php } ?>>Mật khẩu</option>
        </select>
    </div>

    <div class="col">
        <label>Ngôn ngữ hóa trường này</label><br />
        <input type="checkbox"  name="is_lang" <?php if($is_lang!=''){?>checked="true"<?php } ?> />
    </div>
    
    <div class="col">
        <label>Có thể xóa</label><br />
        <input type="checkbox"  name="is_delete" <?php if($is_delete!=''){?>checked="true"<?php } ?> />
    </div>
    
    <div class="col">
        <label>Đừng dẫn</label><br />
        <input type="text" value="<?php echo $field_link;?>" name="field_link" />
    </div>
    
    <div class="col" id="col_data_value">
        <label>Dữ liệu dựng sẵn</label><br />
        <input type="text" id="inp_data" />
        <span class="buttonPro small blue" onclick="add_data_value();return false;">Thêm</span>
        <div id="data_value">
        <?php
        foreach($data_value as $val){
        ?>
        <span onclick="$(this).remove();return false;" class="item"><input type="hidden" name="data_value[]" value="<?php echo $val;?>" /><?php echo $val;?></span>
        <?php
        }
        ?>
        </div>
    </div>
    
    <div class="col" style="width: 100%;">
        <label>Mô tả</label><br />
        <table>
            <?php
            for($i=0;$i<count($app_contacts->list_lang);$i++){
                $k=$app_contacts->list_lang[$i]->key;
            ?>
            <tr>
                <td style="width: 200px;"><img src="<?php echo $url.'/image/'.$app_contacts->list_lang[$i]->key.'.png';?>"  style="float: left;width: 20px;"/> <?php echo $app_contacts->list_lang[$i]->name;?></td>
                <td><input type="text" name="tip[]" value="<?php echo $tip[$k];?>" style="width: 100%;"/></td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>
    
    <div class="col">
    <?php if($func=='add'){?>
        <input type="hidden" name="func" value="add" />
        <input type="submit" name="act" class="buttonPro green" value="Thêm mới"/>
    <?php }else{?>
        <input type="hidden" name="id_edit" value="<?php echo $id_edit;?>" />
        <input type="hidden" name="func" value="edit" />
        <input type="submit" name="act" class="buttonPro green" value="Cập nhật"/>
    <?php }?>
    </div>
</form>

<table>
    <tr>
        <th>Id</th>
        <th>Biểu tượng</th>
        <th>Tên</th>
        <th>Kiểu</th>
        <th>Tên chuẩn hóa ngôn ngữ</th>
        <th>Đường dẫn</th>
        <th>Dữ liệu chọn</th>
        <th>Mô tả</th>
        <th>Thao tác</th>
    </tr>
    
    <?php
    $query_list_field=mysql_query("SELECT * FROM `field_contacts`");
    while($row_field=mysql_fetch_array($query_list_field)){
    ?>
    <tr>
        <td><?php echo $row_field['id'];?></td>
        <td>
            <?php
            if(file_exists('field_icon/'.$row_field['id'].'.png')){
                echo '<img style="width:20px;" src="field_icon/'.$row_field['id'].'.png"/>';
            }
            ?>
        </td>
        <td><?php echo $row_field['name'];?></td>
        <td><?php echo $row_field['type'];?></td>
        <td><?php echo $row_field['name_is_lang'];?></td>
        <td><?php echo $row_field['link'];?></td>
        <td>
            <ul>
            <?php 
                $data_v=json_decode($row_field['data_value']);
                foreach($data_v as $v){
                    echo '<li>'.$v.'</li>';
                }
            ?>
            </ul>
        </td>
        <td>
            <ul>
            <?php 
                $data_v=json_decode($row_field['tip']);
                foreach($data_v as $v){
                    echo '<li>'.$v.'</li>';
                }
            ?>
            </ul>
        </td>
        <td>
            <a href="#" class="buttonPro small red">Xóa</a>
            <a href="<?php echo $url;?>?view=field&edit=<?php echo $row_field['id'];?>" class="buttonPro small yellow">Sửa</a>
        </td>
    </tr>
    <?php
    }
    mysql_free_result($query_list_field);
    ?>
</table>

<script>
function add_data_value(){
    var inp_data=$("#inp_data").val();
    var txt_add="<span onclick='$(this).remove();return false;' class='item'><input type='hidden' name='data_value[]' value='"+inp_data+"' /> "+inp_data+"</span>";
    $("#data_value").append(txt_add);
}


function check_data(a){
    var val=$(a).val();
    alert(val);
    if(val=='2'){
        $("#col_data_value").show();
    }else{
        $("#col_data_value").hide();
    }
}
</script>