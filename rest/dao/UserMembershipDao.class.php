<?php

require_once "BaseDao.class.php";

class UserMembershipDao extends BaseDao{

  public function __construct(){
    parent::__construct("user_membership");
  }
  


#update

public function get_users_membreship_by_user_id($id){
  $query="SELECT user_membership.`id`, user.`first_name`, user.`last_name`, membership.`type`, user_membership.`start_date`,user_membership.`end_date`
          FROM user_membership JOIN user ON user.`id` = user_membership.`user_id`
          JOIN membership ON membership.`id`= user_membership.`membership_id`
          WHERE user_membership.`id`= :user_id";
  return $this->query($query, ['user_id' => $user_id]);
}

public function get_user_membership(){
  $query="SELECT user_membership.`id`, user.`first_name`, user.`last_name`, membership.`type`,user_membership.`start_date`,user_membership.`end_date`
          FROM user_membership JOIN user ON user.`id`= user_membership.`user_id`
          JOIN membership ON membership.`id`= user_membership.`membership_id`";
  return $this->query_single($query);
}

public function get_active_users(){
  $query=" SELECT COUNT(id) as id
           FROM user_membership
           WHERE end_date>CURRENT_DATE";
  return $this->query_single($query);
}

public function get_earned(){
  $query="SELECT SUM(membership.`price`) AS earned
          FROM membership
          JOIN user_membership ON user_membership.`membership_id`= membership.`id`
          WHERE user_membership.start_date >= NOW() - INTERVAL 30 DAY";
  return $this->query_single($query);
}

}

?>

