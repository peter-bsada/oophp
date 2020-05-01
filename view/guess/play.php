<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes

?>
<h1>Guess my number</h1>

<p>Guess a number between 1 and 100, you have <?= $tries ?> life left.</p>

<form method="post">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <?php if (!((int)$guess === $number || $tries === 0)) : ?>
    <input type="text" name="guess">
    <input type="submit" name="doGuess" value="Make a guess">
    <?php endif; ?>
    <input type="submit" name="doInit" value="Start from beginning">
    <?php if (!((int)$guess === $number || $tries === 0)) : ?>
    <input type="submit" name="doCheat" value="Cheat">
    <?php endif; ?>
</form>

<?php if ($res) : ?>
    <p>Your guess <?= $guess ?> is <b><?= $res?></b></p>
    <?php if ($tries === 0) : ?>
        <p>Game Over, Try again!</p>
    <?php endif; ?>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>CHEAT: Current number is <?= $number ?>.</p>
<?php endif; ?>
