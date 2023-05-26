<?php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
$pageName = 'cultures';
require_once '../inc/header.php';

$sql = "SELECT COUNT(*) AS total FROM cultures";
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetch();
$nbVilles = (int)$result->total;
// echo $nbVilles;
$parPage = 5;
//calcule le nombre de pages totale

$pages = ceil($nbVilles / $parPage);
// die($pages);
//calcule du 1er ville de la page
$premier = ($currentPage * $parPage) - $parPage;
$sql = 'SELECT * FROM `cultures` ORDER BY `id_culture` DESC LIMIT :premier, :parPage; ';
$query = $pdo->prepare($sql);
$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parPage', $parPage, PDO::PARAM_INT);
$query->execute();
$cultures = $query->fetchAll(PDO::FETCH_ASSOC);
require_once '../inc/header.php';
require_once BL . 'functions/messages.php';
?>
<!--Table-->
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-lg-6">
            <h1>Table Cultures</h1>
        </div>
        <div class="col-lg-6 ">
            <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#addCul">Ajouter</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" id="showOs">
                <table class="table table-bordered mb-5 text-center">
                    <thead>
                        <tr class="table-primary text-center">
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Description</th>
                            <th scope="col">Rendement Moyen</th>
                            <th scope="col">Periode Recolte</th>
                            <th scope="col">Irrigation Utilisee</th>
                            <th scope="col">Oasis</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cultures as $item) : ?>
                            <tr class=" text-center">
                                <th scope="row"><?php echo $item['id_culture']; ?>
                                </th>
                                <td><?php echo $item['nom_culture']; ?></td>
                                <td><?php echo $item['description']; ?></td>
                                <td><?php echo $item['rendement_moyen']; ?></td>
                                <td><?php echo $item['periode_recolte']; ?></td>
                                <td><?php echo $item['irrigation_utilisee']; ?></td>
                                <td><?php echo $item['id_oasis']; ?></td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-primary m-2" onclick="detailCul(<?php echo $item['id_culture'] ?>)"><i class='bx bx-show'></i></button>
                                    <button class="btn btn-success m-2" onclick="editCul(<?php echo $item['id_culture'] ?>)"><i class='bx bx-edit'></i></button>
                                    <button class="btn btn-danger m-2" onclick="deleteCul(<?php echo $item['id_culture'] ?>)"><i class='bx bx-trash'></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- pagination -->
    <nav aria-label="Page navigation example float-rigth" id="pagination">
        <ul class="pagination justify-content-end">
            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                <a class=" page-link " href="./?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php
            for ($page = 1; $page <= $pages; $page++) {
            ?>
                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>"><a class="page-link " href="./?page=<?= $page ?>"><?php echo $page ?></a></li>
            <?php } ?>
            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                <a class="page-link" href="./?page=<?= $currentPage + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>

        </ul>
    </nav>
    <!-- add modal -->
    <div class="modal fade" id="addCul" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Culture</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Nom : </label>
                                    <input class="form-control" type="text" placeholder="Nom de oasis" aria-label="default input example" id="nom_culture" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Description : </label>
                                    <input class="form-control" type="text" placeholder="description" aria-label="default input example" id="description" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Rendement Moyen : </label>
                                    <input class="form-control" type="text" placeholder="rendement_moyen" aria-label="default input example" id="rendement_moyen" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Periode Recolte : </label>
                                    <input class="form-control" type="text" placeholder="periode_recolte" aria-label="default input example" id="periode_recolte" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for=""> Irrigation Utilisee : </label>
                                    <input class="form-control" type="text" placeholder="irrigation_utilisee" aria-label="default input example" id="irrigation_utilisee" required>
                                </div>
                                <div class="col-md-6 mb-2" id="addCulture">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary" onclick="addCu()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="editCul" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Culture</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Nom: </label>
                                <input class="form-control" type="text" placeholder="Nom de oasis" aria-label="default input example" id="Editnom_culture" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Description : </label>
                                <input class="form-control" type="text" placeholder="description" aria-label="default input example" id="Editdescription" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Rendement Moyen : </label>
                                <input class="form-control" type="text" placeholder="rendement_moyen" aria-label="default input example" id="Editrendement_moyen" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Periode Recolte : </label>
                                <input class="form-control" type="text" placeholder="periode_recolte" aria-label="default input example" id="Editperiode_recolte" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for=""> Irrigation Utilisee : </label>
                                <input class="form-control" type="text" placeholder="irrigation_utilisee" aria-label="default input example" id="Editirrigation_utilisee" required>
                            </div>
                            <div class="col-md-6 mb-2" id="editOs">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="" id="hiddenDataCU">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="updateCul()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- detail modal -->
    <div class="modal fade" id="detailCU" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Culture</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Nom: </label>
                                <input class="form-control" type="text" placeholder="Nom de oasis" aria-label="default input example" id="Voirnom_culture" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Description : </label>
                                <input class="form-control" type="text" placeholder="description" aria-label="default input example" id="Voirdescription" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Rendement Moyen : </label>
                                <input class="form-control" type="text" placeholder="rendement_moyen" aria-label="default input example" id="Voirrendement_moyen" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Periode Recolte : </label>
                                <input class="form-control" type="text" placeholder="periode_recolte" aria-label="default input example" id="Voirperiode_recolte" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for=""> Irrigation Utilisee : </label>
                                <input class="form-control" type="text" placeholder="irrigation_utilisee" aria-label="default input example" id="Voirirrigation_utilisee" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for=""> Oasis : </label>
                                <input class="form-control" type="text" placeholder="irrigation_utilisee" aria-label="default input example" id="VoirOasis" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <?php

    require_once BLA . '/inc/footer.php';
    ?>
    <script>
        $(document).ready(function() {
            displayDataOS();
        })
        //display culture
        function displayDataOS() {
            var displayDataOS = "true";
            console.log('first');
            $.ajax({
                url: "displayCu.php",
                type: "post",
                data: {
                    displaySend: displayDataOS,
                },
                success: function(data, status) {
                    console.log('two');
                    $('#addCulture').html(data);
                    $('#editOs').html(data);
                }
            })
        }
        //add culture
        function addCu() {
            var nom = $('#nom_culture').val();
            var irrigation_utilisee = $('#irrigation_utilisee').val();
            var periode_recolte = $('#periode_recolte').val();
            var description = $('#description').val();
            var rendement_moyen = $('#rendement_moyen').val();
            var oasis = $('#oasis').val();
            console.log(oasis);
            $.ajax({
                url: "insertCu.php",
                type: "post",
                data: {
                    nom: nom,
                    description: description,
                    rendement_moyen: rendement_moyen,
                    periode_recolte: periode_recolte,
                    irrigation_utilisee: irrigation_utilisee,
                    oasis: oasis
                },
                success: function(data, status) {
                    // displayData();
                    location.reload();
                }
            })
        }
        //details culture
        function editCul(culId) {
            $('#hiddenDataCU').val(culId);
            $('#editCul').modal('show');
            $.post("updateCu.php", {
                culId: culId,
            }, function(data, status) {
                var culID = JSON.parse(data);
                // console.log(culID);
                $('#Editnom_culture').val(culID.nom_culture);
                $('#Editdescription').val(culID.description);
                $('#Editrendement_moyen').val(culID.rendement_moyen);
                $('#Editperiode_recolte').val(culID.periode_recolte);
                $('#Editirrigation_utilisee').val(culID.irrigation_utilisee);
            })
        }
        //Update oasis
        function updateCul() {
            var nom = $('#Editnom_culture').val();
            console.log(nom);
            var irrigation_utilisee = $('#Editirrigation_utilisee').val();
            console.log(irrigation_utilisee);

            var periode_recolte = $('#Editperiode_recolte').val();
            console.log(periode_recolte);

            var description = $('#Editdescription').val();
            console.log(description);

            var rendement_moyen = $('#Editrendement_moyen').val();
            console.log(rendement_moyen);

            var hiddenDataCU = $('#hiddenDataCU').val();
            console.log(hiddenDataCU);

            var oasis = $('#oasis').val();
            console.log(oasis);

            $.post("updateCu.php", {
                hiddenDataCU: hiddenDataCU,
                nom: nom,
                irrigation_utilisee: irrigation_utilisee,
                periode_recolte: periode_recolte,
                description: description,
                rendement_moyen: rendement_moyen,
                oasis: oasis
            }, function(data, status) {
                $('#editCul').modal("hide");
                location.reload();
            })
        }
        //Show oasis
        function detailCul(datailsId) {
            $('#detailCU').modal('show');
            $.post("displayCu.php", {
                datailsId: datailsId,
            }, function(data, status) {
                var culID = JSON.parse(data);
                console.log(culID);
                $('#Voirnom_culture').val(culID.nom_culture);
                $('#Voirdescription').val(culID.description);
                $('#Voirrendement_moyen').val(culID.rendement_moyen);
                $('#Voirperiode_recolte').val(culID.periode_recolte);
                $('#Voirirrigation_utilisee').val(culID.irrigation_utilisee);
                $('#VoirOasis').val(culID.id_oasis);
            })
        }
        //delete oasis
        function deleteCul(deleteId) {
            // console.log(deletID);
            $.ajax({
                url: "deleteCu.php",
                type: 'post',
                data: {
                    deleteSend: deleteId,
                },
                success: function(data, status) {
                    location.reload();
                }
            })
        }
    </script>