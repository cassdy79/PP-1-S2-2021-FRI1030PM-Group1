<nav>
    <?php if(isset($_SESSION['email'])) : ?>
        <a href='/'>&nbsp;Home&nbsp;</a>
		<a href=profile>&nbsp;Profile&nbsp;</a>
        <?php if(isset($_SESSION['admin'])) : ?>
            <a href=admin>&nbsp;Admin Dashboard&nbsp;</a>
			<a href=addcar>&nbsp;Add Car&nbsp;</a>
        <?php endif; ?>
        <a href=map>&nbsp;Map&nbsp;</a>
        <a href=logout>&nbsp;Logout&nbsp;</a>
    <?php else : ?>
        <a href='/'>&nbsp;Home&nbsp;</a>
        <a href=login>&nbsp;Login&nbsp;</a>
        <a href=register>&nbsp;Register&nbsp;</a>
    <?php endif; ?>
    

</nav>