<?php
include_once '../business.php';

$thumbnails = get_images_by_query($_GET['query']);
$to_send = [];
foreach($thumbnails as $thumb){
    $html = " <a href='./card?id=" . $thumb['id'] . "'>
                <img src='image?name=thumb_" . $thumb['name'] . "' alt='image'>
              </a>";
        $to_send[] = [
        'html'=>$html,
        'id'=>$thumb['id']
    ];
}
echo json_encode($to_send);
?>