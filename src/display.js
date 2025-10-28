// ===== Firebase (verify storageBucket in Firebase console if Storage errors) =====
import { initializeApp, getApps } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getStorage } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-storage.js";

const firebaseConfig = {
  apiKey: "AIzaSyCCOQXwGVOXD4xtEH4q4Br8Qs0U150zIRw",
  authDomain: "ctraker-7f380.firebaseapp.com",
  projectId: "ctraker-7f380",
  storageBucket: "ctraker-7f380.firebasestorage.app",
  messagingSenderId: "452705756660",
  appId: "1:452705756660:web:e1357e8eb1de5c8b7605a1",
  measurementId: "G-2WJLE6SZED"
};

let app;
if (!getApps().length) app = initializeApp(firebaseConfig);
else app = getApps()[0];
const storage = getStorage(app);

// ===== API base (auto-detect environment) =====
const API_BASE = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1'
  ? 'http://localhost/itrack'
  : '';  // Empty string for root

// ===== Utils =====
function escapeHtml(s) {
  return String(s ?? '')
    .replaceAll('&','&amp;').replaceAll('<','&lt;')
    .replaceAll('>','&gt;').replaceAll('"','&quot;')
    .replaceAll("'","&#39;");
}
function timeAgo(ts) {
  const d = new Date(ts);
  const diff = Math.floor((Date.now() - d.getTime()) / 1000);
  if (diff < 60) return `${diff}s ago`;
  const m = Math.floor(diff/60); if (m < 60) return `${m}m ago`;
  const h = Math.floor(m/60); if (h < 24) return `${h}h ago`;
  const days = Math.floor(h/24); return days === 1 ? '1 day ago' : `${days} days ago`;
}

// Try to pull "file: <filename>" from notif body
function extractFilenameFromBody(body) {
  const m = String(body || '').match(/file:\s*(.+)$/i);
  return m ? m[1].trim() : '';
}
let currentFileUrl = null;
let currentFileName = null;
// ===== Approved files list with pagination =====

async function loadRecentFiles() {
  const list = document.getElementById("recentList");
  if (!list) return;

  try {
    const res = await fetch(`${API_BASE}/api/get_recent_files.php`, { cache: "no-store" });
    const { files } = await res.json();

    list.innerHTML = "";

    if (!files || files.length === 0) {
      list.innerHTML = "<li>No recent uploads</li>";
      return;
    }

   files.forEach(file => {
  const li = document.createElement("li");

  const link = document.createElement("a");
  link.href = "#";
  link.textContent = file.capstone_title || file.filename;

  // 🔹 Reuse the SAME logic as main file list
  link.addEventListener("click", (e) => {
    e.preventDefault();
    currentFileName = file.filename;
    openModal(file);             // ✅ same modal you already use
    fetchComments(currentFileName);
  });

  const meta = document.createElement("small");
  meta.textContent = ` (${file.date_uploaded})`;

  li.appendChild(link);
  li.appendChild(meta);
  list.appendChild(li);
});

  } catch (err) {
    console.error("Failed to load recent files", err);
  }
}
window.addEventListener('DOMContentLoaded', () => {
  loadRecentFiles();
  // 🔹 Toggle slide in/out for recent box
 const toggleBtn = document.getElementById("toggleRecent");
const recentBox = document.getElementById("recentBox");

 // ✅ Always start OPEN (remove collapsed on load)
  if (recentBox) {
    recentBox.classList.remove("collapsed");
    if (toggleBtn) toggleBtn.textContent = "⮜"; // left arrow for open state
  }
toggleBtn?.addEventListener("click", () => {
  recentBox.classList.toggle("collapsed");
  toggleBtn.textContent = recentBox.classList.contains("collapsed") ? "⮞" : "⮜";
  
});

});

