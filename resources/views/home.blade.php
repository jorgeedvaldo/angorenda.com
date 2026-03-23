<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Angorenda - Homepage</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar Customizations */
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #212529 !important;
        }
        .search-bar {
            max-width: 500px;
            width: 100%;
            border-radius: 50px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 0.25rem 0.5rem;
        }
        .search-bar input {
            border: none;
            box-shadow: none;
            background: transparent;
        }
        .search-bar input:focus {
            box-shadow: none;
        }
        .search-icon-btn {
            background-color: #212529;
            color: #fff;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
        }

        /* Property Cards */
        .property-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background-color: #fff;
            position: relative;
        }
        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }
        .property-img-wrapper {
            position: relative;
            aspect-ratio: 4/3;
            overflow: hidden;
        }
        .property-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .badge-status {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: rgba(33, 37, 41, 0.75);
            color: white;
            padding: 0.35em 0.65em;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .badge-photos {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: rgba(33, 37, 41, 0.75);
            color: white;
            padding: 0.35em 0.65em;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .like-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: white;
            color: #adb5bd;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: color 0.2s;
        }
        .like-btn:hover {
            color: #dc3545;
        }
        .property-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .property-rating {
            font-size: 0.8rem;
            font-weight: 600;
            color: #212529;
        }
        .property-meta {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.2rem;
        }
        .property-location {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        .property-price {
            font-weight: 700;
            color: #212529;
            font-size: 1.05rem;
        }

        /* Categories */
        .category-box {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem 1rem;
            text-align: center;
            transition: all 0.2s;
            text-decoration: none;
            color: #495057;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .category-box:hover {
            border-color: #0d6efd; /* Bootstrap Primary Blue */
            color: #0d6efd;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
        }
        .category-icon {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: inherit;
        }
        .category-title {
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0;
        }

        /* CTA Banner */
        .cta-banner {
            background-color: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e9ecef;
        }
        .cta-icon-box {
            width: 48px;
            height: 48px;
            background: #f8f9fa;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #495057;
            margin-right: 1.5rem;
            border: 1px solid #e9ecef;
        }

        /* Utilities */
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #212529;
        }
        .section-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .view-more {
            font-size: 0.9rem;
            font-weight: 500;
            color: #0d6efd; /* Bootstrap Primary */
            text-decoration: none;
        }
        .view-more:hover {
            color: #0a58ca;
            text-decoration: underline;
        }
        .btn-outline-primary-custom {
            color: #212529;
            border-color: #dee2e6;
            font-weight: 500;
            border-radius: 8px;
        }
        .btn-outline-primary-custom:hover {
            background-color: #f8f9fa;
            color: #212529;
            border-color: #ced4da;
        }
        
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top py-3">
        <div class="container-fluid px-4 px-xl-5">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <i class="bi bi-house-door-fill text-primary"></i>
                Angorenda
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Search Bar (Center) -->
                <div class="mx-auto my-3 my-lg-0">
                    <form class="search-bar d-flex align-items-center">
                        <i class="bi bi-geo-alt text-muted ms-3 me-2"></i>
                        <div class="flex-grow-1">
                            <input type="text" class="form-control form-control-sm" placeholder="Localização, Província ou Bairro" aria-label="Search">
                        </div>
                        <button class="search-icon-btn ms-2" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Actions -->
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="btn btn-outline-primary-custom d-none d-sm-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i> Anunciar imóvel
                    </a>
                    
                    @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="#">Meu Perfil</a></li>
                                <li><a class="dropdown-item" href="#">Meus Anúncios</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') ?? '#' }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Sair</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-2 border rounded p-1 bg-light">
                             <a href="#" class="btn btn-sm btn-light text-dark shadow-sm border px-3"><i class="bi bi-list"></i></a>
                             <a href="#" class="btn btn-sm btn-dark rounded-circle px-2 disabled"><i class="bi bi-person-fill"></i></a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container-fluid px-4 px-xl-5 py-5">
        
        <!-- Section: Ofertas Exclusivas -->
        <section class="mb-5 pb-4">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h2 class="section-title mb-0">Ofertas exclusivas</h2>
                <a href="#" class="view-more">Ver mais <i class="bi bi-arrow-right-short"></i></a>
            </div>

            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="property-card h-100">
                        <div class="property-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Apartamento" class="property-img">
                            <span class="badge-status">À venda</span>
                            <span class="badge-photos">+9</span>
                            <div class="like-btn"><i class="bi bi-heart"></i></div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="property-title">T5 Zango 2 venda</h3>
                                <div class="property-rating d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill text-dark" style="font-size:0.7rem;"></i> 0.0 · 0
                                </div>
                            </div>
                            <div class="property-meta d-flex gap-2 text-muted">
                                <span><i class="bi bi-door-closed"></i> 5</span>
                                <span><i class="bi bi-asterisk"></i> 2</span> <!-- using asterisk as placeholder for bath -->
                                <span><i class="bi bi-square"></i> N/A</span>
                            </div>
                            <div class="property-location">Zango 2</div>
                            <div class="property-price">AOA 19 000 000,00</div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="property-card h-100">
                        <div class="property-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Quarto" class="property-img">
                            <span class="badge-status bg-dark text-white">Para arrendar</span>
                            <span class="badge-photos bg-dark text-white">+8</span>
                            <div class="like-btn"><i class="bi bi-heart"></i></div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="property-title">T2 para Arrendar</h3>
                                <div class="property-rating d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill text-dark" style="font-size:0.7rem;"></i> 0.0 · 0
                                </div>
                            </div>
                            <div class="property-meta d-flex gap-2 text-muted">
                                <span><i class="bi bi-door-closed"></i> 2</span>
                                <span><i class="bi bi-asterisk"></i> 1</span>
                                <span><i class="bi bi-square"></i> 100m²</span>
                            </div>
                            <div class="property-location">Luanda Sul</div>
                            <div class="property-price">AOA 85 000,00</div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="property-card h-100">
                        <div class="property-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Casa" class="property-img">
                            <span class="badge-status">À venda</span>
                            <span class="badge-photos">+9</span>
                            <div class="like-btn"><i class="bi bi-heart"></i></div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="property-title">T3 suite Zango 2</h3>
                                <div class="property-rating d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill text-dark" style="font-size:0.7rem;"></i> 0.0 · 0
                                </div>
                            </div>
                            <div class="property-meta d-flex gap-2 text-muted">
                                <span><i class="bi bi-door-closed"></i> 3</span>
                                <span><i class="bi bi-asterisk"></i> 2</span>
                                <span><i class="bi bi-square"></i> N/A</span>
                            </div>
                            <div class="property-location">Zango 2</div>
                            <div class="property-price">AOA 17 500 000,00</div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="property-card h-100">
                        <div class="property-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1598228723793-52759bba239c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Imóvel" class="property-img">
                            <span class="badge-status">À venda</span>
                            <span class="badge-photos">+7</span>
                            <div class="like-btn"><i class="bi bi-heart"></i></div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="property-title">T2 Zango 1 Venda</h3>
                                <div class="property-rating d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill text-dark" style="font-size:0.7rem;"></i> 0.0 · 0
                                </div>
                            </div>
                            <div class="property-meta d-flex gap-2 text-muted">
                                <span><i class="bi bi-door-closed"></i> 2</span>
                                <span><i class="bi bi-asterisk"></i> 1</span>
                                <span><i class="bi bi-square"></i> N/A</span>
                            </div>
                            <div class="property-location">Zango 1</div>
                            <div class="property-price">AOA 11 000 000,00</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Explorar Categorias -->
        <section class="mb-5 pb-5 pt-3 text-center">
            <h2 class="section-title mb-1 fs-3">Explorar Categorias</h2>
            <p class="section-subtitle mb-4">Encontre o imóvel perfeito para você</p>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 row-cols-lg-auto justify-content-center g-3">
                <div class="col mx-1" style="width: 130px; max-width: 100%;">
                    <a href="#" class="category-box">
                        <i class="bi bi-building category-icon"></i>
                        <h4 class="category-title">Apartamento</h4>
                    </a>
                </div>
                <div class="col mx-1" style="width: 130px; max-width: 100%;">
                    <a href="#" class="category-box">
                        <i class="bi bi-box-seam category-icon"></i>
                        <h4 class="category-title">Armazém</h4>
                    </a>
                </div>
                <div class="col mx-1" style="width: 130px; max-width: 100%;">
                    <a href="#" class="category-box">
                        <i class="bi bi-house category-icon"></i>
                        <h4 class="category-title">Casa</h4>
                    </a>
                </div>
                <div class="col mx-1" style="width: 130px; max-width: 100%;">
                    <a href="#" class="category-box">
                        <i class="bi bi-buildings category-icon"></i>
                        <h4 class="category-title">Edifício</h4>
                    </a>
                </div>
                <!-- Adding more category items statically -->
                <div class="col mx-1" style="width: 130px; max-width: 100%;">
                    <a href="#" class="category-box">
                        <i class="bi bi-briefcase category-icon"></i>
                        <h4 class="category-title">Escritório</h4>
                    </a>
                </div>
                <div class="col mx-1 d-none d-md-block" style="width: 130px; max-width: 100%;">
                    <a href="#" class="category-box">
                        <i class="bi bi-tree category-icon"></i>
                        <h4 class="category-title">Fazenda</h4>
                    </a>
                </div>
                <div class="col mx-1 d-none d-md-block" style="width: 130px; max-width: 100%;">
                    <a href="#" class="category-box">
                        <i class="bi bi-shop category-icon"></i>
                        <h4 class="category-title">Loja</h4>
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA Banner -->
        <section class="mb-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="cta-banner flex-column flex-md-row text-center text-md-start">
                        <div class="d-flex align-items-center mb-3 mb-md-0 flex-column flex-md-row">
                            <div class="cta-icon-box mb-3 mb-md-0 mx-auto mx-md-0">
                                <i class="bi bi-gift"></i>
                            </div>
                            <div>
                                <h3 class="mb-1" style="font-size: 1.1rem; font-weight: 700;">Anuncie gratuitamente</h3>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">Alcance mais pessoas e feche negócios</p>
                            </div>
                        </div>
                        <a href="#" class="btn btn-dark px-4 py-2" style="border-radius: 8px;">Publicar <i class="bi bi-arrow-right-short ms-1"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Recomendações Especiais -->
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h2 class="section-title mb-0">Recomendações especiais</h2>
            </div>

            <div class="row g-4">
                <!-- Reusing the exact same card layout design -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="property-card h-100">
                        <div class="property-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Vivenda" class="property-img">
                            <span class="badge-status">À venda</span>
                            <span class="badge-photos">+4</span>
                            <div class="like-btn"><i class="bi bi-heart"></i></div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="property-title">Vivenda V6 no Condomínio</h3>
                                <div class="property-rating d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill text-dark" style="font-size:0.7rem;"></i> 0.0 · 0
                                </div>
                            </div>
                            <div class="property-meta d-flex gap-2 text-muted">
                                <span><i class="bi bi-door-closed"></i> 6</span>
                                <span><i class="bi bi-asterisk"></i> 10</span>
                                <span><i class="bi bi-square"></i> N/A</span>
                            </div>
                            <div class="property-location">Bela Vista</div>
                            <div class="property-price">AOA 500 000 000,00</div>
                        </div>
                    </div>
                </div>
                
                <!-- Repeat for demo -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="property-card h-100">
                        <div class="property-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1502672260266-1c1e54117320?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Imóvel" class="property-img">
                            <span class="badge-status">À venda</span>
                            <span class="badge-photos">+4</span>
                            <div class="like-btn"><i class="bi bi-heart"></i></div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="property-title">Espaço Comercial - Baixa</h3>
                                <div class="property-rating d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill text-dark" style="font-size:0.7rem;"></i> 0.0 · 0
                                </div>
                            </div>
                            <div class="property-meta d-flex gap-2 text-muted">
                                <span><i class="bi bi-door-closed"></i> 0</span>
                                <span><i class="bi bi-asterisk"></i> 0</span>
                                <span><i class="bi bi-square"></i> 178m²</span>
                            </div>
                            <div class="property-location">Ingombota</div>
                            <div class="property-price">AOA 380 000 000,00</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="property-card h-100">
                        <div class="property-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Apartamento" class="property-img">
                            <span class="badge-status bg-dark text-white">Para arrendar</span>
                            <span class="badge-photos">+6</span>
                            <div class="like-btn"><i class="bi bi-heart"></i></div>
                        </div>
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h3 class="property-title">Apartamento T2</h3>
                                <div class="property-rating d-flex align-items-center gap-1">
                                    <i class="bi bi-star-fill text-dark" style="font-size:0.7rem;"></i> 0.0 · 0
                                </div>
                            </div>
                            <div class="property-meta d-flex gap-2 text-muted">
                                <span><i class="bi bi-door-closed"></i> 2</span>
                                <span><i class="bi bi-asterisk"></i> 2</span>
                                <span><i class="bi bi-square"></i> N/A</span>
                            </div>
                            <div class="property-location">Talatona</div>
                            <div class="property-price">AOA 1 200 000,00</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
