// Contributor Modal Controls
const modal = document.getElementById("contributorModal");
const openBtn = document.getElementById("openContributorModal");
const closeBtn = document.getElementById("closeContributorModal");

openBtn?.addEventListener("click", () => {
  modal.style.display = "flex";
});

closeBtn?.addEventListener("click", () => {
  modal.style.display = "none";
});

// Handle form submission
document.getElementById("contributorForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  // Always set role as contributor
  formData.append("role", "contributor");

  try {
    const res = await fetch("api/create_contributor.php", {
      method: "POST",
      body: formData
    });

    const text = await res.text();
    document.getElementById("contributorStatus").textContent = text;

    if (text.includes("successful")) {
      form.reset();
    }

  } catch (err) {
    console.error(err);
    document.getElementById("contributorStatus").textContent = "Error creating contributor.";
  }
});
