<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
	          <div class="modal-header">
	            <h5 class="modal-title" id="exampleModalLabel">Update post</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div> 
	          <form action="" method="POST">
	            <div class="modal-body">
	              <div class="form-group">
	                <label for="updateTitle" class="col-form-label">Title:</label>
	                <input type="text" class="form-control" name="title" id="updateTitle-">
	                <div class="form-group">
	                  <label for="updatePost" class="col-form-label">Description: </label>
	                  <textarea class="form-control" name="description" id="updatePost"></textarea>
	                  <div class="form-group">
	              	    <label for="updatePrice" class="col-form-label">Price: </label>
	                    <input type="text" class="form-control" name="price" id="updatePrice">
	                    
					  </div>
					  <div class="form-group">
	              	    <label for="updateImg" class="col-form-label">Bild-URL </label>
	                    <input type="text" class="form-control" name="img_url" id="updateImg">
	                    <input type="hidden" class="form-control" name="id">
	                  </div>
	                </div>
	            	<div class="modal-footer">
	              	  <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
	                  <input type="submit" name="updateBtn" value="Uppdatera" class="btn btn-success">
		            </div>
	              </div>
	            </div>
		      </form>
		    </div>
	      </div>
	</div>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script>
	  	$('#exampleModal').on('show.bs.modal', function (event) {
	    var button = $(event.relatedTarget); // Button that triggered the modal
	    var title = button.data('title'); // Extract info from data-* attributes
	    var description = button.data('description'); // Extract info from data-* attributes
		var price = button.data('price'); // Extract info from data-* attributes
		var img_url = button.data('img_url'); // Extract info from data-* attributes
	    var id = button.data('id'); // Extract info from data-* attributes
	   
	    var modal = $(this);
	    modal.find(".modal-body input[name='title']").val(title);
	    modal.find(".modal-body textarea[name='description']").val(description);
		modal.find(".modal-body input[name='price']").val(price);
		modal.find(".modal-body input[name='img_url']").val(img_url);
	    modal.find(".modal-body input[name='id']").val(id);
	  	});
	</script>
</body>
</html>