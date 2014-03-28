<DOCTYPE html>
<html lang="ja">
	<head>
		<meta charaset="utf-8">
		<title>美容室登録ページ</title>
	</head>
	<body>

		<p>美容室登録ページです</p>

		<!-- フォーム部分 -->
		<form action="db_register_salons.php" method="POST">
			美容室名　<input type="text" name="salon_name" value="サロン名" /><br>

			都道府県　<select name="state">
			<option value=null selected>都道府県を選択してください</option>
				<?php
				// DBから都道府県情報を取得
				$dsn = 'mysql:dbname=rich_salons_media;host=localhost;charset=utf8;';
				$user = 'root';
				$password = 'rich2014';
				try{
				    $dbh = new PDO($dsn, $user, $password);
				    // $dbh->query('SET NAMES utf8');

				    $sql = 'select * from state_master';
				    foreach ($dbh->query($sql) as $row) {
				            echo"<option value=".$row['state_id'].">".$row['state_name']."</option>";
				    }
				}catch (PDOException $e){
				    print('Error:'.$e->getMessage());
				    die();
				}

				$dbh = null;
				?>
			</select><br>

			住所1 <input type="text" name="address_1" value="住所_1" /><br>
			住所2 <input type="text" name="address_2" value="住所_2" /><br>
			電話番号 <input type="text" name="tel_num" value="00011112222" /><br>
			営業時間 <input type="text" name="business_hours" value="24時間！" /><br>
			<!-- 定休日を選択にしないのは「連休の次の日」という休み方の店があるから -->
			定休日 <input type="text" name="closed" value="年中無休" /><br>
			紹介タイトル <input type="text" name="salon_introduction_title" value="紹介タイトルです" /><br>
			紹介本文 <input type="text" name="salon_introduction_text" value="紹介本文です" /><br>
			店舗画像1 <input type="file" name="salon_image_1" /><br>
			店舗画像2 <input type="file" name="salon_image_2" /><br>
			店舗画像3 <input type="file" name="salon_image_3" /><br>
			おすすめフラグ <input type="hidden" name="recommend_flg" value=0 />
						 <input type="checkbox" name="recommend_flg" value=1 /><br>
			登録タグ <select name="tags" /></select><br>
			<!-- 現在時刻を取得して隠しパラメータとして送信 -->
			<?php
				$datetime = new DateTime();
				$today = $datetime->format('Y/m/d-H:i:s');
				echo "$today";
				echo "<input type=\"hidden\" name=\"salon_update_time\" value=".$today." /><br>";
			?>
			<input type="submit" value="登録"><br>

		</form>


	</body>
</html>
