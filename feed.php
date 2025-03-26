<?php // feed.php
require_once 'header.php';
if (!$loggedin) die("</div></body></html>");
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
    echo "</div>";
}
if (!$num) echo "<p class='info'>Sem atividades recentes.</p>";
?>
</div><!-- Fechando page-container -->
</body>
</html>