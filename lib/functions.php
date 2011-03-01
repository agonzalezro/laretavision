<?php
//FIXME: Si poñen unha web solo aparece http
define('DB', dirname(__FILE__).'/sqlite.db');


function getUserInfo($user) {
    try{
        $dbHandle = new PDO('sqlite:'.DB);
    }catch( PDOException $exception ){
        die($exception->getMessage());
    }   

    $sqlGetUser = 'SELECT * FROM users WHERE id = "'.$user.'"';
    $result = $dbHandle->query($sqlGetUser);

    $user = $result->fetch();

    $return['location'] = $user[1];
    $return['avatar'] = $user[2];

    return $return;
}


function readlast() {
    $chios = simplexml_load_file('http://lareta.net/rss');
    $chio = $chios->item;

    $split = split(':', $chio->title); //The first term is the username and the rest are the message (chío)

    //Read all the terms of the split except the first one
    //sizeof($split) could be a bad methodology, but only need to read it 1 time, as much, 2 or 3 times
    for($i = 1; $i <= sizeof($split); $i++) {
        if ($i == 1) $title = $split[$i];
        else if ($i == sizeof($split)) $title = $title . htmlspecialchars($split[$i]);
        else $title = $title . ':' . htmlspecialchars($split[$i]);
    }

    $link = $chio->link;
    $description = htmlspecialchars($chio->description); //Really the RSS's description is the timestamp
    $creator = $split[0]; //I get the creator splitting the title by ':'

    $userInfo = getUserInfo($creator);
	
	//escape the problematic characters on javascript
	$description= htmlspecialchars($description);
    return "showMessage(\"".$userInfo['location']."\", \"$creator\", \"".$userInfo['avatar']."\", \"$title\", \"$link\", \"$description\"); var user = \"$creator\";";
}
?>