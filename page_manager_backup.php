<?php
$lang='vi';
$lang=$_GET['lang'];
$query_backup=mysql_query("SELECT `id`,`id_user`,`comment` FROM `backup_contact_$lang` LIMIT 50");
?>

<table>
    <tr>
        <th>ID Backup</th>
        <th>ID người dùng</th>
        <th>Thông tin</th>
        <th>Thao tác</th>
    </tr>
    <?php
    while($row_backup=mysql_fetch_assoc($query_backup)){
        ?>
        <tr>
            <td><i class="fas fa-id-card"></i> <?php echo $row_backup['id'];?></td>
            <td><a target="_blank" href="<?php echo $url_carrot_store;?>/user/<?php echo $row_backup['id_user'];?>/<?php echo $lang;?>" class="buttonPro small"><i class="far fa-id-badge"></i> <?php echo $row_backup['id_user'];?></a></td>
            <td><?php echo $row_backup['comment'];?></td>
            <td>
                <a href="<?php echo $url;?>?view=view_backup&id_backup=<?php echo $row_backup['id'];?>&lang=<?php echo $lang;?>" class="buttonPro blue small"><i class="fas fa-eye"></i> Xem bảng sao lưu</a>
                <a href="<?php echo $url;?>?view=manager_backup&delete=<?php echo $row_backup['id'];?>&lang=<?php echo $lang;?>" class="buttonPro red small"><i class="fas fa-trash-alt"></i> Xóa</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>