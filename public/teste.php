<?php

class A {
	private $a = 123;
}

echo '<h1>NULL</h1>';

for ($i=0;$i<=100; $i++)
{
	$a = new A();
	echo memory_get_usage().'<br />';
	$a = null;
}

echo '<h1>Unset</h1>';

for ($i=0;$i<=100; $i++)
{
	$a = new A();
	echo memory_get_usage().'<br />';
	unset($a);
}