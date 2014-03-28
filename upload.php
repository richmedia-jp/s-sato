<?php
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
		echo $imageFilePath;
}
	// index.phpになげる
	// header('Location: http://'.$_SERVER['SERVER_NAME']);
	exit;
?>