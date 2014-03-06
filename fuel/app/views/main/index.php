
<a href="<?php echo Uri::create('maze/index'); ?>">Maze</a><br/>
<a href="<?php echo Uri::create('calc/index'); ?>">Calculator</a><br/>
<a href="<?php echo Uri::create('captcha/index'); ?>">Captcha Test</a>
<hr/>

<form method="POST" action="<?php echo Uri::create('main/check'); ?>" id="" class="">
	<input type="text" name="username" class="" id="" /><br/>
	<input type="text" name="password" class="" id="" /><br/>
	<input type="submit" name="submit" />
</form>