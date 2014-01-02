<?php require 'includes/connection.php'?>
<?php require_once 'includes/functions.php'; ?>
<?php 
    find_selected_page();
?>
<?php include 'includes/header.php'; ?>
<table id="structure">
<tr>
<td id="navigation">
<?php echo navigation($sel_subject,$sel_page); ?>
<br />
<a href="new_subject.php">+ Add a new subject</a>
</td>
<td id="page">
<h2>Content Area</h2>
<?php if (!is_null($sel_subject)){ 
echo $sel_subject['menu_name'];
?> 
<br />
<?php
}elseif(!is_null($sel_page)){ echo $sel_page['menu_name'];
?>
</ br>
<div class="page-content">
<?php echo $sel_page['content'];?>
</div>
<?php }else{ echo 'select subject or a page to edit.'; }?>
                                       
</td>
</tr>
</table>
<?php include 'includes/footer.php'; ?>
