<?php
include_once 'connection.php';

$connection = connection();

function showProduct($connection){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $code = $_POST['code'];

        $sql_info = "SELECT * FROM vw_info_Prod where codProd = ?";
        $resultado = $connection->prepare($sql_info);
        $resultado->execute([$code]);
        $result = $resultado->get_result();
        if( $data = $result->fetch_object()){
            echo json_encode([
                'idProd'=>$data->codProd,
                'editProdName' => $data->tradeMark,
                'editChemName' => $data->chemicalName,
                'editProdType' => $data->typeProduct,
                'idType' => $data->typeProductCode,
                'measure' => $data->measure

            ]);
        }else{
            echo json_encode(["error" => "No data found"]);
        }



    }else {
        echo json_encode(["error" => "Database connection failed"]);
    }
}

showProduct($connection);

?>
