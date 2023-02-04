<?php 
 
session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
}
 
?>

<?php include 'layouts/header.php' ?> 

<body>

  <?php include 'layouts/navbar.php' ?> 

  <?php include 'layouts/sidebar.php' ?> 

  <main id="main" class="main">
    <div class="pagetitle">
        <h1>List Contacts</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">List Contacts</li>
          </ol>
        </nav>
      </div><!-- End Page Title -->
    

  </main><!-- End #main -->

  <?php include 'layouts/footer.php' ?>

</body>

</html>