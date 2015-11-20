<?php
class User_UserRepository extends Base_Repository{

	public function getUserId(){
		return empty($_SESSION['user_id']) ? 0 : $_SESSION['user_id'];
	}

	private function login($userId){
		return $_SESSION['user_id'] = $userId;
	}

	public function logout(){
		unset($_SESSION['user_id']);
	}

	public function loginById($userId){
		if ($this -> getUserById($userId)){
			return $this -> login($userId);
		}
		return false;
	}

	public function addUser(array $user){

	}

	public function loginByUsername($username, $password = null){
		$obj = $this -> getUserByUsername($username, $password);
			if (!empty($obj['id'])){
				return $this -> login($obj['id']);
			}
		return false;
	}

	public function getUserById($id){
		$SQL = "
			SELECT `id`
			FROM `user`
			WHERE `id` = ". $id ."
		";
		$result = array('id' => 1);
		return $result;
	}

	public function getUserByUsername($username, $password = null){
		$SQL = "
			SELECT `id`
			FROM `user`
			WHERE `username` = ". $username ."
		";
		if (!is_null($password)){
			$SQL .= " AND `password` = ".$password;
		}
		$result = array('id' => 1);
		return $result;
	}


}