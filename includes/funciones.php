<?php
//Se hace para que el codigo sea portable ya que en caso de no poder cargar va a marcar error
require 'app.php';

function incluirTemplate ( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/" . $nombre . ".php";
}
