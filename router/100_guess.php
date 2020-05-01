<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for the gamestart
    $_SESSION["res"] = null;
    $game = new Pegh\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();


    return $app->response->redirect("guess/play");
});



/**
* PLay the game - Show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game!";

    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $doCheat = $_SESSION["doCheat"] ?? null;
    $number = $_SESSION["number"] ?? null;


    $_SESSION["res"] = null;
    $_SESSION["guess"] = null;
    $_SESSION["doCheat"] = null;

    $data = [
        "guess" => $guess ?? null,
        "tries" => $tries,
        "number" => $number ?? null,
        "res" => $res ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
    ];


    $_SESSION["res"] = null;
    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * PLay the game - make a guess
 */
$app->router->post("guess/play", function () use ($app) {

    $guess = $_POST["guess"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $number = $_SESSION["number"] ?? null;


    if ($doGuess) {
        $game = new Pegh\Guess\Guess($number, $tries);
        $res = $game->makeGuess($guess);
        $_SESSION["tries"] = $game->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
        $_SESSION["number"] = $number;
        $_SESSION["doInit"] = $doInit;
        $_SESSION["doCheat"] = $doCheat;
    }
    elseif ($doCheat) {
        $_SESSION["res"] = "Cheated number is: " . $number;
        return $app->response->redirect("guess/play");
    }else  {
        return $app->response->redirect("guess/init");
    }
    return $app->response->redirect("guess/play");
});
