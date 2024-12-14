function searchBooks() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#booksTable tbody tr');

    rows.forEach(row => {
        const text = Array.from(row.cells).map(cell => cell.textContent.toLowerCase()).join(' ');
        row.style.display = text.includes(input) ? '' : 'none';
    });
}