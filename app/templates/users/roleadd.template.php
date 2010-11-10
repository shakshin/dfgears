<h2>
					Добавить пользователя
</h2>
<script language=JavaScript>
function check(){

    if(document.getElementById('frm_addRl').role_alias.value==''){
		 alert("Введите алиас!!");
	}
	else if(document.getElementById('frm_addRl').role_name.value==''){
	     alert("Введите название!!");
	}
	else {
	    document.getElementById('frm_addRl').submit();
	}

}
</script>

<div class="c"></div>

<div class="b-obj-list">
<form name="" id='frm_addRl' action="/admin/users/addRole/" method="post">
<table boredr=0 >
<tr>
  <th width=20%>Алиас</th>
  <td><input name="role_alias" type="text" value=""></td>
</tr>
<tr>
  <th width=20%>Имя</th>
  <td><input name="role_name" type="text" value=""></td>
</tr>
</table>

<div class="c"></div>
                        <div href="" class="b-button l">
                            <input type="button" value="Добавить" onclick='check();'>
                        </div>
                        <div class="c"></div>
</form>

</div>
