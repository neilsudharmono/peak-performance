<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- SEO and Social Sharing Meta Tags -->
    <meta name="description" content="Join Peak Performance Sports Club for tennis, lawn bowl, and more. Explore our state-of-the-art facilities, exciting events, and membership benefits." />
    <meta name="keywords" content="Tennis, Lawn Bowl, Sports Club, Membership, Peak Performance, NSW, Sports, Events" />
    <meta name="author" content="Peak Performance Sports Club" />

    <!-- Open Graph for Social Media -->
    <meta property="og:title" content="Peak Performance Sports Club" />
    <meta property="og:description" content="Join Peak Performance Sports Club and enjoy premium tennis and lawn bowl facilities in NSW, along with exclusive events and memberships." />
    <meta property="og:image" content="https://example.com/img/hero-banner.png" />
    <meta property="og:url" content="https://example.com" />
    <meta property="og:type" content="website" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Peak Performance Sports Club" />
    <meta name="twitter:description" content="Explore the best tennis and lawn bowl facilities, and sign up for exclusive memberships and events at Peak Performance Sports Club." />
    <meta name="twitter:image" content="https://example.com/img/hero-banner.png" />

    <title>Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/peak-performance/img/favicon1.png" />
    <link rel="stylesheet" href="css/header.css?v=1.0" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/hero-banner.css" />
    <link rel="stylesheet" href="css/horizontal-scroll.css" />
    <link rel="stylesheet" href="css/mansonry.css" />
    <link rel="stylesheet" href="css/subscribe-form.css" />
</head>
  <body>
    <!-- Header -->
    <?php include "header.php"; ?>
    <main>
      <!-- Hero Banner -->
      <section class="hero-banner">
        <div class="video-wrapper">
          <iframe
            src="https://www.youtube.com/embed/bX6frsuoRW8?autoplay=1&mute=1&loop=1&playlist=bX6frsuoRW8&controls=0&showinfo=0&modestbranding=1&iv_load_policy=3"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen
            aria-label="Promotional video of Peak Performance Sports Club showing various activities."
          >
          </iframe>
        </div>
        <div class="overlay"></div>
        <div class="hero-content">
          <h1>Welcome to Peak Performance</h1>
          <p>Your Tennis & Bowl Sports Club</p>
        </div>
      </section>

      <!-- Masonry Block -->
      <section class="masonry-section">
        <h1 class="masonry-title">Discover the club</h1>
        <div class="masonry-container">
          <!-- Left Column -->
          <div class="masonry-column">
            <a href="tennis-article.php" class="masonry-item-link" aria-label="Learn about Tennis at Peak Performance Sports Club">
              <div class="masonry-item large">
                <img src="img/tennis.png" alt="Tennis activities at Peak Performance Sports Club" />
                <div class="masonry-text">TENNIS</div>
              </div>
            </a>
            <div class="masonry-row">
              <a href="contact-us.php" class="masonry-item-link" aria-label="Contact Peak Performance Sports Club">
                <div class="masonry-item small">
                  <img src="img/contact.png" alt="Contact us icon" />
                  <div class="masonry-text">CONTACT US</div>
                </div>
              </a>
              <a href="latest-events.php" class="masonry-item-link" aria-label="Check out the latest events at Peak Performance Sports Club">
                <div class="masonry-item small">
                  <img src="img/latest-events.png" alt="Latest events icon" />
                  <div class="masonry-text">Our events</div>
                </div>
              </a>
            </div>
          </div>

          <!-- Right Column -->
          <div class="masonry-column">
            <div class="masonry-row">
              <a href="membership.php" class="masonry-item-link" aria-label="Learn about memberships at Peak Performance Sports Club">
                <div class="masonry-item small">
                  <img src="img/membership.png" alt="Membership options at Peak Performance Sports Club" />
                  <div class="masonry-text">MEMBERSHIP</div>
                </div>
              </a>
              <a href="function-article.php" class="masonry-item-link" aria-label="Discover functions and events at Peak Performance Sports Club">
                <div class="masonry-item small">
                  <img src="img/function.png" alt="Function hall at Peak Performance Sports Club" />
                  <div class="masonry-text">FUNCTION</div>
                </div>
              </a>
            </div>
            <a href="lawn-bowl-article.php" class="masonry-item-link" aria-label="Explore lawn bowl activities at Peak Performance Sports Club">
              <div class="masonry-item large">
                <img src="img/lawnbowl.png" alt="Lawn bowl activities at Peak Performance Sports Club" />
                <div class="masonry-text">LAWN BOWL</div>
              </div>
            </a>
          </div>
        </div>
      </section>

      <!-- Horizontal Scroll -->
      <section class="events-section">
        <div class="events-header">
          <h2 class="events-title">Our latest events</h2>
          <div class="events-navigation" aria-label="Event navigation arrows">
            <button class="arrow left-arrow" aria-label="Previous events">
              <img src="img/left-arrow.png" alt="Left arrow for previous events" />
            </button>
            <button class="arrow right-arrow" aria-label="Next events">
              <img src="img/right-arrow.png" alt="Right arrow for next events" />
            </button>
          </div>
        </div>
        <div class="events-container" aria-label="Latest events listings">
          <!-- Event tiles will be dynamically generated here -->
        </div>
      </section>

      <!-- Subscribe Section -->
      <section class="subscribe-section">
        <div class="subscribe-title">
          <h2>The best tennis & lawn bowl club in NSW!</h2>
        </div>
        <div class="subscribe-content-wrapper">
          <div class="subscribe-content">
            <p>
              Sign up to the Peak Performance Sports Club newsletter for exclusive updates on upcoming offers and events.
            </p>
          </div>
          <div class="subscribe-form-container">
            <form action="db/subscribe_process.php" method="post" class="subscribe-form" aria-label="Subscription form">
              <input
                type="email"
                name="email"
                placeholder="Email"
                required
                aria-label="Enter your email address"
                id="email"
              />
              <button type="submit" aria-label="Subscribe to the newsletter">
                Subscribe
              </button>
            </form>
            <!-- Success message -->
            <div class="subscribe-success-message" id="success-message">
              Successfully subscribed!
            </div>
          </div>
        </div>
      </section>

    </main>
    <?php include "footer.php"; ?>
  </body>

  <script src="scripts/script.js"></script>
  <script src="scripts/horizontal-scroll.js"></script>
  <script>
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('subscribeSuccess') === 'TRUE') {
        document.getElementById('success-message').style.display = 'block';
      }
  </script>
</html>
