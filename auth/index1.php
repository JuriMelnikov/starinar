<?
/*
Basic login example with php user class
http://phpUserClass.com
*/
require_once 'authClass_php5.php';
$user = new flexibleAccess();
if ( isset($_GET['logout']) && $_GET['logout'] == 1 ) 
	$user->logout('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
if ( !$user->is_loaded() )//если нет userID, т.е. в конструкторе не определили, проверяем введенные данные, если ошибка - редирект на себя
{ 
	//Login stuff:
	if ( isset($_POST['uname']) && isset($_POST['pwd'])){//если есть и логин и пароль
	  if ( !$user->login($_POST['uname'],$_POST['pwd'],$_POST['remember'] )){//если login класса = ложь, сообщаем
	  //Mention that we don't have to use addslashes as the class do the job
	    echo 'Wrong username and/or password';
	  }else{																//если login класса = истина, редирект
	  echo "Да,вот так вот";
	    //user is now loaded
	    header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	  }
	}
	echo '<h1>Login</h1>
	<p><form method="post" action="'.$_SERVER['PHP_SELF'].'" >
	 username: <input type="text" name="uname" ><br><br >
	 password: <input type="password" name="pwd" ><br ><br >
	 Remember me? <input type="checkbox" name="remember" value="1" ><br ><br >
	 <input type="submit" value="login" >
	</form>
	</p>';
	die();
}else{//если userID есть то рисуем ссылку для выхода.
  //User is loaded
  echo '<a href="'.$_SERVER['PHP_SELF'].'?logout=1">logout</a>';
}
?>
Hello!!!