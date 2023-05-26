<?php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
$pageName = "infrastructure";
require_once '../inc/header.php';

$sql = "SELECT COUNT(*) AS total FROM infrastructure";
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetch();
$nbVilles = (int)$result->total;
// echo $nbVilles;
$parPage = 4;
//calcule le nombre de pages totale

$pages = ceil($nbVilles / $parPage);
// die($pages);
//calcule du 1er ville de la page
$premier = ($currentPage * $parPage) - $parPage;
$sql = 'SELECT * FROM `infrastructure` ORDER BY `id_infra` DESC LIMIT :premier, :parPage; ';
$query = $pdo->prepare($sql);
$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parPage', $parPage, PDO::PARAM_INT);
$query->execute();
$infrastructures = $query->fetchAll(PDO::FETCH_ASSOC);
require_once '../inc/header.php';
require_once BL . 'functions/messages.php';
?>
<!--Table-->
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-lg-6">
            <h1>Table Infrastructure</h1>
        </div>
        <div class="col-lg-6 ">
            <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#addIN">Ajouter</button>
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
                            <th scope="col">Type Infra</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Capacité</th>
                            <th scope="col">Date Construction</th>
                            <th scope="col">Oasis</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($infrastructures as $item) : ?>
                            <tr class=" text-center">
                                <th scope="row"><?php echo $item['id_infra']; ?>
                                </th>
                                <td><?php echo $item['nom_infra']; ?></td>
                                <td><?php echo $item['description']; ?></td>
                                <td><?php echo $item['type_infra']; ?></td>
                                <td><?php echo $item['etat']; ?></td>
                                <td><?php echo $item['capacite']; ?></td>
                                <td><?php echo $item['date_construction']; ?></td>
                                <td><?php echo $item['id_oasis']; ?></td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-primary m-2" onclick="detailIN(<?php echo $item['id_infra'] ?>)"><i class='bx bx-show'></i></button>
                                    <button class="btn btn-success m-2" onclick="editIN(<?php echo $item['id_infra'] ?>)"><i class='bx bx-edit'></i></button>
                                    <button class="btn btn-danger m-2" onclick="deleteIN(<?php echo $item['id_infra'] ?>)"><i class='bx bx-trash'></i></button>
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
    <div class="modal fade" id="addIN" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Infrastructure</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Nom : </label>
                                    <input class="form-control" type="text" placeholder="Nom de infra" aria-label="default input example" id="nom_infra" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Description : </label>
                                    <input class="form-control" type="text" placeholder="description" aria-label="default input example" id="description" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for=""> Type Infra : </label>
                                    <input class="form-control" type="text" placeholder="type_infra" aria-label="default input example" id="type_infra" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Etat : </label>
                                    <input class="form-control" type="text" placeholder="etat" aria-label="default input example" id="etat" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for=""> capacite : </label>
                                    <input class="form-control" type="number" placeholder="capacite" aria-label="default input example" id="capacite" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for=""> Date Construction : </label>
                                    <input class="form-control" type="date" placeholder="date_construction" aria-label="default input example" id="date_construction" required>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2" id="addProduit">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary" onclick="addIN()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="editIN" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Infrastructure</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Nom: </label>
                                <input class="form-control" type="text" placeholder="Nom de produit" aria-label="default input example" id="Editnom_infra" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Description : </label>
                                <input class="form-control" type="text" placeholder="description" aria-label="default input example" id="Editdescription" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Type Infra : </label>
                                <input class="form-control" type="text" placeholder="type_infra" aria-label="default input example" id="Edittype_infra" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Etat : </label>
                                <input class="form-control" type="text" placeholder="etat" aria-label="default input example" id="Editetat" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for=""> Capacite : </label>
                                <input class="form-control" type="number" placeholder="irrigation_utilisee" aria-label="default input example" id="Editcapacite" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for=""> Date Construction : </label>
                                <input class="form-control" type="date" aria-label="default input example" id="Editdate_construction" required>
                            </div>

                        </div>
                        <div class="col-md-6 mb-2" id="editOs">
                        </div>
                    </div>
                    <input type="hidden" name="" id="hiddenDataIN">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="updateIN()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- detail modal -->
    <div class="modal fade" id="detailIN" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <input class="form-control" type="text" placeholder="Nom de oasis" aria-label="default input example" id="Voirnom_infra" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Description : </label>
                                <input class="form-control" type="text" placeholder="description" aria-label="default input example" id="Voirdescription" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Rendement Moyen : </label>
                                <input class="form-control" type="text" placeholder="type_infra" aria-label="default input example" id="Voirtype_infra" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Periode Recolte : </label>
                                <input class="form-control" type="text" placeholder="etat" aria-label="default input example" id="Voiretat" readonly>
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
        //display infra
        function displayDataOS() {
            var displayDataOS = "true";
            console.log('first');
            $.ajax({
                url: "displayIN.php",
                type: "post",
                data: {
                    displaySend: displayDataOS,
                },
                success: function(data, status) {
                    console.log('two');
                    $('INoduit').html(data);
                    $('#editOs').html(data);
                }
            })
        }
        //add infra
        function addIN() {
            var nom = $('#nom_infra').val();
            var date_construction = $('#date_construction').val();
            var etat = $('#etat').val();
            var description = $('#description').val();
            var type_infra = $('#type_infra').val();
            var capacite = $('#capacite').val();
            var oasis = $('#oasis').val();
            console.log(oasis);
            $.ajax({
                url: "insertIn.php",
                type: "post",
                data: {
                    nom: nom,
                    description: description,
                    type_infra: type_infra,
                    etat: etat,
                    date_construction: date_construction,
                    oasis: oasis,
                    capacite: capacite
                },
                success: function(data, status) {
                    location.reload();
                }
            })
        }
        //details infra
        function editIN(culId) {
            $('#hiddenDataIN').val(culId);
            $('#editIN').modal('show');
            $.post("updateIN.php", {
                culId: culId,
            }, function(data, status) {
                var culID = JSON.parse(data);
                // console.log(culID);
                $('#Editnom_infra').val(culID.nom_infra);
                $('#Editdescription').val(culID.description);
                $('#Edittype_infra').val(culID.type_infra);
                $('#Editetat').val(culID.etat);
                $('#Editcapacite').val(culID.capacite);
                $('#Editdate_construction').val(culID.date_construction);
            })
        }
        //Update infra
        function updateIN() {
            var nom = $('#Editnom_infra').val();
            console.log(nom);
            var capacite = $('#Editcapacite').val();
            console.log(capacite);

            var etat = $('#Editetat').val();
            console.log(etat);

            var description = $('#Editdescription').val();
            console.log(description);

            var type_infra = $('#Edittype_infra').val();
            console.log(type_infra);

            var hiddenDataIN = $('#hiddenDataIN').val();

            var oasis = $('#oasis').val();
            console.log(oasis);
            var date_construction = $('#Editdate_construction').val();
            console.log(date_construction);

            $.post("updateIN.php", {
                hiddenDataIN: hiddenDataIN,
                nom: nom,
                capacite: capacite,
                etat: etat,
                description: description,
                type_infra: type_infra,
                oasis: oasis,
                date_construction: date_construction
            }, function(data, status) {
                // $('#editPR').modal("hide");
                location.reload();
            })
        }
        //Show infra
        function detailIN(datailsId) {
            $('#detailIN').modal('show');
            $.post("displayIN.php", {
                datailsId: datailsId,
            }, function(data, status) {
                var culID = JSON.parse(data);
                console.log(culID);
                $('#Voirnom_infra').val(culID.nom_infra);
                $('#Voirdescription').val(culID.description);
                $('#Voirtype_infra').val(culID.type_infra);
                $('#Voiretat').val(culID.etat);
                $('#Voircapacite').val(culID.capacite);
                $('#Voirdate_construction').val(culID.date_construction);

                $('#VoirOasis').val(culID.id_oasis);
            })
        }
        //delete infra
        function deleteIN(deleteId) {
            // console.log(deletID);
            $.ajax({
                url: "deleteIN.php",
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