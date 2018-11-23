<?php if(isset($_GET['type']) && isset($_GET['message'])): ?>

<?php if($_GET['type'] === 'error'): ?>
        <br>
        <div class="nscs-main-message nscs-main-message_error">
            <?php echo str_replace('_', ' ',$_GET['message']); ?>
        </div>
<?php endif; ?>

<?php if($_GET['type'] === 'success'): ?>
        <br>
        <div class="nscs-main-message nscs-main-message_success">
            <?php echo str_replace('_', ' ',$_GET['message']); ?>
        </div>
<?php endif; ?>

<?php endif; ?>