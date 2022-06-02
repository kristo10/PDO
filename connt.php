<?php

class Database {
    public $connection;
    public function __construct($host, $db, $user, $password) {
        $this->connection = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    }

    /* ndertoj nje metode insert(.....) e cila do te jete dinamike, ne menyre te tille qe te funksionoje per cdo lloj tabele
    dhe mund te shtoje rekorde me vlera te ndryshme.
    Funksioni insert(...) do  pranoje 2 argumenta:
    1- Argumenti i pare do te jete nje string qe mbane emrin e tabeles ne te cilen do te bejme shtimin e rekordit(query) te rri
    2- Argumenti i dyte do te jete nje array associative 'key => value' i cili do te mbaje si "keys" emrat e fushave te tabeles
    dhe si "values" do te mbaje vlerat perkatese qe do kene keto fusha ne rekordin e rri  */

    public function insert(string $table, array $field_values) {

        // funksioni implode("",array) merr te gjitha elementet e nje array dhe si output jep nje string me elementet e bashkuar
        // funksioni array_keys(...) merr si argument nje array dhe kthen si output nje array tjeter i cili permban listen me key(celsa)
        $fushat = implode(',', array_keys($field_values));
        $parametrat = ':' . implode(', :', array_keys($field_values));

        $stmt = $this->connection->prepare("INSERT INTO $table ($fushat) VALUES ($parametrat);");

        foreach ($field_values as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $rezultati = $stmt->execute();
        if ($rezultati) {
            $id = $this->connection->lastInsertId();
            echo $id;
        }
    }

    /* ndertoj nje metode update(...)  te pranoje 3 argumente
    1- Argumenti i pare do te jete nje string qe mban emrin e tabeles ne te cilen do te bejme modifikim e rekordit(query)
    2- Argumenti i dyte do te jete nje array associative "key=>value" i cili do te mbaje si "key" emrat e fushave te tabeles qe do modifikojme
    dhe si "values" do te mbajme vlerat perkatese qe do te kene keto fusha
    3- Argumenti i trete do te jete nje string qe mban kushin "where", pa e perfshire vete termin "where" p.sh 'id=1' dhe jo 'WHERE id=1'
    */

    public function update(string $table, array $field_values, string $where) {
        $fusha_vlerat = null;
        foreach ($field_values as $key => $value) {
            $fusha_vlerat .= "$key = :$key,";
        }
        // funksioni 'rtrim($variabli);' perdoret te hequr hapsiren nga ana e djathte e stringut. Ne kete rast e kam perdor per te heq ','
        $fusha_vlerat = rtrim($fusha_vlerat, ',');
        $stmt = $this->connection->prepare("UPDATE $table SET $fusha_vlerat WHERE $where");
        foreach ($field_values as $key => $value) {
            $stmt->bindValue(":$key",$value);
        }
        $rezultati = $stmt->execute();
        echo "Rekordi u modifikua";
    }

    /* nsertoj nje metode select(....) qe pranon 3 argumenta
    1- Argumenti i pare do te jete nje string qe mban deklarten SQL
    2- Argumenti i dyte do te jete nje array associative "key=>value" i cili do te mbaje si "keys" prametrat te vendosur ne SQL te tipit:fusha, dhe
    si "values" do te mbaje vlerat perkatese qe do te kene keto parametra ne SQL
    3- Argumenti i trete do te jete nje konstante e klases "PDO" e cila tregon se ne cfare menyre do te merren te dhenat
    Ks nje vlere default "PDO::FETCH_ASSOC", pra nuk jemi te detyruar ta percaktojme
    */
    public function select(string $sql, array $bindArray = array(), $fetchMode = PDO::FETCH_ASSOC) {
        $stmt = $this->connection->prepare($sql);
        foreach ($bindArray as $key => $value) {
            $stmt->bindValue("$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll($fetchMode);
    }
}
$table = "info";
$field_values = [
    // Deklarojme vetem fushen qe dua te modifikoj
    // "name"=>"Departamenti i Elektronikes dhe Telekomunikacionit",
    "content"=>"Pershkrimi i D.E.T. i modifikuar"
];
// na sherben per kushtin per te bere update
$where = "id = 20";
$mysql = new Database("localhost","pdo","root","");
// $mysql->insert($table,$field_values);
$mysql->update($table,$field_values,$where);

//select
$sql = "SELECT * FROM info WHERE id = :id";
$rekordet = $mysql->select($sql, [":id"=>4] );
echo "<br>";

foreach ($rekordet as $key => $rekord) {

    echo "Departamenti: " . $rekord['name'] . '<br>';
    echo "content: "    . $rekord['content'];
}



