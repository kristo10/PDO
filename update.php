<?php
include "conn.php";

$stmt = $con->prepare("UPDATE info SET content = :content WHERE id = 3;");

// Vlera qe dua te ndryshoj tek rekordi(query):
$content = "Hello";

// Bej lidhjen e parametrave me vlerat reale
$stmt->bindValue(':content', $content);

// Tani ka ngel vetem ta egzekutojme rekordin
$rezultati = $stmt->execute();
echo "Rekordi u be update";


