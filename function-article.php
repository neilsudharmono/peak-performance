<?php
include 'db/load_facilities.php'; // Include the file containing the function
$facilities = loadFacilities($pdo, 'Function'); // Load Tennis facilities
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Function | Peak Performance Sports Club</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico" />
    <link rel="stylesheet" href="css/header.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/image-header-no-title.css" />
    <link rel="stylesheet" href="css/page-info.css" />
    <link rel="stylesheet" href="css/faq.css" />
    <link rel="stylesheet" href="css/booking-form.css" />
  </head>
  <body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <main>
      <!-- Image Banner -->
      <div class="about-us-banner">
        <img src="img/function-banner.png" alt="Function Banner" />
      </div>

      <!-- Page Info -->
      <section class="content-container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              <a href="about-us.php">ABOUT</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FUNCTION</li>
          </ol>
        </nav>

        <h1 class="page-title">Plan you special moments with us</h1>

        <p class="page-description">
          Our function facilities at Peak Performance Sports Club provide the
          perfect setting for a wide range of events, from corporate meetings
          and conferences to weddings and private celebrations. With flexible
          spaces that can be customized to suit your needs, our venue offers the
          ideal backdrop for any occasion. Our experienced event staff is
          dedicated to ensuring that every detail is handled with care, from
          planning to execution, so you can focus on enjoying your special day.
          Whether you're hosting an intimate gathering or a large event, our
          facilities are equipped to accommodate your guests in style and
          comfort.
        </p>
      </section>

      <section id="faq">
        <h2>Frequently Asked Questions</h2>

        <div class="faq-item">
          <div class="faq-question">
            How can I book the function facilities for an event?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer">
            To book our function facilities, please contact our events team
            through the club's website or call us directly. We'll assist you in
            selecting the right space, discuss your specific needs, and help you
            plan your event from start to finish.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            What types of events can be hosted at the club?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer">
            Our function facilities are versatile and can host a wide range of
            events, including corporate meetings, conferences, weddings,
            birthday parties, and other private celebrations. We offer
            customizable options to ensure that your event is tailored to your
            preferences.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            What is included in the function facilities rental?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer">
            The rental of our function facilities includes access to the event
            space, tables and chairs, basic audio-visual equipment, and on-site
            event coordination. Additional services such as catering,
            decoration, and specialized equipment can be arranged upon request.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            Can I bring my own caterer or decorations?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer">
            Yes, you are welcome to bring your own caterer and decorations,
            although we also offer in-house catering and decoration services. If
            you choose to bring your own, we recommend coordinating with our
            events team to ensure everything meets our venue's guidelines and
            standards.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            Is there parking available for event guests?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer">
            Yes, we have ample parking available on-site for event guests. Our
            parking facilities are conveniently located near the function
            spaces, making it easy for your guests to access the venue.
          </div>
        </div>
      </section>

      <section class="booking-form">
        <h2>Book our place for you moments</h2>
        <form action="db/booking_process.php" method="post" id="tennis-booking-form" novalidate>
        <div class="form-group">
            <label for="facility">Choose a Venue:</label>
            <select name="facility" id="facility">
                <?php foreach ($facilities as $facility): ?>
                    <option value="<?= $facility['FacilityID'] ?>"><?= $facility['FacilityName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
          <div class="form-group">
            <label for="first-name">First Name *</label>
            <input type="text" id="first-name" name="first-name" required />
            <span id="first-name-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="last-name">Last Name *</label>
            <input type="text" id="last-name" name="last-name" required />
            <span id="last-name-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required />
            <span id="email-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              required
              pattern="^\d{10}$"
            />
            <span id="phone-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="booking-date">Booking Date *</label>
            <input type="date" id="booking-date" name="booking-date" required />
            <span id="booking-date-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="time-from">Time From *</label>
            <input type="time" id="time-from" name="time-from" required />
            <span id="time-from-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="time-to">Time To *</label>
            <input type="time" id="time-to" name="time-to" required />
            <span id="time-to-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="note">Note</label>
            <input type="text" id="note" name="note" />
          </div>
          <button type="submit">Submit</button>
          <?php if (isset($_GET['bookingSuccess']) && $_GET['bookingSuccess'] == TRUE): ?>
            <br>
            <div id="success-message" class="success-message">Your booking has been successfully submitted!</div>
        <?php endif; ?>
        </form>
      </section>
    </main>
    <?php include 'footer.php'; ?>

  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/faq.js"></script>
  <script src="scripts/booking-form.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('success-message');
    if (successMessage) {
        window.scrollTo(0, successMessage.getBoundingClientRect().top + window.scrollY);
    }
});
</script>
</html>