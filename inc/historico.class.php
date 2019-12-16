<?php 

class historico {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function senhaHistorico($senha) {
        $sql = $this->pdo->prepare("SELECT * FROM historico_senha WHERE senha = :senha");
        $sql->bindValue(":senha", $senha);
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $_SESSION['senha_historico'] = $sql['senha'];

            return true;
        }
        return false;
    }

    public function addHistorico($id) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) {
            $navegador = "Opera";
        } elseif (strpos($user_agent, 'Edge')) {
            $navegador = "Edge";
        } elseif (strpos($user_agent, 'Chrome')) {
            $navegador = "Google Chrome";
        } elseif (strpos($user_agent, 'Firefox')) {
            $navegador = "Firefox";
        } elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) {
            $navegador = "Internet Explorer";    
        } elseif (strpos($user_agent, 'Safari')) {
            $navegador = "Safari"; 
        } else {
            $navegador = "Outro";
        }

        if (strpos($user_agent, 'Windows NT 10')) {
            $so = "Windows 10";
        } elseif (strpos($user_agent, 'Windows NT 6.3')) {
            $so = "Windows 8.1";
        } elseif (strpos($user_agent, 'Windows NT 6.2')) {
            $so = "Windows 8";
        } elseif (strpos($user_agent, 'Windows NT 6.1')) {
            $so = "Windows 7";
        } elseif (strpos($user_agent, 'Windows NT 6.0')) {
            $so = "Windows Vista";
        } elseif (strpos($user_agent, 'Windows NT 5.2')) {
            $so = "Windows Server 2003/XP x64";
        } elseif (strpos($user_agent, 'Windows NT 5.1') || strpos($user_agent, 'Windows XP')) {
            $so = "Windows XP";
        } elseif (strpos($user_agent, 'Ubuntu')) {
            $so = "Ubuntu";
        } elseif (strpos($user_agent, 'Linux')) {
            $so = "Linux";
        } else {
            $so = "Outros";
        }                                

        $sql = $this->pdo->prepare("INSERT INTO historico (id_usuario, datahora, ip, so, navegador) VALUES (:id_usuario, STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i'), :ip, :so, :navegador)");
        $sql->bindValue(":id_usuario", $id);
        $sql->bindValue(":ip", $ip);
        $sql->bindValue(":so", $so);
        $sql->bindValue(":navegador", $navegador);
        $sql->execute();
    }

    public function getHistorico() {
        $array = array();

        $sql = $this->pdo->prepare("SELECT historico.id, historico.datahora, historico.ip, historico.so, historico.navegador, usuarios.nome as usuario FROM historico LEFT JOIN usuarios ON historico.id_usuario = usuarios.id ORDER BY historico.id DESC");
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function delHistorico($id) {
        $sql = $this->pdo->prepare("DELETE FROM historico WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}