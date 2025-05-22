@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<div class="page-content">

       
        <div class="row profile-body">
          <!-- left wrapper start -->
          
          <!-- left wrapper end -->
          <!-- middle wrapper start -->
          <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
             <div class="card">
              <div class="card-body">

			<h6 class="card-title">Add State   </h6>

			<form method="POST" action="{{ route('store.state') }}" class="forms-sample" enctype="multipart/form-data">
				@csrf
 

				<div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">State Name   </label>
					 <input type="text" name="state_name" class="form-control " > 
				</div>

                                        <div class="form-group mb-3">
                                            <label class="form-label">Main Thumbnail</label>
                                            <div class="custom-file-wrapper">
                                                <input type="file" name="property_thambnail" id="property_thambnail"
                                                    class="custom-file-input" onchange="mainThamUrl(this)">
                                                <label for="property_thambnail" class="custom-file-label">Choose
                                                    File</label>
                                                <span id="file-name">No file chosen</span>
                                            </div>
                                            <img src="" id="mainThmb">
                                        </div>
                                    
  <div class="mb-3">
 <label for="exampleInputEmail1" class="form-label">    </label>
  <img id="showImage" class="wd-80 rounded-circle" src="{{ url('upload/no_image.jpg') }}" alt="profile">
        </div>
				 
	 <button type="submit" class="btn btn-primary me-2">Save Changes </button>
			 
			</form>

              </div>
            </div>

            </div>
          </div>
        
        </div>

			</div>
 
 <script type="text/javascript">
        function mainThamUrl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mainThmb').attr('src', e.target.result).width(80).height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection