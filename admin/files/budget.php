<?php
if ($_SESSION['logged_in'] == true && ($_SESSION['recht'] == "A") || $_SESSION["recht"] == "M") {
	if (isset($_GET['sid'])) {
		include 'edit_budget.php';
	} else {
         $recht = $_SESSION['recht'];
         $department = $_SESSION['department'];

	    if($recht == "A"){
            $query = "SELECT d.id, d.naam, d.budget, sum(ors.aantal * ors.prijs) as totaal FROM orders o JOIN users u on u.id = o.klant JOIN departments d on d.naam = u.department JOIN orderregels ors on ors.order_id = o.id WHERE u.department = 'IT' and (ors.status = 'besteld' or ors.status = 'betaald')
                      UNION
                      SELECT d.id, d.naam, d.budget, sum(ors.aantal * ors.prijs) as totaal FROM orders o JOIN users u on u.id = o.klant JOIN departments d on d.naam = u.department JOIN orderregels ors on ors.order_id = o.id WHERE u.department = 'Finance' and (ors.status = 'besteld' or ors.status = 'betaald')
                      UNION
                      SELECT d.id, d.naam, d.budget, sum(ors.aantal * ors.prijs) as totaal FROM orders o JOIN users u on u.id = o.klant JOIN departments d on d.naam = u.department JOIN orderregels ors on ors.order_id = o.id WHERE u.department = 'HR' and (ors.status = 'besteld' or ors.status = 'betaald')
                      UNION
                      SELECT d.id, d.naam, d.budget, sum(ors.aantal * ors.prijs) as totaal FROM orders o JOIN users u on u.id = o.klant JOIN departments d on d.naam = u.department JOIN orderregels ors on ors.order_id = o.id WHERE u.department = 'Logistic' and (ors.status = 'besteld' or ors.status = 'betaald')
                      UNION
                      SELECT d.id, d.naam, d.budget, sum(ors.aantal * ors.prijs) as totaal FROM orders o JOIN users u on u.id = o.klant JOIN departments d on d.naam = u.department JOIN orderregels ors on ors.order_id = o.id WHERE u.department = 'Purchase' and (ors.status = 'besteld' or ors.status = 'betaald')
                      ORDER BY totaal";
        }
	    if($recht == "M"){
	       $query = "SELECT d.id, d.naam, d.budget, sum(o.totaalprijs) as totaal FROM orders o JOIN users u on u.id = o.klant JOIN departments d on d.naam = u.department WHERE d.naam ='$department'";
	    }
    $result = mysqli_query($conn,$query);
    ?>
    <table>
        <tr>
            <th>Afdeling</th>
            <th>Budget</th>
            <th>Uitgegeven</th>
            <th></th>
        </tr>
        <?php
    while ($row = mysqli_fetch_assoc($result)) {
                $id = $row["id"];
                $department = $row["naam"];
                $budget = $row["budget"];
                $totaal = $row["totaal"];
                $percentage = $totaal / $budget * 100;
                $percentage = number_format((float)$percentage, 2, ',', '');
?>
                 <tr>

                    <td align="center"><?php echo $department ?></td>
                    <td align="center">€ <?php echo $budget ?></td>
                    <td align="center">€ <?php echo $totaal ?></td>
                    <td class="<?php if($percentage < 80){echo "budgetgreen";}elseif($percentage < 100 &&
                    $percentage
                     > 80){echo "budgetyellow";}elseif($percentage >=100){echo "budgetred";}?>" ><div
                     id="percentage"><?php echo
                     $percentage ?> %</div></td>
                    <td></td>
                    <?php if($recht == "A"){ ?>
                    <td align="center"><a target="_self"
                                          href="budget/s/<?php echo $id ?>"><button>Budget wijzigen</button></a></td>
                                          <?php } ?>
                </tr>
<?php }
}
} else {
	header("Location: http://projecthanze.com/admin/home");
}