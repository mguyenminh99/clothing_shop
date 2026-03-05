<?php
$base = rtrim(base_url(), '/');
$featured = $featured_products ?? [];
$newArrivals = $new_arrivals ?? [];
$bestSellers = $best_sellers ?? [];
// Banner & ad slots: replace with your image/link or leave empty to hide
$banner_main = $banner_main ?? null;   // ['image' => 'url', 'link' => 'url', 'alt' => 'text']
$banner_mid  = $banner_mid ?? null;    // same structure
$ad_slots    = $ad_slots ?? [];       // array of ['image' => 'url', 'link' => 'url', 'alt' => 'text']

function home_product_card($p, $base) {
    $thumb = $p->thumbnail ?? '';
    $imgSrc = $thumb ? (strpos($thumb, 'http') === 0 || strpos($thumb, '/') === 0 ? $thumb : asset($thumb)) : '';
    $price = isset($p->discount_price) && $p->discount_price > 0 ? (float)$p->discount_price : (float)($p->base_price ?? 0);
    $link = $base . '/products/' . (int)($p->id ?? 0);
    ?>
    <li class="product-card">
        <a href="<?= $link ?>" class="product-link">
            <div class="product-image-wrap">
                <?php if ($imgSrc): ?><img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($p->name ?? '') ?>" class="product-image" loading="lazy"><?php else: ?><div class="product-image product-image--placeholder"></div><?php endif; ?>
            </div>
            <div class="product-info">
                <h3 class="product-name"><?= htmlspecialchars($p->name ?? '') ?></h3>
                <span class="price-current"><?= number_format($price, 0, ',', '.') ?></span>
            </div>
        </a>
    </li>
<?php
}
?>
<div class="home-page">
    <section class="hero-section">
        <div class="hero-content">
            <h1>Welcome to our store</h1>
            <p>Discover the latest products and special offers.</p>
            <a href="<?= $base ?>/products" class="btn-hero">View products</a>
        </div>
    </section>

    <!-- Main banner slot (full-width, below hero) -->
    <section class="home-banner home-banner--main" aria-label="Promo banner">
        <?php if (!empty($banner_main['image'])): ?>
            <a href="<?= htmlspecialchars($banner_main['link'] ?? $base . '/products') ?>" class="home-banner-link">
                <img src="<?= htmlspecialchars($banner_main['image']) ?>" alt="<?= htmlspecialchars($banner_main['alt'] ?? 'Promo') ?>" class="home-banner-img" loading="lazy">
            </a>
        <?php else: ?>
            <div class="home-banner-placeholder" data-slot="main">Banner slot — add image/link via <code>banner_main</code></div>
        <?php endif; ?>
    </section>

    <?php if (!empty($newArrivals)): ?>
    <section class="home-section home-section--alt">
        <div class="shop-container">
            <h2 class="home-section-title">New arrivals</h2>
            <p class="home-section-desc">Just landed — fresh picks for you.</p>
            <ul class="product-grid product-grid--home">
                <?php foreach ($newArrivals as $p) { home_product_card($p, $base); } ?>
            </ul>
            <p class="home-section-link"><a href="<?= $base ?>/products" class="pagination-link">View all new arrivals</a></p>
        </div>
    </section>
    <?php endif; ?>

    <!-- Mid-page banner (between New arrivals and Best sellers) -->
    <section class="home-banner home-banner--mid" aria-label="Mid-page banner">
        <?php if (!empty($banner_mid['image'])): ?>
            <a href="<?= htmlspecialchars($banner_mid['link'] ?? $base . '/products') ?>" class="home-banner-link">
                <img src="<?= htmlspecialchars($banner_mid['image']) ?>" alt="<?= htmlspecialchars($banner_mid['alt'] ?? 'Promo') ?>" class="home-banner-img" loading="lazy">
            </a>
        <?php else: ?>
            <div class="home-banner-placeholder" data-slot="mid">Banner slot — add image/link via <code>banner_mid</code></div>
        <?php endif; ?>
    </section>

    <?php if (!empty($bestSellers)): ?>
    <section class="home-section">
        <div class="shop-container">
            <h2 class="home-section-title">Best sellers</h2>
            <p class="home-section-desc">Customer favorites — top picks this season.</p>
            <ul class="product-grid product-grid--home">
                <?php foreach ($bestSellers as $p) { home_product_card($p, $base); } ?>
            </ul>
            <p class="home-section-link"><a href="<?= $base ?>/products" class="pagination-link">View all best sellers</a></p>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($featured)): ?>
    <section class="home-section home-section--alt">
        <div class="shop-container">
            <h2 class="home-section-title">Featured products</h2>
            <p class="home-section-desc">Handpicked highlights from our collection.</p>
            <ul class="product-grid product-grid--home">
                <?php foreach (array_slice($featured, 0, 8) as $p) { home_product_card($p, $base); } ?>
            </ul>
            <p class="home-section-link"><a href="<?= $base ?>/products" class="pagination-link">View all</a></p>
        </div>
    </section>
    <?php endif; ?>

    <!-- Ad strip: multiple slots in a row -->
    <section class="home-ads" aria-label="Advertisements">
        <div class="shop-container home-ads-inner">
            <?php if (!empty($ad_slots)): ?>
                <?php foreach (array_slice($ad_slots, 0, 3) as $ad): ?>
                    <div class="home-ad-slot">
                        <?php if (!empty($ad['image'])): ?>
                            <a href="<?= htmlspecialchars($ad['link'] ?? '#') ?>" class="home-ad-link">
                                <img src="<?= htmlspecialchars($ad['image']) ?>" alt="<?= htmlspecialchars($ad['alt'] ?? 'Ad') ?>" class="home-ad-img" loading="lazy">
                            </a>
                        <?php else: ?>
                            <div class="home-ad-placeholder">Ad slot</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="home-ad-slot"><div class="home-ad-placeholder">Ad 1</div></div>
                <div class="home-ad-slot"><div class="home-ad-placeholder">Ad 2</div></div>
                <div class="home-ad-slot"><div class="home-ad-placeholder">Ad 3</div></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="home-cta">
        <div class="shop-container">
            <h2 class="home-cta-title">Ready to explore?</h2>
            <p class="home-cta-desc">Browse our full collection and find your next favorite.</p>
            <a href="<?= $base ?>/products" class="btn-hero">Shop all products</a>
        </div>
    </section>
