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
    						$req = $obj->query("SELECT * FROM users WHERE username = ?", $array['username']);
    						if($req->fetch())
    						{
    							echo '<h2>Votre identifiants est déjà utiliser</h2>';
    						}
    						else
    						{
	    						$pass = hash('sha512', $array['password']);
	    						$req = $obj->query("INSERT INTO users (username,email,password,ip) VALUES (?,?,?,?)",[
									$array['username'], 
									$array['email'], 
									$pass, 
									$_SERVER['REMOTE_ADDR']
								]);
								echo "<h2>Votre compte a bien été créer !</h2>";
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
    				$pass = hash('sha512', $array['password']);
    				$req = $obj->query("SELECT * FROM users WHERE username = ? AND password = ?", [$array['username'], $array['password']]);
    				if($req->fetch())
    				{
    					$_SESSION['auth'] = $array['username'];
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
    
}
