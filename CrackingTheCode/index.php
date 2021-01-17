<html>
<head>
  <title>MD5 Code Cracker</title>
</head>
<body>
<h1>Vignesh's Code Cracker</h1>
<p>
This application takes an MD5 hash of a four digit pin and check all 10,000 
possible four digit PINs to determine the PIN.
</p>

<p>
<pre>
Debug Output:
<?php
$goodtext = "Not found";
// If there is no parameter, this code is all skipped
if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];

    // This is our list of numbers
    $txt = "0123456789";
    $show = 15;

    // Outer loop goes through the list for the
    // first position in our "possible" pre-hash
    // text
    for($i=0; $i<strlen($txt); $i++ ) {
      $ch1 = $txt[$i];   // The first of four characters

      for($j=0; $j<strlen($txt); $j++ ) {
        $ch2 = $txt[$j];  // Our second character

        for($k=0; $k<strlen($txt); $k++ ) {
          $ch3 = $txt[$k];  // Our third character

          for($l=0; $l<strlen($txt); $l++ ) {
            $ch4 = $txt[$l];  // Our fourth character

            // Concatenate the four characters together to 
            // form the "possible" pre-hash text
            $try = $ch1.$ch2.$ch3.$ch4;
            
            // Run the hash and then check to see if we match
            $check = hash('md5', $try);
            if ( $check == $md5 ) {
              $goodtext = $try;
              break;   
              // Exit the inner loop
            }
            // Debug output until $show hits 0
            if ( $show > 0 ) {
              print "$check $try\n";
              $show = $show - 1;
            }
          }
        }
      }
    }
  // Compute elapsed time
  $time_post = microtime(true);
  print "Elapsed time: ";
  print $time_post-$time_pre;
  print "\n";
}
?>
</pre>
</p>

<p>Original Text: <?= htmlentities($goodtext); ?></p>

<form>
<input type="text" name="md5" size="50" value=""/>
<input type="submit" value="Crack MD5"/>
</form>
</p>
</body>
</html>