async function listUploadedFiles(page = 1) {
  const list = document.getElementById("fileList");
  if (!list) return;
  list.innerHTML = "";
  for (let i = 0; i < 9; i++) {
    const skeleton = document.createElement("li");
    skeleton.classList.add("skeleton-item");
    skeleton.innerHTML = `
      <div class="skeleton skeleton-line" style="width: 70%; height: 16px;"></div>
      <div class="skeleton skeleton-line short" style="width: 40%; height: 12px;"></div>
    `;
    list.appendChild(skeleton);
  }

  try {
// ✅ Ask backend for files + pagination info
    const res = await fetch(`${API_BASE}/api/get_files.php?page=${page}`, { cache: "no-store", credentials: "include" });
    const text = await res.text();  // Get raw text first
    console.log("Raw response:", text);  // See what's actually returned
    const data = JSON.parse(text);  // Then parse
    const { files, totalPages } = data;

    list.innerHTML = "";

    // Render files
    files.forEach(file => {
      const li = document.createElement("li");
      li.classList.add("file-item");

      const link = document.createElement("a");
      link.href = "#";
      const title = file.capstone_title || file.filename;
      const year  = file.year_published ? ` (${file.year_published})` : '';
      link.textContent = title + year;

      link.addEventListener("click", (e) => {
        e.preventDefault();
        currentFileName = file.filename;
        openModal(file);
        fetchComments(currentFileName);
      });

      // optional: authors line
      const meta = document.createElement("div");
      meta.classList.add("file-meta");
      meta.textContent = file.authors ? `Authors: ${file.authors}` : "";

      li.appendChild(link);
      li.appendChild(meta);
      list.appendChild(li);
    });

    // ✅ Render pager below file list
    const pager = document.getElementById("pager");
    if (pager) {
      buildPager(pager, totalPages, page, listUploadedFiles);
    }

  } catch (err) {
    console.error("❌ Failed to fetch file metadata:", err);
    list.innerHTML = "Failed to load files.";
  }
}
// ===== Pagination builder =====
function buildPager(container, totalPages, currentPage, onPageChange) {
  container.innerHTML = "";

  if (totalPages <= 1) return;

  // Helper to create button
  const makeBtn = (label, page, isActive = false) => {
    const btn = document.createElement("button");
    btn.textContent = label;
    btn.className = "pager-btn" + (isActive ? " active" : "");
    btn.onclick = () => onPageChange(page);
    return btn;
  };

  // Always show first 2 pages
  for (let i = 1; i <= Math.min(2, totalPages); i++) {
    container.appendChild(makeBtn(i, i, i === currentPage));
  }

  // Ellipsis if currentPage is far
  if (currentPage > 3) {
    const dots = document.createElement("span");
    dots.textContent = "...";
    container.appendChild(dots);
  }

  // Middle (current) page
  if (currentPage > 2 && currentPage < totalPages - 1) {
    container.appendChild(makeBtn(currentPage, currentPage, true));
  }

  // Ellipsis before last
  if (currentPage < totalPages - 2) {
    const dots = document.createElement("span");
    dots.textContent = "...";
    container.appendChild(dots);
  }

  // Always show last 2 pages
  for (let i = Math.max(totalPages - 1, 3); i <= totalPages; i++) {
    container.appendChild(makeBtn(i, i, i === currentPage));
  }

  // Optional "Last" button
  if (totalPages > 5 && currentPage !== totalPages) {
    container.appendChild(makeBtn("Last", totalPages));
  }
}


// ===== File modal + comments =====

function openModal(file) {

  document.getElementById('modalTitle').textContent = file.capstone_title || file.filename;
  document.getElementById('modalUploader').textContent =  (file.uploaded_by ?? '');
  document.getElementById('modalDate').textContent = (file.date_uploaded ?? '');
  document.getElementById('modalYear').textContent = (file.year_published ?? '');
  document.getElementById('modalAuthors').textContent = (file.authors ?? '');

  // stash PDF url for 2nd modal
  currentFileUrl = file.url ?? null;
   console.log("🔗 URL for preview:", currentFileUrl); // 👈 DEBUG

  document.getElementById('fileModal').style.display = 'flex';
  document.getElementById('newComment').value = '';
}

