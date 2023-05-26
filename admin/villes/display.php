<?php
require_once '../../config.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
if (isset($_POST['datailsId'])) {
    $id = $_POST['datailsId'];
    $sql = "SELECT * FROM `villes` where `id_ville`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $vill) {
        $response = $vill;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}



































// if (isset($_POST['displaySend'])) {

//     // if (isset($_GET['page']) && !empty($_GET['page'])) {
//     //     $currentPage = (int) strip_tags($_GET['page']);
//     //     var_dump($currentPage);
//     // } else {
//     //     $currentPage = 0;
//     //     var_dump($currentPage);
//     // }
//     // $kar = $_SERVER['REQUEST_URI'];
//     // var_dump($kar);
//     // //result per page
//     // // $resultPErPage = 4;

//     // $sql = 'SELECT * FROM `villes`';
//     // $query = $pdo->prepare($sql);
//     // $query->execute();
//     // $villes = $query->fetchAll(PDO::FETCH_ASSOC);
//     // $nbVille = $query->rowCount();
//     // var_dump($villes);
//     //page number

//     // //number of all pages
//     // $totalPages = ceil($nbVille / $resultPErPage);
//     // // // var_dump($totalPages);
//     // for ($count = 1; $count <= $totalPages; ++$count) {
//     //     if ($page == $count) {
//     //         echo '<a style="color:black" href="index.php?page=' . $count . '"> ' . $count . '</a>';
//     //     } else {
//     //         echo '<a style="color:blue" href="index.php?page=' . $count . '"> ' . $count . '</a>';
//     //     }
//     // }
//     // $sql = "SELECT * FROM `villes` LIMIT 1,4";
//     // $results = $pdo->prepare($sql);
//     // $results->execute();

//     // $table = '<table class="table table-bordered mb-5 text-center">
//     //     <thead>
//     //         <tr class="table-primary">
//     //             <th scope="col">#</th>
//     //             <th scope="col">Nom</th>
//     //             <th scope="col">Code Postal</th>
//     //             <th scope="col">Actions</th>
//     //         </tr>
//     //     </thead>';
//     // foreach ($results as $key => $vill) {
//     // $id = $vill->id_ville;
//     // $num = $key + 1;
//     // $nom = $vill->nom_ville;
//     // $codePostal = $vill->code_postal;

//     //     // echo $id;
//     //     $table .= '
//     // <tbody>
//     //     <tr>
//     //         <th scope="row">' . $num . '</th>
//     //         <td>' . $nom . '</td>
//     //         <td>' . $codePostal . '</td>
//     //         <td class="d-flex justify-content-center">
//     //             <button class="btn btn-primary m-2 voir" title="Voir detail">
//     //                 <i class="bx bx-show"></i>
//     //             </button>
//     //             <button class="btn btn-success m-2 edit" onclick="detailsVill(' . $id . ')" title="Modifier"><i class="bx bx-edit"></i></button>
//     //             <button class="btn btn-danger m-2 " title="supprimer" onclick="deleteVill(' . $id . ')"><i class="bx bx-trash"></i></button>

//     //         </td>
//     //     </tr>
//     // </tbody>';
//     // }
//     // $table .= '
//     // </table>';
//     // echo $table;




//     //Chat
//     // $sql = "SELECT COUNT(*) AS total FROM villes";
//     // $stmt = $pdo->query($sql);
//     // $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     // $totalRecords = $result['total'];
//     // $recordsPerPage = 5;
//     // $totalPages = ceil($totalRecords / $recordsPerPage);
//     // die($totalPages);

//     // $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
//     // $offset = ($currentPage - 1) * $recordsPerPage;
//     // $sql = "SELECT * FROM villes LIMIT :offset, :limit";
//     // $stmt = $pdo->prepare($sql);
//     // $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
//     // $stmt->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
//     // $stmt->execute();
//     // $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     //endChat





//     // var_dump($data);
//     // $table = '<table class="table table-bordered mb-5 text-center">
//     //     <thead>
//     //         <tr class="table-primary">
//     //             <th scope="col">#</th>
//     //             <th scope="col">Nom</th>
//     //             <th scope="col">Code Postal</th>
//     //             <th scope="col">Actions</th>
//     //         </tr>
//     //     </thead>';
//     // foreach ($villes as $key => $vill) {
//     //     $id = $vill['id_ville'];
//     //     $num = $key + 1;
//     //     $nom = $vill['nom_ville'];
//     //     $codePostal = $vill['code_postal'];

//     //     // echo $id;
//     //     $table .= '
//     //     <tbody>
//     //         <tr>
//     //             <th scope="row">' . $num . '</th>
//     //             <td>' . $nom . '</td>
//     //             <td>' . $codePostal . '</td>
//     //             <td class="d-flex justify-content-center">
//     //                 <button class="btn btn-primary m-2 voir" title="Voir detail">
//     //                     <i class="bx bx-show"></i>
//     //                 </button>
//     //                 <button class="btn btn-success m-2 edit" onclick="detailsVill(' . $id . ')" title="Modifier"><i class="bx bx-edit"></i></button>
//     //                 <button class="btn btn-danger m-2 " title="supprimer" onclick="deleteVill(' . $id . ')"><i class="bx bx-trash"></i></button>

//     //             </td>
//     //         </tr>
//     //     </tbody>';
//     // }
//     // $table .= '
//     // </table>';
//     // echo $table;
//     // for ($i = 1; $i <= $totalPages; $i++) {
//     //     $activeClass = ($i == $currentPage) ? 'active' : '';
//     //     echo "<a href='index.php?page=$i' class='$activeClass'>$i</a>";
//     // }
// }
