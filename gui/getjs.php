<?php
require 'helpers/js.php';
$compiler = new UglifyJS();
$compiler->add("js/jquery.min.js")->add("js/jquery-ui.min.js")->add("js/modernizr-2.6.2.min.js")
				 ->add("js/prefixfree.min.js")
				 ->add("js/jquery.fitvids.js")
				 ->add("js/bootstrap.js")
				 ->add("js/photobox/jquery.shapeshift.js")
				 ->add("js/photobox/WBSReportPages.js")
				 ->add("js/photobox/photobox.js")
				 ->add("js/photobox/init.js")
				 ->add("js/scripts.js")
				 ->cacheDir("./min/")
				 ->write(true);