</div>
<style>
.hero-section{text-align:center;padding:60px 20px;background:linear-gradient(135deg,#f8f6f0 0%,#eee 100%);}
.hero-content h1{margin:0 0 12px;font-size:2rem;}
.btn-hero{display:inline-block;padding:12px 28px;background:#1a1a1a;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;margin-top:16px;}
.btn-hero:hover{background:#d4af37;color:#1a1a1a;}
.home-section{padding:48px 20px;}
.home-section--alt{background:#fafafa;}
.home-section-title{margin:0 0 8px;font-size:1.75rem;}
.home-section-desc{margin:0 0 24px;color:#666;font-size:1rem;}
.home-section-link{text-align:center;margin-top:1.5rem;}
.product-grid--home{margin-bottom:0;}
.product-image--placeholder{background:#e0e0e0;}
/* Banners */
.home-banner{overflow:hidden;}
.home-banner--main{min-height:180px;margin:0;}
.home-banner--mid{min-height:140px;margin:0;background:#f0f0f0;}
.home-banner-link{display:block;line-height:0;}
.home-banner-img{width:100%;height:auto;display:block;object-fit:cover;}
.home-banner--main .home-banner-img{max-height:320px;object-position:center;}
.home-banner--mid .home-banner-img{max-height:220px;}
.home-banner-placeholder,.home-ad-placeholder{display:flex;align-items:center;justify-content:center;min-height:120px;background:#e8e8e8;color:#888;font-size:14px;text-align:center;padding:20px;}
.home-banner--main .home-banner-placeholder{min-height:180px;}
.home-banner--mid .home-banner-placeholder{min-height:140px;}
.home-banner-placeholder code{font-size:12px;background:#ddd;padding:2px 6px;border-radius:3px;}
/* Ad strip */
.home-ads{padding:32px 20px;background:#f5f5f5;}
.home-ads-inner{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
.home-ad-slot{border-radius:8px;overflow:hidden;}
.home-ad-link{display:block;line-height:0;}
.home-ad-img{width:100%;height:auto;display:block;object-fit:cover;min-height:100px;}
.home-ad-placeholder{min-height:100px;border:1px dashed #ccc;}
@media (max-width:768px){.home-ads-inner{grid-template-columns:1fr;}.home-ad-placeholder{min-height:80px;}}
.home-cta{text-align:center;padding:56px 20px;background:linear-gradient(135deg,#1a1a1a 0%,#333 100%);color:#fff;}
.home-cta-title{margin:0 0 8px;font-size:1.5rem;color:#fff;}
.home-cta-desc{margin:0 0 20px;color:rgba(255,255,255,0.85);}
.home-cta .btn-hero{background:#fff;color:#1a1a1a;}
.home-cta .btn-hero:hover{background:#d4af37;color:#1a1a1a;}
</style>