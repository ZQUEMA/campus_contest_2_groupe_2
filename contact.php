	<!--Inserstion du header qui contient la page request.php  -->
<?php include 'header.php'; ?>
	<section class="main clearfix">
		<section class="top">
			<div class="wrapper content_header clearfix">
				<h1 class="title">Manga++</h1>
			</div>
		</section>
		<section class="wrapper">
			<div class="content">
					<section class="mb-4">
					<p class="text-center w-responsive mx-auto mb-5">Avez-vous des questions? N'hésitez pas à nous contacter directement. Notre équipe reviendra vers vous au plus vite pour vous aider.</p>
					<div class="row">
						<div class="col-md-9 mb-md-0 mb-5">
							<!-- Debut du formulaire de contact -->
							<form id="contact-form" name="contact-form" method="post">
								<div class="row">
									<div class="col-md-6">
										<div class="md-form mb-0">
											<label for="name" class="">Votre nom</label>
											<input type="text" id="name" name="name" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="md-form mb-0">
											<label for="email" class="">Votre email</label>
											<input type="text" id="email" name="email" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="md-form mb-0">
											<label for="subject" class="">Objet du message</label>
											<input type="text" id="subject" name="subject" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="md-form">
										<label for="message">Votre message</label>
											<textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
										</div>

									</div>
								</div>
							<div class="text-center text-md-left">
								<!-- Envoie du formulaire -->
								<button type="submit" class="btn btn-primary btn-sm pull-left" name="mail">Envoyer</button>
							</div>
							</form>
							<!-- Fin du formulaire de contact -->
						</div>
					</div>
			</section>
		</section>
	</body>
</html>