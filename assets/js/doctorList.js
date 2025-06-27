function filterDoctors() {
    const dept = document.getElementById('departmentFilter').value.toLowerCase();
    const keyword = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.doctor-grid .card');

    cards.forEach(card => {
        const name = card.querySelector('h4').textContent.toLowerCase();
        const title = card.querySelector('p').textContent.toLowerCase();
        const department = card.getAttribute('data-department').toLowerCase();

        const matchesNameOrTitle = name.includes(keyword) || title.includes(keyword);
        const matchesDept = (dept === 'all') || (department === dept);

        if (matchesNameOrTitle && matchesDept) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}