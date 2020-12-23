<?php

require __DIR__ . '/is_admin.php';
require __DIR__ . '/db_connect.php';

$upload_folder = __DIR__ . '/imgs';

$output = [

    'success' => false,
    'code' => 0,
    'error' => '參數不足',
    'post' => $_POST,
];

$ext_map = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/gif' => '.gif',
];


if (!empty($_FILES) and !empty($_FILES['photo']['type']) and $ext_map[$_FILES['photo']['type']]) {
    $output['file'] = $_FILES;

    $filename = uniqid() . $ext_map[$_FILES['photo']['type']];
    $output['filename'] = $filename;
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_folder . '/' . $filename)) {
        $output['filename'] = $filename;
    }
}


if (!isset($_POST['sid']) or !isset($_POST['product_name'])) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
// TODO: 檢查欄位格式

$sql = "UPDATE `product` SET
`product_name`=?,
`photo`=?,
`category`=?,
`price`=?,
`color`=?,
`size`=?,
`introduction`=?
WHERE `sid`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['product_name'],
    $filename,
    $_POST['category'],
    $_POST['price'],
    $_POST['color'],
    $_POST['size'],
    $_POST['introduction'],
    $_POST['sid'],
]);

$output['rowCount'] = $stmt->rowCount();
if ($stmt->rowCount()) {
    $output['success'] = true;
    unset($output['error']);
} else {
    $output['error'] = '資料無修改';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
