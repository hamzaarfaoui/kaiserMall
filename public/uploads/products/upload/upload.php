<?php
    header('Content-type: text/plain; charset=utf-8');
    move_uploaded_file($_FILES["file"]["tmp_name"], "./files/".date("Ymd")."_cadifit.csv");
    echo "Upload du fichier terminé";
?>