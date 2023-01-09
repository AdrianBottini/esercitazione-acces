<?
include __DIR__ . '/settings.php';

// connessione al db
$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

// var_dump($conn); exit();

// verifico che non ci siano degli errori di connessione
if ($conn && $conn->connect_error) {
	echo "Connection failed: {$conn->connect_error}";
	exit();
}

$post_id = $_GET['id'] ?? null;
if ($post_id) {
	$sql = "SELECT * FROM posts WHERE `id` = {$post_id};"; // TODO: farlo con prepare mai con ->query()
} else {
	$sql = "SELECT `id`, `title` FROM posts;";
}

$result = $conn->query($sql);

// var_dump($result); exit(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>University</title>
</head>
<body><?php
	if ($post_id) { ?>
		<!-- <form action="" method="get">
			<label for="student_name">Nome studente</label>
			<input type="text" name="student_name" id="student_name" value="<?= $q_name ?>">
			<button>Cerca</button>
		</form>
		<br>
		<br> -->

		<?php

		if ($result && $result->num_rows == 1) {
			// la query è andata a buon fine e ci sono delle righe di risultati
			// finché ci sono righe di risultati
			$row = $result->fetch_assoc();
			echo "<h1>{$row['title']}</h1>";
			echo "<p>{$row['content']}</p>";
		} else {
			echo "404";
		}

	} else { ?>

		<h1>Blog con accesso</h1><?php

		if ($result && $result->num_rows > 0) {
			// la query è andata a buon fine e ci sono delle righe di risultati
			// finché ci sono righe di risultati
			while ($row = $result->fetch_assoc()) {
				echo "<a href=\"?id={$row['id']}\">{$row['title']}</a>";
				echo '<br>';
			}
		} elseif ($result) {
			// la query è andata a buon fine ma non ci sono righe di risultati
			echo "Non ci sono posts";
		} else {
			// si è verificato un errore nella query (es: nome tabella sbagliato)
			echo "DB error";
		}
	}


	// chiudo la connessione al db
	$conn->close(); ?>

</body>
</html>