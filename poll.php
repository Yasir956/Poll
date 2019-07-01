<?php
include 'controller.php';
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="/Poll1/style.css">
  <title>Poll</title>
</head>
<body>
  <div class="continput">
    
    <form method="POST" action="" name="pollFrm">
     
     <ul>
      
      <?php
      $pollsData = new ViewData();
      $datas = $pollsData->getPolls();
      $sub_id ="";
      foreach ($datas as $data) {
        $sub_id = $data['id'];
        echo $data['subject'];
      }

      $datas1 = $pollsData->getOptions();
      foreach ($datas1 as $pollData) {
        ?>

        <li>
          <input type="radio" required ="required" name="voteOpt" value='<?php echo $pollData['id'];?>' >
          <label><?php echo $pollData['poll_option']; ?></label>
          <div class="bullet">
            <div class="line zero"></div>
            <div class="line one"></div>
            <div class="line two"></div>
            <div class="line three"></div>
            <div class="line four"></div>
            <div class="line five"></div>
            <div class="line six"></div>
            <div class="line seven"></div>
          </div>
        </li>
        <?php
    //  echo '<li><input type="radio" required ="required" name="voteOpt" value="'.$pollData['id'].'" >'.$pollData['poll_option'].'</li>';
      }
      ?>
      
      <input type="hidden" name="pollID" value="1">
      <input type="submit" name="voteSubmit" class="button" value="VOTE">
      <a href="results.php?pollID=<?php echo $sub_id;?>"> VIEW RESULTS</a>
    </ul>
  </form>
  


  <?php
  if(isset($_POST['voteSubmit'])){
    $voteData = array(
      'sub_id' => $_POST['pollID'],
      'poll_option_id' => $_POST['voteOpt']
      );
    //insert vote data
    $voteSubmit = $pollsData->vote($voteData);

    if($voteSubmit){
        //store in $_COOKIE to signify the user has voted
       setcookie($_POST['pollID'], 1, time()+60*60*24*365);
      
      $statusMsg = 'Your vote has been successfully submitted.';
    }else{
      $statusMsg = 'You have already submitted your vote.';
    }
    echo !empty($statusMsg)?'<p class="center">'.$statusMsg.'</p>':'';
  }
  ?>
</div>
</body>
</html>