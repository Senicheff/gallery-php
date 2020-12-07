<?php

// Обработчик загрузки

$dir = "img";

// Получаем категории

function getCategories($dir)
{
    $categories = [];

    if (file_exists($dir)) {
        $d = opendir($dir);
        while ($file = readdir($d)) {
            if ($file == "." || $file == ".." || is_file($dir . "/" . $file)) {
                continue;
            }
            $categories[] = $file;
        }
        closedir($d);
    }
    return $categories;
}

// Показываем категории

function showCategories($categories)
{
    if (isset($categories)) {

        foreach ($categories as $category) { ?>
            <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
<?php }
    }
}

$categories = getCategories($dir);


echo "<pre>";
print_r($_POST);
echo "</pre>";

echo "<pre>";
print_r($_FILES);
echo "</pre>";

if($_SERVER['REQUEST_METHOD'] == "POST") 
{
    if($_FILES['image']['error'] == 0)
    {
        if(!empty($_POST['category_name']))
        {
            $check_dir = $dir . "/" . $_POST['category_name'];
            if(!is_dir($check_dir)) 
            {
                $new_dir = $dir . "/" . $_POST['category_name'];
                echo $new_dir;
                var_dump(mkdir($new_dir));
                move_uploaded_file($_FILES['image']['tmp_name'], $new_dir . "/" . time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            }  
            else
            {
                $path = $dir . "/" . $_POST['category_name'] . "/" . time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['image']['tmp_name'], $path);
            }     
        }
        else
        {
            $path = $dir . "/" . $_POST['categories'] . "/" . time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($_FILES['image']['tmp_name'], $path);
        
        }
    }
}



?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузить файл</title>
</head>

<body>

    <h1>
        Загрузить файл
    </h1>

    <form action="#" method="POST" enctype="multipart/form-data">

        <fieldset>
            <p>Выберите категорию</p>

            <select name="categories" id="categories">
                <?php showCategories($categories); ?>
            </select>
        </fieldset>

        <fieldset>
            <p>Введите название категории</p>
            <input type="text" name="category_name">
        </fieldset>

        <fieldset>
            <input type="file" name="image" id="image">
        </fieldset>

        <button>Отправить</button>

    </form>

</body>

</html>