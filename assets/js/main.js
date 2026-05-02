// ===== Custom Cursor =====
const dot = document.getElementById('cursorDot');
const ring = document.getElementById('cursorRing');
let mouseX = 0, mouseY = 0, ringX = 0, ringY = 0;

document.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    dot.style.left = mouseX + 'px';
    dot.style.top = mouseY + 'px';
});

function animateRing() {
    ringX += (mouseX - ringX) * 0.12;
    ringY += (mouseY - ringY) * 0.12;
    ring.style.left = ringX + 'px';
    ring.style.top = ringY + 'px';
    requestAnimationFrame(animateRing);
}
animateRing();

// ===== Nav Scroll =====
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
    nav?.classList.toggle('scrolled', window.scrollY > 30);
});

// ===== Mobile Menu =====
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
hamburger?.addEventListener('click', () => {
    hamburger.classList.toggle('open');
    mobileMenu.classList.toggle('open');
});
document.querySelectorAll('.mobile-link').forEach(l => {
    l.addEventListener('click', () => {
        hamburger.classList.remove('open');
        mobileMenu.classList.remove('open');
    });
});

// ===== Typing Effect =====
const typedEl = document.querySelector('.typed-text');
if (typedEl) {
    const words = [
        'Platform Engineer',
        'Software Engineer',
        'Flutter Mobile developer',
        'Python Backend Engineer',
        'PHP Artisan',
        'Open Source Contributor',
        'Problem Solver'
    ];
    let wordIdx = 0, charIdx = 0, deleting = false;

    function type() {
        const word = words[wordIdx];
        if (deleting) {
            typedEl.textContent = word.slice(0, --charIdx);
            if (charIdx === 0) { deleting = false; wordIdx = (wordIdx + 1) % words.length; setTimeout(type, 500); return; }
        } else {
            typedEl.textContent = word.slice(0, ++charIdx);
            if (charIdx === word.length) { deleting = true; setTimeout(type, 2000); return; }
        }
        setTimeout(type, deleting ? 60 : 90);
    }
    type();
}

// ===== Reveal on Scroll =====
const reveals = document.querySelectorAll('[data-reveal]');
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('revealed'), i * 80);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });
reveals.forEach(el => observer.observe(el));

// ===== Animated Counter =====
function animateCounter(el) {
    const target = parseInt(el.dataset.target);
    let current = 0;
    const increment = target / 60;
    const timer = setInterval(() => {
        current = Math.min(current + increment, target);
        el.textContent = Math.floor(current) + (el.dataset.suffix || '');
        if (current >= target) clearInterval(timer);
    }, 25);
}

const statObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.querySelectorAll('[data-target]').forEach(animateCounter);
            statObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('.hero-stats')?.forEach(el => statObserver.observe(el));

// ===== Project Filters =====
const filterBtns = document.querySelectorAll('.filter-btn');
const projectCards = document.querySelectorAll('.project-card');

filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        projectCards.forEach(card => {
            const tags = card.dataset.tags || '';
            const show = filter === 'all' || tags.toLowerCase().includes(filter.toLowerCase());
            card.style.transition = 'opacity 0.3s, transform 0.3s';
            card.style.opacity = show ? '1' : '0.2';
            card.style.transform = show ? 'scale(1)' : 'scale(0.96)';
            card.style.pointerEvents = show ? 'auto' : 'none';
        });
    });
});

// ===== Contact Form (demo) =====
const contactForm = document.getElementById('contactForm');
contactForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const btn = contactForm.querySelector('[type="submit"]');
    btn.textContent = 'Sending...';
    btn.disabled = true;
    setTimeout(() => {
        btn.textContent = '✓ Message Sent!';
        contactForm.reset();
        setTimeout(() => { btn.textContent = 'Send Message'; btn.disabled = false; }, 3000);
    }, 1500);
});

// ===== Glitch Title Effect =====
const glitchEl = document.querySelector('.hero-name');
if (glitchEl) {
    setInterval(() => {
        glitchEl.classList.add('glitch');
        setTimeout(() => glitchEl.classList.remove('glitch'), 200);
    }, 5000);
}

// ===== Admin: Delete Post Confirm =====
document.querySelectorAll('.delete-post-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        if (!confirm('Delete this post? This cannot be undone.')) {
            e.preventDefault();
        }
    });
});

// ===== Admin: Live Slug Preview =====
const titleInput = document.getElementById('post-title');
const slugPreview = document.getElementById('slug-preview');
titleInput?.addEventListener('input', () => {
    const slug = titleInput.value.toLowerCase().trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/[\s-]+/g, '-')
        .replace(/^-|-$/g, '');
    if (slugPreview) slugPreview.textContent = '/blog/' + (slug || 'your-post-title');
});

// ===== Editor Toolbar =====
document.querySelectorAll('.editor-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const textarea = document.getElementById('post-content');
        if (!textarea) return;
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selected = textarea.value.substring(start, end);
        const wrap = btn.dataset.wrap;
        const insert = btn.dataset.insert;
        if (wrap) {
            const wrapped = wrap + selected + wrap;
            textarea.value = textarea.value.substring(0, start) + wrapped + textarea.value.substring(end);
            textarea.selectionStart = start + wrap.length;
            textarea.selectionEnd = end + wrap.length;
        } else if (insert) {
            textarea.value = textarea.value.substring(0, start) + insert + textarea.value.substring(end);
        }
        textarea.focus();
    });
});

// ===== Page Load Animation =====
document.body.classList.add('loaded');
