<?php
session_start();
$flash_msg  = $_SESSION['flash_msg']  ?? '';
$flash_type = $_SESSION['flash_type'] ?? '';
unset($_SESSION['flash_msg'], $_SESSION['flash_type']);

// 2) Incluye tu header (siempre tras session_start)
include 'includes/header.php';

// 3) Conexión a la base de datos
include 'includes/condb.php';

// 4) Obtén el total de usuarios
$sql_total = "SELECT COUNT(*) AS total FROM usuarios";
$res_total = $conexion->query($sql_total);
if ($res_total) {
    $row = $res_total->fetch_assoc();
    $total_usuarios = $row['total'];
} else {
    error_log("Error SQL total usuarios: " . $conexion->error);
    $total_usuarios = 0;
}
?>

<!-- 5) Muestra el flash si existe -->
<?php if ($flash_msg !== ''): ?>
  <div class="<?= $flash_type === 'success' 
                   ? 'mensaje-exito' 
                   : 'mensaje-error' ?>">
    <?= htmlspecialchars($flash_msg) ?>
  </div>
<?php endif; ?>

<!-- Hero / Bienvenida -->
<section class="hero">
  <h2>Bienvenido a nuestra tienda de componentes informáticos</h2>
  <p>Tu tienda de confianza para encontrar los mejores componentes al mejor precio y con la mejor calidad.</p>
  <a href="productos.php" class="btn-hero">Ver productos</a>
</section>

<!-- Estadísticas de usuarios -->
<section class="estadisticas-usuarios">
  <h2>Estadísticas de Usuarios</h2>
  <p>👉 <strong><?= $total_usuarios ?></strong> usuarios registrados.</p>
</section>

<div class="info-adicional">
  <h2>¿Por qué elegirnos?</h2>
  <ul>
    <li>Envío gratuito en compras mayores a 50€.</li>
    <li>Garantía de satisfacción 100%.</li>
    <li>Atención al cliente personalizada.</li>
  </ul>
</div>

<?php
// Fin de la promoción
$promo_end = '2025-06-25 23:59:59';
?>
<section class="offer-countdown">
  <h2>¡Oferta Flash!</h2>
  <p class="offer-text">Sólo quedan:</p>
  <p id="countdown">Cargando timer…</p>
  <a href="productos.php" class="btn-oferta">Aprovecha la promo</a>
</section>

<script>
// Cuenta atrás de la promo
const promoEnd   = new Date("<?= $promo_end ?>").getTime();
const countdownEl = document.getElementById("countdown");

const timer = setInterval(() => {
  const now  = Date.now();
  const diff = promoEnd - now;

  if (diff <= 0) {
    clearInterval(timer);
    countdownEl.textContent = "¡Promoción finalizada!";
    return;
  }

  const days    = Math.floor(diff / (1000 * 60 * 60 * 24));
  const hours   = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((diff % (1000 * 60 * 60))      / (1000 * 60));
  const seconds = Math.floor((diff % (1000 * 60))           / 1000);

  countdownEl.textContent = 
    (days    > 0 ? days    + "d " : "") +
    (hours   > 0 ? hours   + "h " : "") +
    (minutes > 0 ? minutes + "m " : "") +
                 seconds + "s";
}, 1000);
</script>

<?php include 'includes/footer.php'; ?>
