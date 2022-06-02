<?php
include "conn.php";
/*
Shtimi i nje rekordi ne nje tabele
1- Ne fazen e pergatitjes dergohet ne server nje deklarate ne forme shablloni qe permban disa parametra te formes ':emri_parametrit' ne vend te vlerave reale te fushave.
2- Ne fazen e dyte dergohen ne server vetem vlerat te lidhura me parametrat specifik.*/

$stmt = $con->prepare("INSERT INTO info (name, content) VALUES (:name, :content);");

// Vlera e rekordit qe duam te shtojme ne tabele:
$name = "PHP";
$content = "eshte nje gjuhe programimi e cila na ndihmone te krijojme web faqe,projekte te ndryshme te cilat na cojne edhe me shume drejt teknologjise";

// Behet lidhja e parametrave me vlerat reale:
// Kjo gje arrihet me ane te nje metode "bindValue(':parametri','vlera reale' );"
$stmt->bindValue(':name', $name);
$stmt->bindValue(':content', $content);

// Tani ka ngel vetem egzekutimi per te shtuar rekordin e ri:
$rezultati = $stmt->execute();
echo "Rekordi u shtua me sukses";
echo "<br><br>";

// Tani ne mund te marrim dhe ID-in e rekordit qe regjistruam me ane te nje metode 'lastInsertId();'
if ($rezultati) {
    $id = $con->lastInsertId();
    echo "ID-ja : " . $id;
}