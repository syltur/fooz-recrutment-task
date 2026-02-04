/**
 * Task 4.1: AJAX - Load latest 20 books dynamically
 */
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('latest-books-container');

    if (container) {
        const excludeId = container.getAttribute('data-exclude-id');
        const formData = new FormData();
        formData.append('action', 'get_latest_books');
        formData.append('exclude_id', excludeId);
        formData.append('nonce', fooz_ajax_obj.nonce);

        fetch(fooz_ajax_obj.ajax_url, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    let html = '<ul>';
                    data.forEach(book => {
                        html += `
                        <li>
                            <strong>${book.name}</strong> (${book.date})<br>
                            <small>Genre: ${book.genre}</small>
                            <div class="short-excerpt">${book.excerpt}</div>
                        </li>`;
                    });
                    html += '</ul>';
                    container.innerHTML = html;
                } else {
                    container.innerHTML = 'No other books found.';
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                container.innerHTML = 'Error loading books.';
            });
    }
});
