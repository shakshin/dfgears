<h2>
					Добавить пользователя
</h2>
<script language=JavaScript>
function check(){

    if(document.getElementById('frm_addUsr').login.value==''){
		 alert("Введите логин!!");
	}
	else if(document.getElementById('frm_addUsr').pass.value==''){
	     alert("Введите пароль!!");
	}
	else if(document.getElementById('frm_addUsr').conf_pass.value==''){
	     alert("Подтвердите пароль!!");
	}
	else if(document.getElementById('frm_addUsr').mail.value==''){
	     alert("Введите e-mail!!");
	}
	else if(document.getElementById('frm_addUsr').pass.value != document.getElementById('frm_addUsr').conf_pass.value){
	     alert("Пароль и подтверждение не совпадают!!");
	}
	else if(<? $tmp=""; foreach($roles as $v) $tmp.="document.getElementById('frm_addUsr').role_".$v["id"].".checked==false &&"; echo substr($tmp,0,strlen($tmp)-2);?>){
		 alert("Выберите роль!!");
	}
	else {
	    document.getElementById('frm_addUsr').submit();
	}
/*
	else {

        for(key in form) {
    	  if(form[key].name.substr(0,5)=='role_'){
    	     if(form[key].checked==true){
    	       document.getElementById('frm_addUsr').submit();
    	       return 0;
    	     }
    	     else alert("Выберите роль!!");
    	  }
        }

	}
*/
}
</script>

<div class="c"></div>

<div class="b-obj-list">
<form name="" id='frm_addUsr' action="/admin/users/addUser/" method="post">
<table boredr=0 >
<tr>
  <th width=20%>Логин</th>
  <td><input name="login" type="text" value=""></td>
</tr>
<tr>
  <th width=20%>Имя</th>
  <td><input name="name" type="text" value=""></td>
</tr>
<tr>
  <th>Пароль</th>
  <td><input name="pass" type="password" value=""></td>
</tr>
<tr>
  <th>Подтверждение</th>
  <td><input name="conf_pass" type="password" value=""></td>
</tr>
<tr>
  <th>Почта</th>
  <td><input name="mail" type="text" value=""></td>
</tr>
<tr>
  <th>Роль</th>
  <td>
  <? foreach($roles as $v){ ?>
  <input name="role_<?=$v['id']?>" type="checkbox" value="ON"><?=$v['alias']?><br>
  <? } ?>

  </td>
</tr>
</table>

<div class="c"></div>
                        <div href="" class="b-button l">
                            <input type="button" value="Добавить" onclick='check();'>
                        </div>
                        <div class="c"></div>
</form>

</div>
