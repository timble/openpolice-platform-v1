<?php
$path = '';

foreach($iterator = new DirectoryIterator($path) as $directory)
{
	if(file_exists($path.'/'.$directory.'/start.htm'))
	{
		$skipped[] = (string) $directory;
		continue;
	}

	if(file_exists($path.'/'.$directory.'/index.htm'))
	{
		$lines = file($path.'/'.$directory.'/index.htm');
		foreach($lines as $line)
		{
			if($position = strpos($line, 'URL='))
			{
				$link = substr($line, $position + 4, strpos($line, '">') - $position - 4);

				if(strpos($link, 'http://www.police.be/') !== false) {
					$link = substr($link, 21);
				}

				if(strpos($link, 'http://217.21.184.146/') !== false) {
					$link = substr($link, 22);
				}

				$sites[$link][] = (string) $directory;
			}
		}
	}
}

$config = '';
foreach($sites as $key => $value)
{
	$config .= 'location ~ /('.implode('|', $value).') {'.PHP_EOL;
	$config .= "\t".'rewrite ^ '.((strlen($key) == 4) ? 'http://217.21.184.146/'.$key : $key).';'.PHP_EOL;
	$config .= '}'.PHP_EOL;
	$config .= ''.PHP_EOL;
}

file_put_contents(dirname(__FILE__).'/redirect.conf', $config);