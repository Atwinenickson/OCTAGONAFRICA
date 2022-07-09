<?php

class UserMapper extends Mapper
{
    public function getUsers() {
        $sql = "SELECT t.id, t.firstname, t.lastname, t.phone from users";
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new UserEntity($row);
        }
        return $results;
    }

    /**
     * Get one user by its ID
     *
     * @param int $user_id The ID of the user
     * @return UserEntity  The user
     */
    public function getUserById($user_id) {
        $sql = "SELECT t.id, t.firstname, t.lastname, t.phone
            from users u
            where u.id = :user_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["user_id" => $user_id]);

        if($result) {
            return new UserEntity($stmt->fetch());
        }

    }

    public function save(UserEntity $user) {
        $sql = "insert into users
            (firstname, lastname, phone) values
            (:firstname, :lastname, :phone)";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "firstname" => $user->getFirstname(),
            "lastname" => $user->getLastname(),
            "lastname" => $user->getPhone(),
        ]);

        if(!$result) {
            throw new Exception("could not save record");
        }
    }
}
