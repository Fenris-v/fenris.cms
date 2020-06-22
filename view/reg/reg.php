<?php
/** @noinspection PhpUndefinedVariableInspection */
includeView('layout.head', ['title' => $title]); ?>

<div class="auth-bg">
    <img id="auth-bg" src="/templates/images/bg.jpg" alt="background">
    <img id="sun" src="/templates/images/sun.png" alt="sun">
</div>

<form class="form-signin m-auto p-4">
    <img class="mb-4" src="/templates/images/logo.jpeg" alt="logo">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control mb-2" placeholder="Email address" required="" autofocus="">
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control mb-2" placeholder="Password" required="">
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

<script src="/templates/js/jquery-3.5.1.min.js"></script>
<script src="/templates/js/popper.min.js"></script>
<script src="/templates/js/bootstrap.min.js"></script>
<script src="/templates/js/gsap.min.js"></script>
<script src="/templates/js/authAmimate.js"></script>
</body>
</html>
