<?php
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
$pageName = "oasis";
require_once '../inc/header.php';

$sql = "SELECT COUNT(*) AS total FROM oasis";
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
$sql = 'SELECT * FROM `oasis` ORDER BY `id_oasis` DESC LIMIT :premier, :parPage; ';
$query = $pdo->prepare($sql);
$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parPage', $parPage, PDO::PARAM_INT);
$query->execute();
$oasis = $query->fetchAll(PDO::FETCH_ASSOC);
require_once '../inc/header.php';
require_once BL . 'functions/messages.php';
?>
<!--Table-->
<div class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-lg-6">
            <h1>Table Oasis</h1>
        </div>
        <div class="col-lg-6 ">
            <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#addOS">Ajouter</button>
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
                            <th scope="col">Latitude</th>
                            <th scope="col">Longitude</th>
                            <th scope="col">Superficie</th>
                            <th scope="col">Population</th>
                            <th scope="col">Altitude</th>
                            <th scope="col">Acces Eau</th>
                            <th scope="col">Type Oasis</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($oasis as $item) : ?>
                            <tr class=" text-center">
                                <th scope="row"><?php echo $item['id_oasis']; ?>
                                </th>
                                <td><?php echo $item['nom_oasis']; ?></td>
                                <td><?php echo $item['latitude']; ?></td>
                                <td><?php echo $item['longitude']; ?></td>
                                <td><?php echo $item['superficie']; ?></td>
                                <td><?php echo $item['population']; ?></td>
                                <td><?php echo $item['altitude']; ?></td>
                                <td><?php echo $item['acces_eau']; ?></td>
                                <td><?php echo $item['type_oasis']; ?> </td>
                                <td>Tozeur</td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-primary m-2" onclick="detailOasis(<?php echo $item['id_oasis'] ?>)"><i class='bx bx-show'></i></button>
                                    <button class="btn btn-success m-2" onclick="editOasis(<?php echo $item['id_oasis'] ?>)"><i class='bx bx-edit'></i></button>
                                    <button class="btn btn-danger m-2" onclick="deleteOasis(<?php echo $item['id_oasis'] ?>)"><i class='bx bx-trash'></i></button>
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
    <div class="modal fade" id="addOS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Oasis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Nom: </label>
                                    <input class="form-control" type="text" placeholder="Nom de oasis" aria-label="default input example" id="nomOS" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Latitude : </label>
                                    <input class="form-control" type="number" placeholder="Latitude" aria-label="default input example" id="latOS" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Longitude : </label>
                                    <input class="form-control" type="number" placeholder="Longitude" aria-label="default input example" id="longOS" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Superficie : </label>
                                    <input class="form-control" type="number" placeholder="Superficie" aria-label="default input example" id="supOS" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Altitude : </label>
                                    <input class="form-control" type="number" placeholder="Altitude" aria-label="default input example" id="altOS" required>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Acces Eau : </label>
                                    <input class="form-control" type="text" placeholder="Acces Eau" aria-label="default input example" id="eauOS" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Type Oasis : </label>
                                    <input class="form-control" type="text" placeholder="Type Oasis" aria-label="default input example" id="typOS" required>
                                </div>
                                <div class="col-md-6 mb-2" id="addville">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Population : </label>
                                    <input class="form-control" type="number" placeholder="Population" aria-label="default input example" id="popOS" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-primary" onclick="addOS()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- edit modal -->
    <div class="modal fade" id="editOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Oasis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Nom: </label>
                                <input class="form-control" type="text" placeholder="Nom de oasis" aria-label="default input example" id="EditnomOS" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Latitude : </label>
                                <input class="form-control" type="number" placeholder="Latitude" aria-label="default input example" id="EditlatOS" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Longitude : </label>
                                <input class="form-control" type="number" placeholder="Longitude" aria-label="default input example" id="EditlongOS" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Superficie : </label>
                                <input class="form-control" type="number" placeholder="Superficie" aria-label="default input example" id="EditsupOS" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Altitude : </label>
                                <input class="form-control" type="number" placeholder="Altitude" aria-label="default input example" id="EditaltOS" required>
                            </div>
                            <div class="col-md-6 mb-2 ">
                                <label for="">Acces Eau : </label>
                                <input class="form-control" type="text" placeholder="Acces Eau" aria-label="default input example" id="EditeauOS" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Type Oasis : </label>
                                <input class="form-control" type="text" placeholder="Type Oasis" aria-label="default input example" id="EdittypOS" required>
                            </div>
                            <div class="col-md-6 mb-2" id="editVille">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2 ">
                                <label for="">Population : </label>
                                <input class="form-control" type="number" placeholder="Population" aria-label="default input example" id="EditpopOS" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="" id="hiddenDataOS">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="updateOasis()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- detail modal -->
    <div class="modal fade" id="detailOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Oasis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Nom: </label>
                                    <input class="form-control" type="text" aria-label="default input example" id="VoirnomOS" readonly>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Latitude : </label>
                                    <input class="form-control" type="number" aria-label="default input example" id="VoirlatOS" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Longitude : </label>
                                    <input class="form-control" type="number" aria-label="default input example" id="VoirlongOS" readonly>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Superficie : </label>
                                    <input class="form-control" type="number" aria-label="default input example" id="VoirsupOS" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Altitude : </label>
                                    <input class="form-control" type="number" aria-label="default input example" id="VoiraltOS" readonly>
                                </div>
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Acces Eau : </label>
                                    <input class="form-control" type="text" aria-label="default input example" id="VoireauOS" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Type Oasis : </label>
                                    <input class="form-control" type="text" aria-label="default input example" id="VoirtypOS" readonly>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="">Ville : </label>
                                    <input class="form-control" aria-label="default input example" id="Voirville" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2 ">
                                    <label for="">Population : </label>
                                    <input class="form-control" aria-label="default input example" id="VoirpopOS" readonly>
                                </div>
                            </div>
                            <input type="hidden" name="" id="VoiId">
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
        //display oasis
        function displayDataOS() {
            var displayDataOS = "true";
            console.log('first');
            $.ajax({
                url: "displayOS.php",
                type: "post",
                data: {
                    displaySend: displayDataOS,
                },
                success: function(data, status) {
                    console.log('two');
                    $('#addville').html(data);
                    $('#editVille').html(data);

                }
            })
        }
        //add oasis
        function addOS() {
            var nom = $('#nomOS').val();
            var ville = $('#ville').val();
            var type_oasis = $('#typOS').val();
            var acces_eau = $('#eauOS').val();
            var alltitude = $('#altOS').val();
            var population = $('#popOS').val();
            var superficie = $('#supOS').val();
            var latitude = $('#latOS').val();
            var longitude = $('#longOS').val();
            $.ajax({
                url: "insertOs.php",
                type: "post",
                data: {
                    nom: nom,
                    latitude: latitude,
                    longitude: longitude,
                    superficie: superficie,
                    population: population,
                    alltitude: alltitude,
                    acces_eau: acces_eau,
                    type_oasis: type_oasis,
                    ville: ville,
                },
                success: function(data, status) {
                    // displayData();
                    location.reload();
                }
            })
        }
        //details oasis
        function editOasis(oasisId) {
            $('#hiddenDataOS').val(oasisId);
            $('#editOs').modal('show');
            $.post("updateOS.php", {
                oasisId: oasisId,
            }, function(data, status) {
                var oasisId = JSON.parse(data);
                console.log(oasisId);
                $('#EditnomOS').val(oasisId.nom_oasis);
                $('#EditlatOS').val(oasisId.latitude);
                $('#EditlongOS').val(oasisId.longitude);
                $('#EditsupOS').val(oasisId.superficie);
                $('#EditaltOS').val(oasisId.altitude);
                $('#EditeauOS').val(oasisId.acces_eau);
                $('#EdittypOS').val(oasisId.type_oasis);
                $('#EditpopOS').val(oasisId.population);
                $('#EditpopOS').val(oasisId.population);

            })
        }
        //Update oasis
        function updateOasis() {
            var nom = $('#EditnomOS').val();
            var ville = $('#ville').val();
            console.log(ville);
            var type_oasis = $('#EdittypOS').val();
            var acces_eau = $('#EditeauOS').val();
            var alltitude = $('#EditaltOS').val();
            var population = $('#EditpopOS').val();
            var superficie = $('#EditsupOS').val();
            var latitude = $('#EditlatOS').val();
            var longitude = $('#EditsupOS').val();
            var hiddenDataOS = $('#hiddenDataOS').val();
            $.post("updateOS.php", {
                hiddenDataOS: hiddenDataOS,
                nom: nom,
                ville: ville,
                type_oasis: type_oasis,
                acces_eau: acces_eau,
                alltitude: alltitude,
                population: population,
                superficie: superficie,
                latitude: latitude,
                longitude: longitude,
            }, function(data, status) {
                $('#editVi').modal("hide");
                location.reload();
            })
        }
        //Show oasis
        function detailOasis(datailsId) {
            $('#detailOs').modal('show');
            $('#VoiId').val(datailsId);
            $.post("displayOS.php", {
                datailsId: datailsId,
            }, function(data, status) {
                var oasisId = JSON.parse(data);
                console.log(oasisId);
                $('#VoirnomOS').val(oasisId.nom_oasis);
                $('#VoirlatOS').val(oasisId.latitude);
                $('#VoirlongOS').val(oasisId.longitude);
                $('#VoirsupOS').val(oasisId.superficie);
                $('#VoiraltOS').val(oasisId.altitude);
                $('#VoireauOS').val(oasisId.acces_eau);
                $('#VoirtypOS').val(oasisId.type_oasis);
                $('#VoirpopOS').val(oasisId.population);
                $('#VoirpopOS').val(oasisId.population);
                $('#Voirville').val(oasisId.id_ville);

            })
            $('#voirVi').modal("show");
        }
        //delete oasis
        function deleteOasis(deleteId) {
            // console.log(deletID);
            $.ajax({
                url: "deleteOs.php",
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