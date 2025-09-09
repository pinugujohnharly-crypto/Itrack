// Firebase SDK v10+ Modular Import
import { initializeApp, getApps } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getStorage, ref, uploadBytes, getDownloadURL } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-storage.js";

// Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyCCOQXwGVOXD4xtEH4q4Br8Qs0U150zIRw",
  authDomain: "ctraker-7f380.firebaseapp.com",
  projectId: "ctraker-7f380",
  storageBucket: "ctraker-7f380.firebasestorage.app",
  messagingSenderId: "452705756660",
  appId: "1:452705756660:web:e1357e8eb1de5c8b7605a1",
  measurementId: "G-2WJLE6SZED"
};

// ✅ Prevent duplicate initialization
const app = getApps().length === 0 ? initializeApp(firebaseConfig) : getApps()[0];
const storage = getStorage(app);

// Handle upload form submission
document.getElementById('uploadForm').addEventListener('submit', async (e) => {
  e.preventDefault();

  const uploader = e.target.uploader.value.trim();
  const title = e.target.title.value.trim();
  const year = e.target.year.value.trim();
  const authors = e.target.authors.value.trim();
  const file = e.target.pdf.files[0];

  if (!uploader || !title || !year || !authors || !file) {
    alert("Please fill out all fields.");
    return;
  }

  const status = document.getElementById('uploadStatus');
  status.textContent = "Uploading...";

  try {
    // Upload to Firebase Storage
    const storageRef = ref(storage, 'pdfs/' + file.name);
    await uploadBytes(storageRef, file);

    // Get public file URL
    const url = await getDownloadURL(storageRef);

    // Send metadata to your PHP backend
    const res = await fetch('save_to_db.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        filename: file.name,
        url: url,
        uploaded_by: uploader,
        capstone_title: title,
        year_published: year,
        authors: authors
      })
    });

    const resultText = await res.text();
    status.textContent = resultText;

    // Optionally clear the form
    if (res.ok) e.target.reset();

  } catch (err) {
    console.error("❌ Upload error:", err);
    status.textContent = "❌ Upload failed. Check console.";
  }
});
