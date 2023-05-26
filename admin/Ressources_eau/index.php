<?php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
$pageName = "Ressources Eau";
require_once '../inc/header.php';

$sql = "SELECT COUNT(*) AS total FROM ressources_eau";
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetch();
$nbVilles = (int)$result->total;
// echo $nbVilles;
$parPage = 1;
//calcule le nombre de pages totale

$pages = ceil($nbVilles / $parPage);
// die($pages);
//calcule du 1er ville de la page
$premier = ($currentPage * $parPage) - $parPage;
$sql = 'SELECT * FROM `ressources_eau` ORDER BY `id_ressource_eau` DESC LIMIT :premier, :parPage; ';
$query = $pdo->prepare($sql);
$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parPage', $parPage, PDO::PARAM_INT);
$query->execute();
$ressources_eau = $query->fetchAll(PDO::FETCH_ASSOC);
require_once '../inc/header.php';
require_once BL . 'functions/messages.php';
?>
<!--Table-->
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-lg-6">
            <h1>Table Ressources Eau</h1>
        </div>
        <div class="col-lg-6 ">
            <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#addRE">Ajouter</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" id="showOs">
                <table class="table table-bordered mb-5 text-center">
                    <thead>
                        <tr class="table-primary text-center">
                            <th scope="col">#</th>
                            <th scope="col">source_eau</th>
                            <th scope="col">qualite_eau</th>
                            <th scope="col">quantite_eau</th>
                            <th scope="col">utilisation_eau</th>
                            <th scope="col">Oasis</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ressources_eau as $item) : ?>
                            <tr class=" text-center">
                                <th scope="row"><?php echo $item['id_ressource_eau']; ?>
                                </th>
                                <td><?php echo $item['source_eau']; ?></td>
                                <td><?php echo $item['qualite_eau']; ?></td>
                                <td><?php echo $item['quantite_eau']; ?></td>
                                <td><?php echo $item['utilisation_eau']; ?></td>

                                <td><?php echo $item['id_oasis']; ?></td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-primary m-2" onclick="detailRE(<?php echo $item['id_ressource_eau'] ?>)"><i class='bx bx-show'></i></button>
                                    <button class="btn btn-success m-2" onclick="editRE(<?php echo $item['id_ressource_eau'] ?>)"><i class='bx bx-edit'></i></button>
                                    <button class="btn btn-danger m-2" onclick="deleteIN(<?php echo $item['id_ressource_eau'] ?>)"><i class='bx bx-trash'></i></button>
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
    <div class="modal fade" id="addRE" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Ressources Eau</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Source Eau : </label>
                                    <input class="form-control" type="text" placeholder="Nom de infra" aria-label="default input example" id="source_eau" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Qualite Eau : </label>
                                    <input class="form-control" type="text" placeholder="qualite_eau" aria-label="default input example" id="qualite_eau" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Quantite Eau : </label>
                                    <input class="form-control" type="number" placeholder="	quantite_eau" aria-label="default input example" id="quantite_eau" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Utilisation Eau : </label>
                                    <input class="form-control" type="text" placeholder="utilisation_eau" aria-label="default input example" id="utilisation_eau" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2" id="addREA">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary" onclick="addRE()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="editRE" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Ressources Eau</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Source Eau: </label>
                                <input class="form-control" type="text" placeholder="source_eau" aria-label="default input example" id="Editsource_eau" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">qualite_eau : </label>
                                <input class="form-control" type="text" placeholder="qualite_eau" aria-label="default input example" id="Editqualite_eau" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Quantite Eau : </label>
                                <input class="form-control" type="text" placeholder="	quantite_eau" aria-label="default input example" id="Editquantite_eau" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">utilisation_eau : </label>
                                <input class="form-control" type="text" placeholder="utilisation_eau" aria-label="default input example" id="Editutilisation_eau" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2" id="editRSE">
                        </div>
                    </div>
                    <input type="hidden" name="" id="hiddenDataRE">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="updateRE()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- detail modal -->
    <div class="modal fade" id="detailRS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Produit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Nom: </label>
                                <input class="form-control" type="text" placeholder="Nom de oasis" aria-label="default input example" id="Voirsource_eau" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">qualite_eau : </label>
                                <input class="form-control" type="text" placeholder="qualite_eau" aria-label="default input example" id="Voirqualite_eau" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Rendement Moyen : </label>
                                <input class="form-control" type="text" placeholder="	quantite_eau" aria-label="default input example" id="Voir	quantite_eau" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Periode Recolte : </label>
                                <input class="form-control" type="text" placeholder="utilisation_eau" aria-label="default input example" id="Voirutilisation_eau" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for=""> Irrigation Utilisee : </label>
                                <input class="form-control" type="text" placeholder="Voircapacite" aria-label="default input example" id="Voircapacite" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for=""> Date Construction : </label>
                                <input class="form-control" type="date" placeholder="irrigation_utilisee" aria-label="default input example" id="Voirdate_construction" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2 ">
                            <label for=""> Oasis : </label>
                            <input class="form-control" type="text" placeholder="irrigation_utilisee" aria-label="default input example" id="VoirOasis" readonly>
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
        //display ResEau
        function displayDataOS() {
            var displayDataOS = "true";
            $.ajax({
                url: "displayRE.php",
                type: "post",
                data: {
                    displaySend: displayDataOS,
                },
                success: function(data, status) {
                    console.log('two');
                    $('#addREA').html(data);
                    $('#editRSE').html(data);
                }
            })
        }
        //add ResEau
        function addRE() {
            var source_eau = $('#source_eau').val();
            var utilisation_eau = $('#utilisation_eau').val();
            var qualite_eau = $('#qualite_eau').val();
            var quantite_eau = $('#quantite_eau').val();
            var oasis = $('#oasis').val();
            console.log(oasis);
            $.ajax({
                url: "insertRE.php",
                type: "post",
                data: {
                    source_eau: source_eau,
                    qualite_eau: qualite_eau,
                    quantite_eau: quantite_eau,
                    utilisation_eau: utilisation_eau,
                    oasis: oasis,
                },
                success: function(data, status) {
                    location.reload();
                }
            })
        }
        //details ResEau
        function editRE(culId) {
            $('#hiddenDataRE').val(culId);
            $('#editRE').modal('show');
            $.post("updateRE.php", {
                culId: culId,
            }, function(data, status) {
                var culID = JSON.parse(data);
                // console.log(culID);
                $('#Editsource_eau').val(culID.source_eau);
                $('#Editqualite_eau').val(culID.qualite_eau);
                $('#Editquantite_eau').val(culID.quantite_eau);
                $('#Editutilisation_eau').val(culID.utilisation_eau);
            })
        }
        //Update ResEau
        function updateRE() {
            var source_eau = $('#Editsource_eau').val();
            var utilisation_eau = $('#Editutilisation_eau').val();
            console.log(utilisation_eau);
            var qualite_eau = $('#Editqualite_eau').val();
            console.log(qualite_eau);
            var quantite_eau = $('#Editquantite_eau').val();
            console.log(quantite_eau);
            var hiddenDataRE = $('#hiddenDataRE').val();
            var oasis = $('#oasis').val();
            console.log(oasis);

            $.post("updateRE.php", {
                hiddenDataRE: hiddenDataRE,
                source_eau: source_eau,
                utilisation_eau: utilisation_eau,
                qualite_eau: qualite_eau,
                quantite_eau: quantite_eau,
                oasis: oasis,
            }, function(data, status) {
                // $('#editPR').modal("hide");
                location.reload();
            })
        }
        //Show ResEau
        function detailRE(datailsId) {
            $('#detailRS').modal('show');
            $.post("displayRE.php", {
                datailsId: datailsId,
            }, function(data, status) {
                var culID = JSON.parse(data);
                console.log(culID);
                $('#Voirsource_eau').val(culID.source_eau);
                $('#Voirqualite_eau').val(culID.qualite_eau);
                $('#Voirquantite_eau').val(culID.quantite_eau);
                $('#Voirutilisation_eau').val(culID.utilisation_eau);
                $('#VoirOasis').val(culID.id_oasis);
            })
        }
        //delete ResEau
        function deleteIN(deleteId) {
            // console.log(deletID);
            $.ajax({
                url: "deleteRE.php",
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