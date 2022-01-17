<?php

namespace Models;

class ProductsModel extends \Core\Model
{
  public int $id;
  public string $name;
  public string $price;
  public string $status;
  public string $photo;
  public float $amount;
  public string $created_at;
  public string $updated_at;
  private $db = null;
  public function __construct($db)
  {
    $this->db = $db;
  }
  public static function getAll(): array
  {
    return static::getDB()->query("SELECT * FROM products")->fetchAll(\PDO::FETCH_ASSOC);
  }
  public static function create(array $data)
  {
    $database = static::getDB();
    $statement = $database->prepare("INSERT INTO products (name, price, status, amount, photo, created_at, updated_at) VALUES (:name, :price, :status, :amount, :photo, now(), now())");
    try {
      $statement->execute([
        ':name' => $data['name'],
        ':price' => $data['price'],
        ':status' => $data['status'],
        ':amount' => $data['amount'],
        ':photo' => $data['photo']
      ]);
    } catch (\PDOException $e) {
      echo "Creation failed: " . $e->getMessage();
    }
    return $database->query("SELECT * FROM products WHERE name='" . $data['name'] . "'")->fetchAll(\PDO::FETCH_ASSOC);
  }
  public static function find(int $id)
  {
    return static::getDB()->query("SELECT * FROM products WHERE id=$id")->fetchAll(\PDO::FETCH_ASSOC);
  }
  public static function update(array $data, int $id)
  {
    $database = static::getDB();
    $statement = $database->prepare("UPDATE products SET name=:name, price=:price, status=:status, amount=:amount photo=:photo, updated_at=now() WHERE id=$id");
    try {
      $statement->execute([
        ':name' => $data['name'],
        ':price' => $data['price'],
        ':status' => $data['status'],
        ':amount' => $data['amount'],
        ':photo' => $data['photo']
      ]);
    } catch (\PDOException $e) {
      echo "Updating failed: " . $e->getMessage();
    }
    return $database->query("SELECT * FROM products WHERE id=$id")->fetchAll(\PDO::FETCH_ASSOC);
  }
  public static function destroy(int $id): bool
  {
    return static::getDB()->prepare("DELETE FROM products WHERE id=$id")->execute();
  }
}
