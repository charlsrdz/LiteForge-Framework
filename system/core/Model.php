<?php
namespace LiteForge\Core;

class Model
{
    protected $db;

    public function __construct()
    {
        // Aquí debes inicializar la conexión con la base de datos
        $this->db = \LiteForge\Core\Database::getInstance();
    }

    // Método para obtener todos los registros de una tabla
    public function getAll($table)
    {
        return $this->db->query("SELECT * FROM {$table}")->fetchAll();
    }

    // Método para obtener un solo registro basado en un ID
    public function getById($table, $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Método para insertar datos en la base de datos
    public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    // Método para actualizar registros
    public function update($table, $data, $id)
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "{$key} = :{$key}, ";
        }
        $set = rtrim($set, ", ");

        $sql = "UPDATE {$table} SET {$set} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Método para eliminar un registro
    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
?>
