import { Turbo } from '@hotwired/turbo';

document.addEventListener('turbo:load', () => {
    document.addEventListener('turbo:streams:append', (event) => {
        const targetId = event.target.getAttribute('id');
        const frame = document.getElementById(targetId);

        // Check if the target is the adverts list frame
        if (targetId === 'adverts-list') {
            // Append the new advert to the list
            const newAdvert = event.detail.newElement;
            frame.appendChild(newAdvert);
        }
    });
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl)
    });
});