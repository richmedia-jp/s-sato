<?php
echo "フォームの内容を確認するお<br />";

print $_POST["salon_name"]."<br />";
print $_POST["state"]."<br />";
print $_POST["address_1"]."<br />";
print $_POST["address_2"]."<br />";
print $_POST["tel_num"]."<br />";
print $_POST["business_hours"]."<br />";
print $_POST["closed"]."<br />";
print $_POST["salon_introduction_title"]."<br />";
print $_POST["salon_introduction_text"]."<br />";
print $_POST["salon_image_1"]."<br />";
print $_POST["salon_image_2"]."<br />";
print $_POST["salon_image_3"]."<br />";
print $_POST["recommend_flg"]."<br />";
print $_POST["delete_flg"]."<br />";
print $_POST["salon_update_time"]."<br />";

echo "確認できた？<br />";
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
						 $_POST['salon_image_1'], 
						 $_POST['salon_image_2'], 
						 $_POST['salon_image_3'], 
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