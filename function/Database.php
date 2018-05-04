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
    		if(!empty($array['username']))
    		{
    			if(!empty($array['password']))
    			{
    				if(!empty($array['email']))
    				{
    					if($array['password'] === $array['password_co'])
    					{
    						$obj = new Database('root','','open');
    						$req = $obj->query("SELECT * FROM users WHERE username = ?", htmlspecialchars($array['username']));
    						if($req->fetch())
    						{
    							echo '<h2>Votre identifiants est déjà utiliser</h2>';
    						}
    						else
    						{
								$reCaptcha = new ReCaptcha($privateKey);
								if(isset($_POST["g-recaptcha-response"])) 
								{
									$resp = $reCaptcha->verifyResponse(
										$_SERVER["REMOTE_ADDR"],
										$_POST["g-recaptcha-response"]
										);
									if ($resp != null && $resp->success) 
									{
										$pass = hash('sha512', htmlspecialchars($array['password']));
										$req = $obj->query("INSERT INTO users (username,email,password,ip) VALUES (?,?,?,?)",[
											htmlspecialchars($array['username']), 
											htmlspecialchars($array['email']), 
											$pass, 
											$_SERVER['REMOTE_ADDR']
										]);
										echo "<h2>Votre compte a bien été créer !</h2>";
									}
									else 
									{
										echo "CAPTCHA incorrect";
									}
								}
							}
    					}
    					else
    					{
    						echo '<h2>Vos mots de passe ne correspondent pas !</h2>';
    					}
    				}
    				else 
    				{
    					echo '<h2>Merci de renseigner une adresse email !';
    				}
    			}
    			else
    			{
    				echo '<h2>Merci de renseigner un mot de passe</h2>';
    			}
    		}
    		else
    		{
    			echo '<h2>Merci de renseigner un nom d\'utilisateur</h2>';
    		}
    	}
    }

    public static function Login($array)
    {
    	if($array)
    	{
    		if(!empty($array['username']))
    		{
    			if(!empty($array['password']))
    			{
    				$obj = new Database('root','','open');
    				$pass = hash('sha512', htmlspecialchars($array['password']));
    				$req = $obj->query("SELECT * FROM users WHERE username = ? AND password = ?", [htmlspcialchars($array['username']), $pass]);
    				if($req->fetch())
    				{
    					$_SESSION['auth'] = htmlspecialchars($array['username']);
    					header('Location: index.php');
    				}
    				else
    				{
    					echo '<h2>Identifiants incorrect</h2>';
    				}
    			}
    			else 
    			{
    				echo '<h2>Vous devez renseigner un mot de passe</h2>';
    			}
    		}
    		else
    		{
    			echo '<h2>Vous devez renseigner un nom d\'utilisateur</h2>';
    		}
    	}
    }

    public static function ModifyPassword($array)
    {
    	if($array)
    	{
    		if(!empty($array['password']))
    		{
    			if(!empty($array['password_co']))
    			{
    				if($array['password'] === $array['password_co'])
    				{
    					$obj = new Database('root','','open');
    					$pass = hash('sha512', htmlspecialchars($array['password']));
    					$req = $obj->query("UPDATE users SET password = ? WHERE username = ?",[$pass, htmlspecialchars($_SESSION['auth'])]);
    					echo '<h2>Votre mot de passe a bien été modifier !</h2>';
    				}
    				else {
    					echo '<h2>Vos mots de passe ne correspondent pas !</h2>';
    				}
    			}
    			else
    			{
    				echo '<h2>Veuillez confirmer votre mot de passe !</h2>';
    			}
    		}
    		else
    		{
    			echo '<h2>Merci de renseigner un mot de passe !</h2>';
    		}
    	}
    }
    
}
