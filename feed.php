<?php // feed.php
    require_once 'header.php';
    if (!$loggedin) die("</div></body></html>");

    // Processa ação de curtir ou remover curtida
    if (isset($_GET['like'])) {
        $like_id = $_GET['like'];
        curtirMensagem($like_id);
    }
    if (isset($_GET['unlike'])) {
        $unlike_id = $_GET['unlike'];
        removerCurtida($unlike_id);
    }

    echo "<h3>Feed de Atividades</h3>";
    $query = "SELECT * FROM mensagens WHERE tipomsg='0' ORDER BY hora DESC LIMIT 10";
    $result = queryMysql($query);
    $num = $result->num_rows;
    for ($j = 0; $j < $num; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<div class='mensagem'>";
        echo date('j M \'y g:ia:', $row['hora']);
        echo " <a href='mensagens.php?ver=" . $row['autor'] . "'>" . $row['autor'] . "</a> ";
        echo "escreveu: \"" . $row['mensagem'] . "\"";

        // Verifica se o utilizador já curtiu a mensagem
        $queryCurtida = "SELECT * FROM curtidas WHERE id_mensagem='" . $row['id'] . "' AND usuario='$utilizador'";
        $resultCurtida = queryMysql($queryCurtida);
        if ($resultCurtida->num_rows == 0) {
            echo " [<a href='feed.php?like=" . $row['id'] . "'>Curtir</a> (" . contaCurtidas($row['id']) . ")]";
        } else {
            echo " [<a href='feed.php?unlike=" . $row['id'] . "'>Remover curtida</a> (" . contaCurtidas($row['id']) . ")]";
        }
        echo "</div>";
    }
    if (!$num) echo "<p class='info'>Sem atividades recentes.</p>";
?>
</div><!-- Fechando page-container -->
</body>
</html>
