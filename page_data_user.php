<?php
$mysql_get_data=mysql_query("SELECT * FROM `user_field_data` ORDER BY `dates` DESC");
?>
<div class="frm_add">
    <div class="col">
        <strong>Tổng số người dùng hợp hóa dữ liệu</strong><br />
        <?php echo mysql_num_rows($mysql_get_data);?>
    </div>
</div>
<table>
<tr>
    <th>Id</th>
    <th>Dữ liệu</th>
    <th>Thời gian</th>
</tr>
<?php
while($row_data=mysql_fetch_array($mysql_get_data)){
?>
<tr>
    <td><?php echo $row_data['id_device']; ?></td>
    <td>
        <ul>
    <?php 
        $data_user=json_decode($row_data['data']);
        unset($data_user->id_device);
        unset($data_user->lang);
        unset($data_user->account_status);
        unset($data_user->sex);
        unset($data_user->id_lang);
        unset($data_user->os);
        unset($data_user->id_lang);
        unset($data_user->func);
        foreach($data_user as $i_key=>$i_val){
            ?>
            <li><b><?php echo $i_key;?></b>:<?php echo $i_val;?></li>    
            <?php
        }
    ?>
        </ul>
    </td>
    <td><?php echo $row_data['dates']; ?></td>
</tr>
<?php
}
?>
</table>