<footer class="bg-yellow py-3 mt-auto">
    <div class="container">
        <div class="footer row d-flex align-items-center">
            <div class="col-6 copyright">
                &copy; Developed by Fenris.
                <?= date('Y') == 2020 ? 2020 : 2020 . '-' . date('Y'); ?>
            </div>
            <div class="col-6 d-flex justify-content-end social-links align-items-center">
                <p>Follow us:</p>
                <ul>
                    <li class="mx-2">
                        <a class="d-flex" href="https://github.com/Fenris-v" target="_blank" rel="noreferrer noopener">
                            <i class="fab fa-github-square"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script src="/templates/js/jquery-3.5.1.min.js"></script>
<script src="/templates/js/popper.min.js"></script>
<script src="/templates/js/bootstrap.min.js"></script>
</body>
</html>
