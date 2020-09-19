<?php

function setActive ($numberOfNavbarItem)
{
    $option = $_SERVER['REQUEST_URI'];
    switch ($option)
    {
        case "/HomeBudget2/menuGlowne.php":
            {
                if ($numberOfNavbarItem == 1)
                return "active";
            }
        break;
        case "/HomeBudget2/dodajPrzychod.php":
            {
                if ($numberOfNavbarItem == 2)
                return "active";
            }
        break;
        case "/HomeBudget2/dodajWydatek.php":
            {
                if ($numberOfNavbarItem == 3)
                return "active";
            }
        break;
        case "/HomeBudget2/przegladajBilans.php":
            {
                if ($numberOfNavbarItem == 4)
                return "active";
            }
        break;
        case "/HomeBudget2/ustawienia.php":
            {
                if ($numberOfNavbarItem == 5)
                return "active";
            }
        break;
    }

}

echo

'<header>
<div class="container-fluid">
    <div class="row" style="min-height: 131px;">
        <div class="col py-2 bg-primary">
            <h1 class="text-capitalize text-light text-center mb-0">
                <a href="index.php" id="logo"><i class="icon-home brand"></i><strong>HomeBudget</strong></a>
            </h1>
            <p class="small text-center my-0">
                Pieniądze to nie wszystko, ale wszystko bez pieniędzy to nic.
            </p>
        </div>
    </div>
</div>
</header>

<nav class="navbar navbar-light bg-light p-0 navbar-expand-lg main-navbar">
<button type="button" class="navbar-toggler m-1 order-first" data-toggle="collapse" data-target="#navbarLinks">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse " id="navbarLinks">
    <ul class="navbar-nav mr-auto">
        <li class="navbar-item pt-2">
            <a href="menuGlowne.php" class="nav-link '.setActive(1).'"><i class="icon-home-1 mx-1"></i>Strona Główna</a>
        </li>
        <li class="navbar-item pt-2">
            <a href="dodajPrzychod.php" class="nav-link '.setActive(2).'"><i class="icon-dollar mx-1"></i>Dodaj Przychód</a>
        </li>
        <li class="navbar-item pt-2">
            <a href="dodajWydatek.php" class="nav-link '.setActive(3).'"><i class="icon-basket mx-1"></i>Dodaj Wydatek</a>
        </li>
        <li class="navbar-item pt-2">
            <a href="przegladajBilans.php" class="nav-link '.setActive(4).'"><i class="icon-chart-bar mx-1"></i>Przeglądaj Bilans</a>
        </li>
        <li class="navbar-item pt-2">
            <a href="ustwienia.php" class="nav-link '.setActive(5).'"><i class="icon-cog mx-1"></i>Ustawienia</a>
        </li>
        <li class="navbar-item pt-2">
            <a  href="logout.php" class="nav-link" id="logout-link"><i class="icon-logout mx-1"></i>Wyloguj się</a>
        </li>
    </ul>
</div>
<div class="navbar-item text-primary mr-3 pt-1">
<p class="m-1 pt-2"><i class="icon-user mr-1 mb-0"></i>Zalogowany jako: '.$_SESSION["login"].'
</p>
</div>
</nav>'

?>