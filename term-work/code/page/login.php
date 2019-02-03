<h1>Login</h1>
<?php
if (!empty($_POST) && !empty($_POST["loginMail"]) && !empty($_POST["loginPassword"])) {
    $authService = Authentication::getInstance();
    if ($authService->login($_POST["loginMail"], $_POST["loginPassword"])) {
        header("Location:" . BASE_URL);
    } else {
        echo "<div class=\"wrong\">Uživatel nebo heslo je špatně!!!</div>";
    }
} else if (!empty($_POST)) {
    echo "<div class=\"wrong\">Zadejte heslo a jméno!!!</div>";
}
?>

<div >
    <form class= box method="post">
        <input class="email" type="email" name="loginMail" placeholder="Zadejte email!!!">
        <input class="password" type="password" name="loginPassword" placeholder="Zadejte heslo!!!">
        <input class="button" type="submit" value="Přihlásit se">

    </form>
</div>
