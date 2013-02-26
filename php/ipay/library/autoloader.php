<?php

function __autoload($className) {
	 $filename = str_replace('_',DIRECTORY_SEPARATOR,$className) . ".php";
     require $filename;
}
