<?php

if (!empty($_GET['catalog'])) {
	$HTTP = $_GET['catalog'];
} else {
	$HTTP = 'category_1';
}

$dir = "img/{$HTTP}";


$is_404 = false;

// Получаем изображения

function getImages($dir)
{

	if (file_exists($dir)) {
		$img_data = [];
		if (is_dir($dir)) {
			$d = opendir($dir);

			while ($img = readdir($d)) {
				if ($img == "." || $img == "..") {
					continue;
				} else if (pathinfo($dir . "/" . $img, PATHINFO_EXTENSION) != "jpg" && pathinfo($dir . "/" . $img, PATHINFO_EXTENSION) != "png") {
					continue;
				} else {
					$img_data[] = $dir . "/" . $img;
				}
			}


			closedir($d);
		}
	}

	return $img_data;
}

// Получить элементы меню

function get_menu($dir_menu)
{
	if (file_exists($dir_menu)) {
		$menu = [];
		$d = opendir($dir_menu);
		while ($cat = readdir($d)) {
			if (is_dir($dir_menu . "/" . $cat)) {
				if ($cat == "." || $cat == "..") {
					continue;
				} else {
					$menu[] = $cat;
				}
			}
		}
		closedir($d);
		return $menu;
	}
}
$dir_menu = "img";
$menu = get_menu($dir_menu);

function show_menu($menu)
{
	if (!empty($menu)) {
		foreach ($menu as $menu_item) 
		{ ?>
			<a class="<?php if($menu_item == $_GET['catalog']) echo 'active'?>" href="index.php?catalog=<?php echo $menu_item;?>"><?php echo $menu_item;?></a>
			
		<?php }
	}
}

// Выводим изображения

function showImages($img_data)
{
	if (!empty($img_data)) {
		foreach ($img_data as $img) {


?>
			<div class="superbox-list">
				<img src="<?php echo $img; ?>" data-img="<?php echo $img; ?>" alt="Изображение" class="superbox-img">
			</div>

<?php

		}
	}
}

// Функция вывода ошибки 404

function error_404()
{
	global $is_404;
	$is_404 = true;
	header("HTTP/1.1 404 Not Found");
}






if (file_exists($dir)) {
	
	$images = getImages($dir);
} 
else
{
	error_404();
}




















?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Superbox, the lightbox, reimagined</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link href="css/style.css" rel="stylesheet">

	<style>
	.active
{
	color: #fff;
	margin-right: 10px;
	
}	

	</style>
</head>

<body>
	<div class="wrapper">
		<div class="logo">
			<img src="img/logo.png" class="logo-img" alt="Logo">
		</div>

		<div class="menu">
			<nav>
				<a href="upload.php">Добавить картинки</a>
				<ul>
					<?php if($is_404 == false) {show_menu($menu);} ?>
				</ul>
			</nav>
		</div>

		<!-- SuperBox -->
		<div class="superbox">
			<?php

			if ($is_404) { ?>
				<h1> Ошибка 404: директория не найдена!</h1>
			<?php } else {
				showImages($images);
			}

			?>

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