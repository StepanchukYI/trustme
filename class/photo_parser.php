<?php

/*
 * перед использованием этого класса необходимо создать в директории папки user_photo
 * также создать папки product_photo
 */

class photo_parser
{
    /*
     * принимаем закодированную строку и юзер ID, под которым записываем фото на сервер
     */
    public static function Getpicture_from_User($decoded_string, $user_id)
    {

        $decoded_string = base64_decode($decoded_string);//декодируем строку в картинку
        $image_name = $user_id . '_large.jpeg';
        $path = 'user_photo/' . $image_name;   //указание директории куда сохраняем файл


        $file = fopen($path, 'wb');
        fwrite($file, $decoded_string);//записываю в файл
        fclose($file);


        $path_medium = 'user_photo/';
        $image_name_medium = $user_id . '_medium.jpeg';
        $image_name_small = $user_id . '_small.jpeg';
        photo_parser::Resize_foto_small($path, $image_name_medium, $path_medium);
        photo_parser::Resize_foto_medium($path, $image_name_small, $path_medium);

    }

    public static function Getpicture_from_product($decoded_string, $product_id)
    {
        $decoded_string = base64_decode($decoded_string);//декодируем строку в картинку
        $image_name = $product_id . '_large.jpeg';
        $path = 'product_photo/' . $image_name;   //указание директории куда сохраняем файл


        $file = fopen($path, 'wb');
        fwrite($file, $decoded_string);//записываю в файл
        fclose($file);


        $path_medium = 'product_photo/';


        $image_name_medium = $product_id . '_medium.jpeg';
        $image_name_small = $product_id . '_small.jpeg';


        photo_parser::Resize_foto_small($path, $image_name_medium, $path_medium);
        photo_parser::Resize_foto_medium($path, $image_name_small, $path_medium);
    }
    //path принимает путь к файлу который нужно изменить
    //$image_name имя картинки

    function Resize_foto_small($path, $image_name, $new_path)
    {
        $img_id = imagecreatefromjpeg($path);

        $img_width = imageSX($img_id);
        $img_height = imageSY($img_id);


        $k = round($img_width / 75, 2);


        $new_width = $img_width / $k;
        $new_height = $img_height / $k;
        $new_img = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($new_img, $img_id, 0, 0, 0, 0,
            $new_width, $new_height, $img_width, $img_height);

        imagejpeg($new_img, $new_path . $image_name, 100);


        imagedestroy($img_id);//чистка памяти
        imagedestroy($new_img);//чистка памяти
    }


    function Resize_foto_medium($path, $image_name, $new_path)
    {
        $img_id = imagecreatefromjpeg($path);

        $img_width = imageSX($img_id);
        $img_height = imageSY($img_id);

        $k = round($img_width / 130, 2);

        $new_width = $img_width / $k;
        $new_height = $img_height / $k;
        $new_img = imagecreatetruecolor($new_width, $new_height);


        imagecopyresampled($new_img, $img_id, 0, 0, 0, 0,
            $new_width, $new_height, $img_width, $img_height);

        imagejpeg($new_img, $new_path . $image_name, 100);

        imagedestroy($img_id);//чистка памяти
        imagedestroy($new_img);//чистка памяти
    }

}