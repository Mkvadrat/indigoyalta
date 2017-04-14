<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
	<head>
	</head>
	<body class="no-header">

		<div id="hld">
			<div class="wrapper">
				<div class="block no_margin">

					<div class="block_head">
						<div class="bheadl"></div>
						<div class="bheadr"></div>

						<h2><?php echo $heading; ?></h2>

						<ul>
							<li><a href="#" onclick="history.go(-1);"><?php echo _('Go back'); ?></a></li>
						</ul>

					</div>

					<div class="block_content">

							<div class="message errormsg"><?php echo $message; ?></div>

							<div class="internal_padding">
								<p><a href="javascript:history.go(-1);">&laquo; <?php echo _('Go back'); ?></a></p>
							</div>
					</div>
				</div>
			</div>
		</div>

	</body>
</html>