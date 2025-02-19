<?php
    session_start();
    include_once "con_dbb4.php";

    //supprimer les produits
    //si la valiable del existe
    if(isset($_GET['del'])){
        $id_del = $_GET['del'];
        //suppression
        unset($_SESSION['panier4'][$id_del]);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="panier.css">
</head>
<body class="panier">
    <a href="panierLag.php"><img src="symbole-de-la-fleche-gauche-dans-un-cercle.png"></a>
    <section>
        <table>
            <tr>
                <th></th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Action</th>
            </tr>
            <?php
                $total = 0;
                //liste des produits
                //recupéer les clés du tableau session
                $ids = array_keys($_SESSION['panier4']);
                // s'il n'y a aucune clé dans le tableau
                if(empty($ids)){
                    echo "Votre panier est vide";
                }else{
                    //si oui
                    $produits = mysqli_query($con, "SELECT * FROM plat WHERE id IN (".implode(',', $ids).")");
                    
                    //liste des produits avec la boucle foreach
                    foreach($produits as $produit):
                        //calculer le total (Prix Unitaire * quantité)
                        // et additionner chaque résultat a chaque tour de boucle
                        $total = $total + $produit['price'] * $_SESSION['panier4'][$produit['id']];
                    ?>
                 <td><img src="lagon/<?=$produit['img']?>"></td>
                    <td><?=$produit['name']?></td>
                    <td><?=$produit['price']?>FCFA</td>
                    <td><?=$_SESSION['panier4'][$produit['id']] //quantité?></td>
                    <td><a href="panierLag2.php?del=<?=$produit['id']?>"><img src="delete.jpg"></a></td>
                </tr>
            
            <?php endforeach ;} ?>            

            <tr class="total">
                <th>Total : <?=$total?> </th>
            </tr>
        </table>
    </section>
    <a href="panierLag3.php"><img src="fleche-droite-dans-un-cercle.png"></a>
</body>
</html>