<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
            setcookie("RefreshEMP","YES");//Cookie for employeeManagerPage.php
            setcookie("BossLog",1);//Cookie for changeLog.php
        ?>
        <header>
        <h1>Καλημέρα κύριε/κυρία <?php echo $_COOKIE['userFnLog']." ". $_COOKIE['userLnLog']?></h1>
        </header>
        <main>
            <article>
                <h2>Menu Δραστηριοτήτων...</h2>
                <section>
                    <h3>Αποθήκη</h3>
                    <ul>
                        <li>Έλεγχος Αποθέματος</li>
                        <li>Αγορά Αποθέματος</li>
                        <li>Εισαγωγή/Διαγραφή προιόντων</li>
                        <li>Χειρισμός Σχέσης Αποθέματος/Προιόντων</li>
                    </ul>
                    <a href="StorageCentralPage.php">Επιλογή</a>
                </section>
                <section>
                    <h3>Προσωπικό</h3>
                    <ul>
                        <li>Προβολή Προσωπικού</li>
                        <li>Προβολή & Επεξεργασία Κατηγοριών Χρηστών</li>
                        <li>Πρόσληψη/Απώληση Προσωπικού</li>
                        <li>Ενημέρωση Στοιχείων Προσωπικού</li>
                        <li>Χειρισμός Bonus Προσωπικού</li>
                    </ul>
                    <a href="employeeManagerPage.php">Επιλογή</a>
                </section>
                <section>
                    <h3>Προιόντα</h3>
                    <ul>
                        <li>Προβολή Προιόντων & Παραλλαγών τους</li>
                        <li>Προβολή "Δημοφιλών" Προιόντων</li>
                        <li>Ενημέρωση Προιόντων (Προσθήκη/Διαγραφή/Ανανέωση...)</li>
                    </ul>
                    <a href="productsPage.php">Επιλογή</a>
                </section>
                <section>
                    <h3>Πωλήσεις</h3>
                    <ul>
                        <li>Προβολή Παραγγελιών</li>
                        <li>Προβολή "Δημοφιλών" Προιόντων</li>
                        <li>Κατάταξη  Υπαλλήλων Βάση Πωλήσεων</li>
                        <li>Στατιστικά Πωλήσεων</li>
                    </ul>
                    <a href="salesCentralPage.php">Επιλογή</a>
                </section>
                <section>
                    <h3>Λογιστήριο</h3>
                    <ul>
                        <li>Προβολή Εσόδων/Εξόδων</li>
                        <li>Μισθοδωσία Προσωπικού</li>
                        <li>Χαρτοφυλάκιο</li>
                    </ul>
                    <a href="">Επιλογή</a>
                </section>
                <section>
                    <h3>Λογαριασμός μου</h3>
                    <ul>
                        <li>Αλλαγή Στοιχείων Χρήστη</li>
                    </ul>
                    <a href="changeLog.php">Επιλογή</a>
                </section>
            </article>
        </main>
        <a href="empLog.php">Επιστροφή</a>
    </body>
</html>