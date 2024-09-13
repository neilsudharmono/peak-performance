document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("searchInput")
    .addEventListener("input", searchEvents);
});

// JavaScript function to search events
function searchEvents() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toLowerCase();
  table = document.getElementById("eventsTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows and hide those that don't match the search query
  for (i = 1; i < tr.length; i++) {
    // Start from i = 1 to skip the table header
    td = tr[i].getElementsByTagName("td");
    var found = false;
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
          found = true;
        }
      }
    }
    tr[i].style.display = found ? "" : "none";
  }
}

/*

document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("createEventForm")
    .addEventListener("submit", validateForm);
  document
    .getElementById("editEventForm")
    .addEventListener("submit", validateForm);
});

function validateForm(event) {
  event.preventDefault(); // Prevent form submission until validation is done

  var name = document.getElementById("eventName").value.trim();
  var date = document.getElementById("eventDate").value;
  var timeFrom = document.getElementById("eventTimeFrom").value;
  var timeTo = document.getElementById("eventTimeTo").value;
  var location = document.getElementById("eventLocation").value.trim();
  var category = document.getElementById("eventCategory").value;
  var description = document.getElementById("eventDescription").value.trim();

  // Check if any field is empty
  if (
    !name ||
    !date ||
    !timeFrom ||
    !timeTo ||
    !location ||
    !category ||
    !description
  ) {
    alert("All fields are mandatory!");
    return false;
  }

  // Validate if date is in the future
  var selectedDate = new Date(date);
  var today = new Date();
  today.setHours(0, 0, 0, 0); // Set current time to start of the day for comparison

  if (selectedDate < today) {
    alert("Event date must be a future date!");
    return false;
  }

  // Validate if 'Time From' is earlier than 'Time To'
  if (timeFrom >= timeTo) {
    alert("'Time From' should be earlier than 'Time To'!");
    return false;
  }

  // If everything is valid, submit the form
  event.target.submit();
}
  */
