import { initializeApp, getApps } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getStorage } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-storage.js";

// 🔧 Firebase Config
const firebaseConfig = {
  apiKey: "AIzaSyCCOQXwGVOXD4xtEH4q4Br8Qs0U150zIRw",
  authDomain: "ctraker-7f380.firebaseapp.com",
  projectId: "ctraker-7f380",
  storageBucket: "ctraker-7f380.firebasestorage.app",
  messagingSenderId: "452705756660",
  appId: "1:452705756660:web:e1357e8eb1de5c8b7605a1",
  measurementId: "G-2WJLE6SZED"
};;

// 🔒 Avoid duplicate initialization
let app;
if (!getApps().length) {
  app = initializeApp(firebaseConfig);
} else {
  app = getApps()[0];
}
const storage = getStorage(app);

let currentFileName = null;

// 📂 Load uploaded files
async function listUploadedFiles() {
  const list = document.getElementById('fileList');
  list.innerHTML = 'Loading...';

  try {
    const res = await fetch('api/get_files.php');
    const files = await res.json();
    list.innerHTML = '';

    files.forEach(file => {
      const li = document.createElement('li');
      li.classList.add('file-item');

      const link = document.createElement('a');
      link.href = "#";
      link.textContent = file.filename;

      link.addEventListener('click', (e) => {
        e.preventDefault();
        currentFileName = file.filename;
        openModal(file);
        fetchComments(currentFileName);
      });

      li.appendChild(link);
      list.appendChild(li);
    });

  } catch (err) {
    console.error("❌ Failed to fetch file metadata:", err);
    list.innerHTML = 'Failed to load files.';
  }
}

// 📄 Open modal
function openModal(file) {
  document.getElementById('modalTitle').textContent = file.filename;
  document.getElementById('modalUploader').textContent = file.uploaded_by;
  document.getElementById('modalDate').textContent = file.date_uploaded;
  document.getElementById('viewFileBtn').href = file.url;
  document.getElementById('fileModal').style.display = 'flex';
  document.getElementById('newComment').value = '';
}

// ❌ Close modal
window.closeModal = function () {
  document.getElementById('fileModal').style.display = 'none';
};

// 💬 Post comment
document.getElementById('postCommentBtn').addEventListener('click', () => {
  const comment = document.getElementById('newComment').value.trim();
  if (!comment || !currentFileName) return;

  fetch('api/post_comment.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ file: currentFileName, comment })
  })
    .then(res => res.json())
    .then(response => {
      if (response.success) {
        document.getElementById('newComment').value = '';
        fetchComments(currentFileName);
      } else {
        console.error("❌ Error posting comment:", response.error);
      }
    });
});

// 🔁 Fetch comments
function fetchComments(filename) {
  fetch(`api/get_comments.php?file=${encodeURIComponent(filename)}`)
    .then(res => res.json())
    .then(data => {
      const commentDiv = document.getElementById('modalComments');
      commentDiv.innerHTML = '';

      if (!data.length) {
        commentDiv.innerHTML = "<p>No comments yet.</p>";
        return;
      }

      data.forEach(comment => {
        const commentBlock = document.createElement('div');
        commentBlock.classList.add('comment-block');

        const mainComment = document.createElement('p');
        mainComment.innerHTML = `
          <strong>${comment.username}</strong> 
          <span style="color: gray; font-size: 0.8em;">(${comment.created_at})</span><br>
          ${comment.comment}`;
        commentBlock.appendChild(mainComment);

        if (comment.replies && comment.replies.length > 0) {
          comment.replies.forEach(reply => {
            const replyP = document.createElement('p');
            replyP.classList.add('reply');
            replyP.innerHTML = `
              <em>
                <strong>${reply.username}</strong> 
                <span style="color: gray; font-size: 0.8em;">(${reply.created_at})</span><br>
                ${reply.comment}
              </em>`;
            commentBlock.appendChild(replyP);
          });
        }

        const replyBtn = document.createElement('button');
        replyBtn.textContent = "Reply";
        replyBtn.classList.add('reply-btn');

        const replyBox = document.createElement('div');
        replyBox.classList.add('reply-box');
        replyBox.style.display = 'none';

        const replyInput = document.createElement('textarea');
        replyInput.placeholder = "Write a reply...";
        replyInput.rows = 2;

        const sendBtn = document.createElement('button');
        sendBtn.textContent = "Send";
        sendBtn.classList.add('send-reply');

        sendBtn.addEventListener('click', () => {
          const replyText = replyInput.value.trim();
          if (!replyText) return;

          fetch('api/post_comment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              file: currentFileName,
              comment: replyText,
              parent_id: comment.id
            })
          })
            .then(res => res.json())
            .then(() => {
              replyInput.value = '';
              fetchComments(currentFileName);
            });
        });

        replyBtn.addEventListener('click', () => {
          replyBox.style.display = replyBox.style.display === 'none' ? 'block' : 'none';
        });

        replyBox.appendChild(replyInput);
        replyBox.appendChild(sendBtn);
        commentBlock.appendChild(replyBtn);
        commentBlock.appendChild(replyBox);
        commentDiv.appendChild(commentBlock);
      });

      setTimeout(() => {
        commentDiv.scrollTop = commentDiv.scrollHeight;
      }, 100);
    })
    .catch(err => {
      console.error("Error fetching comments:", err);
    });
}

// 🚀 On page load
window.addEventListener('DOMContentLoaded', listUploadedFiles);

// 🟨 Approval modal logic
document.addEventListener('DOMContentLoaded', () => {
  const openBtn = document.getElementById('openApprovalModal');
  if (openBtn) {
    openBtn.addEventListener('click', () => {
      document.getElementById('approvalModal').style.display = 'flex';
      loadPendingFiles();
    });
  }
});

// Make accessible in HTML
window.closeApprovalModal = function () {
  document.getElementById('approvalModal').style.display = 'none';
};

window.approveFile = function (id) {
  fetch('api/approve_file.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `file_id=${id}`
  })
    .then(() => {
      const item = document.querySelector(`[data-file-id="${id}"]`);
      if (item) item.remove();

      // Refresh both lists
      loadPendingFiles();      // refresh modal
      listUploadedFiles();     // refresh approved files list
    });
};
function loadPendingFiles() {
  fetch('api/get_pending_files.php') // ✅
    .then(res => res.json())
    .then(files => {
      const listDiv = document.getElementById('pendingFilesList');
      listDiv.innerHTML = '';

      if (!files.length) {
        listDiv.innerHTML = "<p>No pending files.</p>";
        return;
      }

      files.forEach(file => {
        const item = document.createElement('div');
        item.classList.add('file-item');

        item.innerHTML = `
          <p><strong>${file.filename}</strong> by ${file.uploaded_by}</p>
          <p>Capstone: ${file.capstone_title}</p>
          <a href="${file.url}" target="_blank">🔍 View PDF</a><br><br>
          <button onclick="approveFile(${file.id})">Approve</button>
        `;

        listDiv.appendChild(item);
      });
    });
}
