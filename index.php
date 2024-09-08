<?php
$host = 'mysql-db';
$user = 'ivan';
$pass = 'ivan';
$db = 'test_database';

$redis = new Redis();
$redis->connect('redis', 6379);

echo "Connection to redis successfull <br>";
 
echo "Server is running: " . $redis->ping() . "<br>";

$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

# QUERY

$stmt = $pdo->query('SELECT * FROM test');
while($row = $stmt->fetch()) {
	if (!$redis->exists($row->id)) {
		echo $row->id . " | " . $row->text . '<br>';
		$redis->set($row->id, $row->text);
	}
	else {
		echo "From redis: <br>";
		echo $redis->get($row->id) . "<br>";
	}
}

# QUERY FOR FILES

$stmt1 = $pdo->query('SELECT * FROM files');
while($row = $stmt1->fetch()) {
	// echo "DA LI POSTOJI? " . $redis->exists($row->title) . "<br>";
	if(!$redis->exists($row->title)) {
		echo $row->id . " | " . $row->title . '<br>';
		$file_content = file_get_contents($row->path);
		$redis->set($row->title, $file_content);
	}
	else {
		echo "From redis: <br>";
		echo $redis->get($row->title) . "<br>";
	}
}
echo "Svi kljucevi: <br>";
$keys = $redis->keys('*');
foreach ($keys as $key) echo $key . "<br>"; 


// while($row = $stmt->fetch()) {
// 	if (!$redis->exists($row->title)) {
// 		echo $row->id . " | " . $row->title . '<br>';
// 		$file_content = file_get_contents($row->path);
// 		$redis->set($row->title, $file_content);
// 	}
// 	if ($redis->exists($row->title)) {
// 		echo "From redis: $row->title <br>";
// 		// echo $redis->get($row->title) . "<br>";
// 	}
// }




// $conn = new mysqli($host, $user, $pass, $db);

// if ($conn->connect_error) {
// 	die("Connection failed: " . $conn->connect_error);
// }

// $results = $conn->query("SELECT * FROM test");

?>
<!-- <style>
 table, th, td {
 	border: 1px solid black;
 	border-collapse: collapse;
 }
 </style>

 <table style="width:50%">
 	<thead>
 		<tr>
 			<th>ID</th>
 			<th>Text</th>
 		</tr>
 	</thead>
 	<tbody>
 		<?php foreach ($results as $res): ?>
 			<tr>
 				<td>
 					<?= $res["id"] ?>
 				</td>
 				<td>
 					<?= $res["text"] ?>
 				</td>
 			</tr>
 		<?php endforeach ?>
		 
 	</tbody>
</table>  -->