<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Latest Events | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/image-header-no-title.css" />
    <link rel="stylesheet" href="css/page-info.css" />
    <link rel="stylesheet" href="css/filtering.css" />
  </head>
  <body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <main>
      <!-- Image Banner -->
      <div class="about-us-banner">
        <img src="img/latest-events-banner.png" alt="About Us Banner" />
      </div>

      <!-- Page Info -->
      <section class="content-container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              OUR EVENTS
            </li>
          </ol>
        </nav>

        <h1 class="page-title">Our Latest Events</h1>

        <p class="page-description">
          Discover our upcoming events designed to inspire, connect, and
          entertain. Whether you're looking to attend workshops, conferences, or
          social gatherings, our latest events lineup offers something for
          everyone. Browse through our curated list of future events, each
          featuring detailed descriptions, dates, and categories to help you
          find the perfect occasion to attend. Stay ahead of the curve and make
          sure to mark your calendar for these exciting opportunities to engage
          with our vibrant community.
        </p>
      </section>

      <!-- Filtering -->

      <section class="filtered-events-container">
        <!-- Filter Section -->
        <aside class="filter-section">
          <h3>Category</h3>
          <div class="categories">
            <button class="filter-button active" data-category="ALL">
              ALL
            </button>
            <button class="filter-button" data-category="Tennis">TENNIS</button>
            <button class="filter-button" data-category="Lawn Bowl">
              LAWN BOWL
            </button>
            <button class="filter-button" data-category="Function">
              FUNCTIONS
            </button>
          </div>

          <h3>Time</h3>
          <div class="time-filter">
            <label
              ><input type="checkbox" data-time="thisWeek" /> This Week</label
            >
            <label
              ><input type="checkbox" data-time="thisMonth" /> This Month</label
            >
            <label
              ><input type="checkbox" data-time="nextMonth" /> Next Month</label
            >
            <label
              ><input type="checkbox" data-time="thisYear" /> This Year</label
            >
          </div>
        </aside>

        <!-- Events Listing Section -->
        <section class="filtered-event-listing">
          <div
            id="filtered-event-tiles-container"
            class="filtered-event-tiles"
          ></div>
          <p
            id="no-result-message"
            class="no-result-message"
            style="display: none"
          >
            Sorry, no events match your selection.
          </p>
          <div id="pagination" class="pagination">
            <button id="prevPage" class="arrow left-arrow">
              <img src="img/left-arrow.png" alt="Previous Page" />
            </button>
            <button id="nextPage" class="arrow right-arrow">
              <img src="img/right-arrow.png" alt="Next Page" />
            </button>
          </div>
        </section>
      </section>
    </main>

    <?php include 'footer.php'; ?>

  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/filter.js"></script>
</html>
