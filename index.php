<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/hero-banner.css" />
    <link rel="stylesheet" href="css/horizontal-scroll.css" />
    <link rel="stylesheet" href="css/mansonry.css" />
    <link rel="stylesheet" href="css/subscribe-form.css" />
  </head>
  <body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <main>
      <!-- Hero Banner -->
      <section class="hero-banner">
        <div class="video-wrapper">
          <iframe
            src="https://www.youtube.com/embed/bX6frsuoRW8?autoplay=1&mute=1&loop=1&playlist=bX6frsuoRW8&controls=0&showinfo=0&modestbranding=1&iv_load_policy=3"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen
            aria-label="Banner video the Peak Performance Sport Club"
          >
          </iframe>
        </div>
        <div class="overlay"></div>
        <div class="hero-content">
          <h1>Welcome to Peak Performance</h1>
          <p>Your Tennis & Bowl Sports Club</p>
        </div>
      </section>

      <!-- Mansonry Block -->
      <section class="masonry-section">
        <h1 class="masonry-title">Discover the club</h1>
        <div class="masonry-container">
          <!-- Left Column -->
          <div class="masonry-column">
            <a href="tennis-article.php" class="masonry-item-link">
              <div class="masonry-item large">
                <img src="img/tennis.png" alt="Tennis" />
                <div class="masonry-text">TENNIS</div>
              </div>
            </a>
            <div class="masonry-row">
              <a href="contact-us.php" class="masonry-item-link">
                <div class="masonry-item small">
                  <img src="img/contact.png" alt="Office" />
                  <div class="masonry-text">CONTACT US</div>
                </div>
              </a>
              <a href="latest-events.php" class="masonry-item-link">
                <div class="masonry-item small">
                  <img src="img/latest-events.png" alt="Gym" />
                  <div class="masonry-text">Our events</div>
                </div>
              </a>
            </div>
          </div>

          <!-- Right Column -->
          <div class="masonry-column">
            <div class="masonry-row">
              <a href="membership.php" class="masonry-item-link">
                <div class="masonry-item small">
                  <img src="img/membership.png" alt="Dinner" />
                  <div class="masonry-text">MEMBERSHIP</div>
                </div>
              </a>
              <a href="function-article.php" class="masonry-item-link">
                <div class="masonry-item small">
                  <img src="img/function.png" alt="Function" />
                  <div class="masonry-text">FUNCTION</div>
                </div>
              </a>
            </div>
            <a href="lawn-bowl-article.php" class="masonry-item-link">
              <div class="masonry-item large">
                <img src="img/lawnbowl.png" alt="Lawn Bowl" />
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
          <div class="events-navigation">
            <button class="arrow left-arrow">
              <img src="img/left-arrow.png" alt="Left Arrow" />
            </button>
            <button class="arrow right-arrow">
              <img src="img/right-arrow.png" alt="Right Arrow" />
            </button>
          </div>
        </div>
        <div class="events-container">
          <!-- Event tiles will be dynamically generated here -->
        </div>
      </section>

      <!-- Subscribe Section -->
      <section class="subscribe-section">
        <div class="subscribe-title">
          <h2>THE BEST tennis & lawn bowl club in NSW!</h2>
        </div>
        <div class="subscribe-content-wrapper">
          <div class="subscribe-content">
            <p>
              Sign up to the Peak Performance Sport Club newsletter to receive
              exclusive updates about all our upcoming offers and functions.
            </p>
          </div>
          <div class="subscribe-form-container">
            <form action="db/subscribe_process.php" method="post" class="subscribe-form">
              <input
                type="email"
                name="email"
                placeholder="Email"
                required
                aria-label="Email address"
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
    <?php include 'footer.php'; ?>
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
