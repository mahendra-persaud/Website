<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahendra Persaud | Portfolio</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <style>
        :root {
            --primary: #f2f2f2;
            --accent: #0984e3;
            --accent-secondary: #6c5ce7;
            --accent-tertiary: #00b894;
            --dark-bg: #121212;
            --dark-card: #1e1e1e;
            --dark-lighter: #2d2d2d;
            --gray-300: #a0aec0;
            --gray-600: #718096;
            --gray-800: #e2e8f0;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.25);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.25), 0 1px 3px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.25), 0 1px 3px rgba(0, 0, 0, 0.4);
            --font-sans: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-sans);
            color: var(--primary);
            background-color: var(--dark-bg);
            line-height: 1.6;
            font-size: 16px;
            overflow-x: hidden;
        }
        
        #canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.4;
        }
        
        a {
            color: var(--accent);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        a:hover {
            color: #0a6cbd;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 1rem;
        }
        
        h1 {
            font-size: 2.5rem;
        }
        
        h2 {
            font-size: 1.75rem;
        }
        
        h3 {
            font-size: 1.25rem;
        }
        
        p {
            margin-bottom: 1.5rem;
        }
        
        .container {
            width: 100%;
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 80px;
            background: var(--dark-card);
            box-shadow: var(--shadow-md);
            z-index: 100;
            transition: width 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .sidebar.expanded {
            width: 240px;
        }
        
        .logo {
            padding: 2rem 0;
            text-align: center;
            width: 100%;
            font-weight: 600;
            font-size: 1.2rem;
            white-space: nowrap;
            color: var(--primary);
        }
        
        .logo span {
            background: linear-gradient(45deg, var(--accent), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-toggle {
            position: absolute;
            right: -15px;
            top: 20px;
            width: 30px;
            height: 30px;
            background: var(--dark-card);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
            outline: none;
        }
        
        .nav-toggle:hover {
            transform: scale(1.1);
            background: var(--dark-lighter);
        }
        
        .nav-toggle svg {
            transition: transform 0.3s ease;
            width: 16px;
            height: 16px;
            stroke: var(--primary);
        }
        
        .sidebar.expanded .nav-toggle svg {
            transform: rotate(180deg);
        }
        
        .nav {
            width: 100%;
            margin-top: 2rem;
        }
        
        .nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }
        
        .nav li {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .nav a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: var(--gray-300);
            transition: all 0.2s ease;
            white-space: nowrap;
            border-left: 3px solid transparent;
        }
        
        .nav a:hover {
            background-color: var(--dark-lighter);
            color: var(--primary);
            border-left: 3px solid var(--accent);
        }
        
        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 1rem;
            opacity: 0.7;
            stroke: var(--gray-300);
            transition: all 0.2s ease;
        }
        
        .nav a:hover .nav-icon {
            opacity: 1;
            stroke: var(--accent);
        }
        
        .main {
            margin-left: 80px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        .sidebar.expanded ~ .main {
            margin-left: 240px;
        }
        
        section {
            padding: 5rem 0;
        }
        
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 2rem;
        }
        
        .hero-content {
            max-width: 600px;
        }
        
        .hero-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .hero-subtitle {
            color: var(--gray-300);
            margin-bottom: 2rem;
            font-size: 1.25rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(45deg, var(--accent), var(--accent-secondary));
            color: white;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--accent-secondary), var(--accent));
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(9, 132, 227, 0.3);
        }
        
        .btn:hover::before {
            opacity: 1;
        }
        
        .section-title {
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--accent);
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        
        .card-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        
        .card-content {
            padding: 1.5rem;
        }
        
        .card-title {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--primary);
            position: relative;
            display: inline-block;
        }
        
        .card-title::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }
        
        .card:hover .card-title::after {
            width: 100%;
        }
        
        .card-text {
            color: var(--gray-300);
            margin-bottom: 1rem;
        }
        
        .tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--gray-300);
            border-radius: 30px;
            font-size: 0.75rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.2s ease;
        }
        
        .tag:hover {
            background-color: var(--accent);
            color: white;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--primary);
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            color: var(--primary);
            background-color: var(--dark-lighter);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            transition: all 0.15s ease-in-out;
        }
        
        .form-control:focus {
            border-color: var(--accent);
            outline: 0;
            box-shadow: 0 0 0 3px rgba(9, 132, 227, 0.2);
            background-color: rgba(9, 132, 227, 0.05);
        }
        
        textarea.form-control {
            resize: vertical;
        }
        
        .contact-form {
            background-color: var(--dark-card);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: var(--shadow-md);
            max-width: 600px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .progress-container {
            width: 100%;
            margin-bottom: 1.5rem;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            color: var(--gray-300);
        }
        
        .progress-bar {
            height: 8px;
            background-color: var(--dark-lighter);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        
        .progress-value {
            height: 100%;
            background: linear-gradient(to right, var(--accent), var(--accent-secondary));
            border-radius: 4px;
            position: relative;
            transition: width 1s ease;
        }
        
        .progress-value::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                          rgba(255, 255, 255, 0) 0%, 
                          rgba(255, 255, 255, 0.2) 50%, 
                          rgba(255, 255, 255, 0) 100%);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }
        
        footer {
            background-color: var(--dark-card);
            padding: 2rem 0;
            text-align: center;
            margin-top: 3rem;
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
            gap: 1rem;
        }
        
        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: var(--dark-lighter);
            border-radius: 50%;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .social-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--accent), var(--accent-secondary));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
        }
        
        .social-link:hover::before {
            opacity: 1;
        }
        
        .social-link svg {
            width: 20px;
            height: 20px;
            stroke: var(--gray-300);
            transition: stroke 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .social-link:hover svg {
            stroke: white;
        }
        
        @media (max-width: 1024px) {
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }
            
            .sidebar.expanded {
                width: 240px;
            }
            
            .main {
                margin-left: 60px;
            }
            
            .sidebar.expanded ~ .main {
                margin-left: 240px;
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .sidebar {
                width: 0;
                box-shadow: none;
            }
            
            .sidebar.expanded {
                width: 240px;
                box-shadow: var(--shadow-lg);
            }
            
            .nav-toggle {
                right: -40px;
                background: white;
                box-shadow: var(--shadow-md);
            }
            
            .main {
                margin-left: 0;
            }
            
            .sidebar.expanded ~ .main {
                margin-left: 0;
            }
            
            .hero {
                padding: 0 1rem;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .section {
                padding: 3rem 0;
            }
            
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div id="canvas-container"></div>
    
    <aside class="sidebar">
        <div class="logo">M<span>.</span>Persaud</div>
        <button class="nav-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <nav class="nav">
            <ul>
                <li>
                    <a href="#about">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        About
                    </a>
                </li>
                <li>
                    <a href="#interests">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        Interests
                    </a>
                </li>
                <li>
                    <a href="#skills">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2 L2 7 L12 12 L22 7 Z"></path>
                            <path d="M2 17 L12 22 L22 17"></path>
                            <path d="M2 12 L12 17 L22 12"></path>
                        </svg>
                        Skills
                    </a>
                </li>
                <li>
                    <a href="#contact">
                        <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Contact
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    
    <main class="main">
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">Mahendra Persaud</h1>
                    <p class="hero-subtitle">Computer Science Student & Tech Enthusiast</p>
                    <a href="#contact" class="btn">Get in Touch</a>
                </div>
            </div>
        </section>
        
        <section id="about" class="section">
            <div class="container">
                <h2 class="section-title">About Me</h2>
                <p>I'm a second-year Computer Science student with a passion for technology and sports. My academic journey focuses on building a strong foundation in programming, algorithms, and software development while exploring emerging technologies.</p>
                <p>When I'm not coding, you'll find me following F1 races, exploring automotive engineering, or enjoying a good football or cricket match. I believe that a balanced approach to technical skills and personal interests creates the best foundation for innovation.</p>
            </div>
        </section>
        
        <section id="interests" class="section" style="background-color: var(--dark-card);">
            <div class="container">
                <h2 class="section-title">My Interests</h2>
                <div class="grid">
                    <div class="card">
                        <img src="/api/placeholder/400/200" alt="Formula 1" class="card-img">
                        <div class="card-content">
                            <h3 class="card-title">Formula 1</h3>
                            <p class="card-text">Following the cutting-edge technology and strategy of F1 teams. The perfect blend of engineering, speed, and precision.</p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <img src="/api/placeholder/400/200" alt="Cars" class="card-img">
                        <div class="card-content">
                            <h3 class="card-title">Automotive</h3>
                            <p class="card-text">Fascinated by automotive design, performance, and the evolution of vehicle technology through the years.</p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <img src="/api/placeholder/400/200" alt="Football" class="card-img">
                        <div class="card-content">
                            <h3 class="card-title">Football</h3>
                            <p class="card-text">Enjoying the beautiful game's strategy, teamwork, and moments of individual brilliance across leagues worldwide.</p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <img src="/api/placeholder/400/200" alt="Cricket" class="card-img">
                        <div class="card-content">
                            <h3 class="card-title">Cricket</h3>
                            <p class="card-text">Appreciating the skill, patience, and tactics involved in both traditional test matches and modern T20 formats.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="skills" class="section">
            <div class="container">
                <h2 class="section-title">Technical Skills</h2>
                
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div>
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>PHP</span>
                                <span>85%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: 85%;"></div>
                            </div>
                        </div>
                        
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>JavaScript</span>
                                <span>80%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: 80%;"></div>
                            </div>
                        </div>
                        
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>Python</span>
                                <span>75%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: 75%;"></div>
                            </div>
                        </div>
                        
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>HTML/CSS</span>
                                <span>90%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: 90%;"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>MySQL</span>
                                <span>70%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: 70%;"></div>
                            </div>
                        </div>
                        
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>Java</span>
                                <span>65%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: 65%;"></div>
                            </div>
                        </div>
                        
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>React</span>
                                <span>60%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: 60%;"></div>
                            </div>
                        </div>
                        
                        <div class="progress-container">
                            <div class="progress-label">
                                <span>Data Structures</span>
                                <span>80%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value" style="width: 80%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 3rem;">
                    <h3>Areas of Interest</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 1rem;">
                        <span class="tag">Web Development</span>
                        <span class="tag">Backend Systems</span>
                        <span class="tag">Algorithms</span>
                        <span class="tag">Database Design</span>
                        <span class="tag">UI/UX</span>
                        <span class="tag">Data Visualization</span>
                        <span class="tag">API Development</span>
                        <span class="tag">Mobile Apps</span>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="contact" class="section" style="background-color: var(--dark-card);">
            <div class="container">
                <h2 class="section-title">Get In Touch</h2>
                <div class="contact-form">
                    <form action="process.php" method="POST">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn">Send Message</button>
                    </form>
                </div>
            </div>
        </section>
        
        <footer>
            <div class="container">
                <div class="social-links">
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                            <rect x="2" y="9" width="4" height="12"></rect>
                            <circle cx="4" cy="4" r="2"></circle>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="#" class="social-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                        </svg>
                    </a>
                </div>
                <p>&copy; 2025 Mahendra Persaud. All rights reserved.</p>
            </div>
        </footer>
    </main>
    
    <script>
        // Particle background with Three.js
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
        const particlesCount = 1000;
        const posArray = new Float32Array(particlesCount * 3);
        
        for(let i = 0; i < particlesCount * 3; i += 3) {
            posArray[i] = (Math.random() - 0.5) * 100;
            posArray[i+1] = (Math.random() - 0.5) * 100;
            posArray[i+2] = (Math.random() - 0.5) * 100;
        }
        
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        
        const particlesMaterial = new THREE.PointsMaterial({ 
            size: 0.05,
            color: 0x0984e3,
            transparent: true,
            opacity: 0.6,
            sizeAttenuation: true
        });
        
        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);
        
        // Mouse interaction
        const mouse = {
            x: 0,
            y: 0
        };
        
        document.addEventListener('mousemove', (event) => {
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
        });
        
        // Animation
        function animate() {
            requestAnimationFrame(animate);
            
            particlesMesh.rotation.x += 0.0001;
            particlesMesh.rotation.y += 0.0001;
            
            // Subtle mouse follow effect
            particlesMesh.rotation.x += mouse.y * 0.0001;
            particlesMesh.rotation.y += mouse.x * 0.0001;
            
            renderer.render(scene, camera);
        }
        
        animate();
        
        // Resize handler
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
        
        // Sidebar toggle
        const navToggle = document.querySelector('.nav-toggle');
        const sidebar = document.querySelector('.sidebar');
        
        navToggle.addEventListener('click', () => {
            sidebar.classList.toggle('expanded');
        });
        
        // Simulate PHP form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Message sent successfully! (In a real implementation, this would be processed by PHP)');
        });
        
        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
                
                // Close sidebar on mobile after clicking a link
                if (window.innerWidth <= 576) {
                    sidebar.classList.remove('expanded');
                }
            });
        });
    </script>
</body>
</html>
