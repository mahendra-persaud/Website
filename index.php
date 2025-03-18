<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahendra Persaud | Quantum Interface</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <style>
        :root {
            --neon-blue: #00eeff;
            --neon-red:rgb(255, 42, 0);
            --dark-bg: #080818;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segment', sans-serif;
        }
        
        @font-face {
            font-family: 'Segment';
            src: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/webfonts/fa-solid-900.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }
        
        body {
            background-color: var(--dark-bg);
            color: white;
            overflow-x: hidden;
            position: relative;
        }
        
        #canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        .noise {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.05;
            z-index: -1;
            pointer-events: none;
        }
        
        header {
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 200px;
            background: rgba(8, 8, 24, 0.8);
            backdrop-filter: blur(10px);
            border-right: 1px solid var(--glass-border);
            z-index: 100;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        header.collapsed {
            transform: translateX(-160px);
        }
        
        .logo {
            font-size: 1.2rem;
            font-weight: 700;
            position: relative;
            z-index: 10;
            margin-bottom: 3rem;
            padding-top: 2rem;
            white-space: nowrap;
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        
        header.collapsed .logo {
            opacity: 0;
        }
        
        .logo span {
            color: var(--neon-blue);
        }
        
        .vertical-nav {
            width: 100%;
            opacity: 1;
            transition: opacity 0.2s ease;
        }
        
        header.collapsed .vertical-nav {
            opacity: 0;
            pointer-events: none;
        }
        
        nav ul {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            list-style: none;
            align-items: center;
            padding: 0;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
            display: block;
        }
        
        nav a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 8px;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--neon-blue), var(--neon-purple));
            transition: width 0.3s ease;
            opacity: 0.7;
        }
        
        nav a:hover::before {
            width: 30px;
        }
        
        nav a:hover {
            transform: translateX(15px);
            color: var(--neon-blue);
        }
        
        .hero {
            min-height: 85vh;
            display: flex;
            align-items: center;
            padding: 0 10% 0 50px;
            position: relative;
            transition: padding 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        header:not(.collapsed) ~ main .hero {
            padding-left: 80px;
        }
        
        main {
            margin-left: 200px;
            width: calc(100% - 200px);
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1), width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        header.collapsed ~ main {
            margin-left: 40px;
            width: calc(100% - 40px);
        }
        
        .hero-content {
            max-width: 600px;
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 4rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, #fff, var(--neon-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(0, 238, 255, 0.3);
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.8;
        }
        
        .hero-cta {
            display: inline-block;
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple));
            color: white;
            padding: 1rem 2rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 0 20px rgba(174, 0, 255, 0.4);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .hero-cta:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(174, 0, 255, 0.6);
        }
        
        .section {
            padding: 6rem 10%;
            position: relative;
        }
        
        @media (max-width: 1024px) {
            header:not(.collapsed) {
                width: 180px;
            }
            
            header.collapsed {
                transform: translateX(-140px);
            }
            
            .logo {
                font-size: 0.9rem;
                margin-bottom: 2rem;
            }
            
            main {
                margin-left: 180px;
                width: calc(100% - 180px);
            }
            
            header.collapsed ~ main {
                margin-left: 40px;
                width: calc(100% - 40px);
            }
            
            .hero {
                padding-left: 50px;
            }
        }
        
        .section-title {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--neon-blue), var(--neon-purple));
        }
        
        .interests-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .interest-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        .interest-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(0, 238, 255, 0.1), rgba(174, 0, 255, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .interest-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .interest-card:hover::before {
            opacity: 1;
        }
        
        .interest-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--neon-blue);
        }
        
        .interest-card p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        
        .interest-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .tech-badge {
            background: rgba(0, 238, 255, 0.1);
            border: 1px solid rgba(0, 238, 255, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            color: var(--neon-blue);
        }
        
        .contact-form {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 3rem;
            backdrop-filter: blur(10px);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.8rem 1rem;
            color: white;
            font-size: 1rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--neon-blue);
            box-shadow: 0 0 0 2px rgba(0, 238, 255, 0.3);
        }
        
        .btn-submit {
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple));
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-submit:hover {
            box-shadow: 0 0 20px rgba(0, 238, 255, 0.5);
        }
        
        footer {
            background: rgba(0, 0, 0, 0.3);
            padding: 3rem 10%;
            text-align: center;
            position: relative;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple));
            transform: translateY(-3px);
        }
        
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-purple));
            opacity: 0.1;
            filter: blur(20px);
        }
        
        .holographic-card {
            position: relative;
            perspective: 1000px;
            transform-style: preserve-3d;
            width: 100%;
            max-width: 400px;
            height: 250px;
            margin-left: auto;
        }
        
        .holographic-card-inner {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 15px;
            background: linear-gradient(125deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.05));
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .holographic-card:hover .holographic-card-inner {
            transform: rotateY(180deg);
        }
        
        .holographic-card-front, .holographic-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .holographic-card-back {
            transform: rotateY(180deg);
        }
        
        .holographic-card h3 {
            font-size: 1.8rem;
            color: var(--neon-blue);
            margin-bottom: 1rem;
        }
        
        .holographic-card p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            line-height: 1.6;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 3rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .section {
                padding: 4rem 5%;
            }
            
            .holographic-card {
                margin: 2rem auto 0;
            }
            
            .interests-grid {
                grid-template-columns: 1fr;
            }
            
            header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 60px;
                flex-direction: row;
                justify-content: space-between;
                padding: 0 1rem;
                border-right: none;
                border-bottom: 1px solid var(--glass-border);
            }
            
            .logo {
                writing-mode: initial;
                transform: none;
                margin-bottom: 0;
                padding-top: 0;
            }
            
            main {
                margin-left: 0;
                width: 100%;
                padding-top: 60px;
            }
            
            .vertical-nav {
                position: fixed;
                top: 60px;
                left: -200px;
                width: 200px;
                height: calc(100vh - 60px);
                background: rgba(8, 8, 24, 0.95);
                backdrop-filter: blur(10px);
                transition: left 0.3s ease;
                z-index: 100;
            }
            
            .vertical-nav.open {
                left: 0;
            }
            
            .hero {
                padding-left: 10%;
                min-height: calc(100vh - 60px);
            }
            
            .nav-toggle {
                display: block;
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
            }
        }
        
        .nav-toggle {
            display: none;
            z-index: 20;
        }
        
        .sidebar-toggle {
            position: absolute;
            top: 20px;
            right: -20px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 101;
            color: white;
            box-shadow: 0 0 15px rgba(0, 238, 255, 0.4);
            transition: transform 0.3s ease, background 0.3s ease;
            outline: none;
        }
        
        .sidebar-toggle:hover {
            transform: scale(1.1);
        }
        
        header.collapsed .sidebar-toggle .toggle-icon {
            transform: rotate(180deg);
        }
        
        .toggle-icon {
            transition: transform 0.4s ease;
        }
        
        /* Futuristic scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, var(--neon-blue), var(--neon-purple));
            border-radius: 3px;
        }
        
        /* Animated glow effects */
        .glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: -1;
            opacity: 0.3;
        }
        
        .glow-1 {
            top: 20%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: var(--neon-blue);
            animation: pulse 8s infinite alternate;
        }
        
        .glow-2 {
            bottom: 10%;
            right: -5%;
            width: 400px;
            height: 400px;
            background: var(--neon-purple);
            animation: pulse 10s infinite alternate-reverse;
        }
        
        @keyframes pulse {
            0% {
                opacity: 0.2;
                transform: scale(1);
            }
            50% {
                opacity: 0.4;
                transform: scale(1.1);
            }
            100% {
                opacity: 0.2;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div id="canvas-container"></div>
    <div class="noise"></div>
    
    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>
    
    <header class="collapsed">
        <div class="logo">MAHENDRA<span>.DEV</span></div>
        <button class="sidebar-toggle">
            <svg class="toggle-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <nav class="vertical-nav">
            <ul>
                <li><a href="#about">About</a></li>
                <li><a href="#interests">Interests</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Mahendra Persaud</h1>
            <h2 class="hero-subtitle">Computer Science Student & Tech Enthusiast</h2>
            <a href="#contact" class="hero-cta">Connect With Me</a>
        </div>
        
        <div class="holographic-card">
            <div class="holographic-card-inner">
                <div class="holographic-card-front">
                    <h3>Future Developer</h3>
                    <p>Exploring the intersection of code and creativity</p>
                </div>
                <div class="holographic-card-back">
                    <h3>My Focus</h3>
                    <p>Building innovative solutions with cutting-edge technology</p>
                </div>
            </div>
        </div>
    </section>
    
    <section id="about" class="section">
        <h2 class="section-title">About Me</h2>
        <p>Second-year Computer Science student with a passion for technology and sports. I'm constantly exploring new programming languages and frameworks while enjoying the thrill of F1 racing, the strategy of football, and the tradition of cricket.</p>
        
        <div class="tech-stack">
            <span class="tech-badge">PHP</span>
            <span class="tech-badge">JavaScript</span>
            <span class="tech-badge">Python</span>
            <span class="tech-badge">React</span>
            <span class="tech-badge">Node.js</span>
            <span class="tech-badge">Data Structures</span>
            <span class="tech-badge">Algorithms</span>
        </div>
    </section>
    
    <section id="interests" class="section">
        <h2 class="section-title">My Interests</h2>
        
        <div class="interests-grid">
            <div class="interest-card">
                <img src="/api/placeholder/400/200" alt="Formula 1">
                <h3>Formula 1</h3>
                <p>Following the cutting-edge technology and strategy of F1 teams. The perfect blend of engineering, speed, and precision.</p>
            </div>
            
            <div class="interest-card">
                <img src="/api/placeholder/400/200" alt="Cars">
                <h3>Cars</h3>
                <p>Fascinated by automotive design, performance, and the evolution of vehicle technology through the years.</p>
            </div>
            
            <div class="interest-card">
                <img src="/api/placeholder/400/200" alt="Football">
                <h3>Football</h3>
                <p>Enjoying the beautiful game's strategy, teamwork, and moments of individual brilliance across leagues worldwide.</p>
            </div>
            
            <div class="interest-card">
                <img src="/api/placeholder/400/200" alt="Cricket">
                <h3>Cricket</h3>
                <p>Appreciating the skill, patience, and tactics involved in both traditional test matches and modern T20 formats.</p>
            </div>
        </div>
    </section>
    
    <section id="skills" class="section">
        <h2 class="section-title">Technical Skills</h2>
        
        <div class="interests-grid">
            <div class="interest-card">
                <h3>Web Development</h3>
                <p>Creating responsive and dynamic websites using modern frontend and backend technologies.</p>
                <div class="tech-stack">
                    <span class="tech-badge">HTML5</span>
                    <span class="tech-badge">CSS3</span>
                    <span class="tech-badge">PHP</span>
                    <span class="tech-badge">MySQL</span>
                </div>
            </div>
            
            <div class="interest-card">
                <h3>Programming</h3>
                <p>Developing efficient algorithms and solving complex problems through code.</p>
                <div class="tech-stack">
                    <span class="tech-badge">Java</span>
                    <span class="tech-badge">Python</span>
                    <span class="tech-badge">C++</span>
                    <span class="tech-badge">JavaScript</span>
                </div>
            </div>
            
            <div class="interest-card">
                <h3>Data Analysis</h3>
                <p>Extracting insights from data and creating visualizations to tell compelling stories.</p>
                <div class="tech-stack">
                    <span class="tech-badge">SQL</span>
                    <span class="tech-badge">Python</span>
                    <span class="tech-badge">Data Structures</span>
                </div>
            </div>
            
            <div class="interest-card">
                <h3>UI/UX Design</h3>
                <p>Crafting intuitive user interfaces with a focus on user experience and accessibility.</p>
                <div class="tech-stack">
                    <span class="tech-badge">Figma</span>
                    <span class="tech-badge">Adobe XD</span>
                    <span class="tech-badge">Prototyping</span>
                </div>
            </div>
        </div>
    </section>
    
    <section id="contact" class="section">
        <h2 class="section-title">Get In Touch</h2>
        
        <div class="contact-form">
            <form action="process.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </div>
    </section>
    
    <footer>
        <div class="footer-content">
            <div>
                <p>&copy; 2025 Mahendra Persaud. All rights reserved.</p>
            </div>
            
            <div class="social-links">
                <a href="#" class="social-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                </a>
                <a href="#" class="social-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path></svg>
                </a>
                <a href="#" class="social-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                </a>
                <a href="#" class="social-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                </a>
            </div>
        </div>
    </footer>
    </main>
    
    <script>
        // Three.js Background Animation
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 30;
        
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);
        
        // Create particles
        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 2000;
        const posArray = new Float32Array(particlesCount * 3);
        const velocityArray = new Float32Array(particlesCount * 3);
        
        for(let i = 0; i < particlesCount * 3; i += 3) {
            // Position
            posArray[i] = (Math.random() - 0.5) * 100;
            posArray[i+1] = (Math.random() - 0.5) * 100;
            posArray[i+2] = (Math.random() - 0.5) * 100;
            
            // Velocity
            velocityArray[i] = (Math.random() - 0.5) * 0.02;
            velocityArray[i+1] = (Math.random() - 0.5) * 0.02;
            velocityArray[i+2] = (Math.random() - 0.5) * 0.02;
        }
        
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        
        const particlesMaterial = new THREE.PointsMaterial({ 
            size: 0.15,
            color: 0x00eeff,
            transparent: true,
            opacity: 0.8,
            blending: THREE.AdditiveBlending,
            sizeAttenuation: true
        });
        
        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);
        
        // Mouse interaction
        const mouse = {
            x: 0,
            y: 0,
            pressed: false,
            lastTime: 0
        };
        
        // Event listeners for mouse
        document.addEventListener('mousemove', (event) => {
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
        });
        
        document.addEventListener('mousedown', () => {
            mouse.pressed = true;
            createRipple(mouse.x, mouse.y);
        });
        
        document.addEventListener('mouseup', () => {
            mouse.pressed = false;
        });
        
        // Touch support
        document.addEventListener('touchmove', (event) => {
            if (event.touches.length > 0) {
                mouse.x = (event.touches[0].clientX / window.innerWidth) * 2 - 1;
                mouse.y = -(event.touches[0].clientY / window.innerHeight) * 2 + 1;
            }
        });
        
        document.addEventListener('touchstart', (event) => {
            if (event.touches.length > 0) {
                mouse.x = (event.touches[0].clientX / window.innerWidth) * 2 - 1;
                mouse.y = -(event.touches[0].clientY / window.innerHeight) * 2 + 1;
                createRipple(mouse.x, mouse.y);
            }
            mouse.pressed = true;
        });
        
        document.addEventListener('touchend', () => {
            mouse.pressed = false;
        });
        
        // Ripple effect
        const ripples = [];
        
        function createRipple(x, y) {
            // Prevent too many ripples in a short time
            const now = Date.now();
            if (now - mouse.lastTime < 200) return;
            mouse.lastTime = now;
            
            // Convert normalized coordinates to world coordinates
            const vector = new THREE.Vector3(x, y, 0);
            vector.unproject(camera);
            const dir = vector.sub(camera.position).normalize();
            const distance = -camera.position.z / dir.z;
            const pos = camera.position.clone().add(dir.multiplyScalar(distance));
            
            const ripple = {
                position: pos,
                radius: 0,
                maxRadius: 15,
                strength: 1,
                growth: 0.3,
                life: 100
            };
            
            ripples.push(ripple);
        }
        
        // Animation
        function animate() {
            requestAnimationFrame(animate);
            
            // Update particle positions
            const positions = particlesGeometry.attributes.position.array;
            
            for (let i = 0; i < positions.length; i += 3) {
                // Add velocity to position
                positions[i] += velocityArray[i];
                positions[i+1] += velocityArray[i+1];
                positions[i+2] += velocityArray[i+2];
                
                // Boundary check and bounce
                if (Math.abs(positions[i]) > 50) velocityArray[i] *= -1;
                if (Math.abs(positions[i+1]) > 50) velocityArray[i+1] *= -1;
                if (Math.abs(positions[i+2]) > 50) velocityArray[i+2] *= -1;
                
                // Cursor attraction effect
                if (mouse.pressed) {
                    // Convert normalized mouse coords to world space
                    const mouseVector = new THREE.Vector3(mouse.x, mouse.y, 0);
                    mouseVector.unproject(camera);
                    const dir = mouseVector.sub(camera.position).normalize();
                    const distance = -camera.position.z / dir.z;
                    const cursorPos = camera.position.clone().add(dir.multiplyScalar(distance));
                    
                    // Calculate direction and distance to cursor
                    const dx = cursorPos.x - positions[i];
                    const dy = cursorPos.y - positions[i+1];
                    const dz = cursorPos.z - positions[i+2];
                    const dist = Math.sqrt(dx*dx + dy*dy + dz*dz);
                    
                    // Apply attraction force within radius
                    if (dist < 10) {
                        const force = 0.03 / (dist * dist + 0.1);
                        velocityArray[i] += dx * force;
                        velocityArray[i+1] += dy * force;
                        velocityArray[i+2] += dz * force;
                    }
                }
                
                // Apply ripple effects
                for (let r = 0; r < ripples.length; r++) {
                    const ripple = ripples[r];
                    const dx = ripple.position.x - positions[i];
                    const dy = ripple.position.y - positions[i+1];
                    const dz = ripple.position.z - positions[i+2];
                    const dist = Math.sqrt(dx*dx + dy*dy + dz*dz);
                    
                    // If particle is within the ripple's expanding wave
                    const rippleWidth = 2;
                    if (Math.abs(dist - ripple.radius) < rippleWidth) {
                        const force = ripple.strength * (1 - Math.abs(dist - ripple.radius) / rippleWidth);
                        const direction = dist > 0 ? 1 : -1;
                        
                        velocityArray[i] += (dx / dist) * force * direction;
                        velocityArray[i+1] += (dy / dist) * force * direction;
                        velocityArray[i+2] += (dz / dist) * force * direction;
                    }
                }
            }
            
            // Update ripples
            for (let i = ripples.length - 1; i >= 0; i--) {
                ripples[i].radius += ripples[i].growth;
                ripples[i].life--;
                ripples[i].strength *= 0.98;
                
                if (ripples[i].life <= 0 || ripples[i].radius > ripples[i].maxRadius) {
                    ripples.splice(i, 1);
                }
            }
            
            // Apply damping to velocities
            for (let i = 0; i < velocityArray.length; i++) {
                velocityArray[i] *= 0.99;
            }
            
            // Update particle rotation
            particlesMesh.rotation.x += 0.0002;
            particlesMesh.rotation.y += 0.0001;
            
            // Update geometry
            particlesGeometry.attributes.position.needsUpdate = true;
            
            renderer.render(scene, camera);
        }
        
        animate();
        
        // Resize handler
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
        
        // Create floating shapes
        const floatingShapes = document.createElement('div');
        floatingShapes.classList.add('floating-shapes');
        document.body.appendChild(floatingShapes);
        
        for (let i = 0; i < 10; i++) {
            const shape = document.createElement('div');
            shape.classList.add('shape');
            shape.style.width = `${Math.random() * 200 + 50}px`;
            shape.style.height = shape.style.width;
            shape.style.left = `${Math.random() * 100}%`;
            shape.style.top = `${Math.random() * 100}%`;
            shape.style.animationDuration = `${Math.random() * 10 + 10}s`;
            shape.style.animationDelay = `${Math.random() * 5}s`;
            shape.style.animation = `float ${Math.random() * 10 + 20}s infinite ease-in-out`;
            floatingShapes.appendChild(shape);
        }
        
        // Smooth scroll for nav links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Mouse move effect for holographic card
        const card = document.querySelector('.holographic-card');
        card.addEventListener('mousemove', e => {
            const { left, top, width, height } = card.getBoundingClientRect();
            const x = (e.clientX - left) / width;
            const y = (e.clientY - top) / height;
            
            const rotX = 10 - y * 20;
            const rotY = x * 20 - 10;
            
            card.querySelector('.holographic-card-inner').style.transform = `rotateX(${rotX}deg) rotateY(${rotY}deg)`;
        });
        
        card.addEventListener('mouseleave', () => {
            card.querySelector('.holographic-card-inner').style.transform = 'rotateX(0) rotateY(0)';
        });
        
        // Simulating PHP form processing with JavaScript for demo
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, this would be handled by PHP
            alert('Form submitted! In a real implementation, this would be processed by PHP.');
        });
        
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            initSidebar();
        });
        
        // Initialize sidebar immediately if DOM is already loaded
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            initSidebar();
        }
        
        function initSidebar() {
            // Sidebar toggle functionality
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const header = document.querySelector('header');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    header.classList.toggle('collapsed');
                    console.log("Toggle clicked, header classes:", header.className);
                });
            }
            
            // Mobile navigation toggle
            const navToggle = document.querySelector('.nav-toggle');
            const verticalNav = document.querySelector('.vertical-nav');
            
            if (navToggle) {
                navToggle.addEventListener('click', () => {
                    verticalNav.classList.toggle('open');
                });
            }
            
            // Close mobile nav when clicking a link
            document.querySelectorAll('.vertical-nav a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        verticalNav.classList.remove('open');
                    }
                });
            });
            
            // Set initial state based on screen size
            function setInitialSidebarState() {
                if (window.innerWidth < 1024) {
                    header.classList.add('collapsed');
                }
            }
            
            // Run on page load
            setInitialSidebarState();
            
            // Also run on window resize
            window.addEventListener('resize', setInitialSidebarState);
        }
    </script>
</body>
</html>