<div class="container">
    <?php require '../views/view.error_bubble.php'; ?>
    <div class="row justify-content-center">
        <div class="col-lg-4 my-4 ">
            <form action="login.php" method="post">
            <div class="mb-3">
                <label for="email" name="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="rememberme" class="form-check-input" id="rememberme">
                <label class="form-check-label" for="rememberme">Recuerdame</label>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</div>