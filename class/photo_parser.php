<?php

/*
* Файл для подключения API для изменения размера картинки(фотографии)
*/

class photo_parser
{


    function Getpicterfromclient($encoded_string, $user_id)
    {

        $decoded_string = base64_decode($encoded_string);//декодируем строку в картинку
        $path_large = 'images/' . $user_id . "_large"; //указание директории куда сохраняем файл

        $file = fopen($path_large, 'wb');
        $is_written = fwrite($file, $decoded_string);
        fclose($file);


        $small = $this->medium_photo_resize($decoded_string);
        $path_small = 'images/' . $user_id . "_small";
        $file = fopen($path, 'wb');
        $is_written = fwrite($file, $decoded_string);
        fclose($file);

        $path_medium = 'images/' . $user_id . "_medium";

        $file = fopen($path, 'wb');
        $is_written = fwrite($file, $decoded_string);
        fclose($file);
//проверка на вычитку файла
        if ($is_written > 0) {
//сохранение в БД

            /* $connection = mysql_connect('localhost','root','','tutorial3');//открываем коннект
            $query = "INSERT INTO photos(name,path) values('$image_name','$path');";//сохраняем ссылку на фото в БД

            $result = mysqli_query($connection,$query);

            if($result){
            echo "succes";
            }else {
            echo "failed";
            }

            mysqli_close($connection);//закрываем коннект
            */
        }
    }

//path принимает путь к файлу который нужно изменить
// path_2 путь к каталогу, куда нужно положить
    function resize($path, $path2)
    {
        $img_id = imagecreatefromjpeg($path);

        $img_width = imageSX($img_id);
        $img_height = imageSY($img_id);
        $our_width = 200;//необходимый размер
        $k = round($img_width / $our_width, 2);
        $new_width = $img_width / $k;
        $new_height = $img_height / $k;
        $new_img = imagecreatetruecolor($new_width, $new_height);
        $result = imagecopyresampled($new_img, $img_id, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height);


        $img = imagejpeg($new_img, $path2 . $image_name, 100);
        $img_qw = imagejpeg($img_id, 'images/' . "123", 100);
imagedestroy($img_id);//чистка памяти
imagedestroy($new_img);//чистка памяти
}


    function medium_photo_resize($ing)
    {

    }

    function small_photo_resize($ing)
    {

    }

}