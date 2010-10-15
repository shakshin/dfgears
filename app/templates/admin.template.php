<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
                <link rel="stylesheet" type="text/css" href="/css/admin.css" media="screen"/>
                <link rel="stylesheet" type="text/css" href="/css/superfish.css" media="screen"/>
                <link rel="stylesheet" type="text/css" href="/css/superfish-navbar.css" media="screen"/>
                <script type="text/javascript" src="/js/jquery-1.2.6.min.js"></script>
                <script type="text/javascript" src="/js/hoverIntent.js"></script>
                <script type="text/javascript" src="/js/superfish.js"></script>
                

		<title>DFGears administrator console</title>
	</head>
	<body>
            <div>
            <ul id="menu" class="sf-menu sf-navbar">
<?
    foreach ($adminMenu as $menuItem) {
?>
                <li><a href="#"><?=$menuItem["title"]?></a>
                    <?
                    if (!empty($menuItem["menu"])) {
                    ?>
                    <ul>
                    <?
                        $alias = $menuItem["alias"];
                        foreach ($menuItem["menu"] as $key => $value) {
                    ?>
                        <li><a href="/admin/<?=$alias ?>/<?=$value ?>"><?=$key ?></a></li>
                    <?
                        }
                    ?>
                    </ul>
                    <?
                    }
                    ?>
                </li>
<?
    }
?>
            </ul>
            </div>
             <script type="text/javascript">

                // initialise plugins
                jQuery(function(){
                        jQuery('ul.sf-menu').superfish();
                });

                </script>
            <div id="container">
            <div id="content">
            <?=$content ?>
            </div></div>
        </body>
</html>