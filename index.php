<?php
/*
VERSION 0.1

NOTES:
* Valid folder names must be alphanumeric, dashes or underscores. No spaces or anything else, otherwise it wont look at it.
* It will show files in alphabeticalnumerical order with numbers first.
* To order files in a certain order, put numbers in front followed by an underscore. Example: 1_homepage.jpg
* Dashes and underscores will show up as a space when it shows the name of the file
* When it displays the name the leading numbers and first underscore wont be shown
* The file extension won't be shown for the name of the file
* No need to worry about caching, it adds a string query to the img src of the file, so when its updated, it will know to regrab the new one if need be

http://example.com/?x=foldername
*/

$image_extensions = ['gif', 'jpg', 'jpe', 'jpeg', 'png'];

if (isset($_GET['x']) && !empty($_GET['x']))
{
	$folder_to_use = preg_replace('[^A-Za-z0-9\-_]', '', $_GET['x']);//filter for safety
	
	if ($folder_to_use == '')
		exit;
		
	if ($handle = opendir('./' . $folder_to_use))
	{		
		while (false !== ($entry = readdir($handle)))
		{
			//ignore folders, this also ignores . and ..
        	if (!is_dir($entry))
			{
				$entry_pathparts = pathinfo($entry);
				$extension = $entry_pathparts['extension'];//get extention
				
				//check if we have a match
				$match = in_array($extension, $image_extensions, true);
				
				//we have a match, so put it in our array
				if (!empty($match))
				{
					$image_array[] = $entry;
					
					if (filemtime('./' . $folder_to_use . '/' . $entry) !== false)
						$filetime = filemtime('./' . $folder_to_use . '/' . $entry);
					else if (filectime('./' . $folder_to_use . '/' . $entry) !== false)
						$filetime = filectime('./' . $folder_to_use . '/' . $entry);
					else
						$filetime = time();//current time 
					
					$time_array[] = date('YmdHis', $filetime);
				}
			}
    	}
		
		closedir($handle);
	}
	
		if (!empty($image_array))
		{
			//sort image array like a human, then make $time_array match that sorting
			array_multisort($image_array, SORT_NATURAL, $time_array);
			$multidimensional_array['names'] = $image_array;
			$multidimensional_array['times'] = $time_array;
			
			//dumping in HTML, this is a simple script
			//header
			echo '<!doctype html><html><head><meta charset="utf-8">';
			echo '<title>' . $folder_to_use . '</title>';//output title, its safe
			echo '<meta name="robots" content="noindex, nofollow">';
			echo '<link rel="stylesheet" href="style.css"></head>';
			
			echo '<body><noscript>JavaScript is required for this site.</noscript></body>';
			
			//output our arrays in JS
			echo '<script>' . "\n";
			echo 'var folder = ' . json_encode($folder_to_use . '/') . ';' . "\n";
			
			echo 'var images = ';
			echo json_encode($multidimensional_array);
			echo ';' . "\n";
			
			echo '</script>' . "\n";
			
			
			echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>';
			echo '<script src="script.js"></script>';
			echo '</html>';
		}
}
else
	exit;
