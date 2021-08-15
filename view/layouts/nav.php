<nav>
    <?php if(isset($_SESSION['email'])) : ?>
        <a href=index.php>&nbsp;Home&nbsp;</a>
        <a href=?logout>&nbsp;Logout&nbsp;</a>
    <?php else : ?>
        <a href=index.php>&nbsp;Home&nbsp;</a>
        <a href=login.php>&nbsp;Login&nbsp;</a>
        <a href=register.php>&nbsp;Register&nbsp;</a>
    <?php endif; ?>
    

</nav>