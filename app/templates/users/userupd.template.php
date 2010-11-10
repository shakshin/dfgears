<h2>
					Редактирование пользователя&nbsp;<?=$data[1]['login']?>
</h2>
<script language=JavaScript>
function check(){
	if(document.getElementById('frm_updUsr').login.value==''){
		 alert("Введите логин!!");
	}
	else if(document.getElementById('frm_updUsr').pass.value==''){
	     alert("Введите пароль!!");
	}
	else if(document.getElementById('frm_updUsr').conf_pass.value==''){
	     alert("Подтвердите пароль!!");
	}
	else if(document.getElementById('frm_updUsr').mail.value==''){
	     alert("Введите e-mail!!");
	}
	else if(document.getElementById('frm_updUsr').pass.value != document.getElementById('frm_updUsr').conf_pass.value){
	     alert("Пароль и подтверждение не совпадают!!");
	}
	else if(<? $tmp=""; foreach($roles as $v) $tmp.="document.getElementById('frm_updUsr').role_".$v["id"].".checked==false &&"; echo substr($tmp,0,strlen($tmp)-2);?>){
		 alert("Выберите роль!!");
	}
	else {
	    document.getElementById('frm_updUsr').submit();
	}
}
</script>

<div class="c"></div>

<div class="b-obj-list">
<form name="" id='frm_updUsr' action="/admin/users/updUser/id/<?=$data[1]['id']?>" method="post">
<table boredr=0 >
<tr>
  <th width=20%>Логин</th>
  <td><input name="login" type="text" value="<?=$data[1]['login']?>"></td>
</tr>
<tr>
  <th width=20%>Имя</th>
  <td><input name="name" type="text" value="<?=$data[1]['fullName']?>"></td>
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
  <td><input name="mail" type="text" value="<?=$data[1]['email']?>"></td>
</tr>
<tr>
  <th>Роль</th>
  <td>
  <? foreach($roles as $v){ ?>
  <input name="role_<?=$v['id']?>" type="checkbox" value="ON"
    <?foreach($data as $usr_role)
        if($v['id']==$usr_role['roleId']) echo 'checked';
    ?>

  ><?=$v['alias']?><br>
  <? } ?>

  </td>
</tr>
</tr>
</table>

<div class="c"></div>
                        <div href="" class="b-button l">
                            <input type="button" value="Сохранить" onclick='check();'>
                        </div>
                        <div class="c"></div>
</form>

</div>
