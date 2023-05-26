<?php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
$pageName = "Meteo";
require_once '../inc/header.php';

$sql = "SELECT COUNT(*) AS total FROM meteo";
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetch();
$nbVilles = (int)$result->total;
// echo $nbVilles;
$parPage = 2;
//calcule le nombre de pages totale

$pages = ceil($nbVilles / $parPage);
// die($pages);
//calcule du 1er ville de la page
$premier = ($currentPage * $parPage) - $parPage;
$sql = 'SELECT * FROM `meteo` ORDER BY `id_meteo` DESC LIMIT :premier, :parPage; ';
$query = $pdo->prepare($sql);
$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parPage', $parPage, PDO::PARAM_INT);
$query->execute();
$meteo = $query->fetchAll(PDO::FETCH_ASSOC);
require_once '../inc/header.php';
require_once BL . 'functions/messages.php';
?>
<!--Table-->
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-lg-6">
            <h1>Table Meteo</h1>
        </div>
        <div class="col-lg-6 ">
            <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#addM">Ajouter</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" id="showOs">
                <table class="table table-bordered mb-5 text-center">
                    <thead>
                        <tr class="table-primary text-center">
                            <th scope="col">#</th>
                            <th scope="col">temperature_moyenne</th>
                            <th scope="col">humidite_relative</th>
                            <th scope="col">pluviometrie</th>
                            <th scope="col">vitesse_vent</th>
                            <th scope="col">Oasis</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meteo as $item) : ?>
                            <tr class=" text-center">
                                <th scope="row"><?php echo $item['id_meteo']; ?>
                                </th>
                                <td><?php echo $item['temperature_moyenne']; ?></td>
                                <td><?php echo $item['humidite_relative']; ?></td>
                                <td><?php echo $item['pluviometrie']; ?></td>
                                <td><?php echo $item['vitesse_vent']; ?></td>

                                <td><?php echo $item['id_oasis']; ?></td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-primary m-2" onclick="detailRE(<?php echo $item['id_meteo'] ?>)"><i class='bx bx-show'></i></button>
                                    <button class="btn btn-success m-2" onclick="editRE(<?php echo $item['id_meteo'] ?>)"><i class='bx bx-edit'></i></button>
                                    <button class="btn btn-danger m-2" onclick="deleteIN(<?php echo $item['id_meteo'] ?>)"><i class='bx bx-trash'></i></button>
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
    <div class="modal fade" id="addM" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Meteo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Temperature Moyenne : </label>
                                    <input class="form-control" type="number" placeholder="Nom de infra" aria-label="default input example" id="temperature_moyenne" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Humidite Relative : </label>
                                    <input class="form-control" type="number" placeholder="humidite_relative" aria-label="default input example" id="humidite_relative" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Pluviometrie : </label>
                                    <input class="form-control" type="number" placeholder="	pluviometrie" aria-label="default input example" id="pluviometrie" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Vitesse Vent : </label>
                                    <input class="form-control" type="number" placeholder="vitesse_vent" aria-label="default input example" id="vitesse_vent" required>
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
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary" onclick="addMT()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="editRE" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Meteo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Temperature Moyenne: </label>
                                <input class="form-control" type="number" placeholder="temperature_moyenne" aria-label="default input example" id="Edittemperature_moyenne" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Humidite Relative : </label>
                                <input class="form-control" type="number" placeholder="humidite_relative" aria-label="default input example" id="Edithumidite_relative" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Pluviometrie : </label>
                                <input class="form-control" type="number" placeholder="pluviometrie" aria-label="default input example" id="Editpluviometrie" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Vitesse Vent : </label>
                                <input class="form-control" type="number" placeholder="vitesse_vent" aria-label="default input example" id="Editvitesse_vent" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2" id="editMTE">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Meteo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Temperature Moyenne: </label>
                                <input class="form-control" type="text" placeholder="Nom de oasis" aria-label="default input example" id="Voirtemperature_moyenne" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Humidite Relative : </label>
                                <input class="form-control" type="text" placeholder="humidite_relative" aria-label="default input example" id="Voirhumidite_relative" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Pluviometrie : </label>
                                <input class="form-control" type="text" placeholder="	pluviometrie" aria-label="default input example" id="Voirpluviometrie" readonly>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Vitesse Vent : </label>
                                <input class="form-control" type="text" placeholder="vitesse_vent" aria-label="default input example" id="Voirvitesse_vent" readonly>
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
                url: "displayMT.php",
                type: "post",
                data: {
                    displaySend: displayDataOS,
                },
                success: function(data, status) {
                    console.log('two');
                    $('#addREA').html(data);
                    $('#editMTE').html(data);
                }
            })
        }
        //add ResEau
        function addMT() {
            var temperature_moyenne = $('#temperature_moyenne').val();
            var vitesse_vent = $('#vitesse_vent').val();
            var humidite_relative = $('#humidite_relative').val();
            var pluviometrie = $('#pluviometrie').val();
            var oasis = $('#oasis').val();
            console.log(oasis);
            $.ajax({
                url: "insertMT.php",
                type: "post",
                data: {
                    temperature_moyenne: temperature_moyenne,
                    humidite_relative: humidite_relative,
                    pluviometrie: pluviometrie,
                    vitesse_vent: vitesse_vent,
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
            $.post("updateMT.php", {
                culId: culId,
            }, function(data, status) {
                var culID = JSON.parse(data);
                // console.log(culID);
                $('#Edittemperature_moyenne').val(culID.temperature_moyenne);
                $('#Edithumidite_relative').val(culID.humidite_relative);
                $('#Editpluviometrie').val(culID.pluviometrie);
                $('#Editvitesse_vent').val(culID.vitesse_vent);
            })
        }
        //Update ResEau
        function updateRE() {
            var temperature_moyenne = $('#Edittemperature_moyenne').val();
            var vitesse_vent = $('#Editvitesse_vent').val();
            console.log(vitesse_vent);
            var humidite_relative = $('#Edithumidite_relative').val();
            console.log(humidite_relative);
            var pluviometrie = $('#Editpluviometrie').val();
            console.log(pluviometrie);
            var hiddenDataRE = $('#hiddenDataRE').val();
            var oasis = $('#oasis').val();
            console.log(oasis);

            $.post("updateMT.php", {
                hiddenDataRE: hiddenDataRE,
                temperature_moyenne: temperature_moyenne,
                vitesse_vent: vitesse_vent,
                humidite_relative: humidite_relative,
                pluviometrie: pluviometrie,
                oasis: oasis,
            }, function(data, status) {
                // $('#editPR').modal("hide");
                location.reload();
            })
        }
        //Show ResEau
        function detailRE(datailsId) {
            $('#detailRS').modal('show');
            $.post("displayMT.php", {
                datailsId: datailsId,
            }, function(data, status) {
                var culID = JSON.parse(data);
                console.log(culID);
                $('#Voirtemperature_moyenne').val(culID.temperature_moyenne);
                $('#Voirhumidite_relative').val(culID.humidite_relative);
                $('#Voirpluviometrie').val(culID.pluviometrie);
                $('#Voirvitesse_vent').val(culID.vitesse_vent);
                $('#VoirOasis').val(culID.id_oasis);
            })
        }
        //delete ResEau
        function deleteIN(deleteId) {
            // console.log(deletID);
            $.ajax({
                url: "deleteMT.php",
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