<?php 

class user 
{
    private $id;
    public 	$login;
    public  $email;
	public 	$firstname;
    public 	$lastname;
    

public function register($login, $password, $email, $firstname, $lastname)
{
    $bdd = mysqli_connect('Localhost','root','','class');
    $query = "SELECT * FROM users WHERE login='$login'";
    $execquery = mysqli_query($bdd,$query);
    $result = mysqli_num_rows($execquery);

    if($result = 0)
    {
        $crypt = password_hash($password,PASSWORD_BCRYPT,['cost' => 8]);
        $query = "INSERT INTO users (login,password,email,firstname,lastname) VALUES ('$login','$password','$email','$firstname','$lastname')";
        $queryu = mysqli_query($bdd,$query);
        return array($login,$password,$email,$firstname,$lastname);
    }
    else
    {
        return 'Login déjà existant';
    }

}

public function connect($login,$password)
{
    
    $bdd = mysqli_connect('Localhost','root','','class');
	$query="SELECT * from users WHERE login='$login'";
	$result= mysqli_query($bdd, $query);
	$row = mysqli_fetch_array($result);
		
		if(password_verify($password,$row['password'])) 
		{
			$this->id=$row['id'];
			$this->login=$login;
			$this->email=$row['email'];
			$this->firstname=$row['firstname'];
			$this->lastname=$row['lastname'];
		
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
    return'Vous êtes déconnecté';
}

public function delete()
{
    if(isset($_SESSION['login']))
    {
        $login=$_SESSION['login'];
        $bdd = mysqli_connect('Localhost','root','','class');
		$del="DELETE FROM user WHERE login='$login'";
		mysqli_query($bdd, $del);
		session_destroy();
    }
}

public function update($login, $password, $email, $firstname,$lastname)
{
	if(isset($_SESSION['login']))
	{
		
		$bdd = mysqli_connect('Localhost','root','','class');
		$log=$_SESSION['login'];
		$hash_pdw = password_hash($password, PASSWORD_BCRYPT, ['cost' => 8]);
		$update="UPDATE user SET login='$log', password='$hash_pdw', email='$email', firstname='$firstname', lastname='$lastname' WHERE login='$log'";
		mysqli_query($bdd, $update);
	}
}


public function isConnected()
{
	$connexion=false;
	if(isset($_SESSION['login']))
	{
		$connexion=true;
	}
	else
	{
		$connexion=false;
	}

	return($connexion);

}

public function getAllInfos()
{
	if(isset($_SESSION['login']))
	{
        return($this);
    }
    else
    {

    	return "Aucun utilisateur n'est connecté, veuillez vous connecté !";
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
	$bdd = mysqli_connect('Localhost','root','','class');
	$login=$_SESSION['login'];
	$queryuser="SELECT * from user WHERE login='$login'";
	$resultuser= mysqli_query($bdd, $queryuser);
	$tabuser=mysqli_fetch_array($resultuser);

	$this->id=$tabuser['id'];
	$this->login=$tabuser['login'];
	$this->email=$tabuser['email'];
	$this->firstname=$tabuser['firstname'];
	$this->lastname=$tabuser['lastname'];
}

}


?>