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
    <title>I-Tracks</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="style/hmmenu.css"> 
    <link rel="stylesheet" href="style/modal-comments.css">
    <link rel="stylesheet" href="style/file.css">
    <link rel="stylesheet" href="style/navbar.css">
   <link rel="stylesheet" href="style/modal.css">

   <link rel="stylesheet" href="style/chart.css">
   <!-- Bootstrap CSS -->

<!-- Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>
<body>

          <div class="navbar">
            <div class="trimexlogo">
              <a href="#">
                 CAPSTONE TRACKER
              </a>
            </div>

  <!-- Notification Bell -->
    <div class="notif-wrap"> 
      <a id="username">Welcome, <?= $_SESSION['username']; ?> (<?= $role ?>)</a>
  <button id="notifBtn" class="notif-btn" aria-haspopup="true" aria-expanded="false">
    🔔
    <span id="notifBadge" class="notif-badge" hidden>0</span>
  </button>

  <div id="notifDropdown" class="notif-dropdown" role="menu" aria-hidden="true">
    <div class="notif-head">
      <strong>Notifications</strong>
      <button id="notifRefresh" class="notif-refresh" title="Refresh">↻</button>
    </div>
    <div id="notifList" class="notif-list">
      <!-- items injected here -->
    </div>
    <div class="notif-foot">
      <button id="notifClose" class="notif-close">Close</button>
    </div>
  </div>
      </div>

                <!-- Profile Dropdown -->
                <div class="profile-dropdown">
                  <button class="profile-btn">Profile ▼</button>
                  <div class="dropdown-menu">
                    <a href="profile.php">My Profile</a>
                    <a href="settings.php">Settings</a>
                    <a href="api/logout.php" class="logout">Logout</a>
                  </div>
                </div>
              </div>
<button id="openUploadBtn" class="floating-upload-btn">📤 Upload Capstone</button>

<!-- Upload Modal -->
<div id="uploadModal" class="modal">
  <div class="umodal-content">
    <button onclick="closeUploadModal()" class="close-btn">&times;</button>
    <h3>Upload Capstone File</h3>
    <form id="uploadForm">
      <label>Uploader:</label>
      <input type="text" name="uploader" value="<?= $_SESSION['username']; ?>" readonly />

      <label>Capstone Title:</label>
      <input type="text" name="title" placeholder="Enter capstone title" required />

      <label>Year Published:</label>
      <input type="text" name="year" placeholder="Enter year published" required />

      <label>Authors:</label>
      <input type="text" name="authors" placeholder="Enter authors" required />

      <label>Select PDF:</label>
      <input type="file" name="pdf" accept=".pdf" required />

      <button type="submit" class="upload-btn">Upload</button>
    </form>
    <div id="uploadStatus"></div>
  </div>
</div>

<?php if (strtolower($_SESSION['role']) === 'admin'): ?>

                  <!-- contri Modal -->
              <button id="openContributorModal" class="btn-green">
                    ➕ Create Contributor
                    </button>
              <?php endif; ?>


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

<?php if (strtolower($_SESSION['role']) === 'admin' || strtolower($_SESSION['role']) === 'contributor'): ?>
                  <!-- Admin Approval Modal -->
                    <button id="openApprovalModal" class="admin-btn">🛠 Pending Approvals</button>
      <?php endif; ?>
                  <!-- Admin Approval Modal -->
                  <div id="approvalModal" class="amodal" style="display: none;">
                    <div class="modal-content">
                      <button onclick="closeApprovalModal()" class="close-btn">&times;</button>
                      <h3>Pending File Approvals</h3>
                      <div id="pendingFilesList">Loading...</div>
                    </div>
                  </div>

<!-- Button to Open Modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadStatsModal">
  View Upload Statistics
</button>

<!-- Modal -->
<div class="modal fade" id="uploadStatsModal" tabindex="-1" aria-labelledby="uploadStatsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadStatsModalLabel">Uploaded Files Statistics</h5>
        <button type="button" class="btn-close" id="closeUploadStatsModal" aria-label="Close"></button>

      </div>

      <div class="modal-body">
        <div class="d-flex justify-content-center mb-3 flex-wrap">
          <button class="btn btn-outline-primary mx-1" id="dailyBtn">Daily</button>
          <button class="btn btn-outline-primary mx-1" id="weeklyBtn">Weekly</button>
          <button class="btn btn-outline-primary mx-1" id="monthlyBtn">Monthly</button>
          <button class="btn btn-outline-primary mx-1" id="yearlyBtn">Yearly</button>
        </div>

        <canvas id="uploadChart" height="120"></canvas>
      </div>
    </div>
  </div>
</div>
<!-- Chart.js and your custom JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="src/uploadChart.js"></script>


                <script src="bundle.js"></script>

                
                  <h2>Uploaded Files</h2>
                  <ul id="fileList"></ul>
                   <!-- Recently Uploaded (toggleable) -->

             <div class="recent-box collapsed" id="recentBox">
                <div class="recent-header" style="display:flex;align-items:center;justify-content:space-between;">
                  <h3>Recently Uploaded</h3>
                  <button id="toggleRecent" class="arrow-btn">⮞</button>
                </div>
                <ul id="recentList"></ul>
              </div>



                  <script type="module" src="src/display.js"></script>

<!-- Put this where you want the pager -->
<nav id="pager" class="pager" aria-label="Pagination"></nav>


<script type="module" src="src/upload.js"></script>

<!-- Main File Modal -->
<div id="fileModal" class="modal">
  <div class="modal-content">
    <button onclick="closeModal()" class="close-btn">&times;</button>
    
    <h3 id="modalTitle"></h3>
    <p><strong>Uploader:</strong> <span id="modalUploader"></span></p>
    <p><strong>Date Uploaded:</strong> <span id="modalDate"></span></p>
    <p><strong>Year:</strong> <span id="modalYear"></span></p>
    <p><strong>Authors:</strong> <span id="modalAuthors"></span></p>

    <!-- 🔹 Open PDF in 2nd modal -->
<button type="button" onclick="openPdfModal()" class="btn btn-primary">View PDF</button>
  <h4>Comments</h4>
 <!-- Scrollable comment container -->
    <div class="comments-wrapper">
      <div id="modalComments"></div>
    </div>
    <!-- Comments -->
        <div class="comment-input-area">
      <textarea id="newComment" placeholder="Write a comment..." rows="3" class="comment-input"></textarea>
      <button id="postCommentBtn" class="comment-btn">Post Comment</button>
  </div>
</div>

<!-- PDF Side Modal -->
<div id="pdfModal" class="side-modal">
  <div class="side-modal-content">
    <button onclick="closePdfModal()" class="close-btn">&times;</button>
    <div id="pdfViewer" style="width:100%;height:100%;">
      <!-- PDF will be injected here -->
    </div>
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
    