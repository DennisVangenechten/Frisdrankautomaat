<?php
// Presentation/index.php
declare(strict_types=1);
namespace Presentation;

use Business\MuntService;
use Business\FrisdrankService;
use Data\MuntDAO;

$muntService = new MuntService();
$muntDAO = new MuntDAO();
$frisdrankService = new FrisdrankService();
$frisdranken = $frisdrankService->getAlleFrisdranken();

// Haal alle munten op uit de database
$munten = $muntDAO->getAll();
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Presentation/style2.css">
    <title>Frisdrankautomaat</title>
    <script src="Drank_automaat/Presentation/script.js" defer></script>
</head>

<body>

    <div class="vending-machine">
        <div class="machine-content">
            <div class="drinks-container">
                <?php foreach ($frisdranken as $frisdrank): ?>
                    <div class="drink">
                        <form method="post" <?php if ($frisdrank->getVoorraad() <= 0): ?>class="uitgeput" <?php endif; ?>>
                            <img src="Drank_automaat/Presentation/Images/<?php echo htmlspecialchars($frisdrank->getAfbeelding()); ?>" alt="<?php echo htmlspecialchars($frisdrank->getNaam()); ?>">
                            <input type="hidden" name="frisdrankId" value="<?php echo intval($frisdrank->getId()); ?>">
                            <button type="submit">€ <?php echo number_format((float) $frisdrank->getPrijs(), 2); ?></button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="coins-container">
                <h2>Munten</h2>
                <form method="post">
                    <ul>
                        <?php foreach ($munten as $munt): ?>
                            <li>
                                <button type="submit" name="munt" value="<?php echo floatval($munt->getWaarde()); ?>">€ <?php echo number_format((float) $munt->getWaarde(), 2); ?></button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </form>
                <h2>Bedrag € <?php echo number_format((float) $_SESSION['ingeworpenBedrag'], 2); ?></h2>
                <form method="post">
                    <button type="submit" name="terugbetaling" value="true">Terugbetaling</button>
                </form>
                <?php if (!empty($errorMsg)): ?>
                    <div class="error-message"><?php echo $errorMsg; ?></div>
                <?php endif; ?>

                <?php if (!empty($wisselgeld)): ?>
                    <div class="change">
                        <h2>Wisselgeld:</h2>
                        <ul>
                            <?php foreach ($wisselgeld as $muntId => $aantal): ?>
                                <li><?php echo intval($aantal); ?> x
                                    € <?php echo number_format((float) $muntService->getMuntById($muntId)->getWaarde(), 2); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if (isset($selectedDrinkId)): ?>
                    <?php $gekozenFrisdrank = $frisdrankService->getFrisdrankById($selectedDrinkId); ?>
                    <?php if ($gekozenFrisdrank): ?>
                        <div class="selected-drink">
                            <h3>Gekozen drankje:</h3>
                            <img src="/HTML&CSS_AD/Drank_automaat/Presentation/Images/<?php echo htmlspecialchars($gekozenFrisdrank->getAfbeelding()); ?>" alt="<?php echo htmlspecialchars($gekozenFrisdrank->getNaam()); ?>">
                            <p><?php echo htmlspecialchars($gekozenFrisdrank->getNaam()); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <!-- Admin panel toggle button -->
            <div class="admin-toggle">
                <img src="https://www.svgrepo.com/show/501805/admin.svg" alt="Admin Key" width="24" height="24">
            </div>

            <!-- Admin panel -->
            <div class="admin-panel" id="admin-panel">
                <h2>Admin-panel</h2>
                <form action="authenticatie.php" method="post">
                    <label for="username">Gebruikersnaam:</label>
                    <input type="text" id="username" name="username" required><br>
                    <label for="password">Wachtwoord:</label>
                    <input type="password" id="password" name="password" required><br>
                    <button type="submit">Inloggen</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer"></footer>
</body>

</html>
