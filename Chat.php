<?php

$loader = new Twig\Loader\FilesystemLoader('templates');
$twig = new Twig\Environment($loader, [
    'cache' => 'compilation_cache'
]);

private function getConnection() : PDO
{
    $username = "root";
    $password = "";
    $host = "localhost";
    $db = "User";
    $dsn = "sqlite:dbname=$db;host=$host";                    //задаём тип бд, с которым будем работать
    $connection = new PDO(dsn, $username, $password);
    return $connection;
}

function showMessages($connection)   //вывод сообщений
{
    $rows = [];
    $request = $connection->prepare("SELECT * FROM Messages");
    $request->execute();
    while ($row = $request->fetch(\PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    return $rows;
}

function isUserVerified ($connection, $login, $password) {
    $request = $connection->prepare("SELECT * FROM users WHERE login = ?");
    $request->bindParam(1, $login);
    $request->execute;
    $row = $request->fetch(\PDO::FETCH_ASSOC);
    if ($row == []) {       //no user
        echo "User doesn't exist";
        return;
    }
    if ($row["pass"] == $password) {
        echo "Authorisation completed";
        return true;
    } else {
        echo "Authorisation failed";
        return false;
    }
   // return $row["pass"] == $password;     //if exists -> check password
}

function sendMessage($login,$message, $connection)                            //отправка сообщений
{
    $request = $connection->prepare("INSERT INTO Messages (login, date, message) VALUES (?, ?, ?)");
    $request->bindParam(1, $login);
    $request->bindParam(2, date("YYYY-MM-DD hh:mm"));
    $request->bindParam(3, $message);
    $request->execute();
}
function main() {
    $connection = getConnection();
    $login = $_GET['login'];
    $password = $_GET['password'];
    $message = $_GET['message'];

    if(!isUserVerified($login, $password, $connection)) {
        showMessages($connection);                            //если пользователь не авторзован, то он может только посмотреть чат
    } else {
        sendMessage($login,$message, $connection);                            //если авторизован, то может отправить соощение
    }
}




