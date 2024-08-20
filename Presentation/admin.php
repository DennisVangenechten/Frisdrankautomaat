<?php
// Presentation/admin.php
declare(strict_types=1);
namespace Presentation;

use Business\MuntService;
use Business\FrisdrankService;

$frisdrankService = new FrisdrankService();
$frisdranken = $frisdrankService->getAlleFrisdranken();

$muntService = new MuntService();
$munten = $muntService->getMuntenInLade();
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="Presentation/admin2.css">
</head>

<body>
    <header class="header">
        <h1>Frisdrankautomaat</h1>
    </header>

    <div class="container">
        <!-- Voorraad Frisdrank Aanpassen -->
        <div class="vending-machine">
            <div class="machine-content">
                <h2>Voorraad Frisdrank Aanpassen</h2>
                <?php foreach ($frisdrankService->getAlleFrisdranken() as $frisdrank): ?>
                    <div class="drink">
                        <!-- Afbeelding van de frisdrank -->
                        <img src="/HTML&CSS_AD/Drank_automaat/Presentation/Images/<?php echo $frisdrank->getAfbeelding(); ?>" alt="<?php echo $frisdrank->getNaam(); ?>">
                        <p class="info">Voorraad: <?php echo $frisdrank->getVoorraad(); ?></p>
                        <?php if (isset($errorMsgs[$frisdrank->getId()])): ?>
                            <p class="error"><?php echo $errorMsgs[$frisdrank->getId()]; ?></p>
                        <?php endif; ?>
                        <form method="post">
                            <input type="hidden" name="frisdrankId" value="<?php echo $frisdrank->getId(); ?>">
                            <button type="submit" name="verhoog" class="button">Verhoog Voorraad</button>
                            <button type="submit" name="verminder" class="button">Verminder Voorraad</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Munten sectie -->
        <div class="vending-machine">
            <div class="machine-content">
                <h2>Muntlade Aanpassen</h2>
                <form method="post">
                    <button type="submit" name="legeMuntlade" class="button">Leeg Muntlade</button>
                </form>
                <h2>Individueel Muntlade aanvullen</h2>
                <?php foreach ($muntService->getMunten() as $munt): ?>
                    <div class="drink">
                        <p class="info">€ <?php echo $munt->getWaarde(); ?> - Aantal: <?php echo $munt->getAantal(); ?></p>
                        <form method="post">
                            <input type="hidden" name="muntId" value="<?php echo $munt->getId(); ?>">
                            <input type="number" name="aantal" min="1" value="1" class="input-number">
                            <button type="submit" name="vul_munt" class="button">Vul</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="logout-container">
            <form action="logout.php" method="post" class="logout-form">
                <button type="submit" name="logout" class="button">Uitloggen</button>
            </form>
        </div>
    </footer>
</body>

</html>
