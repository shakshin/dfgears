<?php
class Users extends DFModule {
    public $roleRequired = "admin";
    public $title = "Пользователи";
    public $menu = array(
        "Список пользователей" => "listUsers",
        "Список ролей" => "listRoles"
    );

/////////////////////// работа с пользователями ////////////////////////////////

    public function listUsers() {
        $users = $this->core->database->fetchAll("select * from users order by login");
        $tpl = new DFTemplater();
        $tpl->assign("users", $users);
        $tpl->setPrefix("users");
        return $tpl->fetch("userlist");
    }

    public function addUser() {
    	$login=$this->core->request->parameters["name"];
    	$name=$this->core->request->parameters["name"];
    	$pass=$this->core->request->parameters["pass"];
    	$conf_pass=$this->core->request->parameters["conf_pass"];
    	$mail=$this->core->request->parameters["mail"];

    	if(!empty($name) && !empty($pass) && !empty($conf_pass) && check_email_address($mail) && $pass==$conf_pass){

	        $pass=md5($pass);
	        $this->core->database->exec("
	          insert into users(login,password,fullName,email,active,code)
	          select '{$login}','{$pass}','{$name}','{$mail}',null,''
	        ");

            $id=$this->core->database->fetchOne("select max(id) from users");
            foreach($this->core->request->parameters as $k=>$v){
            	if(substr($k,0,5)=='role_' && $v=='ON'){
            		$role=substr($k,5,strlen($k)-5);

            		if(!empty($role) && !empty($id)){
            			$this->core->database->exec("insert into acl(roleId,userId) select {$role},{$id}");
            		}
            	}
            }

    		header("Location: /admin/users/listUsers");
    	}
    	else {
          $roles = $this->core->database->fetchAll("select * from roles order by id");
          $tpl = new DFTemplater();
          $tpl->assign("roles", $roles);
          $tpl->setPrefix("users");
          return $tpl->fetch("useradd");
    	}

    }

    public function updUser() {
    	$id=$this->core->request->parameters["id"];
    	$login=$this->core->request->parameters["login"];
    	$name=$this->core->request->parameters["name"];
    	$pass=$this->core->request->parameters["pass"];
    	$conf_pass=$this->core->request->parameters["conf_pass"];
    	$mail=$this->core->request->parameters["mail"];
        if(!empty($id)){
            $id++; $id--;
    		if(!empty($name) && !empty($pass) && !empty($conf_pass) && check_email_address($mail) && $pass==$conf_pass){

	        	$pass=md5($pass);
	        	$this->core->database->exec("
	          	update users set
	          		login='{$login}'
	          		,password='{$pass}'
	          		,fullName='{$name}'
	          		,email='{$mail}'
	          		,code=null
	            where id={$id}
	        	");

	        	$this->core->database->exec("delete from acl where userId={$id}");

            	foreach($this->core->request->parameters as $k=>$v){
            		if(substr($k,0,5)=='role_' && $v=='ON'){
            			$role=substr($k,5,strlen($k)-5);
	        			$this->core->database->exec("insert into acl(userId,roleId) select {$id},{$role}");
	        		}
	        	}
    			header("Location: /admin/users/listUsers");
    		}
    		else {

		  		$data=$this->core->database->fetchAll("
		  		select
		  		    users.id
		  			,users.login
		  			,users.fullName
		  			,users.email
		  			,acl.roleId
		  		from users
		  		left join acl on acl.userId=users.id
		  		where id={$id}
		  		");
		  		$roles = $this->core->database->fetchAll("select * from roles order by id");
          		$tpl = new DFTemplater();
          		$tpl->assign("data", $data);
          		$tpl->assign("roles", $roles);
          		$tpl->setPrefix("users");
          		return $tpl->fetch("userupd");
    		}
    	}
        else header("Location: /admin/users/listUsers");
    }

    public function activateUser() {
        $id = $this->core->request->parameters["id"];
        if (!empty($id)) {
            $id++; $id--;
            $this->core->database->exec("update users set active=1 where id={$id}");
        }
        header("Location: /admin/users/listUsers");
    }

    public function deleteUser() {
        $id = $this->core->request->parameters["id"];
        if (!empty($id)) {
            $id++; $id--;
            $this->core->database->exec("delete from acl where userId={$id}");
            $this->core->database->exec("delete from users where id={$id}");
        }
        header("Location: /admin/users/listUsers");
    }

////////////////////////////////////////////////////////////////////////////////

/////////////////////// работа с ролями ////////////////////////////////////////

    public function listRoles() {
        $roles = $this->core->database->fetchAll("select * from roles order by id");
        $tpl = new DFTemplater();
        $tpl->assign("roles", $roles);
        $tpl->setPrefix("users");
        return $tpl->fetch("rolelist");
    }

    public function addRole() {
    	$role_alias=$this->core->request->parameters["role_alias"];
    	$role_name=$this->core->request->parameters["role_name"];
    	if(!empty($role_alias)){

	        $this->core->database->exec("
	          insert into roles(alias,fullName)
	          select '{$role_alias}','{$role_name}'
	        ");

    		header("Location: /admin/users/listRoles");
    	}
    	else {
          $tpl = new DFTemplater();
          $tpl->setPrefix("users");
          return $tpl->fetch("roleadd");
    	}

    }

    public function updRole() {
    	$id = $this->core->request->parameters["id"];
    	$role_alias=$this->core->request->parameters["role_alias"];
    	$role_name=$this->core->request->parameters["role_name"];
        if(!empty($id)){
    		if(!empty($role_alias)){
                $id++; $id--;
	        	$this->core->database->exec("
	          	update roles set
	          		alias='{$role_alias}'
	          		,fullName='{$role_name}'
	            where id={$id}
	        	");
    			header("Location: /admin/users/listRoles");
    		}
    		else {

		  		$data=$this->core->database->fetchAll("select * from roles where id={$id}");
          		$tpl = new DFTemplater();
          		$tpl->assign("data", $data);
          		$tpl->setPrefix("users");
          		return $tpl->fetch("roleupd");
    		}
    	}
        else header("Location: /admin/users/listRoles");
    }

    public function deleteRole() {
        $id = $this->core->request->parameters["id"];
        if (!empty($id)) {
            $id++; $id--;
            $this->core->database->exec("delete from acl where roleId={$id}");
            $this->core->database->exec("delete from roles where id={$id}");
        }
        header("Location: /admin/users/listRoles");
    }
////////////////////////////////////////////////////////////////////////////////

    public function main() {
        header("Location: /admin/users/listUsers");
    }


}
?>
