<?php

require_once 'BaseModel.php';

class UserModel extends BaseModel
{

    public function findUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = self::$_connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $user;
    }

    public function findUser($keyword)
    {
        $sql = 'SELECT * FROM users WHERE user_name LIKE %' . $keyword . '%' . ' OR user_email LIKE %' . $keyword . '%';
        $user = $this->select($sql);

        return $user;
    }

    /**
     * Authentication user
     * @param $userName
     * @param $password
     * @return array
     */
    public function auth($userName, $password)
    {
        $md5Password = md5($password);
        $sql = "SELECT * FROM users WHERE name = ? AND password = ?";
        $stmt = self::$_connection->prepare($sql);
        $stmt->bind_param("ss", $userName, $md5Password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = self::$_connection->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    /**
     * Update user
     * @param $input
     * @return mixed
     */
    public function updateUser($input)
    {
        $sql = 'UPDATE users SET 
                 name = "' . mysqli_real_escape_string(self::$_connection, $input['name']) . '", 
                 password="' . md5($input['password']) . '"
                WHERE id = ' . $input['id'];

        $user = $this->update($sql);

        return $user;
    }

    /**
     * Insert user
     * @param $input
     * @return mixed
     */
    public function insertUser($input)
    {
        $name = $input['name'] ?? '';
        $fullname = $input['fullname'] ?? '';
        $email = $input['email'] ?? '';
        $type = $input['type'] ?? '';
        $password = md5($input['password'] ?? '');

        $sql = "INSERT INTO `app_web1`.`users` 
        (`name`, `fullname`, `email`, `type`, `password`) VALUES (
            '" . mysqli_real_escape_string(self::$_connection, $name) . "', 
            '" . mysqli_real_escape_string(self::$_connection, $fullname) . "', 
            '" . mysqli_real_escape_string(self::$_connection, $email) . "', 
            '" . mysqli_real_escape_string(self::$_connection, $type) . "', 
            '" . $password . "'
        )";

        return $this->insert($sql);
    }

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getUsers($params = [])
    {
        if (!empty($params['keyword'])) {
            $sql = "SELECT * FROM users WHERE name LIKE CONCAT('%', ?, '%')";
            $stmt = self::$_connection->prepare($sql);
            $stmt->bind_param("s", $params['keyword']);
            $stmt->execute();
            $result = $stmt->get_result();
            $users = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        } else {
            $sql = 'SELECT * FROM users';
            $users = $this->select($sql);
        }
        return $users;
    }
}