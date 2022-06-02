<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="userfile[]" value="" multiple="">
        <input type="submit" name="submit" value="Upload">
    </form>
    <?php
    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    $array = array();
    $array_img_file = array();
    $img_insert = '';
    $check = true;
    if (isset($_FILES['userfile'])) {
        $file_array = reArrayFiles($_FILES['userfile']);
        for ($i = 0; $i < count($file_array); $i++) {
            if($file_array[$i]['error']){
                echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']];
            } else {
                $extensions = array('jpg', 'png', 'gif', 'jpeg');
                $file_ext = explode('.', $file_array[$i]['name']);
                $file_ext = end($file_ext);
                if (!in_array($file_ext, $extensions)) {
                    // $error_file_img.="{$file_array[$i]['name']} - invalid file extension";
                    $error_file_img.="<li>{$file_array[$i]['name']} - file phải có định dạng jpg, jpeg, gif, png !</li>";
                    $check = false;
                }
                if ($check == false) {
                } else {
                    $array_img_file[$i]['temp-name'] = $file_array[$i]['tmp_name'];
                    $array_img_file[$i]['name'] = $file_array[$i]['name'];
                    $img_insert.=','.$file_array[$i]['name'];
                    // move_uploaded_file($_FILES['img-file']['tmp_name'], '../images/'.$_FILES[$i]['name']);
                    // move_uploaded_file($file_array[$i]['tmp_name'], '../img-test/'.$file_array[$i]['name']);
                    // echo '</br>' .$file_array[$i]['name'] . ' - ' . $phpFileUploadErrors[$file_array[$i]['error']]. '</br>';
                }
            }
            // if (!file_exists($file_array[$i]['tmp_name']) || !is_uploaded_file($file_array[$i]['tmp_name']))  {
            //     $check = true;
            // }
        }
    }
    foreach ($array_img_file as $row) {
        move_uploaded_file($row['temp-name'], '../img-test/'.$row['name']);
    }
    print_r($array_img_file);
    if ($check == true) {
        echo '</br>' . $img_insert;
    }
    echo $error_file_img;

    function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
    
        return $file_ary;
    }
    ?>
</body>
</html>