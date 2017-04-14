<?php
require 'js.php';
$compiler = new UglifyJS();
$compiler->add("js/jquery.min.js")
				 ->add("js/jquery.bxslider.js")
				 ->add("js/jquery.prettyPhoto.js")
				 ->add("js/jquery.filedrop.js")
				 ->add("js/upload.js")
				 ->add("js/swfobject.js")
				 ->add("js/core.js")->cacheDir("./min/")
				 ->write(true);
