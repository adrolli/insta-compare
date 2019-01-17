<?php

/* 
 * Insta Compare
 * 
 * Compares two lists, useful to find followers that unfollowed you.
 * Extremely dirty hack. Could be much better, if needed.
 * 
 * Ideas: 
 * - Small howto Video
 * - Save the last result, compare with before.
 * - Save an exclude-list.
 * 
 */

$inputfollowers = isset($_POST['followers'])?$_POST['followers']:"";
$inputfollowing = isset($_POST['following'])?$_POST['following']:"";
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Insta Compare is a neat little helper to compare Instagram Followers and Follwing. Made with PHP, Bootstrap and jQuery by Catch-Life.com.">
    <meta name="author" content="Catch-Life.com">

    <title>Insta Compare - Compare Instagram Followers and Following</title>

    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400" rel="stylesheet">

    <link href="style.css" rel="stylesheet">
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

  </head>

  <body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Insta Compare V1.0</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="https://catch-life.com">Travelblog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#imprint">Imprint & Info</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead text-center text-white">
      <div class="masthead-content">
        <div class="container">
          <h1 class="masthead-heading mb-0">Insta Compare</h1>
          <h3 class="mb-0">Compare Instagram Followers and Following</h3>
          <a href="#startnow" class="btn btn-primary btn-xl rounded-pill mt-5">Start now</a>
        </div>
      </div>
      <div class="bg-circle-1 bg-circle"></div>
      <div class="bg-circle-2 bg-circle"></div>
      <div class="bg-circle-3 bg-circle"></div>
      <div class="bg-circle-4 bg-circle"></div>
    </header>

    <div id="startnow" style="margin-bottom: 50px"></div>

    <form action="index.php#compare" method="post">
    <section>
      <div class="container">
        <div class="row align-items-center">
         <div class="col-lg-6">
            <div class="p-5">
              <h4>Paste Followers here:</h4>
              <textarea name="followers" rows="4" cols="50"><?php echo htmlspecialchars($inputfollowers); ?></textarea>
            </div>
          </div>
  
          <div class="col-lg-6">
            <div class="p-5">
              <h4>and Following here:</h4>
              <textarea name="following" rows="4" cols="50"><?php echo htmlspecialchars($inputfollowing); ?></textarea>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="p-5" style="padding-top: 0px !important">
              <label>
                <input type="checkbox" name="checkfollowers" value="yep" checked>
                Show all profiles I follow, that do not follow me.
              </label>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="p-5" style="padding-top: 0px !important">
              <label>
                <input type="checkbox" name="checkfollowing" value="yep">
                Show all Followers, I do not follow.
              </label>
            </div>
          </div>
          
          <div class="col-lg-6">
            <div class="p-5" style="padding-top: 0px !important">
              <label>
                <input type="checkbox" name="filterresults" value="yep" checked>
                Filter the results.
              </label>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="p-5" style="padding-top: 0px !important">
              <label>
                <input type="text" name="profileimage" value="Profilbild">
                Filter value (preset German)  
              </label>
            </div>
          </div>

        <input type="submit" value="Compare now" class="btn btn-primary btn-xl rounded-pill" style="margin: 0 auto">

        </div>
      </div>
    </section>
    </form>

    <div id="compare" style="margin-bottom: 50px"></div>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="p-5">
            <?php

            if (strlen($inputfollowers)==0) {
            
              echo '<h4 style="text-align:center">Put in some data to see results ;-)</h4>
                    <p>Scroll the Follower and Following fields on the Instagram Website until their end
                    and mark all Names. Paste them into the fields above.</p>
                    <p><b>Example (how the copied data will look, in German):</b></p>
                    <p>
                    followers Profilbild<br>
                    follower<br>
                    Followers Name<br>
                    second_followers Profilbild<br>
                    second_follower<br>
                    Second Follower<br>
                    </p>
                    ';
            
            } else {

              // Create some arrays
              $followers = explode("\n", str_replace("\r", "", $_POST['followers']));
              $following = explode("\n", str_replace("\r", "", $_POST['following']));

              if (isset($_POST['checkfollowers'])) {

                  // Compare the array
                  $unfollowers = array_diff($following, $followers); 

                  // Count the array and divide through 3
                  $unfollowerscount = round ( count( $unfollowers ) / 3 );

                  echo "<h4>You are following these, not following you! (~ " . $unfollowerscount . ")</h4>";
                  $i=1;

                  if (!isset($_POST['filterresults'])) {

                    // Unfiltered Output
                    foreach($unfollowers AS $unfollower) {
                        echo $i . ' <a href="https://www.instagram.com/' . $unfollower . '" target="_blank">' . $unfollower . '</a><br>';
                        $i++;
                    }

                  } else {

                    // Filtered Output
                    foreach($unfollowers AS $unfollower) {
                      if (strpos($unfollower, $_POST['profileimage']) !== false) {
                          $compare = $unfollower;
                      } elseif (strpos($compare, $unfollower) !== false) {
                          echo $i . ' <a href="https://www.instagram.com/' . $unfollower . '" target="_blank">' . $unfollower . '</a><br>';
                          $i++;
                      }
                    }
                  }
                }
              }

              if (isset($_POST['checkfollowing'])) {

                  // Compare the array
                  $adfollowers = array_diff($followers, $following); 

                  // Count the array and divide through 3
                  $adfollowerscount = round ( count( $adfollowers ) / 3 );

                  echo "<h4>and you are not following these Followers (~ " . $adfollowerscount . ")</h4>";
                  $i=1;

                  if (!isset($_POST['filterresults'])) {

                    // Unfiltered Output
                    foreach($adfollowers AS $adfollower) {
                        echo $i . ' <a href="https://www.instagram.com/' . $adfollower . '" target="_blank">' . $adfollower . '</a><br>';
                        $i++;
                    }

                  } else {

                    // Filtered Output
                    foreach($adfollowers AS $adfollower) {
                      if (strpos($adfollower, $_POST['profileimage']) !== false) {
                          $compare = $adfollower;
                      } elseif (strpos($compare, $adfollower) !== false) {
                          echo $i . ' <a href="https://www.instagram.com/' . $adfollower . '" target="_blank">' . $adfollower . '</a><br>';
                          $i++;
                      }
                    }
                  }
                }
            ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div id="imprint" style="margin-bottom: 50px"></div>

    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="p-5">
              <h2>Imprint and legal information:</h2>
              <p>Please visit the <a href="https://catch-life.com/contact">Catch Life Travelblog</a> for contact information, more information about travelling the world, being a Digital Nomad and Travel Blogger and stuff like this.</p>
              <p>This tool is made to help you comparing two datasets. It is written in PHP. You may use it to manually compare your Instagram Followers against the ones your're following. As this tool does not use the Instagram API or access Instagram in any way, there is no problem with Instagram policies.<p>
              <p>But it is some manual work to scroll both fields to the end to paste the copied data into the fields above.</p>
              <p>If anyone knows a cheat how to make this more convenient, please drop me a line, create an issue on Github or fork the repository.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
 
    <section>
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-12">
            <div class="p-5">
              <h2>Download Source Code on Github:</h2>
              <p>Want to host this page by yourself. Change the code (eg translate from German to your language) or help me with improvements? Insta Compare is free Open Source Code and available on Github.</p>
              <div style="margin: 0 auto; text-align: center">
              <br>
                <a class="github-button" href="https://github.com/adrolli/insta-compare/archive/master.zip" data-size="large" aria-label="Download adrolli/insta-compare on GitHub">Download</a>
                <a class="github-button" href="https://github.com/adrolli/insta-compare" data-icon="octicon-star" data-size="large" aria-label="Star adrolli/insta-compare on GitHub">Star</a>
                <a class="github-button" href="https://github.com/adrolli/insta-compare/fork" data-icon="octicon-repo-forked" data-size="large" aria-label="Fork adrolli/insta-compare on GitHub">Fork</a>
                <a class="github-button" href="https://github.com/adrolli/insta-compare/issues" data-icon="octicon-issue-opened" data-size="large" aria-label="Issue adrolli/insta-compare on GitHub">Issue</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



    <!-- Footer -->
    <footer class="py-5 bg-black">
      <div class="container">
        <p class="m-0 text-center text-white small">Copyright &copy; <a href="https://catch-life.com">Catch-Life</a></p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="jquery.min.js"></script>
    <script src="bootstrap.bundle.min.js"></script>

  </body>
</html>