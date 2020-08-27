<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>HomeBudget.rejestracja</title>
    <meta name="description" content="Program pomagający zapanować nad finansami domowymi">
	<meta name="keywords" content="finanse, budżet, pieniądze, bilans, saldo, wydatki, przychody, zakupy, oszczędności">
	<meta name="author" content="Bartłomiej Zagórski">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/main.css">
	<link rel="stylesheet" href="./css/fontello.css">
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400&display=swap" rel="preload" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400&display=swap" rel="stylesheet">  
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>

		<header>
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
		<main>
			<article id="main-content" class="py-3 height">
				<div class="container">
					<div class="row align-items-start justify-content-center">
						<div class="col-md-8 mx-auto py-4">
							<div class="card border-primary">
								<div class="card-header bg-primary py-2 text-light text-center ">
									<h3 class="h5 m-0">Rejestracja</h3>
								</div>
								<div class="card-body border-primary py-3">
									<form action="register.php" method="post">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text px-2">
													<i class="icon-mail"></i>
												</span>
											</div>
											<input type="email" name="email" id="email" class="form-control" placeholder="email" onfocus="this.placeholder=''" onblur="this.placeholder='email'" 
												<?php 
													if (isset($_SESSION['allTestsPassed']))
													{
														echo 'value = "'.$_SESSION['given_email'].'"';
													}
												?>
											required>
										</div>
										<?php
													if (isset($_SESSION['error_email']))
													{
														echo "<p class=\"mt-1 text-danger small\">{$_SESSION['error_email']}</p>";
														unset($_SESSION['error_email']);
													}
										?>
										<div class="input-group mt-3">
											<div class="input-group-prepend">
												<span class="input-group-text px-2"><i class="icon-user"></i></span>
											</div>
											<input type="text" name="login" id="login" class="form-control" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'" 
												<?php 
													if (isset($_SESSION['allTestsPassed']))
													{
														echo 'value = "'.$_SESSION['given_login'].'"';
													}
												?>
											required>
										</div>
										<?php
													if (isset($_SESSION['error_login']))
													{
														echo "<p class=\"mt-1 text-danger small\">{$_SESSION['error_login']}</p>";
														unset($_SESSION['error_login']);
													}
										?>
										<div class="input-group mt-3">
											<div class="input-group-prepend">
												<span class="input-group-text px-2"><i class="icon-lock"></i></span>
											</div>
											<input type="password" name="password" id="password" class="form-control" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" required>
										</div>
										<div class="input-group mt-3">
											<div class="input-group-prepend">
												<span class="input-group-text px-2"><i class="icon-lock"></i></span>
											</div>
											<input type="password" name="password-confirm" id="password-confirm" class="form-control" placeholder="powtórz hasło" onfocus="this.placeholder=''" onblur="this.placeholder='powtórz hasło'" required>
										</div>
										<button type="submit" class="btn btn-outline-primary btn-block mt-3 py-2"><i class="icon-user-plus mr-2"></i>Zarejestruj się</button>
									</form>
									<?php
										if (isset($_SESSION['allTestsPassed'])) unset($_SESSION['allTestsPassed']);
									?>
								</div>
								<div class="card-footer p bg-transparent border-primary">
									<p class="mb-1 text-center">Masz już konto?</p>
									<a href="logowanie.html" class="btn btn-success py-2 my-1 btn-block"><i class="icon-login mr-2"></i>Zaloguj się</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</article>
		</main>
	
    <script src="./js/jquery-3.5.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	
</body>
</html>