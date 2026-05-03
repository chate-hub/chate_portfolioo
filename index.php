<?php
$pageTitle = 'Chate Billy Chilima — Software Engineer';
require_once __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO ===== -->
<section class="hero">
    <div class="hero-grid-bg"></div>
    <div class="hero-glow"></div>
    <div class="hero-inner hero-inner--split">

        <!-- Left: Text -->
        <div class="hero-left">
            <div class="hero-tag">Available for freelance work</div>
            <h1 class="hero-name">
                Chate Billy <span class="highlight">Chilima</span>
            </h1>
            <p class="hero-title">
                &gt;&nbsp;<span class="typed-text"></span><span class="cursor-blink"></span>
            </p>
            <p class="hero-desc">
                I craft high-performance, scalable web and mobile applications with clean code and thoughtful architecture.
                Obsessed with developer experience, elegant APIs, and shipping systems that matter.
            </p>
            <div class="hero-actions">
                <a href="/projects.php" class="btn btn-primary">
                    <span>View Projects</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="/#contact" class="btn btn-outline">Get in Touch</a>
            </div>

            <div class="hero-stats">
                <div class="stat-card">
                    <div class="stat-num" data-target="7" data-suffix="+">0+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num" data-target="10" data-suffix="+">0+</div>
                    <div class="stat-label">Projects Shipped</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num" data-target="17" data-suffix="">0</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
            </div>
        </div>

        <!-- Right: Photo -->
        <div class="hero-photo-wrap">
            <div class="hero-photo-card">
                <div class="hero-photo-glow"></div>
                <img src="/assets/img/chate.png" alt="Chate Billy Chilima" class="hero-photo-img">
                <div class="hero-photo-badge">
                    <span class="badge-dot"></span> Open to opportunities
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ===== ABOUT ===== -->
<section class="section" id="about">
    <div class="section-inner">
        <div class="about-grid">
            <div class="about-text" data-reveal>
                <p class="section-tag">About Me</p>
                <h2 class="section-title">Turning ideas into <span class="accent">real products</span></h2>
                <div class="section-divider"></div>
                <p>
                    I'm a <strong>Software Engineer</strong> passionate about building Mobile and Web experiences that are fast, accessible, and genuinely delightful to use. I work across the entire stack — from database design to pixel-perfect UIs.
                </p>
                <p>
                    When I'm not coding, I'm writing about what I've learned, contributing to open source, or exploring the intersection of design and engineering.
                </p>
                <p>
                    Currently focused on <strong>Python (Django)</strong>, <strong>Flutter</strong>, and <strong>cloud-native architecture</strong>. Always curious, always building.
                </p>
                <div style="margin-top: 2rem; display:flex; gap:1rem; flex-wrap:wrap;">
                    <a href="/projects.php" class="btn btn-primary">See My Work</a>
                    <a href="/#contact" class="btn btn-outline">Contact Me</a>
                </div>
            </div>

            <div class="terminal-window" data-reveal>
                <div class="terminal-bar">
                    <div class="terminal-dot"></div>
                    <div class="terminal-dot"></div>
                    <div class="terminal-dot"></div>
                    <span class="terminal-title">~/about-me — bash</span>
                </div>
                <div class="terminal-body">
                    <div class="t-line"><span class="t-prompt">$</span> <span class="t-cmd">whoami</span></div>
                    <div class="t-line t-out highlight">chate — software engineer</div>
                    <div class="t-line" style="margin-top:0.8rem"><span class="t-prompt">$</span> <span class="t-cmd">cat skills.json</span></div>
                    <div class="t-line t-out">{</div>
                    <div class="t-line t-out">&nbsp;&nbsp;"backend": ["Python", "Django", "PHP", "Node.js"],</div>
                    <div class="t-line t-out">&nbsp;&nbsp;"mobile": ["Flutter", "Dart"],</div>
                    <div class="t-line t-out">&nbsp;&nbsp;"database": ["MySQL", "PostgreSQL", "Redis"],</div>
                    <div class="t-line t-out">&nbsp;&nbsp;"devops": ["Docker", "AWS", "GitHub Actions"]</div>
                    <div class="t-line t-out">}</div>
                    <div class="t-line" style="margin-top:0.8rem"><span class="t-prompt">$</span> <span class="t-cmd">cat status.txt</span></div>
                    <div class="t-line t-out success">&#10003; Open to opportunities</div>
                    <div class="t-line t-out success">&#10003; Available for freelance</div>
                    <div class="t-line" style="margin-top:0.8rem"><span class="t-prompt">$</span> <span class="t-cmd">_</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SKILLS ===== -->
