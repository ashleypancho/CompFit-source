<?php
// Routes

//Error Codes
  //-1 => Sent when no users are found from a get
  //-2 => Sent when no teams are found from a get
  //-3 => Returns for POST user, when the username is not unique
  //-4 => Returns for POST user when the user's email has already been used
  //-5 => Returns when no current challenges are found

// Function to check if a password hashes to the same thing as str2
function hash_equals($str1, $str2) {
    if(strlen($str1) != strlen($str2)) {
      return false;
    } else {
      $res = $str1 ^ $str2;
      $ret = 0;
      for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
      return !$ret;
    }
}

$app->post('/auth', function($request, $response, $args){
  $body = $request->getBody();
  $decode = json_decode($body);
  $db = $this->dbConn;
  $password = $decode->password;
  $strToReturn = '';

  $sql = 'SELECT user_id, username, password, salt FROM users WHERE email = :email';
  try {
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $decode->email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);
  }
  catch(PDOException $e) {
    echo json_encode($e->getMessage());
  }
  if ($user) {
      # code...
      if(hash_equals($user->password, crypt($password, $user->salt))) //email and password match a user
    	{
        return $response->write(json_encode(array("username" => $user->username, "user_id" => $user->user_id)));
      }
      else {
          return $response->write(json_encode(array("error" => -2, "user" => $user, "attempted_password" => crypt($password, $user->salt))));
      }
  }
  else {
      return $response->write( json_encode(array("error" => -1)));
  }
});

