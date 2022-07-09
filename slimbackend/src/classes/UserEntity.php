<?php

class UserEntity
{
    protected $id;
    protected $firstname;
    protected $lastname;

    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data) {
        // no id if we're creating
        if(isset($data['id'])) {
            $this->id = $data['id'];
        }

        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->phone = $data['phone'];
    }

    public function getId() {
        return $this->id;
    }

    public function getFirstname() {
        return $this->title;
    }

    public function getLastname() {
        return $this->lastname;
    }


    public function getPhone() {
        return $this->phone;
    }
}