<?php
session_start();
if ($_SESSION['logueado']) {

    include_once("config_products.php");
    include_once("db.class.php");

    $link = new Db();
    $idUpd = $_GET["q"];
    $sql = "select p.id_product as id_product,p.id_category as id_category,c.category_name as category_name,p.product_name as product_name,p.price as price from products p inner join categories c on p.id_category=c.id_category where p.id_product=" . $idUpd;
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">ACTUALIZAR PRODUCTOS</h3>
            </div>
            <div class="col-md-12">
                <form class="form-group" accept-charset="utf-8" method="post" action="update_products.php">
                    <div class="form-group">
                        <label class="control-label">NOMBRE</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $data['product_name'] ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">PRECIO</label>
                        <input id="precio" name="precio" class="form-control" type="text" value="<?php echo $data['price'] ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label">CATEGORIA </label>
                        <select id="categoria" name="categoria" class="form-control">
                            <option value="<?php echo $data['id_category'] ?>">
                                <?php echo $data['category_name'] ?></option>
                            <?php
                            $sqlCategory = "select id_category as id_category ,category_name as category_name from categories order by category_name";
                            $stmt = $link->prepare($sqlCategory);
                            $stmt->execute();
                            $dataCategory = $stmt->fetchAll();
                            foreach ($dataCategory as $row) {
                                if ($data['category_name'] != $row['category_name']) {
                            ?>
                                    <option value="<?php echo $row['id_category'] ?>"> <?php echo $row['category_name'] ?></option>

                            <?php
                                }
                            }

                            ?>
                        </select>
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $data['id_product'] ?>">
                        </div>
                    </div>

                    <div class="text-center">
                        <br>
                        <input type="submit" class="btn btn-success" value="Guardar Producto">
                    </div>

                </form>
            </div>

        </div>
    </div>


</body>

</html>