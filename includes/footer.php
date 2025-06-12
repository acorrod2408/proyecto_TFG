</main>
<footer class="simple-footer">
<div class="footer-content">
    <p>&copy; <?= date('Y') ?> Tecnoiliberis. Todos los derechos reservados.</p>
    <div class="footer-social">
    <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer">
        <img src="images/facebook.png" alt="Facebook">
    </a>
    <a href="https://www.twitter.com/" target="_blank" rel="noopener noreferrer">
        <img src="images/x.png" alt="Twitter">
    </a>
    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">
        <img src="images/instagram1.png" alt="Instagram">
    </a>
    <a href="https://www.linkedin.com/" target="_blank" rel="noopener noreferrer">
        <img src="images/linkedin.png" alt="LinkedIn">
    </a>
    </div>
</div>
<!-- Script boton desplazar hacia arriba -->
<button id="toTop" class="to-top">↑</button>
<script>
const btn = document.getElementById('toTop');
window.addEventListener('scroll', () => {
  btn.style.display = window.scrollY > 200 ? 'block' : 'none';
});
btn.onclick = () => window.scrollTo({top: 0, behavior: 'smooth'});
</script>

</footer>
