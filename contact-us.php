<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Get in touch with Peak Performance Sports Club for inquiries, feedback, or support. Use our contact form to reach out for any questions." />
    <meta name="keywords" content="Contact Peak Performance Sports Club, sports club support, sports club inquiries, tennis club contact, lawn bowl club contact" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Peak Performance Sports Club" />
    <meta name="theme-color" content="#084149" />
    <link rel="icon" type="image/x-icon" href="/peak-performance/img/favicon1.png" />
    <title>Contact us | Peak Performance Sports Club</title>
    <link rel="stylesheet" href="css/header.css?v=1.0" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/image-header-no-title.css" />
    <link rel="stylesheet" href="css/page-info.css" />
    <link rel="stylesheet" href="css/faq.css" />
    <link rel="stylesheet" href="css/contact-form.css" />
  </head>
  <body>
    <!-- Header -->
    <?php include "header.php"; ?>

    <main>
      <!-- Image Banner -->
      <div class="about-us-banner">
        <img src="img/contact-us.png" alt="About Us Banner" />
      </div>

      <!-- Page Info -->
      <div class="content-container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">HOME</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              CONTACT US
            </li>
          </ol>
        </nav>

        <h1 class="page-title">Contact us</h1>

        <p class="page-description">
          Any questions or enquiry? Do not hesitate to contact us through our
          form below
        </p>
      </div>
      <section class="contact-form">
        <form id="contact-form" action="db/contact_us_insert.php" method="post" novalidate>
          <div class="form-group">
            <label for="full-name">Full Name *</label>
            <input
              type="text"
              id="full-name"
              name="full-name"
              required
              aria-required="true"
              aria-describedby="full-name-error"
            />
            <span id="full-name-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="email">Email *</label>
            <input
              type="email"
              id="email"
              name="email"
              required
              aria-required="true"
              aria-describedby="email-error"
            />
            <span id="email-error" class="error-message"></span>
          </div>
          <div class="form-group">
            <label for="enquiry">Enquiry *</label>
            <textarea
              id="enquiry"
              name="enquiry"
              rows="4"
              required
              aria-required="true"
              aria-describedby="enquiry-error"
            ></textarea>
            <span id="enquiry-error" class="error-message"></span>
          </div>
          <button type="submit">Submit</button>
        </form>
      </section>
    </main>

    <?php include "footer.php"; ?>

  </body>
  <script src="scripts/script.js"></script>
  <script src="scripts/contact-form.js"></script>
</html>
