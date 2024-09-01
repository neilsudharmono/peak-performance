<?php
require('db/load_facilities.php'); // Include the file containing the function
$facilities = loadFacilities($pdo, 'Tennis'); // Load Tennis facilities
$today = date('Y-m-d', strtotime('+1 day')); // Calculate today + 1
require('db/retrieve_user.php');
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tennis | Peak Performance Sports Club</title>
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
      <section class="about-us-banner">
        <img src="img/tennis-banner.png" alt="About Us Banner" />
      </section>

      <!-- Page Info -->
      <section class="content-container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              <a href="about-us.php">ABOUT</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">TENNIS</li>
          </ol>
        </nav>

        <h1 class="page-title">Tennis facilities</h1>

        <p class="page-description">
          Our tennis facilities at Peak Performance Sports Club boast five
          premium courts, available for booking by members and guests alike.
          Each court is meticulously maintained to ensure optimal playing
          conditions, providing an excellent environment for both casual and
          competitive play. Whether you're a beginner looking to improve your
          game or a seasoned player seeking a challenging match, our courts
          offer the perfect setting to enjoy the sport.
        </p>
        <p class="page-description">
          Our booking system is designed to be user-friendly, making it easy to
          reserve your preferred time slot and get on the court when it suits
          you best. Beyond regular play, our tennis program is enhanced by a
          variety of exciting events and activities. We frequently host
          tournaments that cater to all skill levels, from amateur to advanced,
          allowing players to test their abilities in a competitive yet friendly
          atmosphere. Additionally, we offer workshops led by experienced
          coaches, designed to help players refine their techniques and gain new
          insights into the game. These events, along with social mixers,
          provide fantastic opportunities to meet fellow tennis enthusiasts,
          foster a sense of community, and deepen your love for the sport.
        </p>
      </section>

      <section id="faq">
        <h2>Frequently Asked Questions</h2>

        <div class="faq-item">
          <div class="faq-question" aria-expanded="false" aria-controls="faq1">
            How can I book a tennis court?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer" id="faq1">
            You can book a tennis court through our online booking system
            available on the club's website. Simply log in with your membership
            details, select the date and time, and choose an available court.
            You can also make bookings in person at the club's reception.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" aria-expanded="false" aria-controls="faq2">
            What is the cancellation policy for court bookings?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer" id="faq2">
            We require at least 24 hours' notice for court booking
            cancellations. If you cancel within this timeframe, you will receive
            a full refund. Cancellations made less than 24 hours before the
            booking will be charged in full.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" aria-expanded="false" aria-controls="faq3">
            Are there any tournaments or events held at the club?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer" id="faq3">
            Yes, we regularly host a variety of tournaments and events,
            including singles and doubles competitions, as well as social mixers
            and workshops. These events are open to members of all skill levels
            and provide a great opportunity to engage with other tennis
            enthusiasts.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" aria-expanded="false" aria-controls="faq4">
            Is coaching available for all skill levels?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer" id="faq4">
            Absolutely! Our coaching programs cater to players of all levels,
            from beginners to advanced. We offer private lessons, group
            sessions, and specialized workshops led by experienced coaches to
            help you improve your game.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question" aria-expanded="false" aria-controls="faq5">
            Can non-members participate in events or book courts?
            <img
              src="img/down-arrow.png"
              class="faq-arrow"
              alt="Toggle Arrow"
            />
          </div>
          <div class="faq-answer" id="faq5">
            Yes, non-members are welcome to participate in certain events and
            book courts, though priority is given to members. Non-members may
            also be subject to different pricing. Please contact the club for
            specific details regarding non-member participation.
          </div>
        </div>
      </section>

      <section class="booking-form">
        <h2>Book our Tennis Court</h2>
        <form action="db/booking_process.php" method="post" id="tennis-booking-form" novalidate>
        <div class="form-group">
            <label for="facility">Choose a Tennis Court:</label>
            <select name="facility" id="facility" onchange="fetchAvailableTimeSlots()">
                <?php foreach ($facilities as $facility): ?>
                    <option value="<?= $facility['FacilityID'] ?>"><?= $facility['FacilityName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
          <div class="form-group">
            <label for="first-name">First Name *</label>
            <input type="text" id="first-name" name="first-name" value="<?php echo $firstName; ?>" disabled required />
            <span id="first-name-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="last-name">Last Name *</label>
            <input type="text" id="last-name" name="last-name" value="<?php echo $lastName; ?>" disabled required />
            <span id="last-name-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" disabled required />
            <span id="email-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              required
              disabled
              pattern="^\d{10}$"
              value="<?php echo $phone; ?>"
            />
            <span id="phone-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="booking-date">Booking Date *</label>
            <input type="date" id="booking-date" name="booking-date" value="<?php echo $today; ?>" onchange="fetchAvailableTimeSlots()" required />
            <span id="booking-date-error" class="error-message"></span>
          </div>
          <div class="form-group" id="time-duration-group">

             <label for="time-duration">Time Duration</label>
             <select id="time-duration" name="time-duration">
                    <!-- Options will be dynamically populated via JavaScript -->
              </select>
             <span class="error-message" id="time-duration-error"></span>
          </div>
          <div class="form-group">
            <label for="note">Note</label>
            <input type="text" id="note" name="note" />
          </div>
          <button type="submit">Book Now</button>

          <?php if (isset($_GET['bookingSuccess']) && $_GET['bookingSuccess'] == 'TRUE'): ?>
            <br>
            <div id="success-message" class="success-message">Your booking has been successfully submitted!</div>
        <?php endif; ?>

        <?php if (isset($_GET['bookingSuccess']) && $_GET['bookingSuccess'] == 'FALSE'): ?>
            <br>
            <div id="success-message" class="success-message">Your booking has not been successful! Please try again</div>
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
