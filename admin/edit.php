<?php
  session_start();
  require '../config/config.php';

  if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }

if ($_POST) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $content = $_POST['content'];


  if ($_FILES['image']['name'] != null){
    // print_r($_FILES);
    // exit();
    $file = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($file,PATHINFO_EXTENSION);

    if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('The uploaded image must be png,jpg,jpeg format.')</script>";
    }else{
      $image = $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],$file);

      $stmt=$pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
      $result= $stmt->execute();
      if($result){
        echo "<script>alert('Successfully updated.')</script>";
        header('Location: index.php');
    }
  }
}else{

        $stmt=$pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
        $result= $stmt->execute();
        if($result){
          echo "<script>alert('Successfully updated.');window.location.href='index.php';</script>";
  }
}
}


  $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
  $stmt->execute();

  $result = $stmt->fetchAll();
  // print"<pre>";
  // print_r($result);
  //print_r($result[0]['id']);



 ?>

<?php
  include('header.html');
 ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>"
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $result[0]['title'] ?>" required>
                  </div>
                  <div class="form-group">
                    <label for="">Content</label>
                    <textarea name="content" class="form-control" rows="8" cols="80"><?php echo $result[0]['content'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Image</label><br>
                    <img src="images/<?php echo $result[0]['image'] ?>" width="150" height="150" alt=""><br><br>
                    <input type="file" name="image" value="" >
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                    <a href="index.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- /.content -->
 <?php include('footer.html'); ?>