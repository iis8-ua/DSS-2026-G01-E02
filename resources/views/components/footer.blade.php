<footer class="footer-ua text-center py-4 mt-auto">
    <div class="container text-muted">

        <div class="mb-3 d-flex justify-content-center flex-wrap gap-4">
            <a href="{{ route('legal.aviso') }}" class="text-decoration-none text-dark hover-blue">Aviso Legal</a>
            <a href="{{ route('legal.privacidad') }}" class="text-decoration-none text-dark hover-blue">Protección de Datos</a>
            <a href="{{ route('legal.accesibilidad') }}" class="text-decoration-none text-dark hover-blue">Accesibilidad</a>
            <a href="{{ route('legal.cookies') }}" class="text-decoration-none text-dark hover-blue">Cookies</a>
        </div>

        <small>
            &copy; {{ date('Y') }} Universidad de Alicante - Sistema de Reserva de Espacios.<br>
        </small>
    </div>
</footer>
