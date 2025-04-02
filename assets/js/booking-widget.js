jQuery(document).ready(function ($) {
  // Initialize Flatpickr on the date input
  $("#booking-date").flatpickr({
    dateFormat: "Y-m-d",
    minDate: "today",
  });

  // Handle button click
  $("#check-packages").on("click", function () {
    let selectedDate = $("#booking-date").val();

    if (!selectedDate) {
      alert("Please select a date first.");
      return;
    }

    $("#packages-list").html("<p>Loading packages...</p>");

    $.ajax({
      url: booking_ajax.ajaxurl,
      type: "POST",
      data: {
        action: "get_packages",
        date: selectedDate,
      },
      success: function (response) {
        if (response.success) {
          let packagesHtml = "<ul>";
          response.data.forEach((pkg) => {
            packagesHtml += `<li>${pkg.name}</li>`;
          });
          packagesHtml += "</ul>";
          $("#packages-list").html(packagesHtml);
        } else {
          $("#packages-list").html("<p>No packages available.</p>");
        }
      },
    });
  });
});
