<?php // logout.php
	require_once 'header.php';
	
	if(isset($_SESSION['utilizador']))
	{
		destroiSessao();
		echo "<br><div class='center'>A sua sessão terminou. Por favor 
			 <a data-transition='slide' href='index.php'>clique aqui</a>
			 para atualizar a página.</div>";
	}
	else echo "<div class='center'>Você não pode terminar a sessão porque ela não está ativa.</div>";
?>
		</div>
	</body>
</html>