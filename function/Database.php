<?php
class Database{

    private $pdo;

    public function __construct($login, $password, $database_name, $host = 'localhost'){
        $this->pdo = new PDO("mysql:dbname=$database_name;host=$host", $login, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public function query($query, $params = false){
        if($params){
            $req = $this->pdo->prepare($query);
            $req->execute($params);
        } else {
            $req = $this->pdo->query($query);
        }
        return $req;
    }

    public static function Register($array)
    {
	 require_once '../recaptchalib.php';
	 require_once '../config.php';
        if($array)
        {
            if(!empty($array['username']) && !empty($array['password']) && !empty($array['email']) && !empty($aray['g-recaptcha-response']))
            {
                if($array['password'] === $array['password_co'])
                {
                    $con = new Database($DBUsername,$DBPassword,$DBName);
                    $req = $con->query("SELECT * FROM users WHERE username = ?",[htmlspecialchars($array['username'])]);
                    if($req->rowCount() == 0)
                    {
                        $reCaptcha = new ReCaptcha($privateKey);
                        $resp = $reCaptcha->verifyResponse($SERVER["REMOTE_ADDR"], $array["g-recaptcha-response"]);
                        if($resp != null && $resp->success)
                        {
                            $pass = hash('sha512',htmlspecialchars($array['password']));
                            $req = $obj->query("INSERT INTO users (username,email,password,ip) VALUES (?,?,?,?)",
                            [
                                htmlspecialchars($array['username']), 
                                htmlspecialchars($array['email']), 
                                $pass, 
                                $_SERVER['REMOTE_ADDR']
                            ]);
                            //Account created
                        }
                    }
                    else
                    {
                        echo "Vos identifiants sont déjà utiliser";
                    }
                }
                else
                {
                    echo "Vos mots de passe ne correspondent pas !";
                }
            }
            else 
            { 
                echo "Merci de bien remplir le formulaire !"; 
            }
        }
    }

    public static function Login($array)
    {
        require_once '../config.php';
        if($array)
        {
            if(!empty($array['username']) && !empty($array['password']))
            {
                $con = new Database($DBUsername,$DBPassword,$DBName);
                $pass = hash('sha512',htmlspecialchars($array['password']));
                $req = $con->query("SELECT * FROM users WHERE username = ? AND password = ?",
                [
                    htmlspecialchars($array['username']),
                    $pass
                ]);
                if($req->fetch())
                {
                    $_SESSION['auth'] = htmlspecialchars($array['username']);
                    header('Location: index.php');
                }
                else
                {
                    echo "Identifiants incorrect !";
                }
            }
            else
            {
                echo "Merci de bien remplir le formulaire !"
            }
        }
    }

    public static function ModifyPassword($array)
    {
        require_once '../config.php';
        if($array)
        {
            if(!empty($array['password'] && !empty($array['password_co'])))
            {
                $con = new Database($DBUsername,$DBPassword,$DBName);
                $pass = hash('sha512',htmlspecialchars($array['password']));
                $req = $obj->query("UPDATE users SET password = ? WHERE username = ?",
                [
                    $pass,
                    $_SESSION['auth'];
                ]);
            }
            else
            {
                echo 'Merci de bien remplir le formulaire !';
            }
        }
    }
    
}
