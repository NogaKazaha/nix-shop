<?php

namespace App\Models;

class CartModel extends \Core\Model
{
  public int $id;
  public int $user_id;
  public int $product_id;
  public string $created_at;
  public string $updated_at;
  public static function getAll()
  {
    $database = static::getDB();
    $statement = $database->query('SELECT * FROM products_order');
    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }
  public static function create(array $data): CartModel
  {
    $database = static::getDB();
    $statement = $database->prepare("INSERT INTO products_order (user_id, product_id, amount, created_at, updated_at) VALUES (:user_id, :product_id, :amount, now(), now())");
    try {
      $statement->execute([
        ':user_id' => $data['user_id'],
        ':product_id' => $data['product_id'],
        ':amount' => $data['amount'],
      ]);
    } catch (\PDOException $e) {
      echo "Creation failed: " . $e->getMessage();
    }
    return $database->query("SELECT * FROM products_order WHERE user_id='" . $data['user_id'] . "'")->fetchObject(__CLASS__);
  }
  public static function find(int $id): CartModel
  {
    return static::getDB()->query("SELECT * FROM products_order WHERE id=$id")->fetchObject(__CLASS__);
  }
  public static function findByUserId(int $user_id)
  {
    return static::getDB()->query("SELECT * FROM products_order WHERE user_id=$user_id")->fetchAll(\PDO::FETCH_ASSOC);
  }
  public static function update(array $data, int $id): CartModel
  {
    $database = static::getDB();
    $statement = $database->prepare("UPDATE products_order SET user_id=:user_id, product_id=:product_id, amount=:amount, updated_at=now() WHERE id=$id");
    try {
      $statement->execute([
        ':user_id' => $data['user_id'],
        ':product_id' => $data['product_id'],
        ':amount' => $data['amount'],
      ]);
    } catch (\PDOException $e) {
      echo "Updating failed: " . $e->getMessage();
    }
    return $database->query("SELECT * FROM products_order WHERE id=$id")->fetchObject(__CLASS__);
  }
  public static function destroy(int $id): bool
  {
    return static::getDB()->prepare("DELETE FROM products_order WHERE id=$id")->execute();
  }
}
