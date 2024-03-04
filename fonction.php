<?php
function convertirEnHeuresMinutes($duree) {
$heures = floor($duree / 60);
$minutes = $duree % 60;
return "$heures h $minutes min";
}