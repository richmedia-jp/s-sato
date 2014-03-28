<?php
echo "hellow";
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>画像投稿</title>
</head>
<body>
	<form action="upload.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>"> 
		<input type="file" name="image[]"><br>
		<input type="file" name="image[]"><br>
		<input type="file" name="image[]"><br>
		<input type="submit" value="アップロード">
	</form>
</body>
</html>
<?php
echo "bay";
?>