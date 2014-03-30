<?php
// echo "フォームの内容を確認するお<br />";

// print $_POST["salon_name"]."<br />";
// print $_POST["state"]."<br />";
// print $_POST["address_1"]."<br />";
// print $_POST["address_2"]."<br />";
// print $_POST["tel_num"]."<br />";
// print $_POST["business_hours"]."<br />";
// print $_POST["closed"]."<br />";
// print $_POST["salon_introduction_title"]."<br />";
// print $_POST["salon_introduction_text"]."<br />";
// print $_POST["salon_image_1"]."<br />";
// print $_POST["salon_image_2"]."<br />";
// print $_POST["salon_image_3"]."<br />";
// print $_POST["recommend_flg"]."<br />";
// print $_POST["delete_flg"]."<br />";
// print $_POST["salon_update_time"]."<br />";

// echo "確認できた？<br />";

echo '画像のアップロード';
require_once('config.php');
foreach($_FILES['image']['name'] as $key => $value){
	// エラーチェック
	if($_FILES['image']['error'][$key] != UPLOAD_ERR_OK) {
		echo "エラーが発生しました : ".$_FILES['image']['error'][$key];
		exit;
	}

	$size = filesize($_FILES['image']['tmp_name'][$key]);
	if(!$size || $size > MAX_FILE_SIZE){
		echo "ファイルサイズが大きすぎます";
		exit;
	}

	// 保存するファイル名
	$imagesize = getimagesize($_FILES['image']['tmp_name'][$key]);
	switch($imagesize['mime']){
		case 'image/gif':
			$ext = '.gif';
			break;
		case 'image/jpeg':
			$ext = '.jpg';
			break;
		case 'image/png':
			$ext = '.png';
			break;
		default:
			echo "GIF/JPEG/PNG only!";
			exit;
	}

	$imageFileName = sha1(time().mt_rand()) . $ext;


	// 元画像を保存
	$imageFilePath = IMAGES_DIR . '/' . $imageFileName;

	$rs = move_uploaded_file($_FILES['image']['tmp_name'][$key], $imageFilePath);

	if(!$rs){
		echo "could not upload!";
		exit;
	}

	// 縮小画像を作成・保存
	$width = $imagesize[0];
	$height = $imagesize[1];

	if($width > THUMBNAIL_WIDTH){
		// 元ファイルを画像タイプによって作る
		switch($imagesize['mime']){
			case 'image/gif':
				$srcImage = imagecreatefromgif($imageFilePath);
				break;
			case 'image/jpeg':
				$srcImage = imagecreatefromjpeg($imageFilePath);
				break;
			case 'image/png':
				$srcImage = imagecreatefrompng($imageFilePath);
				break;
		}

		// 新しいサイズを作る
		$thumbHeight = round($height * THUMBNAIL_WIDTH / $width);

		// 縮小画像を生成
		$thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);
		imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, 72, $thumbHeight, $width, $height);
		
		// 縮小画像を保存する
		switch($imagesize['mime']){
			case 'image/gif':
				imagegif($thumbImage, THUMBNAIL_DIR.'/'.$imageFileName);
				break;
			case 'image/jpeg':
				imagejpeg($thumbImage, THUMBNAIL_DIR.'/'.$imageFileName);
				break;
			case 'image/png':
				imagepng($thumbImage, THUMBNAIL_DIR.'/'.$imageFileName);
				break;
		}

	}
	$imagePath[$key] = $imageFilePath;
}
echo 'アップロードしました';

echo '登録します！';
// DBに値を挿入
$dsn = 'mysql:dbname=test_db;host=localhost;';
$user = 'root';
$password = 'rich2014';
try{
    $dbh = new PDO($dsn, $user, $password);
    // $dbh->query('SET NAMES utf8');

    $stmt = $dbh->prepare("INSERT INTO salons(salon_name, 
    										  state, 
    										  address_1, 
    										  address_2, 
    										  tel_num, 
    										  business_hours, 
    										  closed, 
    										  salon_introduction_title, 
    										  salon_introduction_text, 
    										  salon_image_1, 
    										  salon_image_2, 
    										  salon_image_3, 
    										  recommend_flg, 
    										  delete_flg, 
    										  salon_update_time) 
    						VALUES('?', '?', '?', '?', '?', '?', '?', '?', 
    								'?', '?', '?', '?', '?', '?', '?')");
    $stmt->execute(array($_POST['salon_name'],
    					 $_POST['state'], 
						 $_POST['address_1'], 
						 $_POST['address_2'], 
						 $_POST['tel_num'], 
						 $_POST['business_hours'], 
						 $_POST['closed'], 
						 $_POST['salon_introduction_title'], 
						 $_POST['salon_introduction_text'], 
						 $imagePath[0], 
						 $imagePath[1], 
						 $imagePath[2], 
						 $_POST['recommend_flg'], 
						 $_POST['delete_flg'], 
						 $_POST['salon_update_time']
						)
    			   );
	}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$dbh = null;
echo '登録できた？';
?>