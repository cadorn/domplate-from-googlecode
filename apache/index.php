
<p><b>Tests</b></p>

<?php

foreach( new DirectoryIterator(dirname(__FILE__)) as $dir ) {
  if(!$dir->isDot() &&
     $dir->isDir() &&
     ($filename = $dir->getFilename()) &&
     $filename!='.svn') {

  
    print '<p><a href="'.$filename.'/"><b>'.$filename.'</a></p>';
  }
}

?>