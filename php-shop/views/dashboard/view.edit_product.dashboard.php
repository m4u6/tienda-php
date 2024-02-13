<!-- Page content-->
<div class="container-fluid">
    <?php var_dump($_SESSION["product_data"]) ?>
    <h1>Editor de productos</h1>
    <form action="productos.php" method="post" class="py-3" >
        <input type="hidden" name="edit" value="<?php echo $_GET["edit"]?>">    <!--- Con esto luego al procesar el formulario podemos saber que hacer --->
        <div class="form-group">
            <h3>Nombre y descripción</h3>
            <label for="p_name">Nombre de producto:</label>
            <input type="text" name="p_name" id="p_name" class="form-control" value="<?php echo isset($_SESSION["product_data"]["p_name"]) ? $_SESSION["product_data"]["p_name"] : ""   ?>" >
            <label for="p_description">Descripción del producto:</label>
            <textarea rows="3" name="p_description" id="p_description" class="form-control"><?php echo isset($_SESSION["product_data"]["p_description"]) ? $_SESSION["product_data"]["p_description"] : ""   ?></textarea>
        </div>
        <div class="form-group">
            <label for="seo_name">URL Amigable (seo-name)</label>
            <input type="text" name="seo_name" id="seo_name" class="form-control" value="<?php echo isset($_SESSION["product_data"]["seo_name"]) ? $_SESSION["product_data"]["seo_name"] : ""   ?>">
            <label for="stock">Stock:</label>
            <input type="number" step=1 min=0 name="stock" id="stock" value="<?php echo isset($_SESSION["product_data"]["stock"]) ? $_SESSION["product_data"]["stock"] : ""   ?>">
            <input type="submit">
        </div>

    </form>
</div>