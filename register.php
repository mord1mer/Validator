<?php 

require_once 'database/Database.php';
require_once 'validator/Validator.php';
require_once 'validator/ErrorHandler.php';
$errorHandler = new ErrorHandler;
$database=new Database;

$pdo = $database->pdo;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {	
		$validator = new Validator($database,$errorHandler);
		$validation = $validator->check($_POST, [
			'nick' => [
				'required' => false,
				'maxlenght' => 12,
				'minlenght' => 4,
				'unique' => 'users',
			],
			'email' => [
				'required' => true,
				'maxlenght' => 100,
				'email' => true,
				'unique' => 'users',
			],
			'city' => [
				'required' => true,
				'maxlenght' => 100,
				'minlenght' => 3,
			],
			'postal_code' => [
				'required' => true,
				'post_code' => true,
			],
			'password' => [
				'required' => true,
				'minlenght' => 6,
				'maxlenght' => 20,
			],
			'repeat_password' => [
				'required' => true,
				'match' => 'password',
			],
			'g-recaptcha-response' => [
				'captcha' => true,
				'required' => true,
			],
			'regulamin' => [
				'required' => true,
			],
		]);

	if ($validation->fails()) {
		echo('Wystąpiły błędy popraw formularz');
		// echo '<pre>';
		// var_dump($errorHandler->allErrors());
		// echo '</pre>';

	} else {
		echo('Zarejestrowano poprawnie sprawdz emaila');
	}


}?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Simple validator</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<main>
    <section class="container">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Rejestracja</div>
            <div class="card-body">
                <p>Rejestracja jest darmowa.</p>
                <p>Po rejestracji wykonaj dwupoziomową aktywację konta.</p>
                <p>Pola oznaczone <span>*</span> są wymagane do poprawnego ukończenia procesu rejestracji.</p>
            </div>
        </div>
        <div class="card text-center">
            <div class="card-header bg-primary text-white">
                Formularz rejestracji
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <input class="form-control" type="text" name="nick" id="nick" value="<?php if ($errorHandler->hasErrors()) {$validator->old_value('nick');}?>">
                        <label for="nick">nick <span class="required_symbol">*</span></label>
                        <?php if ($errorHandler->hasErrors()&&!empty($errorHandler->firstError('nick'))): ?>
                        <div class="bg-danger text-white">
                            <?php echo $errorHandler->firstError('nick') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="email" type="email" name="email" value="<?php if ($errorHandler->hasErrors()) {$validator->old_value('email');}?>">
                        <label for="email">email <span class="required_symbol">*</span></label>
                        <?php if ($errorHandler->hasErrors()&&!empty($errorHandler->firstError('email'))): ?>
                        <div class="bg-danger text-white">
                            <?php echo $errorHandler->firstError('email') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="city" name="city" value="<?php if ($errorHandler->hasErrors()) {$validator->old_value('city');}?>">
                        <label for="city">Miasto <span class="required_symbol">*</span></label>
                        <?php if ($errorHandler->hasErrors()&&!empty($errorHandler->firstError('city'))): ?>
                        <div class="bg-danger text-white">
                            <?php echo $errorHandler->firstError('city') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" id="postal_code" name="postal_code" value="<?php if ($errorHandler->hasErrors()) {$validator->old_value('postal_code');}?>">
                        <label for="postal_code">Kod pocztowy<span class="required_symbol">*</span></label>
                        <?php if ($errorHandler->hasErrors()&&!empty($errorHandler->firstError('postal_code'))): ?>
                        <div class="bg-danger text-white">
                            <?php echo $errorHandler->firstError('postal_code') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" id="password" name="password">
                        <label for="password">Hasło <span class="required_symbol">*</span></label>
                        <span class="desc">Jako hasła nie używaj swojego imienia, nazwiska itp. Hasło musi się składać z minimum 6 znaków.</span>
                        <?php if ($errorHandler->hasErrors()&&!empty($errorHandler->firstError('password'))): ?>
                        <div class="bg-danger text-white">
                            <?php echo $errorHandler->firstError('password') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" id="repeat_password" name="repeat_password">
                        <label for="repeat_password">Powtórz hasło <span class="required_symbol">*</span></label>
                        <?php if ($errorHandler->hasErrors()&&!empty($errorHandler->firstError('repeat_password'))): ?>
                        <div class="bg-danger text-white">
                            <?php echo $errorHandler->firstError('repeat_password') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="form-group">
                        <label>Oświadczam, że znam i akceptuję postanowienia regulaminu
								<input class="form-control" type="checkbox"  name="regulamin" >
							</label>
                        <?php if ($errorHandler->hasErrors()&&!empty($errorHandler->firstError('regulamin'))): ?>
                        <div class="bg-danger text-white">
                            <?php echo $errorHandler->firstError('regulamin') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="captcha">
                        <div class="g-recaptcha" data-sitekey="6Lci3BoTAAAAAFno3fi1G2GOe3irnxhpeqj1A9oi"></div>
                        <input type="hidden" class="hiddenRecaptcha required" name="captcha" id="hiddenRecaptcha" data-error="#percaptcha">
                        <?php if ($errorHandler->hasErrors()&&!empty($errorHandler->firstError('g-recaptcha-response'))): ?>
                        <div class="bg-danger text-white">
                            <?php echo $errorHandler->firstError('g-recaptcha-response') ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <br>
                    <br>
                    <input class="btn btn-primary btn-block btn-lg" type="submit" required name="register" value="Zarejestruj się">
                </form>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA01CSJu8MXF7Ce7GyNvPtCo2aJzy2eT10&libraries=places&sensor=false&libraries=places&region=PL"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
	function autocompleteLoad() {
	    var input = document.getElementById('city');
	    var options = {
	    types: ['(cities)'],
	};
	var autocomplete = new google.maps.places.Autocomplete(input, options);
	}
	google.maps.event.addDomListener(window, 'load', autocompleteLoad);
</script>
</body>
</html>