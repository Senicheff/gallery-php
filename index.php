<?php

$dir_path = 'img/superbox';






// Получаем картинки
function getImg($dir_path)
{
	$pictures = [];
	if (file_exists($dir_path)) {
		$d = opendir($dir_path);
		while ($file = readdir($d)) {



			if ($file == '.' || $file == '..') {
				continue;
			} else if (pathinfo($file, PATHINFO_EXTENSION) == "jpg" || pathinfo($file, PATHINFO_EXTENSION) == "png") {
				$pictures[] = $dir_path . "/" . $file;
			}
		}
		closedir($d);
	}
	return $pictures;
}

// Выводим картинки
function showImg($pictures)
{
	if(!empty($pictures))
	{
		foreach ($pictures as $key => $value) { ?>
			<div class="superbox-list">
				<img src="<?php echo $value; ?>" data-img="<?php echo $value; ?>" alt="" class="superbox-img">
			</div>
	<?php }
	}
}




if(file_exists($dir_path))
{
	$pictures = getImg($dir_path);
}
else
{
	echo 'Ошибка 404';
}







?>



<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Superbox, the lightbox, reimagined</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link href="css/style.css" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<div class="logo">
			<img src="img/logo.png" class="logo-img" alt="Logo">
		</div>

		
		<!-- SuperBox -->
		<div class="superbox">
			<?php showImg($pictures); ?>
			<div class="superbox-float"></div>
		</div>
		<!-- /SuperBox -->

		<div style="height:300px;"></div>

	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="js/superbox.js"></script>
	<script>
		$(function() {

			// Call SuperBox
			$('.superbox').SuperBox();

		});
	</script>
</body>

</html>