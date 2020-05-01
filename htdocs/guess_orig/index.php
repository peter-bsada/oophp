<?php
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");

session_name("Peter");
session_start();


$guess = $_POST["guess"] ?? null;
$doInit = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;

// Get setting from the session

$tries = $_SESSION["tries"] ?? null;
$number = $_SESSION["number"] ?? null;
$game = null;

if ($doInit || $number === null) {
    $game = new Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
} elseif ($doGuess) {
    $game = new Guess($number, $tries);
    $res = $game->makeGuess($guess);
    $_SESSION["tries"] = $game->tries();
}


// if ($tries === 0) {
//     header("location: index.php");
//     exit();
// }
// echo "<a href='index.php'>Go to start<a>";

// Render the page
require __DIR__ . "/view/guess_my_number_post.php";