$app->get('/users',function($request, $response){
    return $response->write( json_encode( array("working" => 1) ) );


});
$app->group('/user', function(){
  $this->map(['GET', 'POST'], '', function($request, $response, $args){
    if($request->isGet()){
        $db = $this->dbConn;
        $strToReturn = '';
        $users = '';
        $sql = 'SELECT user_id, username, first_name, last_name, email, avatar, created
                FROM users';
        try {
          $stmt = $db->query($sql);
          $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        catch(PDOException $e) {
          echo json_encode($e->getMessage());
        }
        $strToReturn = json_encode($users, JSON_PRETTY_PRINT);
        return $response->write('' . $strToReturn);
    }
    if($request->isPost()){
      $body = $request->getBody();
      $decode = json_decode($body);
      $password = $decode->password;
      $db = $this->dbConn;
      $strToReturn = '';

      $checkUniqueUserSql = 'SELECT * FROM users WHERE `username` = :username';

      try {
        $stmt = $db->prepare($checkUniqueUserSql);
        $stmt->bindParam(':username', $decode->username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
      $test = json_encode($user);
      if($test != 'false'){
        return $response->write(json_encode(array("error" => -3)));
      }

      $checkUniqueEmailSql = 'SELECT * FROM users WHERE `email` = :email';

      try {
        $stmt = $db->prepare($checkUniqueEmailSql);
        $stmt->bindParam(':email', $decode->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
      $test = json_encode($user);
      if($test != 'false'){
        return $response->write(json_encode(array("error" => -4)));
      }

      $sql = 'INSERT INTO users (`first_name`, `last_name`, `username`, `email`, `password`, `salt`, `created` )
              VALUES (:first_name, :last_name, :username, :email, :password, :salt, UTC_TIMESTAMP())';
      try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':first_name', $decode->first_name);
        $stmt->bindParam(':last_name', $decode->last_name);
        $stmt->bindParam(':username', $decode->username);
        $stmt->bindParam(':email', $decode->email);
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
        $salt = sprintf("$2a$%02d$", 10) . $salt;
        $hash = crypt($password, $salt);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':salt', $salt);
        $stmt->execute();
        $user_id = $db->lastInsertId();
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
        return $response->write(json_encode(array("user_id" => $user_id)));
    }
  });
  $this->get('/{user_id}', function($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $user_id = $request->getAttribute('user_id');
    $users = '';

    $sql = 'SELECT user_id, first_name, last_name, email, avatar
            FROM users
            WHERE user_id = "'.$user_id.'"';
      try {
        $stmt = $db->query($sql);
        $users = $stmt->fetch(PDO::FETCH_OBJ);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    $test = json_encode($users, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No users found" => -1)));
    }
    else {
      return $response->write('' . $test);
    }
  });
});

$app->get('/username/{username}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $username = $request->getAttribute('username');
    $users = '';

    $sql = 'SELECT user_id, username, first_name, last_name, email, avatar
            FROM users
            WHERE username = "'.$username.'"';
    try {
      $stmt = $db->query($sql);
      $users = $stmt->fetch(PDO::FETCH_OBJ);
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    $test = json_encode($users, JSON_PRETTY_PRINT);
    if($test == 'false'){
      return $response->write(json_encode(array("error" => -1)));
    }
    else {
      return $response->write('' . $test);
    }
  }
);

$app->get('/useremail/{email}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $email = $request->getAttribute('email');
    $users = '';

    $sql = 'SELECT user_id, first_name, last_name, email, avatar
            FROM users
            WHERE email = "'.$email.'"';
      try {
        $stmt = $db->query($sql);
        $users = $stmt->fetch(PDO::FETCH_OBJ);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    $test = json_encode($users, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No users found" => -1)));
    }
    else {
      return $response->write('' . $test);
    }
  }
);
//This is technically a put request, but I was using HTML forms to test, and they don't support put so I made it a post instead
$app->put('/user/{user_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';

    $user_id = $request->getAttribute('user_id');
    $first_name = $_PUT["first_name"];
    $last_name = $_PUT["last_name"];
    $username = $_PUT["username"];

    $db->query('UPDATE users
                SET first_name = "'.$first_name.'",
                    last_name = "'.$last_name.'",
                    username = "'.$username.'"
                WHERE user_id = "'.$user_id.'"');

    foreach($db->query('select * from users') as $row){
      $strToReturn .= '<br /> user_id: ' . $row['user_id'] .' <br /> username: ' . $row['username'];
      $strToReturn .= '<br /> first_name: ' . $row['first_name'] .' <br /> last_name: ' . $row['last_name'];
      $strToReturn .= '<br />';
    }
    return $response->write('' . $strToReturn);
  }
);

$app->delete('/user/{user_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $user_id = $request->getAttribute('user_id');

    foreach($db->query('select * from users where user_id = "'.$user_id.'"') as $row){
      $strToReturn .= '<br /> user_id: ' . $row['user_id'] .' <br /> username: ' . $row['username'];
      $strToReturn .= '<br /> first_name: ' . $row['first_name'] .' <br /> last_name: ' . $row['last_name'];
    }

    $db->query('DELETE FROM users
                WHERE user_id = "'.$user_id.'"');

    return $response->write('Deleting <br />' . $strToReturn);
  }
);

$app->group('/users', function(){
  $this->get('/{team_id}', function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $team_id = $request->getAttribute('team_id');
    $users = '';

    $sql = 'SELECT user.user_id, user.username, user.first_name, user.last_name, user.email, user.avatar
            FROM teams team,
                (SELECT u.user_id, u.username, u.first_name, u.last_name, u.email, u.avatar, t.team_id
                 FROM users u,
                    (SELECT * FROM team_participation WHERE team_id = "'.$team_id.'") as t
                 WHERE t.user_id = u.user_id) as user
            WHERE team.team_id = user.team_id';

      try {
        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    $test = json_encode($users, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No users found" => -1)));
    }
    else {
      return $response->write('' . $test);
    }
  });
  $this->get('/team_name/{team_name}', function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $team_name = $request->getAttribute('team_name');
    $users = '';

    $sql = 'SELECT user.user_id, user.username, user.first_name, user.last_name, user.email, user.avatar
            FROM users user,
              (SELECT t.team_name, t.team_id, tp.user_id
               FROM team_participation tp, (SELECT * FROM teams WHERE team_name = "'.$team_name.'") as t
               WHERE t.team_id = tp.team_id) as team
            WHERE team.user_id = user.user_id';

      try {
        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    $test = json_encode($users, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No users found" => -1)));
    }
    else {
      return $response->write('' . $test);
    }
  });
});

$app->get('/teams',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $teams = '';
    $new;
    $final = [];
    $sql = 'SELECT team_id, team_name, captain_id, avatar, team_color
            FROM teams';
    $sql2 = 'SELECT username
             FROM users
             WHERE user_id = :user_id';
    try {
      $stmt = $db->query($sql);
      $teams = $stmt->fetchAll(PDO::FETCH_OBJ);
      foreach($teams as $team){
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(':user_id', $team->captain_id);
        $stmt2->execute();
        $cName = $stmt2->fetch(PDO::FETCH_ASSOC);
        $new['team_id'] = $team->team_id;
        $new['team_name'] = $team->team_name;
        $new['captain_id'] = $team->captain_id;
        $new['captain_name'] = $cName['username'];
        $new['avatar'] = $team->avatar;
        $new['team_color'] = $team->team_color;
        array_push($final, $new);
      }
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    $strToReturn = json_encode($final, JSON_PRETTY_PRINT);
    return $response->write('' . $strToReturn);
    }
);

$app->get('/team/{team_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $team_id = $request->getAttribute('team_id');
    $users = '';

    $sql1 = 'SELECT team_id, team_name, captain_id, avatar, team_color, created
             FROM teams
             WHERE team_id = "'.$team_id.'"';

    $sql2 = 'SELECT u.user_id, u.username, u.email
             FROM users u,
                (SELECT * from team_participation
                 WHERE team_id = "'.$team_id.'") as t
             WHERE t.user_id = u.user_id';
      try {
        $new;
        $array_loop = 0;
        $stmt = $db->query($sql2);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        //$d = array('players' => $users);

        $stmt2 = $db->query($sql1);
        $users2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $new['team_id'] = $users2['team_id'];
        $new['team_name'] = $users2['team_name'];
        $new['captain_id'] = $users2['captain_id'];
        $new['players'] = $users;
        $new['avatar'] = $users2['avatar'];
        $new['team_color'] = $users2['team_color'];
        $new['created'] = $users2['created'];
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    $test = json_encode($new, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No teams found" => -2)));
    }
    else {
      return $response->write('' . $test);
    }
  }
);

$app->get('/team_name/{team_name}',
function ($request, $response, $args){
  $db = $this->dbConn;
  $strToReturn = '';
  $team_name = $request->getAttribute('team_name');
  $users = '';

  //$sql = 'SELECT team.team_name, user.team_id, user.username FROM teams team, (Select u.first_name, u.last_name, u.username, t.team_id FROM users u, (select * from team_participation where team_id = "'.$team_id.'") as t WHERE t.user_id = u.user_id) as user WHERE team.team_id = user.team_id';
  $sql1 = 'SELECT team_id, team_name, captain_id, avatar, team_color, created
           FROM teams
           WHERE team_name = "'.$team_name.'"';
  $sql2 = 'SELECT u.user_id, u.username
           FROM users u,
              (SELECT tp.user_id
               FROM team_participation tp,
                  (SELECT team_id FROM teams WHERE team_name = "'.$team_name.'") as a
               WHERE a.team_id = tp.team_id) as t
           WHERE t.user_id = u.user_id';
    try {
      $new;
      $array_loop = 0;
      $stmt = $db->query($sql2);
      $users = $stmt->fetch(PDO::FETCH_OBJ);
      //$d = array('players' => $users);

      $stmt2 = $db->query($sql1);
      $users2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $new['team_id'] = $users2['team_id'];
      $new['team_name'] = $users2['team_name'];
      $new['captain_id'] = $users2['captain_id'];
      $new['players'] = $users;
      $new['avatar'] = $users2['avatar'];
      $new['team_color'] = $users2['team_color'];
      $new['created'] = $users2['created'];
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }

  $test = json_encode($new, JSON_PRETTY_PRINT);
  if($test == '[]'){
    return $response->write(json_encode(array("No teams found" => -2)));
  }
  else {
    return $response->write('' . $test);
  }
}
);

// $app->get('/team/{team_id}/{captain_id}',
//   function ($request, $response, $args){
//     $db = $this->dbConn;
//     $strToReturn = '';
//     $team_id = $request->getAttribute('team_id');
//     $captain_id = $request->getAttribute('captain_id');
//
//     foreach($db->query('select * from teams where team_id = "'.$team_id.'"') as $row){
//       $strToReturn .= '<br /> team_id: ' . $row['team_id'] .' <br /> team_name: ' . $row['team_name'];
//       $strToReturn .= '<br /> captain_id: ' . $row['captain_id'];
//       foreach($db->query('select * from users where user_id = "'.$captain_id.'"') as $row){
//         $strToReturn .= ' <br /> username: ' . $row['username'];
//         $strToReturn .= '<br /> first_name: ' . $row['first_name'] .' <br /> last_name: ' . $row['last_name'];
//       }
//     }
//
//     return $response->write('' . $strToReturn);
//   }
// );

$app->post('/team',
  function ($request, $response, $args){
    $body = $request->getBody();
    $decode = json_decode($body);
    $players = $decode->players;
    $db = $this->dbConn;
    $strToReturn = '';

    $sql = 'INSERT INTO teams (`team_name`, `captain_id`, `avatar`, `team_color`, `created`)
            VALUES (:team_name, :captain_id, :avatar, :team_color, UTC_TIMESTAMP())';
    try {
      $stmt = $db->prepare($sql);
        $stmt->bindParam(':team_name', $decode->team_name);
        $stmt->bindParam(':captain_id', $decode->captain_id);
        $stmt->bindParam(':avatar', $decode->avatar);
        $stmt->bindParam(':team_color', $decode->team_color);
        $stmt->execute();
        $team_id = $db->lastInsertId();
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }

    $sql2 = 'INSERT INTO team_participation (`team_id`, `user_id`, `created`)
             VALUES (:team_id, :user_id, UTC_TIMESTAMP())';

    try {
      $stmt = $db->prepare($sql2);
        $stmt->bindParam(':team_id', $team_id);
        $stmt->bindParam(':user_id', $decode->captain_id);
        $stmt->execute();
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }

    foreach($players as $playerid){
      try {
        $stmt = $db->prepare($sql2);
          $stmt->bindParam(':team_id', $team_id);
          $stmt->bindParam(':user_id', $playerid);
          $stmt->execute();
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    }
    //Need to find a way to return team_id
    //return $response->write('' . $);
    return $response->write( json_encode( array("team_id" => $team_id) ) );
  }
);

// $app->delete('/team/{team_id}',
//   function ($request, $response, $args){
//     $db = $this->dbConn;
//     $strToReturn = '';
//     $team_id = $request->getAttribute('team_id');
//
//     foreach($db->query('select * from teams where team_id = "'.$team_id.'"') as $row){
//       $strToReturn .= '<br /> team_id: ' . $row['team_id'] .' <br /> captain_id: ' . $row['captain_id'];
//     }
//
//     $db->query('DELETE FROM teams WHERE team_id = "'.$team_id.'"');
//
//     return $response->write('Deleting <br />' . $strToReturn);
//   }
// );



$app->get('/teams/{user_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $user_id = $request->getAttribute('user_id');
    $users = '';

    $sql = 'SELECT team.team_id, team.team_name, team.captain_id, team.avatar, team.team_color, team.created
            FROM teams team,
              (SELECT u.first_name, u.last_name, u.user_id, u.username, tp.team_id
               FROM team_participation tp,
                  (SELECT * FROM users WHERE user_id = "'.$user_id.'") as u
               WHERE u.user_id = tp.user_id) as user
             WHERE team.team_id = user.team_id';
    $cName = 'SELECT user_id, username
              FROM users
              WHERE user_id = :captain_id';
    $sql1 = 'SELECT c.challenge_id, c.task_name, c.start_date, c.end_date, c.repetitions, c.units, c.task_type, c.status, c.to_team_id, c.from_team_id
             FROM challenges c WHERE (c.to_team_id = :team_id OR c.from_team_id = :team_id) AND c.end_date >= CURDATE() AND c.status = "OPEN" ORDER BY c.end_date ASC';



             try {
               $new = array();
               $array_loop = 0;
               $stmt = $db->query($sql);
               $teams = $stmt->fetchAll(PDO::FETCH_OBJ);
               foreach ($teams as $val){
                 $new[$array_loop]['team_id'] = $val->team_id;
                 $new[$array_loop]['team_name'] = $val->team_name;
                 $new[$array_loop]['captain_id'] = $val->captain_id;
                 $stmt3 = $db->prepare($cName);
                 $stmt3->bindParam(':captain_id', $val->captain_id);
                 $stmt3->execute();
                 $captain = $stmt3->fetch(PDO::FETCH_OBJ);
                 $new[$array_loop]['captain_name'] = $captain->username;
                 $sql2 = 'SELECT u.user_id, u.username
                          FROM users u,
                           (SELECT * from team_participation
                            WHERE team_id = "'.$val->team_id.'") as t
                          WHERE t.user_id = u.user_id';
                 $stmt2 = $db->query($sql2);
                 $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                 $new[$array_loop]['players'] = $users;
                 $new[$array_loop]['avatar'] = $val->avatar;
                 $new[$array_loop]['team_color'] = $val->team_color;
                 $new[$array_loop]['created'] = $val->created;
                 $stmt3 = $db->prepare($sql1);
                 $stmt3->bindParam('team_id', $val->team_id);
                 $stmt3->execute();
                 $challenges = $stmt3->fetchAll(PDO::FETCH_OBJ);
                 $new[$array_loop]['challenges'] = $challenges;
                 $array_loop++;

               }
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    $test = json_encode($new, JSON_PRETTY_PRINT);
    return $response->write('' . $test);
  }
);

$app->get('/teams/captain_id/{captain_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $captain_id = $request->getAttribute('captain_id');
    $users = '';

    $sql = 'SELECT t.team_id, t.team_name, t.captain_id, t.avatar, t.team_color, t.created
            FROM teams t
            WHERE captain_id = "'.$captain_id.'"';
    $cName = 'SELECT user_id, username
          FROM users
          WHERE user_id = :captain_id';


      try {
        $new = array();
        $array_loop = 0;
        $stmt = $db->query($sql);
        $teams = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($teams as $val){
          $new[$array_loop]['team_id'] = $val->team_id;
          $new[$array_loop]['team_name'] = $val->team_name;
          $new[$array_loop]['captain_id'] = $val->captain_id;
          $sql2 = 'SELECT u.user_id, u.username
                   FROM users u,
                    (SELECT * from team_participation
                     WHERE team_id = "'.$val->team_id.'") as t
                   WHERE t.user_id = u.user_id';
          $stmt2 = $db->query($sql2);
          $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);
          $new[$array_loop]['players'] = $users;
          $new[$array_loop]['avatar'] = $val->avatar;
          $new[$array_loop]['team_color'] = $val->team_color;
          $new[$array_loop]['created'] = $val->created;
          $array_loop++;
        }
      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    $test = json_encode($new, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No teams found" => -2)));
    }
    else {
      return $response->write('' . $test);
    }
});

// $app->get('/teams/opponents/{captain_id}',
//   function ($request, $response, $args){
//     $db = $this->dbConn;
//     $strToReturn = '';
//     $captain_id = $request->getAttribute('captain_id');
//     $users = '';
//
//     $sql = 'SELECT t.team_id
//             FROM teams t
//             WHERE captain_id = "'.$captain_id.'"';
//
//       try {
//         $new = array();
//         $newUsers = array();
//         $array_loop = 0;
//         $stmt = $db->query($sql);
//         $teams = $stmt->fetchAll(PDO::FETCH_OBJ);
//         $sql2 = 'SELECT team_id, team_name FROM teams WHERE team_id NOT IN (SELECT DISTINCT t.team_id FROM team_participation t WHERE t.user_id IN (SELECT DISTINCT u.user_id FROM users u, (SELECT user_id from team_participation tp, (SELECT t.team_id FROM teams t WHERE captain_id = "'.$captain_id.'") as ti WHERE tp.team_id = ti.team_id) as t WHERE t.user_id = u.user_id))';
//         $stmt2 = $db->query($sql2);
//         $users = $stmt2->fetchAll(PDO::FETCH_ASSOC);
//
//       }
//       catch(PDOException $e) {
//         echo json_encode($e->getMessage());
//       }
//     $test = json_encode($users);
//     if($test == '[]'){
//       return $response->write(json_encode(array("No teams found" => -2)));
//     }
//     else {
//       return $response->write('' . $test);
//     }
// });

$app->get('/teams/opponents/{team_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $team_id = $request->getAttribute('team_id');
    $users = '';
    $sql = 'SELECT u.username, u.user_id
            FROM users u,
            (SELECT d.user_id
              FROM team_participation d, (SELECT captain_id FROM teams WHERE `team_id` = :team_id) as t
              WHERE d.user_id = t.captain_id) as tp
            WHERE tp.user_id = u.user_id';

      try {
        $new = array();
        $newUsers = array();
        $array_loop = 0;
        $sql2 = 'SELECT team_id, team_name, team_color
                 FROM teams
                 WHERE team_id
                 NOT IN (SELECT DISTINCT t.team_id FROM team_participation t WHERE t.user_id IN
                   (SELECT DISTINCT u.user_id FROM users u, (SELECT user_id from team_participation tp
                     WHERE tp.team_id = "'.$team_id.'") as t WHERE t.user_id = u.user_id))';
        $stmt2 = $db->query($sql2);
        $teams = $stmt2->fetchAll(PDO::FETCH_OBJ);
        foreach($teams as $team){
          $new[$array_loop]['team_id'] = $team->team_id;
          $new[$array_loop]['team_name'] = $team->team_name;
          $new[$array_loop]['team_color'] = $team->team_color;
          $stmt = $db->prepare($sql);
          $stmt->bindParam(':team_id', $team->team_id);
          $stmt->execute();
          $captain = $stmt->fetch(PDO::FETCH_OBJ);
          $sql3 = 'SELECT u.user_id, u.username
                   FROM users u,
                      (SELECT * from team_participation
                       WHERE team_id = "'.$team->team_id.'") as t
                   WHERE t.user_id = u.user_id';
          $stmt3 = $db->query($sql3);
          $users = $stmt3->fetchAll(PDO::FETCH_OBJ);
          $new[$array_loop]['captain_id'] = $captain->user_id;
          $new[$array_loop]['captain_name'] = $captain->username;
          $new[$array_loop]['players'] = $users;
          $array_loop++;
        }

      }
      catch(PDOException $e) {
        echo json_encode($e->getMessage());
      }
    $test = json_encode($new, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No teams found" => -2)));
    }
    else {
      return $response->write('' . $test);
    }
});

$app->post('/challenge',
  function ($request, $response, $args){
    $body = $request->getBody();
    $decode = json_decode($body);
    $db = $this->dbConn;
    $strToReturn = '';

    $sql = 'INSERT INTO challenges (`task_name`, `start_date`, `end_date`, `to_team_id`, `from_team_id`, `repetitions`, `units`, `task_type`)
    VALUES (:task_name, :start_date, :end_date, :to_team_id, :from_team_id, :repetitions, :units, :task_type)';
    try {
      $stmt = $db->prepare($sql);
        $stmt->bindParam(':task_name', $decode->task_name);
        $stmt->bindParam(':start_date', $decode->start_date);
        $stmt->bindParam(':end_date', $decode->end_date);
        $stmt->bindParam(':to_team_id', $decode->to_team_id);
        $stmt->bindParam(':from_team_id', $decode->from_team_id);
        $stmt->bindParam(':repetitions', $decode->repetitions);
        $stmt->bindParam(':units', $decode->units);
        $stmt->bindParam(':task_type', $decode->task_type);
        $stmt->execute();
        $challenge_id = $db->lastInsertId();
    }

    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    $repetitions = 0;
    $sql2 = 'INSERT INTO challenge_progress (`team_id`, `challenge_id`, `exercise_name`, `repetitions`, `units`, `created`)
             VALUES (:team_id, :challenge_id, :exercise_name, :repetitions, :units, UTC_TIMESTAMP())';
    try {
      $stmt = $db->prepare($sql2);
        $stmt->bindParam(':team_id', $decode->to_team_id);
        $stmt->bindParam(':challenge_id', $challenge_id);
        $stmt->bindParam(':exercise_name', $decode->task_name);
        $stmt->bindParam(':repetitions', $repetitions);
        $stmt->bindParam(':units', $decode->units);
        $stmt->execute();
    }

    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    $sql3 = 'INSERT INTO challenge_progress (`team_id`, `challenge_id`, `exercise_name`, `repetitions`, `units`, `created`)
    VALUES (:team_id, :challenge_id, :exercise_name, :repetitions, :units, UTC_TIMESTAMP())';
    try {
      $stmt = $db->prepare($sql3);
        $stmt->bindParam(':team_id', $decode->from_team_id);
        $stmt->bindParam(':challenge_id', $challenge_id);
        $stmt->bindParam(':exercise_name', $decode->task_name);
        $stmt->bindParam(':repetitions', $repetitions);
        $stmt->bindParam(':units', $decode->units);
        $stmt->execute();
    }

    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    //Need to find a way to return team_id
    //return $response->write('Successfully added exercise ' . $exercise_id);
    return $response->write(json_encode(array("challenge_id" => $challenge_id)));
  }
);

//NEED TO TEST
$app->delete('/challenge/{challenge_id}',
  function ($request, $response, $args){ $db = $this->dbConn;
    $strToReturn = '';
    $challenge_id = $request->getAttribute('challenge_id');

    foreach($db->query('SELECT *
                        FROM challenges
                        WHERE challenge_id = "'.$challenge_id.'"') as $row){
      $strToReturn .= '<br /> challenge_id: ' . $row['challenge_id'] .' <br /> task_name: ' . $row['task_name'];
    }

    $db->query('DELETE FROM challenges WHERE challenge_id = "'.$challenge_id.'"');

    return $response->write('Deleting <br />' . $strToReturn);
  }

);


//GOOD BUT DO WE NEED AN ARRAY??
$app->get('/challenge',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $challenges = '';
    $sql = 'SELECT challenge_id, task_name, end_date, to_team_id, from_team_id
            FROM challenges WHERE end_date >= CURDATE() AND status = "OPEN" ORDER BY end_date ASC';
    try {
      $stmt = $db->query($sql);
      $challenges = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    $test = json_encode($challenges, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No current challenges found" => -5)));
    }
    else {
      return $response->write('' . $test);
    }
});

$app->get('/challenge/{challenge_id}',
  function ($request, $response, $args){
    $body = $request->getBody();
    $decode = json_decode($body);
    $challenge_id = $request->getAttribute('challenge_id');
    $db = $this->dbConn;

    $sql = 'SELECT * FROM challenges WHERE challenge_id = "'.$challenge_id.'"';

    try {
      $stmt = $db->query($sql);
      $challenge = $stmt -> fetchALL(PDO::FETCH_OBJ);
    }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($challenge, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No current challenges found" => -5)));
    }
    else {
      return $response->write('' . $test);
    }
  }
);

//GOOD
$app->get('/team_challenges/{team_id}',
  function ($request, $response, $args){
    $new = array();
    $final = array();
    $final_loop = 0;
    $array_loop = 0;
    $db = $this->dbConn;
    $strToReturn = '';
    $team_id = $request->getAttribute('team_id');
    $challenges = '';

    $sql = 'SELECT challenge_id, task_name, start_date, end_date, repetitions, units, task_type, status, to_team_id, from_team_id from challenges WHERE (to_team_id = ' . $team_id . ' OR from_team_id = ' . $team_id . ') AND end_date >= CURDATE() AND status = "OPEN" ORDER BY end_date ASC';
    $sql2 = 'SELECT team_name, team_color FROM teams WHERE `team_id` = :team_id';
    $sql3 = 'SELECT repetitions FROM challenge_progress WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
    $sql4 = 'SELECT u.user_id, u.username FROM users u, (SELECT * from team_participation WHERE `team_id` = :team_id) as t WHERE t.user_id = u.user_id';
    $sql5 = 'SELECT sum(repetitions) as reps FROM individual_progress WHERE  `user_id` = :user_id AND `challenge_id` = :challenge_id';

    try {
      $stmt = $db->query($sql);
      $stmt->execute();
      $challenges = $stmt->fetchAll(PDO::FETCH_OBJ);
      foreach($challenges as $challenge){
        $final[$final_loop]['challenge_id'] = $challenge->challenge_id;
        $final[$final_loop]['task_name'] = $challenge->task_name;
        $final[$final_loop]['start_date'] = $challenge->start_date;
        $final[$final_loop]['end_date'] = $challenge->end_date;
        $final[$final_loop]['repetitions'] = $challenge->repetitions;
        $final[$final_loop]['units'] = $challenge->units;
        $final[$final_loop]['task_type'] = $challenge->task_type;
        $final[$final_loop]['status'] = $challenge->status;
        if($team_id == $challenge->to_team_id){
          $final[$final_loop]['user_team']['team_id'] = $team_id;
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam(':team_id', $team_id);
            $stmt2->execute();
            $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
          $final[$final_loop]['user_team']['team_name'] = $team_name->team_name;
          $final[$final_loop]['user_team']['team_color'] = $team_name->team_color;
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
            $stmt3->bindParam(':team_id', $team_id);
            $stmt3->execute();
            $progress = $stmt3->fetch(PDO::FETCH_OBJ);
          $final[$final_loop]['user_team']['team_progress'] = $progress->repetitions;
            $stmt4 = $db->prepare($sql4);
            $stmt4->bindParam(':team_id', $team_id);
            $stmt4->execute();
            $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
            foreach ($players as $player){
              $new[$array_loop]['user_id'] = $player->user_id;
              $new[$array_loop]['username'] = $player->username;
                $stmt5 = $db->prepare($sql5);
                $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt5->bindParam(':user_id', $player->user_id);
                $stmt5->execute();
                $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                if($playerProgress->reps != null){
                  $new[$array_loop]['user_progress'] = $playerProgress->reps;
                }
                else{
                  $new[$array_loop]['user_progress'] = 0;
                }
              $array_loop++;
            }
            $array_loop = 0;
            $new1 = array();
            $final[$final_loop]['user_team']['players'] = $new;
            $final[$final_loop]['oppo_team']['team_id'] = $challenge->from_team_id;
              $stmt2 = $db->prepare($sql2);
              $stmt2->bindParam(':team_id', $challenge->from_team_id);
              $stmt2->execute();
              $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
            $final[$final_loop]['oppo_team']['team_name'] = $team_name->team_name;
            $final[$final_loop]['oppo_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->from_team_id);
              $stmt3->execute();
              $progress = $stmt3->fetch(PDO::FETCH_OBJ);
            $final[$final_loop]['oppo_team']['team_progress'] = $progress->repetitions;
              $stmt4 = $db->prepare($sql4);
              $stmt4->bindParam(':team_id', $challenge->from_team_id);
              $stmt4->execute();
              $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
              foreach ($players as $player){
                $new1[$array_loop]['user_id'] = $player->user_id;
                $new1[$array_loop]['username'] = $player->username;
                  $stmt5 = $db->prepare($sql5);
                  $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                  $stmt5->bindParam(':user_id', $player->user_id);
                  $stmt5->execute();
                  $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                  if($playerProgress->reps != null){
                    $new1[$array_loop]['user_progress'] = $playerProgress->reps;
                  }
                  else{
                    $new1[$array_loop]['user_progress'] = 0;
                  }
                  $array_loop++;
              }
              $final[$final_loop]['oppo_team']['players'] = $new1;
        }
        else{
          $final[$final_loop]['user_team']['team_id'] = $challenge->from_team_id;
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam(':team_id', $challenge->from_team_id);
            $stmt2->execute();
            $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
          $final[$final_loop]['user_team']['team_name'] = $team_name->team_name;
          $final[$final_loop]['user_team']['team_color'] = $team_name->team_color;
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
            $stmt3->bindParam(':team_id', $challenge->from_team_id);
            $stmt3->execute();
            $progress = $stmt3->fetch(PDO::FETCH_OBJ);
          $final[$final_loop]['user_team']['team_progress'] = $progress->repetitions;
            $stmt4 = $db->prepare($sql4);
            $stmt4->bindParam(':team_id', $challenge->from_team_id);
            $stmt4->execute();
            $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
            foreach ($players as $player){
              $new[$array_loop]['user_id'] = $player->user_id;
              $new[$array_loop]['username'] = $player->username;
                $stmt5 = $db->prepare($sql5);
                $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt5->bindParam(':user_id', $player->user_id);
                $stmt5->execute();
                $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                if($playerProgress->reps != null){
                  $new[$array_loop]['user_progress'] = $playerProgress->reps;
                }
                else{
                  $new[$array_loop]['user_progress'] = 0;
                }
                $array_loop++;
            }
            $final[$final_loop]['user_team']['players'] = $new;
            $new1 = array();
            $array_loop = 0;
            $final[$final_loop]['oppo_team']['team_id'] = $challenge->to_team_id;
              $stmt2 = $db->prepare($sql2);
              $stmt2->bindParam(':team_id', $challenge->to_team_id);
              $stmt2->execute();
              $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
            $final[$final_loop]['oppo_team']['team_name'] = $team_name->team_name;
            $final[$final_loop]['oppo_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->to_team_id);
              $stmt3->execute();
              $progress = $stmt3->fetch(PDO::FETCH_OBJ);
            $final[$final_loop]['oppo_team']['team_progress'] = $progress->repetitions;
              $stmt4 = $db->prepare($sql4);
              $stmt4->bindParam(':team_id', $challenge->to_team_id);
              $stmt4->execute();
              $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
              foreach ($players as $player){
                $new1[$array_loop]['user_id'] = $player->user_id;
                $new1[$array_loop]['username'] = $player->username;
                  $stmt5 = $db->prepare($sql5);
                  $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                  $stmt5->bindParam(':user_id', $player->user_id);
                  $stmt5->execute();
                  $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                  if($playerProgress->reps != null){
                    $new1[$array_loop]['user_progress'] = $playerProgress->reps;
                  }
                  else{
                    $new1[$array_loop]['user_progress'] = 0;
                  }
                  $array_loop++;
              }
              $final[$final_loop]['oppo_team']['players'] = $new1;
        }
        $final_loop++;
      }
    }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($final, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No current challenges found" => -5)));
    }
    else {
      return $response->write('' . $test);
    }
});

$app->get('/past_team_challenges/{team_id}',
  function ($request, $response, $args){
    $new = array();
    $final = array();
    $final_loop = 0;
    $array_loop = 0;
    $db = $this->dbConn;
    $strToReturn = '';
    $team_id = $request->getAttribute('team_id');
    $challenges = '';

    $sql = 'SELECT challenge_id, task_name, start_date, end_date, repetitions, units, task_type, status, to_team_id, from_team_id from challenges WHERE (to_team_id = ' . $team_id . ' OR from_team_id = ' . $team_id . ') AND (end_date < CURDATE() OR status = "CLOSED") ORDER BY end_date ASC';
    $sql2 = 'SELECT team_name, team_color FROM teams WHERE `team_id` = :team_id';
    $sql3 = 'SELECT repetitions FROM challenge_progress WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
    $sql4 = 'SELECT u.user_id, u.username FROM users u, (SELECT * from team_participation WHERE `team_id` = :team_id) as t WHERE t.user_id = u.user_id';
    $sql5 = 'SELECT sum(repetitions) as reps FROM individual_progress WHERE  `user_id` = :user_id AND `challenge_id` = :challenge_id';

    try {
      $stmt = $db->query($sql);
      $stmt->execute();
      $challenges = $stmt->fetchAll(PDO::FETCH_OBJ);
      foreach($challenges as $challenge){
        $final[$final_loop]['challenge_id'] = $challenge->challenge_id;
        $final[$final_loop]['task_name'] = $challenge->task_name;
        $final[$final_loop]['start_date'] = $challenge->start_date;
        $final[$final_loop]['end_date'] = $challenge->end_date;
        $final[$final_loop]['repetitions'] = $challenge->repetitions;
        $final[$final_loop]['units'] = $challenge->units;
        $final[$final_loop]['task_type'] = $challenge->task_type;
        $final[$final_loop]['status'] = $challenge->status;
        if($team_id == $challenge->to_team_id){
          $final[$final_loop]['user_team']['team_id'] = $team_id;
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam(':team_id', $team_id);
            $stmt2->execute();
            $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
          $final[$final_loop]['user_team']['team_name'] = $team_name->team_name;
          $final[$final_loop]['user_team']['team_color'] = $team_name->team_color;
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
            $stmt3->bindParam(':team_id', $team_id);
            $stmt3->execute();
            $progress = $stmt3->fetch(PDO::FETCH_OBJ);
          $final[$final_loop]['user_team']['team_progress'] = $progress->repetitions;
            $stmt4 = $db->prepare($sql4);
            $stmt4->bindParam(':team_id', $team_id);
            $stmt4->execute();
            $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
            foreach ($players as $player){
              $new[$array_loop]['user_id'] = $player->user_id;
              $new[$array_loop]['username'] = $player->username;
                $stmt5 = $db->prepare($sql5);
                $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt5->bindParam(':user_id', $player->user_id);
                $stmt5->execute();
                $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                if($playerProgress->reps != null){
                  $new[$array_loop]['user_progress'] = $playerProgress->reps;
                }
                else{
                  $new[$array_loop]['user_progress'] = 0;
                }
              $array_loop++;
            }
            $new1 = array();
            $array_loop = 0;
            $final[$final_loop]['user_team']['players'] = $new;
            $final[$final_loop]['oppo_team']['team_id'] = $challenge->from_team_id;
              $stmt2 = $db->prepare($sql2);
              $stmt2->bindParam(':team_id', $challenge->from_team_id);
              $stmt2->execute();
              $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
            $final[$final_loop]['oppo_team']['team_name'] = $team_name->team_name;
            $final[$final_loop]['oppo_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->from_team_id);
              $stmt3->execute();
              $progress = $stmt3->fetch(PDO::FETCH_OBJ);
            $final[$final_loop]['oppo_team']['team_progress'] = $progress->repetitions;
              $stmt4 = $db->prepare($sql4);
              $stmt4->bindParam(':team_id', $challenge->from_team_id);
              $stmt4->execute();
              $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
              foreach ($players as $player){
                $new1[$array_loop]['user_id'] = $player->user_id;
                $new1[$array_loop]['username'] = $player->username;
                  $stmt5 = $db->prepare($sql5);
                  $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                  $stmt5->bindParam(':user_id', $player->user_id);
                  $stmt5->execute();
                  $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                  if($playerProgress->reps != null){
                    $new1[$array_loop]['user_progress'] = $playerProgress->reps;
                  }
                  else{
                    $new1[$array_loop]['user_progress'] = 0;
                  }
                  $array_loop++;
              }
              $final[$final_loop]['oppo_team']['players'] = $new1;
        }
        else{
          $final[$final_loop]['user_team']['team_id'] = $challenge->from_team_id;
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam(':team_id', $challenge->from_team_id);
            $stmt2->execute();
            $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
          $final[$final_loop]['user_team']['team_name'] = $team_name->team_name;
          $final[$final_loop]['user_team']['team_color'] = $team_name->team_color;
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
            $stmt3->bindParam(':team_id', $challenge->from_team_id);
            $stmt3->execute();
            $progress = $stmt3->fetch(PDO::FETCH_OBJ);
          $final[$final_loop]['user_team']['team_progress'] = $progress->repetitions;
            $stmt4 = $db->prepare($sql4);
            $stmt4->bindParam(':team_id', $challenge->from_team_id);
            $stmt4->execute();
            $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
            foreach ($players as $player){
              $new[$array_loop]['user_id'] = $player->user_id;
              $new[$array_loop]['username'] = $player->username;
                $stmt5 = $db->prepare($sql5);
                $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt5->bindParam(':user_id', $player->user_id);
                $stmt5->execute();
                $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                if($playerProgress->reps != null){
                  $new[$array_loop]['user_progress'] = $playerProgress->reps;
                }
                else{
                  $new[$array_loop]['user_progress'] = 0;
                }
                $array_loop++;
            }
            $final[$final_loop]['user_team']['players'] = $new;
            $array_loop = 0;
            $new1 = array();
            $final[$final_loop]['oppo_team']['team_id'] = $challenge->to_team_id;
              $stmt2 = $db->prepare($sql2);
              $stmt2->bindParam(':team_id', $challenge->to_team_id);
              $stmt2->execute();
              $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
            $final[$final_loop]['oppo_team']['team_name'] = $team_name->team_name;
            $final[$final_loop]['oppo_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->to_team_id);
              $stmt3->execute();
              $progress = $stmt3->fetch(PDO::FETCH_OBJ);
            $final[$final_loop]['oppo_team']['team_progress'] = $progress->repetitions;
              $stmt4 = $db->prepare($sql4);
              $stmt4->bindParam(':team_id', $challenge->to_team_id);
              $stmt4->execute();
              $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
              foreach ($players as $player){
                $new1[$array_loop]['user_id'] = $player->user_id;
                $new1[$array_loop]['username'] = $player->username;
                  $stmt5 = $db->prepare($sql5);
                  $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                  $stmt5->bindParam(':user_id', $player->user_id);
                  $stmt5->execute();
                  $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                  if($playerProgress->reps != null){
                    $new1[$array_loop]['user_progress'] = $playerProgress->reps;
                  }
                  else{
                    $new1[$array_loop]['user_progress'] = 0;
                  }
                  $array_loop++;
              }
              $final[$final_loop]['oppo_team']['players'] = $new1;
        }
        $final_loop++;
      }
    }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($final, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No current challenges found" => -5)));
    }
    else {
      return $response->write('' . $test);
    }
});


$app->get('/challenges/user_id/{user_id}',
  function ($request, $response, $args){
    $new = array();
    $array_loop = 0;
    $db = $this->dbConn;
    $strToReturn = '';
    $user_id = $request->getAttribute('user_id');
    $team_id = '';
    $challenges = '';

    $sql = 'SELECT team_id FROM team_participation WHERE user_id = '. $user_id;
    $sql2 = 'SELECT * FROM challenges WHERE (to_team_id = :team_id OR from_team_id = :team_id) AND end_date >= CURDATE() AND status = "OPEN" ORDER BY end_date ASC';
    $sql3 = 'SELECT repetitions FROM challenge_progress WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
    $sql4 = 'SELECT sum(repetitions) as reps FROM individual_progress WHERE `challenge_id` = :challenge_id AND `user_id` = :user_id';
    $sql5 = 'SELECT team_name, team_color FROM teams WHERE `team_id` = :team_id';
    $sql6 = 'SELECT u.user_id, u.username FROM users u, (SELECT * from team_participation WHERE `team_id` = :team_id) as t WHERE t.user_id = u.user_id';

    try {
      $stmt = $db->query($sql);
      $teams = $stmt->fetchAll(PDO::FETCH_OBJ);
      foreach($teams as $team){
        $team_id = $team->team_id;
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(':team_id', $team_id);
        $stmt2->execute();
        $challenges = $stmt2->fetchAll(PDO::FETCH_OBJ);
        foreach($challenges as $challenge){
          $new[$array_loop]['challenge_id'] = $challenge->challenge_id;
          $new[$array_loop]['task_name'] = $challenge->task_name;
          $new[$array_loop]['start_date'] = $challenge->start_date;
          $new[$array_loop]['end_date'] = $challenge->end_date;
          $new[$array_loop]['repetitions'] = $challenge->repetitions;
          $new[$array_loop]['units'] = $challenge->units;
          $new[$array_loop]['task_type'] = $challenge->task_type;
            $stmt4 = $db->prepare($sql4);
            $stmt4->bindParam(':challenge_id', $challenge->challenge_id);
            $stmt4->bindParam(':user_id', $user_id);
            $stmt4->execute();
            $indiProgress = $stmt4->fetch(PDO::FETCH_OBJ);
          $new[$array_loop]['user_progress'] = $indiProgress->reps;
          if($team_id == $challenge->to_team_id){
            $new[$array_loop]['user_team']['team_id'] = $challenge->to_team_id;
              $stmt5 = $db->prepare($sql5);
              $stmt5->bindParam(':team_id', $challenge->to_team_id);
              $stmt5->execute();
              $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_team']['team_name'] = $team_name->team_name;
            $new[$array_loop]['user_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->to_team_id);
              $stmt3->execute();
              $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_team']['team_progress'] = $teamProgress->repetitions;
              $stmt6 = $db->prepare($sql6);
              $stmt6->bindParam(':team_id', $challenge->to_team_id);
              $stmt6->execute();
              $players = $stmt6->fetchAll(PDO::FETCH_OBJ);
              $newP = array();
              $playerCount = 0;
              foreach ($players as $player){
                $newP[$playerCount]['user_id'] = $player->user_id;
                $newP[$playerCount]['username'] = $player->username;
                $playerCount++;
              }
            $new[$array_loop]['user_team']['players'] = $newP;
            $new[$array_loop]['oppo_team']['team_id'] = $challenge->from_team_id;
              $stmt5 = $db->prepare($sql5);
              $stmt5->bindParam(':team_id', $challenge->from_team_id);
              $stmt5->execute();
              $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['oppo_team']['team_name'] = $team_name->team_name;
            $new[$array_loop]['oppo_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->from_team_id);
              $stmt3->execute();
              $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['oppo_team']['team_progress'] = $teamProgress->repetitions;
              $stmt6 = $db->prepare($sql6);
              $stmt6->bindParam(':team_id', $challenge->from_team_id);
              $stmt6->execute();
              $players = $stmt6->fetchAll(PDO::FETCH_OBJ);
              $newP = array();
              $playerCount = 0;
              foreach ($players as $player){
                $newP[$playerCount]['user_id'] = $player->user_id;
                $newP[$playerCount]['username'] = $player->username;
                $playerCount++;
              }
            $new[$array_loop]['oppo_team']['players'] = $newP;
          }
          else{
            $new[$array_loop]['user_team']['team_id'] = $challenge->from_team_id;
              $stmt5 = $db->prepare($sql5);
              $stmt5->bindParam(':team_id', $challenge->from_team_id);
              $stmt5->execute();
              $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_team']['team_name'] = $team_name->team_name;
            $new[$array_loop]['user_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->from_team_id);
              $stmt3->execute();
              $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_team']['team_progress'] = $teamProgress->repetitions;
              $stmt6 = $db->prepare($sql6);
              $stmt6->bindParam(':team_id', $challenge->from_team_id);
              $stmt6->execute();
              $players = $stmt6->fetchAll(PDO::FETCH_OBJ);
              $newP = array();
              $playerCount = 0;
              foreach ($players as $player){
                $newP[$playerCount]['user_id'] = $player->user_id;
                $newP[$playerCount]['username'] = $player->username;
                $playerCount++;
              }
            $new[$array_loop]['user_team']['players'] = $newP;
            $new[$array_loop]['oppo_team']['team_id'] = $challenge->to_team_id;
              $stmt5 = $db->prepare($sql5);
              $stmt5->bindParam(':team_id', $challenge->to_team_id);
              $stmt5->execute();
              $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['oppo_team']['team_name'] = $team_name->team_name;
            $new[$array_loop]['oppo_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->to_team_id);
              $stmt3->execute();
              $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['oppo_team']['team_progress'] = $teamProgress->repetitions;
              $stmt6 = $db->prepare($sql6);
              $stmt6->bindParam(':team_id', $challenge->to_team_id);
              $stmt6->execute();
              $players = $stmt6->fetchAll(PDO::FETCH_OBJ);
              $newP = array();
              $playerCount = 0;
              foreach ($players as $player){
                $newP[$playerCount]['user_id'] = $player->user_id;
                $newP[$playerCount]['username'] = $player->username;
                $playerCount++;
              }
            $new[$array_loop]['oppo_team']['players'] = $newP;
          }
          $array_loop++;
        }
      }
    }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($new, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No current challenges found" => -5)));
    }
    else {
      return $response->write('' . $test);
    }
  }
);

$app->get('/past_challenges/user_id/{user_id}',
  function ($request, $response, $args){
    $new = array();
    $array_loop = 0;
    $db = $this->dbConn;
    $strToReturn = '';
    $user_id = $request->getAttribute('user_id');
    $team_id = '';
    $challenges = '';

    $sql = 'SELECT team_id FROM team_participation WHERE user_id = '. $user_id;
    $sql2 = 'SELECT * FROM challenges WHERE (to_team_id = :team_id OR from_team_id = :team_id) AND (end_date <= CURDATE() OR status = "CLOSED") ORDER BY end_date ASC';
    $sql3 = 'SELECT repetitions FROM challenge_progress WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
    $sql4 = 'SELECT sum(repetitions) as reps FROM individual_progress WHERE `challenge_id` = :challenge_id AND `user_id` = :user_id';
    $sql5 = 'SELECT team_name, team_color FROM teams WHERE `team_id` = :team_id';
    $sql6 = 'SELECT u.user_id, u.username FROM users u, (SELECT * from team_participation WHERE `team_id` = :team_id) as t WHERE t.user_id = u.user_id';

    try {
      $stmt = $db->query($sql);
      $teams = $stmt->fetchAll(PDO::FETCH_OBJ);
      foreach($teams as $team){
        $team_id = $team->team_id;
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(':team_id', $team_id);
        $stmt2->execute();
        $challenges = $stmt2->fetchAll(PDO::FETCH_OBJ);
        foreach($challenges as $challenge){
          $new[$array_loop]['challenge_id'] = $challenge->challenge_id;
          $new[$array_loop]['task_name'] = $challenge->task_name;
          $new[$array_loop]['start_date'] = $challenge->start_date;
          $new[$array_loop]['end_date'] = $challenge->end_date;
          $new[$array_loop]['repetitions'] = $challenge->repetitions;
          $new[$array_loop]['units'] = $challenge->units;
          $new[$array_loop]['task_type'] = $challenge->task_type;
            $stmt4 = $db->prepare($sql4);
            $stmt4->bindParam(':challenge_id', $challenge->challenge_id);
            $stmt4->bindParam(':user_id', $user_id);
            $stmt4->execute();
            $indiProgress = $stmt4->fetch(PDO::FETCH_OBJ);
          $new[$array_loop]['user_progress'] = $indiProgress->reps;
          if($team_id == $challenge->to_team_id){
            $new[$array_loop]['user_team']['team_id'] = $challenge->to_team_id;
              $stmt5 = $db->prepare($sql5);
              $stmt5->bindParam(':team_id', $challenge->to_team_id);
              $stmt5->execute();
              $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_team']['team_name'] = $team_name->team_name;
            $new[$array_loop]['user_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->to_team_id);
              $stmt3->execute();
              $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_team']['team_progress'] = $teamProgress->repetitions;
              $stmt6 = $db->prepare($sql6);
              $stmt6->bindParam(':team_id', $challenge->to_team_id);
              $stmt6->execute();
              $players = $stmt6->fetchAll(PDO::FETCH_OBJ);
              $newP = array();
              $playerCount = 0;
              foreach ($players as $player){
                $newP[$playerCount]['user_id'] = $player->user_id;
                $newP[$playerCount]['username'] = $player->username;
                $playerCount++;
              }
            $new[$array_loop]['user_team']['players'] = $newP;
            $new[$array_loop]['oppo_team']['team_id'] = $challenge->from_team_id;
              $stmt5 = $db->prepare($sql5);
              $stmt5->bindParam(':team_id', $challenge->from_team_id);
              $stmt5->execute();
              $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['oppo_team']['team_name'] = $team_name->team_name;
            $new[$array_loop]['oppo_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->from_team_id);
              $stmt3->execute();
              $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['oppo_team']['team_progress'] = $teamProgress->repetitions;
              $stmt6 = $db->prepare($sql6);
              $stmt6->bindParam(':team_id', $challenge->from_team_id);
              $stmt6->execute();
              $players = $stmt6->fetchAll(PDO::FETCH_OBJ);
              $newP = array();
              $playerCount = 0;
              foreach ($players as $player){
                $newP[$playerCount]['user_id'] = $player->user_id;
                $newP[$playerCount]['username'] = $player->username;
                $playerCount++;
              }
            $new[$array_loop]['oppo_team']['players'] = $newP;
          }
          else{
            $new[$array_loop]['user_team']['team_id'] = $challenge->from_team_id;
              $stmt5 = $db->prepare($sql5);
              $stmt5->bindParam(':team_id', $challenge->from_team_id);
              $stmt5->execute();
              $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_team']['team_name'] = $team_name->team_name;
            $new[$array_loop]['user_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->from_team_id);
              $stmt3->execute();
              $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_team']['team_progress'] = $teamProgress->repetitions;
              $stmt6 = $db->prepare($sql6);
              $stmt6->bindParam(':team_id', $challenge->from_team_id);
              $stmt6->execute();
              $players = $stmt6->fetchAll(PDO::FETCH_OBJ);
              $newP = array();
              $playerCount = 0;
              foreach ($players as $player){
                $newP[$playerCount]['user_id'] = $player->user_id;
                $newP[$playerCount]['username'] = $player->username;
                $playerCount++;
              }
            $new[$array_loop]['user_team']['players'] = $newP;
            $new[$array_loop]['oppo_team']['team_id'] = $challenge->to_team_id;
              $stmt5 = $db->prepare($sql5);
              $stmt5->bindParam(':team_id', $challenge->to_team_id);
              $stmt5->execute();
              $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['oppo_team']['team_name'] = $team_name->team_name;
            $new[$array_loop]['oppo_team']['team_color'] = $team_name->team_color;
              $stmt3 = $db->prepare($sql3);
              $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt3->bindParam(':team_id', $challenge->to_team_id);
              $stmt3->execute();
              $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['oppo_team']['team_progress'] = $teamProgress->repetitions;
              $stmt6 = $db->prepare($sql6);
              $stmt6->bindParam(':team_id', $challenge->to_team_id);
              $stmt6->execute();
              $players = $stmt6->fetchAll(PDO::FETCH_OBJ);
              $newP = array();
              $playerCount = 0;
              foreach ($players as $player){
                $newP[$playerCount]['user_id'] = $player->user_id;
                $newP[$playerCount]['username'] = $player->username;
                $playerCount++;
              }
            $new[$array_loop]['oppo_team']['players'] = $newP;
          }
          $array_loop++;
        }
      }
    }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($new, JSON_PRETTY_PRINT);
    if($test == '[]'){
      return $response->write(json_encode(array("No current challenges found" => -5)));
    }
    else {
      return $response->write('' . $test);
    }
  }
);

$app->get('/challenges/exercise_id/{exercise_id}',
    function ($request, $response, $args){
      $db = $this->dbConn;
      $new = array();
      $array_loop = 0;
      $exercise_id = $request->getAttribute('exercise_id');

      $sql6 = 'SELECT user_id FROM exercises WHERE `exercise_id` = :exercise_id';
        $stmt6 = $db->prepare($sql6);
        $stmt6->bindParam(':exercise_id', $exercise_id);
        $stmt6->execute();
        $user_id = $stmt6->fetch(PDO::FETCH_OBJ);
      $sql8 = 'SELECT DISTINCT challenge_id, team_id FROM individual_progress WHERE `user_id` = :user_id AND `exercise_id` = :exercise_id';
      $sql = 'SELECT team_id FROM team_participation WHERE user_id = '. $user_id->user_id;
      $sql2 = 'SELECT * FROM challenges WHERE `challenge_id` = :challenge_id';
      $sql3 = 'SELECT repetitions FROM challenge_progress WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
      $sql4 = 'SELECT sum(repetitions) as reps FROM individual_progress WHERE `challenge_id` = :challenge_id AND `user_id` = :user_id';
      $sql5 = 'SELECT team_name, team_color FROM teams WHERE `team_id` = :team_id';
      $sql7 = 'SELECT count(user_id) as count FROM team_participation WHERE `team_id` = :team_id';
      $sql9 = 'SELECT repetitions FROM individual_progress WHERE  `user_id` = :user_id AND `challenge_id` = :challenge_id AND `exercise_id` = :exercise_id';

      try {
        $stmt8 = $db->prepare($sql8);
        $stmt8->bindParam(':user_id', $user_id->user_id);
        $stmt8->bindParam(':exercise_id', $exercise_id);
        $stmt8->execute();
        $challenge_ids = $stmt8->fetchAll(PDO::FETCH_OBJ);
        foreach($challenge_ids as $challenge_id){
          $stmt2 = $db->prepare($sql2);
          $stmt2->bindParam(':challenge_id', $challenge_id->challenge_id);
          $stmt2->execute();
          $challenges = $stmt2->fetchAll(PDO::FETCH_OBJ);
          foreach($challenges as $challenge){
            if($challenge->to_team_id == $challenge_id->team_id){
              $oppo_team_id = $challenge->from_team_id;
            }
            else{
              $oppo_team_id = $challenge->to_team_id;
            }
            $new[$array_loop]['challenge_id'] = $challenge->challenge_id;
            $new[$array_loop]['task_name'] = $challenge->task_name;
            $new[$array_loop]['start_date'] = $challenge->start_date;
            $new[$array_loop]['end_date'] = $challenge->end_date;
            $new[$array_loop]['repetitions'] = $challenge->repetitions;
            $new[$array_loop]['units'] = $challenge->units;
            $new[$array_loop]['task_type'] = $challenge->task_type;
              $stmt4 = $db->prepare($sql4);
              $stmt4->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt4->bindParam(':user_id', $user_id->user_id);
              $stmt4->execute();
              $indiProgress = $stmt4->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['user_progress'] = $indiProgress->reps;
              $stmt9 = $db->prepare($sql9);
              $stmt9->bindParam(':challenge_id', $challenge->challenge_id);
              $stmt9->bindParam(':user_id', $user_id->user_id);
              $stmt9->bindParam(':exercise_id', $exercise_id);
              $stmt9->execute();
              $indiChalProg = $stmt9->fetch(PDO::FETCH_OBJ);
            $new[$array_loop]['exercise_progress'] = $indiChalProg->repetitions;
            $new[$array_loop]['user_team']['team_id'] = $challenge_id->team_id;
                $stmt5 = $db->prepare($sql5);
                $stmt5->bindParam(':team_id', $challenge_id->team_id);
                $stmt5->execute();
                $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
              $new[$array_loop]['user_team']['team_name'] = $team_name->team_name;
              $new[$array_loop]['user_team']['team_color'] = $team_name->team_color;
                $stmt3 = $db->prepare($sql3);
                $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt3->bindParam(':team_id', $challenge_id->team_id);
                $stmt3->execute();
                $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
              $new[$array_loop]['user_team']['team_progress'] = $teamProgress->repetitions;
                $stmt7 = $db->prepare($sql7);
                $stmt7->bindParam(':team_id', $challenge_id->team_id);
                $stmt7->execute();
                $teamMember = $stmt7->fetch(PDO::FETCH_OBJ);
              $new[$array_loop]['user_team']['num_members'] = $teamMember->count;
              $new[$array_loop]['oppo_team']['team_id'] = $oppo_team_id;
                $stmt5 = $db->prepare($sql5);
                $stmt5->bindParam(':team_id', $oppo_team_id);
                $stmt5->execute();
                $team_name = $stmt5->fetch(PDO::FETCH_OBJ);
              $new[$array_loop]['oppo_team']['team_name'] = $team_name->team_name;
              $new[$array_loop]['oppo_team']['team_color'] = $team_name->team_color;
                $stmt3 = $db->prepare($sql3);
                $stmt3->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt3->bindParam(':team_id', $oppo_team_id);
                $stmt3->execute();
                $teamProgress = $stmt3->fetch(PDO::FETCH_OBJ);
              $new[$array_loop]['oppo_team']['team_progress'] = $teamProgress->repetitions;
                $stmt7 = $db->prepare($sql7);
                $stmt7->bindParam(':team_id', $oppo_team_id);
                $stmt7->execute();
                $teamMember = $stmt7->fetch(PDO::FETCH_OBJ);
              $new[$array_loop]['oppo_team']['num_members'] = $teamMember->count;
            $array_loop++;
          }
        }
      }
      catch(PDOException $e) {
        echo json_encode($e -> getMessage());
      }
      $test = json_encode($new, JSON_PRETTY_PRINT);
      if($test == '[]'){
        return $response->write(json_encode(array("No current challenges found" => -5)));
      }
      else {
        return $response->write('' . $test);
      }
});
$app->get('/challenges/search/{end_date}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $end_date = $request->getAttribute('end_date');
    $challenges = '';

    $sql = 'SELECT * FROM challenges WHERE end_date = "'.$end_date.'" ORDER BY end_date ASC';

    try {
      $stmt = $db->query($sql);
      $challenges = $stmt -> fetchALL(PDO::FETCH_OBJ);
      }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($challenges, JSON_PRETTY_PRINT);
    return $response -> write('' . $test);
});

$app->get('/challenge_progress/{challenge_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $final = array();
    $new = [];
    $array_loop = 0;
    $challenge_id = $request->getAttribute('challenge_id');
    $sql = 'SELECT to_team_id, from_team_id, status FROM challenges WHERE `challenge_id` = :challenge_id';
    $sql2 = 'SELECT team_name, team_color, avatar, captain_id FROM teams WHERE `team_id` = :team_id';
    $sql3 = 'SELECT repetitions, status FROM challenge_progress WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
    $sql4 = 'SELECT u.user_id, u.username FROM users u, (SELECT * from team_participation WHERE `team_id` = :team_id) as t WHERE t.user_id = u.user_id';
    $sql5 = 'SELECT sum(repetitions) as reps FROM individual_progress WHERE  `user_id` = :user_id AND `challenge_id` = :challenge_id';
    $sql10 = 'SELECT * FROM individual_progress WHERE `user_id` = :user_id AND `challenge_id` = :challenge_id';

    try {
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':challenge_id', $challenge_id);
      $stmt->execute();
      $teams = $stmt->fetch(PDO::FETCH_OBJ);
      $final['challenge']['status'] = $teams->status;
      $final['user_team']['team_id'] = $teams->to_team_id;
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(':team_id', $teams->to_team_id);
        $stmt2->execute();
        $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
      $final['user_team']['team_name'] = $team_name->team_name;
      $final['user_team']['team_color'] = $team_name->team_color;
      $final['user_team']['team_avatar'] = $team_name->avatar;
      $final['user_team']['captain_id'] = $team_name->captain_id;
        $stmt3 = $db->prepare($sql3);
        $stmt3->bindParam(':challenge_id', $challenge_id);
        $stmt3->bindParam(':team_id', $teams->to_team_id);
        $stmt3->execute();
        $progress = $stmt3->fetch(PDO::FETCH_OBJ);
      $final['user_team']['team_progress'] = $progress->repetitions;
        $stmt4 = $db->prepare($sql4);
        $stmt4->bindParam(':team_id', $teams->to_team_id);
        $stmt4->execute();
        $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
        foreach ($players as $player){
          $new[$array_loop]['user_id'] = $player->user_id;
          $new[$array_loop]['username'] = $player->username;
            $stmt5 = $db->prepare($sql5);
            $stmt5->bindParam(':challenge_id', $challenge_id);
            $stmt5->bindParam(':user_id', $player->user_id);
            $stmt5->execute();
            $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
            if($playerProgress->reps != null){
              $new[$array_loop]['user_progress'] = $playerProgress->reps;
            }
            else{
              $new[$array_loop]['user_progress'] = 0;
            }
            $stmt10 = $db->prepare($sql10);
            $stmt10->bindParam(':challenge_id', $challenge_id);
            $stmt10->bindParam(':user_id', $player->user_id);
            $stmt10->execute();
            $exercises = $stmt10->fetchAll(PDO::FETCH_OBJ);
          $new[$array_loop]['user_exercises'] = $exercises;
          $array_loop++;
        }
      $array_loop = 0;
      $new1 = array();
      $final['user_team']['players'] = $new;
      $final['oppo_team']['team_id'] = $teams->from_team_id;
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(':team_id', $teams->from_team_id);
        $stmt2->execute();
        $team_name = $stmt2->fetch(PDO::FETCH_OBJ);
      $final['oppo_team']['team_name'] = $team_name->team_name;
      $final['oppo_team']['team_color'] = $team_name->team_color;
      $final['oppo_team']['team_avatar'] = $team_name->avatar;
      $final['oppo_team']['captain_id'] = $team_name->captain_id;
        $stmt3 = $db->prepare($sql3);
        $stmt3->bindParam(':challenge_id', $challenge_id);
        $stmt3->bindParam(':team_id', $teams->from_team_id);
        $stmt3->execute();
        $progress = $stmt3->fetch(PDO::FETCH_OBJ);
      $final['oppo_team']['team_progress'] = $progress->repetitions;
        $stmt4 = $db->prepare($sql4);
        $stmt4->bindParam(':team_id', $teams->from_team_id);
        $stmt4->execute();
        $players = $stmt4->fetchAll(PDO::FETCH_OBJ);
        foreach ($players as $player){
          $new1[$array_loop]['user_id'] = $player->user_id;
          $new1[$array_loop]['username'] = $player->username;
            $stmt5 = $db->prepare($sql5);
            $stmt5->bindParam(':challenge_id', $challenge_id);
            $stmt5->bindParam(':user_id', $player->user_id);
            $stmt5->execute();
            $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
            if($playerProgress->reps != null){
              $new1[$array_loop]['user_progress'] = $playerProgress->reps;
            }
            else{
              $new1[$array_loop]['user_progress'] = 0;
            }
              $stmt10 = $db->prepare($sql10);
              $stmt10->bindParam(':challenge_id', $challenge_id);
              $stmt10->bindParam(':user_id', $player->user_id);
              $stmt10->execute();
              $exercises = $stmt10->fetchAll(PDO::FETCH_OBJ);
            $new1[$array_loop]['user_exercises'] = $exercises;
            $array_loop++;
        }
        $final['oppo_team']['players'] = $new1;
    }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($final, JSON_PRETTY_PRINT);
    return $response -> write('' . $test);

});



//
//EXERCISE
//ENDPOINTS
//





$app->post('/exercise',
  function ($request, $response, $args){
    $body = $request->getBody();
    $decode = json_decode($body);
    $user_id =  $decode->user_id;
    $eRepetitions = $decode->repetitions;
    $eUnits = $decode->units;
    $db = $this->dbConn;
    $strToReturn = '';

    $sql = 'INSERT INTO exercises (`exercise_name`, `user_id`, `date_completed`, `repetitions`, `units`, `created`)
            VALUES (:exercise_name, :user_id, :date_completed, :repetitions, :units, UTC_TIMESTAMP())';
    try {
      $stmt = $db->prepare($sql);
        $stmt->bindParam(':exercise_name', $decode->exercise_name);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':date_completed', $decode->date_completed);
        $stmt->bindParam(':repetitions', $eRepetitions);
        $stmt->bindParam(':units', $decode->units);
        $stmt->execute();
        $exercise_id = $db->lastInsertId();
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }

    $teamsql = 'SELECT DISTINCT team_id
                FROM team_participation
                WHERE `user_id` = :user_id';
    try {
      $stmt = $db->prepare($teamsql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $teams = $stmt->fetchALL(PDO::FETCH_OBJ);
        foreach($teams as $team){
           $challengesql = 'SELECT challenge_id, to_team_id, from_team_id, units, repetitions, task_type
                      FROM challenges
                      WHERE (`status` = "OPEN")
                        AND (`to_team_id` = :team_id
                        OR `from_team_id` = :team_id)
                        AND `task_name` = :exercise_name
                        AND `start_date` <= :date_completed';
            $stmt = $db->prepare($challengesql);
            $stmt->bindParam(':team_id', $team->team_id);
            $stmt->bindParam(':exercise_name', $decode->exercise_name);
            $stmt->bindParam(':date_completed', $decode->date_completed);
            $stmt->execute();
            $challenges = $stmt->fetchALL(PDO::FETCH_OBJ);
            foreach($challenges as $challenge){
              $sql5 = 'SELECT sum(repetitions) as reps FROM individual_progress WHERE  `user_id` = :user_id AND `challenge_id` = :challenge_id';
                $stmt5 = $db->prepare($sql5);
                $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt5->bindParam(':user_id', $user_id);
                $stmt5->execute();
                $previousProgress = $stmt5->fetch(PDO::FETCH_OBJ);
              $cReps = $challenge->repetitions;
                if($eUnits != $challenge->units){
                  if($challenge->units == 'miles'){
                    if($eUnits == 'meters'){
                      $nRepetitions = $eRepetitions * 0.000621371;
                    }
                    else if($eUnits == 'kilometers'){
                      $nRepetitions = $eRepetitions * 0.621371;
                    }
                  }
                  else if($challenge->units == 'meters'){
                    if($eUnits == 'miles'){
                      $nRepetitions = $eRepetitions * 1609.34;
                    }
                    else if($eUnits == 'kilometers'){
                      $nRepetitions = $eRepetitions * 1000;
                    }
                  }
                  else if($challenge->units == 'kilometers'){
                    if($eUnits == 'miles'){
                      $nRepetitions = $eRepetitions * 1.60934;
                    }
                    else if($eUnits == 'meters'){
                      $nRepetitions = $eRepetitions * 0.001;
                    }
                  }
                }
                else{
                  $nRepetitions = $eRepetitions;
                }
              $indiProgress = 'INSERT INTO individual_progress (`team_id`, `user_id`, `challenge_id`, `exercise_id`, `exercise_name`, `repetitions`, `units`, `date_completed`, `created`)
                               VALUES (:team_id, :user_id, :challenge_id, :exercise_id, :exercise_name, :repetitions, :units, :date_completed, UTC_TIMESTAMP())';
              try {
                $stmt = $db->prepare($indiProgress);
                $stmt->bindParam(':team_id', $team->team_id);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt->bindParam(':exercise_id', $exercise_id);
                $stmt->bindParam(':exercise_name', $decode->exercise_name);
                $stmt->bindParam(':repetitions', $nRepetitions);
                $stmt->bindParam(':units', $challenge->units);
                $stmt->bindParam(':date_completed', $decode->date_completed);
                $stmt->execute();
              }
              catch(PDOException $e) {
                echo json_encode($e->getMessage());
              }
              $checkProgress = 'SELECT challenge_id, repetitions
                                FROM challenge_progress
                                WHERE `challenge_id` = :challenge_id
                                AND `team_id` = :team_id';
              try {
                $stmt = $db->prepare($checkProgress);
                $stmt->bindParam(':team_id', $team->team_id);
                $stmt->bindParam(':challenge_id', $challenge->challenge_id);
                $stmt->execute();
                $progress = $stmt->fetch(PDO::FETCH_OBJ);
              }
              catch(PDOException $e) {
                echo json_encode($e->getMessage());
              }
              if($progress){
                $pProgress = 0;
                // $users = 'SELECT user_id FROM team_progress WHERE `team_id` = :team_id AND user_id != :player';
                //   $stmt = $db->prepare($users);
                //   $stmt->bindParam(':team_id', $team->team_id);
                //   $stmt->bindParam(':player', $user_id);
                //   $stmt->execute();
                //   $u = $stmt->fetchAll(PDO::FETCH_OBJ);
                // $ppProgress = $stmt6->fetchAll(PDO::FETCH_OBJ);
                $sql6 = 'SELECT user_id, sum(repetitions) as reps FROM individual_progress WHERE `team_id` = :team_id AND `challenge_id` = :challenge_id AND user_id != :player GROUP BY user_id';
                  $stmt6 = $db->prepare($sql6);
                  $stmt6->bindParam(':team_id', $team->team_id);
                  $stmt6->bindParam(':player', $user_id);
                  $stmt6->bindParam(':challenge_id', $challenge->challenge_id);
                  $stmt6->execute();
                  $ppProgress = $stmt6->fetchAll(PDO::FETCH_OBJ);
                  foreach($ppProgress as $temp){
                    if($temp->reps >= $cReps){
                      $pProgress = $pProgress + $cReps;
                    }
                    else{
                      $pProgress =  $pProgress + $temp->reps;
                    }
                  }
                $sql5 = 'SELECT sum(repetitions) as reps FROM individual_progress WHERE  `user_id` = :user_id AND `challenge_id` = :challenge_id';
                  $stmt5 = $db->prepare($sql5);
                  $stmt5->bindParam(':challenge_id', $challenge->challenge_id);
                  $stmt5->bindParam(':user_id', $user_id);
                  $stmt5->execute();
                  $playerProgress = $stmt5->fetch(PDO::FETCH_OBJ);
                $progresssql = 'UPDATE challenge_progress SET repetitions = :repetitions WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
                try {
                  if($challenge->task_type == 'Individual' && $playerProgress->reps >= $cReps){
                    $newRepetitions = $cReps + $pProgress;
                  }
                  else{
                    $newRepetitions = $progress->repetitions + $nRepetitions;
                  }
                  $stmt = $db->prepare($progresssql);
                  $stmt->bindParam(':team_id', $team->team_id);
                  $stmt->bindParam(':challenge_id', $challenge->challenge_id);
                  $stmt->bindParam(':repetitions', $newRepetitions);
                  $stmt->execute();
                }
                catch(PDOException $e) {
                  echo json_encode($e->getMessage());
                }
                $getNumPlayers = 'SELECT count(user_id) as count_user FROM team_participation WHERE `team_id` = :team_id';
                  $stmt = $db->prepare($getNumPlayers);
                  $stmt->bindParam(':team_id', $team->team_id);
                  $stmt->execute();
                  $numPlayers = $stmt->fetch(PDO::FETCH_OBJ);
                $sqlW = 'UPDATE challenge_progress SET status = "WON" WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
                $sqlStat = 'UPDATE challenges SET status = "CLOSED" WHERE `challenge_id` = :challenge_id';
                $sqlL = 'UPDATE challenge_progress SET status = "LOST" WHERE `challenge_id` = :challenge_id AND `team_id` = :team_id';
                if($challenge->task_type == 'Individual' && $newRepetitions >= $challenge->repetitions * $numPlayers->count_user){
                  $sqlWin = $db->prepare($sqlW);
                  $sqlWin->bindParam(':team_id', $team->team_id);
                  $sqlWin->bindParam(':challenge_id', $challenge->challenge_id);
                  $sqlWin->execute();

                  $sqlLose = $db->prepare($sqlL);
                  $sqlLose->bindParam(':team_id', $challenge->from_team_id);
                  $sqlLose->bindParam(':challenge_id', $challenge->challenge_id);
                  $sqlLose->execute();

                  $sqlS = $db->prepare($sqlStat);
                  $sqlS->bindParam(':challenge_id', $challenge->challenge_id);
                  $sqlS->execute();
                }
                else if($challenge->task_type == 'Group' && $newRepetitions >= $challenge->repetitions){
                  $sqlWin = $db->prepare($sqlW);
                  $sqlWin->bindParam(':team_id', $team->team_id);
                  $sqlWin->bindParam(':challenge_id', $challenge->challenge_id);
                  $sqlWin->execute();

                  $sqlLose = $db->prepare($sqlL);
                  $sqlLose->bindParam(':team_id', $challenge->from_team_id);
                  $sqlLose->bindParam(':challenge_id', $challenge->challenge_id);
                  $sqlLose->execute();

                  $sqlS = $db->prepare($sqlStat);
                  $sqlS->bindParam(':challenge_id', $challenge->challenge_id);
                  $sqlS->execute();
                }
              }
            }

        }
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }

    return $response->write(json_encode(array("exercise_id" => $exercise_id)));
  }
);

//STILL NEED TO CREATE AND TEST
$app->delete('/exercise/{exercise_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $exercise_id = $request->getAttribute('exercise_id');

    foreach($db->query('SELECT * FROM exercises WHERE exercise_id = "'.$exercise_id.'"') as $row){
      $strToReturn .= '<br /> exercise_id: ' . $row['exercise_id'] .' <br /> exercise_name: ' . $row['exercise_name'];
    }

    $db->query('DELETE FROM exercises WHERE exercise_id = "'.$exercise_id.'"');

    return $response->write('Deleting <br />' . $strToReturn);
  }

);

$app->get('/exercise',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $exercises = '';
    $sql = 'SELECT exercise_id, exercise_name, user_id, date_completed
            FROM exercises';
    try {
      $stmt = $db->query($sql);
      $exercises = $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    $strToReturn = json_encode($exercises, JSON_PRETTY_PRINT);
      return $response->write('' . $strToReturn);
    }
);

$app->get('/exercise/{exercise_id}',
  function ($request, $response, $args){
     $db = $this->dbConn;
    $strToReturn = '';
    $exercise_id = $request->getAttribute('exercise_id');
    $exercise = '';
    $sql = 'SELECT *
            FROM exercises
            WHERE exercise_id = "'.$exercise_id.'"';
    $getChallenges = 'SELECT challenge_id
                      FROM individual_progress
                      WHERE user_id = :user_id
                      AND exercise_id = :exercise_id';


    try {
      $new;
      $stmt = $db->query($sql);
      $exercise = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt2 = $db->prepare($getChallenges);
      $stmt2->bindParam(':user_id', $exercise['user_id']);
      $stmt2->bindParam(':exercise_id', $exercise['exercise_id']);
      $stmt2->execute();
      $challenges = $stmt2->fetchAll(PDO::FETCH_OBJ);
      $new['exercise_id'] = $exercise['exercise_id'];
      $new['exercise_name'] = $exercise['exercise_name'];
      $new['repetitions'] = $exercise['repetitions'];
      $new['units'] = $exercise['units'];
      $new['date_completed'] = $exercise['date_completed'];
      $new['challenges'] = $challenges;
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    $test = json_encode($new, JSON_PRETTY_PRINT);
    return $response -> write('' . $test);
    }
);



//DO WE NEED THIS ENDPOINT? WHEN WOULD YOU UPDATE AN EXERCISE??
$app->put('/exercise/{exercise_id}',
  function ($request, $response, $args){
  }
);

$app->get('/exercises/user_id/{user_id}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $user_id = $request->getAttribute('user_id');
    $exercise = '';
    $sql = 'SELECT *
          FROM exercises
          WHERE user_id = "'.$user_id.'" ORDER BY date_completed DESC';
    $getChallenges = 'SELECT challenge_id
                    FROM individual_progress
                    WHERE user_id = :user_id
                    AND exercise_id = :exercise_id';
    try {
      $new = array();
      $array_loop = 0;
      $stmt = $db->query($sql);
      $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach($exercises as $exercise){
        $stmt2 = $db->prepare($getChallenges);
        $stmt2->bindParam(':user_id', $exercise['user_id']);
        $stmt2->bindParam(':exercise_id', $exercise['exercise_id']);
        $stmt2->execute();
        $challenges = $stmt2->fetchAll(PDO::FETCH_OBJ);
        $new[$array_loop]['exercise_id'] = $exercise['exercise_id'];
        $new[$array_loop]['exercise_name'] = $exercise['exercise_name'];
        $new[$array_loop]['repetitions'] = $exercise['repetitions'];
        $new[$array_loop]['units'] = $exercise['units'];
        $new[$array_loop]['date_completed'] = $exercise['date_completed'];
        $new[$array_loop]['challenges'] = $challenges;
        $array_loop++;
      }
    }
    catch(PDOException $e) {
      echo json_encode($e->getMessage());
    }
    $test = json_encode($new, JSON_PRETTY_PRINT);
    return $response -> write('' . $test);
  }
);

$app->get('/exercises/search/{team_id}',
  function ($request, $response, $args){
  }
);

$app->get('/exercises/exercise/{exercise_name}',
  function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $exercise_name = $request->getAttribute('exercise_name');
    $exercises = '';

    $sql = 'SELECT exercises.exercise_name, exercises.exercise_id, exercises.user_id, exercises.date_completed, exercises.repetitions, exercises.units
    FROM exercises WHERE  "'.$exercise_name.'" = exercises.exercise_name';

      try {
      $stmt = $db->query($sql);
      $exercises = $stmt -> fetchALL(PDO::FETCH_OBJ);
      }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($exercises, JSON_PRETTY_PRINT);
    return $response -> write('' . $test);
    }
);
$app->get('/exercise_list', function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';

    $sql = 'SELECT exercise_list_id, exercise_name
            FROM exercise_list';
    try {
      $stmt = $db->query($sql);
      $exercises = $stmt -> fetchALL(PDO::FETCH_OBJ);
    }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($exercises, JSON_PRETTY_PRINT);
    return $response -> write('' . $test);
});

$app->get('/units/{exercise_list_id}', function ($request, $response, $args){
    $db = $this->dbConn;
    $strToReturn = '';
    $exercise_list_id = $request->getAttribute('exercise_list_id');

    $sql = 'SELECT unit_name
            FROM units
            WHERE `exercise_list_id` = '. $exercise_list_id;
    try {
      $stmt = $db->query($sql);
      $exercises = $stmt -> fetchALL(PDO::FETCH_OBJ);
    }
    catch(PDOException $e) {
      echo json_encode($e -> getMessage());
    }
    $test = json_encode($exercises, JSON_PRETTY_PRINT);
    if($test == '[]'){
        $test = json_encode(array(array("unit_name" => "repetitions")));
    }
    return $response -> write('' . $test);
});
