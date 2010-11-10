<h2>
					Редактирование роли&nbsp;<?=$data[1]['alias']?>
</h2>
<script language=JavaScript>
function check(){
    if(document.getElementById('frm_updRl').role_alias.value==''){
		 alert("Введите алиас!!");
	}
	else if(document.getElementById('frm_updRl').role_name.value==''){
	     alert("Введите название!!");
	}
	else {
	    document.getElementById('frm_updRl').submit();
	}

}
</script>

<div class="c"></div>

<div class="b-obj-list">
<form name="" id='frm_updRl' action="/admin/users/updRole/id/<?=$data[1]['id']?>" method="post">
<table boredr=0 >
<tr>
  <th width=20%>Алиас</th>
  <td><input name="role_alias" type="text" value="<?=$data[1]['alias']?>"></td>
</tr>
<tr>
  <th width=20%>Имя</th>
  <td><input name="role_name" type="text" value="<?=$data[1]['fullName']?>"></td>
</tr>
</table>

<div class="c"></div>
                        <div href="" class="b-button l">
                            <input type="button" value="Сохранить" onclick='check();'>
                        </div>
                        <div class="c"></div>
</form>

</div>
