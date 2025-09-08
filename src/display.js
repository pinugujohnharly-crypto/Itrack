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

// 🆕 helper: try to pull "file: <filename>" from notif body
function extractFilenameFromBody(body) {
  const m = String(body || '').match(/file:\s*(.+)$/i);
  return m ? m[1].trim() : '';
}

let currentFileName = null;

// ===== Approved files list =====
async function listUploadedFiles() {
  const list = document.getElementById('fileList');
  if (!list) return;
  list.innerHTML = 'Loading...';

  try {
    const res = await fetch('api/get_files.php', { cache: 'no-store' });
    const files = await res.json();
    list.innerHTML = '';

    files.forEach(file => {
      const li = document.createElement('li');
      li.classList.add('file-item');

      const link = document.createElement('a');
      link.href = "#";
      link.textContent = file.capstone_title || file.filename;

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

// ===== File modal + comments =====
function openModal(file) {
  document.getElementById('modalTitle').textContent = file.capstone_title || file.filename;
  document.getElementById('modalUploader').textContent = file.uploaded_by ?? '';
  document.getElementById('modalDate').textContent = file.date_uploaded ?? '';
  document.getElementById('viewFileBtn').href = file.url ?? '#';
  document.getElementById('fileModal').style.display = 'flex';
  document.getElementById('newComment').value = '';
}
window.closeModal = function () {
  document.getElementById('fileModal').style.display = 'none';
};

document.getElementById('postCommentBtn')?.addEventListener('click', () => {
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

// 🆕 tag each comment element so we can scroll/highlight a specific reply later
function renderComment(comment, isReply = false) {
  const commentEl = document.createElement('div');
  commentEl.classList.add('comment');
  if (isReply) commentEl.classList.add('reply');
  commentEl.dataset.commentId = comment.id; // <-- key line

  const avatar = document.createElement('div');
  avatar.classList.add('avatar');

  const body = document.createElement('div');
  body.classList.add('comment-body');

  const username = document.createElement('div');
  username.classList.add('username');
  username.textContent = comment.username;

  const text = document.createElement('div');
  text.classList.add('text');
  text.textContent = comment.comment;

  const actions = document.createElement('div');
  actions.classList.add('comment-actions');
  actions.innerHTML = `

    <span class="reply-btn">Reply</span>
    <span class="time">${comment.created_at}</span>
  `;

  const replyBox = document.createElement('div');
  replyBox.classList.add('reply-box');
  replyBox.style.display = 'none';
  replyBox.innerHTML = `
    <textarea rows="2" placeholder="Write a reply..."></textarea>
    <button class="send-reply">Send</button>
  `;

  actions.querySelector('.reply-btn').addEventListener('click', () => {
    replyBox.style.display = replyBox.style.display === 'none' ? 'block' : 'none';
  });

  replyBox.querySelector('.send-reply').addEventListener('click', () => {
    const replyText = replyBox.querySelector('textarea').value.trim();
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
    .then(response => {
      if (response.success) fetchComments(currentFileName);
    });
  });

  body.appendChild(username);
  body.appendChild(text);
  body.appendChild(actions);
  body.appendChild(replyBox);

  commentEl.appendChild(avatar);
  commentEl.appendChild(body);

  if (comment.replies && comment.replies.length > 0) {
    const repliesContainer = document.createElement('div');
    repliesContainer.classList.add('replies');

    comment.replies.forEach(reply => {
      const replyEl = renderComment(reply, true);
      repliesContainer.appendChild(replyEl);
    });

    body.appendChild(repliesContainer);
  }

  return commentEl;
}

// 🆕 support optional highlightId: scroll & flash the exact reply
function fetchComments(filename, highlightId = null) {
  fetch(`api/get_comments.php?file=${encodeURIComponent(filename)}`, { cache: 'no-store' })
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

      if (highlightId) {
        const target = commentDiv.querySelector(`[data-comment-id="${highlightId}"]`);
        if (target) {
          target.classList.add('highlight');
          target.scrollIntoView({ behavior: 'smooth', block: 'center' });
          setTimeout(() => target.classList.remove('highlight'), 2500);
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

// Make accessible in HTML
window.closeApprovalModal = function () {
  document.getElementById('approvalModal').style.display = 'none';
};

window.approveFile = function (id) {
  fetch('api/approve_file.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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

  fetch('api/reject_file.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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
  fetch('api/get_pending_files.php', { cache: 'no-store' })
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

// ===== Notification bell (absolute path avoids 404 from nested pages) =====
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
  // Use absolute path so it works regardless of page depth
  fetch('/tracker/Itrack/api/list_my_notifications.php', { cache: 'no-store' })
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

        // 🆕 Make comment-type notifs clickable and stash ref + file
        if (n.type === 'comment') {
          el.classList.add('clickable');
          if (n.ref_id) el.dataset.refId = n.ref_id;
          const f = extractFilenameFromBody(n.body);
          if (f) el.dataset.file = f;
        }

        list.appendChild(el);
      });

      // 🔔 badge shows UNREAD count (not last-24h)
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
window.addEventListener('DOMContentLoaded', listUploadedFiles);

// Per-item actions + comment-notif click to open modal & jump to reply
document.getElementById('notifList')?.addEventListener('click', async (e) => {
  // 🆕 open modal & jump to reply when clicking a reply notification row (but not the small action buttons)
  const row = e.target.closest('.notif-item.clickable');
  const clickedAction = e.target.closest('.mark-read, .delete-notif');
  if (row && !clickedAction) {
    const refId = +row.dataset.refId;
    const file  = row.dataset.file;
    if (refId && file) {
      // Optimistically mark as read (optional)
      const idFromButtons = row.querySelector('.mark-read')?.dataset.id;
      if (idFromButtons) {
        try {
          await fetch('/tracker/Itrack/api/mark_notification_read.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ id: idFromButtons })
          });
        } catch {}
      }

      // Open the modal and highlight the exact reply
      currentFileName = file;
      openModal({ capstone_title: file, filename: file, uploaded_by: '', date_uploaded: '', url: '#' });
      fetchComments(file, refId);

      // Refresh badge shortly
      setTimeout(loadMyNotifications, 400);
    }
    return;
  }

  // ===== existing per-item actions: mark read / delete =====
  const readBtn = e.target.closest('.mark-read');
  const delBtn  = e.target.closest('.delete-notif');

  if (readBtn) {
    const id = +readBtn.dataset.id; if (!id) return;
    // ✅ single-item endpoint
    fetch('/tracker/Itrack/api/mark_notification_read.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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

  if (delBtn) {
    const id = +delBtn.dataset.id; if (!id) return;
    if (!confirm('Delete this notification?')) return;
    fetch('/tracker/Itrack/api/delete_notification.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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
