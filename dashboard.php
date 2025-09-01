<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T-Tracks</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="style/hmmenu.css"> 
    <link rel="stylesheet" href="style/modal-comments.css">
    <link rel="stylesheet" href="style/file.css">
    <link rel="stylesheet" href="style/navbar.css">
   <link rel="stylesheet" href="style/modal.css">
</head>
<body>

          <div class="navbar">
            <div class="trimexlogo">
              <a href="#">
                <img src="logo/Trimex.jpg" alt="Trimex Logo" style="height: 40px; vertical-align: middle;">
                TRIMEX CAPSTONE TRACKER
              </a>
            </div>

                <!-- Profile Dropdown -->
                <div class="profile-dropdown">
                    <a>Welcome, <?= $_SESSION['username']; ?> (<?= $role ?>)</a>
                  <button class="profile-btn">Profile ▼</button>
                  <div class="dropdown-menu">
                    <a href="profile.php">My Profile</a>
                    <a href="settings.php">Settings</a>
                    <a href="api/logout.php" class="logout">Logout</a>
                  </div>
                </div>
              </div>

<?php if (strtolower($_SESSION['role']) === 'admin' || strtolower($_SESSION['role']) === 'contributor'): ?>

                  <!-- contri Modal -->
              <button id="openContributorModal" class="btn-green">
                    ➕ Create Contributor
                    </button>

<!-- Contributor Modal -->
<div id="contributorModal" class="Cmodal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000080; justify-content:center; align-items:center;">
  <div style="background:white; padding:20px; width:400px; position:relative; border-radius:10px;">
    <button id="closeContributorModal" style="position:absolute; top:5px; right:10px; font-size:18px;">&times;</button>
    <h3>Create Contributor Account</h3>
    
    <form id="contributorForm">
      <label>First Name:</label>
      <input type="text" name="first_name" required style="width:100%; padding:10px; margin-bottom:10px;" />

      <label>Last Name:</label>
      <input type="text" name="last_name" required style="width:100%; padding:10px; margin-bottom:10px;" />

      <label>Username:</label>
      <input type="text" name="username" required style="width:100%; padding:10px; margin-bottom:10px;" />

      <label>Password:</label>
      <input type="password" name="password" required style="width:100%; padding:10px; margin-bottom:10px;" />

      <button type="submit" style="padding:10px 20px; background:#28a745; color:white; border:none; border-radius:5px;">Create</button>
    </form>

    <div id="contributorStatus" style="margin-top:10px; font-weight:bold;"></div>
  </div>
</div>
<!-- Link the external JS -->
<script src="src/contributor.js"></script>

                  <!-- Admin Approval Modal -->
                    <button id="openApprovalModal" class="admin-btn">🛠 Pending Approvals</button>
              <?php endif; ?>

                  <!-- Admin Approval Modal -->
                  <div id="approvalModal" class="modal" style="display: none;">
                    <div class="modal-content">
                      <button onclick="closeApprovalModal()" class="close-btn">&times;</button>
                      <h3>Pending File Approvals</h3>
                      <div id="pendingFilesList">Loading...</div>
                    </div>
                  </div>



                <script src="bundle.js"></script>

                
                  <h2>Uploaded Files</h2>
                  <ul id="fileList"></ul>
                  <script type="module" src="src/display.js"></script>

                <button id="openUploadBtn" class="floating-upload-btn" title="Upload Capstone">
                  📤 Upload Capstone
                </button>



<script type="module" src="src/upload.js"></script>

<!-- File Preview Modal -->
<div id="fileModal" class="modal">
  <div class="modal-content">
    <button onclick="closeModal()" class="close-btn">&times;</button>
    
    <h3 id="modalTitle">Filename</h3>
    <p><strong>Uploaded by:</strong> <span id="modalUploader"></span></p>
    <p><strong>Date:</strong> <span id="modalDate"></span></p>
    
    <a id="viewFileBtn" href="#" target="_blank" class="view-file-link">🔍 View PDF</a>
    <hr>

    <h4>Comments</h4>

    <!-- Scrollable comment container -->
    <div class="comments-wrapper">
      <div id="modalComments"></div>
    </div>

    <!-- Fixed comment input at bottom -->
    <div class="comment-input-area">
      <textarea id="newComment" placeholder="Write a comment..." rows="3" class="comment-input"></textarea>
      <button id="postCommentBtn" class="comment-btn">Post Comment</button>
    </div>
  </div>
</div>



<!-- Upload Modal -->
<div id="uploadModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000080; justify-content:center; align-items:center;">
  <div style="background:white; padding:20px; width:500px; position:relative; border-radius:10px;">
    <button onclick="closeUploadModal()" style="position:absolute; top:5px; right:10px; font-size:18px;">&times;</button>
    <h3>Upload Capstone File</h3>
    <form id="uploadForm">
      <label>Uploader:</label>
      <input type="text" name="uploader" value="<?= $_SESSION['username']; ?>" readonly style="width:100%; padding:10px; margin-bottom:10px;" />
      <label>Capstone Title:</label>
      <input type="text" name="title" placeholder="Enter capstone title" required style="width:100%; padding:10px; margin-bottom:10px;" />
      <label>Select PDF:</label>
      <input type="file" name="pdf" accept=".pdf" required style="width:100%; padding:10px; margin-bottom:10px;" />
      <button type="submit" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px;">Upload</button>
    </form>
    <div id="uploadStatus" style="margin-top: 10px; font-weight: bold;"></div>

  </div>

</div>

<script src="src/dropdown.js"></script>
<script type="module">
  import { openUploadModal, closeUploadModal } from './src/modal-control.js';
  // Attach the functions to buttons
  document.getElementById('openUploadBtn')?.addEventListener('click', openUploadModal);
  window.closeUploadModal = closeUploadModal; // used by modal close button
</script>


 <script type="module" src="src/display.js"></script>
</body>
</html>
    