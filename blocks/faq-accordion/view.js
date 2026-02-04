/**
 * Task 5: FAQ Accordion Block - Frontend Script
 * 
 * Transforms headings and paragraphs into accordion structure
 * Adds click handlers for expand/collapse behavior
 * Adds programmatic numbering via CSS counter
 */
document.addEventListener('DOMContentLoaded', function () {
    var wrappers = document.querySelectorAll('.fooz-faq-wrapper');

    wrappers.forEach(function (wrapper) {
        var container = wrapper.querySelector('.faq-items-container');
        if (!container) return;

        var headings = container.querySelectorAll('h2, h3, h4');

        headings.forEach(function (heading) {
            // Create FAQ item wrapper
            var faqItem = document.createElement('div');
            faqItem.className = 'faq-item';

            // Create question element with icon
            var question = document.createElement('div');
            question.className = 'faq-question';
            question.innerHTML = '<span class="faq-question-text">' + heading.textContent + '</span><span class="faq-icon"></span>';

            // Create answer container
            var answer = document.createElement('div');
            answer.className = 'faq-answer';

            // Move all siblings until next heading into answer
            var nextEl = heading.nextElementSibling;
            while (nextEl && !['H2', 'H3', 'H4'].includes(nextEl.tagName)) {
                var next = nextEl.nextElementSibling;
                answer.appendChild(nextEl);
                nextEl = next;
            }

            // Assemble FAQ item
            faqItem.appendChild(question);
            faqItem.appendChild(answer);

            // Replace heading with FAQ item
            heading.parentNode.insertBefore(faqItem, heading);
            heading.remove();

            // Add click handler for accordion toggle
            question.addEventListener('click', function () {
                faqItem.classList.toggle('is-active');
            });
        });
    });
});
