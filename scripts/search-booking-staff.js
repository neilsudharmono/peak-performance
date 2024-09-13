document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("searchInput")
    .addEventListener("input", searchByUserID);
});

// JavaScript function to search by UserID
function searchByUserID() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toLowerCase();
  table = document.getElementById("eventsTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows and hide those that don't match the search query
  for (i = 1; i < tr.length; i++) {
    // Only check the first column (UserID)
    td = tr[i].getElementsByTagName("td")[4]; // Assuming UserID is in the first column
    if (td) {
      txtValue = td.textContent || td.innerText;
      tr[i].style.display =
        txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
    }
  }
}
