<footer class="text-muted" style="background: linear-gradient(135deg,#1e5799,#035b79 0,#498ca3); height: 200px;">
      <nav class="navbar navbar-dark box-shadow" style="color: white;">
        <div class="container d-flex justify-content-between pt-4">
          <div>
            <p><a href="index.php">Admin</a></p>
            <p><a href="products.php" >Hantera Produkter</a></p>
            <p><a href="users.php" >Hantera Användare</a></p>
            <p><a href="orders.php">Hantera Ordrar</a></p>
            <p><a href="../index.php">Snusshoppen</a></p>
           
          </div>
          <div>
            <p>Besöksadress</p>
            <p>Kontorsgatan 12</p>
            <p>118 45 Stockholm</p>
            <p>Sverige</p>
          </div>
          <div>
            <p>Kontakta oss</p>
            <p>kontakt@snusshopen.se</p>
            <p>+46 707 836 946</p>
            <p>Chatta med oss här</p>
          </div>
        </div>
        </nav>
    </footer>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript">
    $('.update-cart-form input[name="quantity"]').on('change', function(){
      $(this).parent().submit();
    });

  </script>
  
</body>
</html>