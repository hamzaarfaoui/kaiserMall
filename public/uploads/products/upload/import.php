<html>
    <head>
    <meta charset="UTF-8">
</head>
<body>
<?php
//$cnx =  mysql_connect("localhost", "db_democadifit", "tzzkr7iKK5sd35i");
//mysql_select_db("democadifit");
$cnx =  mysql_connect("localhost", "db_cadifit", "Jafq1QkbteHFden");
mysql_select_db("cadifit");
if (!$cnx) {
	echo "Erreur de connexion à la base de données.";
	exit;	
}
$row_count = 1;
$s = "";
if (($f = fopen("./files/".date('Ymd')."_cadifit.csv", "r")) !== FALSE) {
   while (($data = fgetcsv($f, 800, ";")) !== FALSE) {
        $data_count = count($data);
        //echo "<p> $data_count in line $row_count: <br /></p>\n";
        $nbCols = count($data);
        $row_count++;
        if ($row_count > 2) {
            $agence = 2;
            $entite = 0;
            $nbr = 0;
            $action = 999;
            $nom = $data[0];
            $prenom = $data[1];
            $matricule = $data[2];
            $date = explode("/", $data[3]);
            $d = $date[0]; if($d < 10) $d = "0".$d;
            $m = $date[1]; if($m < 10) $m = "0".$m;
            $dt = "2020-03-".$d;
            $datearrivee = $dt." 09:00:00";
            $datepriseencharge = $dt." 09:00:30";
            $datecloture = $dt." 09:02:00";
            $q = "INSERT INTO ca_clients (id_agence, entite, date_arrivee, date_priseencharge, date_cloture, nbr, nom, prenom, id_action) VALUES(".$agence.", ".$entite.", '".$datearrivee."', '".$datepriseencharge."', '".$datecloture."', $nbr, '".$nom."', '".$prenom."', $action)";
            $s .= "<li>".$q;
            $r = mysql_query($q);
            $lastid = mysql_insert_id();
            
            $motif = 6; if($nbCols == 5) $motif = $data[4];
            $q2 = "INSERT INTO ca_client_motifs (id_client, id_motif) VALUES ($lastid, $motif)";
            $r2 = mysql_query($q2);
        }
   }
   fclose($f);
}
//echo $s;
echo "Traitement terminé";
?>
</body>
</html>
