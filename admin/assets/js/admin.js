/**
 * Admin Panel Interactions - Prefab Wooden Homes
 */

document.addEventListener('DOMContentLoaded', () => {
    // Mobile sidebar toggle
    const toggleBtn = document.getElementById('admSidebarToggle');
    const sidebar = document.getElementById('admSidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        // Close sidebar if clicked outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 900 && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    }

    // Auto-slug generator for project titles
    const titleInput = document.getElementById('projectTitle');
    const slugInput = document.getElementById('projectSlug');
    if (titleInput && slugInput && (!slugInput.value || slugInput.value.trim() === '')) {
        titleInput.addEventListener('input', () => {
            slugInput.value = titleInput.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/[\s-]+/g, '-');
        });
    }

    // Image preview helper
    const imgInput = document.getElementById('projectImageInput');
    const imgPreview = document.getElementById('projectImagePreview');
    if (imgInput && imgPreview) {
        imgInput.addEventListener('change', () => {
            const file = imgInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imgPreview.src = e.target.result;
                    imgPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Safe deletion confirmation
    document.querySelectorAll('.adm-btn-delete').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const itemName = btn.getAttribute('data-item') || 'this item';
            if (!confirm(`Are you sure you want to delete ${itemName}? This action cannot be undone.`)) {
                e.preventDefault();
            }
        });
    });

    // ─── Content & Source Code Protection (Admin Console) ───
    function initAdminProtection() {
        let toastEl = null;
        let toastTimeout = null;

        function showCopyAlert() {
            if (!toastEl) {
                toastEl = document.createElement('div');
                toastEl.id = 'copyAlertToast';
                toastEl.className = 'copy-alert-toast';
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.innerHTML = `
                    <div class="copy-alert-toast__icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.5L1.5 21H22.5L12 2.5Z" fill="#F4B400" stroke="#C98A00" stroke-width="1.5" stroke-linejoin="round"/>
                            <path d="M12 8.5V14" stroke="#1F2937" stroke-width="2.2" stroke-linecap="round"/>
                            <circle cx="12" cy="17.5" r="1.3" fill="#1F2937"/>
                        </svg>
                    </div>
                    <div class="copy-alert-toast__content">
                        <div class="copy-alert-toast__text">
                            <strong>ALERT:</strong> You are not allowed to copy content or view source
                        </div>
                    </div>
                `;
                document.body.appendChild(toastEl);
            }

            toastEl.classList.add('active');

            if (toastTimeout) {
                clearTimeout(toastTimeout);
            }
            toastTimeout = setTimeout(() => {
                if (toastEl) {
                    toastEl.classList.remove('active');
                }
            }, 3000);
        }

        // Helper to check if active element is a form field
        function isInputActive(e) {
            const target = e.target || document.activeElement;
            if (!target) return false;
            const tag = (target.tagName || '').toUpperCase();
            return tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || target.isContentEditable;
        }

        // 1. Right Click Prevention
        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            showCopyAlert();
            return false;
        });

        // 2. Clipboard Copy & Cut Prevention (Allow inside form controls)
        document.addEventListener('copy', (e) => {
            if (isInputActive(e)) return;
            e.preventDefault();
            showCopyAlert();
            return false;
        });

        document.addEventListener('cut', (e) => {
            if (isInputActive(e)) return;
            e.preventDefault();
            showCopyAlert();
            return false;
        });

        // 3. Developer Tools & View-Source Shortcut Interception
        document.addEventListener('keydown', (e) => {
            const isCtrlOrCmd = e.ctrlKey || e.metaKey;
            const key = (e.key || '').toLowerCase();
            const keyCode = e.keyCode || e.which;

            // F12 Key
            if (key === 'f12' || keyCode === 123) {
                e.preventDefault();
                showCopyAlert();
                return false;
            }

            if (isCtrlOrCmd) {
                // Ctrl+U (View Source)
                // Ctrl+S (Save Page)
                // Ctrl+Shift+I / Ctrl+Shift+J / Ctrl+Shift+C (Inspect / Console / Picker)
                if (key === 'u' || key === 's' || (e.shiftKey && (key === 'i' || key === 'j' || key === 'c'))) {
                    e.preventDefault();
                    showCopyAlert();
                    return false;
                }

                // Ctrl+C / Ctrl+X outside form fields
                if (!isInputActive(e) && (key === 'c' || key === 'x')) {
                    e.preventDefault();
                    showCopyAlert();
                    return false;
                }
            }
        });

        window.__showCopyAlert = showCopyAlert;
    }

    initAdminProtection();
});
