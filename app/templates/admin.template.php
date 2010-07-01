<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>DFGears Administrator panel</title>
                <style>
                    table.grid {
                        border-collapse: collapse;
                        border: none;
                    }
                    table.grid td {
                        padding-top: 2px;
                        padding-bottom: 2px;
                        padding-left: 5px;
                        padding-right: 5px;
                    }

                    table.grid td.menu{
                        vertical-align: top;
                        border-right: 1px solid black;
                        width: 150px;
                    }

                    a {
                        text-decoration: none;
                        color: black;
                    }

                    a:hover {
                        text-decoration: underline;
                    }

                    table.data {
                        border-collapse: collapse;
                        border: 1px solid grey;
                    }

                    table.data td {
                        border: 1px solid grey;
                    }

                    table.data tr.head td {
                        background: gray;
                        color: black;
                        font-weight: bold;

                    }
                </style>
	</head>
    <body>
        <table class="grid">
            <tr>
                <td class="menu">
                    <a href="/admin/users">Пользователи</a><br/>
                    <a href="/admin/roles">Роли</a><br/>
                </td>
                <td class="content">
                            <?=$content ?>
                </td>
            </tr>
        </table>
    </body>
</html>