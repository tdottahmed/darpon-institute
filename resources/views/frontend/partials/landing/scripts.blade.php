<script>
  document.addEventListener('DOMContentLoaded', function() {
    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
      orderForm.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('This is a static demo. Order submission functionality is not connected.');
      });
    }
  });
</script>
