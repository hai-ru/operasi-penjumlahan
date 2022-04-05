<?php

class Operasi {

    public function tambah($a,$b)
    {
        return $a + $b;
    }
    public function kurang($a,$b)
    {
        return $a - $b;
    }
    public function kali($a,$b)
    {
        return $a * $b;
    }
    public function bagi($a,$b)
    {
        if($b === 0) return $b;
        return $a / $b;
    }
}

header('Content-type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

try {

    $result = [
        "status"=>false,
        "message"=>"ERROR",
        "code"=>500,
    ];

    if(!isset($data["a"]) && !isset($data["b"]) && !isset($data["operasi"])){
        $result["message"] = "BAD REQUEST";
        $result["code"] = 403;
        echo json_encode($result);
        exit;
    }

    $operasi = new Operasi;

    $a = intval($data["a"]);
    $b = intval($data["b"]);

    $hasil = 0;

    switch ($data["operasi"]) {
        case 'bagi':
            $hasil = $operasi->bagi($a,$b);
            break;
        case 'kurang':
            $hasil = $operasi->kurang($a,$b);
            break;
        case 'kali':
            $hasil = $operasi->kali($a,$b);
            break;
        
        default:
            $hasil = $operasi->tambah($a,$b);
            break;
    }

    $result["status"] = true;
    $result["message"] = "OK";
    $result["code"] = 200;
    $result["data"] = $hasil;

    echo json_encode($result);

} catch (Exception $e) {
    echo json_encode([
        "status"=>false,
        "message"=>"ERROR",
        "code"=>500,
        "data"=>$e->getMessage()
    ]);
}

?>