window.closeModal = function () {
  document.getElementById('fileModal').style.display = 'none';
};

// ===== PDF modal handling =====
window.openPdfModal = function () {
  const pdfContainer = document.getElementById('pdfViewer');

  if (currentFileUrl) {
    console.log("📄 Opening PDF:", currentFileUrl);
    pdfContainer.innerHTML = `<iframe src="${currentFileUrl}" style="width:100%;height:100%;border:none;"></iframe>`;
  } else {
    console.warn("⚠️ No URL found for PDF preview");
    pdfContainer.innerHTML = `<p>No PDF available (URL missing)</p>`;
  }

  document.getElementById('pdfModal').classList.add('active');
};

window.closePdfModal = function () {
  document.getElementById('pdfModal').classList.remove('active');
};

// ===== Comments (same as before) =====

document.getElementById('postCommentBtn')?.addEventListener('click', () => {
  const comment = document.getElementById('newComment').value.trim();
  if (!comment || !currentFileName) return;

  fetch(`${API_BASE}/api/post_comment.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
    body: JSON.stringify({ file: currentFileName, comment })
  })
  .then(res => res.json())
  .then(response => {
    if (response.success) {
      document.getElementById('newComment').value = '';
      fetchComments(currentFileName, response.comment_id); // use PHP's key
    } else {
      console.error("❌ Error posting comment:", response.error);
      alert(response.error || 'Failed to post comment.');
    }
  })
  .catch(err => {
    console.error('❌ Network error posting comment:', err);
    alert('Network error.');
  });
});

// ===== Comment renderer (one-level replies + "Replying to @Name") =====
function renderComment(comment, isReply = false, parentUser = null) {
  const commentEl = document.createElement('div');
  commentEl.classList.add('comment');
  if (isReply) commentEl.classList.add('reply');
  commentEl.dataset.commentId = comment.id;

  const avatar = document.createElement('div');
  avatar.classList.add('avatar');

  const body = document.createElement('div');
  body.classList.add('comment-body');

  const username = document.createElement('div');
  username.classList.add('username');
  username.textContent = comment.username;

  // “Replying to @Name” line for replies
  if (isReply && parentUser) {
    const replyingTo = document.createElement('div');
    replyingTo.classList.add('in-reply-to');
    replyingTo.textContent = `Replying to @${parentUser}`;
    body.appendChild(replyingTo);
  }

  const text = document.createElement('div');
  text.classList.add('text');
  text.textContent = comment.comment;

  const actions = document.createElement('div');
  actions.classList.add('comment-actions');

  // Only allow reply on top-level comments
  if (!isReply) {
    const replyBtn = document.createElement('span');
    replyBtn.className = 'reply-btn';
    replyBtn.textContent = 'Reply';
    actions.appendChild(replyBtn);

    const replyBox = document.createElement('div');
    replyBox.classList.add('reply-box');
    replyBox.style.display = 'none';
    replyBox.innerHTML = `
      <textarea rows="2" placeholder="Write a reply..."></textarea>
      <button class="send-reply">Send</button>
    `;

    replyBtn.addEventListener('click', () => {
      const ta = replyBox.querySelector('textarea');
      if (!ta.value.trim()) ta.value = `@${comment.username} `;
      replyBox.style.display = replyBox.style.display === 'none' ? 'block' : 'none';
      ta.focus();
    });

    replyBox.querySelector('.send-reply').addEventListener('click', () => {
      const replyText = replyBox.querySelector('textarea').value.trim();
      if (!replyText) return;

      fetch(`${API_BASE}/api/post_comment.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',
        body: JSON.stringify({
          file: currentFileName,
          comment: replyText,
          parent_id: comment.id
        })
      })
      .then(res => res.json())
      .then(response => {
        if (response.success) {
          fetchComments(currentFileName, response.comment_id);
        } else {
          console.error("❌ Error posting reply:", response.error);
          alert(response.error || 'Failed to post reply.');
        }
      })
      .catch(err => {
        console.error('❌ Network error posting reply:', err);
        alert('Network error.');
      });
    });

    body.appendChild(replyBox);
  }

  const time = document.createElement('span');
  time.className = 'time';
  time.textContent = comment.created_at;
  actions.appendChild(time);

  body.appendChild(username);
  body.appendChild(text);
  body.appendChild(actions);

  commentEl.appendChild(avatar);
  commentEl.appendChild(body);

  // ONE-LEVEL ONLY: render direct children; no replies of replies
  if (!isReply && Array.isArray(comment.replies) && comment.replies.length > 0) {
    const repliesContainer = document.createElement('div');
    repliesContainer.classList.add('replies');

    comment.replies.forEach(reply => {
      const replyEl = renderComment(reply, true, comment.username);
      repliesContainer.appendChild(replyEl);
    });

    body.appendChild(repliesContainer);
  }

  return commentEl;
}

