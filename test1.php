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
    $check_file_img = false;
    $check_img = true;
    if (isset($_FILES['userfile'])) {
        $file_array = reArrayFiles($_FILES['userfile']);
        for ($i = 0; $i < count($file_array); $i++) {
            echo $file_array[$i]['tmp_name'] . '  ' .$file_array[$i]['name'] . '</br>';
            if($file_array[$i]['error']){
                echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']];
            } else {
                $extensions = array('jpg', 'png', 'gif', 'jpeg');
                $file_ext = explode('.', $file_array[$i]['name']);
                $file_ext = end($file_ext);
                if (!in_array($file_ext, $extensions)) {
                    $error_file_img.="{$file_array[$i]['name']} - invalid file extension";
                    $check_img = false;
                }
                if ($check_img == false) {
                    echo $error_file_img;
                } else {
                    // move_uploaded_file($_FILES['img-file']['tmp_name'], '../images/'.$_FILES[$i]['name']);
                    move_uploaded_file($file_array[$i]['tmp_name'], '../img-test/'.$file_array[$i]['name']);
                    echo '</br>' .$file_array[$i]['name'] . ' - ' . $phpFileUploadErrors[$file_array[$i]['error']]. '</br>';
                    $check_file_img = true;
                    echo 0;
                }
            }
            if (!file_exists($file_array[$i]['tmp_name']) || !is_uploaded_file($file_array[$i]['tmp_name']))  {
                $check_img = true;
                $check_file_img = true;
            }
        }
    }
    if ($check_file_img == true && $check_img == true) {
        echo 1;
    }

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