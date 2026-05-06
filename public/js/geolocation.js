/**
 * geolocation.js
 * Handles browser Geolocation API for the SOS button.
 * Sends emergency request with latitude/longitude to the server.
 */

'use strict';

const SosHandler = {
    // State
    isProcessing: false,
    lastSosTime: null,
    cooldownSeconds: 60,

    /**
     * Initialize the SOS button event listener.
     */
    init() {
        const sosBtn = document.getElementById('sos-button');
        if (!sosBtn) return;
        sosBtn.addEventListener('click', () => this.handleSos());
    },

    /**
     * Main SOS handler: get location then send request.
     */
    handleSos() {
        if (this.isProcessing) return;

        // Check client-side cooldown
        if (this.lastSosTime) {
            const elapsed = (Date.now() - this.lastSosTime) / 1000;
            if (elapsed < this.cooldownSeconds) {
                const remaining = Math.ceil(this.cooldownSeconds - elapsed);
                this.showMessage('warning',
                    `⏱ Please wait ${remaining} seconds before sending another SOS.`);
                return;
            }
        }

        this.setLoading(true);
        this.showStatus('📍 Getting your location...');

        // Try to get GPS location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => this.onLocationSuccess(position),
                (error)    => this.onLocationError(error),
                { timeout: 10000, maximumAge: 0, enableHighAccuracy: true }
            );
        } else {
            // Browser doesn't support geolocation – ask for manual address
            this.onLocationError({ code: 0, message: 'Geolocation not supported' });
        }
    },

    /**
     * Called when location is successfully obtained.
     */
    onLocationSuccess(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        this.showStatus('✅ Location captured. Sending SOS...');
        this.sendSosRequest(lat, lng, '');
    },

    /**
     * Called when location is denied or unavailable.
     */
    onLocationError(error) {
        console.warn('Geolocation error:', error.message || error.code);
        this.setLoading(false);
        this.showStatus('❌ Location mandatory');
        this.showMessage('danger', '📍 Location access denied. Accessing your live location is mandatory for sending an SOS.');
    },

    /**
     * Show manual address input form when GPS fails (DISABLED).
     */
    showManualAddressForm() {
        // Disabled: live location is now mandatory.
    },

    /**
     * Send SOS AJAX request to the server.
     * FIXED: Use X-CSRF-TOKEN header, handle non-JSON server responses,
     *        and avoid sending empty strings for numeric fields.
     */
    sendSosRequest(lat, lng, address) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const sosUrl    = document.getElementById('sos-url')?.value;

        if (!sosUrl) {
            this.showMessage('danger', 'Configuration error. Please refresh the page.');
            this.setLoading(false);
            return;
        }

        if (!csrfToken) {
            this.showMessage('danger', 'Session expired. Please refresh the page and try again.');
            this.setLoading(false);
            return;
        }

        // Build form data — only include lat/lng when they are actual numbers
        const formData = new FormData();
        formData.append('_token', csrfToken);
        if (lat !== null && lat !== '' && !isNaN(lat)) formData.append('latitude', lat);
        if (lng !== null && lng !== '' && !isNaN(lng)) formData.append('longitude', lng);
        if (address && address.trim() !== '') formData.append('address', address.trim());

        fetch(sosUrl, {
            method:      'POST',
            credentials: 'same-origin',    // Always send session cookie
            headers: {
                'X-CSRF-TOKEN': csrfToken, // Extra CSRF header as backup
                'Accept':       'application/json', // Tell server we expect JSON back
            },
            body: formData,
        })
        .then(res => {
            // If server returns a redirect (auth failure), handle gracefully
            if (res.status === 401 || res.status === 403) {
                throw new Error('Authentication required. Please login again.');
            }
            if (res.status === 429) {
                // Rate limit – still parse JSON for message
                return res.json().then(d => { throw new Error(d.message || 'Please wait before sending another SOS.'); });
            }
            if (!res.ok) {
                return res.text().then(text => {
                    // Try to parse as JSON first
                    try { const d = JSON.parse(text); throw new Error(d.message || 'Server error. Please try again.'); }
                    catch(e) { throw new Error('Server error (' + res.status + '). Please try again.'); }
                });
            }
            return res.json();
        })
        .then(data => {
            this.setLoading(false);
            if (data.success) {
                this.lastSosTime = Date.now();
                this.showStatus('');
                this.showSuccessModal(data);
            } else {
                this.showMessage('danger', data.message || 'SOS failed. Please try again.');
            }
        })
        .catch(err => {
            console.error('SOS request failed:', err);
            this.setLoading(false);
            this.showMessage('danger', err.message || 'Network error. Please try again.');
        });
    },

    /**
     * Send SOS with manual address (called from button in manual form).
     */
    sendManualSos() {
        const addressInput = document.getElementById('manual-address-input');
        const address = addressInput?.value?.trim();
        if (!address) {
            this.showMessage('danger', 'Please enter your address.');
            return;
        }
        this.setLoading(true);
        this.showStatus('Sending SOS with manual address...');
        this.sendSosRequest(null, null, address);
    },

    /**
     * Show the success modal after SOS is sent.
     */
    showSuccessModal(data) {
        const overlay = document.getElementById('sos-success-overlay');
        if (overlay) {
            overlay.style.display = 'flex';
            // Set "Add Details" link
            const detailsLink = document.getElementById('add-details-link');
            if (detailsLink && data.emergency_id) {
                detailsLink.href = detailsLink.dataset.base + '/' + data.emergency_id + '/details';
                detailsLink.style.display = 'inline-flex';
            }
            // Set map link
            const mapLink = document.getElementById('map-link');
            if (mapLink && data.map_link && data.map_link !== '#') {
                mapLink.href = data.map_link;
                mapLink.style.display = 'inline-flex';
            }
        } else {
            this.showMessage('success', '🆘 Emergency Sent Successfully!');
        }
    },

    /**
     * Close the success modal.
     */
    closeModal() {
        const overlay = document.getElementById('sos-success-overlay');
        if (overlay) overlay.style.display = 'none';
    },

    /**
     * Show/hide loading state on SOS button.
     * Adds/removes a 'sos-btn--sending' CSS class for visual feedback.
     */
    setLoading(state) {
        this.isProcessing = state;
        const btn = document.getElementById('sos-button');
        if (!btn) return;
        btn.disabled = state;

        const label = btn.querySelector('.sos-label');
        const icon  = btn.querySelector('.sos-icon');

        if (state) {
            btn.classList.add('sos-btn--sending');
            if (icon)  icon.textContent  = '⏳';
            if (label) label.textContent = 'SENDING';
            // Animated dots suffix
            this._dotInterval = setInterval(() => {
                if (!label) return;
                const dots = label.dataset.dots || '';
                label.dataset.dots = dots.length >= 3 ? '' : dots + '.';
                label.textContent = 'SENDING' + label.dataset.dots;
            }, 400);
        } else {
            btn.classList.remove('sos-btn--sending');
            clearInterval(this._dotInterval);
            if (icon)  icon.textContent  = '🆘';
            if (label) { label.textContent = 'PRESS'; delete label.dataset.dots; }
        }
    },

    /**
     * Show a status message below the SOS button.
     */
    showStatus(msg) {
        const el = document.getElementById('sos-status-msg');
        if (el) el.textContent = msg;
    },

    /**
     * Show an alert message in the sos-alerts container.
     */
    showMessage(type, message) {
        const container = document.getElementById('sos-alerts');
        if (!container) return;
        container.innerHTML = `
            <div class="alert-custom alert-${type}">
                <span>${message}</span>
            </div>`;
        container.scrollIntoView({ behavior: 'smooth' });
        setTimeout(() => { container.innerHTML = ''; }, 6000);
    },
};

// Boot when DOM is ready
document.addEventListener('DOMContentLoaded', () => SosHandler.init());