// ===== Fetch & optionally highlight one comment =====
function fetchComments(filename, highlightId = null) {
  fetch(`${API_BASE}/api/get_comments.php?file=${encodeURIComponent(filename)}`, { cache: 'no-store', credentials: 'include' })
    .then(res => res.json())
    .then(data => {
      const commentDiv = document.getElementById('modalComments');
      commentDiv.innerHTML = '';

      if (!data.length) {
        commentDiv.innerHTML = "<p>No comments yet.</p>";
        return;
      }

      data.forEach(comment => {
        const commentEl = renderComment(comment);
        commentDiv.appendChild(commentEl);
      });

      // Highlight target reply (from notif or after posting)
      if (highlightId) {
        const target = commentDiv.querySelector(`[data-comment-id="${highlightId}"]`);
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'center' });
          const bubble = target.querySelector('.comment-body') || target;
          bubble.classList.add('flash-highlight');
          setTimeout(() => bubble.classList.remove('flash-highlight'), 2500);
        }
      }
    })
    .catch(err => console.error("Error fetching comments:", err));
}

// ===== Approvals modal =====
document.addEventListener('DOMContentLoaded', () => {
  const openBtn = document.getElementById('openApprovalModal');
  if (openBtn) {
    openBtn.addEventListener('click', () => {
      document.getElementById('approvalModal').style.display = 'flex';
      loadPendingFiles();
    });
  }
});

window.closeApprovalModal = function () {
  document.getElementById('approvalModal').style.display = 'none';
};

window.approveFile = function (id) {
  fetch(`${API_BASE}/api/approve_file.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    credentials: 'include',
    body: new URLSearchParams({ file_id: id })
  })
  .then(async r => {
    const text = await r.text();
    if (!r.ok) { console.error('HTTP error (approve):', r.status, text); throw new Error('HTTP '+r.status); }
    try { return JSON.parse(text); } catch (e) { console.error('Bad JSON (approve):', text); throw e; }
  })
  .then(res => {
    if (!res.ok) return alert(res.error || 'Approve failed');
    const item = document.querySelector(`[data-file-id="${id}"]`);
    if (item) item.remove();
    loadPendingFiles();
    listUploadedFiles && listUploadedFiles();
  })
  .catch(() => alert('Network/parse error (approve). Check console.'));
};

window.rejectFile = function (id) {
  const reason = prompt('Reason for rejection (shown to uploader):');
  if (reason === null) return;

  fetch(`${API_BASE}/api/reject_file.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    credentials: 'include',
    body: new URLSearchParams({ file_id: id, reason })
  })
  .then(async r => {
    const text = await r.text();
    if (!r.ok) { console.error('HTTP error (reject):', r.status, text); throw new Error('HTTP '+r.status); }
    try { return JSON.parse(text); } catch (e) { console.error('Bad JSON (reject):', text); throw e; }
  })
  .then(res => {
    if (!res.ok) return alert(res.error || 'Reject failed');
    const item = document.querySelector(`[data-file-id="${id}"]`);
    if (item) item.remove();
    loadPendingFiles();
    listUploadedFiles && listUploadedFiles();
  })
  .catch(() => alert('Reject failed (network/parse). Check console.'));
};

