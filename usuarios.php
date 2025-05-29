<?php
// usuarios.php
session_start();
include './includes/header.php';
include './includes/condb.php';

// Sólo admin
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Campo real para buscar y ordenar
$campoUsuario = 'nombre_usuario';

// Lógica de búsqueda
$cond = '';
if (!empty($_GET['buscar'])) {
    $b = $conexion->real_escape_string(trim($_GET['buscar']));
    $cond = "WHERE nombre_usuario LIKE '%$b%' OR correo LIKE '%$b%'";
}

// Consulta
$sql = "SELECT * FROM usuarios $cond ORDER BY $campoUsuario ASC";
$res = $conexion->query($sql);

if ($res === false) {
    echo '<div class="mensaje-error">'
       . 'Error al consultar usuarios: '
       . htmlspecialchars($conexion->error)
       . '</div>';
} else {
    ?>
    <main class="container">
        <?php
            if (!empty($_GET['msg'])) {
            switch ($_GET['msg']) {
                case 'creado':
                echo '<div class="mensaje-exito">Se ha añadido el usuario correctamente.</div>';
                break;
                case 'editado':
                echo '<div class="mensaje-exito">Se ha modificado el usuario correctamente.</div>';
                break;
                case 'borrado':
                echo '<div class="mensaje-exito">Se ha borrado el usuario correctamente.</div>';
                break;
            }
            }
        ?>
      <h2>Usuarios</h2>

      <form class="search-form" method="GET" action="">
        <label for="buscar">Buscar por usuario o correo:</label>
        <input
          type="text"
          id="buscar"
          name="buscar"
          placeholder="Nombre de usuario o correo"
          value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
          required
        >
        <button type="submit">Buscar</button>
      </form>

      <a href="anadirusuarios1.php" class="add-cart-btn" style="margin-bottom:1rem; display:inline-block;">
        Añadir Usuario
      </a>

      <div class="table-container">
        <table class="products-table">
          <thead>
            <tr>
              <th>Usuario</th>
              <th>Correo</th>
              <th>Rol</th>
              <th>Editar</th>
              <th>Borrar</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($res->num_rows > 0): ?>
              <?php while ($u = $res->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($u['nombre_usuario']) ?></td>
                  <td><?= htmlspecialchars($u['correo']) ?></td>
                  <td><?= htmlspecialchars($u['rol']) ?></td>
                  <td>
                    <a href="modificarusuarios1.php?id=<?= $u['id_usuario'] ?>" title="Editar">
                        <img src="./images/lapiz.png" width=20px>
                    </a>
                  </td>
                  <td>
                    <a href="borrarusuarios1.php?id=<?= $u['id_usuario'] ?>"
                       title="Borrar"
                       onclick="return confirm('¿Seguro que quieres borrar este usuario?');"
                    ><img src="./images/basura.jpg" width=20px></a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6">No se encontraron usuarios.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
    <?php
}
include './includes/footer.php';
