// src/pagination.js
export function buildPager(container, totalPages, currentPage, onPageChange) {
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

  // First pages
  for (let i = 1; i <= Math.min(3, totalPages); i++) {
    container.appendChild(makeBtn(i, i, i === currentPage));
  }

  // Ellipsis if needed
  if (currentPage > 4) {
    const dots = document.createElement("span");
    dots.textContent = "...";
    container.appendChild(dots);
  }

  // Middle page
  if (currentPage > 3 && currentPage < totalPages - 2) {
    container.appendChild(makeBtn(currentPage, currentPage, true));
  }

  // Ellipsis before last pages
  if (currentPage < totalPages - 3) {
    const dots = document.createElement("span");
    dots.textContent = "...";
    container.appendChild(dots);
  }

  // Last pages
  for (let i = Math.max(totalPages - 2, 4); i <= totalPages; i++) {
    if (i > 3) container.appendChild(makeBtn(i, i, i === currentPage));
  }

  // Last button
  if (totalPages > 5) {
    const lastBtn = makeBtn("Last", totalPages, false);
    container.appendChild(lastBtn);
  }
}
