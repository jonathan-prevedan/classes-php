<?php 

$bdd = new PDO('mysql:host=localhost;dbname=class;charset=utf8', 'root', '');

class userpdo
{
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    public function register($login,$email,$password,$firstname,$lastname)
    {
        $register = $bdd->query("SELECT * FROM users WHERE login='$login'");
        $exist = $register->rowCount();

        if($exist == 0)
        {
            $hash_pwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => 8]);
            $insertmbr = $bdd->query("INSERT INTO users (login,password,email,firstname,lastname) VALUES ('$login','$hash_pwd','$email','$firstname','$lastname'");
            return array($login,$password,$email,$firstname,$lastname);
        }
        else
        {
            return'Ce login existe déjà.';
        }
    }
    public function connect($login, $password)
{

	$user = $bdd->query("SELECT *FROM user WHERE login='$login'");
	$donnees = $user->fetch();
		
		if(password_verify($password,$donnees['password'])) 
		{
			$this->id=$donnees['id'];
			$this->login=$login;
			$this->email=$donnees['email'];
			$this->firstname=$donnees['firstname'];
			$this->lastname=$donnees['lastname'];
		
			$_SESSION['login']=$login;
			$_SESSION['password']=$password;
			return $_SESSION['login']. ", vous êtes bien connecté";

			


		}
		else
		{
			return "Login ou mot de passe incorrect";	
		}

}

public function disconnect()
{
	session_destroy();
	return "Vous êtes bien déconnecté";
}

public function delete()
{

	if(isset($_SESSION['login']))
	{
		$login=$_SESSION['login'];
		$del = $base->query("DELETE FROM user WHERE login='$login'");
		session_destroy();
	}

}

public function update($login, $password, $email, $firstname,
$lastname)
{
	if(isset($_SESSION['login']))
	{
		$log=$_SESSION['login'];
		$hash_pwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
		$update = $bdd->query("UPDATE user SET login='$login', password='$hash_pwd', email='$email', firstname='$firstname', lastname='$lastname' WHERE login='$log'");
	}
}

public function isConnected()
{
	$connected=false;
	if(isset($_SESSION['login']))
	{
		$connected=true;
	}
	else
	{
		$connected=false;
	}

	return($connected);

}

public function getAllInfos()
{
	if(isset($_SESSION['login']))
	{
        return($this);
    }
    else
    {

    	return "Aucun utilisateur n'est connecté";
    }
}

public function getLogin()
{
	 return($this->login);
}

public function getEmail()
{
	 return($this->email);
}

public function getFirstname()
{
	 return($this->firstname);
}

public function getLastname()
{
	 return($this->lastname);
}

public function refresh()
{
	$login=$_SESSION['login'];
	$queryuser = $bdd ->query("SELECT *from user WHERE login='$login'");
	$donnees = $queryuser->fetch();

	$this->id=$donnees['id'];
	$this->login=$donnees['login'];
	$this->email=$donnees['email'];
	$this->firstname=$donnees['firstname'];
	$this->lastname=$donnees['lastname'];
}

}
session_start();



$user = new userpdo;


// var_dump($user->register('Salut','cocorico','jonathan@coucou.com','jona', 'than'));
// echo '<br>';


echo $user->connect('Salut', 'cocorico');
echo '<br>';


// echo $user->disconnect();
// echo '<br>';

// echo $user->delete();
// echo '<br>';

// echo $user->update('Aurevoir','salutrico','jhonny@cool.com','jhon', 'hnny');
// echo '<br>';

// echo $user->isConnected();
// echo '<br>';


// $info=$user->getAllInfos();
// var_dump($info);
// echo '<br>';

// echo $user->getLogin();
// echo '<br>';

// echo $user->getEmail();
// echo '<br>';

// echo $user->getFirstname();
// echo '<br>';

// echo $user->getLastname();
// echo '<br>';

// echo $user->refresh();
// echo '<br>';


?>
