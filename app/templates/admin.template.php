<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>DFGears Administrator</title>
		<link href="/css/admin-main.css" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript" charset="utf-8" src="http://code.jquery.com/jquery-1.4.1.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(function() {
				$('#menu li').hover(function() {
					$(this).addClass('b-opened');
				}, function() {
					$(this).removeClass('b-opened');
				});

				var $buttons_list = $('.b-button.b-list')

				$(document).eq(0).click(function() {
					$buttons_list.removeClass('b-opened');
				});

				$buttons_list.click(function() {
					var $self = $(this),
						opened = $self.hasClass('b-opened');

					$buttons_list.removeClass('b-opened');

					if (!opened) $self.addClass('b-opened');
					
					return false;	
				});

				var search_value = 'поиск';
				$('#search_input').focus(function() {
					var $self = $(this);
					if ($self.val() == search_value) $self.val('');
				});
				$('#search_input').blur(function() {
					var $self = $(this);
					if ($self.val() == '') $self.val(search_value);
				});
			});
		</script>
	</head>
	<body>

		<div class="l-header">
                        
			<ul class="b-menu" id="menu">
                                <? foreach ($adminMenu as $modMenu) { $alias = $modMenu["alias"];
                                ?>
				<li class="l">
					<a href="#">
						<span><?=$modMenu["title"] ?></span>
					</a>

					<div class="b-submenu">
                                                <? foreach ($modMenu["menu"] as $title => $action) { ?>
						<a href="/admin/<?=$alias ?>/<?=$action ?>">
							<span>
								<?=$title ?>
							</span>
						</a>
                                                <? } ?>
					</div>
				</li>
                                <? } ?>
			</ul>

			<div class="b-admin-buttons r">
				<a href="#" class="b-admin l"><?=$_SESSION["userName"] ?></a>
				<a href="/user/logoff" class="b-logout l">Выход</a>
			</div>

			<div class="c"></div>

		</div>

		<div class="l-content-handler">

			<div class="l-content">

			<?=$content ?>

			</div>

		</div>

	</body>
</html>