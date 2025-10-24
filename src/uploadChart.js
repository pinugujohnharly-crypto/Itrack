document.addEventListener("DOMContentLoaded", () => {
  const uploadModal = document.getElementById("uploadStatsModal");
  const openUploadBtn = document.querySelector('[data-bs-target="#uploadStatsModal"]');
  const closeUploadBtn = document.getElementById("closeUploadStatsModal");
  const chartCanvas = document.getElementById("uploadChart");

  // ===== Modal Controls =====
  if (openUploadBtn && uploadModal) {
    openUploadBtn.addEventListener("click", () => {
      uploadModal.style.display = "flex";
      uploadModal.classList.add("show");
      uploadModal.removeAttribute("aria-hidden");
      document.body.classList.add("modal-open");
      loadChartData("daily"); // auto-load when opened
    });
  }

  if (closeUploadBtn && uploadModal) {
    closeUploadBtn.addEventListener("click", () => {
      uploadModal.style.display = "none";
      uploadModal.classList.remove("show");
      uploadModal.setAttribute("aria-hidden", "true");
      document.body.classList.remove("modal-open");
    });
  }

  // Close modal when clicking outside
  uploadModal?.addEventListener("click", (e) => {
    if (e.target === uploadModal) {
      uploadModal.style.display = "none";
      uploadModal.classList.remove("show");
      uploadModal.setAttribute("aria-hidden", "true");
      document.body.classList.remove("modal-open");
    }
  });

  // ===== Chart.js Setup =====
  if (!chartCanvas || typeof Chart === "undefined") {
    console.error("Chart.js or canvas not found.");
    return;
  }

  const ctx = chartCanvas.getContext("2d");

  const uploadChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [],
      datasets: [{
        label: "Uploaded Files",
        data: [],
        backgroundColor: "rgba(13, 110, 253, 0.6)",
        borderColor: "rgba(13, 110, 253, 1)",
        borderWidth: 1,
        borderRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          ticks: { color: "#333" },
          grid: { color: "rgba(0, 0, 0, 0.05)" }
        },
        y: {
          beginAtZero: true,
          ticks: { color: "#333" },
          grid: { color: "rgba(0, 0, 0, 0.05)" }
        }
      },
      plugins: {
        legend: { labels: { color: "#333" } },
        tooltip: {
          backgroundColor: "#0d6efd",
          titleColor: "#fff",
          bodyColor: "#fff"
        }
      }
    }
  });

  // ===== Load Chart Data =====
  async function loadChartData(type = "daily") {
    try {
      const response = await fetch(`api/get_upload_stats.php?type=${type}`);
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      const json = await response.json();
      const data = json.data || [];

      uploadChart.data.labels = data.map(d => d.label);
      uploadChart.data.datasets[0].data = data.map(d => d.uploaded);
      uploadChart.update();

      setActiveButton(type);
    } catch (error) {
      console.error("Error loading chart data:", error);
    }
  }

  // ===== Button States =====
  function setActiveButton(activeType) {
    ["daily", "weekly", "monthly", "yearly"].forEach(type => {
      const btn = document.getElementById(`${type}Btn`);
      if (btn) btn.classList.toggle("active", type === activeType);
    });
  }

  // ===== Time Range Buttons =====
  ["daily", "weekly", "monthly", "yearly"].forEach(type => {
    const btn = document.getElementById(`${type}Btn`);
    if (btn) btn.addEventListener("click", () => loadChartData(type));
  });
});
