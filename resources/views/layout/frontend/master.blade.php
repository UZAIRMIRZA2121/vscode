@include('layout.frontend.header')


    @yield('content')




@include('layout.frontend.footer')
  <!-- Modal -->
  <div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog"
  aria-labelledby="prescriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="prescriptionModalLabel">Prescription Form</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form action="{{ route('prescription.request') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <!-- Hidden input field for product ID -->
                  <input type="hidden" id="productIdInput" name="product_id">
                  <br>
                  <input type="file" name="img" id=""><br><br>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// JavaScript to set the product ID before submitting the form
$('#prescriptionModal').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget); // Button that triggered the modal
var productId = button.data('product-id'); // Extract info from data-* attributes
var modal = $(this);
modal.find('#productIdInput').val(productId); // Set the value of hidden input
});
</script>

<script>
    // Function to hide the alert after 5 seconds
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            var statusAlert = document.getElementById('status-alert');
            var verificationAlert = document.getElementById('verification-alert');
            var alertAlert = document.getElementById('alert');

            if (statusAlert) {
                statusAlert.style.display = 'none';
            }
            if (verificationAlert) {
                verificationAlert.style.display = 'none';
            }
            if (alertAlert) {
                alertAlert.style.display = 'none';
            }
        }, 3000);
    });
</script>