<section class="section" id="skills" style="background: var(--bg2); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="section-inner">
        <p class="section-tag" data-reveal>Tech Stack</p>
        <h2 class="section-title" data-reveal>What I <span class="accent">build with</span></h2>
        <div class="section-divider" data-reveal></div>

        <div class="skills-grid">

            <div class="skill-card" data-reveal>
                <div class="skill-icon-svg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28"><path d="M5 12H3l9-9 9 9h-2M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/><path d="M9 21v-6a2 2 0 012-2h2a2 2 0 012 2v6"/></svg>
                </div>
                <div class="skill-name">Backend</div>
                <p style="font-size:0.82rem;color:var(--text-dim);margin-bottom:0.5rem">Robust server-side systems and APIs</p>
                <div class="skill-tags">
                    <span class="tag">Python (Django)</span>
                    <span class="tag">PHP 8.2</span>
                    <span class="tag">Node.js</span>
                    <span class="tag">REST APIs</span>
                    <span class="tag">GraphQL</span>
                </div>
            </div>

            <div class="skill-card" data-reveal>
                <div class="skill-icon-svg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18" stroke-linecap="round" stroke-width="2.5"/></svg>
                </div>
                <div class="skill-name">Mobile</div>
                <p style="font-size:0.82rem;color:var(--text-dim);margin-bottom:0.5rem">Cross-platform native mobile apps</p>
                <div class="skill-tags">
                    <span class="tag">Flutter</span>
                    <span class="tag">Dart</span>
                    <span class="tag">Android</span>
                    <span class="tag">iOS</span>
                    <span class="tag">Firebase</span>
                </div>
            </div>

            <div class="skill-card" data-reveal>
                <div class="skill-icon-svg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <div class="skill-name">Frontend</div>
                <p style="font-size:0.82rem;color:var(--text-dim);margin-bottom:0.5rem">Responsive, performant user interfaces</p>
                <div class="skill-tags">
                    <span class="tag">React</span>
                    <span class="tag">TypeScript</span>
                    <span class="tag">Next.js</span>
                    <span class="tag">Tailwind CSS</span>
                    <span class="tag">Vue.js</span>
                </div>
            </div>

            <div class="skill-card" data-reveal>
                <div class="skill-icon-svg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                </div>
                <div class="skill-name">Databases</div>
                <p style="font-size:0.82rem;color:var(--text-dim);margin-bottom:0.5rem">Efficient data models and queries</p>
                <div class="skill-tags">
                    <span class="tag">MySQL</span>
                    <span class="tag">PostgreSQL</span>
                    <span class="tag">Redis</span>
                    <span class="tag">MongoDB</span>
                    <span class="tag">SQLite</span>
                </div>
            </div>

            <div class="skill-card" data-reveal>
                <div class="skill-icon-svg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28"><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/></svg>
                </div>
                <div class="skill-name">DevOps &amp; Cloud</div>
                <p style="font-size:0.82rem;color:var(--text-dim);margin-bottom:0.5rem">Deploying and scaling production systems</p>
                <div class="skill-tags">
                    <span class="tag">Docker</span>
                    <span class="tag">AWS</span>
                    <span class="tag">CI/CD</span>
                    <span class="tag">Linux</span>
                    <span class="tag">Nginx</span>
                </div>
            </div>

            <div class="skill-card" data-reveal>
                <div class="skill-icon-svg">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div class="skill-name">Security</div>
                <p style="font-size:0.82rem;color:var(--text-dim);margin-bottom:0.5rem">Writing secure code by default</p>
                <div class="skill-tags">
                    <span class="tag">OWASP</span>
                    <span class="tag">OAuth 2.0</span>
                    <span class="tag">JWT</span>
                    <span class="tag">SSL/TLS</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ===== CONTACT ===== -->
<section class="section" id="contact">
    <div class="section-inner">
        <p class="section-tag" data-reveal>Contact</p>
        <h2 class="section-title" data-reveal>Let's <span class="accent">work together</span></h2>
        <div class="section-divider" data-reveal></div>

        <div class="contact-grid" data-reveal>
            <form class="contact-form" id="contactForm" novalidate>
                <!-- Honeypot: hidden from humans, bots fill it -->
                <div style="display:none;" aria-hidden="true">
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="form-group">
                    <label class="form-label">// Your Name</label>
                    <input type="text" name="name" class="form-input" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label class="form-label">// Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="john@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">// Subject</label>
                    <input type="text" name="subject" class="form-input" placeholder="Project inquiry...">
                </div>
                <div class="form-group">
                    <label class="form-label">// Message</label>
                    <textarea name="message" class="form-textarea" rows="5" placeholder="Tell me about your project..." required></textarea>
                </div>

                <div id="formAlert" style="display:none;" class="form-alert"></div>

                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <span id="submitText">Send Message &rarr;</span>
                    <span id="submitSpinner" style="display:none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite;">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>

            <div class="contact-info">

                <div class="contact-item">
                    <span class="contact-icon-svg">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <div>
                        <div class="contact-item-title">Email</div>
                        <div class="contact-item-val">chatebchilima20@gmail.com</div>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="contact-icon-svg">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <div>
                        <div class="contact-item-title">Location</div>
                        <div class="contact-item-val">Lusaka, Zambia &mdash; Remote Worldwide</div>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="contact-icon-svg">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                    <div>
                        <div class="contact-item-title">Response time</div>
                        <div class="contact-item-val">Usually within 24h</div>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="contact-icon-svg">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </span>
                    <div>
                        <div class="contact-item-title">Status</div>
                        <div class="contact-item-val" style="color:var(--accent)">&#10003; Open for work</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