function loadPendingFiles() {
  fetch(`${API_BASE}/api/get_pending_files.php`, { cache: 'no-store', credentials: 'include' })
    .then(res => res.json())
    .then(files => {
      const listDiv = document.getElementById('pendingFilesList');
      listDiv.innerHTML = '';
      if (!files.length) { listDiv.innerHTML = "<p>No pending files.</p>"; return; }

      files.forEach(file => {
        const item = document.createElement('div');
        item.classList.add('file-item');
        item.dataset.fileId = file.id;
        item.innerHTML = `
          <div class="meta">
            <p><strong>${file.filename}</strong> by ${file.uploaded_by ?? ''}</p>
            <p>Capstone: ${file.capstone_title ?? ''}</p>
            <a href="${file.url}" target="_blank">🔍 View PDF</a>
          </div>
          <div class="actions">
            <button class="btn btn-success" onclick="approveFile(${file.id})">Approve</button>
            <button class="btn btn-danger" onclick="rejectFile(${file.id})">Reject</button>
          </div>`;
        listDiv.appendChild(item);
      });
    });
}

// ===== Notification bell =====
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('notifBtn');
  const dd  = document.getElementById('notifDropdown');
  const badge = document.getElementById('notifBadge');
  const refresh = document.getElementById('notifRefresh');
  const closeBtn = document.getElementById('notifClose');

  if (!btn || !dd) return;

  const toggle = () => {
    const open = dd.getAttribute('aria-hidden') === 'false';
    dd.setAttribute('aria-hidden', open ? 'true' : 'false');
    btn.setAttribute('aria-expanded', open ? 'false' : 'true');
    if (!open) loadMyNotifications();
  };

  btn.addEventListener('click', toggle);
  closeBtn?.addEventListener('click', toggle);
  refresh?.addEventListener('click', (e) => { e.stopPropagation(); loadMyNotifications(); });

  document.addEventListener('click', (e) => {
    if (!dd.contains(e.target) && e.target !== btn) {
      dd.setAttribute('aria-hidden','true');
      btn.setAttribute('aria-expanded','false');
    }
  });

  loadMyNotifications();
  setInterval(loadMyNotifications, 60000);
});

