<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PropertyPlace | Find Property</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    /* === Reset & Base === */
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden; /* tidak bisa di-scroll */
      font-family: 'Poppins', sans-serif;
      background-color: #202429;
      color: #DAD3C5;
    }

    /* === Background Hero === */
    .hero-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('assets/img/hero/hero_thumb_8_1.jpg') center/cover no-repeat;
      animation: fadeBg 20s infinite alternate;
      z-index: 0;
    }

    @keyframes fadeBg {
      0%   { background-image: url('assets/img/hero/hero_thumb_8_1.jpg'); }
      33%  { background-image: url('assets/img/hero/hero_thumb_8_2.jpg'); }
      66%  { background-image: url('assets/img/hero/hero_thumb_8_3.jpg'); }
      100% { background-image: url('assets/img/hero/hero_thumb_8_1.jpg'); }
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(32, 36, 41, 0.75);
      z-index: 1;
    }

    /* === Pencarian === */
    .hero-search {
      position: relative;
      z-index: 2;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 0 20px;
    }

    .hero-search h1 {
      font-size: 2.2rem;
      margin-bottom: 10px;
    }

    .hero-search p {
      color: #C0B9AD;
      font-size: 1rem;
      margin-bottom: 30px;
    }

    form.property-search {
      background: rgba(43, 47, 54, 0.9);
      padding: 25px 20px;
      border-radius: 14px;
      box-shadow: 0 4px 25px rgba(0,0,0,0.4);
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      max-width: 800px;
      width: 100%;
    }

    form.property-search input,
    form.property-search select {
      flex: 1 1 180px;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      color: #202429;
      background: #fff;
    }

    form.property-search button {
      background: #DAD3C5;
      color: #202429;
      border: none;
      border-radius: 8px;
      padding: 12px 24px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    form.property-search button:hover {
      background: #bdb6a8;
    }

    @media (max-width: 768px) {
      .hero-search h1 { font-size: 1.8rem; }
      form.property-search { flex-direction: column; }
      form.property-search input,
      form.property-search select,
      form.property-search button {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="hero-bg"></div>
  <div class="overlay"></div>

  <section class="hero-search">
    <h1>Find Your Dream Property</h1>
    <p>Discover the perfect home or investment — search easily below.</p>

    <form class="property-search" action="<?= base_url('/property/search') ?>" method="get">
      <input type="text" name="keyword" placeholder="Listing ID or Location" required />
      <select name="category">
        <option value="">Category</option>
        <option value="luxury">Luxury</option>
        <option value="residential">Residential</option>
        <option value="commercial">Commercial</option>
      </select>
      <select name="offer_type">
        <option value="">Offer Type</option>
        <option value="sale">For Sale</option>
        <option value="rent">For Rent</option>
      </select>
      <button type="submit"><i class="fa fa-search"></i> Search</button>
    </form>
  </section>
</body>
</html>
