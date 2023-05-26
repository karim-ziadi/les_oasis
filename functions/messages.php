<!-- error message -->
<?php 
if(isset($error_message)&& $error_message!=''){ ?>
<div class="alert alert-danger" role="alert">
    <?php echo $error_message; ?>
</div>
<?php 
}?>
<!-- success message -->
<?php 
if(isset($success_message)&& $success_message!=''){ ?>
<div class="alert alert-success" role="alert">
    <?php echo $success_message; ?>
</div>
<?php 
}?>