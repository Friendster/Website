<?php
/**
 * Created by PhpStorm.
 * User: mancr
 * Date: 2/4/2017
 * Time: 19:15
 */
// TODO UPDATE TO PDO
class Database {
    private static $connection;
    
    private static function connectToDatabase() {
//        echo '<h1>GETTING SOMETHING FORM DB</h1>';

        if(Database::$connection == null) {
            $host = Config::$database_host;
            $username = Config::$username;
            $password = Config::$password;
            $db = Config::$database;

            // Create connection
            $conn = new mysqli($host, $username, $password, $db);

            // Check connection
            if ($conn->error) {
                die("DB connection failed. Error " . $conn->connect_errno . " " . $conn->connect_error);
            }
            Database::$connection = $conn;
        }
        return Database::$connection;
    }

    public static function closeConnection() {
        if(Database::$connection != null) {
            Database::$connection->close();
        }
    }

    public static function createUser($email, $hashed_pw) {
        //todo: error check if db is unavailable
        $conn = Database::connectToDatabase();
        $sql = "INSERT INTO user (email, pass) VALUES(?, ?)";

        if ($stmt = $conn->prepare($sql)) {

            // Bind user parameter
            $stmt->bind_param('ss', $email, $hashed_pw);

            // Execute query
            $stmt->execute();
            $stmt->close();
        }


    }


// http://php.net/manual/en/mysqli-stmt.get-result.php
// http://php.net/manual/en/mysqli.prepare.php - see also solution for results to arrays here
    static function getUser($user) {
        $userObj = new stdClass();

        // Connect to db
        $conn = Database::connectToDatabase();

        // Define sql
        $sql = "SELECT pass, id FROM user WHERE email=?";

        // Prepare statemet
        if ($stmt = $conn->prepare($sql)) {

            // Bind user parameter
            $stmt->bind_param('s', $user);

            // Execute query
            $stmt->execute();

            // Bind result variables
            $stmt->bind_result($userObj->password, $userObj->id);

            // Fetch value
            $stmt->fetch();
            $stmt->close();
        }




        return $userObj;
    }

    public static function createPost($user_id, $content) {
        // Connect to db
        $conn = Database::connectToDatabase();

        // Define sql
        $sql = "INSERT INTO `post` (`user_id`, `content`) VALUES (?,?)";

        // Prepare statemet
        if ($stmt = $conn->prepare($sql)) {

            // Bind user parameter
            $stmt->bind_param('is', $user_id, $content);

            // Execute query
            $stmt->execute();

            // Fetch value
            $stmt->fetch();

            $stmt->close();
        }



    }


    public static function getPosts() {

        // Connect to db
        $conn = Database::connectToDatabase();

        // Define sql
        $sql = "SELECT `post`.`id` AS `post_id`, `user_id`, `content`, `date`, `email` AS `author` FROM `post`, `user` WHERE `user_id`=`user`.`id` ORDER BY `date` DESC";


        // Get result
        $result = $conn->query($sql);


        $posts = array();

        while ($row = $result->fetch_assoc()) {
//            array_push($posts, $row);

            // TODO object oriented handling of entities
            $author = new User($row['user_id'], $row['author'], '');
            $post = new Post($row['post_id'], $author, $row['content'], $row['date']);
            array_push($posts, $post);
        }
        // Close connection

        return $posts;

    }

    public static function updatePost($post_id, $post_content) {
        $conn = Database::connectToDatabase();

        $sql = "UPDATE `friendster`.`post` SET `content`=? WHERE `id`=? ";

        if ($stmt = $conn->prepare($sql)) {

            // Bind user parameter
            $stmt->bind_param('si', $post_content, $post_id);

            // Execute query
            $stmt->execute();

            $stmt->close();
        }


    }

    public static function deletePost($post_id) {
        $conn = Database::connectToDatabase();

        $sql = "DELETE FROM `friendster`.`post` WHERE `id`=? ";

        if ($stmt = $conn->prepare($sql)) {

            // Bind user parameter
            $stmt->bind_param('i', $post_id);

            $stmt->execute();

            $stmt->close();
        }


    }

    public static function getProfile($user_id) {
        // TODO create profile model class
        $profile_obj = new stdClass();
        $profile_obj->id = $user_id;

        // Connect to db
        $conn = Database::connectToDatabase();

        // Define sql
        $sql = "SELECT `email`, `name`, `description`, `profilePictureName`, `dateOfBirth` FROM `user` WHERE `id`=?";

        // Prepare statemet
        if ($stmt = $conn->prepare($sql)) {

            // Bind user parameter
            $stmt->bind_param('s', $user_id);

            // Execute query
            $stmt->execute();

            // Bind result variables
            $stmt->bind_result($profile_obj->email, $profile_obj->name, $profile_obj->description, $profile_obj->profile_picture_name, $profile_obj->date_of_birth);

            // Fetch value
            $stmt->fetch();
            $stmt->close();
        }




        return $profile_obj;
    }


    public static function updateProfilePicture($user_id, $profile_picture_name) {
        // Connect to db
        $conn = Database::connectToDatabase();

        // Define sql
        $sql = "UPDATE `user` SET `profilePictureName` = ? WHERE `user`.`id` = ?";

        // Prepare statemet
        if ($stmt = $conn->prepare($sql)) {

            // Bind user parameter
            $stmt->bind_param('si', $profile_picture_name, $user_id);

            // Execute query
            $stmt->execute();

            $stmt->close();
        }


    }

}

