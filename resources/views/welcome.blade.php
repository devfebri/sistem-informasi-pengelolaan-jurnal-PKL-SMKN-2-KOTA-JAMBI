<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\welcome.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI Jurnal PKL SMKN 2 KOTA JAMBI</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: #ffd700 !important;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .logo-school {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .logo-school img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        
        .hero-description {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 2.5rem;
            opacity: 0.95;
        }
        
        .btn-login {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            color: white;
            text-decoration: none;
        }
        
        /* Features Section */
        .features-section {
            padding: 4rem 0;
            background: #f8f9fa;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            color: #333;
        }
        
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }
        
        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .feature-description {
            color: #666;
            line-height: 1.6;
        }
        
        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
        }
        
        .stat-item {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            display: block;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        
        .footer-content {
            margin-bottom: 1rem;
        }
        
        .footer-links {
            margin-bottom: 1rem;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #ffd700;
        }
        
        .footer-copyright {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-description {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header/Navigation -->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    SIPKL SMKN 2 Jambi
                </a>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#beranda">
                                <i class="fas fa-home mr-1"></i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#fitur">
                                <i class="fas fa-star mr-1"></i>Fitur
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tentang">
                                <i class="fas fa-info-circle mr-1"></i>Tentang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                <i class="fas fa-sign-in-alt mr-1"></i>Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="beranda" class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="logo-school">
                        <img src="{{ asset('img/logo.jpg') }}" alt="Logo SMKN 2 Kota Jambi">
                    </div>
                    
                    <h1 class="hero-title">SIPKL SMKN 2</h1>
                    <p class="hero-subtitle">Sistem Informasi Pengelolaan Jurnal PKL</p>
                    <p class="hero-description">
                        Platform digital modern untuk mengelola kegiatan Praktik Kerja Lapangan (PKL) 
                        siswa SMKN 2 Kota Jambi. Memudahkan monitoring, evaluasi, dan administrasi PKL secara terintegrasi.
                    </p>
                    
                    <a href="/login" class="btn-login">
                        <i class="fas fa-rocket mr-2"></i>
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="features-section">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-journal-whills"></i>
                        </div>
                        <h3 class="feature-title">Jurnal Digital</h3>
                        <p class="feature-description">
                            Sistem pencatatan jurnal PKL secara digital dengan fitur upload gambar dan validasi otomatis.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="feature-title">Multi User</h3>
                        <p class="feature-description">
                            Mendukung berbagai role pengguna: admin, guru pembimbing, siswa, dan pihak instansi.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Monitoring Real-time</h3>
                        <p class="feature-description">
                            Pantau progress PKL siswa secara real-time dengan dashboard yang informatif.
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h3 class="feature-title">Manajemen Instansi</h3>
                        <p class="feature-description">
                            Kelola data instansi PKL dan koordinasi dengan pembimbing lapangan secara efisien.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-users"></i> 500+
                        </span>
                        <span class="stat-label">Siswa Aktif</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-chalkboard-teacher"></i> 50+
                        </span>
                        <span class="stat-label">Guru Pembimbing</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-building"></i> 100+
                        </span>
                        <span class="stat-label">Instansi Mitra</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item">
                        <span class="stat-number">
                            <i class="fas fa-book"></i> 1000+
                        </span>
                        <span class="stat-label">Jurnal Tersimpan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h2 class="section-title">Tentang SIPKL</h2>
                    <p class="lead mb-4">
                        Sistem Informasi Pengelolaan Jurnal PKL (SIPKL) adalah platform digital yang dikembangkan 
                        khusus untuk SMKN 2 Kota Jambi dalam rangka meningkatkan efisiensi dan kualitas 
                        pengelolaan kegiatan Praktik Kerja Lapangan.
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <h4><i class="fas fa-target text-primary mr-2"></i>Visi</h4>
                            <p>Menjadi sistem pengelolaan PKL terdepan yang mendukung kualitas pendidikan vokasi.</p>
                        </div>
                        <div class="col-md-6">
                            <h4><i class="fas fa-bullseye text-success mr-2"></i>Misi</h4>
                            <p>Memfasilitasi digitalisasi proses PKL untuk meningkatkan efisiensi dan transparansi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <h5><i class="fas fa-graduation-cap mr-2"></i>SIPKL SMKN 2 Kota Jambi</h5>
                <p>Sistem Informasi Pengelolaan Jurnal PKL</p>
            </div>
            
            <div class="footer-links">
                <a href="#beranda">Beranda</a>
                <a href="#fitur">Fitur</a>
                <a href="#tentang">Tentang</a>
                <a href="/login">Login</a>
            </div>
            
            <div class="footer-copyright">
                <p>&copy; {{ date('Y') }} SMKN 2 Kota Jambi. Dikembangkan dengan <i class="fas fa-heart text-danger"></i> untuk pendidikan Indonesia.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Smooth scrolling untuk navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.2)';
            } else {
                header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
        });

        // Animate on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>