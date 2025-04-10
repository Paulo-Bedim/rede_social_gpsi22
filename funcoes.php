<?php // funcoes.php
    $dbhost = 'localhost';
    $dbname = 'rede_social_gpsi22';
    $dbuser = 'pauloneto1';
    $dbpass = 'password123';
    $ligacao = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($ligacao->connect_error) die("Erro fatal na ligação!");

    // Função para criar tabela; ATENÇÃO: Ainda não vai criar tabela
    function createTable($nome, $query)
    {
        queryMysql("CREATE TABLE IF NOT EXISTS $nome($query)");
        echo "A tabela '$nome' foi criada ou já existe.<br>";
    }

    // Função para executar queries
    function queryMysql($query)
    {
        global $ligacao;
        $result = $ligacao->query($query);
        if (!$result) die("Erro fatal na consulta!");
        return $result;
    }

    // Função para destruir sessão e limpar dados no logout
    function destroiSessao()
    {
        // Limpa todas as variáveis de sessão
        $_SESSION = array();
        // Destrói a sessão e elimina as cookies
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    // Função para mostrar imagem e apresentação do utilizador
    function mostrarPerfil($utilizador)
    {
        if (file_exists("$utilizador.jpg")) {
            echo "<img src='$utilizador.jpg' style='float:left;'>";
        }
        $result = queryMysql("SELECT * FROM perfis WHERE utilizador='$utilizador'");
        if ($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            echo stripslashes($row['texto']) . "<br style='clear:left;'><br>";
        }
        else echo "<p>Ainda não há dados.</p><br>";
    }

    // Função para curtir uma mensagem
    function curtirMensagem($id) {
        global $utilizador;
        // Verifica se o utilizador já curtiu esta mensagem
        $result = queryMysql("SELECT * FROM curtidas WHERE id_mensagem='$id' AND usuario='$utilizador'");
        if ($result->num_rows == 0) {
            queryMysql("INSERT INTO curtidas VALUES(NULL, '$id', '$utilizador')");
        }
    }

    // Função para remover a curtida de uma mensagem
    function removerCurtida($id) {
        global $utilizador;
        queryMysql("DELETE FROM curtidas WHERE id_mensagem='$id' AND usuario='$utilizador'");
    }

    // Função para contar o número de curtidas de uma mensagem
    function contaCurtidas($id) {
        $result = queryMysql("SELECT COUNT(*) AS count FROM curtidas WHERE id_mensagem='$id'");
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row['count'];
    }
?>
