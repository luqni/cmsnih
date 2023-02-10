<?php 
define('BASEPATH', true); //access connection script if you omit this line file will be blank
include '../config/db.php';
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
      <div class='row'>
        <div class="col-md-9">
        <!-- main content here -->
        </div>
        <div class="col-md-3 d-flex justify-content-end">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Contact</button>
        </div>
      </div>
      <br>
      <?php
        $sql = "select a.id, a.name, count(b.id) as count from contacts a left join numbers b ON a.id = b.contact_id GROUP BY a.id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <div class='row'>
        <table id="example" class="display">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Total Number</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $row) { ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['count']; ?></td>
                <td>
                  <a href="#" onclick="viewFunction(<?php echo $row['id']; ?>)">
                  <i data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="detail contacts" class="bi bi-eye-fill" data-bs-toggle="modal" data-bs-target="#editModal"></i></a> 
                  <a href="#" onclick="editFunction(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>')">
                  <i data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="edit contacts" class="bi bi-pencil-square"></i></a>
                  <i class="bi bi-box-arrow-in-down"></i>
                  <i class="bi bi-trash-fill"></i>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
  </main><!-- End #main -->

<div class="modal fade" id="addModal" tabindex="-1"><!-- Start Add Modal-->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form   action="../controller/contactController.php" method="post">
        <div class="modal-body">
            <!-- Name input-->
            <div class="form-floating mb-3">
                <input class="form-control" id="name" name="name" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                <label for="name">name</label>
                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
            </div> 
        </div>
        <div class="modal-footer">
          <input  name="user_id" type="hidden" value=<?php echo $_SESSION['user_id']; ?>/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div><!-- End Add Modal-->

<div class="modal fade" id="editModal" tabindex="-1"><!-- Start Edit Modal-->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form   action="../controller/editContactController.php" method="post">
        <div class="modal-body">
            <!-- Name input-->
            <div class="form-floating mb-3">
                <input class="form-control" id="editname" name="name" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                <label for="name">name</label>
                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
            </div> 
        </div>
        <div class="modal-footer">
          <input  name="id" id="idContact" type="hidden"/>
          <input  name="user_id" type="hidden" value=<?php echo $_SESSION['user_id']; ?>/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div><!-- End Edit Modal-->

<div class="modal fade" id="detailModal" tabindex="-1"><!-- Start Detail Modal-->
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
          <table  class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Name</th>
                <th>Number</th>
              </tr>
            </thead>
            <tbody id="data-list-numbers">
              <!-- Data akan ditampilkan di sini -->
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      
    </div>
  </div>
</div><!-- End Detail Modal-->

<?php include 'layouts/footer.php' ?>
<script type="text/javascript">
  function viewFunction(id) {
      console.log(id);
      $.ajax({
          type: "GET",
          url: "../controller/getDataNumberController.php?contact_id="+id,
          data: id, 
          success: function(res){
            var result = JSON.parse(res);
            let rows = ``;
           
            for (let i = 0; i < result.length; i++) {
              let data = `
                <tr>
                  <td>${i+1}</td>
                  <td>${result[i].id}</td>
                  <td>${result[i].name}</td>
                  <td>${result[i].number}</td>
                </tr>
              `;
              rows += data;
            }

            document.querySelector("#data-list-numbers").innerHTML = rows;
            
            $("#detailModal").modal('show');
          },
          // Alert status code and error if fail
          error: function (xhr, ajaxOptions, thrownError){
              alert(xhr.status);
              alert(thrownError);
          }
      });
    }


  function editFunction(id, name) {
    $("#idContact").val( id );
    $("#editname").val( name );
    $("#editModal").modal('show');
  }

  $(document).ready(function() {
    $('#example').DataTable();
  });
      
</script>
</body>

</html>