<?php
$sub_view='';

if(isset($_GET['sub_view'])){
    $sub_view=$_GET['sub_view'];
}
?>
<div id="page_contain">
<h3>Công cụ</h3>
<i>Các công cụ hỗ trợ ứng dụng và cms làm việc</i>
<ul style="list-style: none;">
<li><a class="buttonPro small <?php if($sub_view=='backup'){?>yellow<?php } ?>" href="<?php echo $url;?>?view=tool&sub_view=backup"><i class="fas fa-database"></i> Sao lưu dữ liệu</a></li>
<li><a class="buttonPro small <?php if($sub_view=='error'){?>yellow<?php } ?>" href="<?php echo $url;?>?view=tool&sub_view=error"><i class="fas fa-bug"></i> Xem lỗi hệ thống</a></li>
    <li><a class="buttonPro small <?php if($sub_view=='command_mysql'){?>yellow<?php } ?>" href="<?php echo $url;?>?view=tool&sub_view=command_mysql"><i class="fa fa-terminal" aria-hidden="true"></i> Chạy lệnh mysql</a></li>
</ul>

<?php
    include "page_tool_".$sub_view.".php";
?>
</div>