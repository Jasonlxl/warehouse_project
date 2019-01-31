<?php
session_start();
$url = $_POST["url"];
$_SESSION["fname"] = $url;