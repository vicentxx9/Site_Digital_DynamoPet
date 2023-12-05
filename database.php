<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "pet_cadastro";

// Cria a conexão
$conn = mysqli_connect($servername, $username, $password, $database);

// Função para inserir um novo pet
function insert_pet($conn, $name, $species, $age, $gender) {
    $query = "INSERT INTO pets (name, species, age, gender) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $species, $age, $gender);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return mysqli_insert_id($conn);
}

if ($conn === false) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

// Prepara a consulta
$query = "SELECT * FROM users";
$stmt = mysqli_prepare($conn, $query);

// Verifica se a consulta foi preparada corretamente
if ($stmt === false) {
    die("Erro ao preparar a consulta: " . mysqli_error($conn));
}

// Função para listar todos os pets
function list_pets($conn) {
    $query = "SELECT * FROM pets";
    $results = mysqli_query($conn, $query);

    $pets = array();
    while ($row = mysqli_fetch_assoc($results)) {
        $pets[] = $row;
    }

    return $pets;
}

// Função para obter um pet pelo ID
function get_pet_by_id($conn, $id) {
    $query = "SELECT * FROM pets WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc($id);

    return $row;
}

// Função para atualizar um pet
function update_pet($conn, $id, $name, $species, $age, $gender) {
    $query = "UPDATE pets SET name = ?, species = ?, age = ?, gender = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $species, $age, $gender, $id);
    mysqli_stmt_execute($stmt);

    return mysqli_affected_rows($conn);
}

// Função para excluir um pet
function delete_pet($conn, $id) {
    $query = "DELETE FROM pets WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    return mysqli_affected_rows($conn);
}

?>