function loadMyNotifications() {
  fetch(`${API_BASE}/api/list_my_notifications.php`, { cache: 'no-store', credentials: 'include' })
    .then(async r => {
      const text = await r.text();
      if (!r.ok) { console.error('HTTP error (notif):', r.status, text); throw new Error('HTTP '+r.status); }
      try { return JSON.parse(text); } catch (e) { console.error('Bad JSON (notif):', text); throw e; }
    })
    .then(({ok, items, error}) => {
      const list  = document.getElementById('notifList');
      const badge = document.getElementById('notifBadge');

      if (!ok) {
        list.innerHTML = `<div class="notif-item"><div class="notif-body"><div class="notif-text">${escapeHtml(error||'Failed to load')}</div></div></div>`;
        badge?.setAttribute('hidden','');
        return;
      }
      if (!Array.isArray(items) || items.length === 0) {
        list.innerHTML = `<div class="notif-item"><div class="notif-body"><div class="notif-text">No notifications yet.</div></div></div>`;
        badge?.setAttribute('hidden','');
        return;
      }

      list.innerHTML = '';

      items.forEach(n => {
        const isRevoked = n.status === 'revoked';
        const isRead    = !!n.read_at;

        // dot color/type (supports comment type)
        const type = n.type === 'comment'
          ? 'comment'
          : (isRevoked
              ? 'rejected'
              : /rejected/i.test((n.title||'') + (n.body||'')) ? 'rejected' : 'approved');

        const actions = `
          <div class="notif-actions">
            <button class="mark-read" data-id="${n.id}" ${isRead ? 'disabled' : ''} title="${isRead ? 'Already read' : 'Mark as read'}">✓</button>
            <button class="delete-notif" data-id="${n.id}" title="Delete">🗑</button>
          </div>`;

        const el = document.createElement('div');
        el.className = 'notif-item' + (isRead ? ' read' : '');
        el.innerHTML = `
          <div class="notif-dot ${type}"></div>
          <div class="notif-body">
            <div class="notif-title">${escapeHtml(n.title||'')}</div>
            <div class="notif-text" style="white-space:pre-line;">${escapeHtml(n.body||'')}</div>
            ${isRevoked && n.revoke_reason ? `<div class="notif-text">Revoked: ${escapeHtml(n.revoke_reason)}</div>` : ''}
            ${isRevoked && n.revoked_at
              ? `<div class="notif-time">Revoked at: ${escapeHtml(n.revoked_at)}</div>`
              : `<div class="notif-time">${timeAgo(n.created_at)}</div>`}
          </div>
          ${actions}
        `;

        // Make comment-type notifs clickable and stash ref + file
        if (n.type === 'comment') {
          el.classList.add('clickable');
          if (n.ref_id) el.dataset.refId = n.ref_id;
          const f = extractFilenameFromBody(n.body);
          if (f) el.dataset.file = f;
        }

        list.appendChild(el);
      });

      // Badge shows UNREAD count
      const unread = items.filter(n => !n.read_at && n.status === 'sent').length;
      if (badge) {
        if (unread > 0) { badge.textContent = String(unread); badge.removeAttribute('hidden'); }
        else { badge.setAttribute('hidden',''); }
      }
    })
    .catch(err => {
      console.error('Notifications failed:', err);
      const list = document.getElementById('notifList');
      if (list) list.innerHTML = `<div class="notif-item"><div class="notif-body"><div class="notif-text">Network/parse error. Check console.</div></div></div>`;
    });
}

// ===== On page load =====
window.addEventListener('DOMContentLoaded', () => listUploadedFiles(1));

// Per-item actions + comment-notif click to open modal & jump to reply
document.getElementById('notifList')?.addEventListener('click', async (e) => {
  // Open modal & jump to reply when clicking a comment notification row
  const row = e.target.closest('.notif-item.clickable');
  const clickedAction = e.target.closest('.mark-read, .delete-notif');
  if (row && !clickedAction) {
    const refId = +row.dataset.refId;
    const file  = row.dataset.file;
    if (refId && file) {
      // Mark as read (optional)
      const idFromButtons = row.querySelector('.mark-read')?.dataset.id;
      if (idFromButtons) {
        try {
          await fetch(`${API_BASE}/api/mark_notifications_read.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            credentials: 'include',
            body: new URLSearchParams({ id: idFromButtons })
          });
        } catch {}
      }

      currentFileName = file;
      openModal({ capstone_title: file, filename: file, uploaded_by: '', date_uploaded: '', url: '#' });
      fetchComments(file, refId);
      setTimeout(loadMyNotifications, 400);
    }
    return;
  }

  // Mark single notification read
    const readBtn = e.target.closest('.mark-read');
  if (readBtn) {
    const id = +readBtn.dataset.id; if (!id) return;
   fetch(`${API_BASE}/api/mark_notifications_read.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      credentials: 'include',
      body: new URLSearchParams({ id })
    })
    .then(r => r.json())
    .then(res => {
      if (!res.ok) return alert(res.error || 'Failed to mark read');
      loadMyNotifications();
    })
    .catch(() => alert('Network error.'));
    return;
  }

  // Delete notification
  const delBtn  = e.target.closest('.delete-notif');
  if (delBtn) {
    const id = +delBtn.dataset.id; if (!id) return;
    if (!confirm('Delete this notification?')) return;
    fetch(`${API_BASE}/api/delete_notification.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      credentials: 'include',
      body: new URLSearchParams({ id })
    })
    .then(r => r.json())
    .then(res => {
      if (!res.ok) return alert(res.error || 'Failed to delete');
      loadMyNotifications();
    })
    .catch(() => alert('Network error.'));
  }
});

//pagination


