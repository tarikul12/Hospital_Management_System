// Auto-refresh every 5 seconds
    setInterval(() => {
        location.reload();
    }, 5000);

    // Search filtering logic (client-side only)
    function searchPatient() {
        const searchValue = document.getElementById("searchInput").value.trim().toLowerCase();
        const rows = document.querySelectorAll("table tr");

        for (let i = 1; i < rows.length; i++) {
            const idCell = rows[i].querySelector("td");
            if (idCell) {
                const id = idCell.textContent.trim().toLowerCase();
                rows[i].style.display = id.includes(searchValue) ? "" : "none";
            }
        }

        return false; // Prevent form submission
    }

$(document).ready(function () {
    $('#historyTable').DataTable({
        // options
    });
});
