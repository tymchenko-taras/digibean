<!DOCTYPE html>
<html>
<head>
    <title><?php echo $this -> title?></title>

	<?php ScssUtil::register(array(
		'/styles/scss/style.scss',
		'/styles/scss/style1.scss',
		'/styles/scss/style2.scss',
	), 0) ?>

</head>
<body>
<div>header</div>
<div><?php echo $content?></div>
<div>footer</div>
</body>
</html>