document.addEventListener("DOMContentLoaded", () => {
  const ctx = document.getElementById("uploadChart").getContext("2d");

  // Initialize Chart.js bar chart
  const uploadChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [],
      datasets: [{
        label: "Uploaded Files",
        data: [],
        backgroundColor: "rgba(54, 162, 235, 0.6)"
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Fetch and update chart data
  async function loadChartData(type = 'daily') {
    try {
      const res = await fetch(`api/get_upload_stats.php?type=${type}`);
      const json = await res.json();
      const data = json.data || [];

      uploadChart.data.labels = data.map(d => d.label);
      uploadChart.data.datasets[0].data = data.map(d => d.uploaded);
      uploadChart.update();

      setActiveButton(type);
    } catch (error) {
      console.error('Error loading chart data:', error);
    }
  }

  // Highlight the active button
  function setActiveButton(activeType) {
    ['daily', 'weekly', 'monthly', 'yearly'].forEach(type => {
      const btn = document.getElementById(`${type}Btn`);
      if (btn) btn.classList.toggle('active', type === activeType);
    });
  }

  // Load default (daily) data when modal opens
  const modal = document.getElementById('uploadStatsModal');
  modal.addEventListener('shown.bs.modal', () => {
    loadChartData('daily');
  });

  // Button event listeners
  document.getElementById("dailyBtn").addEventListener("click", () => loadChartData("daily"));
  document.getElementById("weeklyBtn").addEventListener("click", () => loadChartData("weekly"));
  document.getElementById("monthlyBtn").addEventListener("click", () => loadChartData("monthly"));
  document.getElementById("yearlyBtn").addEventListener("click", () => loadChartData("yearly"));
});
