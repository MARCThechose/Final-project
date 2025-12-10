$(document).ready(function () {
  
  // We need to fetch the full description for the view/update modals, which is not in the table.
  // We'll make an AJAX call for that.
  function fetchInventoryDetails(id, callback) {
    $.ajax({
      url: 'inventory_get_details.php',
      type: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function(response) {
        callback(response);
      },
      error: function() {
        alert('Could not fetch item details.');
        callback(null);
      }
    });
  }

  $('.updateBtn').on('click', function () {
    var id = $(this).data('id');
    $tr = $(this).closest('tr');
    var data = $tr.children("td").map(function () {
      return $(this).text().trim();
    }).get();
    
    $('#updateId').val(id);
    $('#updateName').val(data[1]);
    $('#updateQuantity').val(data[2]);
    $('#updateOrigin').val(data[3]);
    $('#updateDateOfArrival').val(data[4]);

    fetchInventoryDetails(id, function(details) {
      if(details) {
        $('#updateDescription').val(details.description);
      }
      $('#updateModal').modal('show');
    });
  });

  $('.viewBtn').on('click', function () {
    var id = $(this).data('id');
    $tr = $(this).closest('tr');
    var data = $tr.children("td").map(function () {
      return $(this).text().trim();
    }).get();

    $('#viewName').text(data[1]);
    $('#viewQuantity').text(data[2]);
    $('#viewOrigin').text(data[3]);
    $('#viewDateOfArrival').text(data[4]);
    
    fetchInventoryDetails(id, function(details) {
      if(details) {
        $('#viewDescription').text(details.description);
      }
      $('#viewModal').modal('show');
    });
  });

  $('.deleteBtn').on('click', function () {
    var id = $(this).data('id');
    $('#deleteModal').modal('show');
    $('#deleteId').val(id);
  });
});